<?php
namespace App\Livewire\Main\LampiranLaporan;
use Illuminate\Support\Facades\Crypt;
use App\Models\LampiranLaporan as Model;
use Livewire\Component;
use Storage;
class Index extends Component
{
    public $lampiran_id;
    
    public function render()
    {
        return view('livewire.main.lampiran-laporan.index');
    }
    
    public function mount($id)
    {
        $this->lampiran_id = Crypt::decrypt($id);
        $model = Model::where('id_lampiran','=',$this->lampiran_id)->first();
        $file = Storage::disk('public')->url($model->file_lampiran_url);
        return redirect($file);
    }
}
