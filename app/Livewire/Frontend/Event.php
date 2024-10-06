<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\Website\RefArticles as Model;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Event extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $perpage = 6;
    public $list_event;
    public $first_event;


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
        $this->first_event = Model::where('status','PUBLISED')->where('kategori',2)->orderBy('created_at','asc')->first();
        $this->list_event = Model::where('status','PUBLISED')->where('kategori',2)->orderBy('created_at','asc')->skip(1)->limit(3)->get();
    }
    
    public function render()
    {
        $query = Model::query();
        $rows = $query->where('status','PUBLISED')->where('kategori',2)->orderBy('created_at','asc')->skip(4)->paginate($this->perpage);
        return view('livewire.frontend.event', [
          'model'=> $rows
        ]);
    }


}