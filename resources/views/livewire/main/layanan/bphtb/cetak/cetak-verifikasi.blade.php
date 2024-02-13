    @section('title', 'Verifikasi ' . date('Y') . ' Nomor. ' . $pembayaran_kode_bayar )

    <div id="myCanvas" style="width: 680px;margin:0px auto;">
    	<div style="text-align: center;">
    		<div class="header-kiri">
    			<center>
    				<img src="{{ asset('images/logo/logo.png');}}" style="padding:0px 5px;width:110px;" />
    			</center>
    		</div>
    		<div class="header-kanan">
    			<div class="konten-header-kanan">
    				<center>
    					<H2 style="font-size: 18px; margin-bottom: 14px; margin-top: 14px; ">NOTA VERIFIKASI</H2>
    				</center>
    				<center>
    					<H2 style="font-size: 18px; margin-bottom: 14px;">BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN</H2>
    				</center>
    				<center>
    					<h2 style="font-size: 18px; margin-bottom: 14px;">NO REGISTRASI :
    						{{$pembayaran_no_registrasi}} / KODE BAYAR : {{$pembayaran_kode_bayar}} </h2>
    				</center>
    				<center>
    					<h2 style="font-size: 18px; margin-bottom: 14px; font-weight: 500;">JENIS TRANSAKSI : {{strtoupper($op_jenis_transaksi_id)}}</h2>
    				</center>
    				<center>
    					<h2 style="font-size: 18px; margin-bottom: 14px; font-weight: 500;">TANGGAL TERBIT : {{strtoupper(tglIndo(date("Y-m-d")))}}</h2>
    				</center>
    			</div>

    		</div>
    	</div>
    	</center>

    	<img src="{{ asset('images/logo/line.png');}}" style="width: 680px;" />

    	<div class="content" style="text-align: left;">
    		<div class="watermarked" data-watermark="Badan Pendapatan Daerah - bphtb.bandungkab.go.id ">
    			<BR>
    			<TABLE class="tables table-style-one">
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil">a.</div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">1. Nama Wajib Pajak</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($nama_wp)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">2. NIK</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($nik)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">3. Alamat Wajib Pajak</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($alamat)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">4. RT/RW</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($rt)}}/ {{strtoupper($rw)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">5. Kelurahan / Desa</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($kelurahan)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">6. Kecamatan</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($kecamatan)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">7. Kabupaten / Kota</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($kota_kab)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%" style="padding-top:5px;">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    					</TD>
    					<TD width="5%">
    					</TD>
    					<TD width="50%">
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil">b.</div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">1. Nomor Objek Pajak</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($op_nop)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">2. Letak Tanah dan Bangunan</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($op_alamat)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">3. RT/ RW</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($op_rt)}}/ {{strtoupper($op_rw)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">4. Kelurahan / Desa</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($op_kelurahan)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">5. Kecamatan</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($op_kecamatan)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">6. Kabupaten / Kota</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil">{{strtoupper($op_kabupaten_kota)}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="5%">
    						<div class="judul-mid-profil"></div>
    					</TD>
    					<TD width="40%">
    						<div class="judul-profil">7. Dokumen Pendukung</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">:</div>
    					</TD>
    					<TD width="50%">
    						<div class="judul-detail-profil"> {{$op_no_ajb_baru}}</div>
    					</TD>
    				</TR>
    			</TABLE>
				<p>c. Penghitungan NJOP PBB</p>
    			<table width="100%" cellspacing="2" cellpading="2" style="border-collapse: collapse;">
    				<thead style="background:#fff; font-size:13px;">
    					<tr>
    						<td align='center' width="15%" class="text_center" style="border: solid 1px #ccc;">Uraian</td>
    						<td align='center' width="30%" class="text_center" style="border: solid 1px #ccc;">Luas<br />(Diisi luas tanah dan atau bangunan yang haknya diperoleh)</td>
    						<td align='center' width="35%" class="text_center" style="border: solid 1px #ccc;">NJOP PBB /m<sup>2</sup><br>(Diisi berdasarkan SPPT PBB Tahun terjadinya perolehan hak/tahun ....)</td>
    						<td align='center' width="20%" class="text_center" style="border: solid 1px #ccc;">Luas x NJOP PBB /m<sup>2 </td>

    					</tr>
    				</thead>
    				<tbody style="background:#fff; font-size:12px;">
    					<tr>
    						<td style="border: solid 1px #ccc;">Tanah (bumi)</td>
    						<td align='right' style="border: solid 1px #ccc;">{{$op_luas_tanah_baru}} m<sup>2</sup></td>
    						<td align='right' style="border: solid 1px #ccc;">Rp. {{number_format($op_njop_tanah, 2, ".", ",")}}</td>
    						<td align='right' style="border: solid 1px #ccc;">Rp. {{number_format($op_total_nilai_tanah, 2, ".", ",")}}</td>
    					</tr>
    					<tr>
    						<td style="border: solid 1px #ccc;">Bangunan</td>
    						<td align='right' style="border: solid 1px #ccc;">{{$op_luas_bangunan_baru}} m<sup>2</sup>
    						</td>
    						<td align='right' style="border: solid 1px #ccc;">Rp. {{number_format($op_njop_bangunan, 2, ".", ",")}} </td>
    						<td align='right' style="border: solid 1px #ccc;">Rp. {{number_format($op_total_nilai_bangunan, 2, ".", ",")}}
    						</td>
    					</tr>
    					<tr>
    						<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>NJOP PBB</b></td>
    						<td align='right' style="border: solid 1px #ccc;">Rp. {{number_format($op_total_nilai_tanah+$op_total_nilai_bangunan, 2, ".", ",")}}
    						</td>
    					</tr>
    					<tr>
    						<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>Harga Transaksi/Nilai Pasar</b></td>
    						<td align='right' style="border: solid 1px #ccc;">Rp. {{number_format($op_harga_transaksi, 2, ".", ",")}}</span>

    						</td>
    					</tr>
    				</tbody>
    			</table>
				<p>Jumlah Perolehan hak atas dan atau bangunan</p>
				
    			<TABLE class="tables table-style-one">
    				<TR>
    					<TD colspan="4" width="100%">
    						<div class="judul-mid-profil">PENGHITUNGAN BPHTB</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="70%">
    						<div class="judul-mid-profil">Nilai Perolehan Objek Pajak (NPOP)</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-profil"></div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">Rp.</div>
    					</TD>
    					<TD width="20%">
    						<div class="judul-detail-profil">{{number_format($op_nilai_npop, 2, ".", ",")}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="70%">
    						<div class="judul-mid-profil">Nilai Perolehan Objek Pajak Tidak Kena Pajak (NPOPTKP)</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-profil"></div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">Rp.</div>
    					</TD>
    					<TD width="20%">
    						<div class="judul-detail-profil">{{number_format($op_nilai_njoptkp, 2, ".", ",")}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="70%">
    						<div class="judul-mid-profil">Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP) </div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-profil"></div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">Rp.</div>
    					</TD>
    					<TD width="20%">
    						<div class="judul-detail-profil">{{number_format($op_nilai_npopkp, 2, ".", ",")}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="70%">
    						<div class="judul-mid-profil">Bea Perolehan Hak atas Tanah dan Bangunan yang terutang</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-profil"></div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">Rp.</div>
    					</TD>
    					<TD width="20%">
    						<div class="judul-detail-profil">?-----?</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="70%">
    						<div class="judul-mid-profil">Bea Perolehan Hak atas Tanah dan Bangunan potongan</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-profil"></div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">Rp.</div>
    					</TD>
    					<TD width="20%">
    						<div class="judul-detail-profil">{{number_format($op_nilai_pengenaan, 2, ".", ",")}}</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="70%">
    						<div class="judul-mid-profil">Sanksi Administrasi</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-profil"></div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">Rp.</div>
    					</TD>
    					<TD width="20%">
    						<div class="judul-detail-profil">?-----?</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="70%">
    						<div class="judul-mid-profil">Bea Perolehan Hak atas Tanah dan Bangunan yang sudah dibayar</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-profil"></div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">Rp.</div>
    					</TD>
    					<TD width="20%">
    						<div class="judul-detail-profil">?-----?</div>
    					</TD>
    				</TR>
    				<TR>
    					<TD width="70%">
    						<div class="judul-mid-profil">Bea Perolehan Hak atas Tanah dan Bangunan yang harus dibayar</div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-profil"></div>
    					</TD>
    					<TD width="5%">
    						<div class="judul-mid-profil">Rp.</div>
    					</TD>
    					<TD width="20%">
    						<div class="judul-detail-profil">{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</div>
    					</TD>
    				</TR>
    			</TABLE>
				<p><b>Catatan</b> : <i>Nota ini bukan bukti pembayaran. Nota akan menjadi expired jika dalam 3 hari tidak dibayarkan. (Perbup No. 18
Tahun 2019 Pasal 7 ayat 1 "Wajib pajak melakukan pembayaran BPHTB terhutang dengan menggunakan SSPD BPHTB
paling lambat 3 hari setelah mendapatkan persetujuan nota verifikasi")</i></p>
    		</div>

    		<TABLE class="tables table-style-one">
    			<TR>
    				<td width="50%"></td>
    				<td width="50%" style="border: solid 1px #ccc;">
					Ditandatangani oleh:<br/>
					KEPALA SUB BIDANG PENETAPAN<br/>
					VERIFIKASI PBB DAN BPHTB<br/><br/><br/><br/><br/>
					Nama lengkap, stempel, dan tanda tangan	</td>
    			</TR>
    		</TABLE>

    	</div>

    </div>