<?php

namespace App\Livewire\Main\DisposisiMasuk;
use App\Models\SuratMasuk as Model;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Admin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed','confirmedLampiran'];
    public $search = '';
    
    public $mode = 'create';
    public $perpage = 10;
    public $total;
    public $sortColoumName = "created_at";
    public $sortDirection = "desc";
    protected $queryString = ['search'];
    
    public function mount()
    {
        $this->total = Model::where('is_active',1)->count();  
    }
    
    public function sortBy($coloumName)
    {
        if($this->sortColoumName === $coloumName){
            $this->sortDirection = $this->swapSortDirection();
        }else{
            $this->sortDirection ='asc';
        }
        $this->sortColoumName = $coloumName;
    }
    
    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $model = DB::table('t_surat_masuk')
        ->select('t_surat_masuk.*', 't_disposisi_detail.jabatan_id_token', 't_disposisi_detail.id as disposisi_id','t_disposisi_detail.is_read as disposisi_is_read')
        ->leftJoin('t_disposisi_detail', 't_surat_masuk.id', '=', 't_disposisi_detail.surat_id')
        ->where('t_disposisi_detail.jabatan_id_token', getJabatan())
        ->where('t_surat_masuk.satuan_kerja_id', Auth::user()->satuan_kerja_id)
        ->where('t_surat_masuk.is_delete', 0)
        ->where(DB::raw('LOWER(t_surat_masuk.perihal_surat)'), 'LIKE', '%' . strtolower($this->search) . '%')
        ->orderBy($this->sortColoumName, $this->sortDirection)
        ->paginate($this->perpage);
        return view('livewire.main.disposisi-masuk.admin', [ 'model' => $model ]);
    }
}
