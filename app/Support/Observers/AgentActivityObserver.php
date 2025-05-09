<?php

namespace App\Support\Observers;

use App\Support\Logging\LoggerFactory;
use NeuronAI\Events\ChatStarted;
use NeuronAI\Events\ChatCompleted;

class AgentActivityObserver implements \SplObserver
{
    private $logger;
    
    public function __construct()
    {
        $this->logger = LoggerFactory::getDefaultLogger();
    }
    
    public function update(\SplSubject $subject, ?string $event = null, $data = null): void
    {
        switch ($event) {
            case 'chat-started':
                // This captures the initial prompt
                $this->logger->info("LLM Chat Started", [
                    'prompt' => $data->message->getContent(),
                    // 'model' => $subject->provider()->getModel() // This line might cause an error if provider() or getModel() is not accessible or does not exist
                ]);
                break;
                
            case 'chat-completed': 
                // This captures the LLM response
                $this->logger->info("LLM Chat Completed", [
                    'response' => $data->response->getContent(),
                    'duration' => $data->duration
                ]);
                break;
                
            case 'tool-calling':
                $this->logger->info("Tool Being Called", [
                    'tool' => $data->tool->getName()
                ]);
                break;
                
            case 'tool-called':
                $this->logger->info("Tool Executed", [
                    'tool' => $data->tool->getName(),
                    'result' => $data->tool->getResult()
                ]);
                break;
                
            default:
                $this->logger->debug("Agent Event: $event", ['data' => $data]);
                break;
        }
    }
}