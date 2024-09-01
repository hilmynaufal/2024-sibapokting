@section('title')
Tambah Data Pasar
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
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Sejarah</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="sejarah" id="sejarah" wire:model="sejarah" rows="10" cols="100"></textarea>
                                    @error('sejarah') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Area Pasar</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="area_pasar" id="area_pasar" wire:model="area_pasar" rows="10" cols="100"></textarea>
                                    @error('area_pasar') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Jam Oprasional</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="jam_oprasional" id="jam_oprasional" wire:model="jam_oprasional" rows="10" cols="100"></textarea>
                                    @error('jam_oprasional') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Luas Pasar</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="luas_pasar" id="luas_pasar" wire:model="luas_pasar" rows="10" cols="100"></textarea>
                                    @error('luas_pasar') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Jumlah Kios/Lios</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="jumlah_kios" id="jumlah_kios" wire:model="jumlah_kios" rows="10" cols="100"></textarea>
                                    @error('jumlah_kios') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Jumlah Pedagang</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="jumlah_pedagang" id="jumlah_pedagang" wire:model="jumlah_pedagang" rows="10" cols="100"></textarea>
                                    @error('jumlah_pedagang') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Jenis Barang</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="jenis_barang" id="jenis_barang" wire:model="jenis_barang" rows="10" cols="100"></textarea>
                                    @error('jenis_barang') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Fasilitas Umum</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="fasilitas_umum" id="fasilitas_umum" wire:model="fasilitas_umum" rows="10" cols="100"></textarea>
                                    @error('fasilitas_umum') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Gambar Headline</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">   
                                    <x-filepond title="Gambar Headline" 
                                    required="required" 
                                    file-document="gambar_utama" 
                                    data-max-file-size="1MB" 
                                    wire:model="gambar_utama" 
                                    id="gambar_utama"
                                    allowImagePreview
                                    imagePreviewMaxHeight="200"
                                    allowFileTypeValidation
                                    acceptedFileTypes="['image/png', 'image/jpg', 'image/jpeg']"
                                    allowFileSizeValidation
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Gambar Lainnya</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">   
                                    <x-filepond title="Gambar Lainnya" 
                                    required="required" 
                                    file-document="gambar_lainnya" 
                                    data-max-file-size="1MB" 
                                    wire:model="gambar_lainnya" 
                                    id="gambar_lainnya"
                                    multiple
                                    allowImagePreview
                                    imagePreviewMaxHeight="200"
                                    allowFileTypeValidation
                                    acceptedFileTypes="['image/png', 'image/jpg', 'image/jpeg']"
                                    allowFileSizeValidation
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-secondary" href="{{route('master.referensi.pasar')}}">Close</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
	ClassicEditor
            .create(document.querySelector('#sejarah'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('sejarah', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#area_pasar'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('area_pasar', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#jam_oprasional'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('jam_oprasional', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#luas_pasar'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('luas_pasar', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#jumlah_kios'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('jumlah_kios', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#jumlah_pedagang'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('jumlah_pedagang', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#jenis_barang'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('jenis_barang', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#fasilitas_umum'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('fasilitas_umum', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
</script>
@endpush


@push('css')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endpush

@push('js')
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.registerPlugin(FilePondPluginImagePreview);
        </script> 
@endpush

