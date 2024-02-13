<?php
namespace App\Livewire\Main\DisposisiKeluar;
use Livewire\Component;
use App\Models\SuratMasuk as Model;
use App\Models\Disposisi;
use App\Models\DisposisiKeluar;
use App\Models\DisposisiLaporan;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;
    
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed','confirmedLampiran'];
    public $search = '';
    public $showForm;
    
    public $tgl_terima;
    public $tgl_surat;
    public $pembuat_surat_id;
    public $satuan_kerja_id;
    public $no_surat;
    public $alamat_pengirim;
    public $perihal_surat;
    public $sekretaris_surat_id;
    public $tujuan_surat_id;
    public $no_arsip;
    public $isi_surat;
    public $keterangan_surat;
    public $pengirim_surat;
    public $file_lampiran;
    
    public $surat_masuk_id = NULL;
    public $surat_masuk_token;
    public $primaryId;
    public $disposisiId;
    public $disposisiDetailId;
    public $disposisiDetailTipe;
    public $disposisiDetailDirect;
    public $is_direct;
    
    public $disposisi_id;
    public $disposisi_at;
    public $disposisi_batas_waktu;
    public $disposisi_tujuan;
    public $disposisi_instruksi;
    public $disposisi_catatan;
    // public $disposisi_laporan;
    
    public $mode = 'create';
    public $perpage = 10;
    public $total;
    public $sortColoumName = "created_at";
    public $sortDirection = "desc";
    protected $queryString = ['search'];
    
    public $isOpen = false;
    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }
    
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
        $model = Disposisi::where('is_active',1)
        ->where('jabatan_id_token', getJabatan())
        ->where(DB::raw('LOWER(disposisi_catatan)'), 'LIKE', '%' . strtolower($this->search) . '%')
        ->orderBy($this->sortColoumName, $this->sortDirection)
        ->paginate($this->perpage);
        // dd($model);
        return view('livewire.main.disposisi-keluar.index', [ 'model' => $model ]);
    }
    
    public function view($primaryId)
    {
        $this->isOpen = true;
        $this->mode = 'view';
        $this->primaryId = $primaryId;
    }
    
    public function viewTracking($primaryId){
        $this->isOpen = true;
        $this->mode = 'tracking';
        $this->primaryId = $primaryId;
        $this->surat_masuk_id = $primaryId;
    }    
    
    private function resetInput()
    {
        $this->mode = '';
        $this->resetErrorBag();
        $this->resetValidation();
        $this->isOpen = false;
    }
    
    public function viewVerifikasi($primaryId)
    {
        $this->resetInput();
        $disposisi = Disposisi::where('id', $primaryId)->firstOrFail();
        $model = Model::where('id', $disposisi->surat_id)->first();
        $disposisi->is_view=1;
        $disposisi->update();
        $this->primaryId = $disposisi->surat_id;
        $this->surat_masuk_id = $disposisi->surat_id;
        $this->surat_masuk_token = $model->token;
        // dd($this->surat_masuk_token);
        $this->disposisiId = $disposisi->disposisi_id;
        $this->disposisiDetailId = $disposisi->id;
        $this->disposisiDetailTipe = $disposisi->tipe;
        $this->disposisiDetailDirect = $disposisi->is_direct;
        
        $this->disposisi_id = $disposisi->disposisi_id;
        $this->disposisi_at = $disposisi->disposisi_at;
        $this->disposisi_batas_waktu = $disposisi->disposisi_batas_waktu;
        $this->disposisi_tujuan = $disposisi->disposisi_tujuan;
        $this->disposisi_instruksi = $disposisi->disposisi_instruksi;
        $this->disposisi_catatan = $disposisi->disposisi_catatan;  
        
        $model = Model::where('id','=',$disposisi->surat_id)->first();
        $this->tgl_terima = Carbon::parse($model->tgl_terima)->locale('id')->isoFormat('LL');
        $this->tgl_surat = Carbon::parse($model->tgl_surat)->locale('id')->isoFormat('LL');
        $this->pembuat_surat_id = $model->pembuat_surat_id;
        $this->no_surat = $model->no_surat;
        $this->alamat_pengirim = $model->alamat;
        $this->perihal_surat = $model->perihal_surat;
        $this->tujuan_surat_id = $model->tujuan->jabatan;
        $this->no_arsip = $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat; 
        
        $this->isOpen = true;
        $this->mode = 'view';
        $this->dispatch('surat_view', id: $disposisi->id);
    }
    
    
    
    
}
