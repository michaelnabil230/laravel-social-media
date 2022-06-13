<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests\UpdatePasswordRequest;
use App\Traits\SendsAlerts;
use Illuminate\Support\Facades\Auth;

class PasswordController
{
    use SendsAlerts;

    public function __invoke(UpdatePasswordRequest $request)
    {
        Auth::user()->update(['password' => $request->password]);

        $this->success('Password updated');

        return to_route('settings.profile');
    }
}
