<?php

use Illuminate\Support\Facades\Route;


// use App\Http\Controllers\EventController;



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

// Route::get('/', function () {
//     return view('welcome');
// });
/**Rendering Page **/




Auth::routes();


Route::get('/', 'LoginController@showLoginForm');
Route::post('/login', 'LoginController@login')->name('login');
 

// request:


Route::group(['middleware' => 'auth'], function()
{

    Route::get('/event', 'EventController@event')->name('event');

    Route::post('/event-add', 'EventController@event_add');
    Route::post('/event-update', 'EventController@event_update');
    Route::post('/event-delete', 'EventController@event_delete');
    Route::get('/event-get', 'EventController@event_get');

});