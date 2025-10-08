<?php
use Illuminate\Support\Facades\Route;



Route::middleware(['authUser'])->group(function () {
    
    Route::get('/', function () {
        return view('channel');
    })->name("channel");

});

