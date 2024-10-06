<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\Website\RefArticles as Model;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use App\Models\Website\RefBanner;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Storage;
use DB;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Crypt;

class DetailEvent extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $perpage = 6;
    public $list_event;
    public $first_event;
    public $detail;


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount($id)
    {
        $idevent = Crypt::decrypt($id);
        $this->detail = Model::where('id',$idevent)->where('status','PUBLISED')->orderBy('created_at','asc')->first();
        $jmlHit = $this->detail->hit;
        $this->detail->hit = $jmlHit + 1;
        $this->detail->update();
        $this->list_event = Model::where('id','!=',$idevent)->where('status','PUBLISED')->where('kategori',2)->orderBy('created_at','asc')->limit(5)->get();

    }
    
    public function render()
    {
        return view('livewire.frontend.detail-event');
    }


}