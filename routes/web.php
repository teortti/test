<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
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

//главная страница
Route::get('/',  function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('/test', function () {
    return view('test');
});*/

//страница изменения
Route::get('/edit', function () {
    return view('edit');
});

Route::post('/edit', function () {
    return view('edit');
});

//страница удаления
Route::get('/delete', function () {
    return view('delete');
});

//страница добавления альбома
Route::get('/add_album', function () {
    return view('add_album');
});

//контроллер для добавления альбома
Route::get('insert','InsertAlbumController@insertform');
Route::post('create','InsertAlbumController@insert');

//контроллер выхода из аккаунта
Route::get('logout','Auth\LoginController@logout');

//контроллер для обновления альбома
Route::get('edit_album','UpdateAlbumController@show');
Route::post('edit_album','UpdateAlbumController@edit_album');

Route::get('/post',[ClientController::class, 'getalbumdata']);
