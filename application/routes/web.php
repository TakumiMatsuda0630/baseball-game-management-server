<?php

declare(strict_types=1);

use Application\Http\Controllers\Admin\GameScheduleController;
use Application\Http\Controllers\Admin\LoginController;
use Application\Http\Controllers\Admin\StadiumController;
use Application\Http\Controllers\Admin\TeamController;
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

        // チーム管理
        Route::get('/team', [TeamController::class, 'index'])
            ->name('team.index');
        Route::get('/team/regist', [TeamController::class, 'create'])
            ->name('team.create');
        Route::post('/team/store', [TeamController::class, 'store'])
            ->name('team.store');
        Route::get('/team/edit/{id}', [TeamController::class, 'edit'])
            ->whereUuid('id')
            ->name('team.edit');
        Route::put('/team/update/{id}', [TeamController::class, 'update'])
            ->whereUuid('id')
            ->name('team.update');
        Route::delete('/team/delete/{id}', [TeamController::class, 'destroy'])
            ->whereUuid('id')
            ->name('team.destroy');

        // 試合予定管理
        Route::get('/game-schedule', [GameScheduleController::class, 'index'])->name('game-schedule.index');
        Route::get('/game-schedule/regist', [GameScheduleController::class, 'create'])->name('game-schedule.create');
        Route::post('/game-schedule/store', [GameScheduleController::class, 'store'])->name('game-schedule.store');
        Route::get('/game-schedule/edit/{id}', [GameScheduleController::class, 'edit'])->whereNumber('id')->name('game-schedule.edit');
        Route::put('/game-schedule/update/{id}', [GameScheduleController::class, 'update'])->whereNumber('id')->name('game-schedule.update');
        Route::delete('/game-schedule/delete/{id}', [GameScheduleController::class, 'destroy'])->whereNumber('id')->name('game-schedule.destroy');

        Route::get('logout', [LoginController::class, 'logout'])
            ->name('logout');
    });
