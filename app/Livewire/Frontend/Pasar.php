<?php

namespace App\Livewire\Frontend;

use App\Models\Referensi\RefPasar;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Pasar extends Component
{
    public $cabang;
    public $ranting;
    public $rayon;
    public $siswa;
    public $warga;

    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
    
    }

    public function render()
    {
        $pasarpeta = RefPasar::where('deleted_id',null)->get();
        // dd($pasarpeta);
        return view('livewire.frontend.pasar',[
            'pasarpeta' => $pasarpeta
        ]);
    }

}
