<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = Auth::id();

        $notifications = UserNotification::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(15)
            ->get(['id', 'title', 'message', 'read_at', 'created_at']);

        $unreadCount = UserNotification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success'      => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markRead(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);

        $query = UserNotification::where('user_id', Auth::id())->whereNull('read_at');

        if (! empty($ids)) {
            $query->whereIn('id', $ids);
        }

        $query->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
