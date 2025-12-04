<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);

        $user = User::where('email', $request->email)->first();

        $existingRequest = PasswordResetRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (! $existingRequest) {
            PasswordResetRequest::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        return back()->with(['status' => 'Permintaan reset password telah dikirim ke admin. Admin akan segera menghubungi Anda.']);
    }
}
