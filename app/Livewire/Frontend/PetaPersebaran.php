<?php

namespace App\Livewire\Frontend;

use App\Models\Referensi\RefPasar;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Referensi\RefKomoditas;
use DateInterval;
use DateTime;

class PetaPersebaran extends Component
{
    #[Layout('components.layouts.keenthemes.frontend.dash')]
    public $komoditas = 89;
    public $list_komoditas_search;
    // public $list_pasar;

    public $date_komoditas;
    public $date_komoditas_before;
    public $kategori=[];

    public $pasar_tabel;
    public $date_start;
    public $date_end;

    public function mount(){
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->date_komoditas = $tanggal;
        $this->date_komoditas_before = (new DateTime($tanggal))->sub(new DateInterval('P1D'))->format('Y-m-d');
        $this->list_komoditas_search = RefKomoditas::get();
        // $this->list_pasar = RefPasar::orderBy('id','asc')->get();

        $this->pasar_tabel = 0;
        $this->date_start = (new DateTime($tanggal))->sub(new DateInterval('P1D'))->format('Y-m-d');
        $this->date_end =  $tanggal;

        // foreach($this->list_pasar as $pasar){
        //     array_push($this->kategori,$pasar->namapasar);
        // }
    }
    
    public function render()
    {
        $pasarpeta = RefPasar::where('deleted_id',null)->get();
        return view('livewire.frontend.peta-persebaran',[
            'pasarpeta' => $pasarpeta
        ]);
    }
}
