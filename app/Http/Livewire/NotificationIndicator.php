<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class NotificationIndicator extends Component
{
    public $hasNotification;

    protected $listeners = [
        'NotificationMarkedAsRead' => 'setHasNotification',
    ];

    public function render(): View
    {
        $this->hasNotification = $this->setHasNotification(
            auth()->user()->unreadNotifications()->count(),
        );

        return view('livewire.notification_indicator', [
            'hasNotification' => $this->hasNotification,
        ]);
    }

    public function setHasNotification(int $count): bool
    {
        return $count > 0;
    }
}
