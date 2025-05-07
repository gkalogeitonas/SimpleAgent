<?php

namespace App\Framework;

use OpenAI;
use OpenAI\Client;

abstract class Agent
{
    protected Client $client;
    protected array $tools = [];
    protected array $messages = [];
    
    public function __construct()
    {
        $this->client = OpenAI::client($_ENV['OPENAI_API_KEY'] ?? 'your-openai-api-key');
        $this->setupTools();
        
        // Add system message with instructions
        $this->messages[] = [
            'role' => 'system',
            'content' => $this->instructions()
        ];
    }
    
    abstract public function instructions(): string;
    
    abstract protected function setupTools(): void;
    
    public static function make(): self
    {
        return new static();
    }
    
    public function chat(string $message): string
    {
        // Add the user message
        $this->messages[] = [
            'role' => 'user',
            'content' => $message
        ];
        
        // Prepare tools for OpenAI format
        $openAITools = array_map(function($tool) {
            return [
                'type' => 'function',
                'function' => [
                    'name' => $tool['name'],
                    'description' => $tool['description'],
                    'parameters' => [
                        'type' => 'object',
                        'properties' => $tool['properties'] ?? (object)[],
                        'required' => $tool['required'] ?? []
                    ]
                ]
            ];
        }, $this->tools);
        
        $response = $this->client->chat()->create([
            'model' => $_ENV['AI_MODEL'] ?? 'gpt-4-turbo',
            'messages' => $this->messages,
            'tools' => $openAITools,
            'tool_choice' => 'auto',
        ]);
        
        $responseMessage = $response->choices[0]->message;
        $this->messages[] = [
            'role' => 'assistant',
            'content' => $responseMessage->content,
            'tool_calls' => $responseMessage->toolCalls ?? null,
        ];
        
        // Process tool calls if any
        if (!empty($responseMessage->toolCalls)) {
            foreach ($responseMessage->toolCalls as $toolCall) {
                $toolName = $toolCall->function->name;
                
                // Find the tool and execute its callable
                foreach ($this->tools as $tool) {
                    if ($tool['name'] === $toolName) {
                        $result = call_user_func($tool['callable']);
                        
                        // Add the tool response to messages
                        $this->messages[] = [
                            'role' => 'tool',
                            'tool_call_id' => $toolCall->id,
                            'name' => $toolName,
                            'content' => json_encode($result),
                        ];
                    }
                }
            }
            
            // Get the final response after tool execution
            $response = $this->client->chat()->create([
                'model' => $_ENV['AI_MODEL'] ?? 'gpt-4-turbo',
                'messages' => $this->messages,
            ]);
            
            return $response->choices[0]->message->content;
        }
        
        return $responseMessage->content;
    }
    
    protected function addTool(string $name, string $description, callable $callable, array $properties = [], array $required = []): void
    {
        $this->tools[] = [
            'name' => $name,
            'description' => $description,
            'callable' => $callable,
            'properties' => $properties,
            'required' => $required
        ];
    }
}
