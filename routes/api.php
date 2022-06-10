<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SheetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/sheet/{sheet}/{cell}', [SheetController::class, 'getData'])->name('getData');
    Route::get('/sheet/{sheet}', [SheetController::class, 'getForm'])->name('getForm');
    Route::post('/sheet/{sheet}', [SheetController::class, 'saveData'])->name('saveData');

    Route::post('/logout', [AuthController::class, 'logout']);
});
