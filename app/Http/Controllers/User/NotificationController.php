<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function MarkAsRead($id){
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['success' => true]);

    }
    // End Method 

    public function NotificationsDelete($id){

        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        return back()->with('success','Notification deleted');
    }
    // End Method 


} 
