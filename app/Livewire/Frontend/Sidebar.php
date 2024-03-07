<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\transaksi\Komoditas as Model;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Storage;

class Sidebar extends Component
{
    use WithPagination;
    public $komoditas_id;
    
    #[Layout('components.layouts.keenthemes.frontend.app')]
    
    public function mount()
    {
        $this->komoditas_id = 88;
        // $dt = new \Carbon\Carbon(now());
        // $tanggal = $dt->format('Y-m-d');
        // $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));
        // $komoditas = Komoditas::with('toKomoditas')->where('detail_tgl',$tanggal)->first();
        // $komoditas_sebelum = Komoditas::where('pasar_id',$komoditas->pasar_id)
        // ->where('komoditas_id',$komoditas->komoditas_id)
        // ->where('detail_tgl',$tanggal_sebelum)->first();
        // return [
        //     'komoditas' => $komoditas,
        //     'komoditas_sebelum' => $komoditas_sebelum
        // ];
    }
    
    public function render()
    {
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));
        $tanggal_sebelum_1 = date('Y-m-d',strtotime($tanggal_sebelum . "-1 days"));
        $komoditas = Model::with('toKomoditas')->where('detail_tgl',$tanggal)->first();
        if(empty($komoditas)){
            $before_komoditas = Model::with('toKomoditas')->where('detail_tgl',$tanggal_sebelum)->first();
            $komoditas_sebelum = Model::where('pasar_id',$before_komoditas->pasar_id)
            ->where('komoditas_id',$before_komoditas->komoditas_id)
            ->where('detail_tgl',$tanggal_sebelum)->first();
        }else{  
            $komoditas_sebelum = Model::where('pasar_id',$komoditas->pasar_id)
            ->where('komoditas_id',$komoditas->komoditas_id)
            ->where('detail_tgl',$tanggal_sebelum)->first();
        }
        
        return view('livewire.frontend.sidebar',[
            'komoditas' => empty($komoditas) ? $before_komoditas : $komoditas,
            'komoditas_sebelum' => $komoditas_sebelum
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
    //     return redirect()->route('master.referensi.pasar.barang');

        
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
    //     return redirect()->route('master.referensi.pasar.barang');
    // }
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
            $log = 'Data Pasar Berhasil di Hapus';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Data Pasar Gagal di Hapus';
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            
        }
        return redirect()->route('master.referensi.pasar');

    }
    
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