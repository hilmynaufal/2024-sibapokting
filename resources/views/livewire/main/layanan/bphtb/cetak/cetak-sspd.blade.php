	
	@push('css')

	<style type="text/css">
	body {
	  font-size:10px;
	  font-family: Arial, Helvetica, sans-serif;
	  line-height: 80%;
	}	
	table, th, td {
		border-collapse: collapse;
	}
	td{
		border:1px solid black;
		border-top: none;
		border-bottom: none;
	}
	.input_nop {
		display:block;
		float:left;
		margin-right:10px;	
	}
	.textReadOnly {
		background-color:#ccc;
	}
	.text_center {
		text-align:center;
	}
	.border_thin thead tr th, .border_thin tbody tr td, .border_thin tfoot tr th {
		border-style: solid;
		border-width: 1px;
		padding:4px;
		font-size:12px;
	}
	td.border_thin2 thead tr th, td.border_thin2 tbody tr td, td.border_thin2 tfoot tr th {
		border-style: solid;
		border-width: 1px;
		/* padding:5px; */
	}
	.border_none thead tr th, .border_none tbody tr td, .border_none tfoot tr th {
		border:none;
	}	
	.style_head_color_1 {
		background-color: #ccc;
		border-style: solid;
		border-width: 1px;				
	}		
	.no_border {
		border-width:0;
	}
	.column_border tr th{		
		border: solid 1px #ccc;
		font-size:12px;
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
					<b>PEMERINTAH<br/>
					KABUPATEN BANDUNG <br/></b>
					<img src="{{ asset('images/logo/logo.png');}}" width='100' border='0'>
				</td>
				<td width="60%" valign='top' align='center'>
					<h1 style="font-size:14px">SURAT SETORAN PAJAK DAERAH<br/>BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN <br/>(SSPD - BPHTB)</h1>					
				</td>			
				<td width="20%" valign='middle' align='center' rowspan="2">
					NO RESI <br/> 
					{{$pembayaran_kode_bayar}}			
				</td>
			</tr>
			<tr>
				<td align='center'><h3 style="font-size:12px">BERFUNGSI SEBAGAI SURAT PEMBERITAHUAN OBJEK PAJAK <br/>PAJAK BUMI DAN BANGUNAN (SPOP PBB)</h3></td>	
			</tr>
			<tr>
				<td colspan="3"><b>BADAN PENDAPATAN DAERAH</b></td>
			</tr>
			<tr>
				<td colspan="3"><b>PERHATIAN:</b> Bacalah petunjuk pengisian pada halaman belakang lembar ini terlebih dahulu</td>
			</tr>
			<tr>
				<td colspan="3">
					<table width="100%" class="border_none">
						<tr>
							<td width="40px">A. </td>
							<td width="250px">1. Nama Wajib Pajak </td>
							<td colspan="6">: {{strtoupper($nama_wp)}}</td>
						</tr>
						<tr>
							<td> </td>
							<td>2. NPWP </td>
							<td colspan="6">: {{strtoupper($npwp)}}</td>
						</tr>
						<tr>
							<td> </td>
							<td>3. Alamat Wajib Pajak</td>
							<td colspan="4">: {{strtoupper($alamat)}}</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td>4. Kelurahan </td>
							<td colspan="2">:  {{strtoupper($kelurahan)}}</td>
							<td>5. RT/RW: </td>
							<td> {{strtoupper($rt)}}/ {{strtoupper($rw)}}</td>
							<td width="120px">6. Kecamatan</td>
							<td> {{strtoupper($kecamatan)}}</td>
						</tr>
						<tr>
							<td></td>
							<td>5. Kota</td>
							<td>:  {{strtoupper($kota_kab)}}</td>
							<td></td>
							<td></td>
							<td></td>
							<td>7. Kode POS</td>
							<td> {{strtoupper($kode_pos)}}</td>
						</tr>
						<tr>
							<td colspan='8' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td style="height:20px;font-size:11px">B.</td>
							<td style="height:20px;font-size:11px">1. Nomor Objek Pajak (NOP) PBB</td>
							<!-- <td style="height:20px;font-size:11px" colspan='3'>: 32.06.100.002.004.0050-0</td> -->
							<td style="height:20px;font-size:11px" colspan='3'>: {{strtoupper($op_nop)}}</td>

							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px"></td>
						</tr>
						<tr>
							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px">2. Letak tanah dan atau bangunan</td>
							<td style="height:20px;font-size:11px" colspan="3">:  {{strtoupper($op_alamat)}}</td>
							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px"></td>
						</tr>
						<tr>
							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px">3. Kelurahan</td>
							<td style="height:20px;font-size:11px" colspan="3">: {{strtoupper($op_kelurahan)}}</td>
							<td style="height:20px;font-size:11px" colspan="2">4. RT/RW:</td>
							<td style="height:20px;font-size:11px">{{strtoupper($op_rt)}} / {{strtoupper($op_rw)}}</td>
						</tr>
						<tr>
							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px">5. Kecamatan</td>
							<td style="height:20px;font-size:11px" colspan="3">: {{strtoupper($op_kecamatan)}}</td>
							<td style="height:20px;font-size:11px" colspan="2">6. Kabupaten/Kota:</td>
							<td style="height:20px;font-size:11px">{{strtoupper($op_kabupaten_kota)}}</td>
						</tr>

						<tr>
							<td></td>
							<td colspan="7">
								<table width="100%" cellspacing="2" cellpading="2" style="" class='border_thin'>
									<thead>
										<tr>
											<th width="25%" width="25%" class="text_center" style="border: solid 1px #ccc;">Uraian</th>
											<th colspan="2" align='center' width="25%" width="25%" class="text_center" style="border: solid 1px #ccc;">Luas<br/>(Diisi luas tanah dan atau bangunan yang haknya diperoleh)</th>
											<th colspan="2" align='center' width="25%" class="text_center" style="border: solid 1px #ccc;">NJOP PBB /m<sup>2</sup><br>(Diisi berdasarkan SPPT PBB Tahun terjadinya perolehan hak/tahun ....)</th>	
											<th colspan="2" width="25%" width="25%" class="text_center" style="border: solid 1px #ccc;">Luas x NJOP PBB /m<sup>2 </th>	

										</tr>
									</thead>
									<tbody>
										<tr> 
											<td style="border: solid 1px #ccc;">Tanah (bumi)</td>
											<td width="3%" style="border: solid 1px #ccc;">7</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_tanah_baru}} m<sup>2</sup></td>
											<td width="3%" style="border: solid 1px #ccc;">9</td>
											<td align='right' style="border: solid 1px #ccc;"><b class="input_nop">Rp</b>{{number_format($op_njop_tanah, 2, ".", ",")}}</td>
											<td width="3%" style="border: solid 1px #ccc;">11</td>
											<td align='right' style="border: solid 1px #ccc;"><b class="input_nop">Rp</b>{{number_format($op_total_nilai_tanah, 2, ".", ",")}}</td>			
										</tr>
										<tr>
											<td style="border: solid 1px #ccc;">Bangunan</td>
											<td width="3%" style="border: solid 1px #ccc;">8</td>
											<td align='right' style="border: solid 1px #ccc;">{{$op_luas_bangunan_baru}} m<sup>2</sup></td>
											<td width="3%" style="border: solid 1px #ccc;">10</td>
											<td align='right' style="border: solid 1px #ccc;"><b class="input_nop">Rp</b>{{number_format($op_njop_bangunan, 2, ".", ",")}}										</td>
											<td width="3%" style="border: solid 1px #ccc;">12</td>
											<td align='right' style="border: solid 1px #ccc;"><b class="input_nop">Rp</b>{{number_format($op_total_nilai_bangunan, 2, ".", ",")}}</td>			
										</tr>
										<tr>
											<td style="border-width:0"></td>
											<td style="border-width:0"></td>
											<td style="border-width:0"></td>
											<td style="border-width:0"></td>
											<td style="border-width:0">NJOP PBB :</td>
											<td style="border: solid 1px #ccc;">13</td>
											<td align='right' style="border: solid 1px #ccc;"><b class="input_nop">Rp</b>{{number_format($op_total_nilai_tanah+$op_total_nilai_bangunan, 2, ".", ",")}}										</td>			
										</tr>
										<tr>
											<td style="border-width:0"></td>
											<td style="border-width:0"></td>
											<td style="border-width:0"></td>
											<td style="border-width:0">14.</td>
											<td style="border-width:0">Harga Transaksi/Nilai Pasar</td>
											<td align='right' style="border: solid 1px #ccc;" colspan="2"><b class="input_nop">Rp</b>{{number_format($op_harga_transaksi, 2, ".", ",")}}</span>

											</td>			
										</tr>
									</tbody>
								</table>		
							</td>
						</tr>
						<tr>
							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px" colspan='7'>15. Jenis Perolehan hak atas tanah dan atau bangunan: 
							<b>{{$op_jenis_transaksi_id}}</b>
							</td>
						</tr>
						<tr>
							<td style="height:20px;font-size:11px"></td>
							<td style="height:20px;font-size:11px" colspan='7'>16. Nomor Sertifikat: {{$op_no_ajb_baru}}</td>
						</tr>
						<tr>
							<td colspan='8' style='border-bottom:solid 1px'></td>
						</tr>
						<tr>
							<td  style='border-bottom:solid 1px'>C. </td>
							<td colspan="7" style='border-bottom:solid 1px'>PERHITUNGAN BPHTB (Hanya diisi berdasarkan perhitungan Wajib Pajak)</td>	
						</tr>
						<tr>
							<td></td>
							<td colspan="7" valign='top'>
								<table width="100%">
									<tr>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">1. Nilai Perolehan Objek Pajak (NPOP)</td>
										<td width="150px" style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;"></td>
										<td width="30px" style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">1</td>
										<td width="220px" style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;" align='right'>Rp </b>{{number_format($op_nilai_npop, 2, ".", ",")}}</td>		
									</tr>				
									<tr>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">2. Nilai Perolehan Pajak Tidak Kena Pajak (NPOPTKP)</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;"></td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">2</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;" align='right'>Rp </b>{{number_format($op_nilai_njoptkp, 2, ".", ",")}}</td>
									</tr>				
									<tr>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">3. Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP)</td>
										<td align='right' style='padding-right:5px;border-bottom: solid 1px #ccc;font-size:11px;height:20px;'>angka 1 - angka 2</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">3</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;" align='right'>Rp </b>{{number_format($op_nilai_npopkp, 2, ".", ",")}}</td>	
									</tr>				
									<tr>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">4. Bea Perolehan Hak atas Tanah dan Bangunan yang terutang</td>
										<td align='right' style='padding-right:10px;border-bottom: solid 1px #ccc;font-size:11px;height:20px;'>5% x angka 3</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">4</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;" align='right'>Rp </b>{{number_format($op_nilai_bphtb, 2, ".", ",")}}</td>
									</tr>				
									<tr>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">5. Pengenaan 50% karena waris/ hibah wasiat / pemberian hak pengelolaan*)</td>
										<td align='right' style='padding-right:5px;border-bottom: solid 1px #ccc;font-size:11px;height:20px;'>50% x angka 4</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">5</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;" align='right'>Rp </b>{{number_format($op_nilai_pengenaan, 2, ".", ",")}}</td>
									</tr>				
									<tr>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">6. Bea Perolehan Hak atas Tanah dan Bangunan yang harus dibayar</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;"></td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;">6</td>
										<td style="border-bottom: solid 1px #ccc;font-size:11px;height:20px;" align='right'>Rp </b>{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</td>
									</tr>								
								</table>
							</td>	
						</tr>
						<tr>
							<td style='border-bottom:solid 1px'></td>
							<td colspan="7" style='border-bottom:solid 1px'></td>	
						</tr>
						<tr>
							<td>D.</td>
							<td colspan="7">JUMLAH SETORAN</td>	
						</tr>
						<tr>
							<td></td>
							<td colspan="7">
								<table width="100%">	
									<tr>
										<tr>
											<td valign='top'>JUMLAH YANG DISETOR (Dengan Angka) <br/>
											<span style="display:block; border:solid 1px #ccc;padding:5px; font-size:18px;background-color:#ccc">Rp </b>{{number_format($op_nilai_bayar_bphtb, 2, ".", ",")}}</span>
											</td>
											<td valign='top'>Dengan Huruf <br/>
												<span style="display:block; border:solid 1px #ccc;padding:1px; margin-text=2px; font-size:14px;background-color:#ccc">{{ strtoupper(terbilang($this->op_nilai_bayar_bphtb)) }}</td>
										</tr>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style='border-bottom:solid 1px'></td>
							<td colspan="7" style='border-bottom:solid 1px'></td>	
						</tr>
						<tr>
							<td colspan="8">
								<table width="100%">
									<tr>
										<td align='center' valign='top'>
											tgl<br>WAJIB PAJAK/PENYETOR<br/><br/><br/><br/><br/>
											Nama lengkap dan tanda tangan
										</td>
										<td align='center' valign='top'>
											MENGETAHUI:<br/>
											PPAT/NOTARIS<br/><br/><br/><br/><br/>
											KABID P2										</td>
										<td align='center' valign='top'>
											DITERIMA OLEH:<br/>
											TEMPAT PEMBAYARAN BPHTB <br/>
											Tanggal:<br/><br/><br/><br/> 
											Nama lengkap, stempel, dan tanda tangan	
										</td>
										<td align='center' valign='top'>
											Telah Diverifikasi:<br/>
											A.n KEPALA BADAN PENDAPATAN DAERAH<br/><br/><br/><br/><br/>	
											Nama lengkap, stempel, dan tanda tangan		
										</td>
									</tr>		
								</table>		
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
		$(document).ready(function() {

			Array.from(document.querySelectorAll('.watermarked')).forEach(function(el) {
				el.dataset.watermark = (el.dataset.watermark + ' ').repeat(700);
			});

			$(window).load(function() {
				alert("Klik OK untuk Download Dokumen");
			ExportPdf();
			});
		});



		function ExportPdf(){
		kendo.drawing
		.drawDOM("body",
		{
			paperSize: "legal",
			margin: { top: "1cm", left: "0.5", right: "0.5", bottom: "1cm" },
			scale: 0.7,
			// height: 520,
		})
		.then(function(group){
			kendo.drawing.pdf.saveAs(group, "SSPD - BPHTB ({{$pembayaran_kode_bayar}}).pdf")
		});
		}
	</script>


	@endpush