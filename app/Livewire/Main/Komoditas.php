<?php
namespace App\Livewire\Main;
use Livewire\Component;
use App\Models\Transaksi\Komoditas as Model;
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
    
    public $pasar_id;
    public $id_komoditas;
    
    public $sortColoumName = "tanggal";
    public $sortDirection = "desc";
    protected $queryString = ['search'];
    
    #[Layout('components.layouts.keenthemes.page')]
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
    
    
    public function render()
    {
        $query = Model::query();
            $query->when($this->search != "", function ($q) {
                return $q->whereRaw('LOWER(pasar_id) like ?', ['%'.strtolower($this->search).'%']);
            });
        if(Auth::user()->role_id == 5){
            $rows = $query->where('pasar_id',Auth::user()->pasar_id)->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);
        }else{
            $rows = $query->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);
        }

        if ($rows[0]!=null) {
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
    
    
    
}