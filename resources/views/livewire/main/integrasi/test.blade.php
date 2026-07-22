@section('title')
Pengetesan Integrasi SILINDA
@stop
@section('menu')
Referensi > <b>Pengetesan Integrasi SILINDA</b>
@stop

<div id="kt_app_content_container" class="app-container container-xxl">
    <!-- Header Card -->
    <div class="card mb-6 shadow-sm border-0 bg-gradient-to-r from-gray-900 to-slate-800 text-white rounded-4 overflow-hidden">
        <div class="card-body p-8 p-lg-12">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
                <div>
                    <span class="badge badge-light-primary fw-bold px-4 py-2 mb-3 text-uppercase tracking-wider">Developer & Debugging Tool</span>
                    <h1 class="fs-2x text-gray-900 fw-bold mb-2">Pusat Pengujian Integrasi SILINDA</h1>
                    <p class="fs-5 text-gray-600 mb-0 max-w-600px">
                        Lakukan diagnosa koneksi API, pembaruan token, serta pengujian data kirim secara aman dan bertahap dengan pelacakan respon real-time.
                    </p>
                </div>
                <div>
                    <a href="{{ route('main.integrasi.view') }}" class="btn btn-light-dark btn-sm fw-bold">
                        <i class="ki-outline ki-arrow-left fs-4 me-2"></i>Kembali ke Dashboard Integrasi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-6">
        <!-- LEFT COLUMN: Steps & Actions -->
        <div class="col-lg-7">
            
            <!-- STEP 1: Database Config Check -->
            <div class="card card-custom mb-6 border-0 shadow-sm rounded-4">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 text-gray-800">Langkah 1: Verifikasi Konfigurasi Database</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Memastikan kredensial API SILINDA tersedia di model RefSilinda.</span>
                    </h3>
                    <div class="card-toolbar">
                        <button class="btn btn-sm btn-icon btn-light-primary rounded-circle" wire:click="checkDatabaseConfig" title="Refresh status database">
                            <i class="ki-outline ki-arrows-loop fs-4"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body pt-2">
                    @if($step1['status'] == 'success')
                        <div class="alert alert-dismissible bg-light-success d-flex flex-column flex-sm-row p-4 mb-4 border-0">
                            <i class="ki-outline ki-shield-search fs-2hx text-success me-4 mb-5 mb-sm-0"></i>
                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                <h5 class="mb-1 text-success fw-bold">Database Terkoneksi</h5>
                                <span class="fs-7 text-gray-700">{{ $step1['message'] }}</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-3 my-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold text-gray-600 fs-7 w-150px">Credential ID:</td>
                                        <td class="text-gray-800 fw-bold fs-7">{{ $step1['data']['credentialId'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-gray-600 fs-7">Credential Key:</td>
                                        <td class="text-gray-800 fw-mono fs-7">{{ $step1['data']['credentialKey'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-gray-600 fs-7">Base URL:</td>
                                        <td class="text-gray-800 fw-bold fs-7">{{ $step1['data']['baseURL'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-gray-600 fs-7">URL Token SPLP:</td>
                                        <td class="text-gray-500 fs-8 fw-mono">{{ $step1['data']['urlTokenSPLP'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-gray-600 fs-7">Token Saat Ini:</td>
                                        <td>
                                            <span class="badge badge-light-info fw-mono fs-8 p-2" title="{{ $config->token ?? '' }}">{{ $step1['data']['token'] }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-4 mb-0 border-0">
                            <i class="ki-outline ki-information-5 fs-2hx text-danger me-4 mb-5 mb-sm-0"></i>
                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                <h5 class="mb-1 text-danger fw-bold">Konfigurasi Tidak Aktif</h5>
                                <span class="fs-7 text-gray-700">{{ $step1['message'] }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- STEP 2: Token SPLP Request -->
            <div class="card card-custom mb-6 border-0 shadow-sm rounded-4">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 text-gray-800">Langkah 2: Ambil & Perbarui Token SPLP</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Lakukan request token baru menggunakan kredensial SPLP.</span>
                    </h3>
                </div>
                <div class="card-body pt-2">
                    <p class="fs-7 text-gray-600">
                        Metode ini akan melakukan request POST secara real-time ke URL Token SPLP menggunakan authorization basic key bawaan sistem. Token yang diperoleh akan langsung disimpan ke database untuk digunakan pada step selanjutnya.
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
                        <button class="btn btn-primary fw-bold" wire:click="testGetToken" wire:loading.attr="disabled">
                            <span wire:loading.remove><i class="ki-outline ki-key fs-4 me-2"></i>Generate Token Baru</span>
                            <span wire:loading wire:target="testGetToken">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses Request...
                            </span>
                        </button>

                        @if($step2['status'] == 'success')
                            <span class="badge badge-light-success fw-bold px-3 py-2"><i class="ki-outline ki-check-circle fs-6 text-success me-1"></i>Token Baru Tersimpan</span>
                        @elseif($step2['status'] == 'error')
                            <span class="badge badge-light-danger fw-bold px-3 py-2"><i class="ki-outline ki-cross-circle fs-6 text-danger me-1"></i>Request Gagal</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- STEP 3: Test Read/Monitoring API -->
            <div class="card card-custom mb-6 border-0 shadow-sm rounded-4">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 text-gray-800">Langkah 3: Uji Coba Monitoring (Read API)</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Menguji pembacaan data monitoring komoditas dari SILINDA berdasarkan pasar.</span>
                    </h3>
                </div>
                <div class="card-body pt-2">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-gray-700 fs-7">Pilih Pasar Integrasi:</label>
                        <select class="form-select form-select-solid" wire:model="selectedPasarRead">
                            <option value="">-- Pilih Pasar --</option>
                            @foreach($pasarList as $p)
                                <option value="{{ $p->id }}">{{ $p->namapasar }} (Integrasi ID: {{ $p->kode_integrasi }})</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-dark fw-bold" wire:click="testReadAPI" wire:loading.attr="disabled" {{ empty($selectedPasarRead) ? 'disabled' : '' }}>
                        <span wire:loading.remove><i class="ki-outline ki-magnifier fs-4 me-2"></i>Kirim Request Read</span>
                        <span wire:loading wire:target="testReadAPI">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Membaca API...
                        </span>
                    </button>
                </div>
            </div>

            <!-- STEP 4: Test Write/Sync API -->
            <div class="card card-custom mb-6 border-0 shadow-sm rounded-4">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 text-gray-800">Langkah 4: Uji Coba Pengiriman Harga (Sync API)</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Simulasi pengiriman data transaksi harga komoditas harian ke SILINDA.</span>
                    </h3>
                </div>
                <div class="card-body pt-2">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-gray-700 fs-7">Pilih Pasar:</label>
                            <select class="form-select form-select-solid" wire:model.live="selectedPasarWrite">
                                <option value="">-- Pilih Pasar --</option>
                                @foreach($pasarList as $p)
                                    <option value="{{ $p->id }}">{{ $p->namapasar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-gray-700 fs-7">Pilih Komoditas (Hari Ini):</label>
                            <select class="form-select form-select-solid" wire:model="selectedKomoditasWrite" {{ empty($availableKomoditas) ? 'disabled' : '' }}>
                                <option value="">-- Pilih Komoditas --</option>
                                @foreach($availableKomoditas as $k)
                                    <option value="{{ $k['trans_id'] }}">{{ $k['nama_komoditas'] }} - Rp{{ number_format($k['harga_publish'], 0, ',', '.') }} (Silinda ID: {{ $k['id_silinda'] }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if(!empty($availableKomoditas))
                        <div class="alert alert-light-warning d-flex align-items-center p-3 mb-4 rounded-3 border-0">
                            <i class="ki-outline ki-information-4 fs-4 text-warning me-2"></i>
                            <span class="fs-8 text-gray-700 fw-semibold">Terdeteksi {{ count($availableKomoditas) }} data komoditas siap kirim hari ini pada pasar terpilih.</span>
                        </div>
                    @endif

                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-success fw-bold" wire:click="testSendSingleKomoditas" wire:loading.attr="disabled" {{ empty($selectedKomoditasWrite) ? 'disabled' : '' }}>
                            <span wire:loading.remove><i class="ki-outline ki-send fs-4 me-2"></i>Kirim Single Komoditas</span>
                            <span wire:loading wire:target="testSendSingleKomoditas">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim...
                            </span>
                        </button>

                        <button class="btn btn-light-success text-success fw-bold" wire:click="testSendAllKomoditas" wire:loading.attr="disabled" {{ empty($availableKomoditas) ? 'disabled' : '' }}>
                            <span wire:loading.remove><i class="ki-outline ki-rocket fs-4 me-2"></i>Kirim Seluruh Komoditas (Loop)</span>
                            <span wire:loading wire:target="testSendAllKomoditas">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim Masal...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: Realtime Log Console & Payload Inspector -->
        <div class="col-lg-5">
            
            <!-- STICKY CONSOLE CONTAINER -->
            <div class="card card-custom border-0 shadow-sm rounded-4 h-lg-100 min-h-600px bg-slate-900 text-light d-flex flex-column overflow-hidden">
                <div class="card-header border-0 bg-dark py-4 px-6 d-flex align-items-center justify-content-between">
                    <h3 class="card-title my-0">
                        <span class="card-label fw-bold text-white fs-4"><i class="ki-outline ki-terminal fs-3 me-2 text-primary"></i>KONSOL DEBUG RESEP & LOG API</span>
                    </h3>
                    <div class="card-toolbar">
                        <button class="btn btn-sm btn-outline btn-outline-dashed btn-outline-danger btn-color-gray-100 btn-active-danger" wire:click="resetLogs">
                            Bersihkan Log
                        </button>
                    </div>
                </div>

                <!-- CONSOLE SCREEN / INSPECTOR BODY -->
                <div class="card-body p-6 flex-grow-1 overflow-y-auto" style="max-height: 75vh; font-family: 'Courier New', Courier, monospace;">
                    
                    <!-- STEP 2 LIVE LOGS -->
                    @if($step2['status'] != 'idle')
                        <div class="mb-6 p-4 rounded bg-dark border border-secondary">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge badge-light-primary fw-bold uppercase">LOG STEP 2: SPLP TOKEN</span>
                                <span class="text-muted fs-8">{{ date("H:i:s") }}</span>
                            </div>
                            <div class="fs-8 text-gray-300">
                                <strong>Request URL:</strong><br>
                                <span class="text-info">{{ $step2['url'] }}</span><br><br>
                                
                                <strong>Headers:</strong>
                                <pre class="text-warning bg-slate-800 p-2 rounded mt-1 fs-9">{{ json_encode($step2['headers'], JSON_PRETTY_PRINT) }}</pre>
                                
                                <strong>Payload:</strong><br>
                                <code class="text-success">{{ $step2['payload'] }}</code><br><br>
                                
                                @if($step2['status'] == 'loading')
                                    <div class="text-primary text-center py-2"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Menunggu Response...</div>
                                @elseif($step2['status'] == 'error')
                                    <strong class="text-danger">Error / Failure:</strong><br>
                                    <span class="text-danger">{{ $step2['error'] }}</span>
                                @elseif($step2['status'] == 'success')
                                    <strong class="text-success">Raw Response Payload:</strong>
                                    <pre class="text-light bg-slate-800 p-2 rounded mt-1 fs-9 overflow-x-auto">{{ $step2['raw_response'] }}</pre>
                                    
                                    <strong class="text-success">Parsed Authorization Token:</strong><br>
                                    <span class="text-info fs-9 text-break">{{ $step2['parsed_token'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- STEP 3 LIVE LOGS -->
                    @if($step3['status'] != 'idle')
                        <div class="mb-6 p-4 rounded bg-dark border border-secondary">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge badge-light-warning fw-bold text-dark uppercase">LOG STEP 3: MONITORING READ</span>
                                <span class="text-muted fs-8">{{ date("H:i:s") }}</span>
                            </div>
                            <div class="fs-8 text-gray-300">
                                <strong>Request URL:</strong><br>
                                <span class="text-info text-break">{{ $step3['url'] }}</span><br><br>
                                
                                <strong>Headers:</strong>
                                <pre class="text-warning bg-slate-800 p-2 rounded mt-1 fs-9 overflow-x-auto">{{ json_encode($step3['headers'], JSON_PRETTY_PRINT) }}</pre>
                                
                                <strong>Request Payload (JSON):</strong>
                                <pre class="text-success bg-slate-800 p-2 rounded mt-1 fs-9">{{ json_encode(json_decode($step3['payload']), JSON_PRETTY_PRINT) }}</pre>
                                
                                @if($step3['status'] == 'loading')
                                    <div class="text-primary text-center py-2"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Mengambil Data dari SILINDA...</div>
                                @elseif($step3['status'] == 'error')
                                    <strong class="text-danger">Request Gagal:</strong><br>
                                    <span class="text-danger">{{ $step3['error'] }}</span>
                                @elseif($step3['status'] == 'success')
                                    <strong class="text-success">Response dari SILINDA:</strong>
                                    <pre class="text-light bg-slate-800 p-2 rounded mt-1 fs-9 overflow-x-auto">{{ json_encode(json_decode($step3['raw_response']), JSON_PRETTY_PRINT) ?? $step3['raw_response'] }}</pre>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- STEP 4 LIVE SINKRONISASI LOGS -->
                    <div class="p-4 rounded bg-dark border border-secondary">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge badge-light-success fw-bold uppercase">LOG STEP 4: SINKRONISASI HARGA</span>
                            <span class="badge badge-secondary fs-9">{{ count($step4['logs']) }} Entri</span>
                        </div>
                        
                        @if(empty($step4['logs']))
                            <div class="text-center text-muted fs-8 py-8">
                                <i class="ki-outline ki-notepad-bookmark fs-2x mb-2 text-gray-700"></i><br>
                                Belum ada log transaksi pengiriman. Silakan lakukan pengujian pengiriman pada Langkah 4.
                            </div>
                        @else
                            @if($step4['status'] == 'loading')
                                <div class="text-center text-success fs-8 py-2"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Mengirim masal...</div>
                            @endif

                            <div class="d-flex flex-column gap-3 overflow-y-auto" style="max-height: 400px;">
                                @foreach($step4['logs'] as $log)
                                    <div class="border-bottom border-secondary pb-3 fs-9">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-bold text-light">{{ $log['commodity'] }}</span>
                                            @if($log['status'] == 'success')
                                                <span class="badge badge-success fs-9">SUCCESS</span>
                                            @else
                                                <span class="badge badge-danger fs-9">FAILED</span>
                                            @endif
                                        </div>
                                        
                                        <div class="text-gray-400">
                                            <strong>Payload:</strong> <code class="text-info fs-9">{{ $log['payload'] }}</code><br>
                                            <strong>Response:</strong> 
                                            <pre class="text-warning bg-slate-800 p-2 rounded mt-1 fs-9 overflow-x-auto">{{ json_encode(json_decode($log['response']), JSON_PRETTY_PRINT) ?? $log['response'] }}</pre>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
