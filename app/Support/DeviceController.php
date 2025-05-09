<?php

namespace App\Support;

class DeviceController
{
    public function turnOnLight(): string
    {
        return "The light has been turned on!!!";
    }

    public function turnOffLight(): string
    {
        return "The light has been turned off.";
    }

    public function turnOnAirConditioner(): string
    {
        return "The air conditioner has been turned on.";
    }

    public function turnOffAirConditioner(): string
    {
        return "The air conditioner has been turned off.";
    }
}