@section('title')
    Laporan Harian Kepokmas
@stop
@section('menu')
    Layanan > BPHTB > <b>Laporan Harian Kepokmas</b>
@stop

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

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

<script>
    window.addEventListener('swal:deleteRequest', event => {
        Swal.fire({
            title: event.detail[0].title,
            text: event.detail[0].text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                @this.call('deleteSelectedRequest', event.detail[0].id);
                Swal.fire({
                    title: 'Data Berhasil tersimpan',
                    icon: 'success'
                });
            } else {
                Swal.fire({
                    title: 'Operasi Dibatalkan',
                    icon: 'success'
                });
            }
        });
    });
</script>
@endpush

<!--begin::Col-->
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-lg-12 col-xxl-12">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Harga Pangan Kabupaten Bandung</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3" >
                    <div class="row col-md-12 mb-5">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <div class="w-200 mw-350px position-relative">
                                <!--begin::Input-->
                                <input class="form-control form-control-sm" wire:model.live="end" name="end" id="end" />
                                <!--end::Input-->
            
                                <!--begin::CVV icon-->
                                <div class="position-absolute translate-middle-y top-50 mt-1 end-0 me-3">
                                    <i class="ki-duotone ki-calendar text-gray-500 fs-2"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>
                                
                                <!--end::CVV icon-->
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"></label>
                            <div class="w-200 mt-2 mw-350px position-relative">
                                <a href="{{route('laporan.all-print', ['end' => $end ])}}"
                                    class="btn btn-sm btn-light-danger btn-active-light-primary me-1"
                                    title="Cetak">
                                    <i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span
                                            class="path2"></span></i>Cetak
                                </a>
                            </div>
                        </div>
                    </div>
                        <div class="row col-md-12 mb-5 table-responsive">
                            <table class="table table-sm table-row-dashed m-2" id="all">
                                <thead>
                                    <tr class="fs-7 bg-dark fw-bold border-0 text-white">
                                        <th class="p-4">Nama Komoditas</th>
                                        @foreach($jsonData->meta->pasar as $pasar)
                                            <th class="min-w-100px">{{ $pasar }}</th>
                                        @endforeach
                                        <th class="min-w-100px p-4">Jumlah Pasar</th>
                                        <th class="min-w-100px p-4">Rata-Rata</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jsonData->meta->komoditas as $komoditas)
                                        <tr>
                                            <td>{{ $komoditas->namakomoditas }}</td>
                                            @php
                                                $jumlah_pasar = 0;
                                                $total_harga = 0;
                                            @endphp
                                            @foreach ($jsonData->meta->pasar as $pasar)
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
                </div>
                <!--end::Body-->
            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    $("#start").flatpickr();
    $("#end").flatpickr();
</script>
@endpush