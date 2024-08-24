<?php

namespace App\Http\Controllers;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Requests\LoginRequest;

class LoginController extends AuthenticatedSessionController
{
    /**
     * Show login page
     * 
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Submits the login forms and creates an access_token for the API
     * 
     * @param  \Laravel\Fortify\Http\Requests\LoginRequest  $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        $cookie = null;
        $response = parent::store($request);

        if (auth()->check()) {
            $token = auth()->user()->createToken('access-token')->plainTextToken;
            $cookie = cookie('access_token', $token, 60);

            return $response->withCookie($cookie);
        }

        return $response;
    }
}
