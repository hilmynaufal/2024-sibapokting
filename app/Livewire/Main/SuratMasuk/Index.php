<?php
namespace App\Livewire\Main\SuratMasuk;
use Livewire\Component;
use App\Models\SuratMasuk as Model;
use App\Models\Lampiran;
use App\Models\Verifikasi;
use App\Models\Disposisi;
use App\Models\DisposisiMasuk;
use App\Models\User;
use App\Models\RefJabatan;
use App\Models\RefJenisDisposisi;
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

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;
    
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['store' => 'render','delete', 'confirmed','confirmedLampiran','confirmedDeleted'];
    public $search = '';
    public $showForm;
    
    public $create_id;
    public $update_id;
    
    #[Rule('required|min:5')]
    public $tgl_terima;
    public $tgl_surat;
    
    public $is_direct;
    public $pembuat_surat_id;
    public $satuan_kerja_id;
    public $no_surat;
    public $alamat_pengirim;
    public $perihal_surat;
    public $sekretaris_surat_id;
    public $tujuan_surat_id;
    public $tujuan_surat_token;
    public $no_arsip;
    public $isi_surat;
    public $keterangan_surat;
    public $pengirim_surat;
    public $unit_kerja_list;
    public $sekretaris_list;
    public $struktural_list;
    public $jenis_disposisi_list;
    
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
    
    // DISPOSISI
    public $disposisi_id;
    public $disposisi_at;
    public $disposisi_tujuan;
    public $disposisi_instruksi;
    public $disposisi_batas_waktu;
    public $disposisi_catatan;
    public $disposisi_tipe;
    
    public $mode = 'create';
    public $perpage = 10;
    public $total;
    public $sortColoumName = "created_at";
    public $sortDirection = "desc";
    protected $queryString = ['search'];
    
    public function getListeners()
    {
        return [
            'confirmedLampiran','confirmedDeleted',
        ];
    }
    
    
    public function mount()
    {
        $this->total = Model::where('is_active',1)->count();
        $this->jenis_disposisi_list   = RefJenisDisposisi::where('is_active','=',1)->where('is_delete','=',0)->orderBy('nama','asc')->get();    
        
        $this->sekretaris_list = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.no_induk as pegawai_no_induk', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)
        ->where('b.is_delete','=',0)
        ->where('b.status_tujuan',1)
        ->whereIn('b.kode',['SP','S','SDK'])
        ->orderBy('b.jabatan','asc')
        ->get();
        
        $this->unit_kerja_list = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.no_induk as pegawai_no_induk', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)
        ->where('b.status_tujuan',1)->orderBy('b.jabatan','asc')
        ->get();
        
        $this->struktural_list = DB::table('ref_users as a')
        ->select('a.id as pegawai_id', 'a.no_induk as pegawai_no_induk', 'a.token as pegawai_id_token', 'a.nama as pegawai_nama', 'b.token as jabatan_id_token', 'b.jabatan as jabatan_nama', 'b.kode as jabatan_kode')
        ->leftJoin('ref_jabatan as b', 'a.jabatan_id', '=', 'b.token')
        ->where('b.is_active','=',1)->where('b.is_delete','=',0)
        ->where('b.status_jabatan',1)->orderBy('b.jabatan','asc')
        ->get();
    }
    
    protected $rules = [
        'tgl_terima' => 'required|date',
        'tgl_surat' => 'required|date',
        'no_surat' => 'required',
        'perihal_surat' => 'required',
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
            return view('livewire.main.surat-masuk.index-admin', [ 'model' => $model ]);
        }elseif(Auth::user()->role_id==6 || Auth::user()->role_id==7){
            $model = DB::table('t_surat_masuk')
            ->select('t_surat_masuk.*', 't_verifikasi.jabatan_penerima_token', 't_verifikasi.id as verifikasi_id','t_verifikasi.is_read as verifikasi_is_read')
            ->leftJoin('t_verifikasi', 't_surat_masuk.id', '=', 't_verifikasi.surat_id')
            ->where('t_surat_masuk.pembuat_surat_id', Auth::user()->id)
            ->where('t_verifikasi.jabatan_penerima_token', getJabatan())
            ->where('t_surat_masuk.satuan_kerja_token', Auth::user()->satuan_kerja_id)
            ->where('t_surat_masuk.is_delete', 0)
            ->where('t_verifikasi.tipe', 1)
            ->where(DB::raw('LOWER(t_surat_masuk.perihal_surat)'), 'LIKE', '%' . strtolower($this->search) . '%')
            ->orderBy($this->sortColoumName, $this->sortDirection)
            ->paginate($this->perpage);
            return view('livewire.main.surat-masuk.index', [ 'model' => $model ]);
        }else{
            $model = DB::table('t_surat_masuk')
            ->select('t_surat_masuk.*', 't_verifikasi.jabatan_penerima_token', 't_verifikasi.id as verifikasi_id','t_verifikasi.is_read as verifikasi_is_read')
            ->leftJoin('t_verifikasi', 't_surat_masuk.id', '=', 't_verifikasi.surat_id')
            ->where('t_verifikasi.jabatan_penerima_token', getJabatan())
            ->where('t_surat_masuk.satuan_kerja_token', Auth::user()->satuan_kerja_id)
            ->where('t_surat_masuk.is_delete', 0)
            ->where('t_verifikasi.tipe', 1)
            ->where(DB::raw('LOWER(t_surat_masuk.perihal_surat)'), 'LIKE', '%' . strtolower($this->search) . '%')
            ->orderBy($this->sortColoumName, $this->sortDirection)
            ->paginate($this->perpage);
            return view('livewire.main.surat-masuk.index-verifikasi', [ 'model' => $model ]);
        }
        setActivity('Pengguna Mengakses Menu Surat Masuk');
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
        $this->sekretaris_surat_id = NULL;
        $this->tujuan_surat_id = NULL;
        $this->no_arsip = NULL;
        $this->isi_surat = NULL;
        $this->keterangan_surat = NULL;
        $this->pengirim_surat = NULL;
        $this->file_lampiran = NULL;
        $this->file_lampiran_url = NULL;
        $this->file_lampiran_size = NULL;
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
    }
    
    public function store()
    {
        // dd($this);
        $this->validate();
        $model = Model::firstOrNew(['id' =>  $this->surat_masuk_id]);
        $model->id = Model::max('id') + 1;   
        $model->create_id = Auth::user()->id;
        $model->tgl_terima = $this->tgl_terima;
        $model->tgl_surat = $this->tgl_surat;
        
        $model->pembuat_surat_id = Auth::user()->id;
        $model->pembuat_surat_token = Auth::user()->jabatan_id;
        $model->satuan_kerja_token = Auth::user()->satuan_kerja_id;
        
        // $sekretaris = User::where('id',$this->sekretaris_surat_id)->first();
        $sekretaris = User::where('id',4)->first();
        $model->sekretaris_surat_id = $sekretaris->id;
        $model->sekretaris_surat_token = $sekretaris->jabatan_id;
        
        $tujuan = User::where('id',$this->tujuan_surat_id)->first();
        $model->tujuan_surat_id = $tujuan->id;
        $model->tujuan_surat_token = $tujuan->jabatan_id;
        
        $model->no_arsip = $this->no_arsip == NULL ? generateArsipMasukNumber($tujuan->id) : $this->no_arsip;
        $model->no_surat = $this->no_surat;
        $model->alamat = $this->alamat_pengirim;
        $model->perihal_surat = $this->perihal_surat;
        $model->isi_surat = $this->isi_surat;
        $model->keterangan_surat = $this->keterangan_surat;
        $model->pengirim_surat = $this->pengirim_surat; 
        $model->is_active       = 1;
        $model->is_delete       = 0;
        $model->is_read         = 0;
        
        if($model->save()){
            
            $surat_masuk = Model::where('token',$model->token)->first();
            if (!empty($this->file_lampiran)) {
                $this->validate(['file_lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,docx|max:10000']);
                $tgl_masuk = Carbon::parse($model->tgl_terima);
                $year = $tgl_masuk->year;
                $month = $tgl_masuk->month;
                $day = $tgl_masuk->day;
                $folderPath = "uploads/surat_masuk/{$year}/{$month}{$day}"; 
                if (!file_exists(Storage::disk('public')->path($folderPath))) {
                    Storage::disk('public')->makeDirectory($folderPath, 0755, true);
                }
                foreach ($this->file_lampiran as $file) {
                    $surat_masuk->file_lampiran = $file->getClientOriginalName();
                    $surat_masuk->file_lampiran_url = $file->store($folderPath, 'public');
                    $surat_masuk->file_lampiran_size = $file->getSize();
                    $surat_masuk->update();
                    Lampiran::create([
                        'create_id' => Auth::user()->id,
                        'file_lampiran_ekstensi' => $file->getExtension(),
                        'file_lampiran' => $file->getClientOriginalName(),
                        'file_lampiran_url' => $file->store($folderPath, 'public'),
                        'file_lampiran_size' => $file->getSize(),
                        'surat_id' => $model->id,
                        'surat_id_token' => $model->token,
                        'tipe' => 1,
                    ]);
                    setActivity('Add Lampiran: '.$file->getClientOriginalName().' pada '.$model->perihal_surat.' - ID# '.$model->id);
                }
                
            }            
            
            // $pengirim_user_id,$surat_id_token,$jabatan_id_token,$deskripsi,$status
            setVerifikasi($model->create_id,$model->token,$model->pembuat_surat_id,$model->pembuat_surat_token,"Entry Surat Masuk",0,1);
            setVerifikasi($model->create_id,$model->token,$model->sekretaris_surat_id,$model->sekretaris_surat_token,"CC Surat Masuk ke Sekretaris Perusahaan",0,1);
            setVerifikasi($model->create_id,$model->token,$model->tujuan_surat_id,$model->tujuan_surat_token,"Tujuan Penerima Surat Masuk",1,1);
            
            $this->resetInput();
            $mode = 'view';
            setActivity('Tambah Surat Masuk: '.$model->perihal_surat.' - ID# '.$model->id);
            return $this->alert('success', 'Surat Masuk Berhasil di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Surat Masuk Gagal di Simpan', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
        
    }
    
    public function edit($primaryId)
    {
        // dd($this->sekretaris_surat_id);
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
        $this->sekretaris_surat_id = $model->sekretaris_surat_id;
        $this->tujuan_surat_id = $model->tujuan_surat_id;
        $this->no_arsip = $model->no_arsip == NULL ? generateArsipMasukNumber($model->tujuan_surat_id) : $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat; 
        $this->surat_masuk_id     = $model->id;
        
        
    }
    
    public function update()
    {
        // dd($this->surat_masuk_id);
        $this->validate();
        // $model = Model::firstOrNew(['id' =>  $this->surat_masuk_id]);
        $model = Model::where('id',$this->surat_masuk_id)->first();
        // dd($model->token);
        $model->create_id = Auth::user()->id;
        $model->tgl_terima = $this->tgl_terima;
        $model->tgl_surat = $this->tgl_surat;
        $model->pembuat_surat_id = $this->pembuat_surat_id;
        $model->no_surat = $this->no_surat;
        $model->alamat = $this->alamat_pengirim;
        $model->perihal_surat = $this->perihal_surat;
        $model->sekretaris_surat_id = $this->sekretaris_surat_id;
        $model->tujuan_surat_id = $this->tujuan_surat_id;
        $model->no_arsip = $this->no_arsip;
        $model->isi_surat = $this->isi_surat;
        $model->keterangan_surat = $this->keterangan_surat;
        $model->pengirim_surat = $this->pengirim_surat;
        $model->is_active   = 1;
        $model->is_delete   = 0;
        $model->is_read     = 0;
        $model->update_id   = Auth::user()->id;
        
        if (!empty($this->file_lampiran)) {
            $this->validate(['file_lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,docx|max:10000']);
            $tgl_masuk = Carbon::parse($model->tgl_terima);
            $year = $tgl_masuk->year;
            $month = $tgl_masuk->month;
            $day = $tgl_masuk->day;
            $folderPath = "uploads/surat_masuk/{$year}/{$month}{$day}"; 
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
                    'tipe' => 1,
                ]);
                setActivity('Ubah Lampiran: '.$file->getClientOriginalName().' pada '.$model->perihal_surat.' - ID# '.$model->id);
            }
        }
        if($model->update()){
            
            // SET KE TIMELINE
            setVerifikasi($model->create_id,$model->token,$model->pembuat_surat_id,$model->pembuat_surat_token,"Entry Surat Masuk",0,1);
            setVerifikasi($model->create_id,$model->token,$model->sekretaris_surat_id,$model->sekretaris_surat_token,"CC Surat Masuk ke Sekretaris Perusahaan",0,1);
            setVerifikasi($model->create_id,$model->token,$model->tujuan_surat_id,$model->tujuan_surat_token,"Tujuan Penerima Surat Masuk",1,1);
            $this->mode = "view";
            setActivity('Ubah Surat Masuk: '.$model->perihal_surat.' - ID# '.$model->id);
            $this->resetInput();
            $this->alert('success', 'Surat Masuk Berhasil di Ubah', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Surat Masuk Gagal di Ubah', [
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
        $this->surat_masuk_id = $data->token;
        return $this->alert('question', 'Apakah Anda Yakin Akan Menghapus Surat Masuk ? '.$data->perihal_surat.'', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Hapus',
            'showCancelButton' => true,
            'cancelButtonText' => 'Batal',
            'onConfirmed' => 'confirmedDeleted',
            'toast' => false,
            'position' => 'center',
            'timer' => false
        ]);
    }
    
    public function confirmedDeleted()
    {
        // dd($this);
        $model = Model::where('token',$this->surat_masuk_id)->first();
        $model_verifikasi = Verifikasi::where('surat_id_token',$model->token)->delete();
        if($model->delete()){
            $this->resetInput();
            setActivity('Hapus Surat Masuk: '.$model->perihal_surat.' - ID# '.$model->id);
            return $this->alert('success', 'Surat Masuk Berhasil di Hapus', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }else{
            return $this->alert('error', 'Surat Masuk Gagal di Hapus', [
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
        return $this->alert('success', 'Status Surat Masuk '.$model->perihal_surat.' '.$infoStatus, [
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
        $this->tujuan_surat_id = $model->tujuan->jabatan;
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
        $this->resetInput();
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
        // dd($model);
        $model->update(['is_view' => $model->is_view + 1]);
        $this->is_direct = $verifikasi->is_direct;
        $this->primaryId = $verifikasi->surat_id;
        $this->update_id = Auth::user()->id;
        $this->tgl_terima = Carbon::parse($model->tgl_terima)->locale('id')->isoFormat('LL');
        $this->tgl_surat = Carbon::parse($model->tgl_surat)->locale('id')->isoFormat('LL');
        $this->pembuat_surat_id = $model->pembuat_surat_id;
        $this->no_surat = $model->no_surat;
        $this->alamat_pengirim = $model->alamat;
        $this->perihal_surat = $model->perihal_surat;
        $this->tujuan_surat_id = $model->tujuan->jabatan;
        $this->tujuan_surat_token = $model->tujuan->token;
        $this->no_arsip = $model->no_arsip;
        $this->isi_surat = $model->isi_surat;
        $this->keterangan_surat = $model->keterangan_surat;
        $this->pengirim_surat = $model->pengirim_surat;
        $this->surat_masuk_id = $model->id;
        $this->surat_masuk_token = $model->token;
        $this->file_lampiran = $model->file_lampiran;
        $this->file_lampiran_url = $model->file_lampiran_url;
        $this->file_lampiran_size = $model->file_lampiran_size;
        $this->isOpen = true;
        $this->mode = 'view';
    }
    
    public function deleteConfirmLampiran($id)
    {
        $data = Lampiran::where('id_lampiran',$id)->first();
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
        $lampiran = Lampiran::where('id_lampiran',$this->deleteLampiran_id)->first();
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
