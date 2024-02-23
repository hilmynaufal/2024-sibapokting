@section('title')
Lihat Data Berita
@stop
@section('menu')
Website > <b>Berita</b>
@stop
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <div class="col-lg-12 col-xxl-12">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Lihat Berita</span>
                    </h3>
            </div>
            
            <div class="card-body" style="text-align:left;">
                <form class="form-horizontal" wire:submit="create">
                    <input type="hidden" name="id_geleri" wire:model="id_geleri">
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
                                })" wire:model.defer="kategori" name="kategori" id="kategori" disabled
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
                                <label class="form-label">Nama<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" disabled
                                    wire:model="nama" id="nama">
                                @error('nama') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Gambar Headline</label>
                            </div>
                            <div class="col-md-10">
                                @if(!empty($gambar))
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
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Gambar Lainnya</label>
                            </div>
                            <div class="col-md-10">
                                @if(!empty($multi_gambar))
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
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-secondary" href="{{route('website.galeri.index')}}">Close</a>
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

