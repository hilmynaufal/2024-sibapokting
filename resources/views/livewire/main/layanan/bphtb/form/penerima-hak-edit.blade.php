<div>
    @section('title')
    1. Pihak Ke-1 (Penerima Hak/Informasi Pembeli/Penerima Waris/Penerima Hibah/Pemenang Lelang)
    @stop
    @section('menu')
    Layanan > BPHTB > <b>1. Pihak Ke-1</b>
    @stop
    <form wire:submit.prevent="create">
        <input type="hidden" name="id_bphtb" wire:model="id_bphtb">
        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row mt-2">
                <label for="prov_id" class="col-sm-2 form-label">Jenis Wajib Pajak<span
                        class="text-danger">*</span></label>
                <div class="col-md-6 mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_wp" wire:model="jenis_wp" id="inlineRadio1" value="1"
                            checked="">
                        <label class="form-check-label" for="inlineRadio1">Pribadi</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jenis_wp" wire:model="jenis_wp" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">Badan</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">NIK<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control " name="nik" wire:model="nik" id="nik" maxlength="16" 
                        onchange="get_wp()">
                        @error('nik') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">NPWP</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control " name="npwp" wire:model="npwp" id="npwp" maxlength="15" >
                    @error('npwp') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">Nama WP<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-10">
                    <input type="text"
                        oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                        class="form-control " name="nama_wp" wire:model="nama_wp" id="nama_wp" >
                        @error('nama_wp') <span class="error">{{ $message }}</span> @enderror
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
                        class="form-control " name="alamat" wire:model="alamat" id="alamat" >
                        @error('alamat') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">Provinsi<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-2">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control " name="id_provinsi" wire:model="id_provinsi" id="id_provinsi" 
                            autocomplete="off">
                        <span class="input-group-btn">
                            <button id="prov" type="button" class="btn btn-success btn-flat" data-toggle="modal"
                                data-target="#modalProvinsi"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control " id="provinsi" readonly="">
                </div>
            </div>
        </div>

        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">Kota / Kabupaten<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-2">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control " name="id_kota_kab" wire:model="id_kota_kab" id="id_kota_kab" 
                            autocomplete="off">
                        <span class="input-group-btn">
                            <button id="kota" type="button" class="btn btn-success btn-flat" data-toggle="modal"
                                data-target="#modalKota"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control " id="kota_kab" readonly="">
                </div>
            </div>
        </div>

        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">Kecamatan<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-2">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control " name="id_kecamatan" wire:model="id_kecamatan" id="id_kecamatan" 
                            autocomplete="off">
                        <span class="input-group-btn">
                            <button id="kec" type="button" class="btn btn-success btn-flat" data-toggle="modal"
                                data-target="#pekerjaanModal"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control " id="kecamatan" readonly="">
                </div>
            </div>
        </div>

        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">Kelurahan / Desa<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-2">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control " name="id_kelurahan" wire:model="id_kelurahan" id="id_kelurahan" 
                            autocomplete="off">
                        <span class="input-group-btn">
                            <button id="kel" type="button" class="btn btn-success btn-flat" data-toggle="modal"
                                data-target="#pekerjaanModal"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control " id="kelurahan" readonly="">
                </div>
            </div>
        </div>

        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">RT<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control " name="rt" wire:model="rt" id="rt" >
                </div>
                <div class="col-md-2">
                    <label class="form-label">RW<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control " name="rw" wire:model="rw" id="rw" >
                </div>
            </div>
        </div>

        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label">Kode Pos</label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control " name="kode_pos" wire:model="kode_pos" id="kode_pos" >
                </div>
                <div class="col-md-2">
                    <label class="form-label">No. Hp (Whatsapp)<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control  " name="no_hp" wire:model="no_hp" id="no_hp" >
                    @error('no_hp') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="footer">
            <p class="text-danger">*Wajib Diisi</p>
            <div class="btn-list">

                <button type="submit" class="btn btn-info float-end" id="next">Selanjutnya <i
                        class="fa fa-arrow-right"></i></button>
            </div>
        </div>

    </form>
</div>