<?php
namespace App\Livewire\Modal\Transaksi\Komoditas;

use App\Models\Transaksi\Komoditas as Model;
use App\Models\Referensi\RefPasar;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FetchData extends ModalComponent
{
    use LivewireAlert;

    public $tanggal_asal;
    public $tanggal_tujuan;
    public $pasar_id = '';
    public $listPasar = [];
    public $previewData = [];
    public $showPreview = false;
    public $totalWillCopy = 0;
    public $totalSkipped = 0;

    protected $rules = [
        'tanggal_asal' => 'required|date',
        'tanggal_tujuan' => 'required|date',
    ];

    public function mount()
    {
        // Load list pasar berdasarkan role
        if (Auth::user()->role_id == 5) {
            $this->listPasar = RefPasar::orderBy('namapasar', 'asc')
                ->where('id', Auth::user()->pasar_id)
                ->get();
            $this->pasar_id = Auth::user()->pasar_id;
        } else {
            $this->listPasar = RefPasar::orderBy('namapasar', 'asc')->get();
        }

        // Set default tanggal
        $this->tanggal_asal = date('Y-m-d', strtotime('-1 day'));
        $this->tanggal_tujuan = date('Y-m-d');
    }

    public function loadPreview()
    {
        $this->validate();

        // Reset preview data
        $this->previewData = [];
        $this->totalWillCopy = 0;
        $this->totalSkipped = 0;

        // Build query untuk data asal
        $query = Model::where('detail_tgl', $this->tanggal_asal);

        // Filter berdasarkan pasar jika dipilih
        if ($this->pasar_id != '') {
            $query->where('pasar_id', $this->pasar_id);
        }

        $dataAsal = $query->get();

        if ($dataAsal->isEmpty()) {
            $this->alert('warning', 'Tidak ada data komoditas dari tanggal ' . tglIndo($this->tanggal_asal), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        // Loop data asal dan cek duplikat
        foreach ($dataAsal as $data) {
            // Cek apakah sudah ada di tanggal tujuan
            $exists = Model::where('pasar_id', $data->pasar_id)
                ->where('komoditas_id', $data->komoditas_id)
                ->where('detail_tgl', $this->tanggal_tujuan)
                ->exists();

            if ($exists) {
                // Sudah ada, akan di-skip
                $this->previewData[] = [
                    'komoditas_id' => $data->komoditas_id,
                    'pasar_id' => $data->pasar_id,
                    'nama_pasar' => $data->nama_pasar,
                    'nama_komoditas' => $data->nama_komoditas,
                    'harga_publish' => $data->harga_publish,
                    'status' => 'skip',
                ];
                $this->totalSkipped++;
            } else {
                // Belum ada, akan disalin
                $this->previewData[] = [
                    'komoditas_id' => $data->komoditas_id,
                    'pasar_id' => $data->pasar_id,
                    'nama_pasar' => $data->nama_pasar,
                    'nama_komoditas' => $data->nama_komoditas,
                    'harga_publish' => $data->harga_publish,
                    'users_id' => $data->users_id,
                    'status' => 'copy',
                ];
                $this->totalWillCopy++;
            }
        }

        $this->showPreview = true;
    }

    public function resetPreview()
    {
        $this->showPreview = false;
        $this->previewData = [];
        $this->totalWillCopy = 0;
        $this->totalSkipped = 0;
    }

    public function copyData()
    {
        // Validasi preview data tidak kosong
        if (empty($this->previewData) || $this->totalWillCopy == 0) {
            $this->alert('error', 'Tidak ada data yang bisa disalin', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        try {
            DB::beginTransaction();

            $copied = 0;

            // Filter hanya data yang akan disalin
            $dataToCopy = collect($this->previewData)->where('status', 'copy');

            foreach ($dataToCopy as $data) {
                // Get nama pasar
                $pasar = RefPasar::find($data['pasar_id']);
                $nama_pasar = $pasar ? $pasar->namapasar : $data['nama_pasar'];

                // Hitung harga_dinamik dan kondisi
                $selisih_harga = hargaSelisih(
                    $data['komoditas_id'],
                    $data['pasar_id'],
                    $data['harga_publish'],
                    $this->tanggal_tujuan
                );

                $kondisi = statusDinamika(
                    $data['komoditas_id'],
                    $data['pasar_id'],
                    $data['harga_publish'],
                    $this->tanggal_tujuan
                );

                // Create record baru
                Model::create([
                    'komoditas_id' => $data['komoditas_id'],
                    'pasar_id' => $data['pasar_id'],
                    'users_id' => Auth::user()->id,
                    'tanggal' => $this->tanggal_tujuan . ' ' . date('H:i:s'),
                    'detail_tgl' => $this->tanggal_tujuan,
                    'harga_publish' => $data['harga_publish'],
                    'harga_pasar' => $data['harga_publish'],
                    'harga_dinamik' => $selisih_harga,
                    'kondisi' => $kondisi,
                    'status' => 'harga pasar',
                    'nama_komoditas' => $data['nama_komoditas'],
                    'nama_pasar' => $nama_pasar,
                    'created_id' => Auth::user()->id,
                    'created_at' => now(),
                ]);

                $copied++;
            }

            DB::commit();

            // Log activity
            $log = "Ambil {$copied} data komoditas dari " . tglIndo($this->tanggal_asal) . " ke " . tglIndo($this->tanggal_tujuan);
            setActivity($log);

            // Alert success
            $this->alert('success', $log . ' berhasil!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);

            // Redirect untuk refresh halaman
            return redirect()->route('main.komoditas');

        } catch (\Exception $e) {
            DB::rollBack();

            $this->alert('error', 'Gagal menyalin data: ' . $e->getMessage(), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.main.transaksi.komoditas.modal.fetch-data');
    }

    public static function destroyOnClose(): bool
    {
        return true;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
}
