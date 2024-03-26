@section('title')
Home
@stop
@section('utama')
Grafik
@stop
@section('submenu')
Varians Komoditas
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
                    <div class="col-xl-7">
                        <div class="card card-flush">
                            <!--begin::Header-->
                            <div class="card-header py-5">
                                <!--begin::Title-->
                                <h3 class="card-title fw-bold text-gray-800">DISPARITAS HARGA VARIANT</h3>
                                <!--end::Title-->

                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                    <div class="mb-0">
                                        <label class="form-label">Pilih Komoditas</label>
                                        <div class="w-200 mw-350px" wire:ignore>
                                            <select x-init="$($el).select2();" onchange="changeBar()" wire:model="komoditas"
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
                                        <label class="form-label">Pilih Tanggal</label>
                                        <div class="w-200 mw-350px position-relative">
                                            <!--begin::Input-->
                                            <input class="form-control form-control-sm" onchange="changeBar()" wire:model="date_komoditas"
                                                name="date_komoditas" id="date_komoditas" />
                                            <!--end::Input-->

                                            <!--begin::CVV icon-->
                                            <div class="position-absolute translate-middle-y top-50 mt-1 end-0 me-3">
                                                <i class="ki-duotone ki-calendar text-gray-500 fs-2"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                            </div>
                                            <!--end::CVV icon-->
                                        </div>
                                        <!--end::Input wrapper-->
                                    </div>
                                    <!--end::Daterangepicker-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                                <!--begin::Items-->
                                <div class="d-flex flex-wrap d-grid gap-5 px-9 mb-5">
                                    <!--begin::Item-->
                                    <div class="me-md-2">
                                        <!--begin::Statistics-->
                                        <div class="d-flex mb-2">
                                            <span class="fs-4 fw-semibold text-gray-500 me-1">Rp</span>
                                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{nilai(getKomoditas($komoditas)->het,0)}}</span>
                                        </div>
                                        <!--end::Statistics-->

                                        <!--begin::Description-->
                                        <span class="fs-6 fw-semibold text-gray-500">Harga Eceran Tertinggi</span>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div
                                        class="border-start-dashed border-end-dashed border-start border-end border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">
                                        <!--begin::Statistics-->
                                        <div class="d-flex mb-2">
                                            <span class="fs-4 fw-semibold text-gray-500 me-1">Rp</span>
                                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{nilai(avgHarga($komoditas,0,$date_komoditas),0)}}</span>

                                            <!--begin::Label-->
                                            {!!
                                                dinamikaHargaAvgVariant(avgHarga($komoditas,0,$date_komoditas),avgHarga($komoditas,0,$date_komoditas_before))
                                            !!}
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Statistics-->
                                        <!--begin::Description-->
                                        <span class="fs-6 fw-semibold text-gray-500">Rata" {{tglIndo($date_komoditas)}}</span>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="m-0">
                                        <!--begin::Statistics-->
                                        <div class="d-flex align-items-center mb-2">
                                            <!--begin::Currency-->
                                            <span class="fs-4 fw-semibold text-gray-500 align-self-start me-1">Rp</span>
                                            <!--end::Currency-->

                                            <!--begin::Value-->
                                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{nilai(avgHarga($komoditas,0,$date_komoditas_before),0)}}</span>
                                            <!--end::Value-->

                                        </div>
                                        <!--end::Statistics-->

                                        <!--begin::Description-->
                                        <span class="fs-6 fw-semibold text-gray-500">Rata" {{tglIndo($date_komoditas_before)}}</span>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Items-->

                                <!--begin::Chart-->
                                <div id="bar" wire:ignore>
                                </div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                                <!--begin::Title-->
                                
                                <!--begin::Header-->
                                <div class="card-header py-5">
                                    <h3 class="card-title fw-bold text-gray-800">PERKEMBANGAN HARGA {{getKomoditas($komoditas)->namakomoditas}}</h3>
                                </div>
                                <!--end::Title-->
                                <!--begin::Chart-->
                                <div id="line" wire:ignore>
                                </div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <!--end::Row-->
                    <!--begin::Col-->
                    <div class="col-xl-5">
                        <div class="card card-flush h-xl-100">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-800">Top Performing Pages</span>

                                    <span class="text-gray-500 pt-1 fw-semibold fs-6">Counted in Millions</span>
                                </h3>
                                <!--end::Title-->

                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <a href="#" class="btn btn-sm btn-light">PDF Report</a>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body py-3">
                                <div class="hover-scroll h-750px">
                                    <!--begin::Table-->
                                    <table class="table table-row-dashed align-middle gs-0 gy-4">
                                        <!--end::Table head-->
                                        <!--begin::Table head-->
                                        <thead>
                                            <tr class="fs-7 fw-bold border-0 text-gray-500">
                                                <th class="min-w-150px">VARIANT</th>
                                                <th class="min-w-80px text-start pe-0">TGL KMR</th>
                                                <th class="min-w-80px text-start pe-0">TGL SKR</th>
                                                <th class="text-start min-w-50px">PERUBAHAN</th>
                                            </tr>
                                        </thead>
                                        <!--begin::Table body-->
                                        <tbody>
                                            @foreach ($model as $index => $item)
                                                <tr>
                                                    <td class="min-w-150px">
                                                        <a href="#"
                                                            class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{$item->namakomoditas}}</a>
                                                    </td>

                                                    <td class="min-w-80px pe-0 pe-0">
                                                        <div class="d-flex justify-content-start">
                                                            <span class="text-gray-800 fw-bold fs-6">1,256</span>
                                                        </div>
                                                    </td>

                                                    <td class="min-w-80px pe-0">
                                                        <div class="d-flex justify-content-start">
                                                            <span class="text-gray-900 fw-bold fs-6">2.63</span>
                                                        </div>
                                                    </td>
                                                    <td class="min-w-50px">
                                                        <div class="d-flex justify-content-start">
                                                            <span
                                                                class="text-danger min-w-50px d-block text-start fw-bold fs-6">-1.35</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Body-->
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
    var options = {
        series: [],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: {!! json_encode($this->kategori) !!},
        },
        yaxis: {
            title: {
                text: 'Rp (Rupiah)'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "Rp " + val
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#bar"), options);
    chart.render();




    var options2 = {
        series: [],
        chart:{
          type: 'area',
          stacked: false,
          height: 350,
          zoom: {
            enabled: true,
            type: 'x',  
            autoScaleYaxis: true
        }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: [],
        },
        yaxis: {
            title: {
                text: 'Rp (Rupiah)'
            },
            showForNullSeries: true,
        }
    };

    var chart2 = new ApexCharts(document.querySelector("#line"), options2);
    chart2.render();
    $(document).ready(function () {
        $("#date_komoditas").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
        var settings = {
            "url": {!! json_encode(url('/')) !!}+"/api/komoditasBar?komoditas="+$('#komoditas').val() +"&date="+$('#date_komoditas').val(),
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            chart.updateSeries([
                {
                    name: 'Harga Sekarang',
                    data: response['price_now']
                }, {
                    name: 'Harga Sebelumnya',
                    data: response['price_before']
                }
            ]);
            // chart.updateOptions({
            //     xaxis: {
            //         categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
            //     },
            // });
        });



        var settings1 = {
            "url": {!! json_encode(url('/')) !!}+"/api/komoditasLine?komoditas="+$('#komoditas').val() +"&date="+$('#date_komoditas').val(),
            "method": "GET",
            "timeout": 0,
        };
        $.ajax(settings1).done(function (response) {
            chart2.updateSeries([
                {
                    name: 'Tanggal',
                    data: response['price_before']
                }
            ]);
            chart2.updateOptions({
                xaxis: {
                    categories: response['categori']
                },
            });
        });

    });

    function changeBar(){
        @this.set('komoditas', $('#komoditas').val());
        @this.set('date_komoditas', $('#date_komoditas').val());
        @this.set('date_komoditas_before', formatDateBefore($('#date_komoditas').val()));

        var settings = {
            "url": {!! json_encode(url('/')) !!}+"/api/komoditasBar?komoditas="+$('#komoditas').val() +"&date="+$('#date_komoditas').val(),
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            chart.updateSeries([
                {
                    name: 'Harga Sekarang',
                    data: response['price_now']
                }, {
                    name: 'Harga Sebelumnya',
                    data: response['price_before']
                }
            ])
        });
    }

    function formatDateBefore(date) {
        var d = new Date(date);
        var days = d.getDate() - 1;
        var month = '' + (d.getMonth() + 1),
            day = '' + days,
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }
</script>
@endpush