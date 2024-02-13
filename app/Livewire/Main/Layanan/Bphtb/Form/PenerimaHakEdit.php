<?php

namespace App\Livewire\Main\Layanan\Bphtb\Form;
use App\Models\Bphtb\PenerimaHak as Model;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;


class PenerimaHakEdit extends Component
{
    use LivewireAlert;
    public $jenis_wp, $nik, $npwp, $nama_wp, $alamat, $idProvinsi, $provinsi, $idKab, $kota_kab, $idKecamatan, $kecamatan, $idKelurahan, $kelurahan, $rt, $rw, $kode_pos, $no_hp, $id_bphtb;
    
    public $provinsiList;
    public $kabupatenList;
    public $kecamatanList;
    public $kelurahanList;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.form.penerima-hak');
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
        $this->validate([
            'jenis_wp' => 'required',
            'nik' => 'required',
            // 'nik' => 'required|unique:t_bphtb_penerima_hak,nik',
            'nama_wp' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);
        
        $provinsi = RefProvinsi::select('name')->where('id', $this->idProvinsi)->first();
        $kota_kab = RefKabupaten::select('name')->where('id', $this->idKab)->first();
        $kecamatan = RefKecamatan::select('name')->where('id', $this->idKecamatan)->first();
        $desa = RefDesa::select('name')->where('id', $this->idKelurahan)->first();
        
        $model = Model::where('id_bphtb',$this->id_bphtb)->update(
            [
                'jenis_wp' => $this->jenis_wp,
                'nik' => $this->nik,
                'npwp' => $this->npwp,
                'nama_wp' => $this->nama_wp,
                'alamat' => $this->alamat,
                'id_provinsi' => $this->idProvinsi,
                'provinsi' => $provinsi->name,
                'id_kota_kab' => $this->idKab,
                'kota_kab' => $kota_kab->name,
                'id_kecamatan' => $this->idKecamatan,
                'kecamatan' => $kecamatan->name,
                'id_kelurahan' => $this->idKelurahan,
                'kelurahan' => $desa->name,
                'rt' => $this->rt,
                'rw' => $this->rw,
                'kode_pos' => $this->kode_pos,
                'no_hp' => $this->no_hp,
                'id_bphtb' => $this->id_bphtb,
                'updated_id' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            if($model){
                // $this->alert('success', 'Laporan Disposisi Berhasil di Simpan', [
                    //     'position' => 'top',
                    //     'timer' => 3000,
                    //     'toast' => true,
                    //     'timerProgressBar' => true,
                    // ]);
                    return redirect()->route('bphtb.form.pelepas.hak', [Crypt::encrypt($this->id_bphtb)]);
                }else{
                    // return $this->alert('error', 'Laporan Disposisi Gagal di Simpan', [
                        //     'position' => 'top',
                        //     'timer' => 3000,
                        //     'toast' => true,
                        //     'timerProgressBar' => true,
                        // ]);
                    }
                    
                }
                
            }
            