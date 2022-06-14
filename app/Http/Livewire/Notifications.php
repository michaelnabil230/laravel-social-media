<?php

namespace App\Http\Livewire;

use App\Policies\NotificationPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $notificationCount = 0;

    public function render(): View
    {
        return view('livewire.notifications', [
            'notifications' => auth()->user()->unreadNotifications()->paginate(),
        ]);
    }

    public function mount(): void
    {
        abort_if(auth()->guest(), 403);

        $this->notificationCount = auth()->user()->unreadNotifications()->count();
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = DatabaseNotification::findOrFail($notificationId);

        $this->authorize(NotificationPolicy::MARK_AS_READ, $notification);

        $notification->markAsRead();

        $this->notificationCount--;

        $this->emit('NotificationMarkedAsRead', $this->notificationCount);
    }
}
