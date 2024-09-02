<?php
namespace App\Livewire\Modal\Frontend;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailMaps extends ModalComponent
{
    use LivewireAlert;
    
    public function render()
    {
        return view('livewire.main.transaksi.barang.modal.add');
    }
    
    public function mount()
    {


        
    }

}

