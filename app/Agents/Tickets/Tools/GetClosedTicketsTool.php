<?php

namespace App\Agents\Tickets\Tools;

use NeuronAI\Tools\Tool;
use App\Agents\Tickets\TicketRepository;

class GetClosedTicketsTool
{
    public static function register(): Tool
    {
        $repo = new TicketRepository();
        
        return Tool::make(
            'getClosedTickets',
            'Returns a list of closed support tickets.'
        )->setCallable(function () use ($repo) {
            return $repo->getClosedTickets();
        });
    }
}