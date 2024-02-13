<?php
namespace App\Livewire\Master\Referensi\Pajak;
use Livewire\Component;
use App\Models\Pajak\RefJenisTransaksi as Model;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class JenisTransaksi extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed'];
    public $search = '';
    
    public $mode = 'create';
    public $actionTitle = 'Tambah';
    public $perpage = 10;
    public $role_list;
    
    public $id_jenis_transaksi;
    public $kd_jenis_transaksi;
    public $nm_jenis_transaksi;
    
    public $sortColoumName = "kd_jenis_transaksi";
    public $sortDirection = "asc";
    protected $queryString = ['search'];
    
    public function mount()
    {

    }
    
    protected $rules = [
        'kd_jenis_transaksi'      => 'required',
        'nm_jenis_transaksi'      => 'required',
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
            $query->when($this->search != "", function ($q) {
                return $q->whereRaw('LOWER(nm_jenis_transaksi) like ?', ['%'.strtolower($this->search).'%']);
            });
            $rows = $query->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);

        if ($rows[0]!=null) {
            $this->firstId = $rows[0]->id;
        }
        
        return view('livewire.master.referensi.pajak.jenis-transaksi', [
          'model'=> $rows
        ]);
    }
    
    
    private function resetInput()
    {
        $this->kd_jenis_transaksi = NULL;
        $this->nm_jenis_transaksi = NULL;
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
        $model = Model::firstOrNew(['id' =>  $this->id_jenis_transaksi]);
        $model->id          = Model::max('id') + 1;
        $model->kd_jenis_transaksi = $this->kd_jenis_transaksi;
        $model->nm_jenis_transaksi = $this->nm_jenis_transaksi;
        
        if($model->save()){
            $this->resetInput();
            $log = 'Data Alur Berkas '.$model->nm_jenis_transaksi.' Berhasil di Ditambah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Alur Berkas '.$model->nm_jenis_transaksi.' Gagal di Ditambah';
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
        $this->id_jenis_transaksi  = $model->id;
        $this->kd_jenis_transaksi  = $model->kd_jenis_transaksi;
        $this->nm_jenis_transaksi  = $model->nm_jenis_transaksi;
        $this->dispatch("showForm");
        $this->showForm = true;
    }
    
    public function update()
    {
        $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->id_jenis_transaksi]);
        $model->kd_jenis_transaksi = $this->kd_jenis_transaksi;
        $model->nm_jenis_transaksi = $this->nm_jenis_transaksi;
        
        if($model->save()){
            $this->mode = "create";
            $this->actionTitle = 'Ubah';
            $this->resetInput();
            $log = 'Data Alur Berkas '.$model->nm_jenis_transaksi.' Berhasil di Ubah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Alur Berkas '.$model->nm_jenis_transaksi.' Gagal di Ubah';
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