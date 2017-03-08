<?php

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

Route::get('/{vue_capture?}', function () {
    return view('welcome');
});
Route::get('/test/user', 'UserController@getGroupOptions');

Route::get('/test/users', function() {
    $state = \App\Models\Entities\State::find(10);
    return $state->locations;

});

//Route::get('/test/users', 'UserController@lists');


