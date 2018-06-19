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
//Route to formulate AJAX requests errors
Route::get('/error/{error}', function($error){
  $returns['error']=true;
  if($error){
    $returns['message'] = $error;
  }else{
    $returns['message'] = "Some Error Occured";
  }
  return response()->json($returns);
})->name('error.api');

Route::middleware('auth:admin-api')->group(function () {
  Route::delete('/prole/{id}/delete', 'PermissionRoleController@destroy');
  Route::get('/search', 'Admin\UserController@getUsers');
  Route::delete('/user/{id}/delete', 'Admin\UserController@destroy');


});

Route::middleware('auth:api')->group(function () {
  Route::post('/messages/{id}/send', 'MessagesController@send');
  Route::post('/messages/{id}/read', 'MessagesController@readFromUser');

  Route::post('vote/{id}/set', 'ReplyController@setVote')->name('discussion.reply.vote');

  Route::post('/newRecord', 'PostController@store')->name('discussion.record.store');
  Route::post('/editRecord', 'PostController@edit')->name('discussion.record.edit');
  Route::post('/newComment', 'CommentController@store')->name('discussion.comment.store');
  Route::post('/editComment', 'CommentController@edit')->name('discussion.comment.edit');

  Route::delete('/comment/{id}/delete', 'CommentController@delete')->name('discussion.comment.delete');
  Route::delete('/post/{id}/delete', 'PostController@delete')->name('discussion.post.delete');
  Route::delete('/reply/{id}/delete', 'ReplyController@delete')->name('discussion.reply.delete');
  Route::delete('/department/{id}/delete', 'DepartmentsController@destroy');
  Route::delete('/specialization/{id}/delete', 'SpecializationController@destroy');
  Route::delete('/depspec/{id}/delete', 'DepartmentsController@specDestroy');

  Route::get('/{id}/replies', 'PostController@loadReplies');
  Route::get('/{id}/search', 'DiscussionController@searchPosts');

});
