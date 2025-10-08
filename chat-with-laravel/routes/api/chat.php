<?php

use App\Http\Controllers\ChatController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::middleware(['authUser'])->group(function () {
    
    Route::get('/', function () {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('chat',compact('users'));
    })->name("chat");
    Route::post('sendMessage', [ChatController::class, 'sendMessage']);
    Route::get('getMessages/{id}', [ChatController::class, 'getMessages']);

});

