<?php
namespace App\Livewire\Modal\Master\Referensi\Komoditas;
use App\Models\Referensi\RefKomoditas as Model;
use Illuminate\Support\Facades\Crypt;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Storage;


class Add extends ModalComponent
{
    use LivewireAlert;
    use WithFileUploads;

    public $id;
    public $namakomoditas;
    public $satuan;
    public $gambar;
    
    public function render()
    {
        return view('livewire.modal.master.referensi.komoditas.add');
    }
    public function mount()
    {
            $this->gambar      = $this->gambar;
    }


    public function create()
    {
        $this->validate([
                'namakomoditas' => 'required',
                'satuan' => 'required',
                'file' => 'file|mimes:pdf,jpg,jpeg,png,docx,doc,xls,xlsx|max:10000',
            ]);
            
            // PROSES UPLOAD

            $folderPath = "komoditas";
            if (!file_exists(Storage::disk('public')->path($folderPath))) {
                Storage::disk('public')->makeDirectory($folderPath, 0755, true);
            }
            $uploadedFile = $this->file;
            $fileName = $uploadedFile->getClientOriginalName(); // Mengambil nama asli file yang diunggah
            $fileExtension = $uploadedFile->getClientOriginalExtension(); // Mengambil ekstensi file yang diunggah
            $newFileName = time() . '_' . str_replace(' ','_',strtolower($fileName).'.'.$fileExtension); // Menyusun nama baru file

            // END PROSES UPLOAD

            $model = Model::create([
                'namakomoditas' => $this->namakomoditas,
                'satuan' => $this->satuan,
                'gambar' => $uploadedFile->storeAs($folderPath, $newFileName, 'public'),
                'created_id' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if($model->save()){
                $this->alert('success', 'Data Komoditas Berhasil Disimpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.komoditas');
            }else{
                $this->alert('error', 'Data Komoditas Gagal Disimpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('master.referensi.komoditas');
            }
            
    }
    
}

