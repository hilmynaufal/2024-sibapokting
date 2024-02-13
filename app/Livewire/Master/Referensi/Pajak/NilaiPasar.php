<?php
namespace App\Livewire\Master\Referensi\Pajak;
use Livewire\Component;
use App\Models\Pajak\RefNilaiPasar as Model;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefDesa;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class NilaiPasar extends Component
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
    
    public $id_nilai_pasar;
    public $kd_znt;
    public $nilai_min;
    public $nilai_max;
    public $alamat;
    public $kode_kecamatan;
    public $kode_desa;
    public $tahun;
    
    public $kecamatan_list;
    public $searchKecamatan;
    public $inputSearchKecamatan;
    public $searchDesa;
    public $desa_list;
    public $input_desa_list;
    public $sortColoumName = "alamat";
    public $sortDirection = "asc";
    protected $queryString = ['search'];
    
    public function mount()
    {
        $this->kecamatan_list  = RefKecamatan::where('regency_id', getApp()->kab)->orderBy('name','asc')->get();
        // $this->desa_list       = RefDesa::where('district_id', $this->searchKecamatan)->orderBy('name','asc')->get();
    }

    public function updatedSearchKecamatan($searchKecamatan){
        $this->desa_list = RefDesa::where('district_id', $this->searchKecamatan)->orderBy('name','desc')->get();
    }
    public function updatedInputSearchKecamatan($inputSearchKecamatan){
        $this->input_desa_list = RefDesa::where('district_id', $this->inputSearchKecamatan)->orderBy('name','desc')->get();
    }

    public function rules()
    {
        return [
            'kd_znt'      => 'required',
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
            $query->when($this->searchDesa != "", function ($q) {
                return $q->where('kode_desa', '=', $this->searchDesa);
            });
            $query->when($this->search != "", function ($q) {
                return $q->whereRaw('LOWER(alamat) like ?', ['%'.strtolower($this->search).'%']);
            });
            $rows = $query->orderBy($this->sortColoumName,$this->sortDirection)
            ->paginate($this->perpage);

        if ($rows[0]!=null) {
            $this->firstId = $rows[0]->id;
        }
        return view('livewire.master.referensi.pajak.nilai-pasar', [
          'model'=> $rows
        ]);
    }
    
    
    private function resetInput()
    {
        $this->id_nilai_pasar = NULL;
        $this->kd_znt = NULL;
        $this->nilai_min = NULL;
        $this->nilai_max = NULL;
        $this->alamat = NULL;
        $this->inputSearchKecamatan   = NULL;
        $this->kode_desa  = NULL;
        $this->tahun   = NULL;
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
        $model = Model::firstOrNew(['id' =>  $this->id_nilai_pasar]);
        $model->id          = Model::max('id') + 1;
        $model->kd_znt = $this->kd_znt;
        $model->nilai_min = $this->nilai_min;
        $model->nilai_max    = $this->nilai_max;
        $model->alamat  = $this->alamat;
        $model->kode_kecamatan = $this->inputSearchKecamatan;
        $model->kode_desa = $this->kode_desa;
        $model->tahun = $this->tahun;
        
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
        $this->id_nilai_pasar = $model->id;
        $this->kd_znt = $model->kd_znt;
        $this->nilai_min = $model->nilai_min;
        $this->nilai_max    = $model->nilai_max;
        $this->alamat  = $model->alamat;
        $this->inputSearchKecamatan = $model->kode_kecamatan;
        $this->input_desa_list = RefDesa::where('district_id', $this->inputSearchKecamatan)->orderBy('name','desc')->get();
        $this->kode_desa = $model->kode_desa;
        $this->tahun = $model->tahun;
        $this->dispatch("showForm");
        $this->showForm = true;
    }
    
    public function update()
    {
        // $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->id_nilai_pasar]);
        $model->kd_znt = $this->kd_znt;
        $model->nilai_min = $this->nilai_min;
        $model->nilai_max    = $this->nilai_max;
        $model->alamat  = $this->alamat;
        $model->kode_kecamatan = $this->inputSearchKecamatan;
        $model->kode_desa = $this->kode_desa;
        $model->tahun = $this->tahun;
        
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