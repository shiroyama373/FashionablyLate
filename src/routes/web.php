<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// ログイン用ルートを追加
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// ログアウト用ルート（認証済みのみ）
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


Route::get('/', function () { 
    return view('welcome');
});

//一般ユーザー向け
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

// 管理者向け
Route::prefix('admin')->middleware('auth')->group(function () {
    // 管理画面トップ（一覧表示）
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // 管理画面一覧（/admin/contacts でも同じController@indexを使う）
    Route::get('/contacts', [AdminController::class, 'index'])->name('admin.contacts.index');

    // エクスポート
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');

    // 詳細表示（モーダル用）
    Route::get('/contacts/{id}', [AdminController::class, 'show'])->name('admin.contacts.show');

    // 削除
    Route::delete('/contacts/{id}', [AdminController::class, 'destroy'])->name('admin.contacts.destroy');
});