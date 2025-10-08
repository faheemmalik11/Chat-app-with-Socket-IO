<?php

namespace App\Http\Controllers;

use App\Events\SendPrivateMessage;
use App\Models\UserChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function getMessages(){
        $messages = DB::table('user_chats')
        ->where(function ($query) {
            $query->where('sender_id', '=', request('id')) // First condition
                  ->where('receiver_id', '=', auth()->user()->id); // Second condition
        })
        ->orWhere(function ($query) {
            $query->where('sender_id', '=', auth()->user()->id)
            ->where('receiver_id', '=', request('id')) // First condition
                  ; // Fourth condition
        })
        ->orderBy('created_at', 'asc')
        ->get();
    
        return response()->json([
            "messages" => $messages,
        ]);
    }
    public function sendMessage(){
        $message = request('message');
        $user = request('user_id');
        $data = ["message"=>$message, "recepientUserId"=>$user, "senderUserId"=>auth()->user()->id,];
        broadcast(new SendPrivateMessage($data));
        UserChat::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => request('user_id'),
            'message' => $message,
        ]);
        return response()->json([
            'code'=>200,
            'data' => [
                'message'=> 'Message event triggered',
                'user'=> $user
            ]
           ]);
    }


}
