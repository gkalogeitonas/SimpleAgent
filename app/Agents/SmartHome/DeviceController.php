<?php

namespace App\Agents\SmartHome;

use App\Support\Logging\LoggerFactory;



class DeviceController
{

    protected $logger;
    public function __construct()
    {
        $this->logger = LoggerFactory::create('DeviceController');
    }


    public function turnOnLight(): string
    {
        $this->log("Turning on the light.");
        return "The light has been turned on!!!";
    }

    public function turnOffLight(): string
    {
        $this->log("Turning off the light.");
        return "The light has been turned off.";
    }

    public function turnOnAirConditioner(): string
    {
        $this->log("Turning on the air conditioner.");
        return "The air conditioner has been turned on.";
    }

    public function turnOffAirConditioner(): string
    {
        $this->log("Turning off the air conditioner.");
        return "The air conditioner has been turned off.";
    }


    private function log(string $message): void
    {
        $this->logger->info($message);
    }
}