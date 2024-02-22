@section('title')
Edit Data Berita
@stop
@section('menu')
Website > <b>Berita</b>
@stop
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <div class="col-lg-12 col-xxl-12">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Edit Berita</span>
                    </h3>
            </div>
            <div class="card-body" style="text-align:left;">
                <form class="form-horizontal" wire:submit="create">
                    <input type="hidden" name="id_berita" wire:model="id_berita">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Kategori<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group mb-2">
                                    <select x-init="$($el).select2({ placeholder: '-- Pilih Kategori --', });
                                $($el).on('change', function() {
                                    $wire.set('kategori', $($el).val());
                                })" wire:model.defer="kategori" name="kategori" id="kategori"
                                        class="form-control form-control-lg form-select-solid @error('kategori') is-invalid @enderror">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategoriList as $kategori)
                                        <option value="{{$kategori->id}}">{{strtoupper($kategori->nama)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Judul<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                                    wire:model="judul" id="judul">
                                @error('judul') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Sumber<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('sumber') is-invalid @enderror" name="sumber"
                                    wire:model="sumber" id="sumber">
                                @error('sumber') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Isi Berita</label>
                            </div>
                            <div class="col-md-10">
                                <div class="py-5" data-bs-theme="light">
                                    <textarea name="konten" id="konten" wire:model="konten" rows="10" cols="100">{{$konten}}</textarea>
                                    @error('konten') <span class="invalid-feedback" role="alert">{{ $message }}</span>
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
                                    file-document="gambar_edit" 
                                    data-max-file-size="1MB" 
                                    wire:model="gambar_edit"
                                    id="gambar_edit"
                                    allowImagePreview
                                    imagePreviewMaxHeight="200"
                                    allowFileTypeValidation
                                    acceptedFileTypes="['image/png', 'image/jpg', 'image/jpeg']"
                                    allowFileSizeValidation
                                    />
                                </div>
                                <div class="row g-10 row-cols-2 row-cols-lg-5">
                                    <div class="col">
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                            href="{{Storage::disk('public')->url($gambar)}}">
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('{{Storage::disk('public')->url($gambar)}}')">
                                            </div>
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-3x text-white"></i> </div>
                                        </a>
                                    </div>
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
                                    file-document="multi_gambar_edit" 
                                    data-max-file-size="1MB" 
                                    wire:model="multi_gambar_edit" 
                                    id="multi_gambar_edit"
                                    multiple
                                    allowImagePreview
                                    imagePreviewMaxHeight="200"
                                    allowFileTypeValidation
                                    acceptedFileTypes="['image/png', 'image/jpg', 'image/jpeg']"
                                    allowFileSizeValidation
                                    />
                                </div>
                                <div class="row g-10 row-cols-2 row-cols-lg-5">
                                @foreach ($multi_gambar as $val)
                                    <div class="col">
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot"
                                            href="{{Storage::disk('public')->url($val)}}">
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('{{Storage::disk('public')->url($val)}}')">
                                            </div>
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-3x text-white"></i> </div>
                                        </a>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-secondary" href="{{route('website.berita.index')}}">Close</a>
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
            .create(document.querySelector('#konten'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('konten', editor.getData());
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

