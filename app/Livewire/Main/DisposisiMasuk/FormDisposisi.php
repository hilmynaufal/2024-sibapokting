<?php

namespace App\Livewire\Main\DisposisiMasuk;
use Livewire\Component;
use App\Models\SuratMasuk as Model;
use App\Models\Disposisi;
use App\Models\DisposisiMasuk;
use App\Models\User;
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
    
    
    public function mount()
    {        
        $this->jenis_disposisi_list     = RefJenisDisposisi::where('is_active','=',1)->where('is_delete','=',0)->orderBy('nama','asc')->get(); 
        $model = RefJabatan::where('token',getJabatan())->first();
        
        $a = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.no_induk as pegawai_no_induk', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('a.id','!=',Auth::user()->id)
        ->where('b.level_jabatan','>',$model->level_jabatan)
        ->where('a.unit_kerja_id',Auth::user()->unit_kerja_id)
        ->orderBy('a.nama','asc');
        // ->get();
        
        $b = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.no_induk as pegawai_no_induk', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_pembantu_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('a.id','!=',Auth::user()->id)
        ->where('b.level_jabatan','>',$model->level_jabatan)
        ->where('a.unit_kerja_id',Auth::user()->unit_kerja_id)
        ->orderBy('a.nama','asc')
        ->union($a);
        // ->get();
        
        $this->struktural_list = $b->orderBy('pegawai_nama','ASC')->get();
    }
    
    public function render()
    {
        return view('livewire.main.disposisi-masuk.form-disposisi',['primaryId'=>$this->primaryId]);
    }
    
    #[On('disposisi-created')]
    public function disposisiCreate($primaryId)
    {
        // dd($primaryId);
        $this->surat_masuk_id = $primaryId;
    }
    
    // #[On('disposisi-created')]
    public function disposisiInsert()
    {
        $this->validate([
            'disposisi_tujuan' => 'required',
            'disposisi_instruksi' => 'required',
            'disposisi_batas_waktu' => 'required',
            'disposisi_catatan' => 'required',
        ]);
        
        $disposisiTujuanString = implode(',', $this->disposisi_tujuan);
        $disposisiInstruksiString = implode(',', $this->disposisi_instruksi);
        
        $this->mode = 'disposisi';
        $model = Model::where('id',$this->surat_masuk_id)->first();
        $disposisi = Disposisi::firstOrNew(
            [
                'surat_id' => $model->id,
                'surat_id_token' => $model->token,
                'tipe' => 2,
                'is_active' => 1,
            ],
            [
                'create_id' => Auth::user()->id,
                'jabatan_id_token' => getJabatan(),
                'created_at' => date('Y-m-d H:i:s'),
                'disposisi_id'=>Auth::user()->id,
                'disposisi_at'=>date('Y-m-d H:i:s'),
                'disposisi_tujuan'=>$disposisiTujuanString,
                'disposisi_instruksi'=>$disposisiInstruksiString,
                'disposisi_batas_waktu'=>$this->disposisi_batas_waktu,
                'disposisi_catatan'=>$this->disposisi_catatan,
                'disposisi_nomor'=>generateDisposisiNumber(),
                'jabatan_id_token'=>getJabatan()
                ]
            );
            
            if($disposisi->save()){
                
                // DisposisiMasuk::where('surat_id', $this->surat_masuk_id)->where('tipe',2)->delete();
                
                $models = DisposisiMasuk::where('is_read',1)
                ->where('is_status',2)
                ->where('surat_id', $this->surat_masuk_id)
                ->where('jabatan_penerima_token', getJabatan())
                ->update(['is_disposisi' => 1]);
                
                // dd($models);
                
                $disposisi_tujuan_array = explode(",", $disposisiTujuanString);
                $pegawai_atasan = User::where('id', Auth::user()->id)->first();
                $atasan = RefJabatan::where(['token' => getJabatan()])->first();
                
                foreach ($disposisi_tujuan_array as $data) {
                    list($userID, $jabatanID) = explode(":", $data);
                    $pegawai = User::where('id', $userID)->first();
                    $pegawai_tujuan = RefJabatan::where(['token' => $jabatanID])->first();
                    // dd($pegawai_tujuan->level_jabatan);
                    
                    $directMessage = "Disposisi Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                    $directType = 1;
                    $ccType = 0;
                    $disposisiType = 2;
                    if ($pegawai_tujuan->level_jabatan == 7) {
                        // Apabila Staff
                        // Level 1
                        $level1UserID = getAtasanByJabatan(1,$pegawai_tujuan->atasan_id_token)->id;
                        $level1JabatanID = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->token;
                        $level1JabatanPosisi = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->jabatan;
                        // Level 2
                        $level2JabatanID = getAtasanByJabatan(2,$level1JabatanID)->atasan_id_token;
                        $level2UserID = getAtasanByJabatan(1,$level2JabatanID)->id;
                        $level2JabatanPosisi = getAtasanByJabatan(2,$level2JabatanID)->jabatan;
                        // Level 3
                        $level3JabatanID = getAtasanByJabatan(2,$level2JabatanID)->token;
                        $level3UserID = getAtasanByJabatan(1,$level3JabatanID)->id;
                        $level3JabatanPosisi = getAtasanByJabatan(2,$level3JabatanID)->jabatan;
                        // Level 4
                        $level4JabatanID = getAtasanByJabatan(2,$level3JabatanID)->token;
                        $level4UserID = getAtasanByJabatan(1,$level4JabatanID)->id;
                        $level4JabatanPosisi = getAtasanByJabatan(2,$level4JabatanID)->jabatan;
                        // Pesan
                        $ccMessage4 = "CC ke " . $level4JabatanPosisi . " Disposisi Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                        $ccMessage3 = "CC ke " . $level3JabatanPosisi . " Disposisi Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                        $ccMessage2 = "CC ke " . $level2JabatanPosisi . " Disposisi Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                        $ccMessage1 = "CC ke " . $level1JabatanPosisi . " Disposisi Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                        setDisposisi($disposisi->create_id, $model->token, $level4UserID, $ccMessage4, $disposisi->token, $ccType, $disposisiType, $level4JabatanID);
                        setDisposisi($disposisi->create_id, $model->token, $level3UserID, $ccMessage3, $disposisi->token, $ccType, $disposisiType, $level3JabatanID);
                        setDisposisi($disposisi->create_id, $model->token, $level2UserID, $ccMessage2, $disposisi->token, $ccType, $disposisiType, $level2JabatanID);
                        setDisposisi($disposisi->create_id, $model->token, $level1UserID, $ccMessage1, $disposisi->token, $ccType, $disposisiType, $level1JabatanID);
                        setDisposisi($disposisi->create_id, $model->token, $pegawai->id, $directMessage, $disposisi->token, $directType, $disposisiType, $pegawai_tujuan->token);
                    }elseif ($pegawai_tujuan->level_jabatan == 6) {
                        // Apabila Kabag
                        // Level 1
                        $level1UserID = getAtasanByJabatan(1,$pegawai_tujuan->atasan_id_token)->id;
                        $level1JabatanID = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->token;
                        $level1JabatanPosisi = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->jabatan;
                        // Level 2
                        $level2JabatanID = getAtasanByJabatan(2,$level1JabatanID)->atasan_id_token;
                        $level2UserID = getAtasanByJabatan(1,$level2JabatanID)->id;
                        $level2JabatanPosisi = getAtasanByJabatan(2,$level2JabatanID)->jabatan;
                        $ccMessage2 = "CC ke " . $level2JabatanPosisi . " Disposisi Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                        $ccMessage1 = "CC ke " . $level1JabatanPosisi . " Disposisi Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                        setDisposisi($disposisi->create_id, $model->token, $level2UserID, $ccMessage2, $disposisi->token, $ccType, $disposisiType, $level2JabatanID);
                        setDisposisi($disposisi->create_id, $model->token, $level1UserID, $ccMessage1, $disposisi->token, $ccType, $disposisiType, $level1JabatanID);
                        setDisposisi($disposisi->create_id, $model->token, $pegawai->id, $directMessage, $disposisi->token, $directType, $disposisiType, $pegawai_tujuan->token);
                    } elseif ($pegawai_tujuan->level_jabatan == 5) { 
                        // Apabila Kadiv
                        // Level 1
                        $level1UserID = getAtasanByJabatan(1,$pegawai_tujuan->atasan_id_token)->id;
                        $level1JabatanID = getAtasanByJabatan(2,$pegawai_tujuan->token)->atasan_id_token;
                        $level1JabatanPosisi = getAtasanByJabatan(2,$pegawai_tujuan->atasan_id_token)->jabatan;
                        $ccMessage = "CC ke " . $level1JabatanPosisi . " Disposisi Masuk Langsung dari " . $atasan->jabatan . " ke " . $pegawai_tujuan->jabatan;
                        // Tujuan Utama
                        setDisposisi($disposisi->create_id, $model->token, $level1UserID, $ccMessage, $disposisi->token, $ccType, $disposisiType, $level1JabatanID);
                        setDisposisi($disposisi->create_id, $model->token, $pegawai->id, $directMessage, $disposisi->token, $directType, $disposisiType, $pegawai_tujuan->token);
                    }else{
                        // Direct Langsung
                        // Tujuan Utama
                        setDisposisi($disposisi->create_id, $model->token, $pegawai->id, $directMessage, $disposisi->token, $directType, $disposisiType, $pegawai_tujuan->token);
                    }
                }
                
                $this->mode = "view";
                $this->resetInput();
                // return $this->alert('success', 'Disposisi Berhasil di Kirim', [
                    //     'position' => 'top',
                    //     'timer' => 3000,
                    //     'toast' => true,
                    //     'timerProgressBar' => true,
                    // ]);
                    return redirect()->to('main/disposisi/keluar');
                }else{
                    return $this->alert('error', 'Disposisi Gagal di Kirim', [
                        'position' => 'top',
                        'timer' => 3000,
                        'toast' => true,
                        'timerProgressBar' => true,
                    ]);
                }
                
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
            
        }
        