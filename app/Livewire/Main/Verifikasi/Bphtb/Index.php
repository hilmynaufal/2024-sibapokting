<?php
namespace App\Livewire\Main\Verifikasi\Bphtb;
use Livewire\Component;
use App\Models\Bphtb\PembayaranPajak as Model;
use App\Models\Pajak\RefJenisTransaksi;

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

    public $perolehan_list;
    public $searchJenis;

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
    public $sortColoumName = "created_at";
    public $sortDirection = "asc";
    protected $queryString = ['search'];
    
    public function mount()
    {
        $this->total = Model::count();
        $this->perolehan_list        = RefJenisTransaksi::orderBy('kd_jenis_transaksi','asc')->get();

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
        setActivity('Pengguna Mengakses Verifikasi BPHTB');


        $query = Model::query();
            $query->when($this->search != "", function ($q) {
                return $q->whereRaw('LOWER(no_registrasi) like ?', ['%'.strtolower($this->search).'%']);
            });
            $rows = $query->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);

        if ($rows[0]!=null) {
            $this->firstId = $rows[0]->id;
        }
        return view('livewire.main.verifikasi.bphtb.index', [
          'model'=> $rows
        ]);

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
        return redirect()->route('bphtb.form.penerima.hak');
    }

    
    
}
