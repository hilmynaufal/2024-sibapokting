<?php
namespace App\Livewire\Modal\Master\Referensi\Komoditas;
use App\Models\Referensi\RefKomoditas as Model;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use Illuminate\Support\Facades\Crypt;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class View extends ModalComponent
{
    use LivewireAlert;

    public $id;
    public $namakomoditas;
    public $satuan;
    public $gambar;
    public $het;
    
    public function render()
    {
        return view('livewire.modal.master.referensi.komoditas.view');
    }
    
    public function mount($id)
    {

        $data = Model::where('id',$id)->first();
        $this->id = $data->id;
        $this->namakomoditas = $data->namakomoditas;
        $this->satuan       = $data->satuan;
        $this->gambar       = $data->gambar;
        $this->het          = $data->het;
    }

    public static function destroyOnClose(): bool
    {
        return true;
    }

    public static function closeModalOnClickAway(): bool
{
    return false;
}
    
}

