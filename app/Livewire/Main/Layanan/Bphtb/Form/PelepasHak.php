<?php

namespace App\Livewire\Main\Layanan\Bphtb\Form;
use App\Models\Bphtb\PelepasHak as Model;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;


class PelepasHak extends Component
{
    use LivewireAlert;
    public $jenis_wp, $nik, $npwp, $nama_wp, $alamat, $idProvinsi, $provinsi, $idKab, $kota_kab, $idKecamatan, $kecamatan, $idKelurahan, $kelurahan, $rt, $rw, $kode_pos, $no_hp, $id_bphtb;
    
    public $provinsiList;
    public $kabupatenList;
    public $kecamatanList;
    public $kelurahanList;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.form.pelepas-hak');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $model = Model::where('id_bphtb',$bphtb)->first();
        
        $this->provinsiList        = RefProvinsi::orderBy('name','asc')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $model->id_provinsi)->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $model->id_kota_kab)->get();
        $this->kelurahanList       = RefDesa::where('district_id', $model->id_kecamatan)->get();
        // dd($model);
        $this->id_bphtb = $model->id_bphtb;
        $this->jenis_wp = $model->jenis_wp;
        $this->nik = $model->nik;
        $this->npwp = $model->npwp;
        $this->nama_wp = $model->nama_wp;
        $this->alamat = $model->alamat;
        $this->idProvinsi = $model->id_provinsi;
        $this->provinsi = $model->provinsi;
        $this->idKab = $model->id_kota_kab;
        $this->kota_kab = $model->kota_kab;
        $this->idKecamatan = $model->id_kecamatan;
        $this->kecamatan = $model->kecamatan;
        $this->idKelurahan = $model->id_kelurahan;
        $this->kelurahan = $model->kelurahan;
        $this->rt = $model->rt;
        $this->rw = $model->rw;
        $this->kode_pos = $model->kode_pos;
        $this->no_hp = $model->no_hp;
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
        // $this->validate([
            //     'jenis_wp' => 'required',
            //     'nik' => 'required',
            //     // 'nik' => 'required|unique:t_bphtb_pelepas_hak,nik',
            //     'nama_wp' => 'required',
            //     'alamat' => 'required',
            //     'no_hp' => 'required',
            // ]);
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
                // return redirect()->route('bphtb.form.objek.pajak', [$model->id_bphtb]);
                return redirect()->route('bphtb.form.objek.pajak', [Crypt::encrypt($model->id_bphtb)]);
                $this->resetInput();
                return $this->alert('success', 'Laporan Disposisi Berhasil di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
            }else{
                return $this->alert('error', 'Laporan Disposisi Gagal di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
            }
            
        }
        
        public function backForm()
        {
            return redirect()->route('bphtb.form.penerima.hak.edit', [Crypt::encrypt($this->id_bphtb)]);
        }
    }
    