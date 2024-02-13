<div>
    <div class="row">
        <div class="col-md-6">
            <table class="table mt-5">
                <tbody>
                    <tr>
                        <th>No. Registrasi</th>
                        <td> : </td>
                        <td>{{empty($pembayaran_pajak->no_registrasi) ? '-' : $pembayaran_pajak->no_registrasi}}</td>
                    </tr>
                    <tr>
                        <th>Tgl. Pengajuan</th>
                        <td> : </td>
                        <td>{{empty($pembayaran_pajak->tanggal_pendaftaran) ? '-' : tglIndo($pembayaran_pajak->tanggal_pendaftaran)}}</td>
                    </tr>
                    <tr>
                        <th>Tahun Transaksi</th>
                        <td> : </td>
                        <td>{{empty($pembayaran_pajak->tanggal_pendaftaran) ? '-' : tglIndoTahun($pembayaran_pajak->tanggal_pendaftaran)}}</td>
                    </tr>
                    <tr>
                        <th>Posisi Berkas</th>
                        <td> : </td>
                        <td>{!! empty($pembayaran_pajak->id_bphtb) ? '-' : statusBerkasKb($pembayaran_pajak->id_bphtb) !!}</td>
                    </tr>
                    <tr>
                        <th>NOP</th>
                        <td> : </td>
                        <td>{{$objek_pajak->kd_propinsi}}.{{$objek_pajak->kd_dati2}}.{{$objek_pajak->kd_kecamatan}}.{{$objek_pajak->kd_kelurahan}}
                            .{{$objek_pajak->kd_blok}}-{{$objek_pajak->no_urut}}.{{$objek_pajak->kd_jns_op}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table mt-5">
                <tbody>
                    <tr>
                        <th>Jenis Transaksi</th>
                        <td> : </td>
                        <td>{{ $objek_pajak->jenisPerolehan->nm_jenis_transaksi}}</td>
                    </tr>
                    <tr>
                        <th>Nota Verifikasi</th>
                        <td> : </td>
                        <td>
                            @if($pembayaran_pajak)
                            <a target="_blank" 
                            href="{{route('bphtb.cetak.verifikasi', [Crypt::encrypt($pembayaran_pajak->id_bphtb)])}}"><i
                            class="bi bi-file-earmark-pdf-fill"></i> Nota Verifikasi</a>
                            @else
                                <div class="text-red">Belum generate pembayaran</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dok. SSPD</th>
                        <td> : </td>
                        <td>
                            @if($pembayaran_pajak)
                            <a target="_blank"
                            href="{{route('bphtb.cetak.sspd', [Crypt::encrypt($pembayaran_pajak->id_bphtb)])}}"><i
                                    class="bi bi-file-earmark-pdf-fill"></i> SSPD</a>
                            @else
                                <div class="text-red">Belum generate pembayaran</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dok. SSPDKB</th>
                        <td> : </td>
                        <td>
                            @if($pembayaran_pajak)
                            <a target="_blank"
                            href="{{route('bphtb.cetak.sspd', [Crypt::encrypt($pembayaran_pajak->id_bphtb)])}}"><i
                                    class="bi bi-file-earmark-pdf-fill"></i> SSPDKB</a>
                            @else
                                <div class="text-red">Belum generate pembayaran</div>
                            @endif
                        </td>
                    </tr>                    
                    <tr>
                        <th>NTPD</th>
                        <td> : </td>
                        <td>
                            @if($pembayaran_pajak)
                            <a target="_blank"
                            href="{{route('bphtb.cetak.ntpd', [Crypt::encrypt($pembayaran_pajak->id_bphtb)])}}"><i
                                    class="bi bi-file-earmark-pdf-fill"></i> NTPD </a>
                            @else
                                <div class="text-red">Belum generate pembayaran</div>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
