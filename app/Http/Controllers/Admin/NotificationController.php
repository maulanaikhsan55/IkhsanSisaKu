<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\User;
use App\Models\KarangTaruna;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get all notification counts for admin dashboard
     */
    public function getCounts()
    {
        $counts = [
            'password_resets' => PasswordResetRequest::where('status', 'pending')->count(),
            'pending_users' => User::where('status_akun', 'pending')->count(),
            'inactive_karang_taruna' => KarangTaruna::where('status', 'inactive')->count(),
            'total' => 0
        ];

        $counts['total'] = $counts['password_resets'] + $counts['pending_users'] + $counts['inactive_karang_taruna'];

        return response()->json($counts);
    }

    /**
     * Get recent notifications for toast display
     */
    public function getRecent(Request $request)
    {
        $notifications = [];

        // Password reset requests
        $passwordResets = PasswordResetRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        foreach ($passwordResets as $reset) {
            $notifications[] = [
                'id' => 'password_reset_' . $reset->id,
                'type' => 'password_reset',
                'title' => 'Permintaan Reset Password',
                'message' => $reset->user->name . ' meminta reset password',
                'time' => $reset->created_at->diffForHumans(),
                'url' => route('admin.password-reset.index'),
                'icon' => 'fa-key'
            ];
        }

        // Inactive users (nonaktif status)
        $inactiveUsers = User::where('status_akun', 'nonaktif')
            ->latest()
            ->take(3)
            ->get();

        foreach ($inactiveUsers as $user) {
            $notifications[] = [
                'id' => 'inactive_user_' . $user->id,
                'type' => 'inactive_user',
                'title' => 'User Status Nonaktif',
                'message' => $user->name . ' status akun nonaktif',
                'time' => $user->created_at->diffForHumans(),
                'url' => route('admin.master-data.index'),
                'icon' => 'fa-user-times'
            ];
        }

        // Inactive karang taruna
        $inactiveKT = KarangTaruna::where('status', 'inactive')
            ->latest()
            ->take(3)
            ->get();

        foreach ($inactiveKT as $kt) {
            $notifications[] = [
                'id' => 'inactive_kt_' . $kt->id,
                'type' => 'inactive_karang_taruna',
                'title' => 'Karang Taruna Tidak Aktif',
                'message' => $kt->nama . ' status tidak aktif',
                'time' => $kt->updated_at->diffForHumans(),
                'url' => route('admin.karang-taruna.index'),
                'icon' => 'fa-building'
            ];
        }

        // Sort by time (most recent first)
        usort($notifications, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return response()->json([
            'notifications' => array_slice($notifications, 0, 5), // Limit to 5 most recent
            'total_count' => count($notifications)
        ]);
    }
}
