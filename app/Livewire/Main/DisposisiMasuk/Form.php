<?php
namespace App\Livewire\Main\DisposisiMasuk;
use App\Models\DisposisiLaporan as Model;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Storage;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\LampiranLaporan;
use App\Models\SuratMasuk;
use App\Models\DisposisiMasuk;
use App\Models\Disposisi;
use Livewire\Attributes\On; 
class Form extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    
    #[Rule('required|min:3')] 
    public $deskripsi = '';
    
    #[Rule('required')] 
    public $file_lampiran = '';
    public $surat_masuk_id;
    
    public function render()
    {
        return view('livewire.main.disposisi-masuk.form');
    }
    
    #[On('laporan_form')]
    public function mount($id)
    {
        // dd($id);
        // $model = Model::where('surat_masuk_id',$id);
        $this->surat_masuk_id = $id;
    }
    
    private function resetInput()
    {
        $this->deskripsi = NULL;
        $this->file_lampiran = NULL;
        $this->resetErrorBag();
        $this->resetValidation();
    }
    
    public function store()
    {
        // $this->validate();
        $model = new Model();
        // dd($this->surat_masuk_id);
        $surat = SuratMasuk::where('id',$this->surat_masuk_id)->first();
        
        $model->id                  = Model::max('id') + 1;   
        $model->create_id           = Auth::user()->id;
        $model->surat_id            = $this->surat_masuk_id;
        $model->surat_id_token      = $surat->token;
        $model->jabatan_id_token    = Auth::user()->jabatan_id;
        $model->deskripsi           = $this->deskripsi;
        $model->jabatan_nama        = Auth::user()->nama;
        $model->jabatan_posisi      = Auth::user()->jabatan;
        $model->is_status           = 0;
        $model->is_delete           = 0;
        $model->is_read             = 0;
        $model->is_view             = 0;
        $model->is_response         = 1;
        $surat->is_complete         = 1;
        $surat->save();
        
        $disposisi_detail = DisposisiMasuk::where('is_read',1)
        ->where('is_status',2)
        ->where('surat_id', $this->surat_masuk_id)
        ->where('jabatan_penerima_token', getJabatan())
        ->first();
        $disposisi_detail->update(['is_response' => 1]);
        // dd(date('Y-m-d'));
        $disposisi = Disposisi::where('id',$disposisi_detail->disposisi_id)->first();
        $disposisi->is_compelete=1;
        // dd($disposisi);
        if($disposisi->disposisi_batas_waktu<date('Y-m-d')){
            $disposisi->is_expire = 1;
            $disposisi->expired_at = now();
        }
        $disposisi->update();
        
        if (!empty($this->file_lampiran)) {
            $this->validate(['file_lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10000']);
            $tgl_masuk = Carbon::parse($model->tgl_terima);
            $year = $tgl_masuk->year;
            $month = $tgl_masuk->month;
            $day = $tgl_masuk->day;
            // $folderPath = "file_lampiran_laporan/{$year}/{$month}/{$day}/{$model->token}/"; 
            $folderPath = "uploads/laporan_disposisi/{$year}/{$month}{$day}"; 
            if (!file_exists(Storage::disk('public')->path($folderPath))) {
                Storage::disk('public')->makeDirectory($folderPath, 0755, true);
            }
            
            // $model->file_lampiran = $this->file->getClientOriginalName();
            // $model->file_lampiran_url = $this->file->store($folderPath, 'public');
            // $model->file_lampiran_size = $this->file->getSize();
            
            foreach ($this->file_lampiran as $file) {
                $model->file_lampiran = $file->getClientOriginalName();
                LampiranLaporan::create([
                    'file_lampiran' => $file->getClientOriginalName(),
                    'file_lampiran_url' => $file->store($folderPath, 'public'),
                    'file_lampiran_size' => $file->getSize(),
                    'disposisi_detail_laporan_id' => $model->id,
                    'tipe' => 1,
                ]);
            }
        }
        
        if($model->save()){
            $this->dispatch('laporan-created', ['id' => $model->surat_id]);
            $this->resetInput();
            $mode = 'view';
            return $this->alert('success', 'Laporan Disposisi Berhasil di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Laporan Disposisi Gagal di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
        
    }
}
