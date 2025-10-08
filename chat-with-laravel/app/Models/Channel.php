<?php

namespace App\Models;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function chats(){
        return $this->belongsToMany(Chat::class);
    }
}
