<?php

namespace App\Livewire\Main\Laporan\SuratKeluar;
use App\Models\SuratKeluar as Model;
use App\Models\RefJabatan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Exports\SuratKeluarExport;
use Livewire\WithPagination;
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];
    public $search = '';
    public $sortColoumName = "created_at";
    public $sortDirection = "desc";
    public $perpage = 10;
    
    public $tgl_awal;
    public $tgl_akhir;
    public $no_surat;
    public $tujuan;
    public $status;
    
    public $struktural_list;
    
    public function mount(){
        $this->struktural_list = RefJabatan::where('status_tujuan','=',1)->orderBy('jabatan','asc')->get(); 
    }
    
    public function render()
    {        
        $model = Model::where('is_delete', 0)
        ->where('satuan_kerja_token', Auth::user()->satuan_kerja_id)
        ->when($this->tgl_awal, function ($query) {
            return $query->whereDate('tgl_surat', '>=', $this->tgl_awal);
        })
        ->when($this->tgl_akhir, function ($query) {
            return $query->whereDate('tgl_surat', '<=', $this->tgl_akhir);
        })
        ->when($this->no_surat, function ($query) {
            return $query->where('no_surat', 'like', '%' . $this->no_surat . '%');
        })
        ->when($this->tujuan, function ($query) {
            return $query->where('tujuan_surat_token', 'like', '%' . $this->tujuan . '%');
        })
        ->when($this->status, function ($query) {
            return $query->where('is_type', $this->status);
        })
        ->whereRaw('LOWER(perihal_surat) like ?', ['%' . strtolower($this->search) . '%'])
        ->orderBy($this->sortColoumName, $this->sortDirection)
        ->paginate($this->perpage);
        
        return view('livewire.main.laporan.surat-keluar.index', [ 'model' => $model ]);
    }
    
    public function store()
    {
        return (new SuratKeluarExport($this->tgl_awal, $this->tgl_akhir, $this->no_surat, $this->tujuan, $this->status, $this->search))->download('Export Data Surat Masuk.xlsx');
    }
    
}

