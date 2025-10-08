<?php

use App\Models\Channel;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



 Broadcast::channel('general.{channelId}', function ($user, $channelId) {

      $channel =  Channel::findorFail($channelId);
      if( $channel->users->contains($user)){
        return ['id' => $user->id, 'name' => $user->name];
      }
},['guards'=>['user']]);


Broadcast::channel('chat.{recipientId}.{senderId}', function ($user, $recipientId, $senderId ) {

  return $user->id == $recipientId || $user->id == $senderId;
 
},['guards'=>['user']]);