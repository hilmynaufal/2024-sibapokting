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
        $pasar = RefPasar::where('id',$this->pasarId)->first();
        $barang = RefBarang::where('id',$this->barangId)->first();
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $tanggalChangeTime = $dt->format('Y-m-d H:i:s');

            $model = Model::create([
                'barang_id' => $this->barangId,
                'pasar_id' => $this->pasarId,
                'users_id' => Auth::user()->id,
                'tanggal' => $tanggalChangeTime,
                'stok_awal' => $this->stok_awal,
                'stok_masuk' => $this->stok_masuk,
                'stok_keluar' => $this->stok_keluar,
                'stok_akhir' => $this->stok_akhir,
                'detail_tgl' => $tanggalChange,
                'nama_barang' => $barang->namabarang,
                'nama_pasar' => $pasar->namapasar,
                'created_id' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if($model->save()){
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
    public function updatedpasarId(){
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

