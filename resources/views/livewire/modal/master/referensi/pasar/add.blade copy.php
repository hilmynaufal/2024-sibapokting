<div class="modal fade show" id="modaleditpihak1" tabindex="-1" style="display: block; padding-left: 0px;"
    aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pasar</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="$dispatch('closeModal')">
                </button>
            </div>
            <div class="modal-body" style="text-align:left;">
                <form class="form-horizontal" wire:submit="create">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Titik Lokasi Maps Objek Pajak</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" style="width:50%;margin-top:0.7em;margin-left:2em;" class="form-control"
                                    id="pac-input" name="pac-input" placeholder="Masukkan Nama Lokasi">
                                <div class="row">
                                    <div class="col-md-12">


                                        <div>
                                            <div id="mapCanvas" style="width: 100%; height: 500px"></div>
                                        </div>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-6">
                                <label>Petunjuk Ubah Koordinat</label>
                                <div class="alert alert-danger">Silahkan Cari & Geser Kursor untuk Merubah Koordinat Sesuai
                                    Lokasi Objek Pajak</div>
                            </div>
                            <div class="col-md-2">
                                <label>Latitude</label>
                                <input type="text" wire:model="lat" name="lat" class="form-control" placeholder="Latitude" readonly>
                            </div>
                            <div class="col-md-2">

                                <label>Longitude</label>
                                <input type="text" wire:model="lng" name="lng" class="form-control" placeholder="Longitude" readonly>

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="token" wire:model="token">
                    <input type="hidden" id="id" name="id" wire:model="id" class="form-control">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Nama Pasar<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('namapasar') is-invalid @enderror" name="namapasar"
                                    wire:model="namapasar" id="namapasar">
                                @error('namapasar') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Tipe Pasar</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('tipe') is-invalid @enderror"
                                    name="tipe" wire:model="tipe" id="tipe">
                                @error('tipe') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Alamat<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text"
                                    oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                                    class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                    wire:model="alamat" id="alamat">
                                @error('alamat') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Provinsi<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2" wire:ignore>
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Provinsi --', });
                                $($el).on('change', function() {
                                    $wire.set('provinsi', $($el).val());
                                })" wire:model.live="provinsi" name="provinsi" id="provinsi"
                                        class="form-control form-control-lg form-select-solid @error('provinsi') is-invalid @enderror">
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach($provinsiList as $provinsi)
                                        <option value="{{$provinsi->id}}">{{$provinsi->id}} -
                                            {{strtoupper($provinsi->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Kota / Kabupaten<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2" wire:ignore.self>
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Kabupaten --', });
                                $($el).on('change', function() {
                                    $wire.set('kabupaten', $($el).val());
                                })" wire:model.live="kabupaten" name="kabupaten" id="kabupaten"
                                        class="form-control form-control-lg form-select-solid @error('kabupaten') is-invalid @enderror">
                                        <option value="">-- Pilih Kabupaten --</option>
                                        @foreach($kabupatenList as $kabupaten)
                                        <option value="{{$kabupaten->id}}">{{$kabupaten->id}} -
                                            {{strtoupper($kabupaten->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Kecamatan<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2" wire:ignore.self>
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Kecamatan --', });
                                $($el).on('change', function() {
                                    $wire.set('kecamatan', $($el).val());
                                })" wire:model.live="kecamatan" name="kecamatan" id="kecamatan"
                                        class="form-control form-control-lg form-select-solid @error('kecamatan') is-invalid @enderror">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach($kecamatanList as $kecamatan)
                                        <option value="{{$kecamatan->id}}">{{$kecamatan->id}} -
                                            {{strtoupper($kecamatan->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Kelurahan / Desa<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2" wire:ignore.self>
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Desa --', });
                                $($el).on('change', function() {
                                    $wire.set('desa', $($el).val());
                                })" wire:model.live="desa" name="desa" id="desa"
                                        class="form-control form-control-lg form-select-solid @error('desa') is-invalid @enderror">
                                        <option value="">-- Pilih Desa --</option>
                                        @foreach($kelurahanList as $kelurahan)
                                        <option value="{{$kelurahan->id}}">{{$kelurahan->id}} -
                                            {{strtoupper($kelurahan->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">RT<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control @error('rt') is-invalid @enderror" name="rt"
                                    wire:model="rt" id="rt">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">RW<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control @error('rw') is-invalid @enderror" name="rw"
                                    wire:model="rw" id="rw">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$dispatch('closeModal')">Close</button>
                        <button id="submitformeditpihak1" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




@push('js')

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKNBdoFt5N7b8OxFwo8QFvRQIY45Kkxm8&libraries=places&callback=initialize">
</script>

<script>

   
    window.addEventListener('keydown', function (e) {
if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
    if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
        e.preventDefault();
        return false;
    }
}
}, true);

<?php if($lat==NULL){ ?>
    // var position = [-6.8392563, 107.5101425];
    var position = [-7.110000, 107.620616];
    <?php }else{ ?>
        // var position = [position.coords.latitude, position.coords.longitude];
    var position = [<?php echo $lat; ?>, <?php echo $lng; ?>];
<?php } ?>

function initialize() {
initAutocomplete();
initMap();
}

function initAutocomplete() {
$('input[name="lat"]').val(position[0]);
$('input[name="lng"]').val(position[1]);
// alert(position[0],position[1]);
var latlng = new google.maps.LatLng(position[0], position[1]);
var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 22,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.SATELLITE,
    attributionControl: false,
});

// Change the map type based on user selection
function changeMapType() {
    var selectedMapType = document.getElementById('mapTypeSelector').value;
    map.setMapTypeId(google.maps.MapTypeId[selectedMapType]);
}


// Create the search box and link it to the UI element.
var input = document.getElementById('pac-input');
var searchBox = new google.maps.places.SearchBox(input);
map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

// Bias the SearchBox results towards current map's viewport.
map.addListener('bounds_changed', function () {
    searchBox.setBounds(map.getBounds());
});

var markers = [];
// Listen for the event fired when the user selects a prediction and retrieve
// more details for that place.

marker2 = new google.maps.Marker({
    position: latlng,
    map: map,
    zoom: 16,
    title: "Latitude:" + position[0] + " | Longitude:" + position[1]
});

google.maps.event.addListener(map, 'click', function (event) {
    var result = [event.latLng.lat(), event.latLng.lng()];
    transition(result);
});

searchBox.addListener('places_changed', function () {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
        return;
    }

    // Clear out the old markers.
    markers.forEach(function (marker) {
        marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function (place) {
        if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
        }
        var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        };

        // Create a marker for each place.
        markers.push(new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name,
            position: place.geometry.location
        }));

        if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
        } else {
            bounds.extend(place.geometry.location);
        }
    });
    map.fitBounds(bounds);
});
}

var numDeltas = 100;
var delay = 0; //milliseconds
var i = 0;
var deltaLat;
var deltaLng;

function transition(result) {
i = 0;
deltaLat = (result[0] - position[0]) / numDeltas;
deltaLng = (result[1] - position[1]) / numDeltas;
moveMarker();
}

function moveMarker() {
position[0] += deltaLat;
position[1] += deltaLng;
var latlng = new google.maps.LatLng(position[0], position[1]);
marker2.setTitle("Latitude:" + position[0] + " | Longitude:" + position[1]);
marker2.setPosition(latlng);
if (i != numDeltas) {
    i++;
    setTimeout(moveMarker, delay);
}
$('input[name="lat"]').val(position[0]);
$('input[name="lng"]').val(position[1]);
@this.set('lat', position[0], false);
@this.set('lng', position[1], false);
}

</script>
@endpush