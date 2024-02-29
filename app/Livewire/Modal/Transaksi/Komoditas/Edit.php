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

class Edit extends ModalComponent
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
        return view('livewire.main.transaksi.komoditas.modal.edit');
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

    public function update()
    {
        $selisih_harga  = hargaSelisih($this->komoditasId,$this->pasarId,$this->harga,$this->tanggal);
        $kondisi        = statusDinamika($this->komoditasId,$this->pasarId,$this->harga,$this->tanggal);
        $pasar = RefPasar::where('id',$this->pasarId)->first();
        $komoditas = RefKomoditas::where('id',$this->komoditasId)->first();
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $tanggalChangeTime = $dt->format('Y-m-d H:i:s');

        $model = Model::where('id',$this->id_komoditas_update)->first();
        $model->harga_publish = $this->harga;
        $model->harga_dinamik = $selisih_harga;
        $model->kondisi = $kondisi;
        $model->harga_pasar = $this->harga;
        $model->detail_tgl = $tanggalChange;
        $model->updated_id = Auth::user()->id;
        $model->updated_at = date('Y-m-d H:i:s');        
        if($model->update()){
            $this->alert('success', 'Update Harga Komoditas.'.$komoditas->namakomoditas.' Berhasil di Simpan', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
                return redirect()->route('main.komoditas');
            
        }else{
            $this->alert('error', 'Update Harga Komoditas.'.$komoditas->namakomoditas.' Gagal di Simpan', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
                return redirect()->route('main.komoditas');
        }
    }
    public function updatedpasarId(){
        // $cek_komoditas = RefKomoditas::join('t_siba_komoditas','t_siba_komoditas.komoditas_id','=','t_siba_komoditas.id','right')
        // ->where('t_siba_komoditas.pasar_id',$pasarId)
        // ->where('t_siba_komoditas.detail_tgl',date('Y-m-d'))->get();
        $this->tanggal = date('Y-m-d H:i');
        // $this->listKomoditas = RefKomoditas::orderBy('namakomoditas','asc')->get();
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $this->komoditas = Model::where('pasar_id',$this->pasarId)->where('detail_tgl',$tanggalChange)->get();
        $komoditasInserted = [];
        foreach($this->komoditas as $value){
            array_push($komoditasInserted,$value->komoditas_id);
        }
        $this->listKomoditas = RefKomoditas::orderBy('namakomoditas','asc')
        ->whereNotIn('id', $komoditasInserted)->get();
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

