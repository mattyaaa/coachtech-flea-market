<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

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

// 商品一覧画面（トップ画面）
Route::get('/',[ItemController::class, 'index']);


// 認証が必要なルートグループ
Route::middleware('auth')->group(function () {
    // プロフィール画面
    Route::get('/mypage', [ProfileController::class, 'show']);

    // プロフィール編集画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::put('/mypage/profile', [ProfileController::class, 'update']);

    // プロフィール画面_購入した商品一覧
    Route::get('/mypage?tab=buy', [ProfileController::class, 'showPurchases']);
    
    // プロフィール画面_出品した商品一覧
    Route::get('/mypage?tab=sell', [ProfileController::class, 'showSales']);
});
