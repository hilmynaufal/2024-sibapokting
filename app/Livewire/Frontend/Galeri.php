<?php
namespace App\Livewire\Frontend;
use Livewire\Component;
use App\Models\Website\RefGaleri as Model;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class galeri extends Component
{
    use WithPagination,WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $perpage = 6;
    public $list_galeri;
    public $first_galeri;


    #[Layout('components.layouts.keenthemes.frontend.app')]

    public function mount()
    {
        $this->list_galeri = Model::orderBy('created_at','asc')->limit(6)->get();
    }
    
    public function render()
    {
        $query = Model::query();
        $rows = $query->paginate($this->perpage);

        return view('livewire.frontend.galeri', [
          'model'=> $rows
        ]);
    }


}