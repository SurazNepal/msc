<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $user = Auth::user();

       // Redirect based on Spatie roles
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->hasRole('employee')) {
            return redirect()->intended(route('employee.dashboard'));
        }

        // Default redirect for regular users (defined in fortify.php config)
        return redirect()->intended(config('fortify.home'));
    }
}
