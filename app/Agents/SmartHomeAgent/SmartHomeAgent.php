<?php

namespace App\Agents\SmartHomeAgent;

use NeuronAI\Agent;
use NeuronAI\Providers\OpenAI\OpenAI;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Tools\Tool;
use App\Support\DeviceController;

class SmartHomeAgent extends Agent
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
        return "You are a smart home assistant. You can control lights and air conditioning.";
    }

    public function tools(): array
    {
        $controller = new DeviceController();

        return [
            Tool::make(
                'turnOnLight',
                'Turns on the light.'
            )->setCallable(fn() => $controller->turnOnLight()),

            Tool::make(
                'turnOffLight',
                'Turns off the light.'
            )->setCallable(fn() => $controller->turnOffLight()),

            Tool::make(
                'turnOnAirConditioner',
                'Turns on the air conditioner.'
            )->setCallable(fn() => $controller->turnOnAirConditioner()),

            Tool::make(
                'turnOffAirConditioner',
                'Turns off the air conditioner.'
            )->setCallable(fn() => $controller->turnOffAirConditioner()),
        ];
    }
}