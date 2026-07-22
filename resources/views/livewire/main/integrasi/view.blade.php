@section('title')
Integrasi Data
@stop
@section('menu')
Referensi > <b>Integrasi Data</b>
@stop
@push('css')
<style>
    .select2-container--open {
        z-index: 999999999;
    }

    .select2-container {
        z-index: 999999999;
    }
</style>
@endpush
@push('js')
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    new DataTable('#datatablePangkalan', {
        responsive: true
    });
</script>
@endpush

<!--begin::Col-->
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-lg-12 col-xxl-12">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body p-10 p-lg-15">
                    <!--begin::Content main-->
                    <div class="mb-14 ">
                        <!--begin::Heading-->
                        <div class="mb-15 d-flex align-items-center justify-content-between flex-wrap gap-4">
                            <div>
                                <!--begin::Title-->
                                <h1 class="fs-2x text-gray-900 mb-2">Integrasi Silinda Provinsi Jawa Barat</h1>
                                <!--end::Title-->

                                <!--begin::Text-->
                                <div class="fs-5 text-gray-600 fw-semibold">
                                    Pantau dan lakukan sinkronisasi data bahan pokok harian dengan sistem SILINDA Jawa Barat.
                                </div>
                                <!--end::Text-->
                            </div>
                            <div>
                                <a href="{{ route('main.integrasi.test') }}" class="btn btn-light-warning fw-bold">
                                    <i class="ki-outline ki-terminal fs-4 me-1"></i>Halaman Pengetesan (Debug)
                                </a>
                            </div>
                        </div>
                        <!--end::Heading-->

                        <!--begin::Body-->

                        <!--begin::Table-->
                        <div class="mb-14">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 text-center border-0 bg-light">
                                            <th class="min-w-200px rounded-start"></th>
                                            <th class="min-w-140px">Tanggal</th>
                                            <th class="min-w-120px">Status</th>
                                            <th class="min-w-100px rounded-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->

                                    <!--begin::Table body-->
                                    <tbody class="border-bottom border-dashed">
                                        @foreach($pasar as $value)

                                        <tr class="text-center">
                                            <td class="text-start ps-6">
                                                <div class="fw-semibold fs-4 text-gray-800">
                                                {{$value->namapasar}}
                                                </div>
                                            </td>
                                            <td>
                                                {{empty($value->last_integrasi) ? '-' : TglTimeIndo($value->last_integrasi)}} 
                                            </td>
                                            <td>
                                                @if(TglStandar($value->last_integrasi) != date("Y-m-d"))
                                                <i class="ki-outline ki-0 fs-2x text-danger"></i>
                                                <i class="ki-outline ki-cross fs-2x text-danger"></i> </td>
                                                @else
                                                <i class="ki-outline ki-check fs-2x text-success"></i>
                                                <i class="ki-outline ki-0 fs-2x text-success"></i> </td>
                                                @endif
                                            <td>
                                                <button class="btn btn-sm btn-dark lh-1 py-4" wire:click="singkronisasi({{$value->id}})" wire:loading.attr="disabled">
                                                    <span wire:loading.remove><i class="ki-outline ki-setting-4 fs-4 me-1"></i>Singkronisasi</span>
                                                    <span wire:loading >
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Table-->

                        <!--begin::Sync Logs Panel-->
                        @if(!empty($syncLogs))
                        <div class="card border border-gray-300 shadow-sm rounded-4 mt-8 bg-light">
                            <div class="card-header border-0 bg-secondary py-4 px-6 d-flex align-items-center justify-content-between rounded-top-4">
                                <h3 class="card-title my-0">
                                    <span class="fw-bold text-gray-800 fs-4">
                                        <i class="ki-outline ki-terminal fs-3 me-2 text-warning"></i>
                                        Log Sinkronisasi Terakhir: {{ $syncLogs['pasar'] }}
                                    </span>
                                </h3>
                                <div class="card-toolbar">
                                    <button class="btn btn-sm btn-light-dark fw-bold" wire:click="clearLogs">
                                        <i class="ki-outline ki-cross fs-5 me-1"></i>Sembunyikan Log
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-6">
                                <div class="d-flex align-items-center gap-4 mb-5 flex-wrap">
                                    <span class="badge badge-light-success fs-7 fw-bold px-3 py-2">
                                        <i class="ki-outline ki-check-circle fs-5 text-success me-1"></i>
                                        Berhasil: {{ $syncLogs['success_count'] }} Item
                                    </span>
                                    <span class="badge badge-light-danger fs-7 fw-bold px-3 py-2">
                                        <i class="ki-outline ki-cross-circle fs-5 text-danger me-1"></i>
                                        Gagal: {{ $syncLogs['failed_count'] }} Item
                                    </span>
                                    <span class="text-muted fs-8 fw-semibold ms-auto">Waktu: {{ $syncLogs['tanggal'] }}</span>
                                </div>

                                <div class="row g-4">
                                    <!-- SUCCESS LIST -->
                                    <div class="col-md-6">
                                        <div class="bg-white p-4 rounded-3 border border-gray-200 h-100 max-h-300px overflow-y-auto">
                                            <h5 class="fw-bold text-success mb-3 fs-6">
                                                <i class="ki-outline ki-like fs-5 me-1"></i>Item Berhasil Sinkronisasi
                                            </h5>
                                            @if(empty($syncLogs['success_list']))
                                                <div class="text-muted fs-8 py-4 text-center">Tidak ada komoditas yang berhasil dikirim.</div>
                                            @else
                                                <ul class="list-group list-group-flush fs-8">
                                                    @foreach($syncLogs['success_list'] as $sItem)
                                                        <li class="list-group-item px-0 py-2 border-dashed d-flex align-items-center">
                                                            <span class="bullet bullet-dot bg-success me-2"></span>
                                                            <span class="text-gray-800">{{ $sItem }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- FAILED LIST -->
                                    <div class="col-md-6">
                                        <div class="bg-white p-4 rounded-3 border border-danger border-dashed h-100 max-h-300px overflow-y-auto">
                                            <h5 class="fw-bold text-danger mb-3 fs-6">
                                                <i class="ki-outline ki-shield-cross fs-5 me-1"></i>Detail Log Kegagalan (Errors)
                                            </h5>
                                            @if(empty($syncLogs['errors']))
                                                <div class="text-muted fs-8 py-4 text-center">Bersih! Tidak ada kegagalan pengiriman.</div>
                                            @else
                                                <div class="d-flex flex-column gap-3">
                                                    @foreach($syncLogs['errors'] as $errItem)
                                                        <div class="p-4 bg-light-danger rounded-3 border border-danger-subtle text-danger fs-8">
                                                            <div class="fw-bold mb-1">
                                                                <i class="ki-outline ki-information-2 fs-6 text-danger me-1"></i>
                                                                {{ $errItem['komoditas'] }}: <span class="text-gray-800 fw-semibold">{{ $errItem['message'] }}</span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <span class="text-muted fs-9 d-block mb-1">Raw Response API:</span>
                                                                <pre class="bg-dark text-gray-300 p-3 rounded-2 fs-9 fw-mono overflow-x-auto text-break mb-0 max-h-150px" style="white-space: pre-wrap;">{{ $errItem['raw_response'] }}</pre>
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
                        @endif
                        <!--end::Sync Logs Panel-->

                    </div>
                    <!--end::Content main-->

                </div>
            </div>
            <!--begin::Body-->
        </div>
    </div>
</div>


<!--end::Col-->

@push('meta')
<meta name="turbolinks-visit-control" content="reload">
<meta name="turbolinks-cache-control" content="no-cache">
@endpush


@push('css')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@endpush

@push('js')
<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
@endpush