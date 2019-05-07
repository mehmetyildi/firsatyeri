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
Auth::routes();

Route::prefix('boards')->as('boards.')->namespace('Board')->group(
    function (){
        Route::name('index')->get('/board','BoardsController@index');
    }
);

Route::get('get_district_list','DropdownsController@getDistrictList');
Route::middleware('auth')->group(function (){
    Route::name('home')->get('/','HomeController@home');
    Route::prefix('users')->as('users.')->namespace('Auth')->group(
        function (){
            Route::name('detail')->get('/{username}/detail','UsersController@detail');
            Route::name('edit')->get('/edit/{id}','UsersController@edit');
            Route::name('update')->get('/update/{id}','UsersController@update');
            Route::name('update_photo')->post('/update_photo/{id}','UsersController@update_photo');
            Route::name('update_main_image')->post('/update_main_image/{id}','UsersController@update_main_image');
            Route::name('sticks.create')->get('/stick/{id}/create','UsersController@create_stick');
            Route::name('sticks.store')->post('/stick/store/{id}','UsersController@store_stick');
            Route::name('sticks.detail')->get('/sticks/detail/{stick}','UsersController@sticks_detail');
            Route::name('boards.create')->get('/boards/{id}/create','UsersController@create_board');
            Route::name('boards.store')->post('/boards/store/{id}','UsersController@store_board');
            Route::name('boards.index')->get('{username}/boards/index','UsersController@boards_index');
            Route::name('follow')->get('/follow/{following}','UsersController@follow');
            Route::name('unfollow')->get('/unfollow/{following}','UsersController@unfollow');
            Route::name('board.detail')->get('{id}/boards/{board}/detail', 'UsersController@boards_detail');
        }
    );

    Route::prefix('sticks')->as('sticks.')->namespace('Stick')->group(
        function (){
            Route::name('comments.store')->get('/{stick}/store/create','SticksController@create_comment');
        }
    );

    Route::prefix('groups')->as('groups.')->namespace('Group')->group(
        function (){
            Route::name('create')->get('/create','GroupsController@create');
            Route::name('store')->post('/store','GroupsController@store');
            Route::name('detail')->get('/{id}/detail','GroupsController@detail');
            Route::name('index')->get('{username}/index','GroupsController@index');
            Route::name('update_photo')->post('/update_photo/{id}','GroupsController@update_photo');
            Route::name('create_stick')->get('/create_stick','GroupsController@create_stick');
            Route::name('follow')->get('/follow/{group}','GroupsController@follow');
            Route::name('unfollow')->get('/unfollow/{group}','GroupsController@unfollow');
            Route::name('boards.create')->get('/boards/{id}/create','GroupsController@create_board');
            Route::name('boards.store')->post('/boards/store/{id}','GroupsController@store_board');
            Route::name('edit')->get('/edit/{group}','GroupsController@edit');
            Route::name('update')->post('/update/{group}','GroupsController@update');
            Route::name('wanted.create')->get('/wanted/{id}/create','GroupsController@create_wanted');
            Route::name('wanted.store')->post('/wanted/{id}/store','GroupsController@store_wanted');
            Route::name('sticks.create')->get('/stick/{id}/create','GroupsController@create_stick');
            Route::name('sticks.store')->post('/stick/store/{id}','GroupsController@store_stick');
            Route::name('sticks.detail')->get('/sticks/detail/{stick}','GroupsController@sticks_detail');
        }
    );

    Route::prefix('boards')->as('boards.')->namespace('Board')->group(
        function (){
            Route::name('create')->get('/create','BoardsController@create');
            Route::name('store')->post('/store','BoardsController@store');
        }
    );
});

