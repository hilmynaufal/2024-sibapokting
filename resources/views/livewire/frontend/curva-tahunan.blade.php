<div>
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
                            <div class="w-200 mw-350px" wire:ignore>
                                <select x-init="$($el).select2();" wire:model="searchPasar" name="searchPasar"
                                    id="searchPasar" class="form-control form-control-lg form-select-solid">
                                    <option value="">Semua Pasar</option>
                                    @foreach($list_pasar as $pasar)
                                    <option value="{{$pasar->id}}">{{$pasar->namapasar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Pilih Komoditas</label>
                            <div class="w-200 mw-350px" wire:ignore>
                                <select x-init="$($el).select2();" wire:model="searchKomoditas" name="searchKomoditas"
                                    id="searchKomoditas" class="form-control form-control-lg form-select-solid">
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
                name: '2022',
                data: response['data22']
            },{
                name: '2023',
                data: response['data23']
            },{
                name: '2024',
                data: response['data24']
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
                name: '2022',
                data: response['data22']
            },{
                name: '2023',
                data: response['data23']
            },{
                name: '2024',
                data: response['data24']
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
                name: '2022',
                data: response['data22']
            },{
                name: '2023',
                data: response['data23']
            },{
                name: '2024',
                data: response['data24']
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