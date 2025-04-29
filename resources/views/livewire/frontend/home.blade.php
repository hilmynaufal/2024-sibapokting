@section('title')
Home
@stop
@section('utama')
Home
@stop

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
                        <!--begin::Slider Widget 7-->
                        <div id="kt_sliders_widget_7_slider"
                            class="card card-flush carousel carousel-custom carousel-light-dots carousel-stretch slide h-450px"
                            data-bs-ride="carousel" data-bs-interval="5000" style="background-color: #008674"
                            data-bs-theme="light">
                            <!--begin::Header-->
                            <div class="card-header align-items-center pt-7">
                                <!--begin::Title-->
                                <h4 class="card-label fw-bold text-white m-0">Selamat Datang Panel Komoditas Pangan</h4>
                                <!--end::Title-->

                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Carousel Indicators-->
                                    <ol
                                        class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-danger">
                                        @foreach($listBannerTop as $listBanner)
                                        <li data-bs-target="#kt_sliders_widget_7_slider"
                                            data-bs-slide-to="{{$listBanner->id}}"
                                            class="ms-1 {{$listBanner->id == $listBannerActive->id ? 'active' : ''}}">
                                        </li>
                                        @endforeach

                                    </ol>
                                    <!--end::Carousel Indicators-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body pt-3">
                                <!--begin::Carousel-->
                                <div class="carousel-inner h-400px pt-20">
                                    @foreach($listBannerTop as $listBannerData)
                                    <!--begin::Item-->
                                    <div class="carousel-item {{$listBannerData->id == $listBannerActive->id ? 'active show' : ''}}">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Wrapper-->
                                            <div class="m-7">
                                                <!--begin::Title-->
                                                <div class="position-relative w-600px fs-2x z-index-2 fw-bold text-white mb-7">
                                                    {!! $listBannerData->deskripsi!!}
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Wrapper-->
                            
                                            <!--begin::Illustration-->
                                            <img src="{{Storage::disk('public')->url($listBannerData->gambar)}}"
                                                class="position-absolute me-3 bottom-2 mt-8 end-0 h-400px w-auto" alt="">
                                            <!--end::Illustration-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Item-->
                                    @endforeach
                                </div>
                                <!--end::Body-->
                            </div>                            
                            <!--end::Slider Widget 7-->


                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row g-2 g-xl-12">
                        <!--begin::Col-->
                        <div class="col-xl-12">
                            <!--begin::Table widget 6-->
                            <div class="card card-flush h-md-100">
                                <!--begin::Header-->
                                <div class="card-header pt-7">
                                    <!--begin::Title-->
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">
                                            @if(empty($search))
                                                Harga Rata-Rata Komoditas Kabupaten Bandung
                                            @else
                                                Harga Komoditas {{getNamaPasar($search)}} Kabupaten Bandung
                                            @endif
                                        </span>

                                        <span class="text-gray-500 mt-1 fw-semibold fs-6">{{tglIndo($date)}}</span>
                                    </h3>
                                    <!--end::Title-->

                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <div class="mb-0" style="margin-right:4px;">
                                            <label class="form-label">Pilih Tanggal</label>
                                            <div class="w-200 mw-350px">
                                                <input class="form-control form-control-lg" wire:model.live="date" name="date" id="kt_datepicker_1"/>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label">Pilih Pasar</label>
                                            <div class="w-200 mw-350px" wire:ignore >
                                                <select x-init="$($el).select2();
                                                $($el).on('change', function() {
                                                    $wire.set('search', $($el).val());
                                                })" wire:model.live="search"  name="search" id="search" class="form-control form-control-lg form-select-solid">
                                                    <option value="">Semua Pasar</option>
                                                    @foreach($list_pasar as $pasar)
                                                    <option value="{{$pasar->id}}">{{$pasar->namapasar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="row g-5 g-xl-10">
                                            @foreach ($model as $index => $item)
                                            <div class="col-sm-6 col-xl-4">
                                                <div class="border border-dashed border-gray-300 rounded px-7 py-3  ribbon ribbon-top">
                                                        <div class="ribbon-label" style="background-color: #ff7575">HET : {{rupiah($item->het,0)}}</div>
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-stack mb-3">
                                                        <!--begin::Wrapper-->
                                                        <div class="me-3">
                                                            <!--begin::Icon-->
                                                            <div class="symbol symbol-70px">
                                                                <img src="{{ Storage::disk('public')->url($item->gambar) }}" alt="">
                                                            </div>
                                                            <!--end::Icon-->

                                                            <!--begin::Title-->
                                                            <a class="text-gray-800 text-hover-primary fw-bold">{{limitasiKarakter($item->namakomoditas,25)}}</a>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Wrapper-->


                                                    </div>
                                                    <!--end::Info-->

                                                    <!--begin::Customer-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Name-->
                                                        <span class="text-gray-500 fw-bold">
                                                            Saat ini:
                                                            <div
                                                                class="text-gray-800 text-hover-primary fw-bold">
                                                                {{rupiah(avgHarga($item->id,$search,$date),0)}} </div>
                                                            Sebelumnya:
                                                            <div
                                                                class="text-gray-800 text-hover-primary fw-bold">
                                                                {{rupiah(avgHarga($item->id,$search,$date_before),0)}} </div>
                                                        </span>
                                                        <!--end::Name-->

                                                        <!--begin::Label-->
                                                        {!!
                                                            dinamikaHargaAvgIcon(avgHarga($item->id,$search,$date),avgHarga($item->id,$search,$date_before))
                                                        !!}
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Customer-->
                                                </div>
                                            </div>
                                            @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        {{-- <div
                                            class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                                            <div class="dataTables_length" id="kt_ecommerce_products_table_length">
                                                <label><select name="kt_ecommerce_products_table_length"
                                                        aria-controls="kt_ecommerce_products_table"
                                                        class="form-select form-select-sm form-select-solid"
                                                        wire:model.live="perpage">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select></label></div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                id="kt_ecommerce_products_table_paginate">
                                                {{ $model->links() }}
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <!--end: Card Body-->
                            </div>
                            <!--end::Table widget 6-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    
                    <!--begin::Row-->
                    <div class="row g-2 g-xl-12">
                        <!--begin::Col-->
                        <div class="col-xl-12">
                            <!--begin::Table widget 6-->
                            <div class="card card-flush h-md-100">
                                <!--begin::Header-->
                                <div class="card-header pt-7">
                                    <!--begin::Title-->
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">
                                        Perkembangan Harga Pangan Pokok Strategis
                                        </span>
                                    </h3>
                                    <!--end::Title-->

                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <div class="mb-0">
                                            <label class="form-label">Pilih Pasar</label>
                                            <div class="w-200 mw-350px" wire:ignore >
                                                <select x-init="$($el).select2();"  wire:model="searchPasar"name="searchPasar" id="searchPasar" class="form-control form-control-lg form-select-solid">
                                                    <option value="">Semua Pasar</option>
                                                    @foreach($list_pasar as $pasar)
                                                    <option value="{{$pasar->id}}">{{$pasar->namapasar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <label class="form-label">Pilih Komoditas</label>
                                            <div class="w-200 mw-350px" wire:ignore >
                                                <select x-init="$($el).select2();" wire:model="searchKomoditas" name="searchKomoditas" id="searchKomoditas" class="form-control form-control-lg form-select-solid">
                                                    @foreach($list_komoditas_search as $kom)
                                                    <option value="{{$kom->id}}">{{$kom->namakomoditas}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="row g-5 g-xl-10">
                                        <div id="chart">
                                        </div>
                                    </div>
                                </div>
                                <!--end: Card Body-->
                            </div>
                            <!--end::Table widget 6-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <div class="row g-2 g-xl-12">
                        <x-visitor/>
                    </div>
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>

@push('js')
<script>
    
  var options = {
    series: [],
    chart: {
      height: 400,
      type: "area",
      zoom: {
        enabled: false
      },
      toolbar: {
        show: false
      }
    },
    markers: {
      show: true,
      size: 6
    },
    dataLabels: {
      enabled: false
    },
    legend: {
      show: true,
      showForSingleSeries: true,
      position: "top",
      horizontalAlign: "right"
    },
    stroke: {
      curve: "smooth",
      linecap: "round"
    },
    grid: {
      row: {
        colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
        opacity: 0.5
      }
    },
    xaxis: {
        categories: [ "Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Okt","Nov","Des"]
    }
  };
$( document ).ready(function() {
    $("#kt_datepicker_1").flatpickr({
        "setDate": new Date(),
        "autoclose": true
    });

    var settings = {
        "url": {!! json_encode(url('/')) !!}+"/api/dataChart?pasar="+$('#searchPasar').val() +"&komoditas="+$('#searchKomoditas').val(),
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function (response) {
        chart.updateSeries([
            {
            //     name: '2022',
            //     data: response['data22']
            // },{
                name: '2023',
                data: response['data23']
            },{
                name: '2024',
                data: response['data24']
            },
            {
                name: '2025',
                data: response['data25']
            },
            {
                name:'HET/HAP',
                data:response['het']
            }
        ])
    });
});
        
var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

$("#searchKomoditas").on("change", function() {
    var settings = {
        "url": {!! json_encode(url('/')) !!}+"/api/dataChart?pasar="+$('#searchPasar').val() +"&komoditas="+$('#searchKomoditas').val(),
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function (response) {
        chart.updateSeries([
            {
            //     name: '2022',
            //     data: response['data22']
            // },{
                name: '2023',
                data: response['data23']
            },{
                name: '2024',
                data: response['data24']
            },
            {
                name: '2025',
                data: response['data25']
            },
            {
                name:'HET/HAP',
                data:response['het']
            }
        ])
    });
});

$("#searchPasar").on("change", function() {
    var settings = {
        "url": {!! json_encode(url('/')) !!}+"/api/dataChart?pasar="+$('#searchPasar').val() +"&komoditas="+$('#searchKomoditas').val(),
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function (response) {
        chart.updateSeries([
            {
            //     name: '2022',
            //     data: response['data22']
            // },{
                name: '2023',
                data: response['data23']
            },{
                name: '2024',
                data: response['data24']
            },
            {
                name: '2025',
                data: response['data25']
            },
            {
                name:'HET/HAP',
                data:response['het']
            }
        ])
    });
});

</script>
@endpush