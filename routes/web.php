<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RefController;
use App\Http\Controllers\api\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('home', App\Livewire\Frontend\Home::class)->name('home');
Route::get('varians', App\Livewire\Frontend\Varians::class)->name('varians');
Route::get('rentang', App\Livewire\Frontend\RentangHarga::class)->name('rentang');
Route::get('berita', App\Livewire\Frontend\Berita::class)->name('berita');
Route::get('beritadetail/{id}', App\Livewire\Frontend\DetailBerita::class)->name('beritadetail');

Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
Route::get('/auth', App\Livewire\Auth\Login::class)->name('login.auth');
Route::get('logout', App\Livewire\Auth\Logout::class)->name('logout');
Route::get('register', App\Livewire\Auth\Register::class)->name('register');
Route::get('forgot-password', App\Livewire\Auth\Forgot::class)->name('forgot');

Route::group(['middleware' => ['auth','verified','web'],'prefix' => '', 'as' => '', 'before' => 'csrf'], function () {
    
    Route::prefix('dashboard')->group(function () {
        Route::get('/',App\Livewire\Dashboard\Index::class)->name('dashboard');
        Route::get('/roleakses',App\Livewire\Dashboard\RoleAkses::class)->name('dashboard.role.akses');
        Route::get('/autologin/{level}/{id}',App\Livewire\Auth\AutoLogin::class)->name('dashboard.auto.login');
    });
    
    //Begin Master
    Route::prefix('account/user')->group(function () {
        Route::get('/',App\Livewire\Master\Kepegawaian\User\Index::class)->name('account.index');
        Route::get('add',App\Livewire\Master\Kepegawaian\User\Add::class)->name('account.create');
        Route::get('edit/{token}',App\Livewire\Master\Kepegawaian\User\Edit::class)->name('account.update');
        Route::get('akun/{token}',App\Livewire\Master\Kepegawaian\User\Akun::class)->name('account.view');
        Route::get('profile',App\Livewire\Master\Kepegawaian\User\Profile::class)->name('account.profile');
        Route::get('password',App\Livewire\Master\Kepegawaian\User\Password::class)->name('account.password');
    });
    
    Route::prefix('master/menu')->group(function () {
        Route::get('/',App\Livewire\Master\Konfigurasi\Menu\Index::class)->name('master.menu');
        Route::get('child/{id}',App\Livewire\Master\Konfigurasi\Menu\Child::class)->name('master.child');
    });
    
    Route::prefix('master/role')->group(function () {
        Route::get('/',App\Livewire\Master\Konfigurasi\Role\Index::class)->name('master.role');
        Route::get('child/{id}',App\Livewire\Master\Konfigurasi\Role\Child::class)->name('master.role.child');
    });    
    
    Route::prefix('master/utilitas')->group(function () {
        // Route::get('role',App\Livewire\Master\Konfigurasi\Role\Index::class)->name('master.role');
        // Route::get('role-child/{id}',App\Livewire\Master\Konfigurasi\Role\Child::class)->name('master.role.child');
        Route::get('satuan-kerja',App\Livewire\Master\Kepegawaian\SatuanKerja\Index::class)->name('master.satuankerja');
        Route::get('unit-kerja',App\Livewire\Master\Kepegawaian\UnitKerja\Index::class)->name('master.unitkerja');
        Route::get('jabatan',App\Livewire\Master\Kepegawaian\Jabatan\Index::class)->name('master.jabatan');
        Route::get('setting',App\Livewire\Master\Konfigurasi\Setting\Index::class)->name('master.setting');
    });    
    
    Route::prefix('master/referensi')->group(function () {
        Route::get('provinsi',App\Livewire\Master\Referensi\Wilayah\Provinsi::class)->name('master.referensi.provinsi');
        Route::get('kabupaten',App\Livewire\Master\Referensi\Wilayah\Kabupaten::class)->name('master.referensi.kabupaten');
        Route::get('kecamatan',App\Livewire\Master\Referensi\Wilayah\Kecamatan::class)->name('master.referensi.kecamatan');
        Route::get('desa',App\Livewire\Master\Referensi\Wilayah\Desa::class)->name('master.referensi.desa');
        // ROUTE MASTER SIBAPOKTING
        Route::get('komoditas',App\Livewire\Master\Referensi\Komoditas::class)->name('master.referensi.komoditas');
        Route::get('barang',App\Livewire\Master\Referensi\Barang::class)->name('master.referensi.barang');

        Route::get('pasar',App\Livewire\Master\Referensi\Pasar\Pasar::class)->name('master.referensi.pasar');
        Route::get('addpasar',App\Livewire\Master\Referensi\Pasar\AddPasar::class)->name('master.referensi.addpasar');
        Route::get('mapspasar/{id}',App\Livewire\Master\Referensi\Pasar\MapsPasar::class)->name('master.referensi.mapspasar');
        Route::get('editpasar/{id}',App\Livewire\Master\Referensi\Pasar\EditPasar::class)->name('master.referensi.editpasar');

        Route::get('distributor',App\Livewire\Master\Referensi\Distributor\Distributor::class)->name('master.referensi.distributor');
        Route::get('adddistributor',App\Livewire\Master\Referensi\Distributor\AddDistributor::class)->name('master.referensi.adddistributor');
        Route::get('mapsdistributor/{id}',App\Livewire\Master\Referensi\Distributor\MapsDistributor::class)->name('master.referensi.mapsdistributor');
        Route::get('editdistributor/{id}',App\Livewire\Master\Referensi\Distributor\EditDistributor::class)->name('master.referensi.editdistributor');

        Route::get('pupuk',App\Livewire\Master\Referensi\Pupuk\Pupuk::class)->name('master.referensi.pupuk');
        Route::get('addpupuk',App\Livewire\Master\Referensi\Pupuk\AddPupuk::class)->name('master.referensi.addpupuk');
        Route::get('mapspupuk/{id}',App\Livewire\Master\Referensi\Pupuk\MapsPupuk::class)->name('master.referensi.mapspupuk');
        Route::get('editpupuk/{id}',App\Livewire\Master\Referensi\Pupuk\EditPupuk::class)->name('master.referensi.editpupuk');

        Route::get('agen',App\Livewire\Master\Referensi\Agen\Agen::class)->name('master.referensi.agen');
        Route::get('addagen',App\Livewire\Master\Referensi\Agen\AddAgen::class)->name('master.referensi.addagen');
        Route::get('mapsagen/{id}',App\Livewire\Master\Referensi\Agen\MapsAgen::class)->name('master.referensi.mapsagen');
        Route::get('editagen/{id}',App\Livewire\Master\Referensi\Agen\EditAgen::class)->name('master.referensi.editagen');

        Route::get('pangkalan',App\Livewire\Master\Referensi\Pangkalan\Pangkalan::class)->name('master.referensi.pangkalan');
        Route::get('addpangkalan',App\Livewire\Master\Referensi\Pangkalan\AddPangkalan::class)->name('master.referensi.addpangkalan');
        Route::get('mapspangkalan/{id}',App\Livewire\Master\Referensi\Pangkalan\MapsPangkalan::class)->name('master.referensi.mapspangkalan');
        Route::get('editpangkalan/{id}',App\Livewire\Master\Referensi\Pangkalan\EditPangkalan::class)->name('master.referensi.editpangkalan');
    });    

    Route::prefix('website')->group(function () {
        Route::get('berita/index',App\Livewire\Website\Berita\Index::class)->name('website.berita.index');
        Route::get('berita/add',App\Livewire\Website\Berita\Add::class)->name('website.berita.add');
        Route::get('berita/edit/{id}',App\Livewire\Website\Berita\Edit::class)->name('website.berita.edit');
        Route::get('berita/view/{id}',App\Livewire\Website\Berita\View::class)->name('website.berita.view');

        Route::get('galeri/index',App\Livewire\Website\Galeri\Index::class)->name('website.galeri.index');
        Route::get('galeri/add',App\Livewire\Website\Galeri\Add::class)->name('website.galeri.add');
        Route::get('galeri/edit/{id}',App\Livewire\Website\Galeri\Edit::class)->name('website.galeri.edit');
        Route::get('galeri/view/{id}',App\Livewire\Website\Galeri\View::class)->name('website.galeri.view');

        Route::get('banner/index',App\Livewire\Website\Banner\Index::class)->name('website.banner.index');
        Route::get('banner/add',App\Livewire\Website\Banner\Add::class)->name('website.banner.add');
        Route::get('banner/edit/{id}',App\Livewire\Website\Banner\Edit::class)->name('website.banner.edit');
        Route::get('banner/view/{id}',App\Livewire\Website\Banner\View::class)->name('website.banner.view');

        Route::get('link/index',App\Livewire\Website\Link\Index::class)->name('website.link.index');
        Route::get('link/add',App\Livewire\Website\Link\Add::class)->name('website.link.add');
        Route::get('link/edit/{id}',App\Livewire\Website\Link\Edit::class)->name('website.link.edit');
        Route::get('link/view/{id}',App\Livewire\Website\Link\View::class)->name('website.link.view');
    }); 
    
    Route::prefix('search')->group(function () {
        Route::get('tujuan-eksternal', [App\Livewire\Components\Search::class,'TujuanEksternal'])->name('search.tujuan.eksternal');
    });
        
    Route::prefix('main')->group(function () {
        Route::get('komoditas',App\Livewire\Main\Komoditas::class)->name('main.komoditas');
        Route::get('barang',App\Livewire\Main\Barang::class)->name('main.barang');
        Route::get('integrasi/view',App\Livewire\Main\IntegrasiProses::class)->name('main.integrasi.view');
        Route::get('integrasi',App\Livewire\Main\Integrasi::class)->name('main.integrasi');
    });

});