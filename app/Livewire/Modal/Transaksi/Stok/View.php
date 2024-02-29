<?php
namespace App\Livewire\Modal\Transaksi\Komoditas;
use App\Models\Transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use Illuminate\Support\Facades\Crypt;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;

class View extends ModalComponent
{
    use LivewireAlert;

    public $id_komoditas_update;
    public $listPasar;
    public $pasarId;
    public $listKomoditas=[];
    public $komoditasId;
    public $harga;
    public $created_at;
    public $created_id;
    public $updated_at;
    public $updated_id;
    public $deleted_at;
    public $deleted_id;
    public $komoditas_id;
    public $pasar_id;
    public $users_id;
    public $tanggal;
    public $harga_publish;
    public $harga_admin;
    public $harga_dinamik;
    public $kondisi;
    public $status;
    public $tanggal_update;
    public $harga_pasar;
    public $detail_tgl;
    public $nama_komoditas;
    public $nama_pasar;

    public $komoditas;
    
    public function render()
    {
        return view('livewire.main.transaksi.komoditas.modal.view');
    }
    
    public function mount($id)
    {
        $data = Model::where('id',$id)->first();

        if(Auth::user()->role_id == 5){
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->where('id',Auth::user()->pasar_id)->get();
        }else{
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->get();
        }
        $this->pasarId = $data->pasar_id;
        $this->komoditasId = $data->komoditas_id;
        $this->harga = $data->harga_publish;
        $this->tanggal = $data->tanggal;
        $this->id_komoditas_update = $id;
        $this->listKomoditas = RefKomoditas::orderBy('namakomoditas','asc')->get();

        
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

