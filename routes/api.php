<?php

use App\Http\Controllers\CadastroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'cadastros', 'as' => 'cadastros'], function () {
    Route::get('/', [CadastroController::class, 'index']);
    Route::post('/', [CadastroController::class, 'store']);
    Route::get('/{id}', [CadastroController::class, 'show']);
    Route::put('/{id}', [CadastroController::class, 'update']);
    Route::delete('/{id}', [CadastroController::class, 'destroy']);
});
