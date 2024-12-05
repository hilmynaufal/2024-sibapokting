<div>
    <div class="row g-5 g-xl-12">
        <!--begin::Col-->
        <div class="col-xl-12">
            <div class="card card-flush">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <h3 class="card-title fw-bold text-gray-800">PERKEMBANGAN HARGA {{getKomoditas($komoditas)->namakomoditas}} 20 HARI SEBELUMNYA</h3>
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
                                <input type="date" class="form-control form-control-sm" onchange="changeBar()" wire:model="date_komoditas"
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
                    {{-- <div class="d-flex flex-wrap d-grid gap-5 px-9 mb-5">
                        <div class="me-md-2">
                            <div class="d-flex mb-2">
                                <span class="fs-4 fw-semibold text-gray-500 me-1">Rp</span>
                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{nilai(getKomoditas($komoditas)->het,0)}}</span>
                            </div>
                            <span class="fs-6 fw-semibold text-gray-500">Harga Eceran Tertinggi</span>
                        </div>
                        <div class="m-0">
                            <div class="d-flex align-items-center mb-2">
                                <span class="fs-4 fw-semibold text-gray-500 align-self-start me-1">Rp</span>
                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{nilai(avgHarga($komoditas,0,$date_komoditas_before),0)}}</span>
                            </div>
                            <span class="fs-6 fw-semibold text-gray-500">Rata" {{tglIndo($date_komoditas_before)}}</span>
                        </div>
                        <div
                            class="border-start-dashed border-end-dashed border-start border-end border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">
                            <div class="d-flex mb-2">
                                <span class="fs-4 fw-semibold text-gray-500 me-1">Rp</span>
                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{nilai(avgHarga($komoditas,0,$date_komoditas),0)}}</span>
                                {!!
                                    dinamikaHargaAvgVariant(avgHarga($komoditas,0,$date_komoditas),avgHarga($komoditas,0,$date_komoditas_before))
                                !!}
                            </div>
                            <span class="fs-6 fw-semibold text-gray-500">Rata" {{tglIndo($date_komoditas)}}</span>
                        </div>
                    </div> --}}

                    <!--begin::Chart-->
                    {{-- <div id="bar" wire:ignore>
                    </div> --}}
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
                
                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                    <!--begin::Title-->
                    
                    <!--begin::Chart-->
                    <div id="line" wire:ignore>
                    </div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Row-->
    </div>
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
        colors: ['#98c379'], 
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
        $("#start").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
        $("#end").flatpickr({
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
                    data: response['price_now'],
                    color: '#00686b'
                }, {
                    name: 'Harga Sebelumnya',
                    data: response['price_before'],
                    color: '#f51156'
                }
            ]);
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
        // changeTabel();
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