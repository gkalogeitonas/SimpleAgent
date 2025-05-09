<?php

namespace App\Agents\SmartHome\Tools;

use NeuronAI\Tools\Tool;
use App\Agents\SmartHome\DeviceController;

class TurnOffAirConditionerTool
{
    public static function register(): Tool
    {
        $controller = new DeviceController();
        
        return Tool::make(
            'turnOffAirConditioner',
            'Turns off the air conditioner.'
        )->setCallable(function () use ($controller) {
            return $controller->turnOffAirConditioner();
        });
    }
}