<?php
namespace App\Livewire\Main\Layanan\Bphtb\Form;
use Livewire\Component;
use App\Models\Bphtb\ObjekPajak as Model;
use App\Models\Bphtb\PembayaranPajak;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class Maps extends Component
{
    use LivewireAlert;
    
    public $lat;
    public $lng;
    public $id_bphtb;
    public $updated_id;
    public $updated_at;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.form.maps');
    }
    
    public function mount($id)
    {
        $bphtb = Crypt::decrypt($id);
        $model = Model::where('id_bphtb',$bphtb)->first(); 
        $this->id_bphtb = $model->id_bphtb;
        $this->lat = $model->lat;
        $this->lng = $model->lng;
    }
    
    public function create()
    {
        $model = Model::where('id_bphtb',$this->id_bphtb)->first();
        $model->updated_id = Auth::user()->id;
        $model->updated_at = date('Y-m-d H:i:s');  
        $model->lat = $this->lat;
        $model->lng = $this->lng;
        if($model->save()){
            $this->reset();
            $pembayaran = PembayaranPajak::where('id_bphtb',$model->id_bphtb)->first();
            $pembayaran->total_tagihan = $model->nilai_bayar_bphtb;
            $pembayaran->update();
            return redirect()->route('main.layanan.bphtb.detail', [Crypt::encrypt($model->id_bphtb)]);
        }
    }
    
    public function backForm()
    {
        return redirect()->route('bphtb.form.objek.pajak', [Crypt::encrypt($this->id_bphtb)]);
    }
    
}
