<?php
namespace App\Livewire\Master\Referensi\Pajak;
use Livewire\Component;
use App\Models\Pajak\RefAlurBerkas as Model;
use App\Models\RefRole;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AlurBerkas extends Component
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
    public $role_list;
    
    public $id_alur_berkas;
    public $jenis_pengajuan;
    public $role_id;
    public $step;
    public $keterangan;
    
    public $sortColoumName = "step";
    public $sortDirection = "asc";
    protected $queryString = ['search'];
    
    public function mount()
    {
        $this->role_list        = RefRole::where('is_active',1)->orderBy('role','asc')->get();
    }
    
    protected $rules = [
        'step'      => 'required',
        'jenis_pengajuan'      => 'required',
        'role_id'      => 'required',
        'keterangan'      => 'required',
    ];
    
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
                return $q->where('jenis_pengajuan', '=', $this->searchJenis);
            });
            $query->when($this->search != "", function ($q) {
                return $q->whereRaw('LOWER(keterangan) like ?', ['%'.strtolower($this->search).'%']);
            });
            $rows = $query->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);

        if ($rows[0]!=null) {
            $this->firstId = $rows[0]->id;
        }
        return view('livewire.master.referensi.pajak.alur-berkas', [
          'model'=> $rows
        ]);
    }
    
    
    private function resetInput()
    {
        $this->id_alur_berkas = NULL;
        $this->jenis_pengajuan = NULL;
        $this->role_id = NULL;
        $this->step = NULL;
        $this->keterangan = NULL;
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
        $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->id_alur_berkas]);
        $model->id          = Model::max('id') + 1;
        $model->jenis_pengajuan = $this->jenis_pengajuan;
        $model->role_id = $this->role_id;
        $model->step    = $this->step;
        $model->keterangan  = $this->keterangan;
        
        if($model->save()){
            $this->resetInput();
            $log = 'Data Alur Berkas '.$model->keterangan.' Berhasil di Ditambah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Alur Berkas '.$model->keterangan.' Gagal di Ditambah';
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
        $this->id_alur_berkas = $model->id;
        $this->jenis_pengajuan = $model->jenis_pengajuan;
        $this->role_id = $model->role_id;
        $this->step    = $model->step;
        $this->keterangan  = $model->keterangan;
        $this->dispatch("showForm");
        $this->showForm = true;
    }
    
    public function update()
    {
        $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->id_alur_berkas]);
        $model->jenis_pengajuan = $this->jenis_pengajuan;
        $model->role_id = $this->role_id;
        $model->step    = $this->step;
        $model->keterangan  = $this->keterangan;
        
        if($model->save()){
            $this->mode = "create";
            $this->actionTitle = 'Ubah';
            $this->resetInput();
            $log = 'Data Alur Berkas '.$model->name.' Berhasil di Ubah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Alur Berkas '.$model->name.' Gagal di Ubah';
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
            $log = 'Data Alur Berkas Berhasil di Hapus';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Alur Berkas Gagal di Hapus';
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