<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'user_id',
        'channel_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }
}
