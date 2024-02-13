<?php

namespace App\Livewire\Main\Layanan\Bphtb\Modal;
use App\Models\Bphtb\PembayaranPajak ;
use App\Models\Bphtb\ObjekPajakVerifikasi;
use App\Models\Bphtb\ObjekPajak as Model;
use App\Models\Bphtb\Persyaratan;
use App\Models\Pajak\RefJenisTransaksi;
use App\Models\Pajak\RefHakTanah;
use App\Models\Pajak\RefDokTanah;
use App\Models\Pajak\RefPersyaratan;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;


class PerhitunganVerifikasi extends ModalComponent
{
    use LivewireAlert;
    public $title;
    public $listPersyaratanVerifikasi;
    public $listPersyaratanValidasi;
    public $objek_pajak;
    public $file_dokumen;
    public $id_bphtb;
    public $jenis_transaksi_id;
    public $nop;
    public $tahun_pajak;
    public $nama_sppt;
    public $kabupaten_kota;
    public $kecamatan;
    public $kelurahan;
    public $rt;
    public $rw;
    public $alamat;
    public $kode_znt;
    public $pac_input;
    public $lat;
    public $lng;
    public $luas_tanah_lama;
    public $luas_tanah_baru;
    public $njop_tanah;
    public $total_nilai_tanah;
    public $luas_bangunan_lama;
    public $luas_bangunan_baru;
    public $njop_bangunan;
    public $total_nilai_bangunan;
    public $total_nilai_pasar;
    public $harga_transaksi;
    public $jenis_hak_tanah_id;
    public $jenis_dok_tanah_id;
    public $no_dokumen_peralihan;
    public $tgl_dokumen_peralihan;
    public $sudah_terbit_akta;
    public $no_ajb_baru;
    public $tgl_ajb_baru;
    public $latitude;
    public $longitude;
    
    public $nilai_npop;
    public $nilai_njoptkp;
    public $nilai_npopkp;
    public $nilai_bphtb;
    public $nilai_pengenaan;
    public $nilai_aphb;
    public $nilai_bayar_bphtb;
    
    public $listJenisTransaksi;
    public $total_nilai_pasar_terbilang;
    public $total_nilai_transaksi_terbilang;
    
    public $listJenisKepemilikan;
    public $listJenisDokumenTanah;
    
    public $kd_propinsi = "32", $kd_dati2 = "06", $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op;
    
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.modal.objek-pajak');
    }
    
    public function mount($id)
    {
        $bphtb = $id;
        $data = ObjekPajakVerifikasi::where('id_bphtb',$bphtb)->first();
        if($data){
            $this->title = "Ubah";
            $model = ObjekPajakVerifikasi::where('id_bphtb',$bphtb)->first();
        }else{
            $this->title = "Tambah";
            $model = Model::where('id_bphtb',$bphtb)->first();
        }
        $this->listJenisTransaksi = RefJenisTransaksi::orderBy('kd_jenis_transaksi','asc')->get();
        $this->listJenisKepemilikan = RefHakTanah::orderBy('nm_hak_tanah','asc')->get();
        $this->listJenisDokumenTanah = RefDokTanah::orderBy('nm_dok_tanah','asc')->get();
        
        $this->id_bphtb = $model->id_bphtb;
        $this->jenis_transaksi_id = $model->jenis_transaksi_id;
        $this->nop = $model->nop;
        $this->tahun_pajak = $model->tahun_pajak;
        $this->nama_sppt = $model->nama_sppt;
        $this->kabupaten_kota = $model->kabupaten_kota;
        $this->kecamatan = $model->kecamatan;
        $this->kelurahan = $model->kelurahan;
        $this->rt = $model->rt;
        $this->rw = $model->rw;
        $this->alamat = $model->alamat;
        $this->kode_znt = $model->kode_znt;
        $this->pac_input = $model->pac_input;
        $this->lat = $model->lat;
        $this->lng = $model->lng;
        $this->luas_tanah_lama = $model->luas_tanah_lama;
        $this->luas_tanah_baru = $model->luas_tanah_baru;
        $this->njop_tanah = $model->njop_tanah;
        $this->total_nilai_tanah = $model->total_nilai_tanah;
        $this->luas_bangunan_lama = $model->luas_bangunan_lama;
        $this->luas_bangunan_baru = $model->luas_bangunan_baru;
        $this->njop_bangunan = $model->njop_bangunan;
        $this->total_nilai_bangunan = $model->total_nilai_bangunan;
        $this->total_nilai_pasar = $model->total_nilai_pasar;
        $this->harga_transaksi = $model->harga_transaksi;
        $this->jenis_hak_tanah_id = $model->jenis_hak_tanah_id;
        $this->jenis_dok_tanah_id = $model->jenis_dok_tanah_id;
        $this->no_dokumen_peralihan = $model->no_dokumen_peralihan;
        $this->tgl_dokumen_peralihan = $model->tgl_dokumen_peralihan;
        $this->sudah_terbit_akta = $model->sudah_terbit_akta;
        $this->no_ajb_baru = $model->no_ajb_baru;
        $this->tgl_ajb_baru = $model->tgl_ajb_baru;
        // $this->kd_propinsi = $model->kd_propinsi;
        // $this->kd_dati2 = $model->kd_dati2;
        $this->kd_kecamatan = $model->kd_kecamatan;
        $this->kd_kelurahan = $model->kd_kelurahan;
        $this->kd_blok = $model->kd_blok;
        $this->no_urut = $model->no_urut;
        $this->kd_jns_op = $model->kd_jns_op;
        
        $this->nilai_npop = $model->nilai_npop;
        $this->nilai_njoptkp = $model->nilai_njoptkp;
        $this->nilai_npopkp = $model->nilai_npopkp;
        $this->nilai_bphtb = $model->nilai_bphtb;
        $this->nilai_pengenaan = $model->nilai_pengenaan;
        $this->nilai_aphb = $model->nilai_aphb;
        $this->nilai_bayar_bphtb = $model->nilai_bayar_bphtb;
    }

    public function updated($property,$value)
        {
            // dd($property,$value);  
            $kode = $this->kd_propinsi . $this->kd_dati2 . $this->kd_kecamatan . $this->kd_kelurahan . $this->kd_blok . $this->no_urut . $this->kd_jns_op; 
            $tahun = $this->tahun_pajak; 
            $this->nop = $kode;
            if(strlen($kode)==18){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://bphtb.bandungkab.go.id/transaksi/sspd/get_sppt_data_sebelum?kd_propinsi='.$this->kd_propinsi.'&kd_dati2='.$this->kd_dati2.'&kd_kecamatan='.$this->kd_kecamatan.'&kd_kelurahan='.$this->kd_kelurahan.'&kd_blok='.$this->kd_blok.'&no_urut='.$this->no_urut.'&kd_jns_op='.$this->kd_jns_op.'&no_ktp=3172061601820004&tahun_pajak='.$tahun,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Cookie: ci_session=onti146fp52uqdo27kbptjm7saa3jvqc'
                    ),
                ));
                $response = curl_exec($curl);
                if ($response === false) {
                    $error = curl_error($curl);
                    return dd(response()->json(['error' => $error], 500));
                }
                curl_close($curl);
                $json = json_decode($response, true);
                if($json['status']==true){
                    $this->nama_sppt = $json['data']['nm_wp'];
                    $this->kabupaten_kota = $json['data']['kota_wp'];
                    $this->kecamatan = $json['data']['kecamatan_wp'];
                    $this->kelurahan = $json['data']['kelurahan_wp'];
                    $this->rt = $json['data']['rt_wp'];
                    $this->rw = $json['data']['rw_wp'];
                    $this->alamat = $json['data']['jln_wp'];
                    $this->luas_bangunan_lama = $json['data']['luas_bng_sppt'];
                    $this->luas_tanah_lama = $json['data']['luas_bumi_sppt'];
                    
                    if ($json['data']['luas_bng_sppt'] != 0) {
                        $this->njop_bangunan = $json['data']['njop_bng'] / $json['data']['luas_bng_sppt'];
                    } else {
                        // Handle kasus ketika luas_bng_sppt adalah nol
                        $this->njop_bangunan = 0; // Atau nilai default lainnya sesuai kebutuhan
                    }
                    
                    if ($json['data']['luas_bumi_sppt'] != 0) {
                        $this->njop_tanah = $json['data']['njop_bumi'] / $json['data']['luas_bumi_sppt'];
                    } else {
                        // Handle kasus ketika luas_bumi_sppt adalah nol
                        $this->njop_tanah = 0; // Atau nilai default lainnya sesuai kebutuhan
                    }
                    
                    
                    // return $this->alert('success', 'Data NOB Ditemukan an. '.$this->nama_sppt, [
                        //     'position' => 'center',
                        //     'timer' => 3000,
                        //     'toast' => true,
                        //     'timerProgressBar' => true,
                        // ]);  
                    }else{
                        $this->nama_sppt = "No. NOP Tidak Ada / Keliru (Silahkan Cek Kembali)";
                        $this->kabupaten_kota = "-";
                        $this->kecamatan = "-";
                        $this->kelurahan = "-";
                        $this->rt = "-";
                        $this->rw = "-";
                        $this->alamat = "-";
                        $this->luas_bangunan_lama = "-";
                        $this->luas_tanah_lama = "-";
                        $this->njop_bangunan = "-";
                        $this->njop_tanah = "-";    
                        return $this->alert('warning', 'Data NOP '.$this->nop.' Tidak Ditemukan', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                            'timerProgressBar' => true,
                        ]);  
                    }
                    
                }
                $this->total_nilai_tanah = intval($this->luas_tanah_baru) * intval($this->njop_tanah);
                $this->total_nilai_bangunan = intval($this->luas_bangunan_baru) * intval($this->njop_bangunan);
                $this->total_nilai_pasar = intval($this->total_nilai_tanah) + intval($this->total_nilai_bangunan);
                
                // 1. Perhitungan NPOP
                if ($this->harga_transaksi > $this->total_nilai_pasar) {
                    $nilai_npop = $this->harga_transaksi;
                } else {
                    $nilai_npop = $this->total_nilai_pasar;
                }
                $this->nilai_npop = $nilai_npop;
                
                // 2. Perhitungan Nilai Perolehan dari Referensi Jenis Transaksi
                $jenis_transaksi = RefJenisTransaksi::where('id', $this->jenis_transaksi_id)->first();
                $this->nilai_njoptkp = $jenis_transaksi == NULL ? 0 : $jenis_transaksi->nilai_perolehan;
                
                // 3. Perhitungan NJOPTKP (NPOP - Nilai Perolehan)
                $this->nilai_npopkp = abs($this->nilai_npop - $this->nilai_njoptkp);
                
                // 4. 5% dari Perhitungan NJOPTKP
                $this->nilai_bphtb = abs(5 * $this->nilai_npopkp / 100);
                
                // 5. 50% dari Perhitungan Nilai BPHTB apabila karena waris/hibah/wasiat/pemberian hak pengelolaan*)
                if ($this->jenis_transaksi_id == 3 || $this->jenis_transaksi_id == 4 || $this->jenis_transaksi_id == 5) {
                    $this->nilai_pengenaan = abs(50 * $this->nilai_bphtb / 100);
                } else {
                    $this->nilai_pengenaan = 0;
                }
                
                // 6. Perhitungan APHB
                if ($this->jenis_transaksi_id == 18) {
                    $this->nilai_aphb = abs(2.5 * $this->nilai_npop / 100);
                } else {
                    $this->nilai_aphb = 0;
                }
                
                // 7. Total Bayar BPHTB
                $this->nilai_bayar_bphtb = $this->nilai_bphtb + $this->nilai_pengenaan + $this->nilai_aphb;
                
                
                // Terbilang
                $this->total_nilai_pasar_terbilang = strtoupper(terbilang($this->total_nilai_pasar));
                $this->total_nilai_transaksi_terbilang = strtoupper(terbilang($this->harga_transaksi));
            }


            public function create()
            {

                    $objek_pajak = Model::where('id_bphtb', $this->id_bphtb)->first();
                    if (!$objek_pajak) {
                        // Handle jika objek pajak tidak ditemukan
                        return redirect()->back()->with('error', 'Objek pajak tidak ditemukan.');
                    }
                    
                    $verifikasi = ObjekPajakVerifikasi::firstOrNew(['id_bphtb' => $this->id_bphtb]);
                    
                    // Mengganti data verifikasi dengan data dari objek pajak
                    $verifikasi->fill($objek_pajak->toArray());
                    
                    // Mengatur nilai created_id dan created_at
                    $verifikasi->created_id = Auth::user()->id;
                    $verifikasi->created_at = date('Y-m-d H:i:s');  
                    
                    $verifikasi->id_bphtb = $this->id_bphtb;
                    $verifikasi->jenis_transaksi_id = $this->jenis_transaksi_id;
                    $verifikasi->nop = $this->nop;
                    $verifikasi->tahun_pajak = $this->tahun_pajak;
                    $verifikasi->nama_sppt = $this->nama_sppt;
                    $verifikasi->kabupaten_kota = $this->kabupaten_kota;
                    $verifikasi->kecamatan = $this->kecamatan;
                    $verifikasi->kelurahan = $this->kelurahan;
                    $verifikasi->rt = $this->rt;
                    $verifikasi->rw = $this->rw;
                    $verifikasi->alamat = $this->alamat;
                    $verifikasi->kode_znt = $this->kode_znt;
                    $verifikasi->pac_input = $this->pac_input;
                    $verifikasi->lat = $this->lat;
                    $verifikasi->lng = $this->lng;
                    $verifikasi->luas_tanah_lama = $this->luas_tanah_lama;
                    $verifikasi->luas_tanah_baru = $this->luas_tanah_baru;
                    $verifikasi->njop_tanah = $this->njop_tanah;
                    $verifikasi->total_nilai_tanah = $this->total_nilai_tanah;
                    $verifikasi->luas_bangunan_lama = $this->luas_bangunan_lama;
                    $verifikasi->luas_bangunan_baru = $this->luas_bangunan_baru;
                    $verifikasi->njop_bangunan = $this->njop_bangunan;
                    $verifikasi->total_nilai_bangunan = $this->total_nilai_bangunan;
                    $verifikasi->total_nilai_pasar = $this->total_nilai_pasar;
                    $verifikasi->harga_transaksi = $this->harga_transaksi;
                    $verifikasi->jenis_hak_tanah_id = $this->jenis_hak_tanah_id;
                    $verifikasi->jenis_dok_tanah_id = $this->jenis_dok_tanah_id;
                    $verifikasi->no_dokumen_peralihan = $this->no_dokumen_peralihan;
                    $verifikasi->tgl_dokumen_peralihan = $this->tgl_dokumen_peralihan;
                    $verifikasi->sudah_terbit_akta = $this->sudah_terbit_akta;
                    $verifikasi->no_ajb_baru = $this->no_ajb_baru;
                    $verifikasi->tgl_ajb_baru = $this->tgl_ajb_baru;
                    
                    $verifikasi->kd_propinsi = $this->kd_propinsi;
                    $verifikasi->kd_dati2 = $this->kd_dati2;
                    $verifikasi->kd_kecamatan = $this->kd_kecamatan;
                    $verifikasi->kd_kelurahan = $this->kd_kelurahan;
                    $verifikasi->kd_blok = $this->kd_blok;
                    $verifikasi->no_urut = $this->no_urut;
                    $verifikasi->kd_jns_op = $this->kd_jns_op;
                    
                    $verifikasi->nilai_npop = $this->nilai_npop;
                    $verifikasi->nilai_njoptkp = $this->nilai_njoptkp;
                    $verifikasi->nilai_npopkp = $this->nilai_npopkp;
                    $verifikasi->nilai_bphtb = $this->nilai_bphtb;
                    $verifikasi->nilai_pengenaan = $this->nilai_pengenaan;
                    $verifikasi->nilai_aphb = $this->nilai_aphb;
                    $verifikasi->nilai_bayar_bphtb = $this->nilai_bayar_bphtb;
                    
                    // Simpan data verifikasi
                    
                    if($verifikasi->save()){

                        $objek_pajak = Model::where('id_bphtb', $this->id_bphtb)->first();
                        $verifikasi = ObjekPajakVerifikasi::where('id_bphtb', $this->id_bphtb)->first();

                        if($objek_pajak->nilai_bayar_bphtb == $verifikasi->nilai_bayar_bphtb){
                            $status = 1;
                        }elseif($objek_pajak->nilai_bayar_bphtb < $verifikasi->nilai_bayar_bphtb){
                            $status = 2;
                        }elseif($objek_pajak->nilai_bayar_bphtb >= $verifikasi->nilai_bayar_bphtb){
                            $status = 1;
                        }
                        $pembayaran_pajak = PembayaranPajak::where('id_bphtb',$this->id_bphtb)->first();
                        $pembayaran_pajak->status_validasi = $status;
                        $pembayaran_pajak->validasi_id = Auth::user()->id;
                        $pembayaran_pajak->tanggal_validasi = date('Y-m-d H:i:s'); 
                               
                        if($pembayaran_pajak->update()){
                            $this->alert('success', 'Perubahan Data Objek Pajak an.'.$verifikasi->nama_wp.' Berhasil di Simpan', [
                                'position' => 'top',
                                'timer' => 3000,
                                'toast' => true,
                                'timerProgressBar' => true,
                            ]);
                            return redirect()->route('main.verifikasi.bphtb.detail', [Crypt::encrypt($verifikasi->id_bphtb)]);
                        }
                    }else{
                        $this->alert('error', 'Perubahan Data Objek Pajak an.'.$verifikasi->nama_wp.' Gagal di Simpan', [
                            'position' => 'top',
                            'timer' => 3000,
                            'toast' => true,
                            'timerProgressBar' => true,
                        ]);
                        return redirect()->route('main.verifikasi.bphtb.detail', [Crypt::encrypt($verifikasi->id_bphtb)]);
                    }
                }
                
    
}

