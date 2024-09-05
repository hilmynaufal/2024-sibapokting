@section('title')
    Laporan Stok Barang
@stop
@section('menu')
    Layanan > BPHTB > <b>Laporan Stok Barang</b>
@stop
<!--begin::Col-->
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-lg-12 col-xxl-12">
            <div class="col-xl-12">
                <div class="card card-flush">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">PERKEMBANGAN STOK BARANG</span>
                        </h3>
                        <!--end::Title-->
                        
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <div class="mb-0" style="margin-right:4px;">
                                <label class="form-label">Pilih Barang</label>
                                <div class="w-200 mw-350px" wire:ignore>
                                    <select x-init="$($el).select2();
                                    $($el).on('change', function() {
                                        $wire.set('barang', $($el).val())
                                    })" wire:model.live="barang"
                                        name="barang" id="barang"
                                        class="form-control form-control-sm form-select-solid">
                                        <option value="">Semua Barang</option>
                                        @foreach($list_barang_search as $kom)
                                        <option value="{{$kom->id}}">{{$kom->namabarang}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-0" style="margin-right:4px;">
                                <label class="form-label">Pilih Mulai</label>
                                <div class="w-200 mw-350px position-relative">
                                    <input class="form-control form-control-sm" wire:model.live="start" name="start" id="start" />
                                    <div class="position-absolute translate-middle-y top-50 mt-1 end-0 me-3">
                                        <i class="ki-duotone ki-calendar text-gray-500 fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-0" style="margin-right:4px;">
                                <label class="form-label">Pilih Selesai</label>
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
                            <div class="mb-0" style="margin-right:4px;">
                                <label class="form-label"></label>
                                <div class="w-200 mt-2 mw-350px position-relative">
                                    <a href="{{route('laporan.stok-print', ['barang'=>$barang,'start' => $start, 'end' => $end ])}}" target="_blank"
                                        class="btn btn-sm btn-light-danger btn-active-light-primary me-1"
                                        title="Cetak">
                                        <i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span
                                                class="path2"></span></i>Cetak
                                    </a>
                                </div>
                            </div>
                            <!--end::Daterangepicker-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div wire:loading>
                        <div class="card-body d-flex flex-column flex-center">  
                            <!--begin::Heading-->
                            <div class="mb-2">
                                <!--begin::Title-->
                                <h1 class="fw-semibold text-gray-800 text-center lh-lg">           
                                    Mohon Tunggu <br>
                                    <span class="fw-bolder">Memproses Data</span>
                                </h1>
                                <!--end::Title--> 
                                
                                <!--begin::Illustration-->
                                <div class="py-10 text-center">
                                    <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
                                </div>
                                <!--end::Illustration-->
                            </div>
                            <!--end::Heading-->

                        </div>
                    </div>
                    <div class="card-body py-3" wire:loading.remove >
                        <div class="row col-md-12 mb-5 table-responsive">
                            <table class="table table-sm table-row-dashed m-2">
                                <thead>
                                    <tr class="fs-7 bg-dark fw-bold border-0 text-white">
                                        <th class="p-4">Nama Pasar</th>
                                        @foreach ($jsonData->meta->date as $index => $date)
                                            <th class="min-w-80px p-4">{{ TglIndoBulan($jsonData->meta->date[$index]) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jsonData->data as $pasar)
                                        <tr>
                                            <td class="fw-bold p-4">{{ $pasar->name }}</td>
                                            @foreach ($jsonData->meta->date as $date)
                                                @php
                                                    $data = collect($pasar->by_date)->firstWhere('date', $date);
                                                @endphp
                                                <td class="min-w-80px p-4">
                                                <div class="d-flex flex-column content-justify-center flex-grow-1">
                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                                        <!--begin::Label-->
                                                        <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">Stok Awal</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="ms-auto fw-bolder text-gray-500 text-end">{{ $data ? nilai($data->awal,0) : '-' }}</div>
                                                        <!--end::Stats-->
                                                    </div>
                                                    <!--end::Label-->

                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center my-1">
                                                        <!--begin::Label-->
                                                        <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">Stok Masuk</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="ms-auto fw-bolder text-gray-500 text-end">{{ $data ? nilai($data->masuk,0) : '-' }}</div>
                                                        <!--end::Stats-->                    
                                                    </div>
                                                    <!--end::Label-->

                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                                        <!--begin::Label-->
                                                        <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">Stok Keluar</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="ms-auto fw-bolder text-gray-500 text-end">{{ $data ? nilai($data->keluar,0) : '-' }}</div>
                                                        <!--end::Stats-->                      
                                                    </div>
                                                    <!--end::Label-->
                                                    
                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                                        <!--begin::Label-->
                                                        <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">Stok Akhir</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="ms-auto fw-bolder text-gray-500 text-end">{{ $data ? nilai($data->akhir,0) : '-' }}</div>
                                                        <!--end::Stats-->                      
                                                    </div>
                                                    <!--end::Label-->
                                                </div>    
                                            </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
            </div>
            
            @push('js')
            <script>
            </script>
            @endpush
        </div>
    </div>
</div>


@push('js')
<script>
    $("#start").flatpickr();
    $("#end").flatpickr();
</script>
@endpush