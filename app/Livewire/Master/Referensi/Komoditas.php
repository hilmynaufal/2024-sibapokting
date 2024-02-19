<?php
namespace App\Livewire\Master\Referensi;
use Livewire\Component;
use App\Models\Referensi\RefKomoditas as Model;
use App\Models\Referensi\RefSatuan;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Storage;

class Komoditas extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed'];
    public $search = '';
    
    public $mode = 'create';
    public $actionTitle = 'Tambah';
    
    public $perpage = 10000000;
    
    public $id;
    public $namakomoditas;
    public $satuan;
    public $gambar;
    public $list_satuan;
    
    
    protected $rules = [
        'namakomoditas'    => 'required',
        'satuan'           => 'required',
        'gambar'           => 'file|mimes:pdf,jpg,jpeg,png,docx,doc,xls,xlsx|max:1000',
    ];
    
    public function mount()
    {
        $this->list_satuan = RefSatuan::orderBy('nama','asc')->get();
        $data = Model::count();
        if ($data) {
            $this->id = $data + 1;
        } else {
            $this->id = 1;
        }
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
    
    private function resetInput()
    {
        $this->namakomoditas    = NULL;
        $this->satuan           = NULL;
        $this->gambar           = NULL;
        $this->id               = NULL;
    }
    
    public function cancel()
    {
        $this->resetInput();
        $this->mode = 'create';
        $this->actionTitle = 'Tambah';

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
        
        // PROSES UPLOAD
        $folderPath = "komoditas";
        if (!file_exists(Storage::disk('public')->path($folderPath))) {
            Storage::disk('public')->makeDirectory($folderPath, 0755, true);
        }
        $uploadedFile = $this->gambar;
        $fileName = $uploadedFile->getClientOriginalName(); // Mengambil nama asli file yang diunggah
        $fileExtension = $uploadedFile->getClientOriginalExtension(); // Mengambil ekstensi file yang diunggah
        $newFileName = time() . '_' . str_replace(' ','_',strtolower($fileName)); // Menyusun nama baru file
        // END PROSES UPLOAD
        
        $model = Model::firstOrNew(['id' =>  $this->id]);
        $model->id              = $this->id;
        $model->namakomoditas   = $this->namakomoditas;
        $model->satuan          = $this->satuan;
        $model->gambar          = $this->gambar->storeAs($folderPath, $newFileName, 'public');
        $model->created_id      = Auth::user()->id;
        $model->created_at      = date('Y-m-d H:i:s');
        
        if($model->save()){
            $this->resetInput();
            $log = 'Data Komoditas '.$model->namakomoditas.' Berhasil di Ditambah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Komoditas '.$model->namakomoditas.' Gagal di Ditambah';
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
        return redirect()->route('master.referensi.komoditas');

        
    }
    
    public function edit($primaryId)
    {
        $this->isOpen = true;
        $this->mode = 'update';
        $this->actionTitle = 'Ubah';
        $this->primaryId = $primaryId;
        $model = Model::where('id','=',$primaryId)->first();
        $this->id   = $model->id;
        $this->namakomoditas   = $model->namakomoditas;
        $this->satuan          = $model->satuan;
        $this->gambar          = $model->gambar;
        $this->dispatch("showForm");
        $this->showForm = true;
    }
    
    public function update()
    {
        $this->validate();
        // PROSES UPLOAD
        $folderPath = "komoditas";
        if (!file_exists(Storage::disk('public')->path($folderPath))) {
            Storage::disk('public')->makeDirectory($folderPath, 0755, true);
        }
        $uploadedFile = $this->gambar;
        $fileName = $uploadedFile->getClientOriginalName(); // Mengambil nama asli file yang diunggah
        $fileExtension = $uploadedFile->getClientOriginalExtension(); // Mengambil ekstensi file yang diunggah
        $newFileName = time() . '_' . str_replace(' ','_',strtolower($fileName)); // Menyusun nama baru file
        // END PROSES UPLOAD

        $model = Model::firstOrNew(['id' =>  $this->id]);
        $model->namakomoditas   = $this->namakomoditas;
        $model->satuan          = $this->satuan;
        $model->gambar          = $this->gambar->storeAs($folderPath, $newFileName, 'public');
        
        if($model->save()){
            $this->mode = "create";
            $this->actionTitle = 'Ubah';
            $this->resetInput();
            $log = 'Data Komoditas '.$model->name.' Berhasil di Ubah';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Komoditas '.$model->name.' Gagal di Ubah';
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            
        }
        return redirect()->route('master.referensi.komoditas');
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
            $log = 'Data Barang Berhasil di Hapus';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Barang Gagal di Hapus';
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            
        }
        return redirect()->route('master.referensi.komoditas');

    }
    
    public $isOpen = false;
    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }
    
    
}