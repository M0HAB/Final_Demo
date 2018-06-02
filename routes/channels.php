<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('msg.{id}', function($user,$id){
  $users = explode("_", $id);
  $user1=  (int) $users[0];
  $user2=  (int) $users[1];
  $currentUser = (int) $user->id;
  if ($currentUser === $user1 || $currentUser === $user2){
    return true;
  }else{
    return false;
  }
});
