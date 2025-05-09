<?php

namespace App\Agents\SmartHome\Tools;

use NeuronAI\Tools\Tool;
use App\Agents\SmartHome\DeviceController;

class TurnOnLightTool
{
    public static function register(): Tool
    {
        $controller = new DeviceController();
        
        return Tool::make(
            'turnOnLight',
            'Turns on the light.'
        )->setCallable(function () use ($controller) {
            return $controller->turnOnLight();
        });
    }
}