<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);


        if (!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember_me')))
            throw ValidationException::withMessages([
                "password" => __('These credentials do not match our records.'),
            ]);

    }


    public function logout(): RedirectResponse
    {
        cache()->flush();
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
