<?php

namespace App\Livewire\Website\Link;
use Livewire\Component;
use App\Models\Website\RefLink as Model;
use App\Models\Website\RefKategori;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Storage;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $id_link;
    public $nama;
    public $link;
    public $kategori;
    public $gambar;
    public $gambar_edit;
    public $created_at;
    public $created_id;
    public $updated_at;
    public $updated_id;
    public $deleted_at;
    public $deleted_id;
    public $token;

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.website.link.edit');
    }
    
    public function mount($id)
    {

        $idLink = Crypt::decrypt($id);
        $model = Model::where('id',$idLink)->first();
        $this->id_link    = $model->id;
        $this->nama        = $model->nama;
        $this->gambar       = $model->gambar;
        $this->link       = $model->link;
        $this->kategori     = $model->kategori;


    }


    public function create()
    {
        $this->validate([
            'nama' => 'required',
            'link' => 'required',
            'kategori' => 'required',
            ]);

            // dd($this->gambar->getRealPath())->toMediaCollection('gambar');
            if(!empty($this->gambar_edit)){
                $folderPathImage = "website/link";
                if (!file_exists(Storage::disk('public')->path($folderPathImage))) {
                    Storage::disk('public')->makeDirectory($folderPathImage, 0755, true);
                }
                $uploadedFileImage = $this->gambar_edit;
                $fileNameImage = $this->gambar_edit->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                $newFileNameImage = time() . '_' . str_replace(' ','_',strtolower($fileNameImage)); // Menyusun nama baru file
                $this->gambar_edit->storeAs($folderPathImage, $newFileNameImage, 'public');
            }
            
                $model = Model::where('id',$this->id_link)->first();
                
                $model->nama           = $this->nama;
                if(!empty($this->gambar_edit)){
                    $model->gambar          = $folderPathImage.'/'.$newFileNameImage;
                }
                $model->link          = $this->link;
                $model->kategori        = $this->kategori;
                $model->updated_id      = Auth::user()->id;
                $model->updated_at      = date('Y-m-d H:i:s');  
            // dd($this->images);
            // die;
            if($model->update()){
                $this->alert('success', 'Link Berhasil di Ubah', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('website.link.index');
            }else{
                $this->alert('error', 'Link Gagal di Ubah', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('website.link.index');
            }
            
    }
}

