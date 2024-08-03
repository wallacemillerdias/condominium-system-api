<?php

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

Route::group(['prefix' => 'leads', 'as' => 'leads'], function () {
    Route::get('/', [LeadController::class, 'index']);
    Route::post('/', [LeadController::class, 'store']);
    Route::get('/{id}', [LeadController::class, 'show']);
    Route::put('/{id}', [LeadController::class, 'update']);
    Route::delete('/{id}', [LeadController::class, 'destroy']);
});

Route::post('/cadastro', [\App\Http\Controllers\CadastroController::class, 'store']);
Route::get('cadastro/{cpf}', [\App\Http\Controllers\CadastroController::class, 'show']);
Route::get('cadastros', [\App\Http\Controllers\CadastroController::class, "index"]);
