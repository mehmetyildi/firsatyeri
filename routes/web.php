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
Route::get('get_groupboard_list','DropdownsController@getGroupBoardList');
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
            Route::name('sticks.detail')->get('{record}/sticks/detail/{stick}','UsersController@sticks_detail');
            Route::name('boards.create')->get('/boards/{id}/create','UsersController@create_board');
            Route::name('boards.store')->post('/boards/store/{id}','UsersController@store_board');
            Route::name('follow')->get('/follow/{following}','UsersController@follow');
            Route::name('unfollow')->get('/unfollow/{following}','UsersController@unfollow');
            Route::name('boards.index')->get('{username}/boards/index','UsersController@boards_index');
            Route::name('board.detail')->get('{id}/boards/{board}/detail', 'UsersController@boards_detail');
            Route::name('move_stick_to_board')->post('/users/{user}/boards/{stick}','UsersController@move_stick_to_board');
            Route::name('move_stick_to_group')->post('/users/{user}/groups/{stick}','UsersController@move_stick_to_group');
            Route::name('sticks.save')->post('/users/{user}/sticks/{stick}','UsersController@save_stick');
            Route::name('interests')->get('/interests/{user}/index','UsersController@interests');
            Route::name('interests.store')->post('/interests/{user}','UsersController@interests_store');
            Route::name('interests.edit')->get('/interests/{user}/edit','UsersController@interests_edit');
            Route::name('interests.update')->post('/interests/{user}/update','UsersController@interests_update');
            Route::name('boards.edit')->get('{record}/boards/{board}/edit','UsersController@edit_board');
            Route::name('boards.update')->post('{record}/boards/update/{board}','UsersController@update_board');
            Route::name('recommended')->get('recommended/{username}','UsersController@recommended');

        }
    );

    Route::prefix('sticks')->as('sticks.')->namespace('Stick')->group(
        function (){
            Route::name('comments.store')->get('/{stick}/store/create','SticksController@create_comment');
            Route::name('detail')->get('/detail/{stick}','SticksController@detail');
            Route::name('edit')->get('/{type}/{record}/{stick}','SticksController@edit');
            Route::name('delete')->delete('/{stick}','SticksController@delete');
            Route::name('update')->post('/{type}/{record}/{stick}','SticksController@update');
            Route::name('update_photo')->post('/update_photo/{stick}','SticksController@update_photo');
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
            Route::name('boards.edit')->get('{record}/boards/{board}/edit','GroupsController@edit_board');
            Route::name('boards.update')->post('{record}/boards/update/{board}','GroupsController@update_board');
            Route::name('boards.store')->post('/boards/store/{id}','GroupsController@store_board');
            Route::name('edit')->get('/edit/{group}','GroupsController@edit');
            Route::name('update')->post('/update/{group}','GroupsController@update');
            Route::name('wanted.create')->get('/wanted/{id}/create','GroupsController@create_wanted');
            Route::name('wanted.store')->post('/wanted/{id}/store','GroupsController@store_wanted');
            Route::name('sticks.create')->get('/stick/{id}/create','GroupsController@create_stick');
            Route::name('sticks.store')->post('/stick/store/{id}','GroupsController@store_stick');
            Route::name('sticks.detail')->get('{record}/sticks/detail/{stick}','GroupsController@sticks_detail');
            Route::name('boards.index')->get('{group}/boards/index','GroupsController@boards_index');
            Route::name('board.detail')->get('{id}/boards/{board}/detail', 'GroupsController@boards_detail');
            Route::name('wanted.sticks.create')->get('{group}/wanted/{wanted}/sticks/create', 'GroupsController@create_wanted_stick');
            Route::name('wanted.sticks.store')->post('{group}/wanted/{wanted}/sticks/store', 'GroupsController@store_wanted_stick');
            Route::name('wanted.detail')->get('{record}/wanted/{wanted}/detail', 'GroupsController@wanted_detail');
            Route::name('users.index')->get('{group}/users','GroupsController@user_index');
            Route::name('ban_user')->post('{group}/users/{user}/ban','GroupsController@ban_user');
            Route::name('promote_user')->post('{group}/users/{user}/promote','GroupsController@promote_user');
            Route::name('depromote_user')->post('{group}/users/{user}/depromote','GroupsController@depromote_user');
            Route::name('move_stick_to_board')->post('/groups/{user}/boards/{stick}','GroupsController@move_stick_to_board');
            Route::name('move_stick_to_group')->post('/groups/{user}/groups/{stick}','GroupsController@move_stick_to_group');
            Route::name('wanted.sticks')->get('/{group}/wanted/{wanted}/sticks','GroupsController@wanted_sticks');

        }
    );

    Route::prefix('boards')->as('boards.')->namespace('Board')->group(
        function (){
            Route::name('create')->get('/create','BoardsController@create');
            Route::name('store')->post('/store','BoardsController@store');
        }
    );
});


    Route::prefix(('cms'))->middleware('App\Http\Middleware\AdminMiddleware')->as('cms.')->namespace('Cms')->group(

        function(){
        Route::name('home')->get('/home', 'HomeController@index');
        Route::name('search')->get('/search', 'SearchController@search');

        Route::prefix('interests')->as('interests.')->namespace('Interests')->group(function(){
            Route::name('index')->get('/', 'InterestsController@index');
            Route::name('store')->post('/', 'InterestsController@store');
            Route::name('create')->get('/create', 'InterestsController@create');
            Route::name('edit')->get('/{record}/edit', 'InterestsController@edit');
            Route::name('update')->put('/{record}', 'InterestsController@update');
            Route::name('delete')->delete('/{record}', 'InterestsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'InterestsController@deleteFile');
        });

        Route::prefix('ranks')->as('ranks.')->namespace('Ranks')->group(function(){
            Route::name('index')->get('/', 'RanksController@index');
            Route::name('store')->post('/', 'RanksController@store');
            Route::name('create')->get('/create', 'RanksController@create');
            Route::name('edit')->get('/{record}/edit', 'RanksController@edit');
            Route::name('update')->put('/{record}', 'RanksController@update');
            Route::name('delete')->delete('/{record}', 'RanksController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'RanksController@deleteFile');
        });

        Route::prefix('users')->as('users.')->namespace('Users')->group(function(){
            Route::name('index')->get('/', 'UsersController@index');
            Route::name('promote')->post('/{user}', 'UsersController@promote');
            Route::name('delete')->delete('/{record}', 'UsersController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'UsersController@deleteFile');
        });

        Route::prefix('groups')->as('groups.')->namespace('Groups')->group(function(){
            Route::name('index')->get('/', 'GroupsController@index');
            Route::name('store')->post('/', 'GroupsController@store');
            Route::name('create')->get('/create', 'GroupsController@create');
            Route::name('edit')->get('/{record}/edit', 'GroupsController@edit');
            Route::name('update')->put('/{record}', 'GroupsController@update');
            Route::name('delete')->delete('/{record}', 'GroupsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'GroupsController@deleteFile');
        });
    });

