<?php

namespace App\Agents;

use NeuronAI\Agent;
use NeuronAI\Providers\OpenAI\OpenAI;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolProperty;

class SupportAgent extends Agent
{
    public function provider(): AIProviderInterface
    {
        return new OpenAI(
            key: $_ENV['OPENAI_API_KEY'] ?? 'your-openai-api-key',
            model: $_ENV['AI_MODEL'] ?? 'gpt-4'
        );
    }

    public function instructions(): string
    {
        return "You are an AI Agent specialized in providing helpful responses.";
    }

    public function tools(): array
    {
        return [
            Tool::make(
                'exampleTool',
                'An example tool that echoes back input.'
            )
            ->addProperty(new ToolProperty(
                name: 'input',
                type: 'string',
                description: 'The input to echo back.',
                required: true
            ))
            ->setCallable(function (string $input) {
                return "You said: $input";
            }),
        ];
    }
}
