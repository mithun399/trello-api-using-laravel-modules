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


Route::get('/auth',[Modules\Trello\Http\Controllers\TrelloController::class,'getUser']);
Route::get('/token',[Modules\Trello\Http\Controllers\TrelloController::class,'accessToken']);
Route::get('/board',[Modules\Trello\Http\Controllers\TrelloController::class,'getBoard']);
Route::get('/boarddelete/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'deleteBoard']);
Route::get('/createboardview',[Modules\Trello\Http\Controllers\TrelloController::class,'viewBoard']);
Route::get('/createboard',[Modules\Trello\Http\Controllers\TrelloController::class,'createBoard']);
Route::get('/editview/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'editView']);
Route::get('/updateboard/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'updateBoard']);

Route::get('/getboadlist/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'boardList']);
Route::get('/createlistview/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'createlistview']);
Route::get('/addlist',[Modules\Trello\Http\Controllers\TrelloController::class,'addlist'])->name('addlist');
Route::get('/getcardlist/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'getcardlist']);
Route::get('/addcard',[Modules\Trello\Http\Controllers\TrelloController::class,'addcard']);
Route::get('/addcardview/{id}',[Modules\Trello\Http\Controllers\TrelloController::class,'addcardview']);

