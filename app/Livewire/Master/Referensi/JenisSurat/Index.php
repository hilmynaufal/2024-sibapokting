<?php
namespace App\Livewire\Master\Referensi\JenisSurat;
use Livewire\Component;
use App\Models\RefJenisSurat as Model;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed'];
    public $search = '';
    public $showForm;
    public $kode;
    public $nama;
    public $nama_id = NULL;
    public $alias;
    public $primaryId;
    public $url;
    public $icon;
    
    public $mode = 'create';
    public $perpage = 10;
    public $total;
    public $sortColoumName = "nama";
    public $sortDirection = "asc";
    protected $queryString = ['search'];
    
    public function mount()
    {
        $this->total = Model::where('is_active',1)->count();
    }
    
    protected $rules = [
        'nama'      => 'required',
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
        
        setActivity('Pengguna Mengakses Halaman Jenis Surat');
        return view('livewire.master.referensi.jenis-surat.index',
        [
            'model' => Model::where('is_delete',0)
            ->whereRaw('LOWER(nama) like ?', ['%'.strtolower($this->search).'%'])
            // ->where('is_active','=',1)
            ->orderBy($this->sortColoumName,$this->sortDirection)
            // ->orderBy('posisi','ASC')
            ->paginate($this->perpage)
        ]);
    }
    
    
    private function resetInput()
    {
        $this->kode             = NULL;
        $this->nama     = NULL;
        $this->nama_id  = NULL;
    }
    
    public function cancel()
    {
        $this->mode = 'create';
        $this->resetInput();
    }
    
    public function create()
    {
        $this->resetInput();
        $this->mode = 'create';
        $this->showForm = true;
        $this->isOpen = true;
        $this->dispatch("showForm");
    }
    
    public function store()
    {
        $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->nama_id]);
        $model->id              = Model::max('id') + 1;
        $model->nama            = $this->nama;
        $model->kode            = $this->kode;
        $model->is_active       = 1;
        $model->is_delete       = 0;
        
        if($model->save()){
            $this->resetInput();
            $this->alert('success', 'Jenis Surat Berhasil di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Jenis Surat Gagal di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
        
    }
    
    public function edit($primaryId)
    {
        $this->isOpen = true;
        $this->mode = 'update';
        $this->primaryId = $primaryId;
        $model = Model::where('id','=',$primaryId)->first();
        $this->nama        = $model->nama;
        $this->kode              = $model->kode;
        $this->nama_id     = $model->id;
        $this->dispatch("showForm");
        $this->showForm = true;
    }
    
    public function update()
    {
        $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->nama_id]);
        $model->nama        = $this->nama;
        $model->kode              = $this->kode;
        $model->is_active   = 1;
        $model->is_delete   = 0;
        
        if($model->save()){
            $this->mode = "create";
            $this->resetInput();
            $this->alert('success', 'Jenis Surat Berhasil di Ubah', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Jenis Surat Gagal di Ubah', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
        
    }
    
    public function deleteConfirm($id)
    {
        $data = Model::where('id',$id)->first();
        $this->nama_id = $id;
        return $this->alert('question', 'Apakah Anda Yakin Akan Menghapus Jenis Surat ? '.$data->nama.'', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Ok',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'confirmed',
            'toast' => false,
            'position' => 'center',
            'timer' => 2000
        ]);
    }
    
    public function confirmed()
    {
        $model = Model::where('id',$this->nama_id)->first();
        $model->is_delete = 1;
        if($model->save()){
            $this->resetInput();
            return $this->alert('success', 'Jenis Surat Berhasil di Hapus', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Jenis Surat Gagal di Hapus', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
        
        
    }
    
    public function delete($id)
    {
        if(Model::where('id',$id)->delete()){
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'message' => 'Berhasil',
                'text' => 'Jenis Surat Berhasil Di Hapus'
            ]);
        }else{
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'message' => 'Gagal',
                'text' => 'Jenis Surat Berhasil Di Hapus'
            ]);
        }
    }
    
    public $isOpen = false;
    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }
    
    public function status($id)
    {
        $model = Model::where('id', $id)->firstOrFail();
        $newStatus = $model->is_active === 1 ? 0 : 1;
        $infoStatus = $newStatus == 1 ? "Tidak Aktif" : "Aktif"; 
        $model->update(['is_active' => $newStatus]);
        return $this->alert('success', 'Status Jenis Surat '.$model->nama.' '.$infoStatus, [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }
    
    
}
