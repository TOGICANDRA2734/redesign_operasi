<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\dataProdController;
use App\Http\Controllers\KendalaController;
use App\Http\Controllers\ProductivityController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;


use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;


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

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

Route::controller(AuthController::class)->middleware('loggedin')->group(function() {
    Route::get('login', 'loginView')->name('login.index');
    Route::post('login', 'login')->name('login.check');
    Route::get('register', 'registerView')->name('register.index');
    Route::post('register', 'register')->name('register.store');
});


Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Super Admin
    Route::group(['middleware' => ['role:super_admin']], function(){
        Route::group(['prefix' => 'super_admin', 'as' => 'super_admin.'], function(){
            Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        });
    });

    // Admin
    Route::group(['middleware' => ['role:admin']], function(){
        Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
            Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        });
    });

    // User
    Route::group(['middleware' => ['role:user']], function(){
        Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
            Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
        });
    });

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard-filtered/{namasite}', [DashboardController::class, 'index_filtered'])->name('dashboard.filtered');
    Route::get('dashboard/detail/{site}', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('dashboard/detail_filtered/', [DashboardController::class, 'show_data_filtered'])->name('dashboard.show.filtered');

    // Data Produksi
    Route::resource('data-prod', dataProdController::class);
    Route::get('data-prod/create_data/{tgl}', [dataProdController::class, 'create_data'])->name('create_data.index');
    Route::put('data-prod/update_data/{data_prod}', [dataProdController::class, 'update_data'])->name('update_data.index');
    Route::get('data-prod/{id}/{tgl}/{other}', [dataProdController::class, 'edit_data'])->name('edit_data_other.index');
    Route::get('data-prod-report', [dataProdController::class, 'report'])->name('data-prod.report');
    Route::post('detail-pit', [dataProdController::class, 'getPit'])->name('data-prod.getPit');

    // Productivity
    Route::resource('productivity', ProductivityController::class);
    Route::post('productivity_check', [ProductivityController::class, 'check'])->name('productivity.check');
    Route::post('productivity_store', [ProductivityController::class, 'store_data'])->name('productivity.store_data');

    // Kendala
    Route::resource('kendala', KendalaController::class);
    
    // Komentar
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.store');

    // Profil
    Route::resource('profil', ProfilController::class);

    // Add Account 
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');

    // Change Password
    Route::put('change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');
    
    // Search
    Route::post('search', [SearchController::class, 'index'])->name('search.index');
});
