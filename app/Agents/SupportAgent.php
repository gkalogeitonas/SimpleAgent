<?php

namespace App\Agents;

use App\Framework\Agent;
use App\Support\TicketRepository;

class SupportAgent extends Agent
{
    private TicketRepository $repository;
    
    public function __construct()
    {
        $this->repository = new TicketRepository();
        parent::__construct();
    }
    
    public function instructions(): string
    {
        return "You are a helpful support assistant. You can list open or closed support tickets.";
    }
    
    protected function setupTools(): void
    {
        $this->addTool(
            'getOpenTickets',
            'Returns a list of open support tickets.',
            fn() => $this->repository->getOpenTickets(),
            [
                'tickets' => [
                    'type' => 'array',
                    'description' => 'List of open tickets',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'subject' => ['type' => 'string'],
                            'status' => ['type' => 'string']
                        ],
                        'required' => ['id', 'subject', 'status']
                    ]
                ]
            ],
            []
        );
        
        $this->addTool(
            'getClosedTickets',
            'Returns a list of closed support tickets.',
            fn() => $this->repository->getClosedTickets(),
            [
                'tickets' => [
                    'type' => 'array',
                    'description' => 'List of closed tickets',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'subject' => ['type' => 'string'],
                            'status' => ['type' => 'string']
                        ],
                        'required' => ['id', 'subject', 'status']
                    ]
                ]
            ],
            []
        );
    }
}
