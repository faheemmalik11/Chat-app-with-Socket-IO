<?php

use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


$user_login = ( (int)request()->segment(2) > 0 ? 'u/'. request()->segment(2) : '' );

Route::get('/', function () {
    return view('welcome');
});

Route::get($user_login.'/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    $user_login = ( (int)request()->segment(2) > 0 ? 'u/'. request()->segment(2) : '' );
    Route::get($user_login.'/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch($user_login.'/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete($user_login.'/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get($user_login.'/chatRoom/{group}', [ChatRoomController::class, 'show'])->name('chatRoom.show');
});

Route::get('/socket.io.js', function () {
    return response()->file(base_path('node_modules/socket.io/client-dist/socket.io.js'));
});

require __DIR__.'/auth.php';
