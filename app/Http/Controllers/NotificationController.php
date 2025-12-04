<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated user only
     * Each user only sees their own notifications
     */
    public function index()
    {
        // Ensure we only get notifications for the currently authenticated user
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read - only for the authenticated user's notifications
     * Prevents users from marking other users' notifications as read
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        // Ensure the notification belongs to the authenticated user
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read - only for the authenticated user
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $unreadCount = $user->unreadNotifications->count();
        
        if ($unreadCount > 0) {
            $user->unreadNotifications->markAsRead();
            return back()->with('success', 'Đã đánh dấu tất cả thông báo là đã đọc.');
        }

        return back()->with('info', 'Không có thông báo nào cần đánh dấu.');
    }

    /**
     * Get unread notifications count (AJAX)
     * Returns count only for the authenticated user
     */
    public function unreadCount()
    {
        try {
            $user = Auth::user();
            $count = $user->unreadNotifications->count();
        } catch (\Exception $e) {
            $count = 0;
        }
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get latest notifications (AJAX)
     * Returns only notifications for the authenticated user
     */
    public function latest()
    {
        try {
            $user = Auth::user();
            $notifications = $user->notifications()->take(5)->get();
        } catch (\Exception $e) {
            $notifications = collect();
        }
        
        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => class_basename($notification->type),
                    'data' => $notification->data,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            }),
            'count' => $notifications->count(),
        ]);
    }
}
