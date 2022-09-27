<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\dataProdController;
use App\Http\Controllers\KendalaController;
use App\Http\Controllers\ProductivityController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AdminTransaksiPmaController;

// Admin
use App\Http\Controllers\Admin\dataProdController as Admin_dataProdController;
use App\Http\Controllers\Admin\KendalaController as Admin_KendalaController;
use App\Http\Controllers\Admin\ProductivityController as Admin_ProductivityController;
use App\Http\Controllers\BDDokController;
use App\Http\Controllers\BDHarianController;
use App\Http\Controllers\HistoricalUnitController;
use App\Http\Controllers\MohhController;
use App\Http\Controllers\PapController;
use App\Http\Controllers\POController;
use App\Http\Controllers\PopulasiUnitController;
use App\Http\Controllers\POTransaksiController;
use App\Http\Controllers\ProductivityCoalController;
use App\Http\Controllers\RepHarController;
// User
use App\Http\Controllers\User\dataProdController as User_dataProdController;
use App\Http\Controllers\User\KendalaController as User_KendalaController;
use App\Http\Controllers\User\ProductivityController as User_ProductivityController;



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

Route::middleware(['auth', 'role:user'])->group(function() {
    Route::group(['prefix'=>'user', 'as' => 'user.'],function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard-filtered/{namasite}', [DashboardController::class, 'index_filtered'])->name('dashboard.filtered');
        Route::get('dashboard/detail/{site}', [DashboardController::class, 'show'])->name('dashboard.show');
        Route::get('dashboard/detail_filtered/', [DashboardController::class, 'show_data_filtered'])->name('dashboard.show.filtered');
        Route::resource('data-prod', User_dataProdController::class);
        Route::get('data-prod-report', [User_dataProdController::class, 'report'])->name('data-prod.report');
        Route::post('data-prod-report', [dataProdController::class, 'report'])->name('data-prod.report.post');
        Route::post('detail-pit', [User_dataProdController::class, 'getPit'])->name('data-prod.getPit');
        Route::resource('productivity', User_ProductivityController::class);
        Route::resource('kendala', User_KendalaController::class);        
        Route::post('/comment/store', [CommentController::class, 'store'])->name('comments.store');        
        Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.store');        
        Route::resource('profil', ProfilController::class);        
        Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');
        Route::put('change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');
        Route::post('search', [SearchController::class, 'index'])->name('search.index');
        Route::get('transfer-pma', [TransferController::class, 'index'])->name('transferPma.index');
        Route::resource('productivity_coal', ProductivityCoalController::class);

    });
});

Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::group(['prefix'=>'admin', 'as' => 'admin.'],function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard-filtered/{namasite}', [DashboardController::class, 'index_filtered'])->name('dashboard.filtered');
        Route::get('dashboard/detail/{site}', [DashboardController::class, 'show'])->name('dashboard.show');
        Route::get('dashboard/detail_filtered/', [DashboardController::class, 'show_data_filtered'])->name('dashboard.show.filtered');
        Route::resource('data-prod', Admin_dataProdController::class);
        Route::post('data-prod-edit', [Admin_dataProdController::class, 'switch_site'])->name('switch_site.index');        
        Route::get('data-prod/create_data/{tgl}', [Admin_dataProdController::class, 'create_data'])->name('create_data.index');
        Route::put('data-prod/update_data/{data_prod}', [Admin_dataProdController::class, 'update_data'])->name('update_data.index');
        Route::get('data-prod/{id}/{tgl}/{other}', [Admin_dataProdController::class, 'edit_data'])->name('edit_data_other.index');
        Route::get('data-prod-report', [Admin_dataProdController::class, 'report'])->name('data-prod.report');
        Route::post('data-prod-report', [Admin_dataProdController::class, 'report'])->name('data-prod.report.post');

        Route::post('detail-pit', [Admin_dataProdController::class, 'getPit'])->name('data-prod.getPit');
        Route::resource('productivity', ProductivityController::class);
        Route::post('productivity_check', [ProductivityController::class, 'check'])->name('productivity.check');
        Route::post('productivity_store', [ProductivityController::class, 'store_data'])->name('productivity.store_data');
        
        Route::resource('productivity_coal', ProductivityCoalController::class);
        Route::post('productivity_check_coal', [ProductivityCoalController::class, 'check'])->name('productivity_coal.check');
        Route::post('productivity_store_coal', [ProductivityCoalController::class, 'store_data'])->name('productivity_coal.store_data');
        
        Route::resource('kendala', Admin_KendalaController::class);        
        Route::post('/comment/store', [CommentController::class, 'store'])->name('comments.store');        
        Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.store');        
        Route::resource('profil', ProfilController::class);        
        Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');        
        Route::put('change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');        
        Route::post('search', [SearchController::class, 'index'])->name('search.index');
        // Transfer PMA
        Route::get('transfer-pma', [TransferController::class, 'index'])->name('transferPma.index');
        Route::post('transfer-pma', [TransferController::class, 'store'])->name('transferPma.store');
        Route::put('transfer-pma', [TransferController::class, 'update'])->name('transferPma.update');
        Route::post('transfer-pma-upload',  [UploadController::class, 'store'])->name('upload.store');
    });
});

Route::middleware(['auth', 'role:super_admin'])->group(function() {
    Route::group(['prefix'=>'super_admin', 'as' => 'super_admin.'],function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard-filtered/{namasite}', [DashboardController::class, 'index_filtered'])->name('dashboard.filtered');
        Route::get('dashboard/detail/{site}', [DashboardController::class, 'show'])->name('dashboard.show');
        Route::get('dashboard/detail_filtered/', [DashboardController::class, 'show_data_filtered'])->name('dashboard.show.filtered');

        Route::resource('data-prod', dataProdController::class);
        Route::get('data-prod-excel-generator', [dataProdController::class, 'export_data'])->name('export_data.index');
        Route::get('data-prod/create_data/{tgl}', [dataProdController::class, 'create_data'])->name('create_data.index');
        Route::put('data-prod/update_data/{data_prod}', [dataProdController::class, 'update_data'])->name('update_data.index');
        Route::get('data-prod/{id}/{tgl}/{other}', [dataProdController::class, 'edit_data'])->name('edit_data_other.index');
        Route::get('data-prod-report', [dataProdController::class, 'report'])->name('data-prod.report');
        Route::post('data-prod-report', [dataProdController::class, 'report'])->name('data-prod.report.post');
        Route::post('detail-pit', [dataProdController::class, 'getPit'])->name('data-prod.getPit');


        Route::resource('productivity', ProductivityController::class);
        Route::post('productivity_filter', [ProductivityController::class, 'index'])->name('productivity.filter');


        Route::post('productivity_check', [ProductivityController::class, 'check'])->name('productivity.check');
        Route::post('productivity_store', [ProductivityController::class, 'store_data'])->name('productivity.store_data');
        Route::get('productivity-create-page', [ProductivityController::class, 'create_page'])->name('productivity-create.index');
        

        Route::resource('productivity_coal', ProductivityCoalController::class);
        Route::post('productivity_coal_report', [ProductivityCoalController::class, 'index'])->name('productivity_coal.report');
        Route::post('productivity_check_coal', [ProductivityCoalController::class, 'check'])->name('productivity_coal.check');
        Route::post('productivity_store_coal', [ProductivityCoalController::class, 'store_data'])->name('productivity_coal.store_data');
        
        Route::resource('kendala', KendalaController::class);
        Route::post('/comment/store', [CommentController::class, 'store'])->name('comments.store');
        Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.store');
        Route::resource('profil', ProfilController::class);
        Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');
        Route::put('change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');
        Route::post('search', [SearchController::class, 'index'])->name('search.index');
        
        // Transfer PMA
        Route::get('transfer-pma', [TransferController::class, 'index'])->name('transferPma.index');
        Route::post('transfer-pma', [TransferController::class, 'store'])->name('transferPma.store');
        Route::put('transfer-pma', [TransferController::class, 'update'])->name('transferPma.update');
        Route::post('transfer-pma-upload',  [UploadController::class, 'store'])->name('upload.store');
        Route::get('admin-transfer-pma',  [AdminTransaksiPmaController::class, 'index'])->name('adminTransaksiPma.index');

        // Status Breakdown
        Route::resource('bd-harian', BDHarianController::class);
        Route::post('bd-harian/delete/{id}', [BDHarianController::class, 'deleteData'])->name('bd-harian.delete');
        Route::post('bd-harian-dok/delete/{id}', [BDDokController::class, 'deleteData'])->name('bd-harian-dok.delete');
        Route::post('bd-harian-filter', [BDHarianController::class, 'index'])->name('bd-harian.filter');
        Route::post('bd-harian-show-filter', [BDHarianController::class, 'showFilter'])->name('bd-harian-show.filter');
        Route::get('bd-harian-detail/{bd_harian}', [BDHarianController::class, 'detail'])->name('bd-harian-detail.index');
        Route::resource('bd-harian-dok', BDDokController::class);
        Route::post('bd-harian-show-model', [BDHarianController::class, 'showModel'])->name('showModel.index');

        // PO
        Route::resource('po-harian', POController::class);
        Route::get('po-harian-show', [POController::class, 'show'])->name('po-harian-show.index');
        Route::get('po-harian-show/{id?}', [POController::class, 'show'])->where('id', '.*')->name('po-harian-show.example');
        Route::post('po-harian/delete/{id}', [POController::class, 'deleteData'])->name('po-harian.delete');

        // PO Transaksi 
        Route::resource('po-transaksi-harian', POTransaksiController::class);
        Route::post('po-transaksi-harian/delete/{id}', [POTransaksiController::class, 'deleteData'])->name('po-transaksi-harian.delete');

        // Mohh harian
        Route::get('mohh-harian', [MohhController::class, 'index'])->name('mohh.index');
        Route::post('mohh-harian', [MohhController::class, 'index'])->name('mohh.post');

        // Report Harian
        Route::get('rep-harian', [RepHarController::class, 'index'])->name('rep.index');
        Route::post('rep-harian', [RepHarController::class, 'index'])->name('rep.post');

        // Populasi Unit
        Route::resource('populasi-unit', PopulasiUnitController::class);
        Route::post('/populasi-unit/showUser', [PopulasiUnitController::class, 'getUserbyid'])->name('populasi-unit.showUser');
        Route::post('populasi_unit_filter', [PopulasiUnitController::class, 'index'])->name('populasi_unit.filter');


        // Historical Unit
        Route::resource('historical-unit', HistoricalUnitController::class);
        Route::post('historical-unit-filter', [HistoricalUnitController::class, 'index'])->name('historical-unit.filter');
        Route::post('historical-unit-show-filter', [HistoricalUnitController::class, 'showFilter'])->name('historical-unit-show.filter');

        // Pap
        Route::resource('pap', PapController::class);
        Route::post('pap-filter', [PapController::class, 'index'])->name('pap.filter');
    });
});


Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard-filtered/{namasite}', [DashboardController::class, 'index_filtered'])->name('dashboard.filtered');
        Route::get('dashboard/detail/{site}', [DashboardController::class, 'show'])->name('dashboard.show');
        Route::get('dashboard/detail_filtered/', [DashboardController::class, 'show_data_filtered'])->name('dashboard.show.filtered');
        Route::resource('data-prod', dataProdController::class);
        Route::get('data-prod-excel-generator', [dataProdController::class, 'export_data'])->name('export_data.index');
        Route::get('data-prod/create_data/{tgl}', [dataProdController::class, 'create_data'])->name('create_data.index');
        Route::put('data-prod/update_data/{data_prod}', [dataProdController::class, 'update_data'])->name('update_data.index');
        Route::get('data-prod/{id}/{tgl}/{other}', [dataProdController::class, 'edit_data'])->name('edit_data_other.index');
        Route::get('data-prod-report', [dataProdController::class, 'report'])->name('data-prod.report');
        Route::post('data-prod-report', [dataProdController::class, 'report'])->name('data-prod.report.post');
        Route::post('detail-pit', [dataProdController::class, 'getPit'])->name('data-prod.getPit');
        Route::get('data-prod-filter', [dataProdController::class, 'index'])->name('data-prod.filter');

        Route::resource('productivity', ProductivityController::class);
        Route::post('productivity_filter', [ProductivityController::class, 'index'])->name('productivity.filter');
        Route::get('productivity-create-page', [ProductivityController::class, 'create_page'])->name('productivity-create.index');


        Route::post('productivity_check', [ProductivityController::class, 'check'])->name('productivity.check');
        Route::post('productivity_store', [ProductivityController::class, 'store_data'])->name('productivity.store_data');
        
        Route::resource('productivity_coal', ProductivityCoalController::class);
        Route::post('productivity_coal_report', [ProductivityCoalController::class, 'index'])->name('productivity_coal.report');
        Route::post('productivity_check_coal', [ProductivityCoalController::class, 'check'])->name('productivity_coal.check');
        Route::post('productivity_store_coal', [ProductivityCoalController::class, 'store_data'])->name('productivity_coal.store_data');
        
        Route::resource('kendala', KendalaController::class);
        Route::post('/kendala-filter', [KendalaController::class, 'index'])->name('kendala.filter');
        Route::post('/comment/store', [CommentController::class, 'store'])->name('comments.store');
        Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.store');
        Route::resource('profil', ProfilController::class);
        Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');
        Route::put('change-password', [ChangePasswordController::class, 'update'])->name('change-password.update');
        Route::post('search', [SearchController::class, 'index'])->name('search.index');
        
        // Transfer PMA
        Route::get('transfer-pma', [TransferController::class, 'index'])->name('transferPma.index');
        Route::post('transfer-pma', [TransferController::class, 'store'])->name('transferPma.store');
        Route::put('transfer-pma', [TransferController::class, 'update'])->name('transferPma.update');
        Route::post('transfer-pma-upload',  [UploadController::class, 'store'])->name('upload.store');
        Route::get('admin-transfer-pma',  [AdminTransaksiPmaController::class, 'index'])->name('adminTransaksiPma.index');

        // Status Breakdown
        Route::resource('bd-harian', BDHarianController::class);
        Route::post('bd-harian/delete/{id}', [BDHarianController::class, 'deleteData'])->name('bd-harian.delete');
        Route::post('bd-harian-dok/delete/{id}', [BDDokController::class, 'deleteData'])->name('bd-harian-dok.delete');
        Route::post('bd-harian-filter', [BDHarianController::class, 'index'])->name('bd-harian.filter');
        Route::post('bd-harian-show-filter', [BDHarianController::class, 'showFilter'])->name('bd-harian-show.filter');
        Route::get('bd-harian-detail/{bd_harian}', [BDHarianController::class, 'detail'])->name('bd-harian-detail.index');
        Route::resource('bd-harian-dok', BDDokController::class);
        Route::post('bd-harian-show-model', [BDHarianController::class, 'showModel'])->name('showModel.index');

        // PO
        Route::resource('po-harian', POController::class);
        Route::post('po-harian/delete/{id}', [POController::class, 'deleteData'])->name('po-harian.delete');

        // PO Transaksi 
        Route::resource('po-transaksi-harian', POTransaksiController::class);
        Route::post('po-transaksi-harian/delete/{id}', [POTransaksiController::class, 'deleteData'])->name('po-transaksi-harian.delete');

        // Mohh harian
        Route::get('mohh-harian', [MohhController::class, 'index'])->name('mohh.index');
        Route::post('mohh-harian', [MohhController::class, 'index'])->name('mohh.post');

        // Report Harian
        Route::get('rep-harian', [RepHarController::class, 'index'])->name('rep.index');
        Route::post('rep-harian', [RepHarController::class, 'index'])->name('rep.post');

        // Populasi Unit
        Route::resource('populasi-unit', PopulasiUnitController::class);
        Route::post('/populasi-unit/showUser', [PopulasiUnitController::class, 'getUserbyid'])->name('populasi-unit.showUser');
        Route::post('populasi_unit_filter', [PopulasiUnitController::class, 'index'])->name('populasi_unit.filter');


        // Historical Unit
        Route::resource('historical-unit', HistoricalUnitController::class);
        Route::post('historical-unit-filter', [HistoricalUnitController::class, 'index'])->name('historical-unit.filter');
        Route::post('historical-unit-show-filter', [HistoricalUnitController::class, 'showFilter'])->name('historical-unit-show.filter');

        // Pap
        Route::resource('pap', PapController::class);
        Route::post('pap-filter', [PapController::class, 'index'])->name('pap.filter');
        Route::post('pap-get-bagian', [PapController::class, 'getPapBagian'])->name('pap.getPapBagian');
});
