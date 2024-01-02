<?php

use App\Http\Controllers\CodeExecutionController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/execute-code', [CodeExecutionController::class, 'showForm'])->name('execute-code');
Route::post('/execute-code', [CodeExecutionController::class, 'executeCode']);
Route::get('/executions', [CodeExecutionController::class, 'showExecutions']);


require __DIR__.'/auth.php';
