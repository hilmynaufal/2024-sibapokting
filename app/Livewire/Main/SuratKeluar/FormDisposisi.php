<?php

namespace App\Livewire\Main\SuratKeluar;
use Livewire\Component;
use App\Models\SuratKeluar as Model;
use App\Models\Disposisi;
use App\Models\DisposisiMasuk;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\RefJabatan;
use App\Models\RefJenisDisposisi;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On; 
use DB;

class FormDisposisi extends Component
{
    use LivewireAlert;
    
    public $mode;   
    public $primaryId;   
    public $surat_masuk_id;   
    
    public $struktural_list;
    public $jenis_disposisi_list;
    
    
    // DISPOSISI
    public $disposisi_id;
    public $disposisi_at;
    public $disposisi_tujuan;
    public $disposisi_instruksi;
    public $disposisi_batas_waktu;
    public $disposisi_catatan;
    public $disposisi_nomor;
    
    
    
    public function render()
    {
        return view('livewire.main.surat-keluar.form-disposisi',['primaryId'=>$this->primaryId]);
    }
    
    private function resetInput()
    {
        $this->mode = '';
        $this->surat_masuk_id = NULL;
        
        $this->disposisi_id = NULL;
        $this->disposisi_at = NULL;
        $this->disposisi_tujuan = NULL;
        $this->disposisi_instruksi = NULL;
        $this->disposisi_batas_waktu = NULL;
        $this->disposisi_catatan = NULL;
        $this->disposisi_nomor = NULL;
        
        $this->resetErrorBag();
        $this->resetValidation();
        // $this->isOpen = false;
    }
    
    #[On('suratkeluar-review')]
    public function disposisiReview($primaryId)
    {
        dd($primaryId);
        $this->surat_masuk_id = $primaryId;
        $data = Model::where('id',$this->surat_masuk_id)->first();
        return $this->alert('question', 'Apakah Anda Yakin Akan Approve Surat Keluar ? '.$data->perihal_surat.'', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Approve',
            'showCancelButton' => true,
            'cancelButtonText' => 'Batal',
            'onConfirmed' => 'suratkeluarReview',
            'toast' => false,
            'position' => 'center',
            'timer' => false
        ]);
    }
    
    public function suratkeluarReview()
    {
        $models = Verifikasi::where('is_read',1)
        ->where('is_status',2)
        ->where('surat_id', $this->surat_masuk_id)
        ->where('jabatan_penerima_token', getJabatan())
        ->update(['is_approve' => 1]);
        
        if ($models) {
            $alertMessage = 'Sudah Keluar sudah di Approve';
            $alertType = 'warning';
        } else {
            $alertMessage = 'Verifikasi tidak ditemukan';
            $alertType = 'error';
        }
        
        return $this->alert($alertType, $alertMessage, [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }
    
}
