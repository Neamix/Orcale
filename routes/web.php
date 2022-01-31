<?php

use App\Http\Controllers\ShowController;
use App\Http\Controllers\UserController;
use App\Models\show;
use App\Models\User;
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

/** =================== Genre Routes ==================== */

Route::group(['prefix' => 'genre'],function(){
    Route::post('/',[ShowController::class,'genre_ids']);
    Route::post('/{type}',[ShowController::class,'genre_id']);
});

/**======================== Users ========================= */

Route::group(['prefix' => 'users'],function(){
    Route::post('register',[UserController::class,'register']);
    Route::post('login',[UserController::class,'sign']);
    Route::get('/socialite/{drive}',[UserController::class,'socialite']);
    Route::post('/forget',[UserController::class,'forget']);
    Route::post('/valid',[UserController::class,'validToken']);
    Route::post('/reset',[UserController::class,'resetPassword']);
    Route::post('/auth',[UserController::class,'Auth']);
    Route::post('/modify',[UserController::class,'modify']);
    Route::post('/password',[UserController::class,'changePassword']);
    Route::get('/logout',[UserController::class,'logout']);
    Route::get('/delete',[UserController::class,'delete']);
});
Route::get('/socialite/{drive}/redirect',[UserController::class,'resocialite']);

/** ======================= Shows Routes ================== */

Route::group(['prefix' => 'show'],function(){
    Route::post('/find/{type}/{id}',[ShowController::class,'find']);
    Route::post('/category/{type}/{page?}/{id?}',[ShowController::class,'getByCategory']);
    Route::post('/search/{type}/{limit?}',[ShowController::class,'search']);
    Route::post('/person/{id}',[ShowController::class,'person']);
    Route::post('/{type}/{page?}/{sort?}',[ShowController::class,'get']);
    Route::get('/latest',[ShowController::class,'latest']);
});

Route::post('/action',[ShowController::class,'actions']);

Route::get('/test',function(){
    dump(User::Auth());
});
/** ======================= Vue =========================== */

Route::get('/{any}',function(){
    return view('welcome');
})->where('any','.*')->name('vue');
