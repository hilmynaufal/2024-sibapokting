<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\Transaksi\Komoditas as Model;
use App\Models\Referensi\RefKomoditas;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Storage;

class Sidebar extends Component
{
    use WithPagination;
    public $komoditas_id = 89;
    public $komoditas_sekarang;
    public $komoditas_kemarin;
    public $list_komoditas;
    
    // #[Layout('components.layouts.keenthemes.frontend.app')]
    
    public function mount()
    {
       
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');

        $tanggal_sebelum = date('Y-m-d',strtotime($tanggal . "-1 days"));
        $tanggal_sebelum_1 = date('Y-m-d',strtotime($tanggal_sebelum . "-1 days"));
        $komoditas = Model::with('toKomoditas')->where('detail_tgl',$tanggal)
                    ->where('komoditas_id',$this->komoditas_id)->where('pasar_id',2)->first();

        if(empty($komoditas)){
            $before_komoditas = Model::with('toKomoditas')->where('detail_tgl',$tanggal_sebelum)
            ->where('komoditas_id',$this->komoditas_id)->first();
            if(empty($before_komoditas->pasar_id)){
                $befores_komoditas = Model::with('toKomoditas')->orderBy('detail_tgl','desc')
                ->where('komoditas_id',$this->komoditas_id)->first();
                $komoditas_sebelum = Model::where('pasar_id',2)
                ->where('komoditas_id',$befores_komoditas->komoditas_id)
                ->where('detail_tgl',$tanggal_sebelum)->first(); 
            }else{
                $komoditas_sebelum = Model::where('pasar_id',2)
                ->where('komoditas_id',$before_komoditas->komoditas_id)
                ->where('detail_tgl',$tanggal_sebelum)->first();
            }
        }else{  
            $komoditas_sebelum = Model::where('pasar_id',2)
            ->where('komoditas_id',$komoditas->komoditas_id)
            ->where('detail_tgl',$tanggal_sebelum_1)->first();

        }
        $this->list_komoditas = RefKomoditas::where('prioritas',1)->limit(9)->get();
        $this->komoditas_sekarang   = empty($komoditas) ? $before_komoditas : $komoditas;
        $this->komoditas_kemarin    = $komoditas_sebelum;

    }
    
    public function render()
    {
        return view('livewire.frontend.sidebar')
        ->extends('components.layouts.keenthemes.frontend.app');
        
    }

    public function setKomoditas($komoditasId){
        $this->komoditas_id = $komoditasId;
        $this->mount();
    }
    
}