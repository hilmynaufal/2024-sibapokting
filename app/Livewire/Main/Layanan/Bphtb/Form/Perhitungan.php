<?php
namespace App\Livewire\Main\Layanan\Bphtb\Form;
use Livewire\Component;
use App\Models\Bphtb\ObjekPajak as Model;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class Perhitungan extends Component
{
    use LivewireAlert;
    public $lat;
    public $lng;
    
    public function render()
    {
        return view('livewire.main.layanan.bphtb.form.perhitungan');
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
        $this->validate([
            'lat' => 'required',
            'lng' => 'required',
        ]);
        $model = Model::where('id_bphtb',$this->id_bphtb)->first();
        $model->updated_id = Auth::user()->id;
        $model->updated_at = date('Y-m-d H:i:s');  
        
        $model->lat = $this->lat;
        $model->lng = $this->lng;
        if($model->save()){
            $this->reset();
            return redirect()->route('bphtb.form.perhitungan', [Crypt::encrypt($model->id_bphtb)]);
        }
    }
    
    public function backForm()
    {
        return redirect()->route('bphtb.form.objek.pajak', [Crypt::encrypt($this->id_bphtb)]);
    }
    
}
