<?php

namespace App\Agents\Tickets;

use NeuronAI\Agent;
use NeuronAI\Providers\OpenAI\OpenAI;
use NeuronAI\Providers\AIProviderInterface;
use App\Agents\Tickets\Tools\GetOpenTicketsTool;
use App\Agents\Tickets\Tools\GetClosedTicketsTool;

class TicketsAgent extends Agent
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
        return "You are a helpful support assistant. You can list open or closed support tickets.";
    }

    public function tools(): array
    {
        return [
            GetOpenTicketsTool::register(),
            GetClosedTicketsTool::register(),
        ];
    }
    
    public static function make(...$args): static
    {
        return new static();
    }
}