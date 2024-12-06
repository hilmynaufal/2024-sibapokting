<?php

namespace App\Livewire\Frontend;

use App\Models\Referensi\RefKomoditas;
use App\Models\Referensi\RefPasar;
use DateInterval;
use DateTime;
use Livewire\Component;
use Livewire\Attributes\Layout;

class GrafikBulananAll extends Component
{
    public $komoditas = 89;
    public $pasar;
    public $list_komoditas_search;
    public $list_pasar;

    public $date_komoditas;
    public $date_komoditas_before;
    public $kategori=[];

    public $pasar_tabel;
    public $date_start;
    public $date_end;
    
    #[Layout('components.layouts.keenthemes.frontend.dash')]

    public function mount(){
        $dt = new \Carbon\Carbon(now());
        $tanggal = $dt->format('Y-m-d');
        $this->date_komoditas = $tanggal;
        $this->date_komoditas_before = (new DateTime($tanggal))->sub(new DateInterval('P1D'))->format('Y-m-d');
        $this->list_komoditas_search = RefKomoditas::get();
        $this->list_pasar = RefPasar::orderBy('id','asc')->get();

        $this->pasar_tabel = 0;
        $this->date_start = (new DateTime($tanggal))->sub(new DateInterval('P1D'))->format('Y-m-d');
        $this->date_end =  $tanggal;

        foreach($this->list_pasar as $pasar){
            array_push($this->kategori,$pasar->namapasar);
        }
    }

    public function render()
    {
        return view('livewire.frontend.grafik-bulanan-all');
    }
}
