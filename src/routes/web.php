<?php

use Illuminate\Support\Facades\Route;
// use Laravel\?Fortify\Fortify; //呼び出す必要がない
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ProductMylistController;


// Route::get('/register', function () {
//     return view('auth/register');
// });

// Fortify::routes(); //呼び出す必要がない

// Route::middleware('guest')->group(function () {

// 会員登録
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

// 会員登録処理
Route::post('/register', [RegisteredUserController::class, 'store'])->name('user.store');



// ログイン
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

// ログイン認証処理
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// }

// );


// Route::middleware('auth')->group(function () {



// });


Route::middleware('auth')->group(function () {

    // ログアウト
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// プロフィール設定画面（初回ログイン時）
Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');

// プロフィール登録処理
Route::post('/profile/create', [ProfileController::class, 'store'])->name('profile.store');

// プロフィール画面
// Route::get('/profile/mypage/{id}', [ProfileController::class, 'show'])->name('profile.mypage');
Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');

// プロフィール編集画面
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// プロフィール更新処理
// Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');




});


// メール認証のトークン検証
Route::get('/email/verify/{token}', [EmailVerificationController::class, 'verify'])->name('verification.verify');




// Route::middleware('auth')->group(function () {

// Route::get('/product/mypage/{id}', [ProductMylistController::class, 'index'])->name('product.mylist');
Route::get('/product/mylist', [ProductMylistController::class, 'show'])->name('product.mylist');


// });
