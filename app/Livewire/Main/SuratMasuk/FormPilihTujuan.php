<?php

namespace App\Livewire\Main\SuratMasuk;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormPilihTujuan extends Component
{
    public $selectedUsers;
    public $sekretaris_list;
    public $unit_kerja_list;
    public $struktural_list;
    
    public function mount()
    {
        $this->sekretaris_list = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)
        ->where('b.is_delete','=',0)
        ->where('b.status_tujuan',1)
        ->whereIn('b.kode',['SP','S','SDK'])
        ->orderBy('b.jabatan','asc')
        ->get();
        
        $this->unit_kerja_list = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)
        ->where('b.status_tujuan',1)->orderBy('b.jabatan','asc')
        ->get();
        
        $this->struktural_list = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)
        ->where('b.status_jabatan',1)->orderBy('b.jabatan','asc')
        ->get();
    }
    
    public function render()
    {
        return view('livewire.main.surat-masuk.form-pilih-tujuan');
    }
}
