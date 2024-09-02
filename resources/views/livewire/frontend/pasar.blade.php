@section('title')
Peta Pasar
@stop
@section('utama')
Pasar
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
                    <div class="card">
                        <!--begin::Body-->
                        <div class="card-body p-lg-17">
                            <!--begin::Team-->
                            <div class="mb-18">
                                <!--begin::Heading-->
                                <div class="text-center mb-17">
                                    <!--begin::Title-->
                                    <h3 class="fs-2hx text-gray-900 mb-5">Peta Pasar</h3>
                                    <!--end::Title-->
                                </div>
                                <!--end::Heading-->

                                <!--begin::Wrapper-->
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 gy-10">
                                    <div id="mapid"></div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
        </div>
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
    var mymap = L.map('mapid').setView([-7.003074, 107.688541], 12);
    var tileUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var att = '&copy; <a href="https://www.openstreetmap.org/copyright">Open</a>';
    var tiles = L.tileLayer(tileUrl,{att});
    var greenIcon = L.icon({
        iconUrl: 'http://maps.google.com/mapfiles/ms/micons/green.png',
        iconSize:     [35, 35], // size of the icon
    });
    
    tiles.addTo(mymap);
    
    @foreach($pasarpeta as $i)
    L.marker([{{$i->latitude}},{{$i->longitude}}]).addTo(mymap).bindPopup("<b>{{$i->namapasar}}</b><br>{{$i->alamat}}<br><a wire:click=\"$dispatch('openModal', { component: 'modal.transaksi.komoditas.edit', arguments: { id: {{ $i->id }} }})\" class='btn btn-sm btn-icon btn-success' title='Lihat'><i class='bi bi-eye-fill'></i></a>");
    @endforeach
</script>

@endpush