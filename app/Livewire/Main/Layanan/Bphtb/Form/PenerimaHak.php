<?php

namespace App\Livewire\Main\Layanan\Bphtb\Form;
use App\Models\Bphtb\PenerimaHak as Model;
use App\Models\Bphtb\PelepasHak;
use App\Models\Bphtb\ObjekPajak;
use App\Models\Bphtb\PembayaranPajak;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;


class PenerimaHak extends Component
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
    
    public function mount()
    {
        $lastPenjual = Model::count();
        if ($lastPenjual) {
            $this->id_bphtb = $lastPenjual + 1;
        } else {
            $this->id_bphtb = 1;
        }
        $this->provinsiList        = RefProvinsi::orderBy('name','ASC')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $this->idProvinsi)->orderBy('name','ASC')->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $this->idKab)->orderBy('name','ASC')->get();
        $this->kelurahanList       = RefDesa::where('district_id', $this->idKecamatan)->orderBy('name','ASC')->get();
        
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
        
        $model = Model::create([
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
            'created_id' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        if($model->save()){
            $pelepas_hak = PelepasHak::firstOrNew(['id_bphtb' =>  $model->id_bphtb]);
            $pelepas_hak->created_id = Auth::user()->id;
            $pelepas_hak->created_at = date('Y-m-d H:i:s');
            $pelepas_hak->id_bphtb = $model->id_bphtb;
            $pelepas_hak->save();
            $objek_pajak = ObjekPajak::firstOrNew(['id_bphtb' =>  $model->id_bphtb]);
            $objek_pajak->id_bphtb = $model->id_bphtb;
            $objek_pajak->created_id = Auth::user()->id;
            $objek_pajak->created_at = date('Y-m-d H:i:s');
            $objek_pajak->save();
            $pembayaran = PembayaranPajak::firstOrNew(['id_bphtb' =>  $model->id_bphtb]);
            $pembayaran->id_bphtb = $model->id_bphtb;
            $pembayaran->created_id = Auth::user()->id;
            $pembayaran->created_at = date('Y-m-d H:i:s');
            $pembayaran->save();
            $this->reset();
            return redirect()->route('bphtb.form.pelepas.hak', [Crypt::encrypt($model->id_bphtb)]);
        }
    }
    
}