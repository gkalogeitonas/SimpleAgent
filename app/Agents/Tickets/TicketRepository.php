<?php

namespace App\Agents\Tickets;

class TicketRepository
{
    private array $tickets = [
        ['id' => 1, 'subject' => 'Login issue', 'status' => 'open'],
        ['id' => 2, 'subject' => 'Payment failed', 'status' => 'closed'],
        ['id' => 3, 'subject' => 'Dark mode request', 'status' => 'open'],
        ['id' => 4, 'subject' => 'Billing bug', 'status' => 'closed'],
    ];

    public function getOpenTickets(): string
    {
        $openTickets = array_values(array_filter($this->tickets, fn($t) => $t['status'] === 'open'));
        return json_encode($openTickets, JSON_PRETTY_PRINT);
    }

    public function getClosedTickets(): string
    {
        $closedTickets = array_values(array_filter($this->tickets, fn($t) => $t['status'] === 'closed'));
        return json_encode($closedTickets, JSON_PRETTY_PRINT);
    }
}