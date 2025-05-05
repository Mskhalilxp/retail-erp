<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $perLoad = 10;
    public function markAsRead($id)
    {
        $notification = auth('admin')->user()->notifications->where('id', $id)->first();
        $notification->markAsRead();
        return redirect($notification->data['url']);
    }

    public function markAllAsRead()
    {
        auth('admin')->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function loadMore($type, $next)
    {
        if ($type == 'unread-load-more')
            $notifications = auth('admin')->user()->unreadNotifications();
        else
            $notifications = auth('admin')->user()->notifications();

        $isMoreExist = $notifications->count() - ($next + $this->perLoad) > 0;

        $notifications = $notifications->skip($next)->take($this->perLoad)->get()->map(function($notification){
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'],
                'description' => $notification->data['description'],
                'created_at' => $notification->created_at->diffForHumans(),
            ];
        });


        return response()->json([
            'data' => $notifications,
            'isMoreExist' =>  $isMoreExist,
        ]);
    }

    public function saveToken(Request $request)
    {
        auth('admin')->user()->update(['device_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }
}
