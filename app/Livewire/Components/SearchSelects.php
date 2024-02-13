<?php

namespace App\Http\Livewire\Components;
use Livewire\Component;
use App\Models\RefEselon;
use App\Models\RefJabatan;
use App\Models\RefPangkat;

use App\Models\RefGolongan;
use App\Models\RefUnitKerja;
use Illuminate\Http\Request;
use App\Models\RefSatuanKerja;

class SearchSelects extends Component
{
    
    public function Golongan(Request $request)
    {
        $list =  RefGolongan::where('is_active','=',1)
        ->whereRaw('LOWER(golongan) like ?', ['%'.$request->input('term', '').'%'])
        ->orderBy('golongan','asc')
        ->take(5)
        ->get(['id as id', 'golongan as text']);
        
        return ['results' => $list];
    }
    
    public function Eselon(Request $request)
    {
        $list =  RefEselon::where('is_active','=',1)
        ->whereRaw('LOWER(eselon) like ?', ['%'.$request->input('term', '').'%'])
        ->where('is_active','=',1)
        ->orderBy('eselon','asc')
        ->take(5)
        ->get(['id as id', 'eselon as text']);
        
        return ['results' => $list];
    }
    
    public function Pangkat(Request $request)
    {
        $list =  RefPangkat::where('is_active','=',1)
        ->whereRaw('LOWER(pangkat) like ?', ['%'.$request->input('term', '').'%'])
        ->where('is_active','=',1)
        ->orderBy('pangkat','asc')
        ->take(5)
        ->get(['id as id', 'pangkat as text']);
        
        return ['results' => $list];
    }
    
    public function Jabatan(Request $request)
    {
        $list =  RefJabatan::where('is_active','=',1)
        ->whereRaw('LOWER(jabatan) like ?', ['%'.$request->input('term', '').'%'])
        ->orderBy('jabatan','asc')
        ->take(5)
        ->get(['id as id', 'jabatan as text']);
        
        return ['results' => $list];
    }
    
    public function UnitKerja(Request $request)
    {
        $list =  RefUnitKerja::where('is_active','=',1)
        ->whereRaw('LOWER(unit_kerja) like ?', ['%'.$request->input('term', '').'%'])
        ->where('is_active','=',1)
        ->orderBy('unit_kerja','asc')
        ->take(5)
        ->get(['id as id', 'unit_kerja as text']);
        
        return ['results' => $list];
    }
    
    public function SatuanKerja(Request $request)
    {
        $list =  RefSatuanKerja::where('is_active','=',1)
        ->whereRaw('LOWER(satuan_kerja) like ?', ['%'.$request->input('term', '').'%'])
        ->where('is_active','=',1)
        ->orderBy('satuan_kerja','asc')
        ->take(5)
        ->get(['id as id', 'satuan_kerja as text']);
        
        return ['results' => $list];
    }
    
    public function render()
    {
        return view('livewire.components.search-select');
    }
}
