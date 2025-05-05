<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;
use App\Enums\EmployeeRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }


    public function showLoginForm()
    {
        return view('auth.admin_login');
    }


    public function login(Request $request)
    {

        $request->validate([
            'email'   => 'required|email|exists:admins',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::withoutGlobalScopes()->whereEmail($request->email)->first();

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $request->session()->put('auth_id', Auth::guard('admin')->id());
            $request->session()->save();

            return response()->json(['redirection_url' => auth('admin')->user()->role == EmployeeRole::super_admin->value ? route('dashboard.index') : route('dashboard.orders.index')]);
        }
        else
        {
            throw ValidationException::withMessages([
                "password" => __("The password is incorrect"),
            ]);
        }

    }


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login-form');
    }
}
