<?php

declare(strict_types=1);

use Application\Http\Controllers\Admin\LoginController;
use Application\Http\Controllers\Admin\StadiumController;
use Illuminate\Support\Facades\Route;

// 未ログイン用ルート
Route::middleware('guest')->group(function () {
    // 管理画面のログイン画面表示
    Route::get('admin/login', [LoginController::class, 'index']);
    // 管理画面ログイン処理
    Route::post('admin/login/auth', [LoginController::class, 'authenticate']);
});

// 管理画面ログイン済用ルート
Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {
        // ホーム画面
        // TODO Controllerを作成すること。(手間を省くためにControllerを作成せず、直接レスポンスを返却している)
        Route::get('/home', static function () {
            return inertia('Home');
        });

        // 球場管理
        Route::get('/stadium', [StadiumController::class, 'index'])
            ->name('stadium.index');
        Route::get('/stadium/regist', [StadiumController::class, 'create'])
            ->name('stadium.create');
        Route::post('/stadium/store', [StadiumController::class, 'store'])
            ->name('stadium.store');
        Route::get('/stadium/edit/{id}', [StadiumController::class, 'edit'])
            ->name('stadium.edit');
        Route::put('/stadium/update/{id}', [StadiumController::class, 'update'])
            ->name('stadium.update');
        Route::delete('/stadium/delete/{id}', [StadiumController::class, 'destroy'])
            ->name('stadium.destroy');

        Route::get('logout', [LoginController::class, 'logout'])
            ->name('logout');
    });
