<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;

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


// 商品詳細画面
Route::get('/item/{item_id}', [ItemController::class, 'show']);


// 認証が必要なルートグループ
Route::middleware('auth')->group(function () {
    // 商品購入画面
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show']);
    
    // 住所変更ページ
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress']);
    
    // 商品出品画面
    Route::get('/sell', [ItemController::class, 'create']);

    // 商品出品処理
    Route::post('/sell', [ItemController::class, 'store']);

    // コメント投稿処理
    Route::post('/item/{item_id}/comment', [ItemController::class, 'addComment']);
    
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

// 登録画面と登録処理のルート
Route::get('register', [RegisterController::class, 'showRegistrationForm']);
Route::post('register', [RegisterController::class, 'register']);
