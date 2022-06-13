<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkNotificationsController
{
    public function __invoke(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return to_route('notifications');
    }
}
