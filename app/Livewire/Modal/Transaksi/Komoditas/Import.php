<?php
namespace App\Livewire\Modal\Transaksi\Komoditas;
use App\Models\Transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefKomoditas;
use Illuminate\Support\Facades\Crypt;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class Import extends ModalComponent
{
    use LivewireAlert;

    public $id;
    public $listPasar;
    public $pasarId;
    public $listKomoditas=[];
    public $komoditasId;
    public $harga;
    public $created_at;
    public $created_id;
    public $updated_at;
    public $updated_id;
    public $deleted_at;
    public $deleted_id;
    public $komoditas_id;
    public $pasar_id;
    public $users_id;
    public $tanggal;
    public $harga_publish;
    public $harga_admin;
    public $harga_dinamik;
    public $kondisi;
    public $status;
    public $tanggal_update;
    public $harga_pasar;
    public $detail_tgl;
    public $nama_komoditas;
    public $nama_pasar;

    public $komoditas;

    use WithFileUploads;

    public $file;
    public $previewData = [];
    public $showPreview = false;
    public $importErrors = [];
    
    public function render()
    {
        return view('livewire.main.transaksi.komoditas.modal.import');
    }

    public function updatedFile()
{
    
    $this->validate([
        'file' => 'file|max:5120|mimes:xlsx,xls', // 5MB
    ]);
    // dd($this->file);
}


    
    public function mount()
    {
        if(Auth::user()->role_id == 5){
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->where('id',Auth::user()->pasar_id)->get();
        }else{
            $this->listPasar = RefPasar::orderBy('namapasar','asc')->get();
        }
        $this->pasarId = Auth::user()->pasar_id;
        $this->tanggal = date('Y-m-d H:i');
        // $this->listKomoditas = RefKomoditas::orderBy('namakomoditas','asc')->get();
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        // $this->komoditas = Model::where('pasar_id',$this->pasarId)->where('detail_tgl',$tanggalChange)->get();
        // $komoditasInserted = [];
        // foreach($this->komoditas as $value){
        //     array_push($komoditasInserted,$value->komoditas_id);
        // }
        // $this->listKomoditas = RefKomoditas::orderBy('namakomoditas','asc')
        // ->whereNotIn('id', $komoditasInserted)->get();

        
    }

    public function create()
    {
        set_time_limit(300); // Tambah waktu eksekusi menjadi 5 menit
        // Reset error sebelum proses baru
        $this->importErrors = [];
        // Validasi input yang diperlukan
        if (!$this->tanggal) {
            $this->alert('error', 'Tanggal penginputan harus dipilih', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        // Validasi file
        if (!$this->file) {
            $this->alert('error', 'File Excel harus diupload', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        // Validasi ekstensi file
        $extension = $this->file->getClientOriginalExtension();
        $allowedExtensions = ['xlsx', 'xls'];
        
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            $this->alert('error', 'File harus berformat .xlsx atau .xls', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        // Validasi ukuran file (maksimal 5MB)
        if ($this->file->getSize() > 5 * 1024 * 1024) {
            $this->alert('error', 'Ukuran file maksimal 5MB', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        // Daftar nama pasar sesuai urutan kolom di Excel
        $pasarNames = [
            'Pasar Baleendah',
            'Pasar Sehat Soreang',
            'Pasar Banjaran',
            'Pasar Ciwidey',
            'Pasar Cileunyi',
            'Pasar Margahayu',
            'Pasar Baru Majalaya',
            'Pasar Stasiun Majalaya',
            'Pasar Sehat Cicalengka'
        ];
        // Ambil ID pasar dari database berdasarkan nama
        $pasarMap = RefPasar::whereIn('namapasar', $pasarNames)->pluck('id', 'namapasar')->toArray();

        // --- OPTIMASI: Ambil semua data harga kemarin sekaligus ---
        $dt = new \Carbon\Carbon($this->tanggal);
        $tanggalChange = $dt->format('Y-m-d');
        $tanggalChangeTime = $dt->format('Y-m-d H:i:s');
        $tanggal_sebelum = date('Y-m-d', strtotime($tanggalChange . "-1 days"));
        dd($tanggal_sebelum);
        // Kumpulkan semua komoditas_id dan pasar_id yang akan diimport
        $semua_komoditas_id = [];
        $semua_pasar_id = array_values($pasarMap);
        // Ambil semua komoditas dari file excel
        try {
            $data = \Maatwebsite\Excel\Facades\Excel::toCollection(new class implements \Maatwebsite\Excel\Concerns\ToCollection {
                public function collection(\Illuminate\Support\Collection $collection)
                {
                    return $collection;
                }
            }, $this->file);
            if ($data->isEmpty() || $data->first()->isEmpty()) {
                $this->alert('error', 'File Excel kosong atau tidak valid', [
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return;
            }
            $rows = $data->first();
            $header = $rows->first();
            // Validasi header
            if (strtolower(trim($header[0])) !== 'nama komoditas') {
                $this->alert('error', 'Kolom pertama harus "nama komoditas"', [
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return;
            }
            for ($i = 1; $i < $rows->count(); $i++) {
                $row = $rows[$i];
                $namaKomoditas = trim($row[0] ?? '');
                if (empty($namaKomoditas)) continue;
                $komoditas = RefKomoditas::where('namakomoditas', 'like', '%' . $namaKomoditas . '%')->first();
                if ($komoditas) {
                    $semua_komoditas_id[] = $komoditas->id;
                }
            }
            $semua_komoditas_id = array_unique($semua_komoditas_id);
            // Ambil data harga kemarin sekaligus
            $harga_kemarin = Model::whereIn('komoditas_id', $semua_komoditas_id)
                ->whereIn('pasar_id', $semua_pasar_id)
                ->where('detail_tgl', $tanggal_sebelum)
                ->get()
                ->keyBy(function($item) {
                    return $item->komoditas_id . '-' . $item->pasar_id;
                });
            // Fungsi lokal optimal
            $hargaSelisihArr = function($komoditas_id, $pasar_id, $harga) use ($harga_kemarin) {
                $key = $komoditas_id . '-' . $pasar_id;
                if (!isset($harga_kemarin[$key])) return 0;
                $harga_kemarin_val = $harga_kemarin[$key]->harga_publish;
                return abs($harga - $harga_kemarin_val);
            };
            $statusDinamikaArr = function($komoditas_id, $pasar_id, $harga) use ($harga_kemarin) {
                $key = $komoditas_id . '-' . $pasar_id;
                if (!isset($harga_kemarin[$key])) return 'stabil';
                $harga_kemarin_val = $harga_kemarin[$key]->harga_publish;
                if ($harga > $harga_kemarin_val) return 'naik';
                if ($harga < $harga_kemarin_val) return 'turun';
                return 'stabil';
            };
            // --- END OPTIMASI ---
            $successCount = 0;
            $errorCount = 0;
            $errorMessages = [];
            // Proses setiap baris data (skip header)
            for ($i = 1; $i < $rows->count(); $i++) {
                $row = $rows[$i];
                $namaKomoditas = trim($row[0] ?? '');
                if (empty($namaKomoditas)) continue;
                // Cari komoditas
                $komoditas = RefKomoditas::where('namakomoditas', 'like', '%' . $namaKomoditas . '%')->first();
                if (!$komoditas) {
                    $errorCount++;
                    $errorMessages[] = "Komoditas '$namaKomoditas' tidak ditemukan";
                    continue;
                }
                // Kumpulkan data untuk bulk insert per komoditas
                $bulkInsert = [];
                foreach ($pasarNames as $idx => $pasarName) {
                    $harga = isset($row[$idx+1]) ? trim($row[$idx+1]) : null;
                    if ($harga === null || $harga === '' || !is_numeric($harga) || $harga <= 0) continue;
                    $pasarId = $pasarMap[$pasarName] ?? null;
                    if (!$pasarId) {
                        $errorCount++;
                        $errorMessages[] = "Pasar '$pasarName' tidak ditemukan di database";
                        continue;
                    }
                    // OPTIMASI: gunakan array harga kemarin
                    $selisih_harga = $hargaSelisihArr($komoditas->id, $pasarId, $harga);
                    $kondisi = $statusDinamikaArr($komoditas->id, $pasarId, $harga);
                    $bulkInsert[] = [
                        'token' => Uuid::uuid4()->toString(),
                        'komoditas_id' => $komoditas->id,
                        'pasar_id' => $pasarId,
                        'users_id' => \Auth::user()->id,
                        'tanggal' => $tanggalChangeTime,
                        'harga_publish' => $harga,
                        'harga_dinamik' => $selisih_harga,
                        'kondisi' => $kondisi,
                        'status' => 'harga pasar',
                        'harga_pasar' => $harga,
                        'detail_tgl' => $tanggalChange,
                        'nama_komoditas' => $komoditas->namakomoditas,
                        'nama_pasar' => $pasarName,
                        'created_id' => \Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }
                // Bulk insert sekaligus untuk semua pasar pada komoditas ini
                if (!empty($bulkInsert)) {
                    try {
                        Model::insert($bulkInsert);
                        $successCount += count($bulkInsert);
                    } catch (\Exception $e) {
                        $errorCount += count($bulkInsert);
                        $errorMessages[] = "Gagal menyimpan data untuk komoditas '$namaKomoditas': " . $e->getMessage();
                    }
                }
            }


            // Tampilkan hasil
            if ($successCount > 0) {
                $this->alert('success', "Berhasil mengimport $successCount data komoditas", [
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
            }
            if ($errorCount > 0) {
                $this->importErrors = $errorMessages;
                $this->alert('warning', "Gagal mengimport $errorCount data. Silakan cek daftar error di bawah.", [
                    'timer' => 5000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
            }
            if ($errorCount <= 0) {
                $this->importErrors = [];
                return redirect()->route('main.komoditas');
            }
        } catch (\Exception $e) {
            $this->alert('error', 'Terjadi kesalahan saat membaca file Excel: ' . $e->getMessage(), [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
    }
    
    // public function updatedpasarId(){
    //     $dt = new \Carbon\Carbon($this->tanggal);
    //     $tanggalChange = $dt->format('Y-m-d');
    //     $this->komoditas = Model::where('pasar_id',$this->pasarId)->where('detail_tgl',$tanggalChange)->get();
    //     $komoditasInserted = [];
    //     foreach($this->komoditas as $value){
    //         array_push($komoditasInserted,$value->komoditas_id);
    //     }
    //     $this->listKomoditas = RefKomoditas::orderBy('namakomoditas','asc')
    //     ->whereNotIn('id', $komoditasInserted)->get();
    // }

    public static function destroyOnClose(): bool
    {
        return true;
    }

    public static function closeModalOnClickAway(): bool
{
    return false;
}

    public function previewFile()
    {
        // Validasi input yang diperlukan
        if (!$this->tanggal) {
            $this->alert('error', 'Tanggal penginputan harus dipilih terlebih dahulu', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        if (!$this->file) {
            $this->alert('error', 'File Excel harus diupload terlebih dahulu', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        // Daftar nama pasar sesuai urutan kolom di Excel
        $pasarNames = [
            'Pasar Baleendah',
            'Pasar Sehat Soreang',
            'Pasar Banjaran',
            'Pasar Ciwidey',
            'Pasar Cileunyi',
            'Pasar Margahayu',
            'Pasar Baru Majalaya',
            'Pasar Stasiun Majalaya',
            'Pasar Sehat Cicalengka'
        ];
        // Ambil ID pasar dari database berdasarkan nama
        $pasarMap = RefPasar::whereIn('namapasar', $pasarNames)->pluck('id', 'namapasar')->toArray();

        try {
            // Baca file Excel untuk preview
            $data = Excel::toCollection(new class implements \Maatwebsite\Excel\Concerns\ToCollection {
                public function collection(Collection $collection)
                {
                    return $collection;
                }
            }, $this->file);

            if ($data->isEmpty() || $data->first()->isEmpty()) {
                $this->alert('error', 'File Excel kosong atau tidak valid', [
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return;
            }

            $rows = $data->first();
            $header = $rows->first();

            // Validasi header
            if (strtolower(trim($header[0])) !== 'nama komoditas') {
                $this->alert('error', 'Kolom pertama harus "nama komoditas"', [
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);
                return;
            }
            for ($i = 0; $i < count($pasarNames); $i++) {
                if (!isset($header[$i+1]) || trim($header[$i+1]) !== $pasarNames[$i]) {
                    $this->alert('error', 'Kolom ke-'.($i+2).' harus "'.$pasarNames[$i].'"', [
                        'timer' => 3000,
                        'toast' => true,
                        'timerProgressBar' => true,
                    ]);
                    return;
                }
            }

            $previewData = [];
            $maxPreviewRows = $rows->count() - 1;
            for ($i = 1; $i <= $maxPreviewRows; $i++) {
                $row = $rows[$i];
                $namaKomoditas = trim($row[0] ?? '');
                if (empty($namaKomoditas)) continue;
                $komoditas = RefKomoditas::where('namakomoditas', 'like', '%' . $namaKomoditas . '%')->first();
                $perPasar = [];
                foreach ($pasarNames as $idx => $pasarName) {
                    $harga = isset($row[$idx+1]) ? trim($row[$idx+1]) : null;
                    $isValid = is_numeric($harga) && $harga > 0;
                    $pasarFound = isset($pasarMap[$pasarName]);
                    $perPasar[] = [
                        'pasar' => $pasarName,
                        'harga' => $harga,
                        'is_valid' => $isValid,
                        'pasar_found' => $pasarFound
                    ];
                }
                $previewData[] = [
                    'nama_komoditas' => $namaKomoditas,
                    'komoditas_found' => $komoditas ? true : false,
                    'komoditas_name' => $komoditas ? $komoditas->namakomoditas : 'Tidak ditemukan',
                    'per_pasar' => $perPasar
                ];
            }
            $this->previewData = $previewData;
            $this->showPreview = true;
        } catch (\Exception $e) {
            $this->alert('error', 'Terjadi kesalahan saat membaca file Excel: ' . $e->getMessage(), [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }
    }

    public function hidePreview()
    {
        $this->showPreview = false;
        $this->previewData = [];
        $this->importErrors = [];
    }
}

