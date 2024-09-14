<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function ShowChat()
    {
        $users = $this->getUserList();
        if (!Auth::check()) {
            return view('user.login');
        }
        return view('user.chat.chat', [
            'users' => $users,
        ]);
    }

  
    public function getUserList()
    {
        $userIds = Message::where('sender_id', Auth::user()->user_id)
                         ->orWhere('receiver_id', Auth::user()->user_id)
                         ->pluck('sender_id')
                         ->merge(Message::where('receiver_id', Auth::user()->user_id)
                                       ->pluck('receiver_id'))
                         ->unique();

        // Lấy thông tin của các người dùng từ danh sách user_id
        $users = User::whereIn('user_id', $userIds)->get();
        // dd($users);
        return $users;
    
    }

    public function getMessages($userId)
    {
        $messages = Message::where('sender_id', Auth::user()->user_id)
                           ->where('receiver_id', $userId)
                           ->orWhere('sender_id', $userId)
                           ->where('receiver_id', Auth::user()->user_id)
                           ->get();
        return response()->json($messages);
    }

   public function sendMessage(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|integer',
        'message' => 'required|string',
    ]);

    $message = new Message();
    $message->sender_id = Auth::user()->user_id;
    $message->receiver_id = $request->receiver_id;
    $message->message = $request->message;
    $message->save();

    // Gửi sự kiện thời gian thực
    Broadcast::event(new MessageSent($message));

    return response()->json(['message' => 'Message sent successfully'], 200);
}

}