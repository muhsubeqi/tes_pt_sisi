<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataMenuController;
use App\Http\Controllers\Admin\DataUserController;
use App\Http\Controllers\Admin\IErrorApplicationController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuUserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TesLogikaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/logika1', [TesLogikaController::class, 'logika1'])->name('logika1');
Route::get('/logika2', [TesLogikaController::class, 'logika2'])->name('logika2');
Route::get('/erd-kepegawaian', [TesLogikaController::class, 'erdKepegawaian'])->name('erd.kepegawaian');

Auth::routes();
Route::prefix('administrator')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // User
    Route::prefix('data-user')->group(function () {
        Route::get('/', [DataUserController::class, 'index'])->name('admin.data-user');
        Route::get('/data', [DataUserController::class, 'data'])->name('admin.data-user.data');
        Route::post('/add', [DataUserController::class, 'add'])->name('admin.data-user.add');
        Route::post('/edit', [DataUserController::class, 'edit'])->name('admin.data-user.edit');
        Route::delete('/delete', [DataUserController::class, 'delete'])->name('admin.data-user.delete');
    });
    Route::prefix('user-activity')->group(function () {
        Route::get('/', [UserActivityController::class, 'index'])->name('admin.user-activity');
        Route::get('/data', [UserActivityController::class, 'data'])->name('admin.user-activity.data');
    });
    Route::prefix('error-application')->group(function () {
        Route::get('/', [IErrorApplicationController::class, 'index'])->name('admin.error-application');
        Route::get('/data', [IErrorApplicationController::class, 'data'])->name('admin.error-application.data');
        Route::get('/add', [IErrorApplicationController::class, 'add'])->name('admin.error-application.add');
    });

    // Menu
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('admin.menu');
        Route::get('/data', [MenuController::class, 'data'])->name('admin.menu.data');
        Route::post('/add', [MenuController::class, 'add'])->name('admin.menu.add');
        Route::post('/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
        Route::delete('/delete', [MenuController::class, 'delete'])->name('admin.menu.delete');

        // akses menu user
        Route::get('/akses-menu-user/{idMenu}', [MenuController::class, 'aksesMenuUser'])->name('admin.menu.akses-menu-user');
        Route::get('/akses-menu-user', [MenuController::class, 'aksesMenuUserData'])->name('admin.menu.akses-menu-user.data');
        Route::post('/akses-menu-user/add', [MenuController::class, 'aksesMenuUserAdd'])->name('admin.menu.akses-menu-user.add');
        Route::delete('/akses-menu-user/delete', [MenuController::class, 'aksesMenuUserDelete'])->name('admin.menu.akses-menu-user.delete');
    });

    Route::get('/{menu}', [DataMenuController::class, 'index'])->name('admin.data-menu.index');
});