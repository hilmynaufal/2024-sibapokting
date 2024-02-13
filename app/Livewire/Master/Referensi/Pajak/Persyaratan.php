<?php
namespace App\Livewire\Master\Referensi\Pajak;
use Livewire\Component;
use App\Models\Pajak\RefPersyaratan as Model;
use App\Models\Pajak\RefJenisTransaksi;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Persyaratan extends Component
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
    public $searchPersyaratan;
    public $perolehan_list;
    
    public $id_persyaratan;
    public $jenis_transaksi_id;
    public $is_required;
    public $jenis_persyaratan;
    public $nama_persyaratan;
    public $keterangan;
    public $urutan;
    
    public $sortColoumName = "nama_persyaratan";
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
            $query->when($this->searchPersyaratan != "", function ($q) {
                return $q->where('jenis_persyaratan', '=', $this->searchPersyaratan);
            });
            $query->when($this->search != "", function ($q) {
                return $q->whereRaw('LOWER(nama_persyaratan) like ?', ['%'.strtolower($this->search).'%']);
            });
            $rows = $query->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);

        if ($rows[0]!=null) {
            $this->firstId = $rows[0]->id;
        }
        return view('livewire.master.referensi.pajak.persyaratan', [
          'model'=> $rows
        ]);
    }
    
    
    private function resetInput()
    {
        $this->id_persyaratan = NULL;
        $this->jenis_transaksi_id = NULL;
        $this->is_required = NULL;
        $this->jenis_persyaratan = NULL;
        $this->nama_persyaratan = NULL;
        $this->keterangan   = NULL;
        $this->urutan   = NULL;
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
        $model = Model::firstOrNew(['id' =>  $this->id_persyaratan]);
        $model->id          = Model::max('id') + 1;
        $model->jenis_transaksi_id = $this->jenis_transaksi_id;
        $model->is_required = $this->is_required;
        $model->jenis_persyaratan    = $this->jenis_persyaratan;
        $model->nama_persyaratan  = $this->nama_persyaratan;
        $model->keterangan = $this->keterangan;
        $model->urutan = $this->urutan;
        
        if($model->save()){
            $this->resetInput();
            $log = 'Data Persyaratan Berhasil di Ditambah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Persyaratan Gagal di Ditambah';
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
        $this->id_persyaratan = $model->id;
        $this->jenis_transaksi_id = $model->jenis_transaksi_id;
        $this->is_required = $model->is_required;
        $this->jenis_persyaratan    = $model->jenis_persyaratan;
        $this->nama_persyaratan  = $model->nama_persyaratan;
        $this->keterangan = $model->keterangan;
        $this->urutan = $model->urutan;
        $this->dispatch("showForm");
        $this->showForm = true;
    }
    
    public function update()
    {
        // $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->id_persyaratan]);
        $model->jenis_transaksi_id = $this->jenis_transaksi_id;
        $model->is_required = $this->is_required;
        $model->jenis_persyaratan    = $this->jenis_persyaratan;
        $model->nama_persyaratan  = $this->nama_persyaratan;
        $model->keterangan = $this->keterangan;
        $model->urutan = $this->urutan;
        
        if($model->save()){
            $this->mode = "create";
            $this->actionTitle = 'Ubah';
            $this->resetInput();
            $log = 'Data Persyaratan Berhasil di Ubah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Persyaratan Gagal di Ubah';
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
            $log = 'Data Persyaratan Berhasil di Hapus';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Persyaratan Gagal di Hapus';
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