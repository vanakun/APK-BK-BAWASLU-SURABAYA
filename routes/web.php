<?php

use App\Http\Controllers\Admin\AduanDpdRiController;
use App\Http\Controllers\Admin\AduanDprRiController;
use App\Http\Controllers\Admin\AduanPresidenWakilPresidenController;
use App\Http\Controllers\Admin\CalonDpdRiController;
use App\Http\Controllers\Admin\CalonDprdKotaController;
use App\Http\Controllers\Admin\CalonDprdProvinsiController;
use App\Http\Controllers\Admin\CalonDprRiController;
use App\Http\Controllers\Admin\PartaiController;
use App\Http\Controllers\Admin\PresidenWakilPresidenController;
use App\Http\Controllers\Admin\AduanDprdProvinsiController;
use App\Http\Controllers\Admin\AduanDprdKabupatenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\StepController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Tenagaahli\TenagaahliController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\Admin\CetakController;





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





Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'loginView'])->name('login.index');
    Route::post('login', [LoginController::class, 'login'])->name('login.check');
    Route::get('register', [AuthController::class, 'registerView'])->name('register.index');
    Route::post('registerStore', [AuthController::class, 'registerStore'])->name('register.store');
});
Route::middleware('auth')->group(function() {
    
    // Contoh: Rute admin
    Route::middleware('role:Admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('adminDashboard');
        Route::get('/chart-aduan-presiden-status', [AdminController::class, 'getAduanPresidenByStatus']);

        Route::prefix('antrian')->group(function () {

            Route::get('/aduan', [AdminController::class, 'indexAntrian'])->name('indexAntrian');
            Route::get('/setting-pemilihan', [AdminController::class, 'SettingPemilihan'])->name('SettingPemilihan');

            Route::get('/setting-tahun-pemilihan', [AdminController::class, 'SettingTahunPemilihan'])->name('SettingTahunPemilihan');
            Route::get('/create-tahun-pemilihan', [AdminController::class, 'createTahunPemilihan'])->name('createTahunPemilihan');
            Route::post('/store-tahun-pemilihan', [AdminController::class, 'storeTahunPemilihan'])->name('storeTahunPemilihan');
            Route::delete('/tahun-pemilihan/{id}', [AdminController::class, 'destroyTahunPemilihan'])->name('destroyTahunPemilihan');
            Route::get('/edit/tahun-pemilihan/{id}', [AdminController::class, 'editTahunPemilihan'])->name('editTahunPemilihan');
            Route::put('/tahun-pemilihan/{id}', [AdminController::class, 'updateTahunPemilihan'])->name('updateTahunPemilihan');
            Route::post('/tahun-pemilihan-aktif', [AdminController::class, 'updatetahunpemilianaktif'])->name('updatetahunpemilianaktif');
            
            Route::get('/show-partai', [PartaiController::class, 'indexpartai'])->name('indexpartai');
            Route::get('/create-partai', [PartaiController::class, 'createpartai'])->name('createpartai');
            Route::post('/store-partai', [PartaiController::class, 'storepartai'])->name('storepartai');
            Route::get('/partai/{id}', [PartaiController::class, 'showpartai'])->name('showpartai');
            Route::get('/edit/partai/{id}', [PartaiController::class, 'editpartai'])->name('editpartai');
            Route::put('/partai-update/{id}', [PartaiController::class, 'updatepartai'])->name('partai.update');
            Route::delete('/partai/{id}', [PartaiController::class, 'destroy'])->name('partai.destroy');

            Route::resource('presiden-wakil-presiden', PresidenWakilPresidenController::class);
            Route::get('/show-presiden', [PresidenWakilPresidenController::class, 'indexPresiden'])->name('indexPresiden');
            Route::get('/create-presiden', [PresidenWakilPresidenController::class, 'createpresiden'])->name('createpresiden');
            Route::post('/store-presiden-wakil', [PresidenWakilPresidenController::class, 'storePresiden'])->name('storePresiden');
            Route::get('/edit/presidenwakil/{id}', [PresidenWakilPresidenController::class, 'editPresiden'])->name('editPresiden');
            
            
            Route::resource('calon_dpr_ri', CalonDprRiController::class);
            Route::get('/show-calon-dpr-ri', [CalonDprRiController::class, 'indexDprRi'])->name('indexDprRi');
            Route::get('/create-calon-dpr-ri', [CalonDprRiController::class, 'createDprRi'])->name('createDprRi');
            Route::post('/store-calon-dpr-ri', [CalonDprRiController::class, 'StoreDprRi'])->name('StoreDprRi');
            Route::get('/edit/calon-dpr-ri/{id}', [CalonDprRiController::class, 'editDprRI'])->name('editDprRI');
            Route::put('/calon-dpr-ri/{id}', [CalonDprRiController::class, 'updateDprRi'])->name('updateDprRi');

            Route::resource('calon_dpd_ri', CalonDpdRiController::class);
            Route::resource('calon_dprd_provinsi', CalonDprdProvinsiController::class);
            Route::resource('calon-dprd-kota',CalonDprdKotaController::class);

            Route::resource('aduan_presiden_wakil_presiden', AduanPresidenWakilPresidenController::class);
            Route::get('/aduan/presiden-wakil', [AduanPresidenWakilPresidenController::class, 'indexAntrianPresidenwakil'])->name('indexAntrianPresidenwakil');
            Route::get('/edit-presiden-wakil/{id}', [AduanPresidenWakilPresidenController::class, 'editaduanpresidenwakil'])->name('editaduanpresidenwakil');
            Route::post('/update/presiden-wakil/{id}', [AduanPresidenWakilPresidenController::class, 'updateAduanPresidenWakil'])->name('updateAduanPresidenWakil');
            Route::get('/insert-queue-presiden-wakil/{id}', [AduanPresidenWakilPresidenController::class, 'insertqueuePresidenWakil'])->name('insertqueuePresidenWakil');
            Route::post('/update-queue/presiden-wakil/{id}', [AduanPresidenWakilPresidenController::class, 'updatequeuePresidenWakil'])->name('updatequeuePresidenWakil');
            Route::get('/aduan-presiden/cetak', [AduanPresidenWakilPresidenController::class, 'cetak'])->name('aduan.presiden.cetak');


            Route::resource('aduan_dpd_ri', AduanDpdRiController::class);
            Route::get('/aduan/dpd', [AduanDpdRiController::class, 'indexAntriandpd'])->name('indexAntriandpd');
            Route::get('/insert-queue-dpd/{id}', [AduanDpdRiController::class, 'insertqueuedpd'])->name('insertqueuedpd');
            Route::post('/update-queue/dpd/{id}', [AduanDpdRiController::class, 'updatequeuedpd'])->name('updatequeuedpd');
            Route::get('/edit-dpd/{id}', [AduanDpdRiController::class, 'editaduandpd'])->name('editaduandpd');
            Route::post('/update/dpd/{id}', [AduanDpdRiController::class, 'updateAduandpd'])->name('updateAduandpd');
            Route::get('/aduan-dpd-ri/cetak', [AduanDpdRiController::class, 'cetak'])->name('aduan.dpd-ri.cetak');

            Route::resource('aduan_dpr_ri', AduanDprRiController::class);
            Route::get('/aduan/dpr', [AduanDprRiController::class, 'indexAntrianDPR'])->name('indexAntrianDPR');
            Route::get('/insert-queue-dpr/{id}', [AduanDprRiController::class, 'insertqueuedpr'])->name('insertqueuedpr');
            Route::post('/update-queue/dpr/{id}', [AduanDprRiController::class, 'updatequeuedpr'])->name('updatequeuedpr');
            Route::get('/edit-dpr/{id}', [AduanDprRiController::class, 'editaduandpr'])->name('editaduandpr');
            Route::post('/update/dpr/{id}', [AduanDprRiController::class, 'updateAduandpr'])->name('updateAduandpr');
            Route::get('/aduan-dpr-ri/cetak', [AduanDprRiController::class, 'cetak'])->name('aduan.dpr-ri.cetak');

            Route::resource('aduan_dprd_provinsi', AduanDprdProvinsiController::class);
            Route::get('/aduan/dprd-provinsi', [AduanDprdProvinsiController::class, 'indexAntrianDprdProvinsi'])->name('indexAntrianDprdProvinsi');
            Route::get('/insert-queue-dprd-provinsi/{id}', [AduanDprdProvinsiController::class, 'insertqueuedprdprovinsi'])->name('insertqueuedprdprovinsi');
            Route::post('/update-queue/dprd-provinsi/{id}', [AduanDprdProvinsiController::class, 'updatequeuedprdprovinsi'])->name('updatequeuedprdprovinsi');
            Route::get('/edit-dprd-provinsi/{id}', [AduanDprdProvinsiController::class, 'editaduandprdprovinsi'])->name('editaduandprdprovinsi');
            Route::post('/update/dprd-provinsi/{id}', [AduanDprdProvinsiController::class, 'updateAduandprdprovinsi'])->name('updateAduandprdprovinsi');
            Route::get('/aduan-dprd-provinsi/cetak', [AduanDprdProvinsiController::class, 'cetak'])->name('aduan.dprd-provinsi.cetak');

            Route::resource('aduan_dprd_kabupaten', AduanDprdKabupatenController::class);
            Route::get('/aduan/dprd-kabupaten-kota', [AduanDprdKabupatenController::class, 'indexAntrianDprdKabupaten'])->name('indexAntrianDprdKabupaten');
            Route::get('/insert-queue-dprd-kabupaten-kota/{id}', [AduanDprdKabupatenController::class, 'insertqueuedprdkabupaten'])->name('insertqueuedprdkabupaten');
            Route::post('/update-queue/dprd-kabupaten-kota/{id}', [AduanDprdKabupatenController::class, 'updatequeuedprdkabupaten'])->name('updatequeuedprdkabupaten');
            Route::get('/edit-dprd-kabupaten-kota/{id}', [AduanDprdKabupatenController::class, 'editaduandprdkabupaten'])->name('editaduandprdkabupaten');
            Route::post('/update/dprd-kabupaten-kota/{id}', [AduanDprdKabupatenController::class, 'updateAduandprdkabupaten'])->name('updateAduandprdkabupaten');
            Route::get('/aduan-dprd-kabupaten/cetak', [AduanDprdKabupatenController::class, 'cetak'])->name('aduan.dprd-kabupaten.cetak');

           
        });
        // ... tambahkan rute admin lainnya di sini
    });
    // Contoh: Rute pengguna biasa (tenaga ahli)
    Route::middleware('role:User')->group(function () {
       
        Route::get('/user', [TenagaahliController::class, 'index'])->name('tenagaahliDashboard');
        Route::get('/create-surat', [TenagaahliController::class, 'createsurat'])->name('createsurat');
        Route::get('/create-aduan', [TenagaahliController::class, 'createaduan'])->name('createaduan');

        Route::resource('aduan_presiden_wakil_presiden', AduanPresidenWakilPresidenController::class);
        Route::get('/show-aduan-presiden-wakil/{id}', [TenagaahliController::class, 'showaduanPresidenWakil'])->name('showaduanPresidenWakil');

        Route::resource('aduan_dpd_ri', AduanDpdRiController::class);
        Route::get('/show-aduan-dpd/{id}', [TenagaahliController::class, 'showaduanDpd'])->name('showaduanDpd');

        Route::resource('aduan_dpr_ri', AduanDprRiController::class);
        Route::get('/show-aduan-dpr/{id}', [TenagaahliController::class, 'showaduanDpr'])->name('showaduanDpr');

        Route::resource('aduan_dprd_provinsi', AduanDprdProvinsiController::class);
        Route::get('/show-aduan-dprd-provinsi/{id}', [TenagaahliController::class, 'showaduanDprdProvinsi'])->name('showaduanDprdProvinsi');

        Route::resource('aduan_dprd_kabupaten', AduanDprdKabupatenController::class);
        Route::get('/show-aduan-dprd-kabupaten/{id}', [TenagaahliController::class, 'showaduanDprdKabupaten'])->name('showaduanDprdKabupaten');

       
        Route::get('/show/{id}/share-link', [TenagaahliController::class, 'shareLink'])->name('shareLink');
        Route::get('/show/{id}', [TenagaahliController::class, 'show'])->name('showProject');
        Route::get('/show/step/{id}', [TenagaahliController::class, 'showStep'])->name('stepProject');
        Route::get('/step/{step}', [StepController::class, 'show'])->name('showStep');
        Route::get('/add-expert/{step}', [StepController::class, 'addToStep'])->name('AddToStep');
        Route::post('/store-expert/{step}', [StepController::class, 'storeExpert'])->name('StoreExpert');
        Route::get('/show/step/add/{step}', [StepController::class, 'addToStep'])->name('isKetua');
      
        Route::get('/setting/{user}', [ProfileController::class, 'index'])->name('setting');
        Route::get('/setting/account/{user}', [ProfileController::class, 'accountSet'])->name('accountSet');
        Route::put('/setting/update-acc/{id}', [ProfileController::class, 'updateAccount'])->name('update-account');
        Route::get('/setting/changepw/{user}', [ProfileController::class, 'changePw'])->name('changePw');
        Route::post('/setting/updatepw/{id}', [ProfileController::class, 'updatePassword'])->name('update-password');
        Route::post('/step-media/{step}', [TenagaahliController::class, 'create'])->name('step-media.create');
        // ... tambahkan rute tenaga ahli lainnya di sini
    });
});


    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard-overview-2-page', [PageController::class, 'dashboardOverview2'])->name('dashboard-overview-2');
    Route::get('dashboard-overview-3-page', [PageController::class, 'dashboardOverview3'])->name('dashboard-overview-3');
    Route::get('inbox-page', [PageController::class, 'inbox'])->name('inbox');
    Route::get('file-manager-page', [PageController::class, 'fileManager'])->name('file-manager');
    Route::get('point-of-sale-page', [PageController::class, 'pointOfSale'])->name('point-of-sale');
    Route::get('chat-page', [PageController::class, 'chat'])->name('chat');
    Route::get('post-page', [PageController::class, 'post'])->name('post');
    Route::get('calendar-page', [PageController::class, 'calendar'])->name('calendar');
    Route::get('crud-data-list-page', [PageController::class, 'crudDataList'])->name('crud-data-list');
    Route::get('crud-form-page', [PageController::class, 'crudForm'])->name('crud-form');
    Route::get('users-layout-1-page', [PageController::class, 'usersLayout1'])->name('users-layout-1');
    Route::get('/users-layout-2-page', [PageController::class, 'usersLayout2'])->name('users-layout-2');
    Route::get('users-layout-3-page', [PageController::class, 'usersLayout3'])->name('users-layout-3');
    Route::get('profile-overview-1-page', [PageController::class, 'profileOverview1'])->name('profile-overview-1');
    Route::get('profile-overview-2-page', [PageController::class, 'profileOverview2'])->name('profile-overview-2');
    Route::get('profile-overview-3-page', [PageController::class, 'profileOverview3'])->name('profile-overview-3');
    Route::get('wizard-layout-1-page', [PageController::class, 'wizardLayout1'])->name('wizard-layout-1');
    Route::get('wizard-layout-2-page', [PageController::class, 'wizardLayout2'])->name('wizard-layout-2');
    Route::get('wizard-layout-3-page', [PageController::class, 'wizardLayout3'])->name('wizard-layout-3');
    Route::get('blog-layout-1-page', [PageController::class, 'blogLayout1'])->name('blog-layout-1');
    Route::get('blog-layout-2-page', [PageController::class, 'blogLayout2'])->name('blog-layout-2');
    Route::get('blog-layout-3-page', [PageController::class, 'blogLayout3'])->name('blog-layout-3');
    Route::get('pricing-layout-1-page', [PageController::class, 'pricingLayout1'])->name('pricing-layout-1');
    Route::get('pricing-layout-2-page', [PageController::class, 'pricingLayout2'])->name('pricing-layout-2');
    Route::get('invoice-layout-1-page', [PageController::class, 'invoiceLayout1'])->name('invoice-layout-1');
    Route::get('invoice-layout-2-page', [PageController::class, 'invoiceLayout2'])->name('invoice-layout-2');
    Route::get('faq-layout-1-page', [PageController::class, 'faqLayout1'])->name('faq-layout-1');
    Route::get('faq-layout-2-page', [PageController::class, 'faqLayout2'])->name('faq-layout-2');
    Route::get('faq-layout-3-page', [PageController::class, 'faqLayout3'])->name('faq-layout-3');
    Route::get('login-page', [PageController::class, 'login'])->name('login');
    Route::get('register-page', [PageController::class, 'register'])->name('register');
    Route::get('error-page-page', [PageController::class, 'errorPage'])->name('error-page');
    Route::get('update-profile-page', [PageController::class, 'updateProfile'])->name('update-profile');
    Route::get('change-password-page', [PageController::class, 'changePassword'])->name('change-password');
    Route::get('regular-table-page', [PageController::class, 'regularTable'])->name('regular-table');
    Route::get('tabulator-page', [PageController::class, 'tabulator'])->name('tabulator');
    Route::get('modal-page', [PageController::class, 'modal'])->name('modal');
    Route::get('slide-over-page', [PageController::class, 'slideOver'])->name('slide-over');
    Route::get('notification-page', [PageController::class, 'notification'])->name('notification');
    Route::get('accordion-page', [PageController::class, 'accordion'])->name('accordion');
    Route::get('button-page', [PageController::class, 'button'])->name('button');
    Route::get('alert-page', [PageController::class, 'alert'])->name('alert');
    Route::get('progress-bar-page', [PageController::class, 'progressBar'])->name('progress-bar');
    Route::get('tooltip-page', [PageController::class, 'tooltip'])->name('tooltip');
    Route::get('dropdown-page', [PageController::class, 'dropdown'])->name('dropdown');
    Route::get('typography-page', [PageController::class, 'typography'])->name('typography');
    Route::get('icon-page', [PageController::class, 'icon'])->name('icon');
    Route::get('loading-icon-page', [PageController::class, 'loadingIcon'])->name('loading-icon');
    Route::get('regular-form-page', [PageController::class, 'regularForm'])->name('regular-form');
    Route::get('datepicker-page', [PageController::class, 'datepicker'])->name('datepicker');
    Route::get('tom-select-page', [PageController::class, 'tomSelect'])->name('tom-select');
    Route::get('file-upload-page', [PageController::class, 'fileUpload'])->name('file-upload');
    Route::get('wysiwyg-editor-classic', [PageController::class, 'wysiwygEditorClassic'])->name('wysiwyg-editor-classic');
    Route::get('wysiwyg-editor-inline', [PageController::class, 'wysiwygEditorInline'])->name('wysiwyg-editor-inline');
    Route::get('wysiwyg-editor-balloon', [PageController::class, 'wysiwygEditorBalloon'])->name('wysiwyg-editor-balloon');
    Route::get('wysiwyg-editor-balloon-block', [PageController::class, 'wysiwygEditorBalloonBlock'])->name('wysiwyg-editor-balloon-block');
    Route::get('wysiwyg-editor-document', [PageController::class, 'wysiwygEditorDocument'])->name('wysiwyg-editor-document');
    Route::get('validation-page', [PageController::class, 'validation'])->name('validation');
    Route::get('chart-page', [PageController::class, 'chart'])->name('chart');
    Route::get('slider-page', [PageController::class, 'slider'])->name('slider');
    Route::get('image-zoom-page', [PageController::class, 'imageZoom'])->name('image-zoom');