<?php

namespace App\Traits;

trait SendsAlerts
{
    protected function success(string $message = null)
    {
        $this->sendAlert('success', $message);
    }

    protected function error(string $message)
    {
        $this->sendAlert('error', $message);
    }

    private function sendAlert(string $type, string $message)
    {
        session()->flash($type, $message);
    }
}
