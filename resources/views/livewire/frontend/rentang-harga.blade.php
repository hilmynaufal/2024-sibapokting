@section('title')
Home
@stop
@section('utama')
Grafik
@stop
@section('submenu')
Tabel Komoditas
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
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl ">
                <!--begin::Row-->
                <div class="row g-5 g-xl-12">
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <div class="card card-flush">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">PERKEMBANGAN HARGA BAHAN POKOK</span>
                                </h3>
                                <!--end::Title-->
                                
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                    <div class="mb-0" style="margin-right:4px;">
                                        <label class="form-label">Pilih Komoditas</label>
                                        <div class="w-200 mw-350px" wire:ignore>
                                            <select x-init="$($el).select2();
                                            $($el).on('change', function() {
                                                $wire.set('komoditas', $($el).val())
                                            })" wire:model.live="komoditas"
                                                name="komoditas" id="komoditas"
                                                class="form-control form-control-sm form-select-solid">
                                                <option value="">Semua Komoditas</option>
                                                @foreach($list_komoditas_search as $kom)
                                                <option value="{{$kom->id}}">{{$kom->namakomoditas}}</option>
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
                                                        <td class="min-w-80px p-4">{{ $data ? nilai($data->prices,0) : '-' }}</td>
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
                    <!--end::Row-->
                   
                </div>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--end::Content wrapper-->
</div>

@push('js')
<script>
    $(document).ready(function () {
        $("#komoditas").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
        $("#start").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
        $("#end").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
    });
</script>
@endpush