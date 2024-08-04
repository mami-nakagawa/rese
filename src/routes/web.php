<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::get('/thanks', [ShopController::class, 'thanks']);
Route::get('/', [ShopController::class, 'index']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

Route::middleware('auth', 'verified', 'web')->group(function () {
    Route::post('/done', [ShopController::class, 'reservation']);
    Route::patch('/reservation_update', [ShopController::class, 'reservationUpdate']);
    Route::delete('/reservation_delete', [ShopController::class, 'reservationDestroy']);
    Route::post('/favorite', [ShopController::class, 'favorite']);
    Route::delete('/favorite_delete', [ShopController::class, 'favoriteDestroy']);
    Route::get('/mypage', [ShopController::class, 'mypage']);
    Route::post('/review', [ShopController::class, 'review']);
});

    Route::get('/admin/admin', [AdminController::class, 'admin']);
    Route::post('/admin/done', [AdminController::class, 'register']);

    Route::get('/editor/admin', [EditorController::class, 'admin']);
    Route::post('/editor/done', [EditorController::class, 'create']);
    Route::post('/editor/update', [EditorController::class, 'update']);


