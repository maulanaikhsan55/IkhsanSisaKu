<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function index()
    {
        $requests = PasswordResetRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(5);

        $pendingCount = PasswordResetRequest::where('status', 'pending')->count();
        $resolvedCount = PasswordResetRequest::where('status', 'resolved')->count();

        return view('admin.password-reset.index', compact('requests', 'pendingCount', 'resolvedCount'));
    }

    public function reset(PasswordResetRequest $passwordResetRequest)
    {
        if ($passwordResetRequest->status === 'resolved') {
            return back()->with('error', 'Request ini sudah diproses sebelumnya.');
        }

        $newPassword = Str::random(10).random_int(100, 999).'!';

        DB::table('users')->where('id', $passwordResetRequest->user_id)->update([
            'password' => bcrypt($newPassword),
        ]);

        $passwordResetRequest->update([
            'status' => 'resolved',
            'notes' => $newPassword,
        ]);

        return back()->with('success', 'Password telah direset. Password temporary: '.$newPassword.' (silakan berikan ke user)');
    }

    public function history()
    {
        $requests = PasswordResetRequest::with('user')
            ->where('status', 'resolved')
            ->latest()
            ->paginate(5);

        return view('admin.password-reset.history', compact('requests'));
    }

    public function getPendingCount()
    {
        $count = PasswordResetRequest::where('status', 'pending')->count();
        return response()->json(['count' => $count]);
    }
}
