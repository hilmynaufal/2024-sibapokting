<div>
    @section('title')
    3. Informasi Objek Pajak
    @stop
    @section('menu')
    Layanan > BPHTB > <b>3. Informasi Objek Pajak</b>
    @stop
    <fieldset>
        <form wire:submit="create">
  
            <div class="form-group mb-3 mt-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">NOP<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-5">

                        <input type="text" class="form-control input_nop" wire:model.live="kd_propinsi" id="kd_propinsi" name="kd_propinsi" maxlength="2" value="32" readonly="readonly">
                        <input type="text" class="form-control input_nop" wire:model.live="kd_dati2" id="kd_dati2" name="kd_dati2" maxlength="2" value="06" readonly="readonly">
                        <input type="text" class="form-control input_nop" wire:model.live="kd_kecamatan" id="kd_kecamatan" name="kd_kecamatan" maxlength="3" value="">
                        <input type="text" class="form-control input_nop" wire:model.live="kd_kelurahan" id="kd_kelurahan" name="kd_kelurahan" maxlength="3" value="">
                        <input type="text" class="form-control input_nop" wire:model.live="kd_blok" id="kd_blok" name="kd_blok" maxlength="3" value="">
                        <input type="text" class="form-control input_nop" wire:model.live="no_urut" id="no_urut" name="no_urut" maxlength="4" value="">
                        <input type="text" class="form-control input_nop" wire:model.live="kd_jns_op" id="kd_jns_op" name="kd_jns_op" maxlength="1" value="">

                    </div>
                    <div class="col-md-5">
                        <input type="hidden" class="form-control " wire:model="nop" name="nop" id="nop" value="">
                    </div>
                    {{-- 
                    <div class="col-md-1">
                        <label class="form-label">Tahun Pajak<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control " wire:model="tahun_pajak" name="tahun_pajak" id="tahun_pajak" value="">
                    </div> 
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success btn-cek-nop">Proses</button>
                    </div> --}}
                </div>
            </div>

            <div id="histNop" class="row p-4" style="display: none">
                <div class="card border border-danger">
                    <div class="card-header">
                        <h3 class="card-title">Histori Transaksi Peralihan</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped" id="tblHistNop">

                        </table>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Nama SPPT</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" wire:model="nama_sppt" name="nama_sppt" id="nama_sppt" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Kabupaten/Kota</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" class="form-control" wire:model="kabupaten_kota" name="kabupaten_kota" id="kabupaten_kota" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Kecamatan</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" wire:model="kecamatan" name="kecamatan" id="kecamatan" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Desa/Kelurahan</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" wire:model="kelurahan" name="kelurahan" id="kelurahan" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">RT/RW</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="RT" wire:model="rt" name="rt" id="rt" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="RW" wire:model="rw" name="rw" id="rw" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Alamat Objek Pajak</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" wire:model="alamat" name="alamat" id="alamat" readonly>
                    </div>
                </div>
            </div>
            {{-- 
            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Kode ZNT</label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" wire:model="kode_znt" name="kode_znt" id="kode_znt" readonly>
                    </div> 
                </div>
            </div>
            --}}

       


            <hr>
            <table class="table table-bordered table-responsive table-striped text-nowrap" width="100%">
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
                            <input type="number" class="form-control" wire:model.live="luas_tanah_lama" name="luas_tanah_lama" id="luas_tanah_lama"
                                readonly>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" wire:model.live="luas_tanah_baru" name="luas_tanah_baru" id="luas_tanah_baru"
                                required>
                        </td>
                        <td>

                            <input type="hidden" wire:model="nilai_pasar_tanah" name="nilai_pasar_tanah" id="nilaiPasar">
                            <input type="hidden" wire:model="njop_tanah_sppt" name="njop_tanah_sppt" id="njop_tanah_sppt">
                            <input type="hidden" wire:model="transaksi_tanah_permeter" name="transaksi_tanah_permeter" id="transaksi_tanah_permeter">
                            <input type="text" class="form-control" wire:model="njop_tanah" name="njop_tanah" id="njop_tanah" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control" wire:model="total_nilai_tanah" name="total_nilai_tanah" id="total_nilai_tanah"
                                readonly>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Luas Bangunan<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" class="form-control" wire:model="luas_bangunan_lama" name="luas_bangunan_lama" id="luas_bangunan_lama"
                                readonly="">
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" wire:model.live="luas_bangunan_baru" name="luas_bangunan_baru"
                                id="luas_bangunan_baru" required="">
                        </td>
                        <td>
                            <input type="hidden" wire:model="nilai_pasar_bangunan" name="nilai_pasar_bangunan" id="nilai_pasar_bangunan" value="10000000">
                            <input type="hidden" wire:model="njop_bangunan_sppt" name="njop_bangunan_sppt" id="njop_bangunan_sppt">
                            <input type="hidden" wire:model="transaksi_bangunan_permeter" name="transaksi_bangunan_permeter" id="transaksi_bangunan_permeter">
                            <input type="text" min="1" class="form-control" wire:model="njop_bangunan" name="njop_bangunan" id="njop_bangunan"
                                readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control" wire:model="total_nilai_bangunan" name="total_nilai_bangunan"
                                id="total_nilai_bangunan" readonly="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <h5> Data Tanah dan Bangunan yang dimasukkan harus sesuai dengan bukti kepemilikan!
                                ( Sertifikat, Akta / Warkah / SK BPN )</h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label>Total Nilai NJOP ( <B><I>{{ $this->total_nilai_pasar_terbilang }}</I></B> )</label>
                        </td>
                        <td style="padding-left:20px;">
                            <input type="number" class="form-control" wire:model.live="total_nilai_pasar" name="total_nilai_pasar" id="total_nilai_pasar"
                                readonly="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label>Harga Transaksi / NPOP ( <B><I>{{ $this->total_nilai_transaksi_terbilang }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td style="padding-left:20px;">
                            <input type="number" min="0" class="form-control" wire:model.live="harga_transaksi" name="harga_transaksi" id="harga_transaksi"
                                onchange="TentukanNPOP()" onblur="TentukanNPOP()" required="">
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

            <div class="form-group mb-5 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Jenis Perolehan<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-10">
                        <div wire:ignore>
                        <select x-init="$($el).select2({ placeholder: '-- Pilih Jenis Transaksi --', });
                                $($el).on('change', function() {
                                    $wire.set('jenis_transaksi_id', $($el).val());
                                })" wire:model.live="jenis_transaksi_id"  name="jenis_transaksi_id" id="jenis_transaksi_id" class="form-control form-control-lg form-select-solid @error('jenis_transaksi_id') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Transaksi --</option>
                            @foreach($listJenisTransaksi as $transaksi)
                                <option value="{{$transaksi->id}}">{{strtoupper($transaksi->nm_jenis_transaksi)}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div>
                    </div>
                </div>
            </div>
            </div>

            <HR>

            <div wire:loading class="col-md-12">
            @livewire('main.layanan.bphtb.form.placeholder')
            </div>

            <div wire:loading.remove>

            <table class="table table-bordered table-responsive table-striped text-nowrap" width="100%">
                <tbody>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4">1. Nilai Perolehan Objek Pajak (NPOP) </label>
                                <BR> <label><span class="text-danger fw-bold bd-highlight">Rp. {{number_format($this->nilai_npop)}},-</span> ( <B><I>{{ strtoupper(terbilang($this->nilai_npop)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" readonly wire:model.live="nilai_npop" name="nilai_npop" id="nilai_npop" required="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4">2. Nilai Perolehan Objek Pajak Tidak Kena Pajak (NJOPTKP) </label>
                                <BR> <label><span class="text-danger fw-bold bd-highlight">Rp. {{number_format($this->nilai_njoptkp)}},-</span> ( <B><I>{{ strtoupper(terbilang($this->nilai_njoptkp)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" readonly wire:model.live="nilai_njoptkp" name="nilai_njoptkp" id="nilai_njoptkp" required="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4">3. Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP) </label>
                                <BR> <label><span class="text-danger fw-bold bd-highlight">Rp. {{number_format($this->nilai_npopkp)}},-</span> ( <B><I>{{ strtoupper(terbilang($this->nilai_npopkp)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" readonly wire:model.live="nilai_npopkp" name="nilai_npopkp" id="nilai_npopkp" required="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4">4. Bea Perolehan Hak atas Tanah dan Bangunan yang terutang </label>
                                <BR> <label><span class="text-danger fw-bold bd-highlight">Rp. {{number_format($this->nilai_bphtb)}},-</span> ( <B><I>{{ strtoupper(terbilang($this->nilai_bphtb)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" readonly wire:model.live="nilai_bphtb" name="nilai_bphtb" id="nilai_bphtb" required="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4">5. Pengenaan 50% karena waris/ hibah wasiat/ pemberian hak pengelolaan*) </label>
                                <BR> <label><span class="text-danger fw-bold bd-highlight">Rp. {{number_format($this->nilai_pengenaan)}},-</span> ( <B><I>{{ strtoupper(terbilang($this->nilai_pengenaan)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" readonly wire:model.live="nilai_pengenaan" name="nilai_pengenaan" id="nilai_pengenaan" required="">
                        </td>
                    </tr>
                    @if ($this->jenis_transaksi_id==18)
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4">6. APHB </label>
                                <BR> <label><span class="text-danger fw-bold bd-highlight">Rp. {{number_format($this->nilai_aphb)}},-</span> ( <B><I>{{ strtoupper(terbilang($this->nilai_aphb)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" readonly wire:model.live="nilai_aphb" name="nilai_aphb" id="nilai_aphb" required="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4">7. Bea Perolehan Hak atas Tanah dan Bangunan yang harus dibayar </label>
                                <BR> <label><span class="text-danger fw-bold bd-highlight">Rp. {{number_format($this->nilai_bayar_bphtb)}},-</span> ( <B><I>{{ strtoupper(terbilang($this->nilai_bayar_bphtb)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" readonly wire:model.live="nilai_bayar_bphtb" name="nilai_bayar_bphtb" id="nilai_bayar_bphtb" required="">
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="4" class="text-right">
                            <label class="fs-4">6. Bea Perolehan Hak atas Tanah dan Bangunan yang harus dibayar </label>
                                <BR> <label></label><span class="text-danger fw-bold bd-highlight">Rp. {{number_format($this->nilai_bayar_bphtb)}},-</span> ( <B><I>{{ strtoupper(terbilang($this->nilai_bayar_bphtb)) }}</I></B> )<span class="text-danger">*</span></label>
                        </td>
                        <td>
                            <input type="number" min="0" class="form-control" readonly wire:model.live="nilai_bayar_bphtb" name="nilai_bayar_bphtb" id="nilai_bayar_bphtb" required="">
                        </td>
                    </tr>
                    @endif
                </tbody>
                </table>

            </div>

            <hr>

            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">Jenis Kepemilikan<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div wire:ignore>
                            <select x-init="$($el).select2({ placeholder: '-- Pilih Jenis Kepemilikan --', });
                                    $($el).on('change', function() {
                                        $wire.set('jenis_hak_tanah_id', $($el).val());
                                    })" wire:model="jenis_hak_tanah_id"  name="jenis_hak_tanah_id" id="jenis_hak_tanah_id" class="form-control form-control-lg form-select-solid @error('jenis_hak_tanah_id') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kemepilikan --</option>
                                @foreach($listJenisKepemilikan as $item)
                                    <option value="{{$item->id}}">{{strtoupper($item->nm_hak_tanah)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Jenis Dok. Tanah<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div wire:ignore>
                            <select x-init="$($el).select2({ placeholder: '-- Pilih Jenis Dokumen Tanah --', });
                                    $($el).on('change', function() {
                                        $wire.set('jenis_dok_tanah_id', $($el).val());
                                    })" wire:model="jenis_dok_tanah_id"  name="jenis_dok_tanah_id" id="jenis_dok_tanah_id" class="form-control form-control-lg form-select-solid @error('jenis_dok_tanah_id') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Dokumen Tanah --</option>
                                @foreach($listJenisDokumenTanah as $item)
                                    <option value="{{$item->id}}">{{strtoupper($item->nm_dok_tanah)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">No. Dokumen<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control " wire:model="no_dokumen_peralihan" name="no_dokumen_peralihan" id="no_dokumen_peralihan"
                            value="">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Tgl. Terbit<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                            </div>
                            <input type="date" class="form-control" wire:model="tgl_dokumen_peralihan" name="tgl_dokumen_peralihan"
                                id="tgl_dokumen_peralihan" value="">
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-label">Sudah Terbit Akta?</div>
                    </div>
                    <div class="col-md-4 mt-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sudah_terbit_akta" wire:model.live="sudah_terbit_akta" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">Sudah</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sudah_terbit_akta" wire:model.live="sudah_terbit_akta" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">Belum</label>
                        </div>
                    </div>
                </div>

            </div>
            @if ($sudah_terbit_akta==1)
            <div id="sect_ajb" class="form-group mb-3 fv-row fv-plugins-icon-container">
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label">No. AJB/PPJB Baru<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" wire:model="no_ajb_baru" name="no_ajb_baru" id="no_ajb_baru" value="">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tgl. AJB/PPJB Baru<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                            </div>
                            <input class="form-control" placeholder="YYYY-MM-DD" type="date" wire:model="tgl_ajb_baru" name="tgl_ajb_baru" id="tgl_ajb_baru" value="">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            

            <div class="footer">
                <p class="text-danger">*Wajib Diisi</p>
                <div class="btn-list">
                    <a class="btn btn-danger pull-left" wire:click="backForm"><i class="fa fa-arrow-left"></i> Sebelumnya</a>

                    <button type="submit" class="btn btn-info float-end" wire:target="create" wire:loading.class.remove="bg-info" id="next">
                        Selanjutnya <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>

</div>
</form>
</fieldset>
</div>

@push('css')
<style>
    .form-control {
        float: left;
        margin-right: 4px;
    }

    .input_nop {
        width: 45px;
        background-color: #ddd;
    }

    #kd_kecamatan, #kd_kelurahan, #kd_blok, #no_urut, #kd_jns_op {
        width: 55px;
    }

    #no_urut {
        width: 70px;
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var inputFields = document.querySelectorAll(".input_nop");

    for (var i = 0; i < inputFields.length; i++) {
    inputFields[i].addEventListener("input", function() {
        var maxLength = parseInt(this.getAttribute("maxlength"));
        var currentLength = this.value.length;

        if (currentLength === maxLength) {
        // Cari indeks field saat ini dalam nodeList
        var currentIndex = Array.prototype.indexOf.call(inputFields, this);

        // Loncat ke field selanjutnya jika bukan field terakhir
        if (currentIndex < inputFields.length - 1) {
            inputFields[currentIndex + 1].focus();
        }
        }
    });
    }
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

    if ($('#nilai_njoptkp').val() <= 0) {
        Swal.fire({
            title: "Perhatian!",
            text: "Silahkan Pilih Jenis Perolehan harus diisi",
            icon: "warning",
            showConfirmButton: true,
        })
    } else {
        $("#form-op").submit();
    }
    });

    
</script>
@endpush