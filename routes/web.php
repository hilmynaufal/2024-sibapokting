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

Route::get('/', App\Livewire\Auth\Login::class)->name('login');
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
    }); 
    
    Route::prefix('main/lampiran')->group(function () {
        Route::get('preview/{id}',App\Livewire\Main\Lampiran\Index::class)->name('main.lampiran.view');
    });    
    
    Route::prefix('layanan/bphtb')->group(function () {
        Route::get('create',App\Livewire\Main\Layanan\Bphtb\Create::class)->name('main.layanan.bphtb.create');
        Route::get('index',App\Livewire\Main\Layanan\Bphtb\Index::class)->name('main.layanan.bphtb.index');
        Route::get('detail/{id}',App\Livewire\Main\Layanan\Bphtb\Detail::class)->name('main.layanan.bphtb.detail');
        
        Route::get('penerima-hak',App\Livewire\Main\Layanan\Bphtb\Form\PenerimaHak::class)->name('bphtb.form.penerima.hak');
        Route::get('penerima-hak-edit/{id}',App\Livewire\Main\Layanan\Bphtb\Form\PenerimaHakEdit::class)->name('bphtb.form.penerima.hak.edit');
        Route::get('pelepas-hak/{id}',App\Livewire\Main\Layanan\Bphtb\Form\PelepasHak::class)->name('bphtb.form.pelepas.hak');
        Route::get('objek-pajak/{id}',App\Livewire\Main\Layanan\Bphtb\Form\ObjekPajak::class)->name('bphtb.form.objek.pajak');
        Route::get('maps/{id}',App\Livewire\Main\Layanan\Bphtb\Form\Maps::class)->name('bphtb.form.maps');
        
        Route::get('objek-pajak-verifikasi/{id}',App\Livewire\Main\Layanan\Bphtb\Verifikasi\ObjekPajak::class)->name('bphtb.verifikasi.objek.pajak');
        Route::get('persyaratan-verifikasi/{id}',App\Livewire\Main\Layanan\Bphtb\Form\Perhitungan::class)->name('bphtb.form.verifikasi');
        
        Route::get('catatan-berkas/{id}',App\Livewire\Main\Layanan\Bphtb\Form\Perhitungan::class)->name('bphtb.form.catatan.berkas');
        Route::get('cetak-sspd/{id}',App\Livewire\Main\Layanan\Bphtb\CetakSspd::class)->name('bphtb.cetak.sspd');
        Route::get('cetak-resi/{id}',App\Livewire\Main\Layanan\Bphtb\CetakResi::class)->name('bphtb.cetak.resi');
        Route::get('cetak-ntpd/{id}',App\Livewire\Main\Layanan\Bphtb\CetakNtpd::class)->name('bphtb.cetak.ntpd');
        Route::get('cetak-sspdsigned/{id}',App\Livewire\Main\Layanan\Bphtb\CetakSspdSigned::class)->name('bphtb.cetak.sspdsigned');
        Route::get('cetak-verifikasi/{id}',App\Livewire\Main\Layanan\Bphtb\CetakVerifikasi::class)->name('bphtb.cetak.verifikasi');
    }); 
    Route::prefix('layanan/bphtbkb')->group(function () {
        Route::get('index',App\Livewire\Main\Layanan\BphtbKb\Index::class)->name('main.layanan.bphtbkb.index');
        Route::get('detail/{id}',App\Livewire\Main\Layanan\BphtbKb\Detail::class)->name('main.layanan.bphtbkb.detail');
    });  
    
    Route::prefix('verifikasi/bphtb')->group(function () {
        Route::get('index',App\Livewire\Main\Verifikasi\Bphtb\Index::class)->name('main.verifikasi.bphtb.index');        
        Route::get('detail/{id}',App\Livewire\Main\Verifikasi\Bphtb\Detail::class)->name('main.verifikasi.bphtb.detail');
    }); 

    Route::prefix('verifikasi/bphtbkb')->group(function () {
        Route::get('index',App\Livewire\Main\Verifikasi\BphtbKb\Index::class)->name('main.verifikasi.bphtbkb.index');        
        Route::get('detail/{id}',App\Livewire\Main\Verifikasi\BphtbKb\Detail::class)->name('main.verifikasi.bphtbkb.detail');
    });  

    Route::prefix('pengajuan')->group(function () {
        Route::get('aktif/index',App\Livewire\Main\Pengajuan\Aktif\Index::class)->name('main.pengajuan.aktif.index');
        Route::get('aktif/detail/{id}',App\Livewire\Main\Pengajuan\Aktif\Detail::class)->name('main.pengajuan.aktif.detail');
    }); 
    
    Route::prefix('main/surat')->group(function () {
        Route::get('masuk',App\Livewire\Main\SuratMasuk\Index::class)->name('main.suratmasuk.index');
        Route::get('keluar',App\Livewire\Main\SuratKeluar\Index::class)->name('main.suratkeluar.index');
    });    
    
    Route::prefix('main/disposisi')->group(function () {
        Route::get('masuk',App\Livewire\Main\DisposisiMasuk\Index::class)->name('main.disposisimasuk.index');
        Route::get('cetak/{id}',App\Livewire\Main\DisposisiMasuk\Cetak::class)->name('main.disposisimasuk.cetak');
        Route::get('keluar',App\Livewire\Main\DisposisiKeluar\Index::class)->name('main.disposisikeluar.index');
    });      
    
    Route::prefix('main/laporan')->group(function () {
        Route::get('surat-masuk',App\Livewire\Main\Laporan\SuratMasuk\Index::class)->name('main.laporan.suratmasuk.index');
        Route::get('surat-keluar',App\Livewire\Main\Laporan\SuratKeluar\Index::class)->name('main.laporan.suratkeluar.index');
    });      
    
    Route::prefix('search')->group(function () {
        Route::get('tujuan-eksternal', [App\Livewire\Components\Search::class,'TujuanEksternal'])->name('search.tujuan.eksternal');
    });
    
    
});

// Route::prefix('search')->group(function () {
    //     Route::get('golongan', [App\Livewire\Components\SearchSelects::class,'Golongan'])->name('search.golongan');
    //     Route::get('eselon', [App\Livewire\Components\SearchSelects::class,'Eselon'])->name('search.eselon');
    //     Route::get('pangkat', [App\Livewire\Components\SearchSelects::class,'Pangkat'])->name('search.pangkat');
    //     Route::get('jabatan', [App\Livewire\Components\SearchSelects::class,'Jabatan'])->name('search.jabatan');
    //     Route::get('unit-kerja', [App\Livewire\Components\SearchSelects::class,'UnitKerja'])->name('search.unit-kerja');
    //     Route::get('satuan-kerja', [App\Livewire\Components\SearchSelects::class,'SatuanKerja'])->name('search.satuan-kerja');
    // });    