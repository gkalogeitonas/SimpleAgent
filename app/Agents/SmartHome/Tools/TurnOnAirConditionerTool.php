<?php

namespace App\Agents\SmartHome\Tools;

use NeuronAI\Tools\Tool;
use App\Agents\SmartHome\DeviceController;

class TurnOnAirConditionerTool
{
    public static function register(): Tool
    {
        $controller = new DeviceController();
        
        return Tool::make(
            'turnOnAirConditioner',
            'Turns on the air conditioner.'
        )->setCallable(function () use ($controller) {
            return $controller->turnOnAirConditioner();
        });
    }
}