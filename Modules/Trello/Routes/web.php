<?php
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

// Route::prefix('trello')->group(function() {
//     Route::get('/', 'TrelloController@index');
// });

Route::get('/',function(){
    return view('trello::auth');
});
Route::get('/tokenview',function(){
    return view('trello::token');
});


Route::get('/auth',[Modules\Trello\Http\Controllers\TrelloController::class,'auth']);
Route::get('/token',[Modules\Trello\Http\Controllers\TrelloController::class,'accessToken']);
Route::get('/board',[Modules\Trello\Http\Controllers\TrelloController::class,'getBoard']);
Route::get('/boarddelete/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'deleteBoard']);
Route::get('/createboardview',[Modules\Trello\Http\Controllers\TrelloController::class,'viewBoard']);
Route::get('/createboard',[Modules\Trello\Http\Controllers\TrelloController::class,'createBoard']);
Route::get('/editview/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'editView']);
Route::get('/updateboard/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'updateBoard']);
Route::get('/boardlist/{id}',[Modules\Trello\Http\Controllers\TrelloControllero::class,'boardList']);
Route::get('/listview/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'viewList']);
Route::get('/addlist',[Modules\Trello\Http\Controllers\TrelloController::class,'addList'])->name('addlist');
Route::get('/cardlist/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'cardList']);
Route::get('/cardview/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'cardView']);
Route::get('/addcard',[Modules\Trello\Http\Controllers\TrelloController::class,'addCard']);
