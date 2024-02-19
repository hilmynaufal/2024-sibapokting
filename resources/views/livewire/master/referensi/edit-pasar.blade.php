@section('title')
Ubah Data Pasar
@stop
@section('menu')
Referensi > <b>Pasar</b>
@stop
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
                    <input type="hidden" name="id_pasar" wire:model="id_pasar" id="id_pasar">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Nama Pasar<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('namapasar') is-invalid @enderror" name="namapasar"
                                    wire:model="namapasar" id="namapasar">
                                @error('namapasar') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Tipe Pasar</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control @error('tipe') is-invalid @enderror"
                                    name="tipe" wire:model="tipe" id="tipe">
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="Pasar Tradisional">Pasar Tradisional</option>
                                    <option value="Pasar Modern atau Swalayan">Pasar Modern atau Swalayan</option>
                                    <option value="Pasar Malam">Pasar Malam</option>
                                    <option value="Pasar Pagi">Pasar Pagi</option>
                                    <option value="Pasar Online">Pasar Online</option>
                                </select>
                                @error('tipe') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Alamat<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                    wire:model="alamat" id="alamat">
                                @error('alamat') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Provinsi<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2" wire:ignore>
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Provinsi --', });
                                $($el).on('change', function() {
                                    $wire.set('provinsi', $($el).val());
                                })" wire:model="provinsi" name="provinsi" id="provinsi"
                                        class="form-control form-control-lg form-select-solid @error('provinsi') is-invalid @enderror">
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach($provinsiList as $provinsi)
                                        <option value="{{$provinsi->id}}">{{$provinsi->id}} -
                                            {{strtoupper($provinsi->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Kota / Kabupaten<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2" wire:ignore.self>
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Kabupaten --', });
                                $($el).on('change', function() {
                                    $wire.set('kabupaten', $($el).val());
                                })" wire:model="kabupaten" name="kabupaten" id="kabupaten"
                                        class="form-control form-control-lg form-select-solid @error('kabupaten') is-invalid @enderror">
                                        <option value="">-- Pilih Kabupaten --</option>
                                        @foreach($kabupatenList as $kabupaten)
                                        <option value="{{$kabupaten->id}}">{{$kabupaten->id}} -
                                            {{strtoupper($kabupaten->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Kecamatan<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2" wire:ignore.self>
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Kecamatan --', });
                                $($el).on('change', function() {
                                    $wire.set('kecamatan', $($el).val());
                                })" wire:model="kecamatan" name="kecamatan" id="kecamatan"
                                        class="form-control form-control-lg form-select-solid @error('kecamatan') is-invalid @enderror">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach($kecamatanList as $kecamatan)
                                        <option value="{{$kecamatan->id}}">{{$kecamatan->id}} -
                                            {{strtoupper($kecamatan->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Kelurahan / Desa<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2" wire:ignore.self>
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Desa --', });
                                $($el).on('change', function() {
                                    $wire.set('desa', $($el).val());
                                })" wire:model="desa" name="desa" id="desa"
                                        class="form-control form-control-lg form-select-solid @error('desa') is-invalid @enderror">
                                        <option value="">-- Pilih Desa --</option>
                                        @foreach($kelurahanList as $kelurahan)
                                        <option value="{{$kelurahan->id}}">{{$kelurahan->id}} -
                                            {{strtoupper($kelurahan->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">RT<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control @error('rt') is-invalid @enderror" name="rt"
                                    wire:model="rt" id="rt">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">RW<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control @error('rw') is-invalid @enderror" name="rw"
                                    wire:model="rw" id="rw">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-secondary" href="{{route('master.referensi.pasar')}}">Close</a>
                        <button type="submit" class="btn btn-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


