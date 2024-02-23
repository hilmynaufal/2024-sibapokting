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

class Add extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $id;
    public $nama;
    public $gambar;
    public $link;
    public $kategori;
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
        return view('livewire.website.link.add');
    }
    
    public function mount()
    {
        // $this->kategoriList     = RefKategori::orderBy('nama','ASC')->get();
    }


    public function create()
    {
        $this->validate([
            'nama' => 'required',
            'gambar' => 'required',
            'kategori' => 'required',
            ]);

            // dd($this->gambar->getRealPath())->toMediaCollection('gambar');
            if(!empty($this->gambar)){
                $folderPathImage = "website/link";
                if (!file_exists(Storage::disk('public')->path($folderPathImage))) {
                    Storage::disk('public')->makeDirectory($folderPathImage, 0755, true);
                }
                $uploadedFileImage = $this->gambar;
                $fileNameImage = $this->gambar->getClientOriginalName(); // Mengambil nama asli file yang diunggah
                $newFileNameImage = time() . '_' . str_replace(' ','_',strtolower($fileNameImage)); // Menyusun nama baru file
                $this->gambar->storeAs($folderPathImage, $newFileNameImage, 'public');
            }

            $model = Model::create([
                'nama'             => $this->nama,
                'gambar'            => $folderPathImage.'/'.$newFileNameImage,
                'link'            => $this->link,
                'kategori'          => $this->kategori,
                'created_id'        => Auth::user()->id,
                'created_at'        => date('Y-m-d H:i:s'),
            ]);
            // dd($this->images);
            // die;
            if($model->save()){
                $this->alert('success', 'Link Berhasil di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('website.link.index');
            }else{
                $this->alert('error', 'Link Gagal di Simpan', [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return redirect()->route('website.link.index');
            }
            
    }
}

