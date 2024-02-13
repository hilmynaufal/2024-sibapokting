<?php
namespace App\Livewire\Main\DisposisiMasuk;
use Livewire\Component;
use App\Models\SuratMasuk as Model;
use App\Models\Disposisi;
use App\Models\DisposisiMasuk;
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
    
    public $surat_masuk_id = NULL;
    public $surat_masuk_token;
    public $primaryId;
    public $disposisiId;
    public $disposisiDetailId;
    public $disposisiDetailTipe;
    public $disposisiDetailDirect;
    public $is_direct;
    
    public $mode = 'create';
    public $perpage = 10;
    public $total;
    public $sortColoumName = "created_at";
    public $sortDirection = "desc";
    protected $queryString = ['search'];
    
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
    
    public $disposisi_id;
    public $disposisi_at;
    public $disposisi_batas_waktu;
    public $disposisi_tujuan;
    public $disposisi_instruksi;
    public $disposisi_catatan;
    public $disposisi_tipe;
    public $disposisi_laporan;
    
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
        if(Auth::user()->role_id==6){
            $model = DisposisiMasuk::where('is_active',1)
            ->where('jabatan_penerima_id', Auth::user()->id)
            ->where(DB::raw('LOWER(deskripsi)'), 'LIKE', '%' . strtolower($this->search) . '%')
            ->orderBy($this->sortColoumName, $this->sortDirection)
            ->paginate($this->perpage);
            // dd($model);
        }else{
            $model = DisposisiMasuk::where('is_active',1)
            ->where('jabatan_penerima_token', getJabatan())
            ->where(DB::raw('LOWER(deskripsi)'), 'LIKE', '%' . strtolower($this->search) . '%')
            ->orderBy($this->sortColoumName, $this->sortDirection)
            ->paginate($this->perpage);
        }
        
        return view('livewire.main.disposisi-masuk.index', [ 'model' => $model ]);
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
        
        $verifikasi = DisposisiMasuk::where('id', $primaryId)->where('jabatan_penerima_token', getJabatan())->firstOrFail();
        $model = Model::where('id', $verifikasi->surat_id)->first();
        $model->update(['is_view' => $model->is_view + 1]);
        $disposisi = Disposisi::where('id','=',$verifikasi->disposisi_id)->first();
        $disposisi_laporan = DisposisiLaporan::where('surat_id_token', $model->token)->OrderBy('created_at','ASC')->get();
        
        
        if($verifikasi->is_read==0){
            $verifikasi->where('id', $primaryId)->update([
                'is_view' => $verifikasi->is_view + 1,
                'is_read' => 1,
                'is_status' => 2,
                'view_at' => now(),
                'read_at' => now(),
                'updated_at' => now(),
                'update_id' => Auth::user()->id,
            ]);
        }
        
        $this->primaryId = $verifikasi->surat_id;
        $this->surat_masuk_id = $verifikasi->surat_id;
        $this->surat_masuk_token = $verifikasi->surat_id_token;
        $this->disposisiId = $verifikasi->disposisi_id;
        $this->disposisiDetailId = $verifikasi->id;
        $this->disposisiDetailTipe = $verifikasi->tipe;
        $this->disposisiDetailDirect = $verifikasi->is_direct;
        
        $this->disposisi_id = $disposisi->disposisi_id;
        $this->disposisi_at = $disposisi->disposisi_at;
        $this->disposisi_batas_waktu = $disposisi->disposisi_batas_waktu;
        $this->disposisi_tujuan = $disposisi->disposisi_tujuan;
        $this->disposisi_instruksi = $disposisi->disposisi_instruksi;
        $this->disposisi_catatan = $disposisi->disposisi_catatan;  
        $this->disposisi_tipe = $disposisi->tipe;  
        
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
        $this->dispatch('disposisi_view', id: $verifikasi->id);
        $this->dispatch('laporan_view', id: $verifikasi->surat_id);
        $this->dispatch('laporan-created', id: $verifikasi->surat_id);
        $this->dispatch('disposisi_create', id: $verifikasi->id);
        $this->dispatch('surat_view', id: $verifikasi->id);
        
        $disposisi_laporan = DisposisiLaporan::where('surat_id', $verifikasi->surat_id)->OrderBy('created_at','DESC')->get();
        $this->disposisi_laporan = $disposisi_laporan;
        
    }
    
    
    
    
}
