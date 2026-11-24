<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdatePreferenceRequest;

class AdminController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function index()
    {
        // return redirect()->action([PostController::class, 'index']);
        return view('admin.index');
    }

    public function profile()
    {
        return view('admin.users.profile');
    }

    public function preferences()
    {
        return view('admin.users.preferences');
    }

    public function changePassword()
    {
        return view('admin.users.change_password');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $credentials = ['email' => auth()->user()->email, 'password' => $request->current_password];
        if (Auth::attempt($credentials)) {
            auth()->user()->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->route('admin.change_password')->with(['success-message' => "Password updated successfully."]);
        }
        return back()->with(['error-message' => "Incorrect current password"]);
    }

    public function authenticate(LoginRequest $request)
    {
        $remember = false;
        $credentials = $request->only(['email', 'password']);
        if ($request->input('remember_me') != null) {
            $remember = true;
        }
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('admin_dashboard');
        }
        return back()->with(['error-message' => "Invalid email/password"]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->except('_token'));
        return redirect()->route('admin_profile')->with(['success-message' => "Profile updated successfully."]);
    }

    public function updatePreferences(UpdatePreferenceRequest $request)
    {
        auth()->user()->preferences->update($request->except('_token'));
        return redirect()->route('admin_preferences')->with(['success-message' => "Preferences updated successfully."]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
