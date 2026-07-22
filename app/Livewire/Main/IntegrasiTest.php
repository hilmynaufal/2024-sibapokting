<?php
namespace App\Livewire\Main;

use Livewire\Component;
use App\Models\RefSilinda as Model;
use App\Models\Transaksi\Komoditas;
use App\Models\Referensi\RefPasar;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;

class IntegrasiTest extends Component
{
    use LivewireAlert;

    // Data model aktif
    public $config;
    
    // Step 1: Database Status
    public $step1 = [
        'status' => 'idle', // success, error
        'message' => '',
        'data' => []
    ];

    // Step 2: Token SPLP
    public $step2 = [
        'status' => 'idle',
        'url' => '',
        'headers' => [],
        'payload' => '',
        'raw_response' => '',
        'parsed_token' => '',
        'error' => ''
    ];

    // Step 3: Read API
    public $selectedPasarRead;
    public $step3 = [
        'status' => 'idle',
        'url' => '',
        'headers' => [],
        'payload' => '',
        'raw_response' => '',
        'error' => ''
    ];

    // Step 4: Write/Sync API
    public $selectedPasarWrite;
    public $selectedKomoditasWrite;
    public $availableKomoditas = [];
    public $step4 = [
        'status' => 'idle',
        'logs' => [] // array of ['commodity' => '', 'payload' => '', 'response' => '', 'status' => '']
    ];

    #[Layout('components.layouts.keenthemes.page')]
    public function mount()
    {
        $this->checkDatabaseConfig();
    }

    public function render()
    {
        $pasarInt = RefPasar::where('status_integrasi', 1)->get();
        return view('livewire.main.integrasi.test', [
            'pasarList' => $pasarInt
        ]);
    }

    // Step 1: Ambil konfigurasi database
    public function checkDatabaseConfig()
    {
        $model = Model::where('is_active', '=', 1)->first();
        if ($model) {
            $this->config = $model;
            $this->step1 = [
                'status' => 'success',
                'message' => 'Konfigurasi SILINDA aktif ditemukan di database.',
                'data' => [
                    'id' => $model->id,
                    'credentialId' => $model->credentialId,
                    'credentialKey' => $model->credentialKey ? '••••••••' . substr($model->credentialKey, -6) : '-',
                    'urlTokenSPLP' => $model->urlTokenSPLP,
                    'baseURL' => $model->baseURL,
                    'pathResource' => $model->pathResource,
                    'pathResourceSend' => $model->pathResourceSend,
                    'token' => $model->token ? substr($model->token, 0, 20) . '...' : 'Belum Ada/Kosong',
                    'updated_at' => $model->updated_at ? $model->updated_at->format('Y-m-d H:i:s') : '-'
                ]
            ];
        } else {
            $this->step1 = [
                'status' => 'error',
                'message' => 'Tidak ada konfigurasi SILINDA yang aktif (is_active = 1) di database.',
                'data' => []
            ];
        }
    }

    // Step 2: Ambil/Generate Token SPLP
    public function testGetToken()
    {
        if (!$this->config) {
            $this->alert('error', 'Konfigurasi tidak ditemukan.');
            return;
        }

        $this->step2['status'] = 'loading';
        $urlTokenSPLP = $this->config->urlTokenSPLP;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlTokenSPLP);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials&scope=silinda_creator");

        // Header Basic Authorization hardcoded di controller lama
        $headers = [
            'Authorization: Basic NWEzSzNvTmZGcHdZal9VT0RRR091OFNZZFU0YTpyempwNWpBUGhXSEpOY2JkZkVDSFlZWUg1T1lh',
            'Content-Type: application/x-www-form-urlencoded'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $err = curl_error($ch);
        curl_close($ch);

        $this->step2['url'] = $urlTokenSPLP;
        $this->step2['headers'] = $headers;
        $this->step2['payload'] = "grant_type=client_credentials&scope=silinda_creator";

        if ($err) {
            $this->step2['status'] = 'error';
            $this->step2['error'] = $err;
            $this->step2['raw_response'] = '';
            $this->alert('error', 'Gagal mendapatkan token: ' . $err);
        } else {
            $this->step2['raw_response'] = $result;
            $result1 = json_decode($result);
            $tokenResponse = $result1->access_token ?? "";

            if ($tokenResponse) {
                $this->step2['status'] = 'success';
                $this->step2['parsed_token'] = "Bearer " . $tokenResponse;
                
                // Simpan token ke database agar sinkron
                $model = Model::firstOrNew(['id' => $this->config->id]);
                $model->token = "Bearer " . $tokenResponse;
                $model->save();
                
                // Refresh data Step 1
                $this->checkDatabaseConfig();
                $this->alert('success', 'Token berhasil digenerate dan disimpan ke database!');
            } else {
                $this->step2['status'] = 'error';
                $this->step2['error'] = 'Token tidak ditemukan dalam response JSON.';
                $this->alert('error', 'Gagal mendapatkan token: access_token kosong.');
            }
        }
    }

    // Step 3: Test Read API
    public function testReadAPI()
    {
        if (!$this->config) {
            $this->alert('error', 'Konfigurasi tidak ditemukan.');
            return;
        }

        if (!$this->selectedPasarRead) {
            $this->alert('warning', 'Pilih pasar terlebih dahulu.');
            return;
        }

        $this->step3['status'] = 'loading';
        $pasar = RefPasar::find($this->selectedPasarRead);
        
        if (!$pasar || !$pasar->kode_integrasi) {
            $this->step3['status'] = 'error';
            $this->step3['error'] = 'Pasar tidak memiliki kode integrasi SILINDA.';
            return;
        }

        $myObj = new \stdClass();
        $myObj->length = 70;
        $myObj->market_id = $pasar->kode_integrasi;
        $myObj->time = date("Y-m-d");
        $myJSON = json_encode($myObj);

        $url = $this->config->baseURL . $this->config->pathResource;
        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $this->config->token,
            'Cookie: priangan_ses=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%223c42b07daa419f31433e7a39fa7b8be0%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A14%3A%22103.170.104.48%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A29%3A%22Synapse-PT-HttpComponents-NIO%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1697775983%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7D78ddfc0eb4cb1af12e3b8894b97d13e0'
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $myJSON,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
        ]);

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        $this->step3['url'] = $url;
        $this->step3['headers'] = $headers;
        $this->step3['payload'] = $myJSON;

        if ($err) {
            $this->step3['status'] = 'error';
            $this->step3['error'] = $err;
            $this->step3['raw_response'] = '';
            $this->alert('error', 'Gagal membaca API SILINDA: ' . $err);
        } else {
            $this->step3['status'] = 'success';
            $this->step3['raw_response'] = $result;
            $this->step3['error'] = '';
            $this->alert('success', 'Berhasil melakukan request API Read!');
        }
    }

    // Step 4: Pilih pasar untuk sinkronisasi / kirim data
    public function updatedSelectedPasarWrite($pasarId)
    {
        $this->availableKomoditas = [];
        $this->selectedKomoditasWrite = null;
        
        if (!$pasarId) return;

        $this->availableKomoditas = Komoditas::join('ref_siba_komoditas', 'ref_siba_komoditas.id', '=', 't_siba_komoditas.komoditas_id')
            ->whereNotNull('ref_siba_komoditas.id_silinda')
            ->where('t_siba_komoditas.pasar_id', $pasarId)
            ->where('t_siba_komoditas.detail_tgl', date("Y-m-d"))
            ->select('t_siba_komoditas.id as trans_id', 'ref_siba_komoditas.namakomoditas as nama_komoditas', 'ref_siba_komoditas.id_silinda', 't_siba_komoditas.harga_publish')
            ->orderBy('ref_siba_komoditas.id_silinda', 'asc')
            ->get()
            ->toArray();
            
        if (empty($this->availableKomoditas)) {
            $this->alert('warning', 'Tidak ada data transaksi harga untuk hari ini yang memiliki ID SILINDA pada pasar ini.');
        }
    }

    // Kirim satu komoditas
    public function testSendSingleKomoditas()
    {
        if (!$this->config) {
            $this->alert('error', 'Konfigurasi tidak ditemukan.');
            return;
        }

        if (!$this->selectedPasarWrite || !$this->selectedKomoditasWrite) {
            $this->alert('warning', 'Pilih pasar dan komoditas terlebih dahulu.');
            return;
        }

        $pasar = RefPasar::find($this->selectedPasarWrite);
        
        // Cari item terpilih
        $targetItem = null;
        foreach ($this->availableKomoditas as $item) {
            if ($item['trans_id'] == $this->selectedKomoditasWrite) {
                $targetItem = $item;
                break;
            }
        }

        if (!$targetItem) {
            $this->alert('error', 'Data komoditas tidak valid.');
            return;
        }

        $this->step4['status'] = 'loading';

        $myObj = new \stdClass();
        $myObj->username_log = "integrasi_kab_bandung";
        $myObj->market_id = $pasar->kode_integrasi;
        $myObj->time = date("Y-m-d"); 
        $myObj->commodity_id = $targetItem['id_silinda'];  
        $myObj->price = $targetItem['harga_publish'];
        $myJSON = json_encode($myObj);

        $url = $this->config->baseURL . $this->config->pathResourceSend;
        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $this->config->token,
            'Cookie: priangan_ses=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%225621aa3e66cf4220e54cda6d6bb24a69%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A15%3A%22172.10.10.67%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A29%3A%22Synapse-PT-HttpComponents-NIO%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1697095087%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7D2696be34422c57f3fb81adcd0d980164'
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $myJSON,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
        ]);

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        $logEntry = [
            'commodity' => $targetItem['nama_komoditas'] . " (ID: " . $targetItem['id_silinda'] . ")",
            'payload' => $myJSON,
            'response' => $err ? 'Error: ' . $err : $result,
            'status' => 'error'
        ];

        if (!$err) {
            $jsonRest = json_decode($result);
            if (isset($jsonRest->status) && $jsonRest->status == 'ok') {
                $logEntry['status'] = 'success';
                
                // Update last_integrasi pasar
                $pasar->last_integrasi = date("Y-m-d H:i:s");
                $pasar->save();
                
                $this->alert('success', 'Berhasil mengirim data komoditas: ' . $targetItem['nama_komoditas']);
            } else {
                $this->alert('error', 'Gagal mengirim data komoditas. Periksa log respons.');
            }
        } else {
            $this->alert('error', 'Gagal cURL: ' . $err);
        }

        array_unshift($this->step4['logs'], $logEntry);
        $this->step4['status'] = 'success';
    }

    // Kirim semua komoditas
    public function testSendAllKomoditas()
    {
        if (!$this->config) {
            $this->alert('error', 'Konfigurasi tidak ditemukan.');
            return;
        }

        if (!$this->selectedPasarWrite) {
            $this->alert('warning', 'Pilih pasar terlebih dahulu.');
            return;
        }

        if (empty($this->availableKomoditas)) {
            $this->alert('warning', 'Tidak ada data komoditas yang siap dikirim.');
            return;
        }

        $pasar = RefPasar::find($this->selectedPasarWrite);
        $this->step4['status'] = 'loading';
        
        $successCount = 0;
        $failCount = 0;

        foreach ($this->availableKomoditas as $targetItem) {
            $myObj = new \stdClass();
            $myObj->username_log = "integrasi_kab_bandung";
            $myObj->market_id = $pasar->kode_integrasi;
            $myObj->time = date("Y-m-d"); 
            $myObj->commodity_id = $targetItem['id_silinda'];  
            $myObj->price = $targetItem['harga_publish'];
            $myJSON = json_encode($myObj);

            $url = $this->config->baseURL . $this->config->pathResourceSend;
            $headers = [
                'Content-Type: application/json',
                'Authorization: ' . $this->config->token,
                'Cookie: priangan_ses=a%3A5%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%225621aa3e66cf4220e54cda6d6bb24a69%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A15%3A%22172.10.10.67%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A29%3A%22Synapse-PT-HttpComponents-NIO%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1697095087%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3B%7D2696be34422c57f3fb81adcd0d980164'
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $myJSON,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
            ]);

            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            $logEntry = [
                'commodity' => $targetItem['nama_komoditas'] . " (ID: " . $targetItem['id_silinda'] . ")",
                'payload' => $myJSON,
                'response' => $err ? 'Error: ' . $err : $result,
                'status' => 'error'
            ];

            if (!$err) {
                $jsonRest = json_decode($result);
                if (isset($jsonRest->status) && $jsonRest->status == 'ok') {
                    $logEntry['status'] = 'success';
                    $successCount++;
                } else {
                    $failCount++;
                }
            } else {
                $failCount++;
            }

            array_unshift($this->step4['logs'], $logEntry);
        }

        if ($successCount > 0) {
            // Update last_integrasi pasar
            $pasar->last_integrasi = date("Y-m-d H:i:s");
            $pasar->save();
            
            $this->alert('success', "Sinkronisasi selesai! Berhasil: {$successCount}, Gagal: {$failCount}");
        } else {
            $this->alert('error', "Sinkronisasi gagal sepenuhnya. Silakan periksa log respons.");
        }

        $this->step4['status'] = 'success';
    }

    // Reset log step 4
    public function resetLogs()
    {
        $this->step4['logs'] = [];
        $this->alert('info', 'Log pengetesan berhasil dibersihkan.');
    }
}
