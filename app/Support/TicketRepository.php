<?php

namespace App\Support;

class TicketRepository
{
    private array $tickets = [
        ['id' => 1, 'subject' => 'Login issue', 'status' => 'open'],
        ['id' => 2, 'subject' => 'Payment failed', 'status' => 'closed'],
        ['id' => 3, 'subject' => 'Dark mode request', 'status' => 'open'],
        ['id' => 4, 'subject' => 'Billing bug', 'status' => 'closed'],
    ];

    public function getOpenTickets(): array
    {
        return array_values(array_filter($this->tickets, fn($t) => $t['status'] === 'open'));
    }

    public function getClosedTickets(): array
    {
        return array_values(array_filter($this->tickets, fn($t) => $t['status'] === 'closed'));
    }
}
