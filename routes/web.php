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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/factorylist', 'DataController@fetchFactory');

// Ajax Insert Data Controllers
Route::post('/factory/postcutting', 'DataController@insertCuttingData')->name('ajaxdata.postcutting');
Route::post('/factory/postsewing', 'DataController@insertSewingData')->name('ajaxdata.postsewing');
Route::post('/factory/postfinishing', 'DataController@insertFinishingData')->name('ajaxdata.postfinishing');
Route::post('/factroy/poststrength', 'DataController@insertStrengthData')->name('ajaxdata.poststrength');

// Ajax Factory Tables To get all the factories list
Route::get('/factories/getdata', 'AdminController@getFactories')->name('getfactories');

// For admins
Route::get('/admins/users', function(){
  return view('admin.users');
})->name('admin.users');








// For Masters





// Charts Test
Route::get('/charts/test', 'ChartTestController@index');
