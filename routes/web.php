<?php

use App\Http\Controllers\A2B_PtyUnitPerTipe;
use App\Http\Controllers\A2B_PtyUnitPerUnit;
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
use App\Http\Controllers\BDDokController;
use App\Http\Controllers\BDHarianController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CostPartController;
use App\Http\Controllers\CostPartTipeController;
use App\Http\Controllers\CostUnitController;
use App\Http\Controllers\DailyProduksiController;
use App\Http\Controllers\DistanceBulananController;
use App\Http\Controllers\DistanceHarianController;
use App\Http\Controllers\DistributionA2BController;
use App\Http\Controllers\DistributionTpController;
use App\Http\Controllers\DokumenGrController;
use App\Http\Controllers\FleetSettingController;
use App\Http\Controllers\FuelDailyController;
use App\Http\Controllers\FuelUnitBulananController;
use App\Http\Controllers\FuelUnitBulananInTransController;
use App\Http\Controllers\FuelUnitController;
use App\Http\Controllers\FuelUnitHarianController;
use App\Http\Controllers\FuelUnitPerBulanController;
use App\Http\Controllers\FuelUnitPerPeriodeController;
use App\Http\Controllers\generatePlanController;
use App\Http\Controllers\generateTCController;
use App\Http\Controllers\HistoricalOvhController;
use App\Http\Controllers\HistoricalUnitController;
use App\Http\Controllers\HMController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JointSurveyController;
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\LaporanTargetCustomer;
use App\Http\Controllers\MABulananController;
use App\Http\Controllers\MaHarianController;
use App\Http\Controllers\MohhController;
use App\Http\Controllers\MonthlyProductionController;
use App\Http\Controllers\MPController;
use App\Http\Controllers\MPKontrakController;
use App\Http\Controllers\MPStatistikController;
use App\Http\Controllers\PapController;
use App\Http\Controllers\POController;
use App\Http\Controllers\PopulasiDOController;
use App\Http\Controllers\PopulasiUnitController;
use App\Http\Controllers\POTransaksiController;
use App\Http\Controllers\ProductivityCoalController;
use App\Http\Controllers\ProduksiCustomerJointSurveyController;
use App\Http\Controllers\ProduksiInvoiceJointSurveyController;
use App\Http\Controllers\ProduksiOBPerPitPMAController;
use App\Http\Controllers\ProduksiOBTCPMAController;
use App\Http\Controllers\ProduksiTruckCountPMAController;
use App\Http\Controllers\PtyA2BController;
use App\Http\Controllers\PtyTpController;
use App\Http\Controllers\RainSlipController;
use App\Http\Controllers\readDBFController;
use App\Http\Controllers\RepHarController;
use App\Http\Controllers\SolarInTransController;
use App\Http\Controllers\SolarOpnameController;
use App\Http\Controllers\SolarRsspIntransController;
use App\Http\Controllers\SparePartInTransController;
use App\Http\Controllers\SparePartRsspController;
use App\Http\Controllers\TP_PtyUnitPerTipe;
use App\Http\Controllers\TP_PtyUnitPerUnit;
// User
use App\Http\Controllers\User\dataProdController as User_dataProdController;
use App\Http\Controllers\User\KendalaController as User_KendalaController;
use App\Http\Controllers\User\ProductivityController as User_ProductivityController;
use App\Http\Controllers\VersatilityController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        Route::resource('historical-overhaul', HistoricalOvhController::class);


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
        Route::resource('historical-overhaul', HistoricalOvhController::class);

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
        Route::get('productivity_filter', [ProductivityController::class, 'index'])->name('productivity.filter');


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
        Route::resource('mohh-harian', MohhController::class);

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

        // Historical Overhaul
        Route::resource('historical-overhaul', HistoricalOvhController::class);

        // Pap
        Route::resource('pap', PapController::class);
        Route::post('pap-filter', [PapController::class, 'index'])->name('pap.filter');
        
        // Dokumen GR
        Route::resource('dokumen-gr', DokumenGrController::class);

        Route::resource('historical-overhaul', HistoricalOvhController::class);

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
        Route::post('data-prod', [dataProdController::class, 'index'])->name('data-prod.filter.month');
        Route::get('data-prod-excel-generator', [dataProdController::class, 'export_data'])->name('export_data.index');
        Route::get('data-prod/create_data/{tgl}', [dataProdController::class, 'create_data'])->name('create_data.index');
        Route::put('data-prod/update_data/{data_prod}', [dataProdController::class, 'update_data'])->name('update_data.index');
        Route::get('data-prod/{id}/{tgl}/{other}', [dataProdController::class, 'edit_data'])->name('edit_data_other.index');
        Route::get('data-prod-report', [dataProdController::class, 'report'])->name('data-prod.report');
        Route::post('data-prod-report', [dataProdController::class, 'report'])->name('data-prod.report.post');
        Route::post('detail-pit', [dataProdController::class, 'getPit'])->name('data-prod.getPit');
        Route::get('data-prod-filter', [dataProdController::class, 'index'])->name('data-prod.filter');
        Route::get('data-prod-export', [dataProdController::class, 'export'])->name('data-prod.export');
        Route::get('data-prod-export-all', [dataProdController::class, 'export_all'])->name('data-prod.all.export');

        Route::resource('productivity', ProductivityController::class);
        Route::post('productivity_filter', [ProductivityController::class, 'index'])->name('productivity.filter');
        Route::get('productivity-create-page', [ProductivityController::class, 'create_page'])->name('productivity-create.index');
        Route::post('productivity-import-excel', [ProductivityController::class, 'import_excel'])->name('productivity.import-excel');

        Route::post('productivity_check', [ProductivityController::class, 'check'])->name('productivity.check');
        Route::post('productivity_check_massal', [ProductivityController::class, 'check_massal'])->name('productivity.check_massal');
        Route::post('productivity_store', [ProductivityController::class, 'store_data'])->name('productivity.store_data');
        
        Route::resource('productivity_coal', ProductivityCoalController::class);
        Route::post('productivity_coal_report', [ProductivityCoalController::class, 'index'])->name('productivity_coal.report');
        Route::post('productivity_check_coal', [ProductivityCoalController::class, 'check'])->name('productivity_coal.check');
        Route::post('productivity_store_coal', [ProductivityCoalController::class, 'store_data'])->name('productivity_coal.store_data');
        Route::post('productivity-coal-import', [ProductivityCoalController::class, 'import_excel'])->name('productivity_coal.import-excel');
        
        Route::resource('kendala', KendalaController::class);
        Route::post('/kendala-filter', [KendalaController::class, 'index'])->name('kendala.filter');
        Route::post('kendala-import', [KendalaController::class, 'import_excel'])->name('kendala.import');
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
        Route::resource('mohh-harian', MohhController::class);

        // Report Harian
        Route::get('rep-harian', [RepHarController::class, 'index'])->name('rep.index');
        Route::post('rep-harian', [RepHarController::class, 'index'])->name('rep.post');
        Route::post('rep-harian-add', function (){
            // TODO: NOM UNIT
            $data['nom_unit'] = DB::table('plant_populasi')->select('nom_unit')->where('del', '=', 0)->where('kodesite','=',Auth::user()->kodesite)->get(); 
            dd($data);
            // TODO: PIT
            
            return response()->json($data);
        });

        // Populasi Unit
        Route::resource('populasi-unit', PopulasiUnitController::class);
        Route::post('/populasi-unit/showUser', [PopulasiUnitController::class, 'getUserbyid'])->name('populasi-unit.showUser');
        Route::post('populasi_unit_filter', [PopulasiUnitController::class, 'index'])->name('populasi_unit.filter');


        // Historical Unit
        Route::resource('historical-unit', HistoricalUnitController::class);
        Route::post('historical-unit-filter', [HistoricalUnitController::class, 'index'])->name('historical-unit.filter');
        Route::post('historical-unit-show-filter', [HistoricalUnitController::class, 'showFilter'])->name('historical-unit-show.filter');
        Route::get('historical-unit-show/{id?}', [HistoricalUnitController::class, 'show'])->where('id', '.*')->name('historical-unit.show.example');

        // Historical Overhaul
        Route::resource('historical-overhaul', HistoricalOvhController::class);
        Route::post('historical-ovh-filter', [HistoricalOvhController::class, 'showFilter'])->name('historical-ovh-show.filter');
        

        // Pap
        Route::resource('pap', PapController::class);
        Route::post('pap-filter', [PapController::class, 'index'])->name('pap.filter');
        Route::post('pap-get-bagian', [PapController::class, 'getPapBagian'])->name('pap.getPapBagian');
        Route::post('pap', [PapController::class, 'index'])->name('pap.showFilter');
        
        // Dokumen GR
        Route::resource('dokumen-gr', DokumenGrController::class);

        // Testing
        Route::get('testing', [PapController::class, 'testingDropzone'])->name('pap.testing');
        Route::post('post-testing', [PapController::class, 'postDropzone'])->name('pap.testing.store');

        // HM Controller
        Route::resource('hm', HMController::class);
        Route::get('hm/edit_data/{id}', [HMController::class, 'edit_data'])->name('hm.edit.data');
        Route::put('hm/update_data/{id}', [HMController::class, 'update_data'])->name('hm.update.data');

        // MP Controller
        Route::resource('mp', MPController::class);

        // MP KONTRAK Controller
        Route::resource('mp-kontrak', MPKontrakController::class);

        // MP Statistik Controller
        Route::resource('mp-statistik', MPStatistikController::class);

        // Daily Produksi Controller - PMA TP
        Route::resource('daily-production', DailyProduksiController::class);

        // Daily Produksi Controller - PMA TP
        Route::resource('monthly-production', MonthlyProductionController::class);

        // Fuel Daily Controller
        Route::resource('fuel-daily', FuelDailyController::class);
        
        // Fuel Unit Controller
        Route::resource('fuel-unit', FuelUnitController::class);
        
        // Cost Part Controller
        Route::resource('cost-part', CostPartController::class);

        // Cost Part Controller
        Route::resource('cost-part-tipe', CostPartTipeController::class);

        // Laporan Bulanan Controller
        Route::resource('laporan-bulanan', LaporanBulananController::class);

        // Laporan Customer Controller
        Route::resource('laporan-customer', LaporanTargetCustomer::class);

        // DO Controller
        Route::resource('populasi-do', PopulasiDOController::class);

        // Versatility Controller
        Route::resource('versatility', VersatilityController::class);
        
        // Distance Harian Controller
        Route::resource('distance-harian', DistanceHarianController::class);

        // Distance Bulanan Controller
        Route::resource('distance-bulanan', DistanceBulananController::class);

        // PTY TP per Nomor Unit Controller
        Route::resource('tp-pty-nom', TP_PtyUnitPerUnit::class);

        // PTY TP per Tipe Unit Controller
        Route::resource('tp-pty-tipe', TP_PtyUnitPerTipe::class);
        
        // PTY A2B per Nomor Unit Controller
        Route::resource('a2b-pty-nom', A2B_PtyUnitPerUnit::class);
        
        // PTY A2B per Tipe Unit Controller
        Route::resource('a2b-pty-tipe', A2B_PtyUnitPerTipe::class);

        // Fleet Setting Controller
        Route::resource('fleet-setting', FleetSettingController::class);

        // Invoice Controller
        Route::resource('invoice', InvoiceController::class);

        // Joint Survey Setting Controller
        Route::resource('joint-survey', JointSurveyController::class);

        // Budget Controller Setting Controller
        Route::resource('budget', BudgetController::class);

        // Solar In Trans Setting Controller
        Route::resource('solar-in-trans', SolarInTransController::class);

        // Solar Opname Controller
        Route::resource('solar-opname', SolarOpnameController::class);
        
        // Spare Part In Trans Controller
        Route::resource('spare-part-in-trans', SparePartInTransController::class);

        // Spare Part Po Controller
        Route::resource('spare-part-rssp', SparePartRsspController::class);

        // Solar Part Rssp In Trans Controller
        Route::resource('solar-in-trans-rssp', SolarRsspIntransController::class);

        // Generate TC
        Route::get('generate-tc', [generateTCController::class, 'index'])->name('generateTc.index');
        Route::post('generate-tc', [generateTCController::class, 'store'])->name('generateTc.store');
        
        // Generate Plan
        Route::get('generate-plan', [generatePlanController::class, 'index'])->name('generatePlan.index');
        Route::post('generate-plan', [generatePlanController::class, 'store'])->name('generatePlan.store');

        // Read DBF
        Route::get('read-dbf', [readDBFController::class, 'index'])->name('dbf.index');

        // Hours Distribution TP
        Route::resource('hours-distribution-tp', DistributionTpController::class);
        
        // Hours Distribution A2B
        Route::resource('hours-distribution-a2b', DistributionA2BController::class);

        // MA Bulanan 
        Route::resource('ma-bulanan', MABulananController::class);

        // MA Bulanan 
        Route::resource('ma-harian', MaHarianController::class);

        // PTY TP 
        Route::resource('pty-tp', PtyTpController::class);
        
        // PTY TP 
        Route::resource('pty-a2b', PtyA2BController::class);

        // Produksi Invoice Joint Survey
        Route::resource('invoice-joint-survey', ProduksiInvoiceJointSurveyController::class);

        // Produksi Customer Target
        Route::resource('customer-joint-survey', ProduksiCustomerJointSurveyController::class);

        // Produksi Truck Count PMA
        Route::resource('tc-pma', ProduksiTruckCountPMAController::class);

        // Produksi OB Per Pit
        Route::resource('produksi-ob-per-pit-pma', ProduksiOBPerPitPMAController::class);

        // Produksi OB TC PMA
        Route::resource('produksi-ob-tc-pma', ProduksiOBTCPMAController::class);

        // Fuel Unit Per Bulan
        Route::resource('Fuel-unit-per-bulanan', FuelUnitPerBulanController::class);

        // Fuel Unit Per Harian
        Route::resource('Fuel-unit-harian', FuelUnitHarianController::class);
        
        // Fuel Unit Bulanan
        Route::resource('Fuel-unit-bulanan', FuelUnitBulananController::class);

        // Fuel Unit Per Periode
        Route::resource('Fuel-unit-periode', FuelUnitPerPeriodeController::class);

        // Fuel Unit Per In Trans
        Route::resource('Fuel-unit-in-trans', FuelUnitBulananInTransController::class);
        
        // Cost Unit
        Route::resource('cost-unit', CostUnitController::class);
        
        // MOHH 
        Route::resource('mohh', MohhController::class);

        // Rain Slip
        Route::resource('rain-slip', RainSlipController::class);        
});
