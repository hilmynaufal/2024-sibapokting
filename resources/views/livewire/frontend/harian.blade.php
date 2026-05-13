@section('title')
Harga Harian
@stop
@section('utama')
Tabel
@stop
@section('submenu')
Harga Harian
@stop

@push('css')
<style>
    .loading-overlay {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
    }
</style>
@endpush

<div>
    @livewire('Frontend.Sidebar')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row g-5 g-xl-12">
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <div class="card card-flush">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">HARGA PANGAN HARIAN KABUPATEN BANDUNG</span>
                                </h3>
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <div class="mb-0" style="margin-right:4px;">
                                        <label class="form-label">Pilih Tanggal</label>
                                        <div class="w-200 mw-350px position-relative">
                                            <input class="form-control form-control-sm" wire:model.live="end" name="end" id="end" />
                                            <div class="position-absolute translate-middle-y top-50 mt-1 end-0 me-3">
                                                <i class="ki-duotone ki-calendar text-gray-500 fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div wire:loading>
                                <div class="card-body d-flex flex-column flex-center">
                                    <div class="mb-2">
                                        <h1 class="fw-semibold text-gray-800 text-center lh-lg">
                                            Mohon Tunggu <br>
                                            <span class="fw-bolder">Memproses Data</span>
                                        </h1>
                                        <div class="py-10 text-center">
                                            <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body py-3" wire:loading.remove>
                                <div class="row col-md-12 mb-5 table-responsive">
                                    <table class="table table-sm table-row-dashed m-2">
                                        <thead>
                                            <tr class="fs-7 bg-dark fw-bold border-0 text-white">
                                                <th class="p-4">Nama Komoditas</th>
                                                @foreach($jsonData->meta->pasar as $pasar)
                                                    <th class="min-w-100px p-4">{{ $pasar }}</th>
                                                @endforeach
                                                <th class="min-w-100px p-4">Jumlah Pasar</th>
                                                <th class="min-w-100px p-4">Rata-Rata</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jsonData->meta->komoditas as $komoditas)
                                                <tr>
                                                    <td class="fw-bold p-4">{{ $komoditas->namakomoditas }}</td>
                                                    @php
                                                        $jumlah_pasar = 0;
                                                        $total_harga = 0;
                                                    @endphp
                                                    @foreach($jsonData->meta->pasar as $pasar)
                                                        @php
                                                            $perpasar = collect($jsonData->data)->firstWhere('name', $pasar);
                                                            $perkomoditas = $perpasar ? collect($perpasar->data)->firstWhere('komoditas', $komoditas->namakomoditas) : null;
                                                            if ($perkomoditas) {
                                                                $jumlah_pasar++;
                                                                $total_harga += $perkomoditas->harga;
                                                            }
                                                        @endphp
                                                        <td class="min-w-80px p-4">
                                                            Rp. {{ $perkomoditas ? number_format($perkomoditas->harga, 0) : '-' }}
                                                        </td>
                                                    @endforeach
                                                    <td class="p-4">{{ $jumlah_pasar }}</td>
                                                    <td class="p-4">Rp. {{ $jumlah_pasar > 0 ? number_format($total_harga / $jumlah_pasar, 0) : '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>

@push('js')
<script>
    $(document).ready(function () {
        $("#end").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
    });
</script>
@endpush
