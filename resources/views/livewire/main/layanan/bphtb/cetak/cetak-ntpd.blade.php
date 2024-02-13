<div>
    @section('title', 'NTPD ' . date('Y') . ' Nomor. ' . $pembayaran_kode_bayar )
    <div class="watermarked" data-watermark="Badan Pendapatan Daerah - bphtb.bandungkab.go.id ">
        <div class="kanan-tanggal">Soreang, {{tglIndo(date("Y-m-d"))}}</div>
        <BR>
        <TABLE class="tables table-style-one">
            <TR>
                <TD colspan="3">
                    <center>
                        <div class="judul"><u>NOMOR TANDA PEMBAYARAN DAERAH</u></div>
                    </center>
                    <br><br>
                </TD>
            </TR>
            <TR>
                <TD width="50%">
                    <div class="judul-profil">NTPD</div>
                </TD>
                <TD width="5%">
                    <div class="judul-mid-profil">:</div>
                </TD>
                <TD width="45%">
                    <div class="judul-detail-profil">2024013100061{{$pembayaran_no_registrasi}}</div>
                </TD>
            </TR>
            <TR>
                <TD width="50%">
                    <div class="judul-profil">NOP</div>
                </TD>
                <TD width="5%">
                    <div class="judul-mid-profil">:</div>
                </TD>
                <TD width="45%">
                    <div class="judul-detail-profil">{{$op_nop}}</div>
                </TD>
            </TR>
            <TR>
                <TD width="50%">
                    <div class="judul-profil">Wajib Pajak</div>
                </TD>
                <TD width="5%">
                    <div class="judul-mid-profil">:</div>
                </TD>
                <TD width="45%">
                    <div class="judul-detail-profil">{{$penerima_nama_wp}}</div>
                </TD>
            </TR>
            <TR>
                <TD width="50%">
                    <div class="judul-profil">Jenis Transaksi</div>
                </TD>
                <TD width="5%">
                    <div class="judul-mid-profil">:</div>
                </TD>
                <TD width="45%">
                    <div class="judul-detail-profil">{{$op_jenis_transaksi_id}}</div>
                </TD>
            </TR>
            <TR>
                <TD width="50%">
                    <div class="judul-profil">Tanggal Cetak</div>
                </TD>
                <TD width="5%">
                    <div class="judul-mid-profil">:</div>
                </TD>
                <TD width="45%">
                    <div class="judul-detail-profil">{{$nama_wp}}</div>
                </TD>
            </TR>
            <TR>
                <TD width="50%">
                    <div class="judul-profil">BPHTB</div>
                </TD>
                <TD width="5%">
                    <div class="judul-mid-profil">:</div>
                </TD>
                <TD width="45%">
                    <div class="judul-detail-profil">?--belum ada--?</div>
                </TD>
            </TR>
			<TR>
                <TD width="50%">
                    <div class="judul-profil">Denda</div>
                </TD>
                <TD width="5%">
                    <div class="judul-mid-profil">:</div>
                </TD>
                <TD width="45%">
                    <div class="judul-detail-profil">?--belum ada--?</div>
                </TD>
            </TR>
			<TR>
                <TD width="50%">
                    <div class="judul-profil">Jumlah BPHTB yang sudah dibayar</div>
                </TD>
                <TD width="5%">
                    <div class="judul-mid-profil">:</div>
                </TD>
                <TD width="45%">
                    <div class="judul-detail-profil">?--belum ada--?</div>
                </TD>
            </TR>
        </TABLE>
        <br><br><br>

    </div>

    <!-- <TABLE class="tables table-style-one">
        <TR>
            <TD>
                <center>
                    <img width="140px"
                        src="https://api.qrserver.com/v1/create-qr-code/?format=svg&size=100x100&data=https://ppdb.bandungkab.go.id/download-ppdb-seleksi/1234" />
                </center>
            </td>
            <TD colspan="3">
                <div class="judul">
                    Informasi, Syarat & Ketentuan
                </div>
                <div class="judul-sub" style="font-family:justify;">
                Tanda terima
            ini adalah bukti resmi bahwa pemohon telah melakukan permohonan pengajuan di BPHTB Kabupaten Bandung. Untuk melihat status permohonan silakan kunjungi website BAPENDA KBB di
            https://bapenda.bandungkab.go.id/ dengan mencantumkan No. Registrasi dan Nama Wajib Pajak.<br>
                </div>
            </TD>
            </TD>
        </TR>
    </TABLE> -->
</div>