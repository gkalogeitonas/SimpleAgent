<?php

namespace App\Agents\SmartHome;

use NeuronAI\Agent;
use NeuronAI\Providers\OpenAI\OpenAI;
use NeuronAI\Providers\AIProviderInterface;
use App\Agents\SmartHome\Tools\TurnOnLightTool;
use App\Agents\SmartHome\Tools\TurnOffLightTool;
use App\Agents\SmartHome\Tools\TurnOnAirConditionerTool;
use App\Agents\SmartHome\Tools\TurnOffAirConditionerTool;

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
        return [
            TurnOnLightTool::register(),
            TurnOffLightTool::register(),
            TurnOnAirConditionerTool::register(),
            TurnOffAirConditionerTool::register(),
        ];
    }
    
    public static function make(...$args): static
    {
        return new static();
    }
}