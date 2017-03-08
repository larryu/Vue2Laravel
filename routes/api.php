<?php

use Illuminate\Http\Request;
use App\Models\Entities\Role;
use App\Models\Entities\UserGroup;
use App\Models\Entities\Process;
use App\Models\Entities\Menu;

Route::post('authenticate', 'Auth\AuthController@authenticate');

Route::group(['middleware' => 'jwt.auth'], function()
{
    Route::get('user', 'UserController@show');
    Route::post('user/profile/update', 'UserController@updateProfile');
    Route::post('user/password/update', 'UserController@updatePassword');

    Route::get('tabs', 'TabController@show');
    Route::get('components', 'ComponentController@show');
    Route::get('processes', 'ProcessController@show');

    Route::get('roles', 'RoleController@lists');
    Route::post('role/edit/', 'RoleController@updateRole');
    Route::post('role/add/', 'RoleController@addRole');
    Route::post('role/delete/', 'RoleController@deleteRole');

    Route::get('menus', 'MenuController@show');
    Route::get('menunodes', 'MenuController@getMenuNodes');
    Route::post('menu/edit/', 'MenuController@updateMenu');
    Route::post('menu/add/', 'MenuController@addMenu');
    Route::post('menu/delete/', 'MenuController@deleteMenu');

    Route::get('statenodes', 'StateController@getStateNodes');
    Route::post('state/edit/', 'StateController@updateState');
    Route::post('state/add/', 'StateController@addState');
    Route::post('state/delete/', 'StateController@deleteState');

    Route::get('usernodes', 'UserController@getUserNodes');
    Route::post('user/edit/', 'UserController@updateUser');
    Route::post('user/add/', 'UserController@addUser');
    Route::post('user/delete/', 'UserController@deleteUser');

    Route::get('user/roleoptions', 'UserController@getRoleOptions');
    Route::get('user/groupoptions', 'UserController@getGroupOptions');
});

//Route::get('roles', function() {
//    return Role::all();
//});
//
//
//Route::get('user_groups', function() {
//    return UserGroup::all();
//});


// Route::get('menus', function() {
//     return Menu::all();
// });


//Route::get('menus', 'MenuController@show');