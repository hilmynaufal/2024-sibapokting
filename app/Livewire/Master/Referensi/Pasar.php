<?php
namespace App\Livewire\Master\Referensi;
use Livewire\Component;
use App\Models\Referensi\RefPasar as Model;
use App\Models\Referensi\RefSatuan;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Storage;

class Pasar extends Component
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
    public $namapasar;
    public $tipe;
    public $lng;
    public $lat;
    public $provinsi;
    public $kabupaten;
    public $kecamatan;
    public $desa;
    
    public $provinsiList;
    public $kabupatenList;
    public $kecamatanList;
    public $kelurahanList;
    
    
    protected $rules = [
        'namapasar'    => 'required',
        'tipe'           => 'required',
        'longitude'           => 'required',
        'latitude'           => 'required',
        'provinsi'           => 'required',
        'kabupaten'          => 'required',
        'kecamatan'           => 'required',
        'desa'           => 'required',
    ];
    
    public function mount()
    {
        $this->provinsiList        = RefProvinsi::orderBy('name','ASC')->get();
        $this->kabupatenList       = RefKabupaten::where('province_id', $this->provinsi)->orderBy('name','ASC')->get();
        $this->kecamatanList       = RefKecamatan::where('regency_id', $this->kabupaten)->orderBy('name','ASC')->get();
        $this->kelurahanList       = RefDesa::where('district_id', $this->kecamatan)->orderBy('name','ASC')->get();
        
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
        
        return view('livewire.master.referensi.pasar', [
          'model'=> $rows
        ]);
    }
    
    // private function resetInput()
    // {
    //     $this->namabarang    = NULL;
    //     $this->satuan           = NULL;
    //     $this->gambar           = NULL;
    //     $this->id               = NULL;
    // }
    
    // public function cancel()
    // {
    //     $this->resetInput();
    //     $this->mode = 'create';
    //     $this->actionTitle = 'Tambah';

    // }
    
    // public function create()
    // {
    //     $this->resetInput();
    //     $this->mode = 'create';
    //     $this->actionTitle = 'Tambah';
    //     $this->showForm = true;
    //     $this->isOpen = true;
    //     $this->dispatch("showForm");
    // }
    
    // public function store()
    // {
    //     $this->validate();
        
    //     // PROSES UPLOAD
    //     $folderPath = "barang";
    //     if (!file_exists(Storage::disk('public')->path($folderPath))) {
    //         Storage::disk('public')->makeDirectory($folderPath, 0755, true);
    //     }
    //     $uploadedFile = $this->gambar;
    //     $fileName = $uploadedFile->getClientOriginalName(); // Mengambil nama asli file yang diunggah
    //     $fileExtension = $uploadedFile->getClientOriginalExtension(); // Mengambil ekstensi file yang diunggah
    //     $newFileName = time() . '_' . str_replace(' ','_',strtolower($fileName)); // Menyusun nama baru file
    //     // END PROSES UPLOAD
        
    //     $model = Model::firstOrNew(['id' =>  $this->id]);
    //     $model->id              = $this->id;
    //     $model->namabarang   = $this->namabarang;
    //     $model->satuan          = $this->satuan;
    //     $model->gambar          = $this->gambar->storeAs($folderPath, $newFileName, 'public');
    //     $model->created_id      = Auth::user()->id;
    //     $model->created_at      = date('Y-m-d H:i:s');
        
    //     if($model->save()){
    //         $this->resetInput();
    //         $log = 'Data barang '.$model->namabarang.' Berhasil di Ditambah';
    //         setActivity($log);
    //         $this->alert('success', $log, [
    //             'position' => 'top-end',
    //             'timer' => 3000,
    //             'toast' => true,
    //         ]);
    //     }else{
    //         $log = 'Data barang '.$model->namabarang.' Gagal di Ditambah';
    //         $this->alert('error', $log, [
    //             'position' => 'top-end',
    //             'timer' => 3000,
    //             'toast' => true,
    //         ]);
    //     }
    //     return redirect()->route('master.referensi.barang');

        
    // }
    
    // public function edit($primaryId)
    // {
    //     $this->isOpen = true;
    //     $this->mode = 'update';
    //     $this->actionTitle = 'Ubah';
    //     $this->primaryId = $primaryId;
    //     $model = Model::where('id','=',$primaryId)->first();
    //     $this->id   = $model->id;
    //     $this->namabarang   = $model->namabarang;
    //     $this->satuan          = $model->satuan;
    //     $this->gambar          = $model->gambar;
    //     $this->dispatch("showForm");
    //     $this->showForm = true;
    // }
    
    // public function update()
    // {
    //     $this->validate();
    //     // PROSES UPLOAD
    //     $folderPath = "barang";
    //     if (!file_exists(Storage::disk('public')->path($folderPath))) {
    //         Storage::disk('public')->makeDirectory($folderPath, 0755, true);
    //     }
    //     $uploadedFile = $this->gambar;
    //     $fileName = $uploadedFile->getClientOriginalName(); // Mengambil nama asli file yang diunggah
    //     $fileExtension = $uploadedFile->getClientOriginalExtension(); // Mengambil ekstensi file yang diunggah
    //     $newFileName = time() . '_' . str_replace(' ','_',strtolower($fileName)); // Menyusun nama baru file
    //     // END PROSES UPLOAD

    //     $model = Model::firstOrNew(['id' =>  $this->id]);
    //     $model->namabarang   = $this->namabarang;
    //     $model->satuan          = $this->satuan;
    //     $model->gambar          = $this->gambar->storeAs($folderPath, $newFileName, 'public');
        
    //     if($model->save()){
    //         $this->mode = "create";
    //         $this->actionTitle = 'Ubah';
    //         $this->resetInput();
    //         $log = 'Data barang '.$model->name.' Berhasil di Ubah';
    //         setActivity($log);
    //         $this->alert('success', $log, [
    //             'position' => 'top-end',
    //             'timer' => 3000,
    //             'toast' => true,
    //         ]);
    //     }else{
    //         $log = 'Data barang '.$model->name.' Gagal di Ubah';
    //         $this->alert('error', $log, [
    //             'position' => 'top-end',
    //             'timer' => 3000,
    //             'toast' => true,
    //         ]);
            
    //     }
    //     return redirect()->route('master.referensi.barang');
    // }
    // public function deleteRequest($id)
    // {
    //     $this->dispatch("swal:deleteRequest", [
    //         'type' => 'warning',
    //         'title' =>'Apa anda yakin ?',
    //         'text' =>'Setelah memilih YA maka data akan Dihapus',
    //         'id'=>$id
    //     ]);
    // }
    // public function deleteSelectedRequest($id)
    // {
    //     if(Model::where('id',$id)->delete()){
    //         $this->resetInput();
    //         $log = 'Data Barang Berhasil di Hapus';
    //         setActivity($log);
    //         $this->alert('success', $log, [
    //             'position' => 'top-end',
    //             'timer' => 3000,
    //             'toast' => true,
    //         ]);
    //     }else{
    //         $log = 'Data Barang Gagal di Hapus';
    //         $this->alert('error', $log, [
    //             'position' => 'top-end',
    //             'timer' => 3000,
    //             'toast' => true,
    //         ]);
            
    //     }
    //     return redirect()->route('master.referensi.barang');

    // }
    
    // public $isOpen = false;
    // public function toggle()
    // {
    //     $this->isOpen = !$this->isOpen;
    // }


    public function updatedProvinsi($provinsi){
        $this->kabupatenList = RefKabupaten::where('province_id', $this->provinsi)->get();
    }
    
    public function updatedKabupaten($kabupaten){
        $this->kecamatanList = RefKecamatan::where('regency_id', $this->kabupaten)->get();
        
    }
    
    public function updatedKecamatan($kecamatan){
        $this->kelurahanList = RefDesa::where('district_id', $this->kecamatan)->get();
        
    }
    
    
}