<?php

namespace App\Agents;

use NeuronAI\Agent;
use NeuronAI\Providers\OpenAI\OpenAI;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Tools\Tool;
use App\Support\TicketRepository;

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
        return "You are a helpful support assistant. You can list open or closed support tickets.";
    }

    public function tools(): array
    {
        $repo = new TicketRepository();

        return [
            Tool::make(
                'getOpenTickets',
                'Returns a list of open support tickets.'
            )
            ->setCallable(function () use ($repo) {
                return $repo->getOpenTickets();
            }),

            Tool::make(
                'getClosedTickets',
                'Returns a list of closed support tickets.'
            )
            ->setCallable(function () use ($repo) {
                return $repo->getClosedTickets();
            }),
        ];
    }
}
