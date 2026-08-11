<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\vendor\Chatify\Api\MessagesController;

/**
 * Authentication for pusher private channels
 */
//Route::post('/chat/auth', 'MessagesController@pusherAuth')->name('api.pusher.auth');
Route::post('/chat/auth', [MessagesController::class, 'pusherAuth'])->name('api.pusher.auth');

/**
 *  Fetch info for specific id [user/group]
 */
Route::post('/idInfo', 'MessagesController@idFetchData')->name('api.idInfo');

/**
 * Send message route
 */
Route::post('/sendMessage', 'MessagesController@send')->name('api.send.message');

/**
 * Fetch messages
 */
Route::post('/fetchMessages', 'MessagesController@fetch')->name('api.fetch.messages');

/**
 * Download attachments route to create a downloadable links
 */
Route::get('/download/{fileName}', 'MessagesController@download')->name('api.'.config('chatify.attachments.download_route_name'));

/**
 * Make messages as seen
 */
Route::post('/makeSeen', 'MessagesController@seen')->name('api.messages.seen');

/**
 * Get contacts
 */
Route::get('/getContacts', 'MessagesController@getContacts')->name('api.contacts.get');

/**
 * Star in favorite list
 */
Route::post('/star', 'MessagesController@favorite')->name('api.star');

/**
 * get favorites list
 */
Route::post('/favorites', 'MessagesController@getFavorites')->name('api.favorites');

/**
 * Search in messenger
 */
Route::get('/search', 'MessagesController@search')->name('api.search');

/**
 * Get shared photos
 */
Route::post('/shared', 'MessagesController@sharedPhotos')->name('api.shared');

/**
 * Delete Conversation (Hard Delete)
 */
Route::post('/deleteConversation', 'MessagesController@deleteConversation')->name('api.conversation.delete');

/**
 * Delete Conversation For Me (Soft Delete)
 */
Route::post('/deleteConversationForMe', 'MessagesController@deleteConversationForMe')->name('api.conversation.delete.for.me');

/**
 * Delete Message
 */
Route::post('/deleteMessage', 'MessagesController@deleteMessage')->name('api.message.delete');

/**
 * Update Settings
 */
Route::post('/updateSettings', 'MessagesController@updateSettings')->name('api.avatar.update');

/**
 * Set active status
 */
Route::post('/setActiveStatus', 'MessagesController@setActiveStatus')->name('api.activeStatus.set');


