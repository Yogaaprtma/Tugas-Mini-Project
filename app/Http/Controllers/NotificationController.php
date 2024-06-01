<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Posting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function notif(Request $request)
    {
        $tab = $request->get('tab', 'all');
        $currentUser = Auth::user();

        // Retrieve all notifications with posting
        $notifications = $currentUser->notifications()->with(['posting', 'sender'])->latest()->paginate(10);
        // dd($notifications[1]->posting);

        // Retrieve notifications of type 'comment'
        $commentsNotifications = $currentUser->notifications()
            ->where('type', 'comment')
            ->with(['posting', 'sender'])
            ->latest()
            ->paginate(10, ['*'], 'comments_page');

        // Retrieve notifications of type 'like'
        $likesNotifications = $currentUser->notifications()
            ->where('type', 'like')
            ->with(['posting', 'sender'])
            ->latest()
            ->paginate(10, ['*'], 'likes_page');

        return view('dashboard.notifikasi.notifikasi', compact('notifications', 'commentsNotifications', 'likesNotifications', 'tab'));
    }
}