<?php
namespace App\Livewire\Modal\Transaksi\Barang;
use App\Models\Transaksi\Barang as Model;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefBarang;
use Illuminate\Support\Facades\Crypt;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;

class Edit extends ModalComponent
{
    use LivewireAlert;

    public $id_barang_update;
    public $pasarId;
    public $listPasar=[];
    public $listBarang=[];
    public $barangId;
    public $harga;
    public $created_at;
    public $created_id;
    public $updated_at;
    public $updated_id;
    public $deleted_at;
    public $deleted_id;
    public $barang_id;
    public $pasar_id;
    public $users_id;
    public $tanggal;
    public $stok_awal;
    public $stok_masuk;
    public $stok_keluar;
    public $stok_akhir;
    public $status;
    public $detail_tgl;
    public $harga_pasar;
    public $nama_barang;
    public $nama_pasar;

    public $barang;
    
    public function render()
    {
        return view('livewire.main.transaksi.barang.modal.edit');
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
        $this->barangId = $data->barang_id;
        $this->stok_awal = $data->stok_awal;
        $this->stok_masuk = $data->stok_masuk;
        $this->stok_keluar = $data->stok_keluar;
        $this->stok_akhir = $data->stok_akhir;
        $this->tanggal = $data->tanggal;
        $this->id_barang_update = $id;
        $this->listBarang = RefBarang::orderBy('namabarang','asc')->get();

        
    }

    public function update()
    {
        $selisih_harga  = hargaSelisih($this->barangId,$this->pasarId,$this->harga,$this->tanggal);
        $kondisi        = statusDinamika($this->barangId,$this->pasarId,$this->harga,$this->tanggal);
        $pasar = RefPasar::where('id',$this->pasarId)->first();
        $barang = RefBarang::where('id',$this->barangId)->first();
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $tanggalChangeTime = $dt->format('Y-m-d H:i:s');

        $model = Model::where('id',$this->id_barang_update)->first();
        $model->stok_awal = $this->stok_awal;
        $model->stok_masuk = $this->stok_masuk;
        $model->stok_keluar = $this->stok_keluar;
        $model->stok_akhir = $this->stok_akhir;
        $model->updated_id = Auth::user()->id;
        $model->updated_at = date('Y-m-d H:i:s');        
        if($model->update()){
            $this->alert('success', 'Update Harga Barang.'.$barang->namabarang.' Berhasil di Simpan', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
                return redirect()->route('main.barang');
            
        }else{
            $this->alert('error', 'Update Harga Barang.'.$barang->namabarang.' Gagal di Simpan', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
                return redirect()->route('main.barang');
        }
    }

    public function updated()
    {
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $this->stok_awal = stokSebelum($this->barangId,$this->pasarId,$tanggalChange);
    }

    public function hitung(){
        $this->stok_akhir = $this->stok_awal + $this->stok_masuk - $this->stok_keluar;
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

