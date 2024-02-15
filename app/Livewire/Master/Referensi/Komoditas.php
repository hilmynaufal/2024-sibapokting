<?php
namespace App\Livewire\Master\Referensi;
use Livewire\Component;
use App\Models\Referensi\RefKomoditas as Model;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Komoditas extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed'];
    public $search = '';
    
    public $perpage = 10000000;
    
    public $id;
    public $namakomoditas;
    public $satuan;
    public $gambar;
    
    
    protected $rules = [
        'id'               => 'required',
        'namakomoditas'    => 'required',
        'satuan'           => 'required',
        'gambar'           => 'required',
    ];
    
    public function mount()
    {

    }

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        $query = Model::query();
            $query->when($this->search != "", function ($q) {
                return $q->whereRaw('LOWER(nm_jenis_transaksi) like ?', ['%'.strtolower($this->search).'%']);
            });
            $rows = $query->paginate($this->perpage);

        if ($rows[0]!=null) {
            $this->firstId = $rows[0]->id;
        }
        
        return view('livewire.master.referensi.komoditas', [
          'model'=> $rows
        ]);
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
    
    
}