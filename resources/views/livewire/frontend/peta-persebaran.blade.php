@section('title')
PETA HARGA
@stop
<div>
    <div class="row g-5 g-xl-12">
        <!--begin::Col-->
        <div class="col-xl-12">
            <div class="card card-flush">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <h3 class="card-title fw-bold text-gray-800">PETA PERSEBARAN HARGA</h3>
                    <!--end::Title-->

                    <!--begin::Toolbar-->
                    <div class="card-toolbar m-5">
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
                                <input type="date" class="form-control form-control-sm" onchange="changeBar()"
                                    wire:model="date_komoditas" name="date_komoditas" id="date_komoditas" />
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
                <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-5">

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 gy-10">
                        <div id="mapid"></div>
                    </div>
                </div>
                <!--end::Card body-->

            </div>
        </div>
        <!--end::Row-->

    </div>
</div>


@push('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
    <style type="text/css">
        #mapid {
            margin: 0 auto 0 auto;
            height: 500px;
            width: 100%;
        }
        html, body {
            height: 100%;
        }
   </style>
@endpush

@push('js')
<script type="text/javascript">
$( document ).ready(function() {
    var mymap = L.map('mapid').setView([-7.003074, 107.688541], 11);
    var tileUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var att = '&copy; <a href="https://www.openstreetmap.org/copyright">Open</a>';
    var tiles = L.tileLayer(tileUrl,{att});
    var greenIcon = L.icon({
        iconUrl: 'http://maps.google.com/mapfiles/ms/micons/green.png',
        iconSize:     [35, 35], // size of the icon
    });
    
    tiles.addTo(mymap);
    var settings = {
            "url": {!! json_encode(url('/')) !!}+"/api/komoditasBar?komoditas="+$('#komoditas').val() +"&date="+$('#date_komoditas').val(),
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            @foreach($pasarpeta as $i)
                L.marker([{{$i->latitude}},{{$i->longitude}}]).addTo(mymap).bindPopup("<b>{{$i->namapasar}}</b><br>{{$i->alamat}}<br><a wire:click=\"$dispatch('openModal', { component: 'modal.frontend.detail-maps', arguments: { id: {{ $i->id }} }})class='btn btn-sm btn-icon btn-success' title='Lihat'><i class='bi bi-eye-fill'></i></a>");
            @endforeach
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
});

</script>

@endpush