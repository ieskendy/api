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

Route::group(['prefix' => 'v1'], function(){
	// Login & register
	Route::post('register', 'AuthController@register');
	Route::post('login', 'AuthController@login');
	
	Route::group(['middleware' => 'token'], function(){
		// Topic Routes
		Route::get('topics', 'TopicController@showTopics');
		Route::get('/topics/{id}', 'TopicController@showTopic');
		Route::get('topics/{topic_id}/replies', 'ReplyController@showRepliesByTopic');
		Route::get('/users/{id}/topics', 'TopicController@showUserTopics');
		Route::get('/users/{user_id}/topics/{topic_id}', 'TopicController@showUserTopic');
		// Route::get('/topics/categories/{id}', 'TopicController@showTopicByCategories');
		Route::post('topics', 'TopicController@storeNewTopic');
		Route::put('topics/{id}', 'TopicController@updateTopic');
		Route::delete('topics/{id}', 'TopicController@destroyTopic');

		// User Routes
		Route::get('/users', 'UserController@showUsers');
		Route::get('/users/{id}', 'UserController@showUser');
		Route::put('/users/{id}', 'UserController@updateUserData');
		Route::delete('users/{id}', 'UserController@destroyUser');

		// Reply Routes
		Route::get('/replies', 'ReplyController@showReplies');
		Route::post('/replies', 'ReplyController@createNewReply');
		Route::put('/replies/{id}', 'ReplyController@updateReplyData');
		Route::delete('/replies/{id}', 'ReplyController@destroyReply');

		// Category Routes
		// Route::get('/categories', 'CategoryController@showCategories');
		// Route::post('/categories', 'CategoryController@saveCategory');
		// Route::put('/categories/{id}', 'CategoryController@updateCategory');
		// Route::delete('/categories/{id}', 'CategoryController@destroyCategory');
	});
});
