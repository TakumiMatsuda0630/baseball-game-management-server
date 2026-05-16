<?php

use Application\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;
use Application\Http\Controllers\Admin\StadiumController;

// 管理画面
Route::prefix('admin')->group(function (){
    // ログイン画面表示
    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

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
});
