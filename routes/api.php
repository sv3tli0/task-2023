<?php

use App\Http\Controllers\ProductController;
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

/**
 * As it is REST api > Filter as soon as possible every request due the auth token abilities.
 */

// 1. Must be authed + must have at least read ability
Route::middleware(['auth:sanctum', 'ability:read'])->prefix('products')->group(function () {
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');

    // extra check for ability write.
    Route::middleware('ability:write')->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');

        // extra check for ability delete.
        Route::delete('/{product}', [ProductController::class, 'destroy'])
            ->name('products.delete')
            ->middleware('ability:delete');
    });
});
