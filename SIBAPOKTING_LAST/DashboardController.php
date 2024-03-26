<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\requests;
use Illuminate\Support\Facades\DB;
use Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	$pasar = DB::table('pasar')->get();
        $komoditas = DB::table('komoditas')->get();
        $tgl = Carbon\carbon::now()->format('Y-m-d');
        $tgl1 = Carbon\carbon::now()->addDay(-1)->format('Y-m-d');
        $tgl2 = Carbon\carbon::now()->addDay(-2)->format('Y-m-d');
        $banner1 = DB::table('banner')->where('type', 'header')->limit(1)->get();
        $banner2 = DB::table('banner')->where('type', 'content')->get();
        $banner3 = DB::table('banner')->where('type', 'footer')->get();
        $articles = DB::table('articles')->where('kategori', 'Berita')->orderBy('tanggal', 'desc')->get();
	    $events = DB::table('articles')->where('kategori','Event')->get();

        if ($request->has('_token')) {
            if ($request->namapasar == 'semua') {
                $namapasar = '';
                $avg = DB::table('detail')
                    ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                    ->select(
                        'detail.*',
                        'komoditas.*',
                        DB::raw('AVG(harga_publish) as total'),
                        DB::raw('AVG(harga_dinamik) as total_kemaren')
                    )
                    //->where('detail.pasar_id',$request->namapasar)
                    ->where('detail.detail_tgl', $tgl)
                    ->groupBy('komoditas_id')
                    ->get();
            } else {
                $namapasar = $request->namapasar;
                $avg = DB::table('detail')
                    ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                    ->select(
                        'detail.*',
                        'komoditas.*',
                        DB::raw('AVG(harga_publish) as total'),
                        DB::raw('AVG(harga_dinamik) as total_kemaren')
                    )
                    ->where('detail.pasar_id', $request->namapasar)
                    ->where('detail.detail_tgl', $tgl)
                    ->groupBy('komoditas_id')
                    ->get();
            }
        } else {
            $namapasar = '';
            $avg = DB::table('detail')
                ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                ->select(
                    'detail.*',
                    'komoditas.*',
                    DB::raw('AVG(harga_publish) as total'),
                    DB::raw('AVG(harga_dinamik) as total_kemaren')
                )
                ->where('detail.detail_tgl', $tgl)
                ->groupBy('komoditas_id')
                ->get();
        }

        return view('page.dashboard', [
            'avg' => $avg,
            'articles' => $articles,
	    'events' => $events,
            'banner1' => $banner1,
            'banner2' => $banner2,
            'banner3' => $banner3,
            'tgl' => $tgl,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'pasar' => $pasar,
            'namapasar' => $namapasar,
            'komoditas' => $komoditas,
        ]);
    }

    public function chart($state)
    {
        $tgl = Carbon\carbon::now()->format('Y-m-d');
        $tgl1 = Carbon\carbon::now()->addDay(-1)->format('Y-m-d');
        $tgl2 = Carbon\carbon::now()->addDay(-2)->format('Y-m-d');
        if ($state == 'all') {
            $namapasar = '';
            $avg = DB::table('detail')
                ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                ->select(
                    'detail.*',
                    'komoditas.*',
                    DB::raw('AVG(harga_publish) as total'),
                    DB::raw('AVG(harga_dinamik) as total_kemaren')
                )
                ->where('detail.detail_tgl', $tgl)
                ->groupBy('komoditas_id')
                ->get();
        } else {
            $namapasar = $state;
            $avg = DB::table('detail')
                ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                ->select(
                    'detail.*',
                    'komoditas.*',
                    DB::raw('AVG(harga_publish) as total'),
                    DB::raw('AVG(harga_dinamik) as total_kemaren')
                )
                ->where('pasar_id', $state)
                ->where('detail.detail_tgl', $tgl)
                ->groupBy('komoditas_id')
                ->get();
        }

        return view('page.chart', [
            'avg' => $avg,
            'tgl' => $tgl,
            'tgl1' => $tgl1,
            'tgl2' => $tgl2,
            'namapasar' => $namapasar,
        ]);
    }

    public function articles_list()
    {
        $beritalama = DB::table('articles')->where('status', 'PUBLISED')->limit(5)->orderBy('tanggal', 'desc')->get();
        $articles = DB::table('articles')->where('status', 'PUBLISED')->paginate(10);
        return view('page.articleslist', [
            'articles' => $articles,
            'beritalama' => $beritalama
        ]);
    }

    public function articles_detail($id)
    {
        $beritalama = DB::table('articles')->where('status', 'PUBLISED')->limit(5)->orderBy('tanggal', 'desc')->get();
        $articlesdetail = DB::table('articles')->where('id', $id)->get();

        return view('page.articles', [
            'articlesdetail' => $articlesdetail,
            'beritalama' => $beritalama
        ]);
    }

    public function peta()
    {
        $pasarpeta = DB::table('pasar')->get();
        return view('page.peta', [
            'pasarpeta' => $pasarpeta
        ]);
    }

    public function perpasar(Request $request)
    {
        $pasar = DB::table('pasar')->get();
        $kom = DB::table('komoditas')->get();
        $no = 1;
        if ($request->has('_token')) {
            if ($request->namakomoditas[0] == 'semua') {
                $mulai = $request->tanggal_mulai;
                $selesai = $request->tanggal_selesai;
                $pasarid = $request->pasar_id;

                $tanggal = DB::table('tahun_laporan')
                    ->whereBetween('tgl', [$mulai, $selesai])
                    ->get();
                $selectkomoditas = DB::table('komoditas')->get();
            } else {
                $mulai = $request->tanggal_mulai;
                $selesai = $request->tanggal_selesai;
                $pasarid = $request->pasar_id;

                $tanggal = DB::table('tahun_laporan')
                    ->whereBetween('tgl', [$mulai, $selesai])
                    ->get();
                $selectkomoditas = DB::table('komoditas')->whereIn('id', $request->namakomoditas)->get();
            }
        } else {
            $mulai = Carbon\carbon::now()->addDays(-5)->format('Y-m-d');
            $selesai = Carbon\carbon::now()->format('Y-m-d');
            $tanggal = DB::table('tahun_laporan')
                ->whereBetween('tgl', [$mulai, $selesai])
                ->get();
            $pasarid = '1';
            $selectkomoditas = DB::table('komoditas')->get();
        }

        return view('page.perpasar', [
            'kom' => $kom,
            'pasar' => $pasar,
            'no' => $no,
            'tanggal' => $tanggal,
            'mulai' => $mulai,
            'selesai' => $selesai,
            'pasarid' => $pasarid,
            'selectkomoditas' => $selectkomoditas,
        ]);
    }

    public function perkomoditas(Request $request)
    {
        $pasar = DB::table('pasar')->get();
        $kom = DB::table('komoditas')->get();
        $no = 1;
	

        if ($request->has('_token')) {
            if ($request->namapasar[0] == 'semua') {
                $mulai = $request->tanggal_mulai;
                $selesai = $request->tanggal_selesai;
                $komoditasid = $request->komoditas_id;
                $tanggal = DB::table('tahun_laporan')
                    ->whereBetween('tgl', [$mulai, $selesai])
                    ->get();
                $selectpasar = DB::table('pasar')->get();
            } else {
                // dd($request->namapasar);
                $mulai = $request->tanggal_mulai;
                $selesai = $request->tanggal_selesai;
                $komoditasid = $request->komoditas_id;
                $tanggal = DB::table('tahun_laporan')
                    ->whereBetween('tgl', [$mulai, $selesai])
                    ->get();
                $selectpasar = DB::table('pasar')->whereIn('id', $request->namapasar)->get();
            }
        } else {
            $mulai = Carbon\carbon::now()->format('Y-m-d');
            $selesai = Carbon\carbon::now()->format('Y-m-d');
            $tanggal = DB::table('tahun_laporan')
                ->whereBetween('tgl', [$mulai, $selesai])
                ->get();
            $komoditasid = '1';
            $selectpasar = DB::table('pasar')->get();
        }
        $tanggalLast = Carbon\carbon::now()->addDay(-1)->format('Y-m-d');

        return view('page.perkomoditas', [
            'kom' => $kom,
            'pasar' => $pasar,
            'no' => $no,
            'tanggal' => $tanggal,
            'mulai' => $mulai,
            'tanggalLast' => $tanggalLast,
            'selesai' => $selesai,
            'komoditasid' => $komoditasid,
            'selectpasar' => $selectpasar
        ]);
    }

    public function lpg(Request $request)
    {
        $lpg = DB::table('lpg')->get();
        $no = 1;

        return view('page.lpg', [
            // 'kom' => $kom,
            'lpg' => $lpg,
            'no' => $no,
        ]);
    }

    public function pupuk(Request $request)
    {
        $pupuk = DB::table('pupuk')
        ->select('pupuk.*', 'distributor.id as distributor_id','distributor.nama_distributor','distributor.lokasi')
        ->join('distributor','pupuk.id_distributor','=','distributor.id')
        ->get();
        $no = 1;

        return view('page.pupuk', [
            // 'kom' => $kom,
            'pupuk' => $pupuk,
            'no' => $no,
        ]);
    }

    public function distributor(Request $request)
    {
        $distributor = DB::table('distributor')->get();
        $no = 1;

        return view('page.distributor', [
            // 'kom' => $kom,
            'distributor' => $distributor,
            'no' => $no,
        ]);
    }

    public function stok(Request $request)
    {
        $stok = DB::table('stok')
                ->select('stok.*', 'pasar.id as pasar_id','pasar.namapasar', 'barang.id as barang_id','barang.namabarang')
                ->join('barang','barang.id','=','stok.idbarang')
                ->join('pasar','pasar.id','=','stok.idpasar')
                ->get();
        $no = 1;

        return view('page.stok', [
            // 'kom' => $kom,
            'stok' => $stok,
            'no' => $no,
        ]);
    }

    // LPG

    // public function table_lpg()
    // {
    //     $pasar = DB::table('lpg')->get();
    //     $no = 1;
    //     $komoditasid = $komoditas;


    //     return view('page.table-komoditas', [
    //         'kom' => $kom,
    //         'pasar' => $pasar,
    //         'no' => $no,
    //         'tanggal' => $tanggal,
    //         'mulai' => $mulai,
    //         'selesai' => $selesai,
    //         'komoditasid' => $komoditasid,
    //     ]);
    // }

    public function table_perkomoditas($komoditas, $mulai, $selesai)
    {
        $pasar = DB::table('pasar')->get();
        $kom = DB::table('komoditas')->get();
        $no = 1;
        $komoditasid = $komoditas;
        $tanggal = DB::table('tahun_laporan')
            ->whereBetween('tgl', [$mulai, $selesai])
            ->get();

        return view('page.table-komoditas', [
            'kom' => $kom,
            'pasar' => $pasar,
            'no' => $no,
            'tanggal' => $tanggal,
            'mulai' => $mulai,
            'selesai' => $selesai,
            'komoditasid' => $komoditasid
        ]);
    }

    public function table_perpasar($pasars, $mulai, $selesai)
    {
        $pasar = DB::table('pasar')->get();
        $kom = DB::table('komoditas')->get();
        $no = 1;
        $pasarid = $pasars;
        $tanggal = DB::table('tahun_laporan')
            ->whereBetween('tgl', [$mulai, $selesai])
            ->get();

        return view('page.table-pasar', [
            'kom' => $kom,
            'pasar' => $pasar,
            'no' => $no,
            'tanggal' => $tanggal,
            'mulai' => $mulai,
            'selesai' => $selesai,
            'pasarid' => $pasarid,
        ]);
    }

    public function tentang()
    {
        $banner = DB::table('banner')->where('id', '1')->get();
        $tentang = DB::table('tentang')->get();
        return view('page.tentang', [
            'tentang' => $tentang,
            'banner' => $banner
        ]);
    }
    
    public function strukturOrganisasi()
    {
        $pejabat = DB::table('struktur_organisasi')->orderBy('urutan', 'asc')->get();
        return view('page.struktur-organisasi', compact('pejabat'));
    }

    public function galeri()
    {
        $galeri = DB::table('galeri')->get();
        return view('page.galeri', compact('galeri'));
    }

    public function kontak()
    {
        $banner = DB::table('banner')->where('id', '1')->get();
        $kontak = DB::table('kontak')->get();
        $tentang = DB::table('tentang')->get();
        return view('page.kontak', [
            'kontak' => $kontak,
            'tentang' => $tentang,
            'banner' => $banner
        ]);
    }

    public function kontakstore(Request $request)
    {
        //$date = Carbon\Carbon::now()->format('Y-m-d');
        DB::table('pesan')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
            'tanggal' => config('global.date'),
        ]);
        return redirect()->route('kontakdepan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function hargapangan(){

    //     $select = DB::table('detail')
    //     ->join('komoditas','komoditas.id','=','detail.komoditas_id')
    //     ->select(
    //         'detail.*',
    //         'komoditas.*',
    //         DB::raw('AVG(harga_publish) as total'),
    //         DB::raw('AVG(harga_dinamik) as total_kemaren')
    //     )
    //     ->where('pasar_id','1')
    //     ->where('detail.tanggal','2019-11-21')
    //     ->groupBy('komoditas_id')
    //     ->get();

    //     return json_encode($select);
    // }

    public function berita()
    {
        $select = DB::table('articles')->orderBy('tanggal')->get();
        return json_encode($select);
    }

    public function berita_detail($no)
    {
        $select = DB::table('articles')->where('id', $no)->get();
        return json_encode($select);
    }

    public function berita_limit()
    {
        $select = DB::table('articles')->limit(3)->get();
        return json_encode($select);
    }

    public function tentang_kami()
    {
        $select = DB::table('tentang')->get();
        return json_encode($select);
    }

    public function kontak_kami()
    {
        $select = DB::table('kontak')->get();
        return json_encode($select);
    }

    public function peta_pasar()
    {
        $select = DB::table('pasar')->get();
        return json_encode($select);
    }

    public function pasar()
    {
        $select = DB::table('pasar')->get();
        return json_encode($select);
    }

    public function apiPasar(Request $request)
    {
        if($request->tokenApi == 'Sibapokting123*'){
            $value = array(
                            "status"=>"success",
                            "message"=>"Data retrieved successfully.",
                            "pageTitle"=>"Data Pasar Kabupaten Bandung",
                            "data" => DB::table('pasar')->get()
                        );
        }else{
            $value = array(
                "status"=>"error",
                "message"=>"Token API not active"
            );
        }
        
        return json_encode($value);
    }

    public function apiKomoditas(Request $request)
    {
        if($request->tokenApi == 'Sibapokting123*'){
            $value = array(
                            "status"=>"success",
                            "message"=>"Data retrieved successfully.",
                            "pageTitle"=>"Data Komoditas Kabupaten Bandung",
                            "data" => DB::table('komoditas')->get()
                        );
        }else{
            $value = array(
                "status"=>"error",
                "message"=>"Token API not active"
            );
        }
        
        return json_encode($value);
    }

    public function apiHargaKomoditas(Request $request)
    {
        if($request->tokenApi == 'Sibapokting123*'){
            if ($request->pasar == 'semua') {
                $avg = DB::table('detail')
                    ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                    ->select(
                        'detail.*',
                        'komoditas.*',
                        DB::raw('AVG(harga_publish) as total'),
                        DB::raw('AVG(harga_dinamik) as total_kemaren')
                    )
                    ->where('detail.detail_tgl', $request->tanggal)
                    ->groupBy('komoditas_id')
                    ->get();
            } else {
                $idPasar = $request->pasar;
                $avg = DB::table('detail')
                    ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                    ->select(
                        'detail.*',
                        'komoditas.*',
                        DB::raw('AVG(harga_publish) as total'),
                        DB::raw('AVG(harga_dinamik) as total_kemaren')
                    )
                    ->where('detail.pasar_id', $idPasar)
                    ->where('detail.detail_tgl', $request->tanggal)
                    ->groupBy('komoditas_id')
                    ->get();
            }
    
            $data['avg'] = $avg;

            $value = array(
                            "status"=>"success",
                            "message"=>"Data retrieved successfully.",
                            "pageTitle"=>"Data Harga Komoditas Kabupaten Bandung",
                            "data" => $data
                        );
        }else{
            $value = array(
                "status"=>"error",
                "message"=>"Token API not active"
            );
        }
        
        return json_encode($value);
    }

    public function pesan(Request $request)
    {
        DB::table('pesan')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
            'tanggal' => config('global.date'),
        ]);

        return json_encode('sukses');
    }

    public function komoditas()
    {
        $select = DB::table('komoditas')->get();
        return json_encode($select);
    }

    public function barang()
    {
        $select = DB::table('barang')->get();
        return json_encode($select);
    }

    public function tentangmobile()
    {
        $select = DB::table('tentang-mobile')->get();
        return json_encode($select);
    }

    public function komoditaslist()
    {
        $select = DB::table('detail')
            ->join('komoditas', 'detail.komoditas_id', '=', 'komoditas.id')
            ->select('detail.*', 'komoditas.namakomoditas')
            ->get();

        return json_encode($select);
    }

    public function inputitem(Request $request)
    {
        $datesekarang = Carbon\carbon::parse($request->tanggal)->format('Y-m-d');
        $datekemaren = Carbon\carbon::parse($request->tanggal)->addDay(-1)->format('Y-m-d');
        // $datesekarang = Carbon\carbon::now()->format('Y-m-d H:i:s');
        // $datekemaren = Carbon\carbon::parse($request->tanggal)->addDay(-1)->format('Y-m-d');
        DB::table('detail')->insert([
            'komoditas_id' => $request->komoditas,
            'pasar_id' => $request->pasar,
            'users_id' => $request->user,
            'tanggal' => $datesekarang,
            'detail_tgl' => $datesekarang,
            'harga_pasar' => $request->harga,
            'harga_publish' => $request->harga,
        ]);

        $select = DB::table('detail')
            ->select('harga_publish')
            ->where('detail_tgl', $datekemaren)
            ->where('pasar_id', $request->pasar)
            ->where('komoditas_id', $request->komoditas)
            ->limit(1)
            ->get();


        $hargakemarin = '';
        foreach ($select as $i) {
            $hargakemarin = $i->harga_publish;
        }

        $query = DB::table('detail')
            ->select('harga_publish')
            ->where('detail_tgl', $datesekarang)
            ->where('pasar_id', $request->pasar)
            ->where('komoditas_id', $request->komoditas)
            ->get();

        $hargasekarang = '';
        foreach ($query as $i) {
            $hargasekarang = $i->harga_publish;
        }

        if ($hargakemarin == '') {
                $hargadinamik = '0';
                $kondisi = 'stabil';
                DB::table('detail')
                    ->where('detail_tgl', $datesekarang)
                    ->where('pasar_id', $request->pasar)
                    ->where('komoditas_id', $request->komoditas)
                    ->update([
                        'harga_dinamik' => $hargadinamik,
                        'kondisi' => $kondisi,
                        'status' => 'harga pasar',
                    ]);
            $value = array(
                'data' => 'sukses'
            );
            return json_encode($value);
        } else {
            if ($hargasekarang > $hargakemarin) {
                $hargadinamik = (int)$hargasekarang - (int)$hargakemarin;
                $kondisi = 'naik';
                DB::table('detail')
                    ->where('detail_tgl', $datesekarang)
                    ->where('pasar_id', $request->pasar)
                    ->where('komoditas_id', $request->komoditas)
                    ->update([
                        'harga_dinamik' => $hargadinamik,
                        'kondisi' => $kondisi,
                        'status' => 'harga pasar',
                    ]);
            } elseif ($hargasekarang == $hargakemarin) {
                $hargadinamik = '0';
                $kondisi = 'stabil';
                DB::table('detail')
                    ->where('detail_tgl', $datesekarang)
                    ->where('pasar_id', $request->pasar)
                    ->where('komoditas_id', $request->komoditas)
                    ->update([
                        'harga_dinamik' => $hargadinamik,
                        'kondisi' => $kondisi,
                        'status' => 'harga pasar',
                    ]);
            } elseif ($hargasekarang < $hargakemarin) {
                $hargadinamik = (int)$hargakemarin - (int)$hargasekarang;
                $kondisi = 'turun';
                DB::table('detail')
                    ->where('detail_tgl', $datesekarang)
                    ->where('pasar_id', $request->pasar)
                    ->where('komoditas_id', $request->komoditas)
                    ->update([
                        'harga_dinamik' => $hargadinamik,
                        'kondisi' => $kondisi,
                        'status' => 'harga pasar',
                    ]);
            }
            $value = array(
                'result' => 'sukses'
            );
            return json_encode($value);
        }
    }

    public function inputstok(Request $request)
    {
        $datesekarang = Carbon\carbon::parse($request->tanggal);
        $datekemaren = Carbon\carbon::parse($request->tanggal)->addDay(-1);
        DB::table('stok')->insert([
            'idbarang' => $request->barang,
            'pemasok' => $request->pemasok,
            'stok_awal' => $request->stok_awal,
            'kebutuhan' => $request->kebutuhan,
            'ketersediaan' => $request->ketesediaan,
            'idpasar' => $request->pasar,
            'iduser' => $request->user,
            'tanggal' => $datesekarang,
            'detail_tgl' => $datesekarang,

        ]);
        $value = array(
            'result' => 'sukses'
        );
        return json_encode($value);
    }

    public function detail_item($tgl, $pasar)
    {
        $select = DB::table('detail')
            ->join('komoditas', 'detail.komoditas_id', '=', 'komoditas.id')
            ->select('detail.*', 'komoditas.namakomoditas')
            ->where('detail_tgl', $tgl)
            ->where('pasar_id', $pasar)
            ->get();

        return json_encode($select);
    }

    public function detail_item_barang($tgl, $pasar)
    {
            $select =  DB::table('stok')
            ->join('barang','stok.idbarang', '=','barang.id')
            ->join('pasar','stok.idpasar', '=','pasar.id')
            ->select('stok.*', 'pasar.id as pasar_id','pasar.namapasar', 'barang.id as barang_id','barang.namabarang')
            ->where('detail_tgl', $tgl)
            ->where('idpasar', $pasar)
            ->get();

        return json_encode($select);
    }

    public function detail_detele($id)
    {
        DB::table('detail')->where('id', $id)->delete();

        $value = array(
            "data" => "sukses"
        );
        return json_encode($value);
    }

    public function detail_delete_barang($id)
    {
        DB::table('stok')->where('id', $id)->delete();

        $value = array(
            "data" => "sukses"
        );
        return json_encode($value);
    }

    // API BARANG


    public function login(Request $request)
    {
        $select = DB::table('users')
            ->join('pasar', 'pasar.id', '=', 'users.pasar_id')
            ->select('users.*', 'pasar.namapasar')
            ->where('email', $request->username)
            ->where('pass', $request->password)
            ->get();

        if (count($select) > 0) {
            $value = array(
                "result" => "sukses",
                array(
                    "db" => $select
                )
            );
            return json_encode($value);
        } else {
            $value = array(
                "result" => "gagal"
            );
            return json_encode($value);
        }
    }

    public function banner($id)
    {
        $select = DB::table('banner')->where('id', $id)->get();
        return json_encode($select);
    }

    public function chartPasar()
    {
        $pasar  = request('did');
        $year = request('y');

        // Data Grafik Kategori Usia
        // $categories =  DB::table('detail')
        //                 ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
        //                 ->join('pasar', 'pasar.id', '=', 'detail.pasar_id')
        //                 ->where('komoditas_id', $komoditas)
        //                 ->where('detail_tgl', $year)
        //                 ->orderBy('harga_publish', 'desc')
        //                 ->get();

        // $colors     = [ 5 => '#09d1ff', 4 => '#09e5ff', 3 => '#09faff', 2 => '#09fff0', 1 => '#09ffdc'];
        // $data       = [];
        
        // foreach ($categories as $pasar) {
        //     $data['chart'] = ['pasar' => ucfirst(strtolower($pasar->namapasar))  , 'value' => $pasar->harga_publish];
        // }
        // if ($request->has('_token')) {
            if ($pasar == 'semua') {
                $namapasar = '';
                $avg = DB::table('detail')
                    ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                    ->select(
                        'detail.*',
                        'komoditas.*',
                        DB::raw('AVG(harga_publish) as total'),
                        DB::raw('AVG(harga_dinamik) as total_kemaren')
                    )
                    ->where('detail.detail_tgl', $year)
                    ->groupBy('komoditas_id')
                    ->get();
            } else {
                $namapasar = $pasar;
                $avg = DB::table('detail')
                    ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                    ->select(
                        'detail.*',
                        'komoditas.*',
                        DB::raw('AVG(harga_publish) as total'),
                        DB::raw('AVG(harga_dinamik) as total_kemaren')
                    )
                    ->where('detail.pasar_id', $pasar)
                    ->where('detail.detail_tgl', $year)
                    ->groupBy('komoditas_id')
                    ->get();
            }

            $data['avg'] = $avg;
        return  $data;
    }

    function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    public function chartKomoditas()
    {
        $komoditas  = request('komoditas');
        $tanggal = request('tgl');      

        $datesekarang = Carbon\carbon::parse($tanggal)->format('Y-m-d');
        $datekemaren = Carbon\carbon::parse($tanggal)->addDay(-1)->format('Y-m-d');

        $show = DB::table("detail")
        ->select("namakomoditas","namapasar","detail.harga_publish",
                  DB::raw("(SELECT harga_publish FROM detail t2
                  WHERE t2.komoditas_id = detail.komoditas_id 
                  AND t2.pasar_id = detail.pasar_id
                  AND detail_tgl = '$datekemaren') as harga_kemaren"))
        ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
        ->join('pasar', 'pasar.id', '=', 'detail.pasar_id')
        ->where('komoditas_id', $komoditas)
        ->where('detail_tgl', $datesekarang)
        ->get();

        $data = [];
        
        foreach ($show as $i) {
            $data[] = ['pasar' => ucfirst(strtolower($i->namapasar))  , 'price_last' => $i->harga_kemaren , 'price_now' => $i->harga_publish];
        }
        return  $data;

    }

    public function chartPasarStatistik()
    {
        $pasar  = request('pasar');
        $tgl_start = request('tgl_start');      
        $tgl_end = request('tgl_end');      

        $datesekarang = Carbon\carbon::parse($tgl_start)->format('Y-m-d');
        $datekemaren = Carbon\carbon::parse($tgl_end)->format('Y-m-d');


        if ($pasar == 'semua') {
            $namapasar = '';
                $show = DB::table("detail")
                ->select(
                    'detail.*',
                    'komoditas.*',
                    DB::raw('AVG(harga_publish) as total'),
                    DB::raw('AVG(harga_dinamik) as total_kemaren')
                )
                ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
                // ->join('pasar', 'pasar.id', '=', 'detail.pasar_id')
                // ->where('pasar_id', $pasar)
                ->where('detail_tgl', $tgl_end)
                ->groupBy('komoditas_id')

                ->get();
                
        } else {
            // $namapasar = $pasar;
            $show = DB::table("detail")
            ->select(
                'detail.*',
                'komoditas.*',
                DB::raw('AVG(harga_publish) as total'),
                DB::raw('AVG(harga_dinamik) as total_kemaren')
            )
            ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
            // ->join('pasar', 'pasar.id', '=', 'detail.pasar_id')
            ->where('pasar_id', $pasar)
            ->where('detail_tgl', $tgl_end)
            ->groupBy('komoditas_id')

            ->get();
        }

        $data = [];
        $kondisi ="";
        $persen ="";
        $harga_sebelum ="";
        foreach ($show as $i) {
                                                if($i->kondisi == 'turun'){
                                                    $kondisi = '<img src="https://ews.kemendag.go.id/markers/harga-d.png">';
                                                    $persen = (($i->total-($i->total+$i->total_kemaren))/$i->total*100).'%';
                                                    $harga_sebelum = $i->total+$i->total_kemaren;
                                                }else if($i->kondisi  == 'naik'){
                                                    $kondisi = '<img src="https://ews.kemendag.go.id/markers/harga-a.png">';
                                                    $persen = (($i->total-($i->total-$i->total_kemaren))/$i->total*100).'%';
                                                    $harga_sebelum = $i->total-$i->total_kemaren;
                                                }else{
                                                    $kondisi = '<img src="https://ews.kemendag.go.id/markers/harga-c.png">';
                                                    $persen = '0%';
                                                    $harga_sebelum = $i->total;
                                                    
                                                }       

            $data[] = [ucfirst(strtolower($i->namakomoditas))  ,$i->satuan, 'Rp '.number_format($harga_sebelum,2,',','.'), 'Rp '.number_format($i->total,2,',','.') ,round($persen, 2).'%' ,$kondisi];
        }
        return $data;

    }

    public function chartDetailKomoditas(){

        $show = DB::table("detail")
        ->select("namakomoditas","satuan","namapasar","detail.harga_publish",
                  DB::raw("(SELECT harga_publish FROM detail t2
                  WHERE t2.komoditas_id = detail.komoditas_id 
                  AND t2.pasar_id = detail.pasar_id
                  AND detail_tgl = '2022-02-21') as harga_kemaren"))
        ->join('komoditas', 'komoditas.id', '=', 'detail.komoditas_id')
        ->join('pasar', 'pasar.id', '=', 'detail.pasar_id')
        ->where('pasar_id', 11)
        ->where('detail_tgl', '2022-02-22')
        ->get();




    }
    public function pdf($tgl,$pasar){
        // $no = 1;
        $dataPasar = DB::table('pasar')->where('id', $pasar)->first();
        $select = DB::table('detail')
        ->join('komoditas', 'detail.komoditas_id', '=', 'komoditas.id')
        ->select('detail.*', 'komoditas.namakomoditas')
        ->where('detail_tgl', $tgl)
        ->where('pasar_id', $pasar)
        ->get();

        return view('page.pdf',[
            'data' => $select,
            'pasar' => $dataPasar
        ]);
    }
}
