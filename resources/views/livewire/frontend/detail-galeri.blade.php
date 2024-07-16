@section('title')
Galeri Foto
@stop
@section('utama')
Informasi
@stop
@section('submenu')
Galeri Foto
@stop

<div>
    @livewire('Frontend.Sidebar')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl ">
                <!--begin::Row-->
                <div class="row g-5 g-xl-12">
                    <!--begin::Col-->
                    <div class="card">
                        <!--begin::Body-->
                        <div class="card-body p-lg-17">
                            <!--begin::Team-->
                            <div class="mb-18">
                                <!--begin::Heading-->
                                <div class="text-center mb-17">
                                    <!--begin::Title-->
                                    <h3 class="fs-2hx text-gray-900 mb-5">{{ $judul }}</h3>
                                    <!--end::Title-->
                                </div>
                                <!--end::Heading-->

                                <!--begin::Wrapper-->
                                    @if(!empty($multi_gambar))
                                    <div class="row g-10 row-cols-2 row-cols-lg-5">
                                    @foreach ($multi_gambar as $val)
                                    <div class="col text-center mb-9">
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot"
                                                href="{{Storage::disk('public')->url($val)}}">
                                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                    style="background-image:url('{{Storage::disk('public')->url($val)}}')">
                                                </div>
                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                    <i class="ki-outline ki-eye fs-3x text-white"></i> </div>
                                            </a>
                                    </div>
                                    <!--end::Item-->
                                    @endforeach
                                    @endif
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
