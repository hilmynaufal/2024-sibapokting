<?php
namespace App\Livewire\Main;

use App\Models\Transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;

class KomoditasAddBulk extends Component
{
    use LivewireAlert;

    public $listPasar;
    public $pasarId;
    public $tanggal;
    public $listKomoditas = [];
    public $rows = [];
    public $komoditas;
    
    #[Layout('components.layouts.keenthemes.page')]
    public function render()
    {
        return view('livewire.main.transaksi.komoditas.add-bulk');
    }
    
    public function mount()
    {
        if(Auth::user()->role_id == 5){
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->where('id',Auth::user()->pasar_id)->get();
        }else{
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->get();
        }
        $this->pasarId = Auth::user()->pasar_id;
        $this->tanggal = date('Y-m-d\TH:i');
        
        $this->loadKomoditas();
    }

    public function loadKomoditas()
    {
        if(empty($this->pasarId) || empty($this->tanggal)) {
            $this->rows = [];
            return;
        }

        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        
        // Cek komoditas yang sudah diinput pada tanggal dan pasar ini
        $this->komoditas = Model::where('pasar_id', $this->pasarId)->where('detail_tgl', $tanggalChange)->get();
        $komoditasInserted = [];
        foreach($this->komoditas as $value){
            array_push($komoditasInserted, $value->komoditas_id);
        }
        
        // Ambil komoditas yang belum diinput
        $this->listKomoditas = RefKomoditas::orderBy('namakomoditas', 'asc')
            ->whereNotIn('id', $komoditasInserted)->get();

        $kemarin = \Carbon\Carbon::parse($tanggalChange)->subDay()->format('Y-m-d');
        
        $listKomoditasIds = $this->listKomoditas->pluck('id')->toArray();
        $hargaKemarinRecords = Model::whereIn('komoditas_id', $listKomoditasIds)
                                ->where('pasar_id', $this->pasarId)
                                ->where('detail_tgl', $kemarin)
                                ->get()
                                ->keyBy('komoditas_id');

        // Inisialisasi rows berdasarkan list komoditas
        $this->rows = [];
        foreach($this->listKomoditas as $komoditas) {
            $hargaKemarinRecord = isset($hargaKemarinRecords[$komoditas->id]) ? $hargaKemarinRecords[$komoditas->id] : null;
            $hargaKemarin = $hargaKemarinRecord ? $hargaKemarinRecord->harga_publish : 0;

            $this->rows[$komoditas->id] = [
                'id' => $komoditas->id,
                'nama' => $komoditas->namakomoditas,
                'gambar' => $komoditas->foto ?? '', // Asumsi ada field foto/gambar, kalau tidak bisa diatur di view
                'satuan' => $komoditas->toSatuan->satuan ?? '',
                'hargaKemarin' => $hargaKemarin,
                'harga' => ''
            ];
        }
    }

    public function updatedPasarId()
    {
        $this->loadKomoditas();
    }
    
    public function updatedTanggal()
    {
        $this->loadKomoditas();
    }

    public function create()
    {
        $this->validate([
            'pasarId' => 'required',
            'tanggal' => 'required',
        ]);

        if (Auth::user()->role_id == 5 && Auth::user()->pasar_id != $this->pasarId) {
            abort(403, 'Anda tidak memiliki akses untuk menambah harga komoditas di pasar ini.');
        }

        $pasar = RefPasar::where('id', $this->pasarId)->first();
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $tanggalChangeTime = $dt->format('Y-m-d H:i:s');
        
        $successCount = 0;
        
        $komoditasIds = array_keys($this->rows);
        $komoditasList = RefKomoditas::whereIn('id', $komoditasIds)->get()->keyBy('id');
        
        foreach ($this->rows as $komoditasId => $row) {
            $harga = $row['harga'];
            
            // Hanya simpan jika harga diisi
            if (empty($harga) || $harga <= 0) {
                continue;
            }

            $selisih_harga  = hargaSelisih($komoditasId, $this->pasarId, $harga, $this->tanggal);
            $kondisi        = statusDinamika($komoditasId, $this->pasarId, $harga, $this->tanggal);
            $komoditas = isset($komoditasList[$komoditasId]) ? $komoditasList[$komoditasId] : null;

            $model = Model::create([
                'komoditas_id' => $komoditasId,
                'pasar_id' => $this->pasarId,
                'users_id' => Auth::user()->id,
                'tanggal' => $tanggalChangeTime,
                'harga_publish' => $harga,
                'harga_dinamik' => $selisih_harga,
                'kondisi' => $kondisi,
                'status' => 'harga pasar',
                'harga_pasar' => $harga,
                'detail_tgl' => $tanggalChange,
                'nama_komoditas' => $komoditas ? $komoditas->namakomoditas : '',
                'nama_pasar' => $pasar->namapasar,
                'created_id' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            
            if ($model) {
                $successCount++;
            }
        }

        if ($successCount > 0) {
            $this->alert('success', "Berhasil menyimpan $successCount data komoditas", [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return redirect()->route('main.komoditas');
        } else {
            // $this->alert('warning', 'Tidak ada data harga yang disimpan (pastikan mengisi harga yang valid)', [
            //     'timer' => 3000,
            //     'toast' => true,
            //     'timerProgressBar' => true,
            // ]);
            return redirect()->route('main.komoditas');
        }
    }
}
