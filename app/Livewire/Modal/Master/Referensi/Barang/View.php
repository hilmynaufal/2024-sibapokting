<?php
namespace App\Livewire\Modal\Master\Referensi\Barang;
use App\Models\Referensi\RefBarang as Model;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use Illuminate\Support\Facades\Crypt;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class View extends ModalComponent
{
    use LivewireAlert;

    public $id;
    public $namabarang;
    public $satuan;
    public $gambar;
    
    public function render()
    {
        return view('livewire.modal.master.referensi.barang.view');
    }
    
    public function mount($id)
    {

        $data = Model::where('id',$id)->first();
        $this->id = $data->id;
        $this->namabarang = $data->namabarang;
        $this->satuan = $data->satuan;
        $this->gambar = $data->gambar;
        
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
    
    public function updatedIdProvinsi($idProvinsi){
        $this->kabupatenList = RefKabupaten::where('province_id', $this->idProvinsi)->get();
    }
    
    public function updatedIdKab($idKab){
        $this->kecamatanList = RefKecamatan::where('regency_id', $this->idKab)->get();
        
    }
    
    public function updatedIdKecamatan($idKecamatan){
        $this->kelurahanList = RefDesa::where('district_id', $this->idKecamatan)->get();
        
    }

    public static function destroyOnClose(): bool
    {
        return true;
    }

    public static function closeModalOnClickAway(): bool
{
    return false;
}
    
}

