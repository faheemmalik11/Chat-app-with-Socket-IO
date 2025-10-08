<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatRoomController extends Controller
{
    public function show(Request $request){
        $group = $request->group;
        return view('chatRoom',compact('group'));
    }
}
