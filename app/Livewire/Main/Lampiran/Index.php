<?php
namespace App\Livewire\Main\Lampiran;
use Illuminate\Support\Facades\Crypt;
use App\Models\Lampiran as Model;
use App\Models\Verifikasi;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Storage;
class Index extends Component
{
    public $lampiran_id;
    
    public function render()
    {
        return view('livewire.main.lampiran.index');
    }
    
    public function mount($id)
    {
        $this->lampiran_id = Crypt::decrypt($id);
        // $verifikasi = Verifikasi::where('surat_id','=',$surat_masuk_id)
        // ->where('jabatan_penerima_token',Auth::model()->jabatan_id)
        // ->first();
        // $verifikasi->is_read=1;
        // $verifikasi->update();
        
        $model = Model::where('id_lampiran','=',$this->lampiran_id)->first();
        $file = Storage::disk('public')->url($model->file_lampiran_url);
        return redirect($file);
    }
}
