<?php
namespace App\Livewire\Main\Layanan\Bphtb;
use App\Models\Bphtb\ObjekPajak as Model;
use App\Models\Bphtb\ObjekPajakVerifikasi;
use App\Models\Bphtb\PenerimaHak;
use App\Models\Bphtb\PelepasHak;
use App\Models\Bphtb\PembayaranPajak;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class Detail extends Component
{
    use LivewireAlert;
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
    public $id_bphtb;
    public $latitude;
    public $longitude;
    
    public $nilai_npop;
    public $nilai_njoptkp;
    public $nilai_npopkp;
    public $nilai_bphtb;
    public $nilai_pengenaan;
    public $nilai_aphb;
    public $nilai_bayar_bphtb;
    public $kd_propinsi = "32", $kd_dati2 = "06", $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op;
    
    public $penerima_hak;
    public $pelepas_hak;
    public $objek_pajak;
    public $pembayaran_pajak;
    public $no_registrasi;
    public $tanggal_pendaftaran;
    
    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.main.layanan.bphtb.detail');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $model = Model::where('id_bphtb',$bphtb)->first();
        $this->objek_pajak = Model::where('id_bphtb',$bphtb)->first();
        $this->penerima_hak = PenerimaHak::where('id_bphtb',$bphtb)->first();
        $this->pelepas_hak = PelepasHak::where('id_bphtb',$bphtb)->first();
        $this->pembayaran_pajak = PembayaranPajak::where('id_bphtb',$bphtb)->first();
        $this->objek_pajak_verifikasi = ObjekPajakVerifikasi::where('id_bphtb',$bphtb)->first();
        // dd($bphtb);

        $this->id_bphtb = $model->id_bphtb;
    }
    
    public function create()
    {
        $objek_pajak = Model::where('id_bphtb',$this->id_bphtb)->first();
        $penerima_hak = PenerimaHak::where('id_bphtb',$this->id_bphtb)->first();
        $pelepas_hak = PelepasHak::where('id_bphtb',$this->id_bphtb)->first();
        
        $pembayaran = PembayaranPajak::updateOrCreate([
            'id_bphtb' => $this->id_bphtb,
        ], [
            'kode_bayar' => generateKodePembayaran(),
            'total_tagihan' => $objek_pajak->nilai_bayar_bphtb,
            ])->update([
                'created_id' => Auth::user()->id,
                'created_at' => now(),
                'updated_id' => Auth::user()->id,
                'updated_at' => now(),
                'id_bphtb' => $this->id_bphtb,
                'kode_bayar' => generateKodePembayaran(),
                'tanggal_tagihan' => now(),
                'status_tagihan' => 'Aktif',
                'batas_waktu_tagihan' => now()->addDays(7),
                'total_tagihan' => $objek_pajak->nilai_bayar_bphtb,
                'penerima_hak_id' => $penerima_hak->id,
                'pelepas_hak_id' => $pelepas_hak->id,
                'objek_pajak_id' => $objek_pajak->id,
                'no_registrasi' => generateKodeRegistrasi(),
                'tanggal_pendaftaran' => now(),
            ]);
            return redirect()->route('main.layanan.bphtb.index');
        }
        
        public function backForm()
        {
            return redirect()->route('bphtb.form.maps', [Crypt::encrypt($this->id_bphtb)]);
        }
        
        public function editPenerimaHak()
        {
            return redirect()->route('bphtb.form.penerima.hak.edit', [Crypt::encrypt($this->id_bphtb)]);
        }
        
        public function editPelepasHak()
        {
            return redirect()->route('bphtb.form.pelepas.hak', [Crypt::encrypt($this->id_bphtb)]);
        }
        
        public function editObjekPajak()
        {
            return redirect()->route('bphtb.form.objek.pajak', [Crypt::encrypt($this->id_bphtb)]);
        }
        
        public function editMaps()
        {
            return redirect()->route('bphtb.form.maps', [Crypt::encrypt($this->id_bphtb)]);
        }
        
    }
    