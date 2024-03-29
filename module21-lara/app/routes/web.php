<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/texts', [TextController::class, 'listText'])->name('texts-show');

Route::delete('/text-delete/{id}', [TextController::class, 'deleteText']);

Route::get('/texts/create', [TextController::class, 'showAddTable'])->name('texts-create');



Route::post('/text-update/{id}', [TextController::class, 'showUpdateTable']);

Route::post('/texts-update', [TextController::class, 'updateText'])->name('texts-update');
Route::post('/texts-create', [TextController::class, 'addText'])->name('texts-store');


