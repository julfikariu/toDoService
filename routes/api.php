<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::prefix('v1')->group(function () {
    Route::get('/todos', [TodoController::class, 'index']);
    Route::post('/todos', [TodoController::class, 'store']);
});
