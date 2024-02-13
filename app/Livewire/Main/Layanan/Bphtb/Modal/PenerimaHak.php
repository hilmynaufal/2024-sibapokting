<?php
namespace App\Livewire\Main\Layanan\Bphtb\Modal;
use App\Models\Bphtb\PenerimaHak as Model;
use App\Models\Bphtb\PelepasHak;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;


class PenerimaHak extends ModalComponent
{
    use LivewireAlert;
    public $jenis_wp, $nik, $npwp, $nama_wp, $alamat, $idProvinsi, $provinsi, $idKab, $kota_kab, $idKecamatan, $kecamatan, $idKelurahan, $kelurahan, $rt, $rw, $kode_pos, $no_hp, $id_bphtb;
    public $penerima_hak;
    public $provinsiList;
    public $kabupatenList;
    public $kecamatanList;
    public $kelurahanList;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.modal.penerima-hak');
    }
    
    public function mount($id)
    {
        $bphtb = $id;
        $penerima_hak = Model::where('id_bphtb',$bphtb)->first();
        $this->id_bphtb = $bphtb;
        $this->jenis_wp = $penerima_hak->jenis_wp;
        $this->nik = $penerima_hak->nik;
        $this->npwp = $penerima_hak->npwp;
        $this->nama_wp = $penerima_hak->nama_wp;
        $this->alamat = $penerima_hak->alamat;
        $this->idProvinsi = $penerima_hak->id_provinsi;
        $this->provinsi = $penerima_hak->provinsi;
        $this->idKab = $penerima_hak->id_kota_kab;
        $this->kota_kab = $penerima_hak->kota_kab;
        $this->idKecamatan = $penerima_hak->id_kecamatan;
        $this->kecamatan = $penerima_hak->kecamatan;
        $this->idKelurahan = $penerima_hak->id_kelurahan;
        $this->kelurahan = $penerima_hak->kelurahan;
        $this->rt = $penerima_hak->rt;
        $this->rw = $penerima_hak->rw;
        $this->kode_pos = $penerima_hak->kode_pos;
        $this->no_hp = $penerima_hak->no_hp;

        $this->provinsiList        = RefProvinsi::orderBy('name','ASC')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $this->idProvinsi)->orderBy('name','ASC')->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $this->idKab)->orderBy('name','ASC')->get();
        $this->kelurahanList       = RefDesa::where('district_id', $this->idKecamatan)->orderBy('name','ASC')->get();
        // dd($this->kabupatenList);
        
    }
    
    public function updatedIdProvinsi($idProvinsi){
        $this->kabupatenList = RefKabupaten::where('province_id', $this->idProvinsi)->get();
    }
    
    public function updatedIdKab($idKab){
        $this->kecamatanList = RefKecamatan::where('regency_id', $this->idKab)->get();
        
    }
    
    public function updatedIdKecamatan($idKecamatan){
        $this->kelurahanList = RefDesa::where('district_id', $this->idKecamatan)->get();
        
    }
    
    public function create()
    {
        $this->validate([
                'jenis_wp' => 'required',
                'nik' => 'required',
                // 'nik' => 'required|unique:t_bphtb_pelepas_hak,nik',
                'nama_wp' => 'required',
                'alamat' => 'required',
                'no_hp' => 'required',
            ]);
            $model = Model::where('id_bphtb',$this->id_bphtb)->first();
            
            $provinsi = RefProvinsi::select('name')->where('id', $this->idProvinsi)->first();
            $kota_kab = RefKabupaten::select('name')->where('id', $this->idKab)->first();
            $kecamatan = RefKecamatan::select('name')->where('id', $this->idKecamatan)->first();
            $desa = RefDesa::select('name')->where('id', $this->idKelurahan)->first();
            
            $model->id_bphtb = $this->id_bphtb;
            $model->jenis_wp = $this->jenis_wp;
            $model->nik = $this->nik;
            $model->npwp = $this->npwp;
            $model->nama_wp = $this->nama_wp;
            $model->alamat = $this->alamat;
            $model->id_provinsi = $this->idProvinsi;
            $model->provinsi = $provinsi->name;
            $model->id_kota_kab = $this->idKab;
            $model->kota_kab = $kota_kab->name;
            $model->id_kecamatan = $this->idKecamatan;
            $model->kecamatan = $kecamatan->name;
            $model->id_kelurahan = $this->idKelurahan;
            $model->kelurahan = $desa->name;
            $model->rt = $this->rt;
            $model->rw = $this->rw;
            $model->kode_pos = $this->kode_pos;
            $model->no_hp = $this->no_hp;    
            $model->updated_id = Auth::user()->id;
            $model->updated_at = date('Y-m-d H:i:s');        
            if($model->update()){
                $this->alert('success', 'Perubahan Data Penjual an.'.$model->nama_wp.' Berhasil di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('main.verifikasi.bphtb.detail', [Crypt::encrypt($model->id_bphtb)]);
            }else{
                $this->alert('error', 'Perubahan Data Penjual an.'.$model->nama_wp.' Gagal di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('main.verifikasi.bphtb.detail', [Crypt::encrypt($model->id_bphtb)]);
            }
            
    }
    
}