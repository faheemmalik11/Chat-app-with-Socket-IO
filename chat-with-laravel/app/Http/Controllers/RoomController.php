<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Events\Typing;
use App\Models\Channel;
use App\Models\Chat;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Channel $channel){
        $members = $channel->users;
        $MessagesHistory = Chat::oldest('created_at')->get();
        return view('room', compact('members','channel','MessagesHistory'));
    }

    public function sendMessage(){
       $message = request('message');
       $channel = Channel::findorFail(request('channel'));
       $data = ["message"=>$message, "channel"=>$channel, "user"=>auth()->user()];
       broadcast(new SendMessage($data));
       $chat = Chat::create([
            "message"=>$message,
            "channel_id"=>$channel->id,
            "user_id"=>auth()->user()->id,
       ]);
       return response()->json([
        'code'=>200,
        'data' => [
            'message'=> 'Message event triggered',
        ]
       ]);
    }

    public function typing(Request $request){
        $data = ["typing"=>$request->typing, "channel"=>$request->channel, "user"=>auth()->user()];
        broadcast(new Typing($data));
        return response()->json([
            'code' => 200,
            'message'=> 'Typing event triggered'
        ]); 
    }



}
