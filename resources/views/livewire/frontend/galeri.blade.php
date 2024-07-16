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
                                    <h3 class="fs-2hx text-gray-900 mb-5">Galeri Sibapokting</h3>
                                    <!--end::Title-->
                                </div>
                                <!--end::Heading-->

                                <!--begin::Wrapper-->
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 gy-10">
                                    <!--begin::Item-->
                                @foreach ($model as $index => $item)
                                    <div class="col text-center mb-9">
                                        <!--begin::Photo-->
                                        <div class="octagon mx-auto mb-2 d-flex w-150px h-150px bgi-no-repeat bgi-size-contain bgi-position-center"
                                            style="background-image:url('{{Storage::disk('public')->url($item->gambar)}}')">
                                        </div>
                                        <!--end::Photo-->

                                        <!--begin::Person-->
                                        <div class="mb-0">
                                            <!--begin::Name-->
                                            <a href="{{route('galeridetail',[Crypt::encrypt($item->id)])}}"
                                                class="text-gray-900 fw-bold text-hover-primary fs-3">{{ $item->nama }}</a>
                                            <!--end::Name-->
                                            <!--begin::Position-->
                                            <div class="text-muted fs-6 fw-semibold">{{ $item->toKategori->nama }}</div>
                                            <!--begin::Position-->
                                        </div>
                                        <!--end::Person-->
                                    </div>
                                    <!--end::Item-->
                                @endforeach
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>