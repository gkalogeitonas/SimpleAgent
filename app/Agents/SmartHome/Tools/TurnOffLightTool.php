<?php

namespace App\Agents\SmartHome\Tools;

use NeuronAI\Tools\Tool;
use App\Agents\SmartHome\DeviceController;

class TurnOffLightTool
{
    public static function register(): Tool
    {
        $controller = new DeviceController();
        
        return Tool::make(
            'turnOffLight',
            'Turns off the light.'
        )->setCallable(function () use ($controller) {
            return $controller->turnOffLight();
        });
    }
}