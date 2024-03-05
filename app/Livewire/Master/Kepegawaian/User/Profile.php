<?php

namespace App\Livewire\Master\Kepegawaian\User;

use Storage;
use App\Models\User;
use Livewire\Component;
use App\Models\RefEselon;
use App\Models\RefJabatan;
use App\Models\RefPangkat;
use App\Models\RefGolongan;
use App\Models\RefUnitKerja;
use Livewire\WithFileUploads;
use App\Models\RefSatuanKerja;
use App\Models\RefJenisKelamin;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;

class Profile extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    
    public $user_id;
    public $uuid;
    public $email;
    public $no_induk;
    public $nama;
    public $phone;
    public $jenis_kelamin;
    public $tanggal_lahir;
    
    public $golongan_id;
    public $golongan;
    public $pangkat_id;
    public $pangkat;
    public $eselon_id;
    public $eselon;
    public $jabatan_id;
    public $jabatan;
    public $satuan_kerja_id;
    public $satuan_kerja;
    public $unit_kerja_id;
    public $unit_kerja;
    
    public $alamat;
    public $avatar;
    public $is_active;
    public $avatar_url;
    public $avatar_size;
    public $avatar_path;
    public $avatar_human_size;
    
    public $jenis_kelamin_list;
    
    public $jabatan_pembantu_id;
    public $jabatan_pembantu;
    public $jabatan_pembantu_list;
    
    public function mount()
    {
        
        $this->jenis_kelamin_list   = RefJenisKelamin::where('is_active','=',1)->orderBy('jenis_kelamin','asc')->get();
        
        $data = User::where('id','=',Auth::user()->id)->first();
        // dd($data->jenis_kelamin);
        $this->uuid                = $data->id;
        $this->email               = $data->email;
        $this->no_induk            = $data->no_induk;
        $this->nama                = $data->nama;
        $this->phone               = $data->phone;
        $this->jenis_kelamin       = $data->jenis_kelamin;
        $this->tanggal_lahir       = $data->tanggal_lahir;
        
        // $this->golongan_id         = $data->golongan_id;
        // $this->golongan            = $data->golongan;
        // $this->pangkat_id          = $data->pangkat_id;
        // $this->pangkat             = $data->pangkat;
        // $this->eselon_id           = $data->eselon_id;
        // $this->eselon              = $data->eselon;
        
        $this->jabatan_id          = $data->jabatan_id;
        $this->jabatan             = $data->jabatan;
        $this->satuan_kerja_id     = $data->satuan_kerja_id;
        $this->satuan_kerja        = $data->satuan_kerja;
        $this->unit_kerja_id       = $data->unit_kerja_id;
        $this->unit_kerja          = $data->unit_kerja;
        
        $this->alamat              = $data->alamat;
        
        $this->jabatan_pembantu_id      = $data->jabatan_pembantu_id;
        $this->jabatan_pembantu          = $data->jabatan_pembantu;
    }
    
    protected $rules = [
        'email' => 'required',
        // 'no_induk' => 'required',
        'nama' => 'required',
        // 'phone' => 'required',
        // 'jenis_kelamin' => 'required',
        // 'tanggal_lahir' => 'required',
        // 'golongan_id' => 'required',
        // 'pangkat_id' => 'required',
        // 'eselon_id' => 'required',
        'jabatan_id' => 'required',
        'satuan_kerja_id' => 'required',
        'unit_kerja_id' => 'required',
        // 'alamat' => 'required',
    ];
    
    private function resetInput()
    {
        $this->email            = NULL;
        $this->no_induk         = NULL;
        $this->nama             = NULL;
        $this->phone            = NULL;
        $this->jenis_kelamin    = NULL;
        $this->tanggal_lahir    = NULL;
        
        $this->golongan_id      = NULL;
        $this->golongan         = NULL;
        $this->pangkat_id       = NULL;
        $this->pangkat          = NULL;
        $this->eselon_id        = NULL;
        $this->eselon           = NULL;
        $this->jabatan_id       = NULL;
        $this->jabatan          = NULL;
        $this->satuan_kerja_id  = NULL;
        $this->satuan_kerja     = NULL;
        $this->unit_kerja_id    = NULL;
        $this->unit_kerja       = NULL;
        
        $this->jabatan_pembantu_id      = NULL;
        $this->jabatan_pembatu   = NULL;
        
        $this->alamat           = NULL;
        
    }
    
    public function hydrate()
    {
        $this->dispatch('render-select2');
        // if(!empty($this->listSekolah)):
            //     $this->listSekolah = MSekolah::where('id','=',$this->sekolah_asal_id)->get();
            // endif;
        }
        
        public function cancel()
        {
            $this->mode = 'create';
            $this->resetInput();
        }
        
        public function update()
        {
            $this->validate();
            
            $model = User::firstOrNew(['id' =>  $this->uuid]);
            // $golongan_info        = RefGolongan::where('id','=',$this->golongan_id)->first();
            // $pangkat_info         = RefPangkat::where('id','=',$this->pangkat_id)->first();
            // $eselon_info          = RefEselon::where('id','=',$this->eselon_id)->first();
            
            $model->email               = $this->email;
            $model->no_induk            = $this->no_induk;
            $model->nama                = $this->nama;
            $model->phone               = $this->phone;
            $model->jenis_kelamin       = $this->jenis_kelamin;
            $model->tanggal_lahir       = $this->tanggal_lahir;
            
            // $model->golongan_id         = $this->golongan_id;
            // $model->golongan            = $golongan_info->golongan;
            // $model->pangkat_id          = $this->pangkat_id;
            // $model->pangkat             = $pangkat_info->pangkat;
            // $model->eselon_id           = $this->eselon_id;
            // $model->eselon              = $eselon_info->eselon;
            
            $model->alamat              = $this->alamat;
            $model->is_active           = 1;
            
            // if ($this->avatar) {
                //     $this->validate(['avatar' => 'required|image|mimes:jpeg,bmp,png,jpg,svg|max:2000']);
                //     $pathFolder = Storage::disk('public')->path('avatar');
                //     if (!file_exists($pathFolder)) {
                    //         Storage::disk('public')->makeDirectory('avatar');
                    //     }
                    //     $model->avatar = $this->avatar->getClientOriginalName();
                    //     $model->avatar_url = $this->avatar->store('avatar', 'public');
                    //     $model->avatar_size = $this->avatar->getSize();
                    //     $model->avatar_path = Storage::disk('public')->path($this->avatar->store('avatar', 'public'));
                    //     $model->avatar_human_size = humanFileSize($this->avatar->getSize());
                    // }
                    
                    
                    if($model->save()){
                        $this->resetInput();
                        setActivity('Pengguna '.$model->nama.' Merubah Akun');
                        
                        $log = 'Data Pengguna an.'.$model->nama.' Berhasil di Diubah';
                        setActivity($log);
                        notify()->success($log);
                        
                        if(Auth::user()->role_id==1){
                            return redirect()->route('account.profile');
                        }else{
                            return redirect()->route('account.profile');
                        }
                        
                    }else{
                        $log = 'Data Pengguna an.'.$model->nama.' Gagal di Diubah';
                        notify()->error($log);
                    }
                    
                }
                
                public function render()
                {
                    return view('livewire.master.kepegawaian.user.profile');
                }
            }
            