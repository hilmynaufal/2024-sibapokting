	@push('css')

	<style type="text/css">
		@media print {
			.border_thin{
				page-break-before: always;
			}
		}
		body {
			font-size: 10px;
			font-family: Arial, Helvetica, sans-serif;
			line-height: 80%;
		}

		table,
		th,
		td {
			border-collapse: collapse;
		}

		td {
			border: 1px solid black;
			border-top: none;
			border-bottom: none;
		}

		.input_nop {
			display: block;
			float: left;
			margin-right: 10px;
		}

		.textReadOnly {
			background-color: #ccc;
		}

		.text_center {
			text-align: center;
		}
		.border_thin thead tr th,
		.border_thin tbody tr td,
		.border_thin tfoot tr th {
			border-style: solid;
			border-width: 1px;
			padding: 4px;
			font-size: 12px;
		}

		td.border_thin2 thead tr th,
		td.border_thin2 tbody tr td,
		td.border_thin2 tfoot tr th {
			border-style: solid;
			border-width: 1px;
			/* padding:5px; */
		}

		.border_none thead tr th,
		.border_none tbody tr td,
		.border_none tfoot tr th {
			border: none;
		}

		.style_head_color_1 {
			background-color: #ccc;
			border-style: solid;
			border-width: 1px;
		}

		.no_border {
			border-width: 0;
		}

		.column_border tr th {
			border: solid 1px #ccc;
			font-size: 12px;
		}

		.watermarked {
			position: relative;
			overflow: hidden;
			z-index: -1;
		}

		.watermarked img {
			width: 100%;
		}

		.watermarked::before {
			position: absolute;
			top: -75%;
			left: -75%;

			display: block;
			width: 350%;
			height: 350%;

			transform: rotate(-45deg);
			content: attr(data-watermark);

			opacity: 0.7;
			line-height: 3em;
			letter-spacing: 2px;
			color: #EEE;
		}
	</style>

	@endpush


	<table width="100%" cellspacing="2" cellpading="2" style="" class='border_thin'>
		<tbody>
			<tr>
				<td width="20%" valign='top' align='center' rowspan="2">
					<b>PEMERINTAH<br />
						KABUPATEN BANDUNG <br /></b>
					<img src="{{ asset('images/logo/logo.png');}}" width='100' border='0'>
				</td>
				<td width="60%" valign='top' align='center'>
					<h1 style="font-size:14px">SURAT SETORAN PAJAK DAERAH<br />BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN
						<br />(SSPD - BPHTB)</h1>
				</td>
				<td width="20%" valign='middle' align='center' rowspan="2">
					<h2>LEMBAR 1 </h2><br><br>
					Untuk Wajib Pajak
				</td>
			</tr>
			<tr>
				<td align='center'>
					<h3 style="font-size:12px">BERFUNGSI SEBAGAI SURAT PEMBERITAHUAN OBJEK PAJAK <br />PAJAK BUMI DAN
						BANGUNAN (SPOP PBB)</h3>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" class="border_none">
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">A.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">B.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td colspan="4">
								<table width="100%" cellspacing="2" cellpading="2" style="border-collapse: collapse;">
									<thead style="background:#fff; font-size:13px;">
										<tr>
											<td align='center' width="15%" class="text_center"
												style="border: solid 1px #ccc;">Uraian</td>
											<td align='center' width="30%" class="text_center"
												style="border: solid 1px #ccc;">Luas</td>
											<td align='center' width="35%" class="text_center"
												style="border: solid 1px #ccc;">NJOP PBB /m<sup>2</sup></td>
											<td align='center' width="20%" class="text_center"
												style="border: solid 1px #ccc;">Luas x NJOP PBB /m<sup>2 </td>

										</tr>
									</thead>
									<tbody style="background:#fff; font-size:12px;">
										<tr>
											<td style="border: solid 1px #ccc;">Tanah (bumi)</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_tanah_baru}}
												m<sup>2</sup></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_tanah, 2, ".", ",")}}</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah, 2, ".", ",")}}</td>
										</tr>
										<tr>
											<td style="border: solid 1px #ccc;">Bangunan</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_bangunan_baru}}
												m<sup>2</sup>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_bangunan, 2, ".", ",")}} </td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>NJOP PBB</b>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah+$op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>Harga
													Transaksi/Nilai Pasar</b></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_harga_transaksi, 2, ".", ",")}}</span>

											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>C. </td>
							<td colspan="3">PERHITUNGAN BPHTB (Hanya diisi berdasarkan
								perhitungan Wajib Pajak)</td>
						</tr>
						<tr>
							<td colspan="4" valign='top'>
								<table width="100%">
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">1. Nilai
											Perolehan Objek Pajak (NPOP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">1</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npop, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">2. Nilai
											Perolehan Pajak Tidak Kena Pajak (NPOPTKP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">2</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_njoptkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">3. Nilai
											Perolehan Objek Pajak Kena Pajak (NPOPKP)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											angka 1 - angka 2</td>
										<td style="border: solid 1px #ccc;font-size:11px;">3</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npopkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">4. Bea
											Perolehan Hak atas Tanah dan Bangunan yang terutang</td>
										<td align='right'
											style='padding-right:10px;border: solid 1px #ccc;font-size:11px;'>
											5% x angka 3</td>
										<td style="border: solid 1px #ccc;font-size:11px;">4</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bphtb, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">5. Pengenaan
											50% karena waris/ hibah wasiat / pemberian hak pengelolaan*)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											50% x angka 4</td>
										<td style="border: solid 1px #ccc;font-size:11px;">5</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_pengenaan, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td colspan="2" style="border: solid 1px #ccc;font-size:11px;">6. Bea
											Perolehan Hak atas Tanah dan Bangunan yang harus dibayar</td>
										<td style="border: solid 1px #ccc;font-size:11px;">6</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style='border-bottom:solid 1px'></td>
							<td colspan="3" style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>D.</td>
							<td colspan="3">Jumlah Setoran berdasarkan :</td>
						</tr>
						<tr>
							<table width="100%" style="border-width: 0;">
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ x ] a. penghitungan Wajib Pajak</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] b. STPD BPHTB / SKPDKB BPHTB / SKPDKBT BPHTB *)</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Nomor: ..................</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Tanggal: ..................
									</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] c. Pengurangan dihitung sendiri menjadi: ....% berdasarkan peraturan</td>
									<td width="30%" colspan="2" style='padding-right:5px;font-size:11px; border-width: 0;'>KDH No. ..............</td>
								</tr>
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ ] d. .................</td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td style="font-size:11px; border-width: 0;">JUMLAH YANG DISETOR</td>
									<td style="font-size:11px; border-width: 0;">DIBAYAR TANGGAL</td>
								</tr>
								<tr>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>Rp. {{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</b>
									</td>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>{{tglIndo($pembayaran_tanggal_bayar)}}</b>
									</td>
								</tr>
							</table>
							<br>
							<table width="100%">
								<tr>
									<td  width="25%" align='center' valign='top'>
										tgl<br>WAJIB PAJAK/PENYETOR<br /><br /><br /><br /><br />
										Nama lengkap dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										MENGETAHUI:<br />
										PPAT/NOTARIS<br /><br /><br /><br /><br />
										KABID P2 </td>
									<td  width="25%" align='center' valign='top'>
										DITERIMA OLEH:<br />
										TEMPAT PEMBAYARAN BPHTB <br />
										Tanggal:<br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										Telah Diverifikasi:<br />
										A.n KEPALA BADAN PENDAPATAN DAERAH<br /><br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
								</tr>
							</table>
				</td>
			</tr>
		</tbody>
	</table>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<table width="100%" cellspacing="2" cellpading="2" style="" class='border_thin'>
		<tbody>
			<tr>
				<td width="20%" valign='top' align='center' rowspan="2">
					<b>PEMERINTAH<br />
						KABUPATEN BANDUNG <br /></b>
					<img src="{{ asset('images/logo/logo.png');}}" width='100' border='0'>
				</td>
				<td width="60%" valign='top' align='center'>
					<h1 style="font-size:14px">SURAT SETORAN PAJAK DAERAH<br />BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN
						<br />(SSPD - BPHTB)</h1>
				</td>
				<td width="20%" valign='middle' align='center' rowspan="2">
					<h2>LEMBAR 2 </h2><br><br>
					Untuk PPAT/Notaris sebagai arsip
				</td>
			</tr>
			<tr>
				<td align='center'>
					<h3 style="font-size:12px">BERFUNGSI SEBAGAI SURAT PEMBERITAHUAN OBJEK PAJAK <br />PAJAK BUMI DAN
						BANGUNAN (SPOP PBB)</h3>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" class="border_none">
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">A.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">B.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td colspan="4">
								<table width="100%" cellspacing="2" cellpading="2" style="border-collapse: collapse;">
									<thead style="background:#fff; font-size:13px;">
										<tr>
											<td align='center' width="15%" class="text_center"
												style="border: solid 1px #ccc;">Uraian</td>
											<td align='center' width="30%" class="text_center"
												style="border: solid 1px #ccc;">Luas</td>
											<td align='center' width="35%" class="text_center"
												style="border: solid 1px #ccc;">NJOP PBB /m<sup>2</sup></td>
											<td align='center' width="20%" class="text_center"
												style="border: solid 1px #ccc;">Luas x NJOP PBB /m<sup>2 </td>

										</tr>
									</thead>
									<tbody style="background:#fff; font-size:12px;">
										<tr>
											<td style="border: solid 1px #ccc;">Tanah (bumi)</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_tanah_baru}}
												m<sup>2</sup></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_tanah, 2, ".", ",")}}</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah, 2, ".", ",")}}</td>
										</tr>
										<tr>
											<td style="border: solid 1px #ccc;">Bangunan</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_bangunan_baru}}
												m<sup>2</sup>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_bangunan, 2, ".", ",")}} </td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>NJOP PBB</b>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah+$op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>Harga
													Transaksi/Nilai Pasar</b></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_harga_transaksi, 2, ".", ",")}}</span>

											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>C. </td>
							<td colspan="3">PERHITUNGAN BPHTB (Hanya diisi berdasarkan
								perhitungan Wajib Pajak)</td>
						</tr>
						<tr>
							<td colspan="4" valign='top'>
								<table width="100%">
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">1. Nilai
											Perolehan Objek Pajak (NPOP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">1</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npop, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">2. Nilai
											Perolehan Pajak Tidak Kena Pajak (NPOPTKP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">2</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_njoptkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">3. Nilai
											Perolehan Objek Pajak Kena Pajak (NPOPKP)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											angka 1 - angka 2</td>
										<td style="border: solid 1px #ccc;font-size:11px;">3</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npopkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">4. Bea
											Perolehan Hak atas Tanah dan Bangunan yang terutang</td>
										<td align='right'
											style='padding-right:10px;border: solid 1px #ccc;font-size:11px;'>
											5% x angka 3</td>
										<td style="border: solid 1px #ccc;font-size:11px;">4</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bphtb, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">5. Pengenaan
											50% karena waris/ hibah wasiat / pemberian hak pengelolaan*)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											50% x angka 4</td>
										<td style="border: solid 1px #ccc;font-size:11px;">5</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_pengenaan, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td colspan="2" style="border: solid 1px #ccc;font-size:11px;">6. Bea
											Perolehan Hak atas Tanah dan Bangunan yang harus dibayar</td>
										<td style="border: solid 1px #ccc;font-size:11px;">6</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style='border-bottom:solid 1px'></td>
							<td colspan="3" style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>D.</td>
							<td colspan="3">Jumlah Setoran berdasarkan :</td>
						</tr>
						<tr>
							<table width="100%" style="border-width: 0;">
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ x ] a. penghitungan Wajib Pajak</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] b. STPD BPHTB / SKPDKB BPHTB / SKPDKBT BPHTB *)</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Nomor: ..................</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Tanggal: ..................
									</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] c. Pengurangan dihitung sendiri menjadi: ....% berdasarkan peraturan</td>
									<td width="30%" colspan="2" style='padding-right:5px;font-size:11px; border-width: 0;'>KDH No. ..............</td>
								</tr>
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ ] d. .................</td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td style="font-size:11px; border-width: 0;">JUMLAH YANG DISETOR</td>
									<td style="font-size:11px; border-width: 0;">DIBAYAR TANGGAL</td>
								</tr>
								<tr>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>Rp. {{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</b>
									</td>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>{{tglIndo($pembayaran_tanggal_bayar)}}</b>
									</td>
								</tr>
							</table>
							<br>
							<table width="100%">
								<tr>
									<td  width="25%" align='center' valign='top'>
										tgl<br>WAJIB PAJAK/PENYETOR<br /><br /><br /><br /><br />
										Nama lengkap dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										MENGETAHUI:<br />
										PPAT/NOTARIS<br /><br /><br /><br /><br />
										KABID P2 </td>
									<td  width="25%" align='center' valign='top'>
										DITERIMA OLEH:<br />
										TEMPAT PEMBAYARAN BPHTB <br />
										Tanggal:<br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										Telah Diverifikasi:<br />
										A.n KEPALA BADAN PENDAPATAN DAERAH<br /><br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
								</tr>
							</table>
				</td>
			</tr>
		</tbody>
	</table>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

	<table width="100%" cellspacing="2" cellpading="2" style="" class='border_thin'>
		<tbody>
			<tr>
				<td width="20%" valign='top' align='center' rowspan="2">
					<b>PEMERINTAH<br />
						KABUPATEN BANDUNG <br /></b>
					<img src="{{ asset('images/logo/logo.png');}}" width='100' border='0'>
				</td>
				<td width="60%" valign='top' align='center'>
					<h1 style="font-size:14px">SURAT SETORAN PAJAK DAERAH<br />BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN
						<br />(SSPD - BPHTB)</h1>
				</td>
				<td width="20%" valign='middle' align='center' rowspan="2">
					<h2>LEMBAR 3 </h2><br><br>
					Untuk Kepala Kantor Bidang Pertanahan Sebagai Lampiran Permohonan Pendaaftaran
				</td>
			</tr>
			<tr>
				<td align='center'>
					<h3 style="font-size:12px">BERFUNGSI SEBAGAI SURAT PEMBERITAHUAN OBJEK PAJAK <br />PAJAK BUMI DAN
						BANGUNAN (SPOP PBB)</h3>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" class="border_none">
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">A.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">B.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td colspan="4">
								<table width="100%" cellspacing="2" cellpading="2" style="border-collapse: collapse;">
									<thead style="background:#fff; font-size:13px;">
										<tr>
											<td align='center' width="15%" class="text_center"
												style="border: solid 1px #ccc;">Uraian</td>
											<td align='center' width="30%" class="text_center"
												style="border: solid 1px #ccc;">Luas</td>
											<td align='center' width="35%" class="text_center"
												style="border: solid 1px #ccc;">NJOP PBB /m<sup>2</sup></td>
											<td align='center' width="20%" class="text_center"
												style="border: solid 1px #ccc;">Luas x NJOP PBB /m<sup>2 </td>

										</tr>
									</thead>
									<tbody style="background:#fff; font-size:12px;">
										<tr>
											<td style="border: solid 1px #ccc;">Tanah (bumi)</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_tanah_baru}}
												m<sup>2</sup></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_tanah, 2, ".", ",")}}</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah, 2, ".", ",")}}</td>
										</tr>
										<tr>
											<td style="border: solid 1px #ccc;">Bangunan</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_bangunan_baru}}
												m<sup>2</sup>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_bangunan, 2, ".", ",")}} </td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>NJOP PBB</b>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah+$op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>Harga
													Transaksi/Nilai Pasar</b></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_harga_transaksi, 2, ".", ",")}}</span>

											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>C. </td>
							<td colspan="3">PERHITUNGAN BPHTB (Hanya diisi berdasarkan
								perhitungan Wajib Pajak)</td>
						</tr>
						<tr>
							<td colspan="4" valign='top'>
								<table width="100%">
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">1. Nilai
											Perolehan Objek Pajak (NPOP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">1</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npop, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">2. Nilai
											Perolehan Pajak Tidak Kena Pajak (NPOPTKP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">2</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_njoptkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">3. Nilai
											Perolehan Objek Pajak Kena Pajak (NPOPKP)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											angka 1 - angka 2</td>
										<td style="border: solid 1px #ccc;font-size:11px;">3</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npopkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">4. Bea
											Perolehan Hak atas Tanah dan Bangunan yang terutang</td>
										<td align='right'
											style='padding-right:10px;border: solid 1px #ccc;font-size:11px;'>
											5% x angka 3</td>
										<td style="border: solid 1px #ccc;font-size:11px;">4</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bphtb, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">5. Pengenaan
											50% karena waris/ hibah wasiat / pemberian hak pengelolaan*)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											50% x angka 4</td>
										<td style="border: solid 1px #ccc;font-size:11px;">5</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_pengenaan, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td colspan="2" style="border: solid 1px #ccc;font-size:11px;">6. Bea
											Perolehan Hak atas Tanah dan Bangunan yang harus dibayar</td>
										<td style="border: solid 1px #ccc;font-size:11px;">6</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style='border-bottom:solid 1px'></td>
							<td colspan="3" style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>D.</td>
							<td colspan="3">Jumlah Setoran berdasarkan :</td>
						</tr>
						<tr>
							<table width="100%" style="border-width: 0;">
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ x ] a. penghitungan Wajib Pajak</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] b. STPD BPHTB / SKPDKB BPHTB / SKPDKBT BPHTB *)</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Nomor: ..................</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Tanggal: ..................
									</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] c. Pengurangan dihitung sendiri menjadi: ....% berdasarkan peraturan</td>
									<td width="30%" colspan="2" style='padding-right:5px;font-size:11px; border-width: 0;'>KDH No. ..............</td>
								</tr>
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ ] d. .................</td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td style="font-size:11px; border-width: 0;">JUMLAH YANG DISETOR</td>
									<td style="font-size:11px; border-width: 0;">DIBAYAR TANGGAL</td>
								</tr>
								<tr>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>Rp. {{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</b>
									</td>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>{{tglIndo($pembayaran_tanggal_bayar)}}</b>
									</td>
								</tr>
							</table>
							<br>
							<table width="100%">
								<tr>
									<td  width="25%" align='center' valign='top'>
										tgl<br>WAJIB PAJAK/PENYETOR<br /><br /><br /><br /><br />
										Nama lengkap dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										MENGETAHUI:<br />
										PPAT/NOTARIS<br /><br /><br /><br /><br />
										KABID P2 </td>
									<td  width="25%" align='center' valign='top'>
										DITERIMA OLEH:<br />
										TEMPAT PEMBAYARAN BPHTB <br />
										Tanggal:<br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										Telah Diverifikasi:<br />
										A.n KEPALA BADAN PENDAPATAN DAERAH<br /><br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
								</tr>
							</table>
				</td>
			</tr>
		</tbody>
	</table>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

	<table width="100%" cellspacing="2" cellpading="2" style="" class='border_thin'>
		<tbody>
			<tr>
				<td width="20%" valign='top' align='center' rowspan="2">
					<b>PEMERINTAH<br />
						KABUPATEN BANDUNG <br /></b>
					<img src="{{ asset('images/logo/logo.png');}}" width='100' border='0'>
				</td>
				<td width="60%" valign='top' align='center'>
					<h1 style="font-size:14px">SURAT SETORAN PAJAK DAERAH<br />BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN
						<br />(SSPD - BPHTB)</h1>
				</td>
				<td width="20%" valign='middle' align='center' rowspan="2">
					<h2>LEMBAR 4 </h2><br><br>
					Untuk BAPENDA Dalam Proses Penelitian SSPD BPHTB
				</td>
			</tr>
			<tr>
				<td align='center'>
					<h3 style="font-size:12px">BERFUNGSI SEBAGAI SURAT PEMBERITAHUAN OBJEK PAJAK <br />PAJAK BUMI DAN
						BANGUNAN (SPOP PBB)</h3>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" class="border_none">
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">A.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">B.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td colspan="4">
								<table width="100%" cellspacing="2" cellpading="2" style="border-collapse: collapse;">
									<thead style="background:#fff; font-size:13px;">
										<tr>
											<td align='center' width="15%" class="text_center"
												style="border: solid 1px #ccc;">Uraian</td>
											<td align='center' width="30%" class="text_center"
												style="border: solid 1px #ccc;">Luas</td>
											<td align='center' width="35%" class="text_center"
												style="border: solid 1px #ccc;">NJOP PBB /m<sup>2</sup></td>
											<td align='center' width="20%" class="text_center"
												style="border: solid 1px #ccc;">Luas x NJOP PBB /m<sup>2 </td>

										</tr>
									</thead>
									<tbody style="background:#fff; font-size:12px;">
										<tr>
											<td style="border: solid 1px #ccc;">Tanah (bumi)</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_tanah_baru}}
												m<sup>2</sup></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_tanah, 2, ".", ",")}}</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah, 2, ".", ",")}}</td>
										</tr>
										<tr>
											<td style="border: solid 1px #ccc;">Bangunan</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_bangunan_baru}}
												m<sup>2</sup>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_bangunan, 2, ".", ",")}} </td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>NJOP PBB</b>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah+$op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>Harga
													Transaksi/Nilai Pasar</b></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_harga_transaksi, 2, ".", ",")}}</span>

											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>C. </td>
							<td colspan="3">PERHITUNGAN BPHTB (Hanya diisi berdasarkan
								perhitungan Wajib Pajak)</td>
						</tr>
						<tr>
							<td colspan="4" valign='top'>
								<table width="100%">
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">1. Nilai
											Perolehan Objek Pajak (NPOP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">1</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npop, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">2. Nilai
											Perolehan Pajak Tidak Kena Pajak (NPOPTKP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">2</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_njoptkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">3. Nilai
											Perolehan Objek Pajak Kena Pajak (NPOPKP)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											angka 1 - angka 2</td>
										<td style="border: solid 1px #ccc;font-size:11px;">3</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npopkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">4. Bea
											Perolehan Hak atas Tanah dan Bangunan yang terutang</td>
										<td align='right'
											style='padding-right:10px;border: solid 1px #ccc;font-size:11px;'>
											5% x angka 3</td>
										<td style="border: solid 1px #ccc;font-size:11px;">4</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bphtb, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">5. Pengenaan
											50% karena waris/ hibah wasiat / pemberian hak pengelolaan*)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											50% x angka 4</td>
										<td style="border: solid 1px #ccc;font-size:11px;">5</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_pengenaan, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td colspan="2" style="border: solid 1px #ccc;font-size:11px;">6. Bea
											Perolehan Hak atas Tanah dan Bangunan yang harus dibayar</td>
										<td style="border: solid 1px #ccc;font-size:11px;">6</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style='border-bottom:solid 1px'></td>
							<td colspan="3" style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>D.</td>
							<td colspan="3">Jumlah Setoran berdasarkan :</td>
						</tr>
						<tr>
							<table width="100%" style="border-width: 0;">
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ x ] a. penghitungan Wajib Pajak</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] b. STPD BPHTB / SKPDKB BPHTB / SKPDKBT BPHTB *)</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Nomor: ..................</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Tanggal: ..................
									</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] c. Pengurangan dihitung sendiri menjadi: ....% berdasarkan peraturan</td>
									<td width="30%" colspan="2" style='padding-right:5px;font-size:11px; border-width: 0;'>KDH No. ..............</td>
								</tr>
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ ] d. .................</td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td style="font-size:11px; border-width: 0;">JUMLAH YANG DISETOR</td>
									<td style="font-size:11px; border-width: 0;">DIBAYAR TANGGAL</td>
								</tr>
								<tr>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>Rp. {{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</b>
									</td>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>{{tglIndo($pembayaran_tanggal_bayar)}}</b>
									</td>
								</tr>
							</table>
							<br>
							<table width="100%">
								<tr>
									<td  width="25%" align='center' valign='top'>
										tgl<br>WAJIB PAJAK/PENYETOR<br /><br /><br /><br /><br />
										Nama lengkap dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										MENGETAHUI:<br />
										PPAT/NOTARIS<br /><br /><br /><br /><br />
										KABID P2 </td>
									<td  width="25%" align='center' valign='top'>
										DITERIMA OLEH:<br />
										TEMPAT PEMBAYARAN BPHTB <br />
										Tanggal:<br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										Telah Diverifikasi:<br />
										A.n KEPALA BADAN PENDAPATAN DAERAH<br /><br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
								</tr>
							</table>
				</td>
			</tr>
		</tbody>
	</table>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

	<table width="100%" cellspacing="2" cellpading="2" style="" class='border_thin'>
		<tbody>
			<tr>
				<td width="20%" valign='top' align='center' rowspan="2">
					<b>PEMERINTAH<br />
						KABUPATEN BANDUNG <br /></b>
					<img src="{{ asset('images/logo/logo.png');}}" width='100' border='0'>
				</td>
				<td width="60%" valign='top' align='center'>
					<h1 style="font-size:14px">SURAT SETORAN PAJAK DAERAH<br />BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN
						<br />(SSPD - BPHTB)</h1>
				</td>
				<td width="20%" valign='middle' align='center' rowspan="2">
					<h2>LEMBAR 5 </h2><br><br>
					Untuk Bank yang ditunjuk/Bendahara Penerima sebagai Arsip
				</td>
			</tr>
			<tr>
				<td align='center'>
					<h3 style="font-size:12px">BERFUNGSI SEBAGAI SURAT PEMBERITAHUAN OBJEK PAJAK <br />PAJAK BUMI DAN
						BANGUNAN (SPOP PBB)</h3>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" class="border_none">
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">A.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">B.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td colspan="4">
								<table width="100%" cellspacing="2" cellpading="2" style="border-collapse: collapse;">
									<thead style="background:#fff; font-size:13px;">
										<tr>
											<td align='center' width="15%" class="text_center"
												style="border: solid 1px #ccc;">Uraian</td>
											<td align='center' width="30%" class="text_center"
												style="border: solid 1px #ccc;">Luas</td>
											<td align='center' width="35%" class="text_center"
												style="border: solid 1px #ccc;">NJOP PBB /m<sup>2</sup></td>
											<td align='center' width="20%" class="text_center"
												style="border: solid 1px #ccc;">Luas x NJOP PBB /m<sup>2 </td>

										</tr>
									</thead>
									<tbody style="background:#fff; font-size:12px;">
										<tr>
											<td style="border: solid 1px #ccc;">Tanah (bumi)</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_tanah_baru}}
												m<sup>2</sup></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_tanah, 2, ".", ",")}}</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah, 2, ".", ",")}}</td>
										</tr>
										<tr>
											<td style="border: solid 1px #ccc;">Bangunan</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_bangunan_baru}}
												m<sup>2</sup>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_bangunan, 2, ".", ",")}} </td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>NJOP PBB</b>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah+$op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>Harga
													Transaksi/Nilai Pasar</b></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_harga_transaksi, 2, ".", ",")}}</span>

											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>C. </td>
							<td colspan="3">PERHITUNGAN BPHTB (Hanya diisi berdasarkan
								perhitungan Wajib Pajak)</td>
						</tr>
						<tr>
							<td colspan="4" valign='top'>
								<table width="100%">
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">1. Nilai
											Perolehan Objek Pajak (NPOP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">1</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npop, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">2. Nilai
											Perolehan Pajak Tidak Kena Pajak (NPOPTKP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">2</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_njoptkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">3. Nilai
											Perolehan Objek Pajak Kena Pajak (NPOPKP)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											angka 1 - angka 2</td>
										<td style="border: solid 1px #ccc;font-size:11px;">3</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npopkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">4. Bea
											Perolehan Hak atas Tanah dan Bangunan yang terutang</td>
										<td align='right'
											style='padding-right:10px;border: solid 1px #ccc;font-size:11px;'>
											5% x angka 3</td>
										<td style="border: solid 1px #ccc;font-size:11px;">4</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bphtb, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">5. Pengenaan
											50% karena waris/ hibah wasiat / pemberian hak pengelolaan*)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											50% x angka 4</td>
										<td style="border: solid 1px #ccc;font-size:11px;">5</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_pengenaan, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td colspan="2" style="border: solid 1px #ccc;font-size:11px;">6. Bea
											Perolehan Hak atas Tanah dan Bangunan yang harus dibayar</td>
										<td style="border: solid 1px #ccc;font-size:11px;">6</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style='border-bottom:solid 1px'></td>
							<td colspan="3" style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>D.</td>
							<td colspan="3">Jumlah Setoran berdasarkan :</td>
						</tr>
						<tr>
							<table width="100%" style="border-width: 0;">
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ x ] a. penghitungan Wajib Pajak</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] b. STPD BPHTB / SKPDKB BPHTB / SKPDKBT BPHTB *)</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Nomor: ..................</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Tanggal: ..................
									</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] c. Pengurangan dihitung sendiri menjadi: ....% berdasarkan peraturan</td>
									<td width="30%" colspan="2" style='padding-right:5px;font-size:11px; border-width: 0;'>KDH No. ..............</td>
								</tr>
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ ] d. .................</td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td style="font-size:11px; border-width: 0;">JUMLAH YANG DISETOR</td>
									<td style="font-size:11px; border-width: 0;">DIBAYAR TANGGAL</td>
								</tr>
								<tr>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>Rp. {{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</b>
									</td>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>{{tglIndo($pembayaran_tanggal_bayar)}}</b>
									</td>
								</tr>
							</table>
							<br>
							<table width="100%">
								<tr>
									<td  width="25%" align='center' valign='top'>
										tgl<br>WAJIB PAJAK/PENYETOR<br /><br /><br /><br /><br />
										Nama lengkap dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										MENGETAHUI:<br />
										PPAT/NOTARIS<br /><br /><br /><br /><br />
										KABID P2 </td>
									<td  width="25%" align='center' valign='top'>
										DITERIMA OLEH:<br />
										TEMPAT PEMBAYARAN BPHTB <br />
										Tanggal:<br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										Telah Diverifikasi:<br />
										A.n KEPALA BADAN PENDAPATAN DAERAH<br /><br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
								</tr>
							</table>
				</td>
			</tr>
		</tbody>
	</table>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	
	<table width="100%" cellspacing="2" cellpading="2" style="" class='border_thin'>
		<tbody>
			<tr>
				<td width="20%" valign='top' align='center' rowspan="2">
					<b>PEMERINTAH<br />
						KABUPATEN BANDUNG <br /></b>
					<img src="{{ asset('images/logo/logo.png');}}" width='100' border='0'>
				</td>
				<td width="60%" valign='top' align='center'>
					<h1 style="font-size:14px">SURAT SETORAN PAJAK DAERAH<br />BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN
						<br />(SSPD - BPHTB)</h1>
				</td>
				<td width="20%" valign='middle' align='center' rowspan="2">
					<h2>LEMBAR 6 </h2><br><br>
					ARSIP
				</td>
			</tr>
			<tr>
				<td align='center'>
					<h3 style="font-size:12px">BERFUNGSI SEBAGAI SURAT PEMBERITAHUAN OBJEK PAJAK <br />PAJAK BUMI DAN
						BANGUNAN (SPOP PBB)</h3>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" class="border_none">
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">A.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<TR>
							<TD width="5%">
								<div class="judul-mid-profil">B.</div>
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
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td colspan="4">
								<table width="100%" cellspacing="2" cellpading="2" style="border-collapse: collapse;">
									<thead style="background:#fff; font-size:13px;">
										<tr>
											<td align='center' width="15%" class="text_center"
												style="border: solid 1px #ccc;">Uraian</td>
											<td align='center' width="30%" class="text_center"
												style="border: solid 1px #ccc;">Luas</td>
											<td align='center' width="35%" class="text_center"
												style="border: solid 1px #ccc;">NJOP PBB /m<sup>2</sup></td>
											<td align='center' width="20%" class="text_center"
												style="border: solid 1px #ccc;">Luas x NJOP PBB /m<sup>2 </td>

										</tr>
									</thead>
									<tbody style="background:#fff; font-size:12px;">
										<tr>
											<td style="border: solid 1px #ccc;">Tanah (bumi)</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_tanah_baru}}
												m<sup>2</sup></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_tanah, 2, ".", ",")}}</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah, 2, ".", ",")}}</td>
										</tr>
										<tr>
											<td style="border: solid 1px #ccc;">Bangunan</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_bangunan_baru}}
												m<sup>2</sup>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_njop_bangunan, 2, ".", ",")}} </td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>NJOP PBB</b>
											</td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_total_nilai_tanah+$op_total_nilai_bangunan, 2, ".", ",")}}
											</td>
										</tr>
										<tr>
											<td align='right' colspan="3" style="border: solid 1px #ccc;"><b>Harga
													Transaksi/Nilai Pasar</b></td>
											<td align='right' style="border: solid 1px #ccc;">Rp.
												{{number_format($op_harga_transaksi, 2, ".", ",")}}</span>

											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan='4' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>C. </td>
							<td colspan="3">PERHITUNGAN BPHTB (Hanya diisi berdasarkan
								perhitungan Wajib Pajak)</td>
						</tr>
						<tr>
							<td colspan="4" valign='top'>
								<table width="100%">
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">1. Nilai
											Perolehan Objek Pajak (NPOP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">1</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npop, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td width="78%" colspan="2" style="border: solid 1px #ccc;font-size:11px;">2. Nilai
											Perolehan Pajak Tidak Kena Pajak (NPOPTKP)</td>
										<td width="3%" style="border: solid 1px #ccc;font-size:11px;">2</td>
										<td width="20%" style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_njoptkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">3. Nilai
											Perolehan Objek Pajak Kena Pajak (NPOPKP)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											angka 1 - angka 2</td>
										<td style="border: solid 1px #ccc;font-size:11px;">3</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_npopkp, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">4. Bea
											Perolehan Hak atas Tanah dan Bangunan yang terutang</td>
										<td align='right'
											style='padding-right:10px;border: solid 1px #ccc;font-size:11px;'>
											5% x angka 3</td>
										<td style="border: solid 1px #ccc;font-size:11px;">4</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bphtb, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td style="border: solid 1px #ccc;font-size:11px;">5. Pengenaan
											50% karena waris/ hibah wasiat / pemberian hak pengelolaan*)</td>
										<td align='right' style='padding-right:5px;border: solid 1px #ccc;font-size:11px;'>
											50% x angka 4</td>
										<td style="border: solid 1px #ccc;font-size:11px;">5</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_pengenaan, 2, ".", ",")}}</td>
									</tr>
									<tr>
										<td colspan="2" style="border: solid 1px #ccc;font-size:11px;">6. Bea
											Perolehan Hak atas Tanah dan Bangunan yang harus dibayar</td>
										<td style="border: solid 1px #ccc;font-size:11px;">6</td>
										<td style="border: solid 1px #ccc;font-size:11px;" align='right'>Rp
											</b>{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style='border-bottom:solid 1px'></td>
							<td colspan="3" style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td>D.</td>
							<td colspan="3">Jumlah Setoran berdasarkan :</td>
						</tr>
						<tr>
							<table width="100%" style="border-width: 0;">
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ x ] a. penghitungan Wajib Pajak</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] b. STPD BPHTB / SKPDKB BPHTB / SKPDKBT BPHTB *)</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Nomor: ..................</td>
									<td width="15%" style="font-size:11px; border-width: 0;">Tanggal: ..................
									</td>
								</tr>
								<tr>
									<td width="70%" style="font-size:11px; border-width: 0;">[ ] c. Pengurangan dihitung sendiri menjadi: ....% berdasarkan peraturan</td>
									<td width="30%" colspan="2" style='padding-right:5px;font-size:11px; border-width: 0;'>KDH No. ..............</td>
								</tr>
								<tr>
									<td width="70%" colspan="3" style="font-size:11px; border-width: 0;">[ ] d. .................</td>
								</tr>
							</table>
							<table width="100%">
								<tr>
									<td style="font-size:11px; border-width: 0;">JUMLAH YANG DISETOR</td>
									<td style="font-size:11px; border-width: 0;">DIBAYAR TANGGAL</td>
								</tr>
								<tr>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>Rp. {{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</b>
									</td>
									<td align='center' style="border:solid 1px #ccc; font-size:16px; padding:10px;">
										<b>{{tglIndo($pembayaran_tanggal_bayar)}}</b>
									</td>
								</tr>
							</table>
							<br>
							<table width="100%">
								<tr>
									<td  width="25%" align='center' valign='top'>
										tgl<br>WAJIB PAJAK/PENYETOR<br /><br /><br /><br /><br />
										Nama lengkap dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										MENGETAHUI:<br />
										PPAT/NOTARIS<br /><br /><br /><br /><br />
										KABID P2 </td>
									<td  width="25%" align='center' valign='top'>
										DITERIMA OLEH:<br />
										TEMPAT PEMBAYARAN BPHTB <br />
										Tanggal:<br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
									<td  width="25%" align='center' valign='top'>
										Telah Diverifikasi:<br />
										A.n KEPALA BADAN PENDAPATAN DAERAH<br /><br /><br /><br /><br />
										Nama lengkap, stempel, dan tanda tangan
									</td>
								</tr>
							</table>
				</td>
			</tr>
		</tbody>
	</table>

	@push('js')

	<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script>
	<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
	<script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>

	<script>
		$(document).ready(function () {

			Array.from(document.querySelectorAll('.watermarked')).forEach(function (el) {
				el.dataset.watermark = (el.dataset.watermark + ' ').repeat(700);
			});

			$(window).load(function() {
				alert("Klik OK untuk Download Dokumen");
			ExportPdf();
			});
		});



		function ExportPdf() {
			kendo.drawing
				.drawDOM("body", {
					paperSize: "legal",
					margin: {
						top: "1cm",
						left: "1cm",
						right: "1cm",
						bottom: "1cm"
					},
					scale: 0.7,
					// height: 520,
				})
				.then(function (group) {
					kendo.drawing.pdf.saveAs(group, "SSPD - BPHTB ({{$pembayaran_kode_bayar}}).pdf")
				});
		}
	</script>


	@endpush