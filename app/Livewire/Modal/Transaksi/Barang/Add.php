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

class Add extends ModalComponent
{
    use LivewireAlert;

    public $id;
    public $listPasar;
    public $pasarId;
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
        return view('livewire.main.transaksi.barang.modal.add');
    }
    
    public function mount()
    {
        if(Auth::user()->role_id == 5){
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->where('id',Auth::user()->pasar_id)->get();
        }else{
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->get();
        }
        $this->pasarId = Auth::user()->pasar_id;
        $this->tanggal = date('Y-m-d H:i');
        // $this->listKomoditas = RefBarang::orderBy('namakomoditas','asc')->get();
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $this->barang = Model::where('pasar_id',$this->pasarId)->where('detail_tgl',$tanggalChange)->get();
        $barangInserted = [];
        foreach($this->barang as $value){
            array_push($barangInserted,$value->barang_id);
        }
        $this->listBarang = RefBarang::orderBy('namabarang','asc')
        ->whereNotIn('id', $barangInserted)->get();

        
    }

    public function create()
    {
        $selisih_harga  = hargaSelisih($this->komoditasId,$this->pasarId,$this->harga,$this->tanggal);
        $kondisi        = statusDinamika($this->komoditasId,$this->pasarId,$this->harga,$this->tanggal);
        $pasar = RefPasar::where('id',$this->pasarId)->first();
        $komoditas = RefBarang::where('id',$this->komoditasId)->first();
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $tanggalChangeTime = $dt->format('Y-m-d H:i:s');

            $model = Model::create([
                'komoditas_id' => $this->komoditasId,
                'pasar_id' => $this->pasarId,
                'users_id' => Auth::user()->id,
                'tanggal' => $tanggalChangeTime,
                'harga_publish' => $this->harga,
                'harga_dinamik' => $selisih_harga,
                'kondisi' => $kondisi,
                'status' => 'harga pasar',
                'harga_pasar' => $this->harga,
                'detail_tgl' => $tanggalChange,
                'nama_komoditas' => $komoditas->namakomoditas,
                'nama_pasar' => $pasar->namapasar,
                'created_id' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if($model->save()){
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
        $this->tanggal = date('Y-m-d H:i');
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $this->barang = Model::where('pasar_id',$this->pasarId)->where('detail_tgl',$tanggalChange)->get();
        $barangInserted = [];
        foreach($this->barang as $value){
            array_push($barangInserted,$value->barang_id);
        }
        $this->listBarang = RefBarang::orderBy('namabarang','asc')
        ->whereNotIn('id', $barangInserted)->get();

    }

    public function updatebarangId(){

        $this->barang = Model::where('pasar_id',$this->pasarId)->where('barang_id',$this->barangId)->where('detail_tgl',$tanggalChange)->get();
        dd($this->barang);
        // $this
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

