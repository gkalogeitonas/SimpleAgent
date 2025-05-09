<?php

namespace App\Support\Observers;

use App\Support\Logging\LoggerFactory;
// It's good practice to import specific event classes if they exist and are used for type hinting or data structure access,
// but for now, we'll rely on the event names as strings and the data structure observed in logs.

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
            case 'inference-start': // Changed from 'chat-started'
                $promptPayload = $data->message ?? null;
                $this->logger->info("LLM Prompt Sent (inference-start)", [
                    'prompt_payload' => $promptPayload, // Log the entire message payload
                    // 'model' => $subject->provider()->getModel() // Uncomment if provider() and getModel() are accessible and stable
                ]);
                break;
                
            case 'inference-stop': // Changed from 'chat-completed'
                $responseData = $data->response ?? null;
                $this->logger->info("LLM Response Received (inference-stop)", [
                    'response_payload' => $responseData, // Logs the entire response structure
                    'duration' => $data->duration ?? null
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
                // This will continue to log other events like chat-start, chat-stop, message-saving, etc.
                $this->logger->debug("Agent Event: $event", ['data' => $data]);
                break;
        }
    }
}