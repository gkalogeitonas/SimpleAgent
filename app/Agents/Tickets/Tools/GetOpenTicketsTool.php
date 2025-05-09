<?php

namespace App\Agents\Tickets\Tools;

use NeuronAI\Tools\Tool;
use App\Agents\Tickets\TicketRepository;

class GetOpenTicketsTool
{
    public static function register(): Tool
    {
        $repo = new TicketRepository();
        
        return Tool::make(
            'getOpenTickets',
            'Returns a list of open support tickets.'
        )->setCallable(function () use ($repo) {
            return $repo->getOpenTickets();
        });
    }
}