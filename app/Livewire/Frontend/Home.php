<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\transaksi\Komoditas as Model;
use App\Models\website\RefBanner;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Storage;

class Home extends Component
{
    use WithPagination;
    public $komoditas_id;
    public $listBannerTop;
    public $listBannerActive;
    
    #[Layout('components.layouts.keenthemes.frontend.app')]
    
    public function mount()
    {
        $this->komoditas_id = 88;
        $this->listBannerTop = RefBanner::where('kategori','Header')->orderBy('id','asc')->get();
        $this->listBannerActive = RefBanner::where('kategori','Header')->orderBy('id','asc')->first();

        
    }
    
    public function render()
    {
        return view('livewire.frontend.home');
    }
    
    
    
}