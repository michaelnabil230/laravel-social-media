<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\UpdatePasswordRequest;
use App\Traits\SendsAlerts;

class PasswordController
{
    use SendsAlerts;

    public function __invoke(UpdatePasswordRequest $request)
    {
        auth()->user()->update(['password' => $request->password]);

        $this->success('Password updated');

        return to_route('settings.profile');
    }
}
