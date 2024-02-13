<?php

namespace App\Livewire\Main\SuratKeluar;
use Livewire\Component;
use App\Models\SuratKeluar as Model;
use App\Models\SuratMasuk;
use App\Models\User;
use App\Models\RefJabatan;
use App\Models\Verifikasi;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On; 
use DB;

class FormVerifikasiSurat extends Component
{
    use LivewireAlert;
    
    public $mode;   
    public $primaryId;   
    public $surat_keluar_id;
    
    // DISPOSISI
    public $approval_id;
    public $approval_at;
    public $approval_status;
    public $approval_catatan;
    
    protected $listeners = ['store' => 'disposisiReview','disposisiReviewApprove'];
    
    public function render()
    {
        return view('livewire.main.surat-keluar.form-verifikasi-surat',['primaryId'=>$this->primaryId]);
    }
    
    #[On('approval-surat-created')]
    public function disposisiCreate($primaryId)
    {
        // dd($primaryId);
        $this->surat_keluar_id = $primaryId;
    }
    
    public function disposisiInsert()
    {
        $this->validate([
            'approval_status' => 'required',
            'approval_catatan' => 'required',
        ]);
        
        $this->mode = 'disposisi';
        $model = Model::where('token',$this->surat_keluar_id)->first();
        
        $model->approval_id = Auth::user()->id;
        $model->approval_at = date('Y-m-d H:i:s');
        $model->approval_status = $this->approval_status;
        $model->approval_catatan = $this->approval_catatan;    
        
        if($model->update()){
            
            // dd($model);
            $verifikasi = Verifikasi::where('is_read',1)
            ->where('is_status',2)
            ->where('surat_id_token', $this->surat_keluar_id)
            ->where('jabatan_penerima_token', getJabatan())
            ->update(
                [
                    'is_approve' => $model->approval_status,
                    'approve_at' => $model->approval_at,
                    'catatan' => $model->approval_catatan
                    ]
                );
                
                if($verifikasi==true){
                    
                    $verifikasi_count = Verifikasi::where('is_approve',1)->where('surat_id_token', $this->surat_keluar_id)->count();
                    // dd($verifikasi_count);
                    if($verifikasi_count==1){
                        if($model->penandatangan_surat_dua_id==NULL){
                            setVerifikasi($model->create_id,$model->token,$model->penandatangan_surat_satu_id,$model->penandatangan_surat_satu_token,"Penandatangan Utama",0,2);
                        }else{
                            setVerifikasi($model->create_id,$model->token,$model->penandatangan_surat_dua_id,$model->penandatangan_surat_dua_token,"Penandatangan",0,2);
                        }
                    }elseif($verifikasi_count==2){
                        // setVerifikasi($model->create_id,$model->token,$model->penandatangan_surat_satu_id,$model->penandatangan_surat_satu_token,"Penandatangan Utama",0,2);
                        getCloneSurat($this->surat_keluar_id);
                    }elseif($verifikasi_count==3){
                        getCloneSurat($this->surat_keluar_id);
                    }
                    
                    $this->resetInput();
                    $this->mode = "view";
                    $this->dispatch('close-modal');
                    return $this->alert('success', 'Approval Surat Keluar Berhasil di Kirim', [
                        'position' => 'top',
                        'timer' => 3000,
                        'toast' => true,
                        'timerProgressBar' => true,
                    ]);
                }
                
                
            }    
        }    
        
        private function resetInput()
        {
            $this->mode = '';
            $this->surat_keluar_id = NULL;
            $this->approval_id = NULL;
            $this->approval_at = NULL;
            $this->approval_status = NULL;
            $this->approval_catatan = NULL;
            $this->resetErrorBag();
            $this->resetValidation();
        }
        
        
        #[On('disposisi-review')]
        public function disposisiReview($primaryId)
        {
            $this->surat_keluar_id = $primaryId;
            $data = Model::where('id',$this->surat_keluar_id)->first();
            return $this->alert('question', 'Apakah Anda Yakin Akan Approve Surat ? '.$data->perihal_surat.'', [
                'showConfirmButton' => true,
                'confirmButtonText' => 'Approve',
                'showCancelButton' => true,
                'cancelButtonText' => 'Batal',
                'onConfirmed' => 'disposisiReviewApprove',
                'toast' => false,
                'position' => 'center',
                'timer' => false
            ]);
        }
        
        #[On('disposisi-review2')]
        public function disposisiReview2($primaryId)
        {
            // dd($primaryId);
            $this->surat_keluar_id = $primaryId;
            $data = SuratKeluar::where('token',$this->surat_keluar_id)->first();
            return $this->alert('question', 'Apakah Anda Yakin Akan Approve Surat ? '.$data->perihal_surat.'', [
                'showConfirmButton' => true,
                'confirmButtonText' => 'Approve',
                'showCancelButton' => true,
                'cancelButtonText' => 'Batal',
                'onConfirmed' => 'suratKeluarReviewApprove',
                'toast' => false,
                'position' => 'center',
                'timer' => false
            ]);
        }
        
        public function disposisiReviewApprove()
        {
            $models = Verifikasi::where('is_read',1)
            ->where('is_status',2)
            ->where('surat_id', $this->surat_keluar_id)
            ->where('jabatan_penerima_token', getJabatan())
            ->update(['is_approve' => 1]);
            
            if ($models) {
                $alertMessage = 'Sudah Masuk sudah di Approve';
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
        
        public function suratKeluarReviewApprove()
        {
            $models = Verifikasi::where('is_read',1)
            ->where('is_status',2)
            ->where('surat_id_token', $this->surat_keluar_id)
            ->where('jabatan_penerima_token', getJabatan())
            ->update(['is_approve' => 1]);
            
            
            $surat_keluar = SuratKeluar::where('token',$this->surat_keluar_id)->first();
            $surat_keluar->is_approve=1;
            $surat_keluar->update();
            
            $surat_masuk = Model::firstOrNew(['token' =>  $surat_keluar->token]);
            $surat_masuk->id = Model::max('id') + 1;  
            // $surat_masuk = $surat_keluar->replicate();
            $surat_masuk->tgl_terima = date('Y-m-d');
            $surat_masuk->tgl_surat = $surat_keluar->tgl_surat;
            $surat_masuk->no_surat = $surat_keluar->no_surat;
            $surat_masuk->alamat = $surat_keluar->alamat;
            $surat_masuk->perihal_surat = $surat_keluar->perihal_surat;
            $surat_masuk->no_arsip = $surat_keluar->no_arsip;
            $surat_masuk->isi_surat = $surat_keluar->isi_surat;
            $surat_masuk->keterangan_surat = $surat_keluar->keterangan_surat;
            $surat_masuk->pengirim_surat = $surat_keluar->pengirim_surat;
            $surat_masuk->created_at = $surat_keluar->created_at;
            $surat_masuk->updated_at = $surat_keluar->updated_at;
            $surat_masuk->deleted_at = $surat_keluar->deleted_at;
            $surat_masuk->create_id = $surat_keluar->create_id;
            $surat_masuk->update_id = $surat_keluar->update_id;
            $surat_masuk->delete_id = $surat_keluar->delete_id;
            $surat_masuk->token = $surat_keluar->token;
            $surat_masuk->is_active = 1;
            $surat_masuk->is_delete = 0;
            $surat_masuk->is_read = 0;
            $surat_masuk->is_view = 0;
            $surat_masuk->file_lampiran = $surat_keluar->file_lampiran;
            $surat_masuk->file_lampiran_url = $surat_keluar->file_lampiran_url;
            $surat_masuk->file_lampiran_size = $surat_keluar->file_lampiran_size;
            $surat_masuk->pembuat_surat_id = $surat_keluar->pembuat_surat_id;
            $surat_masuk->pembuat_surat_token = $surat_keluar->pembuat_surat_token;
            $surat_masuk->sekretaris_surat_id = $surat_keluar->penandatangan_surat_satu_id;
            $surat_masuk->sekretaris_surat_token = $surat_keluar->penandatangan_surat_satu_token;
            $surat_masuk->tujuan_surat_id = $surat_keluar->tujuan_surat_id;
            $surat_masuk->tujuan_surat_token = $surat_keluar->tujuan_surat_token;
            $surat_masuk->satuan_kerja_id = $surat_keluar->satuan_kerja_id;
            $surat_masuk->satuan_kerja_token = $surat_keluar->satuan_kerja_token;
            // $surat_masuk->jenis_surat_id = $surat_keluar->jenis_surat_id;
            // $surat_masuk->sifat_surat_id = $surat_keluar->sifat_surat_id;
            $surat_masuk->save();
            
            if ($models) {
                $alertMessage = 'Sudah Masuk sudah di Approve';
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
    