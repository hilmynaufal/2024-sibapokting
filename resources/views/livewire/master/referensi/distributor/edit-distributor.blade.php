@section('title')
Ubah Data Distributor
@stop
@section('menu')
Referensi > <b>Distributor</b>
@stop
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <div class="col-lg-12 col-xxl-12">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Tambah Master Distributor</span>
                    </h3>
            </div>
            <div class="card-body" style="text-align:left;">
                <form class="form-horizontal" wire:submit="create">
                    <input type="hidden" name="id_distributor" wire:model="id_distributor" id="id_distributor">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Nama Distributor<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('namadistributor') is-invalid @enderror" name="namadistributor"
                                    wire:model="namadistributor" id="namadistributor">
                                @error('namadistributor') <span class="invalid-feedback" role="alert">{{ $message }}</span>
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
                                <label class="form-label">No Telp<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="number" class="form-control @error('notelp') is-invalid @enderror" name="notelp"
                                    wire:model="notelp" id="notelp">
                                @error('notelp') <span class="invalid-feedback" role="alert">{{ $message }}</span>
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

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Keterangan</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="keterangan" id="keterangan" wire:model="keterangan" rows="10" cols="100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-secondary" href="{{route('master.referensi.distributor')}}">Close</a>
                        <button type="submit" class="btn btn-success">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


