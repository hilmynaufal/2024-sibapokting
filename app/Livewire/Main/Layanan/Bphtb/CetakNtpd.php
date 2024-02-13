<?php
namespace App\Livewire\Main\Layanan\Bphtb;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Livewire\Component;
use App\Models\Bphtb\ObjekPajak as Model;
use App\Models\Bphtb\PelepasHak;
use App\Models\Bphtb\PenerimaHak;
use App\Models\Bphtb\PembayaranPajak;
use Illuminate\Support\Facades\Crypt;

class CetakNtpd extends Component
{
    // VARIABLE PELEPAS HAK
    public $bphtbID;
    public $jenis_wp;
    public $nik;
    public $npwp;
    public $nama_wp;
    public $alamat;
    public $id_provinsi;
    public $provinsi;
    public $id_kota_kab;
    public $kota_kab;
    public $id_kecamatan;
    public $kecamatan;
    public $id_kelurahan;
    public $kelurahan;
    public $rt;
    public $rw;
    public $kode_pos;
    public $no_hp;

    // VARIABLE PENERIMA HAK
    public $penerima_jenis_wp;
    public $penerima_nik;
    public $penerima_npwp;
    public $penerima_nama_wp;
    public $penerima_alamat;
    public $penerima_id_provinsi;
    public $penerima_provinsi;
    public $penerima_id_kota_kab;
    public $penerima_kota_kab;
    public $penerima_id_kecamatan;
    public $penerima_kecamatan;
    public $penerima_id_kelurahan;
    public $penerima_kelurahan;
    public $penerima_rt;
    public $penerima_rw;
    public $penerima_kode_pos;
    public $penerima_no_hp;
    
    // VARIABLE OBJEK PAJAK
    public $op_jenis_transaksi_id;
    public $op_nop;
    public $op_tahun_pajak;
    public $op_nama_sppt;
    public $op_kabupaten_kota;
    public $op_kecamatan;
    public $op_kelurahan;
    public $op_rt;
    public $op_rw;
    public $op_alamat;
    public $op_kode_znt;
    public $op_pac_input;
    public $op_lat;
    public $op_lng;
    public $op_luas_tanah_lama;
    public $op_luas_tanah_baru;
    public $op_njop_tanah;
    public $op_total_nilai_tanah;
    public $op_luas_bangunan_lama;
    public $op_luas_bangunan_baru;
    public $op_njop_bangunan;
    public $op_total_nilai_bangunan;
    public $op_total_nilai_pasar;
    public $op_harga_transaksi;
    public $op_jenis_hak_tanah_id;
    public $op_jenis_dok_tanah_id;
    public $op_no_dokumen_peralihan;
    public $op_tgl_dokumen_peralihan;
    public $op_sudah_terbit_akta;
    public $op_no_ajb_baru;
    public $op_tgl_ajb_baru;
    public $op_kd_propinsi;
    public $op_kd_dati2;
    public $op_kd_kecamatan;
    public $op_kd_kelurahan;
    public $op_kd_blok;
    public $op_no_urut;
    public $op_kd_jns_op;
    public $op_nilai_npop;
    public $op_nilai_njoptkp;
    public $op_nilai_npopkp;
    public $op_nilai_bphtb;
    public $op_nilai_pengenaan;
    public $op_nilai_aphb;
    public $op_nilai_bayar_bphtb;

    // VARIABLE PEMBAYARAN

    public $pembayaran_jenis_tagihan;
    public $pembayaran_kode_bayar;
    public $pembayaran_status_tagihan;
    public $pembayaran_tanggal_tagihan;
    public $pembayaran_batas_waktu_tagihan;
    public $pembayaran_total_tagihan;
    public $pembayaran_tagihan_id;
    public $pembayaran_status_bayar;
    public $pembayaran_tanggal_bayar;
    public $pembayaran_bayar_id;
    public $pembayaran_status_validasi;
    public $pembayaran_tanggal_validasi;
    public $pembayaran_validasi_id;
    public $pembayaran_penerima_hak_id;
    public $pembayaran_pelepas_hak_id;
    public $pembayaran_objek_pajak_id;
    public $pembayaran_no_registrasi;
    public $pembayaran_tanggal_pendaftaran;




   

    public function render()
    {
        return view('livewire.main.layanan.bphtb.cetak.cetak-ntpd')->extends('components.layouts.keenthemes.print_no_table');
    }

    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $data = Model::where('id_bphtb',$bphtb)->first();
        $pelepas_hak = PelepasHak::where('id_bphtb',$bphtb)->first();
        $penerima_hak = PenerimaHak::where('id_bphtb',$bphtb)->first();
        $pembayaran = PembayaranPajak::where('id_bphtb',$bphtb)->first();
        // $penilaian = Penilaian::where('siswa_id', $data->id)->where('tingkatan_sabuk', 3)->first();
        $arrNop = str_split($data->nop);
        // dd($pembayaran);
        if ($data) {
            $this->penerima_jenis_wp        = $penerima_hak->jenis_wp;
            $this->penerima_nik             = $penerima_hak->nik;
            $this->penerima_npwp            = $penerima_hak->npwp;
            $this->penerima_nama_wp         = $penerima_hak->nama_wp;
            $this->penerima_alamat          = $penerima_hak->alamat;
            $this->penerima_id_provinsi     = $penerima_hak->id_provinsi;
            $this->penerima_provinsi        = $penerima_hak->provinsi;
            $this->penerima_id_kota_kab     = $penerima_hak->id_kota_kab;
            $this->penerima_kota_kab        = $penerima_hak->kota_kab;
            $this->penerima_id_kecamatan    = $penerima_hak->id_kecamatan;
            $this->penerima_kecamatan       = $penerima_hak->kecamatan;
            $this->penerima_id_kelurahan    = $penerima_hak->id_kelurahan;
            $this->penerima_kelurahan       = $penerima_hak->kelurahan;
            $this->penerima_rt              = $penerima_hak->rt;
            $this->penerima_rw              = $penerima_hak->rw;
            $this->penerima_kode_pos        = $penerima_hak->kode_pos;
            $this->penerima_no_hp           = $penerima_hak->no_hp;

            
            $this->jenis_wp                 = $pelepas_hak->jenis_wp;
            $this->nik                      = $pelepas_hak->nik;
            $this->npwp                     = $pelepas_hak->npwp;
            $this->nama_wp                  = $pelepas_hak->nama_wp;
            $this->alamat                   = $pelepas_hak->alamat;
            $this->id_provinsi              = $pelepas_hak->id_provinsi;
            $this->provinsi                 = $pelepas_hak->toProvinsi->name;
            $this->id_kota_kab              = $pelepas_hak->id_kota_kab;
            $this->kota_kab                 = $pelepas_hak->tokabupaten->name;
            $this->id_kecamatan             = $pelepas_hak->id_kecamatan;
            $this->kecamatan                = $pelepas_hak->tokecamatan->name;
            $this->id_kelurahan             = $pelepas_hak->id_kelurahan;
            $this->kelurahan                = $pelepas_hak->toDesa->name;
            $this->rt                       = $pelepas_hak->rt;
            $this->rw                       = $pelepas_hak->rw;
            $this->kode_pos                 = $pelepas_hak->kode_pos;
            $this->no_hp                    = $pelepas_hak->no_hp;
            $this->bphtbID                  = $data->id_bphtb;
            
            $this->op_jenis_transaksi_id    = $data->jenisPerolehan->nm_jenis_transaksi;
            $this->op_nop                   = $arrNop[0].$arrNop[1].'.'.$arrNop[3].$arrNop[4].'.'.$arrNop[5].$arrNop[6].$arrNop[7]
                                            .'.'.$arrNop[8].$arrNop[9].$arrNop[10].'.'.$arrNop[11].$arrNop[12].$arrNop[13].$arrNop[14].'-'.$arrNop[15];
            $this->op_tahun_pajak           = $data->tahun_pajak;
            $this->op_nama_sppt             = $data->nama_sppt;
            $this->op_kabupaten_kota        = $data->kabupaten_kota;
            $this->op_kecamatan             = $data->kecamatan;
            $this->op_kelurahan             = $data->kelurahan;
            $this->op_rt                    = $data->rt;
            $this->op_rw                    = $data->rw;
            $this->op_alamat                = $data->alamat;
            $this->op_kode_znt              = $data->kode_znt;
            $this->op_pac_input             = $data->pac_input;
            $this->op_lat                   = $data->lat;
            $this->op_lng                   = $data->lng;
            $this->op_luas_tanah_lama       = $data->luas_tanah_lama;
            $this->op_luas_tanah_baru       = $data->luas_tanah_baru;
            $this->op_njop_tanah            = $data->njop_tanah;
            $this->op_total_nilai_tanah     = $data->total_nilai_tanah;
            $this->op_luas_bangunan_lama    = $data->luas_bangunan_lama;
            $this->op_luas_bangunan_baru    = $data->luas_bangunan_baru;
            $this->op_njop_bangunan         = $data->njop_bangunan;
            $this->op_total_nilai_bangunan  = $data->total_nilai_bangunan;
            $this->op_total_nilai_pasar     = $data->total_nilai_pasar;
            $this->op_harga_transaksi       = $data->harga_transaksi;
            $this->op_jenis_hak_tanah_id    = $data->jenis_hak_tanah_id;
            $this->op_jenis_dok_tanah_id    = $data->jenis_dok_tanah_id;
            $this->op_no_dokumen_peralihan  = $data->no_dokumen_peralihan;
            $this->op_tgl_dokumen_peralihan = $data->tgl_dokumen_peralihan;
            $this->op_sudah_terbit_akta     = $data->sudah_terbit_akta;
            $this->op_no_ajb_baru           = $data->no_ajb_baru;
            $this->op_tgl_ajb_baru          = $data->tgl_ajb_baru;
            $this->no_hp                    = $data->no_hp;
            $this->op_kd_propinsi           = $data->kd_propinsi;
            $this->op_kd_dati2              = $data->kd_dati2;
            $this->op_kd_kecamatan          = $data->kd_kecamatan;
            $this->op_kd_kelurahan          = $data->kd_kelurahan;
            $this->op_kd_blok               = $data->kd_blok;
            $this->op_no_urut               = $data->no_urut;
            $this->op_kd_jns_op             = $data->kd_jns_op;
            $this->op_nilai_npop            = $data->nilai_npop;
            $this->op_nilai_njoptkp         = $data->nilai_njoptkp;
            $this->op_nilai_npopkp          = $data->nilai_npopkp;
            $this->op_nilai_bphtb           = $data->nilai_bphtb;
            $this->op_nilai_pengenaan       = $data->nilai_pengenaan;
            $this->op_nilai_aphb            = $data->nilai_aphb;
            $this->op_nilai_bayar_bphtb     = $data->nilai_bayar_bphtb;

            $this->pembayaran_jenis_tagihan         = $pembayaran->jenis_tagihan;
            $this->pembayaran_kode_bayar            = $pembayaran->kode_bayar;
            $this->pembayaran_status_tagihan        = $pembayaran->status_tagihan;
            $this->pembayaran_tanggal_tagihan       = $pembayaran->tanggal_tagihan;
            $this->pembayaran_batas_waktu_tagihan   = $pembayaran->batas_waktu_tagihan;
            $this->pembayaran_total_tagihan         = $pembayaran->total_tagihan;
            $this->pembayaran_tagihan_id            = $pembayaran->tagihan_id;
            $this->pembayaran_status_bayar          = $pembayaran->status_bayar;
            $this->pembayaran_tanggal_bayar         = $pembayaran->tanggal_bayar;
            $this->pembayaran_bayar_id              = $pembayaran->bayar_id;
            $this->pembayaran_status_validasi       = $pembayaran->status_validasi;
            $this->pembayaran_tanggal_validasi      = $pembayaran->tanggal_validasi;
            $this->pembayaran_validasi_id           = $pembayaran->validasi_id;
            $this->pembayaran_penerima_hak_id       = $pembayaran->penerima_hak_id;
            $this->pembayaran_pelepas_hak_id        = $pembayaran->pelepas_hak_id;
            $this->pembayaran_objek_pajak_id        = $pembayaran->objek_pajak_id;
            $this->pembayaran_no_registrasi         = $pembayaran->no_registrasi;
            $this->pembayaran_tanggal_pendaftaran   = $pembayaran->tanggal_pendaftaran;
        }
        
        // $this->dropdown_pusat = Pusat::where('visibled', 1)->get();
        // $this->dropdown_cabang = Cabang::where('visibled', 1)->orderBy('nama','asc')->get();
        // $this->radio_gender = Status::where('type', 5)->orderBy('code', 'asc')->get();
        // $this->dropdown_agama = Status::where('type', 19)->orderBy('code', 'asc')->get();
        // $this->penilaian = StatusPSHT::where('type', 2)->orderBy('code', 'asc')->get();
        // $this->dropdown_pendidikan = Status::where('type', 20)->orderBy('code', 'asc')->get();
        // $this->dropdown_pekerjaan = Status::where('type', 21)->orderBy('code', 'asc')->get();
        // $this->dropdown_penghasilan = Status::where('type', 22)->orderBy('code', 'asc')->get();
    }

}