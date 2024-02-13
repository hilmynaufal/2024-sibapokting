<?php
namespace App\Livewire\Main\SuratKeluar;
use Livewire\Component;
use App\Models\SuratKeluar as Model;
use App\Models\Lampiran;
use App\Models\Verifikasi;
use App\Models\User;
use App\Models\RefJabatan;
use App\Models\RefJenisSurat;
use App\Models\RefSifatSurat;
use App\Models\RefInstansi;
use App\Models\RefUnitKerja;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\On; 
use Livewire\Attributes\Rule; 
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate; 


class Index extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed'];
    public $search = '';
    public $showForm;
    
    public $create_id;
    public $update_id;
    
    // #[Rule('required|min:5')]
    public $tgl_terima = '';
    #[Validate('required')]
    public $tgl_surat = '';
    
    public $is_type;
    public $unit_kerja_id;
    public $sifat_surat_id;
    public $jenis_surat_id;
    public $pembuat_surat_id;
    public $satuan_kerja_id;
    public $no_surat;
    public $alamat_pengirim;
    public $perihal_surat;
    public $penandatangan_surat;
    public $penandatangan_surat_id;
    public $list_penandatangan_surat;
    public $tujuan_surat_id;
    public $tujuan_surat_eksternal_id;
    public $no_arsip;
    public $isi_surat;
    public $keterangan_surat;
    public $pengirim_surat;
    public $unit_kerja_list;
    public $sekretaris_list;
    public $struktural_list;
    
    public $jenis_surat_list;
    public $sifat_surat_list;
    public $instansi_list;
    
    public $unit_kerja_list_kabag;
    public $unit_kerja_list_kadiv;
    public $verifikator_id;
    
    public $file_lampiran;
    public $file_lampiran_url;
    public $file_lampiran_size;
    public $jenis_arsip;
    public $selectedState;
    
    public $deleteLampiran_id;
    public $surat_masuk_id = NULL;
    public $surat_masuk_token;
    public $no_arsip_surat;
    public $primaryId;
    public $url;
    public $icon;
    public $is_direct;
    
    // DISPOSISI
    public $disposisi_id;
    public $disposisi_at;
    public $disposisi_tujuan;
    public $disposisi_instruksi;
    public $disposisi_batas_waktu;
    public $disposisi_catatan;
    
    public $mode = 'create';
    public $perpage = 10;
    public $total;
    public $sortColoumName = "created_at";
    public $sortDirection = "desc";
    protected $queryString = ['search'];
    public $pilihan;
    
    
    public function mount()
    {
        $this->total = Model::where('is_active',1)->count();
        $this->jenis_surat_list   = RefJenisSurat::where('is_active','=',1)->where('is_delete','=',0)->orderBy('nama','asc')->get();    
        $this->sifat_surat_list   = RefSifatSurat::where('is_active','=',1)->where('is_delete','=',0)->orderBy('nama','asc')->get();    
        $this->instansi_list   = RefInstansi::where('is_active','=',1)->where('is_delete','=',0)->orderBy('nama','asc')->get();    
        $this->unit_kerja_list   = RefUnitKerja::where('is_active','=',1)->where('is_delete','=',0)->orderBy('unit_kerja','asc')->get();    
        
        $model = RefJabatan::where('token',getJabatan())->first();
        // dd($model->level_jabatan);
        $a = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('a.id','!=',Auth::user()->id)
        ->where('b.level_jabatan','<',$model->level_jabatan)
        // ->where('a.unit_kerja_id',Auth::user()->unit_kerja_id)
        ->orderBy('a.nama','asc');
        // ->get();
        $b = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_pembantu_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('a.id','!=',Auth::user()->id)
        ->where('b.level_jabatan','<',$model->level_jabatan)
        // ->where('a.unit_kerja_id',Auth::user()->unit_kerja_id)
        ->orderBy('a.nama','asc')
        ->union($a);
        // ->get();
        $this->struktural_list = $b->orderBy('pegawai_nama','ASC')->get();
        
        $aa = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('a.id','!=',Auth::user()->id)
        ->where('b.level_jabatan','=',5)
        ->orderBy('a.nama','asc');
        $bb = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_pembantu_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('a.id','!=',Auth::user()->id)
        ->where('b.level_jabatan','=',5)
        ->orderBy('a.nama','asc')
        ->union($aa);
        $this->unit_kerja_list_kadiv = $bb->orderBy('pegawai_nama','ASC')->get();
        
        $aaa = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('a.id','!=',Auth::user()->id)
        ->where('b.level_jabatan','=',6)
        ->orderBy('a.nama','asc');
        $bbb = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_pembantu_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)->where('a.id','!=',Auth::user()->id)
        ->where('b.level_jabatan','=',6)
        ->orderBy('a.nama','asc')
        ->union($aaa);
        $this->unit_kerja_list_kabag = $bbb->orderBy('pegawai_nama','ASC')->get();
        
    }
    
    protected $rules = [
        'tgl_surat' => 'required|date',
        // 'no_surat' => 'required',
        'perihal_surat' => 'required',
        'penandatangan_surat_id' => 'required',
        'tujuan_surat_id' => 'required',
    ];
    
    public function sortBy($coloumName)
    {
        if($this->sortColoumName === $coloumName){
            $this->sortDirection = $this->swapSortDirection();
        }else{
            $this->sortDirection ='asc';
        }
        $this->sortColoumName = $coloumName;
    }
    
    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        
        if(Auth::user()->role_id == 1) {
            $model = Model::where('is_delete', 0)
            ->where('satuan_kerja_token', Auth::user()->satuan_kerja_id)
            ->whereRaw('LOWER(perihal_surat) like ?', ['%' . strtolower($this->search) . '%'])
            ->orderBy($this->sortColoumName, $this->sortDirection)
            ->paginate($this->perpage);
            return view('livewire.main.surat-keluar.index', [ 'model' => $model ]);
        }elseif(Auth::user()->role_id==6 || Auth::user()->role_id==7){
            $model = DB::table('t_surat_keluar')
            ->select('t_surat_keluar.*', 't_verifikasi.jabatan_penerima_token', 't_verifikasi.id as verifikasi_id','t_verifikasi.is_read as verifikasi_is_read','t_verifikasi.jabatan_penerima_posisi','t_verifikasi.is_approve as verifikasi_is_approve')
            ->leftJoin('t_verifikasi', 't_surat_keluar.id', '=', 't_verifikasi.surat_id')
            ->where('t_surat_keluar.pembuat_surat_id', Auth::user()->id)
            ->where('t_verifikasi.jabatan_penerima_token', getJabatan())
            ->where('t_surat_keluar.satuan_kerja_token', Auth::user()->satuan_kerja_id)
            ->where('t_surat_keluar.is_delete', 0)
            ->where('t_verifikasi.tipe', 2)
            ->where(DB::raw('LOWER(t_surat_keluar.perihal_surat)'), 'LIKE', '%' . strtolower($this->search) . '%')
            ->orderBy($this->sortColoumName, $this->sortDirection)
            ->paginate($this->perpage);
            
            return view('livewire.main.surat-keluar.index', [ 'model' => $model ]);
            
        }else{
            $model = DB::table('t_surat_keluar')
            ->select('t_surat_keluar.*', 't_verifikasi.jabatan_penerima_token', 't_verifikasi.id as verifikasi_id','t_verifikasi.is_read as verifikasi_is_read','t_verifikasi.jabatan_penerima_posisi','t_verifikasi.is_approve as verifikasi_is_approve')
            ->leftJoin('t_verifikasi', 't_surat_keluar.id', '=', 't_verifikasi.surat_id')
            ->where('t_verifikasi.jabatan_penerima_token', getJabatan())
            ->where('t_surat_keluar.satuan_kerja_token', Auth::user()->satuan_kerja_id)
            ->where('t_surat_keluar.is_delete', 0)
            ->where('t_verifikasi.tipe', 2)
            ->where(DB::raw('LOWER(t_surat_keluar.perihal_surat)'), 'LIKE', '%' . strtolower($this->search) . '%')
            ->orderBy($this->sortColoumName, $this->sortDirection)
            ->paginate($this->perpage);
            // dd($model);
            return view('livewire.main.surat-keluar.index-verifikasi', [ 'model' => $model ]);
        }
        
        setActivity('Pengguna Mengakses Menu Surat Keluar');
    }
    
    
    private function resetInput()
    {
        $this->mode = '';
        $this->surat_masuk_id = NULL;
        $this->tgl_terima = NULL;
        $this->tgl_surat = NULL;
        $this->pembuat_surat_id = NULL;
        $this->satuan_kerja_id = NULL;
        $this->no_surat = NULL;
        $this->alamat_pengirim = NULL;
        $this->perihal_surat = NULL;
        $this->jenis_surat_id = '';
        $this->sifat_surat_id = '';
        $this->penandatangan_surat = '';
        $this->verifikator_id = '';
        $this->tujuan_surat_id = '';
        $this->no_arsip = NULL;
        $this->isi_surat = NULL;
        $this->keterangan_surat = NULL;
        $this->pengirim_surat = NULL;
        $this->file_lampiran = NULL;
        $this->file_lampiran_url = NULL;
        $this->file_lampiran_size = NULL;
        $this->is_type = '';
        $this->tujuan_surat_eksternal_id = '';
        $this->resetErrorBag();
        $this->resetValidation();
        $this->isOpen = false;
    }
    
    public function cancel()
    {
        $this->resetInput();
        $this->isOpen = true;
        $this->mode = 'cancel';
    }
    
    public function create()
    {
        $this->resetInput();
        $this->isOpen = !$this->isOpen;
        $this->mode = 'create';
        $this->dispatch('select2');
    }
    
    public function hydrate()
    {
        $this->dispatch('select2');
    }
    
    public function store()
    {
        // dd($this->tujuan_surat_eksternal_id);
        $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->surat_masuk_id]);
        $model->id = Model::max('id') + 1;   
        $model->create_id = Auth::user()->id;
        $model->tgl_terima = $this->tgl_terima;
        $model->tgl_surat = $this->tgl_surat;
        
        $model->pembuat_surat_id = Auth::user()->id;
        $model->pembuat_surat_token = getJabatan();
        $model->satuan_kerja_token = Auth::user()->satuan_kerja_id;
        
        $model->penandatangan_surat = implode(",", $this->penandatangan_surat);
        $penandatangan_surats = explode(",",$model->penandatangan_surat);
        foreach($penandatangan_surats as $index => $data){
            if($index==0){
                list($user_satu, $jabatan_satu) = explode(":", $data);
                $model->penandatangan_surat_satu_id = $user_satu;
                $model->penandatangan_surat_satu_token = $jabatan_satu;
            }else{
                list($user_dua, $jabatan_dua) = explode(":", $data);
                $model->penandatangan_surat_dua_id = $user_dua;
                $model->penandatangan_surat_dua_token = $jabatan_dua;
            }
        }
        
        if($this->is_type==1){
            $tujuan = $this->tujuan_surat_id;
        }else{
            $tujuan = $this->tujuan_surat_eksternal_id;
        }
        // dd($tujuan);
        list($userIDTujuan, $jabatanIDTujuan) = explode(":", $tujuan);
        // list($userIDTujuan, $jabatanIDTujuan) = explode(":", $this->tujuan_surat_id);
        // $tujuan = User::where('id',$this->tujuan_surat_id)->first();
        $model->tujuan_surat_id = $userIDTujuan;
        $model->tujuan_surat_token = $jabatanIDTujuan;
        
        list($userIDVerifikatorSatu, $jabatanIDVerifikatorSatu) = explode(":", $this->verifikator_id);
        $model->verifikator_id = $userIDVerifikatorSatu;
        $model->verifikator_token = $jabatanIDVerifikatorSatu;
        
        list($userIDVerifikatorDua, $jabatanIDVerifikatorDua) = explode(":", $this->unit_kerja_id);
        $model->unit_kerja_id = $userIDVerifikatorDua;
        $model->unit_kerja_token = $jabatanIDVerifikatorDua; 
        
        // $model->no_arsip = $this->no_arsip == NULL ? generateArsipKeluarNumber($this->unit_kerja_id) : $this->no_arsip;
        
        $model->no_surat = $this->no_surat;
        $model->no_arsip = $this->no_surat;
        
        $model->alamat = $this->alamat_pengirim;
        $model->perihal_surat = $this->perihal_surat;
        $model->isi_surat = $this->isi_surat;
        $model->keterangan_surat = $this->keterangan_surat;
        $model->pengirim_surat = $this->pengirim_surat; 
        $model->jenis_surat_id = $this->jenis_surat_id; 
        $model->sifat_surat_id = $this->sifat_surat_id; 
        $model->is_type = $this->is_type; 
        $model->is_active       = 1;
        $model->is_delete       = 0;
        $model->is_read         = 0;
        $model->is_approve      = 0;
        
        if($model->save()){
            
            $surat_keluar = Model::where('token',$model->token)->first();
            if (!empty($this->file_lampiran)) {
                $this->validate(['file_lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10000']);
                $tgl_masuk = Carbon::parse($model->tgl_terima);
                $year = $tgl_masuk->year;
                $month = $tgl_masuk->month;
                $day = $tgl_masuk->day;
                // $folderPath = "file_lampiran/surat_keluar/{$year}/{$month}/{$day}/{$model->token}/"; 
                $folderPath = "uploads/surat_keluar/{$year}/{$month}{$day}"; 
                if (!file_exists(Storage::disk('public')->path($folderPath))) {
                    Storage::disk('public')->makeDirectory($folderPath, 0755, true);
                }
                foreach ($this->file_lampiran as $file) {
                    $surat_keluar->file_lampiran = $file->getClientOriginalName();
                    $surat_keluar->file_lampiran_url = $file->store($folderPath, 'public');
                    $surat_keluar->file_lampiran_size = $file->getSize();
                    $surat_keluar->update();
                    Lampiran::create([
                        'create_id' => Auth::user()->id,
                        'file_lampiran_ekstensi' => $file->getExtension(),
                        'file_lampiran' => $file->getClientOriginalName(),
                        'file_lampiran_url' => $file->store($folderPath, 'public'),
                        'file_lampiran_size' => $file->getSize(),
                        'surat_id' => $model->id,
                        'surat_id_token' => $model->token,
                        'tipe' => 2,
                    ]);
                    setActivity('Add Lampiran: '.$file->getClientOriginalName().' pada '.$model->perihal_surat.' - ID# '.$model->id);
                }
                
            }
            
            
            setVerifikasi($model->create_id,$model->token,$model->pembuat_surat_id,$model->pembuat_surat_token,"Entry Surat Keluar",1,2);
            setVerifikasi($model->create_id,$model->token,$model->verifikator_id,$model->verifikator_token,"Review & Approval Surat Keluar",0,2);
            // setVerifikasi($model->create_id,$model->token,$model->unit_kerja_id,$model->unit_kerja_token,"Review & Approval Kadiv Surat Keluar",0,2);
            // setVerifikasi($model->create_id,$model->token,$model->penandatangan_surat_id,$model->penandatangan_surat_token,"Review & Approval Penanda Tangan Surat Keluar",0,2);
            // setVerifikasi($model->create_id,$model->token,$model->tujuan_surat_id,"Tujuan Penerima Surat Keluar",0,2);
            
            $this->resetInput();
            $mode = 'view';
            setActivity('Tambah Surat Keluar: '.$model->perihal_surat.' - ID# '.$model->id);
            return $this->alert('success', 'Surat Keluar Berhasil di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Surat Keluar Gagal di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
        
    }
    
    public function edit($primaryId)
    {
        // dd($this->primaryId);
        $this->resetInput();
        $this->isOpen = true;
        $this->mode = 'update';
        $this->primaryId = $primaryId;
        
        $model = Model::where('id','=',$primaryId)->first();
        $model->is_read=1;
        $model->update();
        
        $this->update_id = Auth::user()->id;
        $this->tgl_terima = $model->tgl_terima;
        $this->tgl_surat = $model->tgl_surat;
        $this->pembuat_surat_id = $model->pembuat_surat_id;
        $this->no_surat = $model->no_surat;
        $this->alamat_pengirim = $model->alamat;
        $this->perihal_surat = $model->perihal_surat;
        
        // $this->penandatangan_surat_id = $model->penandatangan_surat_id.":".$model->penandatangan_surat_token;
        // $this->penandatangan_surat_id = $model->penandatangan_surat_id.":".$model->penandatangan_surat_token;
        
        if($model->is_type==1){
            $this->tujuan_surat_id = $model->tujuan_surat_id.":".$model->tujuan_surat_token;
        }else{
            $this->tujuan_surat_id = $model->tujuanEksternal->id.":".$model->tujuanEksternal->token;
        }
        
        // dd($this->tujuan_surat_id);
        
        $this->verifikator_id = $model->verifikator_id.":".$model->verifikator_token;
        $this->unit_kerja_id = $model->unit_kerja_id.":".$model->unit_kerja_token;
        // $this->penandatangan_surat = explode(",",$model->penandatangan_surat);
        $this->list_penandatangan_surat = convertStringToArray($model->penandatangan_surat);
        // dd($this->list_penandatangan_surat);
        
        
        
        // dd($this->penandatangan_surat);
        
        $this->no_arsip = $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat; 
        $this->surat_masuk_id     = $model->id;
        $this->jenis_surat_id     = $model->jenis_surat_id;
        $this->sifat_surat_id     = $model->sifat_surat_id;
        $this->is_type            = $model->is_type;
    }
    
    public function update()
    {
        // dd($this->no_arsip_surat);
        // $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->surat_masuk_id]);
        $model->create_id = Auth::user()->id;
        $model->tgl_terima = $this->tgl_terima;
        $model->tgl_surat = $this->tgl_surat;
        $model->pembuat_surat_id = $this->pembuat_surat_id;
        $model->no_surat = $this->no_surat;
        $model->alamat = $this->alamat_pengirim;
        $model->perihal_surat = $this->perihal_surat;
        
        $model->pembuat_surat_id = Auth::user()->id;
        $model->pembuat_surat_token = getJabatan();
        $model->satuan_kerja_token = Auth::user()->satuan_kerja_id;
        
        $model->penandatangan_surat = implode(",", $this->penandatangan_surat);
        $penandatangan_surats = explode(",",$model->penandatangan_surat);
        foreach($penandatangan_surats as $index => $data){
            if($index==0){
                list($user_satu, $jabatan_satu) = explode(":", $data);
                $model->penandatangan_surat_satu_id = $user_satu;
                $model->penandatangan_surat_satu_token = $jabatan_satu;
            }else{
                list($user_dua, $jabatan_dua) = explode(":", $data);
                $model->penandatangan_surat_dua_id = $user_dua;
                $model->penandatangan_surat_dua_token = $jabatan_dua;
            }
        }
        
        if($this->is_type==1){
            $tujuan = $this->tujuan_surat_id;
        }else{
            $tujuan = $this->tujuan_surat_eksternal_id;
        }
        // dd($tujuan);
        list($userIDTujuan, $jabatanIDTujuan) = explode(":", $tujuan);
        // $tujuan = User::where('id',$this->tujuan_surat_id)->first();
        $model->tujuan_surat_id = $userIDTujuan;
        $model->tujuan_surat_token = $jabatanIDTujuan;
        
        list($userIDVerifikatorSatu, $jabatanIDVerifikatorSatu) = explode(":", $this->verifikator_id);
        $model->verifikator_id = $userIDVerifikatorSatu;
        $model->verifikator_token = $jabatanIDVerifikatorSatu;
        
        list($userIDVerifikatorDua, $jabatanIDVerifikatorDua) = explode(":", $this->unit_kerja_id);
        $model->unit_kerja_id = $userIDVerifikatorDua;
        $model->unit_kerja_token = $jabatanIDVerifikatorDua; 
        
        // $model->no_arsip = $this->no_arsip == NULL ? generateArsipKeluarNumber($model->unit_kerja_id) : $this->no_arsip;
        $model->no_surat = $this->no_surat;
        $model->no_arsip = $this->no_surat;
        
        $model->isi_surat = $this->isi_surat;
        $model->keterangan_surat = $this->keterangan_surat;
        $model->pengirim_surat = $this->pengirim_surat;
        $model->jenis_surat_id = $this->jenis_surat_id;
        $model->sifat_surat_id = $this->sifat_surat_id;
        $model->is_type = $this->is_type;
        $model->is_active   = 1;
        $model->is_delete   = 0;
        $model->is_read     = 0;
        $model->is_approve  = 0;
        $model->update_id   = Auth::user()->id;
        
        // dd($model);
        
        if (!empty($this->file_lampiran)) {
            $this->validate(['file_lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:10000']);
            $tgl_masuk = Carbon::parse($model->tgl_terima);
            $year = $tgl_masuk->year;
            $month = $tgl_masuk->month;
            $day = $tgl_masuk->day;
            // $folderPath = "file_lampiran/surat_keluar/{$year}/{$month}/{$day}/{$model->token}/"; 
            $folderPath = "uploads/surat_keluar/{$year}/{$month}{$day}"; 
            if (!file_exists(Storage::disk('public')->path($folderPath))) {
                Storage::disk('public')->makeDirectory($folderPath, 0755, true);
            }
            foreach ($this->file_lampiran as $file) {
                $model->file_lampiran = $file->getClientOriginalName();
                $model->file_lampiran_url = $file->store($folderPath, 'public');
                $model->file_lampiran_size = $file->getSize();
                Lampiran::create([
                    'create_id' => Auth::user()->id,
                    'file_lampiran_ekstensi' => $file->getExtension(),
                    'file_lampiran' => $file->getClientOriginalName(),
                    'file_lampiran_url' => $file->store($folderPath, 'public'),
                    'file_lampiran_size' => $file->getSize(),
                    'surat_id' => $model->id,
                    'surat_id_token' => $model->token,
                    'tipe' => 2,
                ]);
                setActivity('Ubah Lampiran: '.$file->getClientOriginalName().' pada '.$model->perihal_surat.' - ID# '.$model->id);
            }
        }
        if($model->update()){
            
            // CLEAR DATA
            Verifikasi::where('surat_id_token', $model->token)->delete();
            // SET KE TIMELINE
            setVerifikasi($model->create_id,$model->token,$model->pembuat_surat_id,$model->pembuat_surat_token,"Entry Surat Keluar",1,2);
            setVerifikasi($model->create_id,$model->token,$model->verifikator_id,$model->verifikator_token,"Review & Approval Surat Keluar",0,2);
            // setVerifikasi($model->create_id,$model->token,$model->unit_kerja_id,$model->unit_kerja_token,"Review & Approval Kadiv Surat Keluar",0,2);
            // setVerifikasi($model->create_id,$model->token,$model->penandatangan_surat_id,$model->penandatangan_surat_token,"Review & Approval Penanda Tangan Surat Keluar",0,2);
            // setVerifikasi($model->create_id,$model->token,$model->tujuan_surat_id,"Tujuan Penerima Surat Keluar",0,2);
            
            $this->mode = "view";
            setActivity('Ubah Surat Keluar: '.$model->perihal_surat.' - ID# '.$model->id);
            $this->resetInput();
            $this->alert('success', 'Surat Keluar Berhasil di Ubah', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Surat Keluar Gagal di Ubah', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
        
    }
    
    public function deleteConfirm($id)
    {
        $data = Model::where('id',$id)->first();
        // dd($data);
        $this->surat_masuk_id = $id;
        return $this->alert('question', 'Apakah Anda Yakin Akan Menghapus Surat Keluar ? '.$data->perihal_surat.'', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Hapus',
            'showCancelButton' => true,
            'cancelButtonText' => 'Batal',
            'onConfirmed' => 'confirmed',
            'toast' => false,
            'position' => 'center',
            'timer' => false
        ]);
    }
    
    public function confirmed()
    {
        $model = Model::where('id',$this->surat_masuk_id)->first();
        $model->is_delete = 1;
        $model->is_active = 0;
        if($model->save()){
            $this->resetInput();
            setActivity('Hapus Surat Keluar: '.$model->perihal_surat.' - ID# '.$model->id);
            return $this->alert('success', 'Surat Keluar Berhasil di Hapus', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Surat Keluar Gagal di Hapus', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
    }
    
    public $isOpen = false;
    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }
    
    public function status($id)
    {
        $model = Model::where('id', $id)->firstOrFail();
        $newStatus = $model->is_active === 1 ? 0 : 1;
        $infoStatus = $newStatus == 1 ? "Tidak Aktif" : "Aktif"; 
        $model->update(['is_active' => $newStatus]);
        return $this->alert('success', 'Status Surat Keluar '.$model->perihal_surat.' '.$infoStatus, [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }
    
    public function view($primaryId)
    {
        // dd($primaryId);
        $this->resetInput();
        $this->isOpen = true;
        $this->mode = 'view';
        
        $this->primaryId = $primaryId;
        $model = Model::where('id','=',$primaryId)->first();
        $model->is_view+=1;
        $model->update();
        
        $this->update_id = Auth::user()->id;
        $this->tgl_terima = Carbon::parse($model->tgl_terima)->locale('id')->isoFormat('LL');
        $this->tgl_surat = Carbon::parse($model->tgl_surat)->locale('id')->isoFormat('LL');
        $this->pembuat_surat_id = $model->pembuat_surat_id;
        $this->no_surat = $model->no_surat;
        $this->alamat_pengirim = $model->alamat;
        $this->perihal_surat = $model->perihal_surat;
        
        if($model->is_type==1){
            $this->tujuan_surat_id = $model->tujuan->jabatan;
        }else{
            $this->tujuan_surat_id = $model->tujuanEksternal->nama;
        }
        
        $this->no_arsip = $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat; 
        $this->surat_masuk_id = $model->id;
        $this->file_lampiran = $model->file_lampiran;
        $this->file_lampiran_url = $model->file_lampiran_url;
        $this->file_lampiran_size = $model->file_lampiran_size;
    }    
    
    public function viewTracking($primaryId)
    {
        $this->resetInput();
        $this->isOpen = true;
        $this->mode = 'tracking';
        $this->primaryId = $primaryId;
        
        // dd($primaryId);
        
        $model = Model::where('id','=',$primaryId)->first();
        // $model->is_read=1;
        // $model->update();
        
        $this->update_id = Auth::user()->id;
        $this->tgl_terima = $model->tgl_terima;
        $this->tgl_surat = $model->tgl_surat;
        $this->pembuat_surat_id = $model->pembuat_surat_id;
        $this->no_surat = $model->no_surat;
        $this->alamat_pengirim = $model->alamat;
        $this->perihal_surat = $model->perihal_surat;
        $this->tujuan_surat_id = $model->tujuan_surat_id;
        $this->no_arsip = $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat; 
        $this->surat_masuk_id     = $model->id;
    }    
    
    public function viewVerifikasi($primaryId)
    {
        // $this->resetInput();
        $this->toggle();
        // $this->isOpen = true;
        $this->mode = 'view';
        
        $verifikasi = Verifikasi::where('id', $primaryId)->where('jabatan_penerima_token', getJabatan())->firstOrFail();
        $verifikasi->where('id', $primaryId)->update([
            'is_view' => $verifikasi->is_view + 1,
            'is_read' => 1,
            'is_status' => 2,
            'view_at' => now(),
            'read_at' => now(),
            'updated_at' => now(),
            'update_id' => Auth::user()->id,
        ]);
        
        $model = Model::where('id', $verifikasi->surat_id)->first();
        $model->update(['is_view' => $model->is_view + 1]);
        
        $this->primaryId = $verifikasi->surat_id;
        $this->is_direct = $verifikasi->is_direct;
        $this->update_id = Auth::user()->id;
        $this->tgl_terima = Carbon::parse($model->tgl_terima)->locale('id')->isoFormat('LL');
        $this->tgl_surat = Carbon::parse($model->tgl_surat)->locale('id')->isoFormat('LL');
        $this->pembuat_surat_id = $model->pembuat_surat_id;
        $this->no_surat = $model->no_surat;
        $this->alamat_pengirim = $model->alamat;
        $this->perihal_surat = $model->perihal_surat;
        if($model->is_type==1){
            $this->tujuan_surat_id = $model->tujuan->jabatan;
        }else{
            $this->tujuan_surat_id = $model->tujuanEksternal->nama;
        }
        $this->no_arsip = $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat;
        $this->surat_masuk_id = $model->id;
        $this->surat_masuk_token = $model->token;
        // dd($model->token);
        $this->file_lampiran = $model->file_lampiran;
        $this->file_lampiran_url = $model->file_lampiran_url;
        $this->file_lampiran_size = $model->file_lampiran_size;
    }
    
    public function updated($property,$value)
    {
        if($this->jenis_surat_id!=''){
            $master_jenis_surat = RefJenisSurat::where('id',$this->jenis_surat_id)->first();
            $jenis_surat = $master_jenis_surat->kode;
        }else{
            $jenis_surat = "";
        }
        if($this->sifat_surat_id!=''){
            $master_sifat_surat = RefSifatSurat::where('id',$this->sifat_surat_id)->first();
            $sifat_surat = $master_sifat_surat->kode;
        }else{
            $sifat_surat = "";
        }
        if($this->unit_kerja_id!=''){
            list($unit_id, $unit_token) = explode(":", $this->unit_kerja_id);
            $master_unit_kerja = RefUnitKerja::where('token',$unit_token)->first();
            // dd($master_unit_kerja);
            $unit_kerja = $master_unit_kerja->kode;
        }else{
            $unit_kerja = "";
        }
        $this->no_surat = generateNomorSurat($this->tgl_surat,$jenis_surat,$sifat_surat,$unit_kerja,$this->sifat_surat_id);
        
    }
    
    
    public function updatedpPlihan($value)
    {
        $this->is_type = $value;
    }
    
    
}
