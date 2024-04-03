@section('title')
Home
@stop
@section('utama')
Informasi
@stop
@section('submenu')
Berita
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
                        <div class="card-body p-lg-20">
                            <!--begin::Section-->
                            <div class="mb-17">
                                <!--begin::Title-->
                                <h3 class="text-gray-900 mb-7">Berita & Event Terbaru</h3>
                                <!--end::Title-->

                                <!--begin::Separator-->
                                <div class="separator separator-dashed mb-9"></div>
                                <!--end::Separator-->

                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-md-6">
                                        <!--begin::Feature post-->
                                        <div
                                            class="h-100 d-flex flex-column justify-content-between pe-lg-6 mb-lg-0 mb-10">
                                            <!--begin::Video-->
                                            <div class="mb-3">
                                                <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                                    href="{{Storage::disk('public')->url($first_berita->gambar)}}">
                                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7"
                                                        style="height: 266px;background-image:url('{{Storage::disk('public')->url($first_berita->gambar)}}">
                                                    </div>
                                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                        <i class="ki-outline ki-eye fs-3x text-white"></i>
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end::Video-->

                                            <!--begin::Body-->
                                            <div class="mb-5">
                                                <!--begin::Title-->
                                                <a href="{{route('beritadetail',[Crypt::encrypt($first_berita->id)])}}" 
                                                    class="fs-2 text-gray-900 fw-bold text-hover-primary text-gray-900 lh-base">
                                                    {{$first_berita->judul}}
                                                </a>
                                                <!--end::Title-->

                                                <!--begin::Text-->
                                                <div class="fw-semibold fs-5 text-gray-600 text-gray-900 mt-4">
                                                    {!!strlen($first_berita->konten) > 300 ?
                                                    substr($first_berita->konten, 0, 300) . '...' :
                                                    $first_berita->konten;!!}
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Body-->

                                            <!--begin::Footer-->
                                            <div class="d-flex flex-stack flex-wrap">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center pe-2">
                                                    <!--begin::Text-->
                                                    <div class="fs-5 fw-bold">
                                                        <a class="text-gray-700 text-hover-primary">{{$first_berita->toUser->nama}}</a>

                                                        <span class="text-muted">on
                                                            {{tglIndo($first_berita->created_at)}}</span>
                                                    </div>
                                                    <!--end::Text-->
                                                </div>
                                                <!--end::Item-->

                                                <!--begin::Label-->
                                                @if($first_berita->kategori == 1)
                                                <span
                                                    class="badge badge-light-primary fw-bold my-2">{{$first_berita->toKategori->nama}}</span>
                                                @elseif($first_berita->kategori == 2)
                                                <span
                                                    class="badge badge-light-success fw-bold my-2">{{$first_berita->toKategori->nama}}</span>
                                                @elseif($first_berita->kategori == 3)
                                                <span
                                                    class="badge badge-light-warning fw-bold my-2">{{$first_berita->toKategori->nama}}</span>
                                                @elseif($first_berita->kategori == 4)
                                                <span
                                                    class="badge badge-light-danger fw-bold my-2">{{$first_berita->toKategori->nama}}</span>
                                                @endif
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Footer-->
                                        </div>
                                        <!--end::Feature post-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-md-6 justify-content-between d-flex flex-column">
                                        @foreach($list_berita as $berita)
                                        <!--begin::Post-->
                                        <div class="ps-lg-6 mb-16 mt-md-0 mt-17">
                                            <!--begin::Body-->
                                            <div class="mb-6">
                                                <!--begin::Title-->
                                                <a href="{{route('beritadetail',[Crypt::encrypt($berita->id)])}}" 
                                                    class="fw-bold text-gray-900 mb-4 fs-2 lh-base text-hover-primary">
                                                    {{$berita->judul}}
                                                </a>
                                                <!--end::Title-->

                                                <!--begin::Text-->
                                                <div class="fw-semibold fs-5 mt-4 text-gray-600 text-gray-900">
                                                    {!! strlen($berita->konten) > 100 ? substr($berita->konten, 0, 100)
                                                    . '...' : $berita->konten !!}
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Body-->


                                            <!--begin::Footer-->
                                            <div class="d-flex flex-stack flex-wrap">
                                                <!--begin::Item-->
                                                <div class="d-flex align-items-center pe-2">
                                                    <!--begin::Text-->
                                                    <div class="fs-5 fw-bold">
                                                        <a href="#"
                                                            class="text-gray-700 text-hover-primary">{{$berita->toUser->nama}}</a>

                                                        <span class="text-muted">on
                                                            {{tglIndo($berita->created_at)}}</span>
                                                    </div>
                                                    <!--end::Text-->
                                                </div>
                                                <!--end::Item-->

                                                <!--begin::Label-->
                                                @if($berita->kategori == 1)
                                                <span
                                                    class="badge badge-light-primary fw-bold my-2">{{$berita->toKategori->nama}}</span>
                                                @elseif($berita->kategori == 2)
                                                <span
                                                    class="badge badge-light-success fw-bold my-2">{{$berita->toKategori->nama}}</span>
                                                @elseif($berita->kategori == 3)
                                                <span
                                                    class="badge badge-light-warning fw-bold my-2">{{$berita->toKategori->nama}}</span>
                                                @elseif($berita->kategori == 4)
                                                <span
                                                    class="badge badge-light-danger fw-bold my-2">{{$berita->toKategori->nama}}</span>
                                                @endif
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Footer-->
                                        </div>
                                        <!--end::Post-->
                                        @endforeach

                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--begin::Row-->
                            </div>
                            <!--end::Section-->

                            <!--begin::Section-->
                            <div class="mb-17">
                                <!--begin::Content-->
                                <div class="d-flex flex-stack mb-5">
                                    <!--begin::Title-->
                                    <h3 class="text-gray-900">Artikel Lainnya</h3>
                                    <!--end::Title-->
                                </div>
                                <!--end::Content-->

                                <!--begin::Separator-->
                                <div class="separator separator-dashed mb-9"></div>
                                <!--end::Separator-->

                                <!--begin::Row-->
                                <div class="row g-10">
                                    @foreach ($model as $index => $item)
                                    <!--begin::Col-->
                                    <div class="col-md-4">
                                        <!--begin::Feature post-->
                                        <div class="card-xl-stretch me-md-6">
                                            <!--begin::Image-->
                                            <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                                href="{{Storage::disk('public')->url($item->gambar)}}">
                                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mb-7"
                                                    style="height: 166px;background-image:url('{{Storage::disk('public')->url($item->gambar)}}">
                                                </div>
                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                    <i class="ki-outline ki-eye fs-3x text-white"></i>
                                                </div>
                                            </a>
                                            <!--end::Image-->

                                            <!--begin::Body-->
                                            <div class="m-0">
                                                <!--begin::Title-->
                                                <a href="{{route('beritadetail',[Crypt::encrypt($item->id)])}}" 
                                                    class="fs-4 text-gray-900 fw-bold text-hover-primary text-gray-900 lh-base">
                                                    {{strlen($item->judul) > 50 ? substr($item->judul, 0, 50)
                                                        . '...' : $item->judul}} </a>
                                                <!--end::Title-->

                                                <!--begin::Text-->
                                                <div class="fw-semibold fs-5 text-gray-600 text-gray-900 my-4">
                                                    {!! strlen($item->konten) > 120 ? substr($item->konten, 0, 120)
                                                    . '...' : $item->konten !!}
                                                </div>
                                                <!--end::Text-->


                                                <!--begin::Footer-->
                                                <div class="d-flex flex-stack flex-wrap">
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center pe-2">
                                                        <!--begin::Text-->
                                                        <div class="fw-bold">
                                                            <a href=""
                                                                class="text-gray-700 text-hover-primary">{{$berita->toUser->nama}}</a>

                                                            <span class="text-muted">on
                                                                {{tglIndo($berita->created_at)}}</span>
                                                        </div>
                                                        <!--end::Text-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Label-->
                                                    @if($berita->kategori == 1)
                                                    <span
                                                        class="badge badge-light-primary fw-small my-2">{{$berita->toKategori->nama}}</span>
                                                    @elseif($berita->kategori == 2)
                                                    <span
                                                        class="badge badge-light-success fw-small my-2">{{$berita->toKategori->nama}}</span>
                                                    @elseif($berita->kategori == 3)
                                                    <span
                                                        class="badge badge-light-warning fw-small my-2">{{$berita->toKategori->nama}}</span>
                                                    @elseif($berita->kategori == 4)
                                                    <span
                                                        class="badge badge-light-danger fw-small my-2">{{$berita->toKategori->nama}}</span>
                                                    @endif
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Footer-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Feature post-->
                                    </div>
                                    <!--end::Col-->
                                    @endforeach
                                </div>
                                <!--end::Row-->
                                <br>
                                <div class="row">
                                    <div
                                        class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                                        <div class="dataTables_length" id="kt_ecommerce_products_table_length">
                                            <label><select name="kt_ecommerce_products_table_length"
                                                    aria-controls="kt_ecommerce_products_table"
                                                    class="form-select form-select-sm form-select-solid"
                                                    wire:model.live="perpage">
                                                    <option value="6">6</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select></label></div>
                                    </div>
                                    <div
                                        class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                            id="kt_ecommerce_products_table_paginate">
                                            {{ $model->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Section-->
                            <!--begin::latest instagram-->
                            <div class="">
                                <!--begin::Section-->
                                <div class="m-0">
                                    <!--begin::Content-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Title-->
                                        <h3 class="text-gray-900">Latest Instagram Posts</h3>
                                        <!--end::Title-->

                                        <!--begin::Link-->
                                        <a href="#" class="fs-6 fw-semibold link-primary">
                                            View Instagram
                                        </a>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Content-->

                                    <!--begin::Separator-->
                                    <div class="separator separator-dashed border-gray-300 mb-9 mt-5"></div>
                                    <!--end::Separator-->
                                </div>
                                <!--end::Section-->

                                <!--begin::Row-->
                                <div class="row g-10 row-cols-2 row-cols-lg-5">
                                    <!--begin::Col-->
                                    <div class="col">
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                            href="/metronic8/demo30/assets/media/stock/900x600/16.jpg">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('/metronic8/demo30/assets/media/stock/900x600/16.jpg')">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-3x text-white"></i> </div>
                                            <!--end::Action-->
                                        </a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col">
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                            href="/metronic8/demo30/assets/media/stock/900x600/13.jpg">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('/metronic8/demo30/assets/media/stock/900x600/13.jpg')">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-3x text-white"></i> </div>
                                            <!--end::Action-->
                                        </a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col">
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                            href="/metronic8/demo30/assets/media/stock/900x600/19.jpg">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('/metronic8/demo30/assets/media/stock/900x600/19.jpg')">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-3x text-white"></i> </div>
                                            <!--end::Action-->
                                        </a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col">
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                            href="/metronic8/demo30/assets/media/stock/900x600/15.jpg">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('/metronic8/demo30/assets/media/stock/900x600/15.jpg')">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-3x text-white"></i> </div>
                                            <!--end::Action-->
                                        </a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col">
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                            href="/metronic8/demo30/assets/media/stock/900x600/12.jpg">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('/metronic8/demo30/assets/media/stock/900x600/12.jpg')">
                                            </div>
                                            <!--end::Image-->

                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="ki-outline ki-eye fs-3x text-white"></i> </div>
                                            <!--end::Action-->
                                        </a>
                                    </div>
                                    <!--end::Col-->

                                </div>
                                <!--begin::Row-->
                            </div>
                            <!--end::latest instagram-->



                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>