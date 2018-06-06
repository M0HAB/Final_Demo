<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->group(function () {
  Route::post('/messages/{id}/send', 'MessagesController@send');
  Route::post('/messages/{id}/read', 'MessagesController@readFromUser');
  Route::post('vote/{id}/set', 'ReplyController@setVote');
  Route::post('/newRecord', 'PostController@store');
  //change to get lama el net yege we shof el auth ezay
  Route::post('/{id}/replies', 'PostController@loadReplies');
});
