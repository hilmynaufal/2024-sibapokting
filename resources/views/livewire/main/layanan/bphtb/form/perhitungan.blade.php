<div>
    @section('title')
    4. Informasi Perhitungan Objek Pajak
    @stop
    @section('menu')
    Layanan > BPHTB > <b>4. Informasi Perhitungan Objek Pajak</b>
    @stop
    <fieldset>
        <form wire:submit="create">
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

            <HR>

            <div class="footer">
                <p class="text-danger">*Wajib Diisi</p>
                <div class="btn-list">
                    <a class="btn btn-danger pull-left" wire:click="backForm"><i class="fa fa-arrow-left"></i> Sebelumnya</a>

                    <button type="submit" class="btn btn-info float-end" wire:target="create" wire:loading.class.remove="bg-info" id="next">
                        Selanjutnya <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>

</form>
</fieldset>
</div>



@push('js')

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKNBdoFt5N7b8OxFwo8QFvRQIY45Kkxm8&libraries=places&callback=initialize">
</script>

<script data-navigate-once>
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
}

let kd_kec = "";
let kd_kel = "";
let kd_znt = "";
let nilai_pasar_tanah = 0;
let opt_nilai_pasar = {};

$("#letak_objek_pajak").change(function () {
setNilaiPasar();
});

$("#next").click(function () {
if ($('#harga_transaksi').val() <= 0) {
    Swal.fire({
        title: "Perhatian!",
        text: "Harga Transaksi harus diisi",
        icon: "warning",
        showConfirmButton: true,
    })
} else {
    $("#form-op").submit();
}
});

$('#nop').mask('00.00.000.000.000-0000.0');

$("#luas_tanah_baru").keyup(function (e) {
var n = parseInt($(this).val().replace(/\D/g, ''))

$(this).val(n.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}))

var nilai_tanah = parseInt($('#njop_tanah').val().replace(/\D/g, '')) * parseInt(n)

$("#total_nilai_tanah").val(nilai_tanah.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}));

var total_nilai_pasar = parseInt($("#total_nilai_tanah").val().replace(/\D/g, '')) + parseInt($('#total_nilai_bangunan').val().replace(/\D/g, ''));

$("#total_nilai_pasar").val(total_nilai_pasar.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}));

$("#harga_transaksi").val(total_nilai_pasar.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}));
});

$("#luas_tanah_baru").change(function () {
var n = parseInt($(this).val().replace(/\D/g, ''))

if (n > $('#luas_tanah_lama').val().replace(/\D/g, '')) {
    Swal.fire({
        title: "Perhatian!",
        text: "Luas Transaksi lebih besar dari Luas SPPT. Silahkan untuk perbaiki terlebih dahulu luas di pelayanan SIPADA PBB",
        icon: "warning",
        showConfirmButton: true,
    })

    $('#next').prop('disabled', true)
}
})

$("#luas_bangunan_baru").keyup(function () {
var n = parseInt($(this).val().replace(/\D/g, ''))

if ($('#luas_bangunan_lama').val() == 0) {
    if (n >= 1 && n <= 36) {
        var njop = 1833000;
        $('#njop_bangunan').val(njop.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }))
    } else if (n >= 37 && n <= 70) {
        var njop = 2200000;
        $('#njop_bangunan').val(njop.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }))
    } else if (n >= 71 && n <= 120) {
        var njop = 2625000;
        $('#njop_bangunan').val(njop.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }))
    } else if (n >= 121) {
        var njop = 3100000;
        $('#njop_bangunan').val(njop.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }))
    } else {
        var njop = 0;
        $('#njop_bangunan').val(njop.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }))
    }
}

$(this).val(n.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}))

var nilai_tanah = parseInt($('#njop_bangunan').val().replace(/\D/g, '')) * parseInt(n)

$("#total_nilai_bangunan").val(nilai_tanah.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}));

var total_nilai_pasar = parseInt($("#total_nilai_tanah").val().replace(/\D/g, '')) + parseInt($('#total_nilai_bangunan').val().replace(/\D/g, ''));

$("#total_nilai_pasar").val(total_nilai_pasar.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}));

$("#harga_transaksi").val(total_nilai_pasar.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}));
});

$("#harga_transaksi").keyup(function () {
var n = parseInt($(this).val().replace(/\D/g, ''))

$(this).val(n.toLocaleString('id-ID', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
}))

var nilai_tanah = Math.ceil((parseInt($(this).val().replace(/\D/g, '')) - parseInt($('#total_nilai_bangunan').val().replace(/\D/g, ''))) / parseInt($('#luas_tanah_baru').val().replace(/\D/g, '')))

$("#transaksi_tanah_permeter").val(nilai_tanah);
});

$('#histNop').hide();
$('.btn-cek-nop').click(function () {
$('#next').prop('disabled', true)
var nop = $('#nop').val()
var tahun_pajak = $('#tahun_pajak').val()

$.ajax({
    url: 'https://apisismiop.bandungbaratkab.go.id/api/getsppt?nop=' + nop,
    method: "get",
    dataType: 'json',
    headers: {
        'Authorization': "Bearer zMqfHsPnkJjHMb68PQvnYlF9b7asK4TSV0SO6SdVDUt6ll9cJcUVNbyX56nNVCxdZ870OcjX69PbdMXejP6VkJZRlYiFeGC7MZ1GQ0rG0erMWnFgSdeUmErxBL2jOuwNGzTAdU6NoJgcTASafeejFSaEoCSmCtFrXb5AIOC7XtXvVTkPFUWOKJCUJabgoKjf0IcF2DKb424PaxDkve7HRshq5hIgvgZItuE7zqzAgoUN42xAOYhLl7KW9tIrLbG"
    },
    beforeSend: function () {
        Swal.fire({
            title: "Mohon tunggu...",
            html: "<i class=\"fa fa-spinner fa-spin\"></i> Processing...",
            icon: "info",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        })
    },
    success: function (resp) {
        Swal.close()
        var belum_lunas = 0;
        var html = '';
        var total_bayar = 0;
        var tahun_tunggakan = [];

        $('#histNop').fadeIn();
        getHistoryNop();

        $.each(resp.data.sppt, function (index, value) {
            if (value.status_pembayaran == 'BELUM LUNAS' && value.piutang > 0) {
                tahun_tunggakan.push(value.thn_pajak_sppt);
                belum_lunas++;
                total_bayar += value.piutang;
                html += '<tr>' +
                    '<td>' + value.thn_pajak_sppt + '</td>' +
                    '<td> Rp. ' + parseInt(value.pbb_yg_harus_dibayar_sppt).toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0,
                    }) + '</td>' +
                    '<td>' + value.status_pembayaran + '</td>' +
                    '<td> Rp. ' + value.piutang.toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0,
                    }) + '</td>' +
                    '</tr>'
            }
        })

        html += '<tr>' +
            '<td colspan="3">Total Tunggakan</td>' +
            '<td>Rp. ' + total_bayar.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }) + '</td>'
        '</tr>'

        tahun_tunggakan.sort().reverse()
        var tunggakan = false;
        var tahun_berjalan = new Date().getFullYear();
        $.each(tahun_tunggakan, function (index, value) {
            if (value != tahun_berjalan) {
                tunggakan = true
            }
        })

        if (nop == '32.06.211.003.007-0003.0') {
            tunggakan = false;
        }

        if (tunggakan) {
            $('#lama_tunggakan').html(belum_lunas)
            $('#dataTunggakan').html(html)
            $('#text_tunggakan').html('Transaksi tidak dapat dilanjutkan karena terdapat tunggakan pada tahun sebelumnya.')
            $('#modalTunggakan').modal('show')

        } else {
            $('#lama_tunggakan').html(belum_lunas)
            $('#dataTunggakan').html(html)
            $('#modalTunggakan').modal('show')

            $.ajax({
                url: 'https://apisismiop.bandungbaratkab.go.id/api/getonesppt?nop=' + nop + '&thn_pajak_sppt=' + tahun_pajak,
                method: "get",
                dataType: 'json',
                headers: {
                    'Authorization': "Bearer zMqfHsPnkJjHMb68PQvnYlF9b7asK4TSV0SO6SdVDUt6ll9cJcUVNbyX56nNVCxdZ870OcjX69PbdMXejP6VkJZRlYiFeGC7MZ1GQ0rG0erMWnFgSdeUmErxBL2jOuwNGzTAdU6NoJgcTASafeejFSaEoCSmCtFrXb5AIOC7XtXvVTkPFUWOKJCUJabgoKjf0IcF2DKb424PaxDkve7HRshq5hIgvgZItuE7zqzAgoUN42xAOYhLl7KW9tIrLbG"
                },
                success: function (resp) {
                    // Swal.close();
                    $('#nama_sppt').val(resp.data.sppt.nm_wp_sppt)
                    $('#kd_provinsi').val(resp.data.sppt.kd_propinsi)
                    $('#kd_dati2').val(resp.data.sppt.kd_dati2)
                    $('#kd_kecamatan').val(resp.data.sppt.kd_kecamatan)
                    $('#kd_kelurahan').val(resp.data.sppt.kd_kelurahan)
                    $('#kd_blok').val(resp.data.sppt.kd_blok)
                    $('#no_urut').val(resp.data.sppt.no_urut)
                    $('#kd_jns_op').val(resp.data.sppt.kd_jns_op)
                    $('#kabupaten_kota').val(resp.data.sppt.kota_wp_sppt)
                    $('#kecamatan').val(resp.data.sppt.nm_kecamatan)
                    $('#kelurahan').val(resp.data.sppt.nm_kelurahan)
                    $('#kd_blok').val(resp.data.sppt.kd_blok)
                    $('#no_urut').val(resp.data.sppt.no_urut)
                    $('#kd_jns_op').val(resp.data.sppt.kd_jns_op)
                    $('#rt').val(resp.data.sppt.rt_op)
                    $('#rw').val(resp.data.sppt.rw_op)
                    $('#alamat').val(resp.data.sppt.jalan_op)
                    $('#pac-input').val(resp.data.sppt.jalan_op)
                    $('#kode_znt').val(resp.data.sppt.kd_znt)
                    $('#luas_tanah_lama').val(resp.data.sppt.luas_bumi_sppt)
                    $('#luas_tanah_baru').val(resp.data.sppt.luas_bumi_sppt)
                    $('#njop_tanah').val((resp.data.sppt.nilai_per_m2_tanah * 1000).toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0,
                    }))
                    $('#transaksi_tanah_permeter').val(0)
                    $('#njop_tanah_sppt').val((resp.data.sppt.nilai_per_m2_tanah * 1000))
                    $('#total_nilai_tanah').val(((resp.data.sppt.nilai_per_m2_tanah * 1000) * resp.data.sppt.luas_bumi_sppt).toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0,
                    }))
                    $('#luas_bangunan_baru').val(resp.data.sppt.luas_bng_sppt)
                    $('#luas_bangunan_lama').val(resp.data.sppt.luas_bng_sppt)
                    $('#njop_bangunan').val((resp.data.sppt.nilai_per_m2_bng * 1000).toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0,
                    }))
                    $('#transaksi_bangunan_permeter').val(0)
                    $('#njop_bangunan_sppt').val((resp.data.sppt.nilai_per_m2_bng * 1000))
                    $('#nilai_pasar_bangunan').val((resp.data.sppt.nilai_per_m2_bng * 1000).toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0,
                    }))
                    $('#total_nilai_bangunan').val(((resp.data.sppt.nilai_per_m2_bng * 1000) * resp.data.sppt.luas_bng_sppt).toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0,
                    }))
                    $('#total_nilai_pasar').val((((resp.data.sppt.nilai_per_m2_tanah * 1000) * resp.data.sppt.luas_bumi_sppt) + ((resp.data.sppt.nilai_per_m2_bng * 1000) * resp.data.sppt.luas_bng_sppt)).toLocaleString('id-ID', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0,
                    }))
                    $('#harga_transaksi').val(0)

                    // set var get nilai pasar
                    kd_kec = resp.data.sppt.kd_kecamatan;
                    kd_kel = resp.data.sppt.kd_kelurahan;
                    kd_znt = resp.data.sppt.kd_znt;
                    // end

                    getNilaiPasar(resp.data.sppt.kd_propinsi, resp.data.sppt.kd_dati2, resp.data.sppt.kd_kecamatan, resp.data.sppt.kd_kelurahan, resp.data.sppt.kd_blok, resp.data.sppt.kd_znt, $('#tahun_pajak').val(), $('#njop_tanah_sppt').val());
                    $('#next').prop('disabled', false)
                },
                error: function (resp) {
                    Swal.close()

                    if (_.has(resp.responseJSON, 'errors')) {
                        _.map(resp.responseJSON.errors, function (val, key) {
                            $('#' + key + '-error').html(val[0]).fadeIn(1000).fadeOut(40000)
                        })
                    }
                    alert(resp.responseJSON.message)
                }
            })
        }
    },
    error: function (resp) {
        Swal.close()

        if (_.has(resp.responseJSON, 'errors')) {
            _.map(resp.responseJSON.errors, function (val, key) {
                $('#' + key + '-error').html(val[0]).fadeIn(1000).fadeOut(40000)
            })
        }
        alert(resp.responseJSON.message)
    }
})
})

function getHistoryNop() {
var nop = $('#nop').val();
// var result = '';
$.ajax({
    url: "https://sipada-bphtb.bandungbaratkab.go.id/getter/get_history_nop" + '?nop=' + nop,
    method: "GET",
    dataType: 'json',
    // async : false,
    success: function (resp) {
        $('#tblHistNop').empty();
        $('#tblHistNop').append(`
                    <tr>
                        <th>NOP</th>
                        <th>Tahun</th>
                        <th>Luas Tanah SPPT Induk m<sup>2</sup></td>
                        <th>Luas Transaksi m<sup>2</sup></th>
                        <th>Status Transaksi BPHTB</th>
                    </tr>
                `)
        if (resp.status == true) {
            var total = 0;
            $.each(resp.data, function (k, v) {
                total += v.luas_tanah_baru;
                if (v.bphtb.stat_validasi == 0) {
                    status = 'Belum Selesai';
                } else {
                    status = 'Selesai';
                }
                $('#tblHistNop').append(
                    `
                    <tr>
                        <td>` + v.nop + `</td>
                        <td>` + v.tahun_pajak + `</td>
                        <td>` + $('#luas_tanah_lama').val() + `</td>
                        <td>` + v.luas_tanah_baru + `</td>
                        <td>` + status + `</td>
                    </tr>`
                )
            })
        } else {
            $('#tblHistNop').append(
                `
                <tr>
                    <td style="text-align:center" colspan="5">Tidak ada data histori transaksi di sistem</td>
                </tr>`
            )
        }
        $('#tblHistNop').append(
            `<tr>
                <td style="text-align:right" colspan="3"><b>Total</b></td>
                <td>` + total + `</td>
            </tr>`
        )
    }
})

// return result;
}

$('#sect_ajb').hide();
var switchStatus = false;
$('#switch').change(function () {
if ($(this).is(':checked')) {
    switchStatus = $(this).is(':checked');
    $('#sect_ajb').fadeIn();
} else {
    switchStatus = $(this).is(':checked');
    $('#sect_ajb').fadeOut();
}
})

function getNilaiPasar(kode_propinsi, kode_dati2, kode_kecamatan, kode_kelurahan, kode_blok, kode_znt, tahun, njop_sppt) {
$.ajax({
    url: 'https://sipada-bphtb.bandungbaratkab.go.id/getter/get_nilai_pasar',
    method: "get",
    dataType: 'json',
    data: {
        'kode_propinsi': kode_propinsi,
        'kode_dati2': kode_dati2,
        'kode_kecamatan': kode_kecamatan,
        'kode_kelurahan': kode_kelurahan,
        'kode_blok': kode_blok,
        'kode_znt': kode_znt,
        'tahun': tahun,
        'njop_sppt': njop_sppt
    },
    success: function (resp) {
        if (resp.data) {
            $('#nilaiPasar').val(resp.data);
        } else {
            $('#nilaiPasar').val(0);
        }
    },
    error: function (resp) {
        alert('Nilai pasar tidak ditemukan');
    }
});
}
</script>
@endpush

</div>
