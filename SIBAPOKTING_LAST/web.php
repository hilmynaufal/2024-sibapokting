<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/mobile/pdf/{tgl}/{pasar}', 'App\Http\Controllers\DashboardController@pdf')->name('home');
// Route::match(['get', 'post'], 'mobile/pdf/{tgl}/{pasar}', ['uses' => 'DashboardController@pdf'])->middleware('cors');

Route::match(['get', 'post'], 'admin', 'App\Http\Controllers\HomeController@index')->name('admin');

Route::resource('admin/pasar', 'App\Http\Controllers\PasarController');
Route::get('admin/pasar/delete/{id}', 'App\Http\Controllers\PasarController@destroy')->name('pasar.delete');

Route::resource('admin/lpg', 'App\Http\Controllers\LpgController');
Route::get('admin/lpg/delete/{id}', 'App\Http\Controllers\LpgController@destroy')->name('lpg.delete');

Route::resource('admin/pupuk', 'App\Http\Controllers\PupukController');
Route::get('admin/pupuk/delete/{id}', 'App\Http\Controllers\PupukController@destroy')->name('pupuk.delete');

Route::resource('admin/distributor', 'App\Http\Controllers\DistributorController');
Route::get('admin/distributor/delete/{id}', 'App\Http\Controllers\DistributorController@destroy')->name('distributor.delete');

Route::resource('admin/barang', 'App\Http\Controllers\StokController');
Route::get('admin/barang/delete/{id}', 'App\Http\Controllers\StokController@destroy')->name('barang.delete');

Route::resource('admin/komoditas', 'App\Http\Controllers\KomoditasController');
Route::get('admin/komoditas/delete/{id}', 'App\Http\Controllers\KomoditasController@destroy')->name('komoditas.delete');

Route::resource('admin/master-barang', 'App\Http\Controllers\BarangController');
Route::get('admin/master-barang/delete/{id}', 'App\Http\Controllers\BarangController@destroy')->name('master-barang.delete');

Route::resource('admin/user-management', 'App\Http\Controllers\UserController');
Route::get('admin/user-management/delete/{id}', 'App\Http\Controllers\UserController@destroy')->name('user.delete');

Route::get('admin/user-detail/', 'App\Http\Controllers\UserController@index_user')->name('userdetail');
Route::post('admin/user-detail/update/{id}', 'App\Http\Controllers\UserController@update_user')->name('userdetailupdate');

Route::get('admin/dataIntegrasi', ['uses' => 'App\Http\Controllers\IntegrasiController@index'])->name('dataIntegrasi');
Route::get('admin/integrasi', ['uses' => 'App\Http\Controllers\IntegrasiController@komoditas'])->name('integrasi');
Route::get('admin/integrasiSilinda', ['uses' => 'App\Http\Controllers\IntegrasiController@silinda'])->name('integrasiSilinda');


Route::get('admin/berita', ['uses' => 'App\Http\Controllers\ArticlesController@index'])->name('articles');
Route::post('admin/articles/store', ['uses' => 'App\Http\Controllers\ArticlesController@store'])->name('articlesstore');
Route::get('admin/articles/destroy/{id}', ['uses' => 'App\Http\Controllers\ArticlesController@destroy'])->name('articlesdestroy');
Route::post('admin/articles/update/{id}', ['uses' => 'App\Http\Controllers\ArticlesController@update'])->name('articlesupdate');
Route::get('admin/articles/edit/{id}', ['uses' => 'App\Http\Controllers\ArticlesController@edit'])->name('articlesedit');

Route::match(['get', 'post'], 'admin/update-harga-komoditas/', ['uses' => 'App\Http\Controllers\KomoditasDetailController@index'])->name('detail.index');
Route::post('admin/update-harga-komoditas/create', ['uses' => 'App\Http\Controllers\KomoditasDetailController@create'])->name('detail.create');
Route::post('admin/update-harga-komoditas/store', ['uses' => 'App\Http\Controllers\KomoditasDetailController@store'])->name('detail.store');
Route::get('admin/update-harga-komoditas/destroy/{id}', ['uses' => 'App\Http\Controllers\KomoditasDetailController@destroy'])->name('detail.destroy');
Route::put('admin/update-harga-komoditas/update/{id}', ['uses' => 'App\Http\Controllers\KomoditasDetailController@update'])->name('detail.update');
Route::post('admin/update-harga-komoditas/show/{id}', ['uses' => 'App\Http\Controllers\KomoditasDetailController@show'])->name('detail.show');
Route::post('admin/update-harga-komoditas/edit/{id}', ['uses' => 'App\Http\Controllers\KomoditasDetailController@edit'])->name('detail.edit');
Route::post('admin/update-harga-komoditas/upload/', ['uses' => 'App\Http\Controllers\KomoditasDetailController@import'])->name('detail.import');

Route::get('admin/banner-poster', ['uses' => 'App\Http\Controllers\BannerController@index'])->name('banner');
Route::post('admin/banner/store/header', ['uses' => 'App\Http\Controllers\BannerController@headerstore'])->name('headerstore');
Route::post('admin/banner/store/content', ['uses' => 'App\Http\Controllers\BannerController@contentstore'])->name('contentstore');
Route::post('admin/banner/store/footer', ['uses' => 'App\Http\Controllers\BannerController@footerstore'])->name('footerstore');
Route::post('admin/banner/update/header/{id}', ['uses' => 'App\Http\Controllers\BannerController@headerupdate'])->name('headerupdate');
Route::post('admin/banner/update/content/{id}', ['uses' => 'App\Http\Controllers\BannerController@contentupdate'])->name('contentupdate');
Route::post('admin/banner/update/footer/{id}', ['uses' => 'App\Http\Controllers\BannerController@footerupdate'])->name('footerupdate');
Route::get('admin/banner/destroy/header/{id}', ['uses' => 'App\Http\Controllers\BannerController@headerdestroy'])->name('headerdestroy');
Route::get('admin/banner/destroy/content/{id}', ['uses' => 'App\Http\Controllers\BannerController@contentdestroy'])->name('contentdestroy');
Route::get('admin/banner/destroy/footer/{id}', ['uses' => 'App\Http\Controllers\BannerController@footerdestroy'])->name('footerdestroy');

Route::get('admin/link-alamat', ['uses' => 'App\Http\Controllers\AlamatController@index'])->name('link');
Route::post('admin/link/store/informasi', ['uses' => 'App\Http\Controllers\AlamatController@informasistore'])->name('informasistore');
Route::post('admin/link/store/instansiterkait', ['uses' => 'App\Http\Controllers\AlamatController@instansiterkaitstore'])->name('instansiterkaitstore');
Route::post('admin/link/update/informasi/{id}', ['uses' => 'App\Http\Controllers\AlamatController@informasiupdate'])->name('informasiupdate');
Route::post('admin/link/update/instansiterkait/{id}', ['uses' => 'App\Http\Controllers\AlamatController@instansiterkaitupdate'])->name('instansiterkaitupdate');
Route::get('admin/link/destroy/informasi/{id}', ['uses' => 'App\Http\Controllers\AlamatController@informasidestroy'])->name('informasidestroy');
Route::get('admin/link/destroy/instansiterkait/{id}', ['uses' => 'App\Http\Controllers\AlamatController@instansiterkaitdestroy'])->name('instansiterkaitdestroy');

Route::get('admin/pengaturan-tentang-kami', ['uses' => 'App\Http\Controllers\TentangController@index'])->name('tentang');
Route::post('admin/tentang/store/', ['uses' => 'App\Http\Controllers\TentangController@tentangstore'])->name('tentangstore');
Route::post('admin/tentang/update/{id}', ['uses' => 'App\Http\Controllers\TentangController@tentangupdate'])->name('tentangupdate');
Route::get('admin/tentang/destroy/{id}', ['uses' => 'App\Http\Controllers\TentangController@tentangdestroy'])->name('tentangdestroy');

Route::get('admin/pengaturan-kontak-kami', ['uses' => 'App\Http\Controllers\KontakController@index'])->name('kontak');
Route::post('admin/kontak/store/', ['uses' => 'App\Http\Controllers\KontakController@kontakstore'])->name('kontakstore');
Route::post('admin/kontak/update/{id}', ['uses' => 'App\Http\Controllers\KontakController@kontakupdate'])->name('kontakupdate');
Route::get('admin/kontak/destroy/{id}', ['uses' => 'App\Http\Controllers\KontakController@kontakdestroy'])->name('kontakdestroy');


Route::get('admin/server', ['uses' => 'App\Http\Controllers\FirebaseController@index'])->name('firebase');
Route::post('admin/server', ['uses' => 'App\Http\Controllers\FirebaseController@update'])->name('firebaseupdate');

Route::get('admin/tentang-mobile', ['uses' => 'App\Http\Controllers\TentangController@index_mobile'])->name('tentangmobile');
Route::post('admin/tentang-mobile/store', ['uses' => 'App\Http\Controllers\TentangController@store_mobile'])->name('tentangmobilestore');
Route::post('admin/tentang-mobile/update/{id}', ['uses' => 'App\Http\Controllers\TentangController@update_mobile'])->name('tentangmobileupdate');
Route::get('admin/tentang-mobile/delete/{id}', ['uses' => 'App\Http\Controllers\TentangController@delete_mobile'])->name('tentangmobiledelete');

Route::get('admin/pesan', ['uses' => 'App\Http\Controllers\PesanController@index'])->name('pesan');
Route::get('admin/pesan/destroy/{id}', ['uses' => 'App\Http\Controllers\PesanController@pesandestroy'])->name('pesandestroy');

Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
Route::get('/result', 'App\Http\Controllers\DashboardController@index')->name('dashboardresult');
Route::get('chartPasar', 'App\Http\Controllers\DashboardController@chartPasar')->name('chartPasar');
Route::get('chartKomoditas', 'App\Http\Controllers\DashboardController@chartKomoditas')->name('chartKomoditas');
Route::get('chartPasarStatistik', 'App\Http\Controllers\DashboardController@chartPasarStatistik')->name('chartPasarStatistik');
Route::get('chartDetailKomoditas', 'App\Http\Controllers\DashboardController@chartDetailKomoditas')->name('chartDetailKomoditas');
Route::get('berita', 'App\Http\Controllers\DashboardController@articles_list')->name('articleslist');
Route::get('berita/post/{id}', 'App\Http\Controllers\DashboardController@articles_detail')->name('articlesdetail');

Route::get('peta-pasar', 'App\Http\Controllers\DashboardController@peta')->name('peta');
Route::get('tentang', 'App\Http\Controllers\DashboardController@tentang')->name('tentangdepan');
Route::get('kontak', 'App\Http\Controllers\DashboardController@kontak')->name('kontakdepan');
Route::get('kontak/store', 'App\Http\Controllers\DashboardController@kontakstore')->name('kontakdepanstore');

Route::match(['get', 'post'],'pasar/komoditas', 'App\Http\Controllers\DashboardController@perpasar')->name('perpasar');
Route::get('komoditas/pasar', 'App\Http\Controllers\DashboardController@perkomoditas')->name('perkomoditas');
Route::get('data/lpg', 'App\Http\Controllers\DashboardController@lpg')->name('lpg');
Route::get('data/pupuk', 'App\Http\Controllers\DashboardController@pupuk')->name('pupuk');
Route::get('data/distributor', 'App\Http\Controllers\DashboardController@distributor')->name('distributor');
Route::get('data/stok', 'App\Http\Controllers\DashboardController@stok')->name('stok');

//mobile
Route::match(['get', 'post'], 'mobile/berita', ['as'=>'mobile.berita','uses' => 'App\Http\Controllers\DashboardController@berita'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/berita-detail/{no}', ['as'=>'mobile.tentang_kami','uses' => 'App\Http\Controllers\DashboardController@tentang_kami'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/tentang-kami', ['as'=>'mobile.tentang-kami','uses' => 'App\Http\Controllers\DashboardController@tentang-kami'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/kontak-kami', ['as'=>'mobile.kontak-kami','uses' => 'App\Http\Controllers\DashboardController@kontak-kami'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/berita/limit', ['as'=>'mobile.berita_limit','uses' => 'App\Http\Controllers\DashboardController@berita_limit'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/peta', ['as'=>'mobile.peta','uses' => 'App\Http\Controllers\DashboardController@peta'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/pasar', ['as'=>'mobile.pasar','uses' => 'App\Http\Controllers\DashboardController@pasar'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/pesan', ['as'=>'mobile.pesan','uses' => 'App\Http\Controllers\DashboardController@pesan'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/komoditas', ['as'=>'mobile.komoditas','uses' => 'App\Http\Controllers\DashboardController@komoditas'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/barang', ['as'=>'mobile.barang','uses' => 'App\Http\Controllers\DashboardController@barang'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/tentang-mobile', ['as'=>'mobile.tentangmobile','uses' => 'App\Http\Controllers\DashboardController@tentangmobile'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/chart/{state}', ['as'=>'mobile.chart','uses' => 'App\Http\Controllers\DashboardController@chart'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/table-komoditas/{komoditas}/{mulai}/{selesai}', ['as'=>'mobile.table_perkomoditas','uses' => 'App\Http\Controllers\DashboardController@table_perkomoditas'])->name('table-komoditas');
Route::match(['get', 'post'], 'mobile/table-pasar/{pasars}/{mulai}/{selesai}', ['as'=>'mobile.table_perpasar','uses' => 'App\Http\Controllers\DashboardController@table_perpasar'])->name('table-pasar');

Route::match(['get', 'post'], 'mobile/login',['as'=>'mobile.login','uses' => 'App\Http\Controllers\DashboardController@login']);
Route::match(['get', 'post'], 'mobile/input', ['as'=>'mobile.inputitem','uses' => 'App\Http\Controllers\DashboardController@inputitem'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/detail-item/{tgl}/{pasar}', ['as'=>'mobile.detail_item','uses' => 'App\Http\Controllers\DashboardController@detail_item'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/detail-delete/{id}', ['as'=>'mobile.detail_detele','uses' => 'App\Http\Controllers\DashboardController@detail_detele'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/banner/{id}', ['as'=>'mobile.banner','uses' => 'App\Http\Controllers\DashboardController@banner'])->middleware('cors');

Route::match(['get', 'post'], 'mobile/stok-barang', ['as'=>'mobile.inputstok','uses' => 'App\Http\Controllers\DashboardController@inputstok'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/detail-item-barang/{tgl}/{pasar}', ['as'=>'mobile.detail_item_barang','uses' => 'App\Http\Controllers\DashboardController@detail_item_barang'])->middleware('cors');
Route::match(['get', 'post'], 'mobile/detail-delete-barang/{id}', ['as'=>'mobile.detail_delete_barang','uses' => 'App\Http\Controllers\DashboardController@detail_delete_barang'])->middleware('cors');

Route::get('api/pasar/', ['as'=>'api.pasar','uses'=>'App\Http\Controllers\DashboardController@apipasar']);
Route::get('api/komoditas/', ['as'=>'api.komoditas','uses'=>'App\Http\Controllers\DashboardController@apikomoditas']);
Route::get('api/hargakomoditas/', ['as'=>'api.hargakomoditas','uses'=>'App\Http\Controllers\DashboardController@apihargakomoditas']);
Route::get('api/post_silinda/', ['as'=>'api.post_silinda','uses'=>'App\Http\Controllers\APIController@silinda']);
Route::get('api/get_silinda/', ['as'=>'api.get_silinda','uses'=>'App\Http\Controllers\APIController@silinda_int']);


Auth::routes();

app('debugbar')->disable();
