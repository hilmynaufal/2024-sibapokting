<?php
namespace App\Livewire\Main;
use Livewire\Component;
use App\Models\Transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class Komoditas extends Component
{
    use WithPagination,WithoutUrlPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed'];
    public $search = '';
    
    public $mode = 'create';
    public $actionTitle = 'Tambah';
    public $perpage = 10;
    public $role_list;
    public $firstId;
    
    public $pasar_id;
    public $id_komoditas;
    public $selectPasar;
    public $selectTanggal;
    public $listPasar;
    
    public $sortColoumName = "tanggal";
    public $sortDirection = "desc";
    protected $queryString = ['search'];
    
    #[Layout('components.layouts.keenthemes.page')]
    public function mount()
    {
        if(Auth::user()->role_id == 5){
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->where('id',Auth::user()->pasar_id)->get();
        }else{
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->get();
        }
        $this->selectTanggal = date('Y-m-d');
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
    
    
    public function render()
    {
        $query = Model::query();
            $query->when($this->selectPasar != "", function ($q) {
                return $q->where('pasar_id','=',$this->selectPasar);
            });
            $query->when($this->selectTanggal != "", function ($q) {
                return $q->where('detail_tgl','=',$this->selectTanggal);
            });
        if(Auth::user()->role_id == 5){
            $rows = $query->where('pasar_id',Auth::user()->pasar_id)->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);
        }else{
            $rows = $query->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);
        }

        if ($rows->isNotEmpty()) {
            $this->firstId = $rows[0]->id;
        }
        
        return view('livewire.main.transaksi.komoditas.komoditas', [
          'model'=> $rows
        ]);
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
            $log = 'Data Komoditas Berhasil di Hapus';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Komoditas Gagal di Hapus';
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            
        }
    }
    
    
    
}