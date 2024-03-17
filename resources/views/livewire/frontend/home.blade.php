@section('title')
Home
@stop
@section('utama')
Home
@stop
<div>
    @livewire('frontend.sidebar')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-0 ">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center me-3 ">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        @yield('title')
                    </h1>
                    <!--end::Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            @yield('menu')
                        </li>
                        <!--end::Item-->

                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl ">
                <!--begin::Row-->
                <div class="row g-5 g-xl-12">
                    <!--begin::Col-->
                    <div class="col-xl-12 mb-xl-10">
                        <!--begin::Slider Widget 7-->
                        <div id="kt_sliders_widget_7_slider"
                            class="card card-flush carousel carousel-custom carousel-light-dots carousel-stretch slide h-300px"
                            data-bs-ride="carousel" data-bs-interval="5000" style="background-color: #008674"
                            data-bs-theme="light">
                            <!--begin::Header-->
                            <div class="card-header align-items-center pt-7">
                                <!--begin::Title-->
                                <h4 class="card-label fw-bold text-white m-0">Selamat Datang</h4>
                                <!--end::Title-->

                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Carousel Indicators-->
                                    <ol
                                        class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-danger">
                                        @foreach($listBannerTop as $listBanner)
                                        <li data-bs-target="#kt_sliders_widget_7_slider"
                                            data-bs-slide-to="{{$listBanner->id}}"
                                            class="ms-1 {{$listBanner->id == $listBannerActive->id ? 'active' : ''}}">
                                        </li>
                                        @endforeach

                                    </ol>
                                    <!--end::Carousel Indicators-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body pt-3">
                                <!--begin::Carousel-->
                                <div class="carousel-inner">
                                    @foreach($listBannerTop as $listBannerData)
                                    <!--begin::Item-->
                                    <div
                                        class="carousel-item {{$listBannerData->id == $listBannerActive->id ? 'active show' : ''}}">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex align-items-center">
                                            <!--begin::Wrapper-->
                                            <div class="m-7">
                                                <!--begin::Title-->
                                                <div
                                                    class="position-relative w-600px fs-2x z-index-2 fw-bold text-white mb-7">
                                                    {!! $listBannerData->deskripsi!!}
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--begin::Wrapper-->

                                            <!--begin::Illustration-->
                                            <img src="{{Storage::disk('public')->url($listBannerData->gambar)}}"
                                                class="position-absolute me-3 bottom-3 mt-8 end-0 h-200px" alt="">
                                            <!--end::Illustration-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--end::Item-->
                                    @endforeach
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Slider Widget 7-->


                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row g-2 g-xl-12">
                        <!--begin::Col-->
                        <div class="col-xl-12 mb-xl-10">
                            <!--begin::Table widget 6-->
                            <div class="card card-flush h-md-100">
                                <!--begin::Header-->
                                <div class="card-header pt-7">
                                    <!--begin::Title-->
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold text-gray-800">Harga Rata-Rata Komoditas
                                            Kabupaten Bandung</span>

                                        <span class="text-gray-500 mt-1 fw-semibold fs-6">{{now()}}</span>
                                    </h3>
                                    <!--end::Title-->

                                    <!--begin::Toolbar-->
                                    <div class="card-toolbar">
                                        <div class="mb-0">
                                            <label class="form-label">Pilih Tanggal</label>
                                            <input class="form-control form-control-solid" placeholder="Pick date rage"
                                                id="kt_daterangepicker_1" />
                                        </div>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div class="card-body" >
                                    <div class="row g-5 g-xl-10" wire:ignore>
                                        @foreach ($model as $index => $item)
                                        <div class="col-md-3">
                                            <!--begin::Card widget 11-->
                                            <div class="card card-flush h-xl-100" style="background-color: #BFDDE3">
                                                <!--begin::Header-->
                                                <div class="card-header flex-nowrap pt-5">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span
                                                            class="card-label fw-bold fs-4 text-gray-800">Dogecoin</span>
                                                        <span class="mt-1 fw-semibold fs-7" style="color: ">0.12,045 USD
                                                            for
                                                            1 DOGE</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Header-->

                                                <!--begin::Body-->
                                                <div class="card-body text-center pt-5">
                                                    <!--begin::Image-->
                                                    <img src="{{ asset('backend/themes/assets/media/svg/shapes/dogecoin.svg');}}"
                                                        class="h-125px mb-5" alt="">
                                                    <!--end::Image-->

                                                    <!--begin::Section-->
                                                    <div class="text-start">
                                                        <span class="d-block fw-bold fs-1 text-gray-800">4703.7589
                                                            DOGE</span>
                                                        <span class="mt-1 fw-semibold fs-3" style="color: ">503,005,56
                                                            USD</span>
                                                    </div>
                                                    <!--end::Section-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card widget 11-->


                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div
                                            class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                                            <div class="dataTables_length" id="kt_ecommerce_products_table_length">
                                                <label><select name="kt_ecommerce_products_table_length"
                                                        aria-controls="kt_ecommerce_products_table"
                                                        class="form-select form-select-sm form-select-solid" wire:model.live="perpage">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select></label></div>
                                        </div>
                                        <div
                                            class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                id="kt_ecommerce_products_table_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button page-item previous disabled"
                                                        id="kt_ecommerce_products_table_previous"><a href="#"
                                                            aria-controls="kt_ecommerce_products_table" data-dt-idx="0"
                                                            tabindex="0" class="page-link"><i class="previous"></i></a>
                                                    </li>
                                                    <li class="paginate_button page-item active"><a href="#"
                                                            aria-controls="kt_ecommerce_products_table" data-dt-idx="1"
                                                            tabindex="0" class="page-link">1</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="kt_ecommerce_products_table" data-dt-idx="2"
                                                            tabindex="0" class="page-link">2</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="kt_ecommerce_products_table" data-dt-idx="3"
                                                            tabindex="0" class="page-link">3</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="kt_ecommerce_products_table" data-dt-idx="4"
                                                            tabindex="0" class="page-link">4</a></li>
                                                    <li class="paginate_button page-item "><a href="#"
                                                            aria-controls="kt_ecommerce_products_table" data-dt-idx="5"
                                                            tabindex="0" class="page-link">5</a></li>
                                                    <li class="paginate_button page-item next"
                                                        id="kt_ecommerce_products_table_next"><a href="#"
                                                            aria-controls="kt_ecommerce_products_table" data-dt-idx="6"
                                                            tabindex="0" class="page-link"><i class="next"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Card Body-->
                            </div>
                            <!--end::Table widget 6-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->

    </div>
    <!--end::Content wrapper-->

    @push('js')
    <script>
        $("#kt_daterangepicker_1").flatpickr();
    </script>
    @endpush