<?php

namespace App\Livewire\Main\SuratKeluar;
use Livewire\Component;
use App\Models\Lampiran as Model;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Storage;

class DetailSuratLampiran extends Component
{
    use LivewireAlert;
    
    public $primaryId;   
    public $surat_masuk_id;   
    public $deleteLampiran_id;   
    public $mode;
    
    public function getListeners()
    {
        return [
            'confirmedLampiran',
        ];
    }
    
    public function mount($id)
    {
        $this->primaryId = $id;
        $this->surat_masuk_id = $id;
    }
    
    public function render()
    {
        return view('livewire.main.surat-keluar.detail-surat-lampiran',['primaryId'=>$this->primaryId]);
    }
    
    public function deleteConfirmLampiran($id)
    {
        $data = Model::where('id_lampiran',$id)->first();
        $this->deleteLampiran_id = $id;
        return $this->alert('question', 'Apakah Anda Yakin Akan Menghapus File ? '.$data->file_lampiran, [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Hapus',
            'showCancelButton' => true,
            'cancelButtonText' => 'Batal',
            'onConfirmed' => 'confirmedLampiran',
            'toast' => false,
            'position' => 'center',
            'timer' => false
        ]);
    }
    
    public function confirmedLampiran()
    {
        $lampiran = Model::where('id_lampiran',$this->deleteLampiran_id)->first();
        Storage::disk('public')->delete($lampiran->file_lampiran_url);
        setActivity('Menghapus File Lampiran: '.$lampiran->file_lampiran.' - Surat ID# '.$lampiran->surat_id);
        if($lampiran->delete()){
            $this->mode = 'view';
            return $this->alert('success', 'Lampiran Berhasil di Hapus', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Lampiran Gagal di Hapus', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
    }    
    
}
