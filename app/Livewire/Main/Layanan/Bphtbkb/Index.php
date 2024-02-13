<?php
namespace App\Livewire\Main\Layanan\Bphtbkb;
use Livewire\Component;
use App\Models\Bphtb\ObjekPajakVerifikasi as Model;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;


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
    public $alamat;
    public $kontak;
    public $email;
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
        $this->total = Model::count();
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
        setActivity('Pengguna Mengakses Halaman SPPD KB  ');
        
        if(Auth::user()->role_id==1){
            $model = Model::where('t_bphtb_objek_pajak_verifikasi.deleted_at',null)
            ->join('t_bphtb_penerima_hak','t_bphtb_penerima_hak.id_bphtb','=','t_bphtb_objek_pajak_verifikasi.id_bphtb')
            ->whereRaw('LOWER(t_bphtb_penerima_hak.nama_wp) like ?', ['%'.strtolower($this->search).'%'])
            ->paginate($this->perpage);
        }else{
            $model = Model::where('t_bphtb_objek_pajak_verifikasi.deleted_at',null)->where('created_id',Auth::user()->id)
            ->join('t_bphtb_penerima_hak','t_bphtb_penerima_hak.id_bphtb','=','t_bphtb_objek_pajak_verifikasi.id_bphtb')
            ->whereRaw('LOWER(t_bphtb_penerima_hak.nama_wp) like ?', ['%'.strtolower($this->search).'%'])
            ->paginate($this->perpage);
        }
        
        return view('livewire.main.layanan.bphtbkb.index',
        [
            'model' => $model
        ]);
    }
    
    
    private function resetInput()
    {
        $this->kode     = NULL;
        $this->nama     = NULL;
        $this->alamat   = NULL;
        $this->kontak   = NULL;
        $this->email    = NULL;
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
        $model->alamat          = $this->alamat;
        $model->kontak          = $this->kontak;
        $model->email           = $this->email;
        $model->is_active       = 1;
        $model->is_delete       = 0;
        
        if($model->save()){
            $this->resetInput();
            $this->alert('success', 'Instansi Berhasil di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Instansi Gagal di Simpan', [
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
        $this->alamat       = $model->alamat;
        $this->kontak       = $model->kontak;
        $this->email        = $model->email;
        $this->nama         = $model->nama;
        $this->kode         = $model->kode;
        $this->nama_id      = $model->id;
        $this->dispatch("showForm");
        $this->showForm = true;
    }
    
    public function update()
    {
        $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->nama_id]);
        $model->nama        = $this->nama;
        $model->kode        = $this->kode;
        $model->alamat      = $this->alamat;
        $model->kontak      = $this->kontak;
        $model->email       = $this->email;
        $model->is_active   = 1;
        $model->is_delete   = 0;
        
        if($model->save()){
            $this->mode = "create";
            $this->resetInput();
            $this->alert('success', 'Instansi Berhasil di Ubah', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Instansi Gagal di Ubah', [
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
        return $this->alert('question', 'Apakah Anda Yakin Akan Menghapus Instansi ? '.$data->nama.'', [
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
            return $this->alert('success', 'Instansi Berhasil di Hapus', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Instansi Gagal di Hapus', [
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
                'text' => 'Instansi Berhasil Di Hapus'
            ]);
        }else{
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'message' => 'Gagal',
                'text' => 'Instansi Berhasil Di Hapus'
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
        return $this->alert('success', 'Status Instansi '.$model->nama.' '.$infoStatus, [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }
    
    public function createForm()
    {
        return redirect()->route('kbbphtb.form.penerima.hak');
    }
    
    
}
