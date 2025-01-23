<?php

use Illuminate\Support\Facades\Route;
// use Laravel\?Fortify\Fortify; //呼び出す必要がない
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ItemController;


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




Route::middleware('auth')->group(function () {

// Route::get('/item/mylist/{id}', [itemMylistController::class, 'index'])->name('item.mylist');
Route::get('/item/mylist', [ItemController::class, 'showMylist'])->name('item.show.mylist');







// // 検索処理
// Route::get("/items/search",[ItemController::class,"search"])->name("items.search");

// 商品一覧画面表示
Route::get("/items",[ItemController::class,"index"])->name("items.index");

// // 商品詳細画面表示
// Route::get("/item",[ItemController::class,"show"])->name("item.show");
Route::get("/item/{itemId}",[ItemController::class,"show"])->name("item.show");

// 商品登録画面表示
Route::get("/items/register",[ItemController::class,"create"])->name("item.create");

// 商品登録処理
Route::post("/items/register",[ItemController::class,"store"])->name("items.store");

// // 商品編集画面表示
// Route::get("/items/{itemId}",[ItemController::class,"edit"])->name("items.edit");


// // 商品更新処理
// Route::patch("/items/{itemId}/update",[ItemController::class,"update"])->name("items.update");


});
