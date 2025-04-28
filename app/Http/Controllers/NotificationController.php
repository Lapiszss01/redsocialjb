<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(User $user)
    {
        $notifications = $user->notifications()->get();

        return view('notifications.index', compact('notifications'));
    }

}
