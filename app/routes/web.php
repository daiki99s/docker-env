<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset/{token}', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'auth'], function() {
    
    Route::resource('post', 'PostController');
    Route::resource('comment', 'CommentController');
    Route::resource('user', 'UserController');
    Route::resource('admin', 'AdminController');
    Route::get('/user/delete/{id}', 'AdminController@delete')->name('admin.delete');
    
    Route::get('/', 'PostController@index');
    Route::get('/report/{id}', 'UserController@reportForm')->name('user.report');
    Route::post('/report/{id}', 'UserController@report');
    Route::post('/follow', 'FollowController@follow')->name('follow.create');
    Route::post('/unfollow', 'FollowController@unfollow')->name('follow.destroy');
    
    Route::post('ajaxlike', 'PostController@ajaxlike')->name('posts.ajaxlike');
    
});