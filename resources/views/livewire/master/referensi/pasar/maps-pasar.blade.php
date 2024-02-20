

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
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <div class="col-lg-12 col-xxl-12">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Tambah Master Pasar</span>
                    </h3>
            </div>
            <div class="card-body" style="text-align:left;">
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


                                        <div wire:ignore>
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

                    <div class="card-footer">
                        <a class="btn btn-secondary" href="{{route('master.referensi.pasar')}}">Close</a>
                        <button id="submitformeditpihak1" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


