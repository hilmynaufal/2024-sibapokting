<?php
namespace App\Livewire\Website\Berita;
use Livewire\Component;
use App\Models\Website\RefArticles as Model;
use App\Models\Website\RefKategori;

use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Storage;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;
    
    public function mount()
    {
        
    }

    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        $query = Model::query();
        $rows = $query->orderBy('id','asc')->get();
    
        return view('livewire.website.berita.index', [
          'model'=> $rows
        ]);
    }

    public function changeStatus($id){
        $status = Model::where('id',$id)->first();
        if($status->status == 'DRAFT'){
            Model::where('id',$id)->update(['status' => 'PUBLISH']);
            $this->alert('success', 'Publish Artikel', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            Model::where('id',$id)->update(['status' => 'DRAFT']);
            $this->alert('success', 'Draft Artikel', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }
    
    public function deleteRequest($id)
    {
        $this->dispatch("swal:deleteRequest", [
            'type' => 'warning',
            'title' =>'Apa anda yakin ?',
            'text' =>'Setelah memilih YA maka data akan Dihapus',
            'id'=>$id
        ]);
    }

    public function deleteSelectedRequest($id)
    {
        if(Model::where('id',$id)->delete()){
            $log = 'Berita Berhasil di Hapus';
            setActivity($log);
            $this->alert('success', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }else{
            $log = 'Berita Gagal di Hapus';
            $this->alert('error', $log, [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            
        }
        return redirect()->route('website.berita.index');

    }
    
    
}