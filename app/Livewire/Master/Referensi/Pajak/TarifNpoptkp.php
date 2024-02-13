<?php
namespace App\Livewire\Master\Referensi\Pajak;
use Livewire\Component;
use App\Models\Pajak\RefTarifNpoptkp as Model;
use App\Models\Pajak\RefJenisTransaksi;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TarifNpoptkp extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed'];
    public $search = '';
    
    public $mode = 'create';
    public $actionTitle = 'Tambah';
    public $perpage = 10;
    public $searchJenis = 1;
    public $perolehan_list;
    
    public $id_tarif_npoptkp;
    public $jenis_transaksi_id;
    public $tarif;
    public $tarif_tambahan;
    public $dasar_hukum;
    public $tahun_awal_berlaku;
    public $tahun_akhir_berlaku;
    public $status;
    
    public $sortColoumName = "dasar_hukum";
    public $sortDirection = "asc";
    protected $queryString = ['search'];
    
    public function mount()
    {
        $this->perolehan_list        = RefJenisTransaksi::orderBy('kd_jenis_transaksi','asc')->get();
    }
    public function rules()
    {
        return [
            'jenis_transaksi_id'      => 'required',
            // 'id_prov'      => 'required',
            // 'id_kab'      => 'required|min:4|max:4',
        ];
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
        $query = Model::query();
            $query->when($this->searchJenis != "", function ($q) {
                return $q->where('jenis_transaksi_id', '=', $this->searchJenis);
            });
            $query->when($this->search != "", function ($q) {
                return $q->whereRaw('LOWER(dasar_hukum) like ?', ['%'.strtolower($this->search).'%']);
            });
            $rows = $query->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);

        if ($rows[0]!=null) {
            $this->firstId = $rows[0]->id;
        }
        return view('livewire.master.referensi.pajak.tarif-npoptkp', [
          'model'=> $rows
        ]);
    }
    
    
    private function resetInput()
    {
        $this->id_tarif_npoptkp = NULL;
        $this->jenis_transaksi_id = NULL;
        $this->tarif = NULL;
        $this->tarif_tambahan = NULL;
        $this->dasar_hukum = NULL;
        $this->tahun_awal_berlaku   = NULL;
        $this->tahun_akhir_berlaku  = NULL;
        $this->status   = NULL;
    }
    
    public function cancel()
    {
        $this->mode = 'create';
        $this->actionTitle = 'Tambah';
        $this->resetInput();
    }
    
    public function create()
    {
        $this->resetInput();
        $this->mode = 'create';
        $this->actionTitle = 'Tambah';
        $this->showForm = true;
        $this->isOpen = true;
        $this->dispatch("showForm");
    }
    
    public function store()
    {
        // $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->id_tarif_npoptkp]);
        $model->id          = Model::max('id') + 1;
        $model->jenis_transaksi_id = $this->jenis_transaksi_id;
        $model->tarif = $this->tarif;
        $model->tarif_tambahan    = $this->tarif_tambahan;
        $model->dasar_hukum  = $this->dasar_hukum;
        $model->tahun_awal_berlaku = $this->tahun_awal_berlaku;
        $model->tahun_akhir_berlaku = $this->tahun_akhir_berlaku;
        $model->status = $this->status;
        
        if($model->save()){
            $this->resetInput();
            $log = 'Data Tarif NPOPTKP Berhasil di Ditambah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Tarif NPOPTKP Gagal di Ditambah';
            notify()->success($log);
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
        
    }
    
    public function edit($primaryId)
    {
        $this->isOpen = true;
        $this->mode = 'update';
        $this->actionTitle = 'Ubah';
        $this->primaryId = $primaryId;
        $model = Model::where('id','=',$primaryId)->first();
        $this->id_tarif_npoptkp = $model->id;
        $this->jenis_transaksi_id = $model->jenis_transaksi_id;
        $this->tarif = $model->tarif;
        $this->tarif_tambahan    = $model->tarif_tambahan;
        $this->dasar_hukum  = $model->dasar_hukum;
        $this->tahun_awal_berlaku = $model->tahun_awal_berlaku;
        $this->tahun_akhir_berlaku = $model->tahun_akhir_berlaku;
        $this->status = $model->status;
        $this->dispatch("showForm");
        $this->showForm = true;
    }
    
    public function update()
    {
        // $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->id_tarif_npoptkp]);
        $model->jenis_transaksi_id = $this->jenis_transaksi_id;
        $model->tarif = $this->tarif;
        $model->tarif_tambahan    = $this->tarif_tambahan;
        $model->dasar_hukum  = $this->dasar_hukum;
        $model->tahun_awal_berlaku = $this->tahun_awal_berlaku;
        $model->tahun_akhir_berlaku = $this->tahun_akhir_berlaku;
        $model->status = $this->status;
        
        if($model->save()){
            $this->mode = "create";
            $this->actionTitle = 'Ubah';
            $this->resetInput();
            $log = 'Data Tarif NPOPTKP Berhasil di Ubah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Tarif NPOPTKP Gagal di Ubah';
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            
        }
        
    }
    public function deleteRequest($id)
    {
        $this->dispatch("swal:deleteRequest", [
            'type' => 'warning',
            'title' =>'Apa anda yakin ?',
            'text' =>'Setelah memilih YA maka data akan Dihapus',
            'id'=>$id
        ]);
    }
    public function deleteSelectedRequest($id)
    {
        if(Model::where('id',$id)->delete()){
            $this->resetInput();
            $log = 'Data Tarif NPOPTKP Berhasil di Hapus';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Tarif NPOPTKP Gagal di Hapus';
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            
        }
    }
    
    public $isOpen = false;
    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }
    
    
    
}