<div class="table-responsive">



            <hr>
            <table class="table table-bordered table-responsive table-striped text-nowrap" width="100%" id="tablePerhitungan">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Luas SPPT / m<sup>2</sup></th>
                        <th class="text-center">Luas Transaksi / m<sup>2</sup></th>
                        <th class="text-center">NJOP / m<sup>2</sup></th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="30%">
                            <label>Luas Tanah (Bumi)<span class="text-danger">*</span></label>
                        </td>
                        <td>
                           <label><span class="text-dark fw-bold fs-3">{{number_format($objek_pajak->luas_tanah_lama)}}</span></label>
                        </td>
                        <td>
                            <label><span class="text-dark fw-bold fs-3">{{number_format($objek_pajak->luas_tanah_baru)}}</span></label>
                        </td>
                        <td>
                            <label><span class="text-dark fw-bold fs-3">Rp. {{number_format($objek_pajak->njop_tanah)}},-</span></label>
                        </td>
                        <td>
                            <label><span class="text-dark fw-bold fs-3">Rp. {{number_format($objek_pajak->total_nilai_tanah)}},-</span></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Luas Bangunan<span class="text-dark">*</span></label>
                        </td>
                        <td>
                                <label><span class="text-dark fw-bold fs-3">{{number_format($objek_pajak->luas_bangunan_lama)}}</span></label>
                            </td>
                            <td>
                            <label><span class="text-dark fw-bold fs-3">{{number_format($objek_pajak->luas_bangunan_baru)}}</span></label>
                        </td>
                        <td>
                                <label><span class="text-dark fw-bold fs-3">Rp. {{number_format($objek_pajak->njop_bangunan)}},-</span></label>
                        </td>
                        <td>
                            <label><span class="text-dark fw-bold fs-3">Rp. {{number_format($objek_pajak->total_nilai_bangunan)}},-</span></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label>Total Nilai NJOP ( <B><I>{{ terbilang($objek_pajak->total_nilai_pasar) }}</I></B> )</label>
                        </td>
                        <td class="text-right">
                                <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->total_nilai_pasar)}},-</span></label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label>Harga Transaksi / NPOP ( <B><I>{{ terbilang($objek_pajak->harga_transaksi) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td class="text-right">
                                <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->harga_transaksi)}},-</span></label> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label></label>
                        </td>
                        <td style="padding-left:20px;">
                            <input type="hidden" class="form-control" wire:model="ket_kelayakan" name="ket_kelayakan" id="ket_kelayakan"
                                style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:center;"
                                readonly="" value="AJUKAN PEMERIKSAAN">
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>

            {{-- Perhitungan Objek Pajak --}}
            <table class="table table-bordered table-responsive table-striped text-nowrap" width="100%" id="tablePerhitungan1">
                <tbody>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4 text-gray-600">1. Nilai Perolehan Objek Pajak (NPOP) </label>
                                <BR> ( <B><I>{{ strtoupper(terbilang($objek_pajak->nilai_npop)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->nilai_npop)}},-</span> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4 text-gray-600">2. Nilai Perolehan Objek Pajak Tidak Kena Pajak (NJOPTKP) </label>
                                <BR> ( <B><I>{{ strtoupper(terbilang($objek_pajak->nilai_njoptkp)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->nilai_njoptkp)}},-</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4 text-gray-600">3. Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP) </label>
                                <BR> ( <B><I>{{ strtoupper(terbilang($objek_pajak->nilai_npopkp)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->nilai_npopkp)}},-</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4 text-gray-600">4. Bea Perolehan Hak atas Tanah dan Bangunan yang terutang </label>
                                <BR> ( <B><I>{{ strtoupper(terbilang($objek_pajak->nilai_bphtb)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->nilai_bphtb)}},-</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4 text-gray-600">5. Pengenaan 50% karena waris/ hibah wasiat/ pemberian hak pengelolaan*) </label>
                                <BR>( <B><I>{{ strtoupper(terbilang($objek_pajak->nilai_pengenaan)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->nilai_pengenaan)}},-</span> 
                        </td>
                    </tr>
                    @if ($objek_pajak->jenis_transaksi_id==18)
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4 text-gray-600">6. APHB </label>
                                <BR> ( <B><I>{{ strtoupper(terbilang($objek_pajak->nilai_aphb)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->nilai_aphb)}},-</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4 text-gray-600">7. Bea Perolehan Hak atas Tanah dan Bangunan yang harus dibayar </label>
                                <BR> ( <B><I>{{ strtoupper(terbilang($objek_pajak->nilai_bayar_bphtb)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->nilai_bayar_bphtb)}},-</span>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4 text-gray-600">6. Bea Perolehan Hak atas Tanah dan Bangunan yang harus dibayar </label>
                                <BR> ( <B><I>{{ strtoupper(terbilang($objek_pajak->nilai_bayar_bphtb)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <label><span class="text-danger fw-bold fs-3">Rp. {{number_format($objek_pajak->nilai_bayar_bphtb)}},-</span></label>
                        </td>
                    </tr>
                    @endif
                </tbody>
                </table>


</div>