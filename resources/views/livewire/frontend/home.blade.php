@section('title')
Home
@stop
@section('utama')
Home
@stop
<div>
    <div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="300px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_toggle">
        <!--begin::Logo-->
        <div class="d-flex flex-stack px-4 px-lg-6 py-3 py-lg-8" id="kt_app_sidebar_logo">
            <!--begin::Logo image-->
            <a href="index.html">
                <img alt="Logo" src="https://preview.keenthemes.com/metronic8/demo23/assets/media/logos/demo23.svg"
                    class="h-20px h-lg-25px theme-light-show" />
                <img alt="Logo" src="https://preview.keenthemes.com/metronic8/demo23/assets/media/logos/demo23-dark.svg"
                    class="h-20px h-lg-25px theme-dark-show" />
            </a>
            <!--end::Logo image-->

        </div>
        <!--end::Logo-->
        @if(!empty($komoditas_sekarang))
        <!--begin::Sidebar nav-->
        <div class="flex-column-fluid px-4 px-lg-8 py-4" id="kt_app_sidebar_nav">
            <!--begin::Nav wrapper-->
            <div id="kt_app_sidebar_nav_wrapper" class="d-flex flex-column hover-scroll-y pe-4 me-n4"
                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar, #kt_app_sidebar_nav" data-kt-scroll-offset="5px">
                <!--begin::Progress-->
                <div class="d-flex align-items-center flex-column w-100 mb-6">
                    <div class="d-flex justify-content-between fw-bolder fs-6 text-gray-800  w-100 mt-auto mb-3">
                        <span>{{$komoditas_sekarang->toKomoditas->namakomoditas}}</span>
                    </div>

                    <div class="w-100 bg-light-primary rounded mb-2" style="height: 24px">
                        <div class="bg-primary rounded" role="progressbar"
                            style="height: 24px; width: {{ dinamikaHargaAvgNilai(avgHarga($komoditas_sekarang->komoditas_id,0,$komoditas_sekarang->detail_tgl),avgHarga($komoditas_kemarin->komoditas_id,0,$komoditas_kemarin->detail_tgl)) }}"
                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div class="fw-semibold fs-7 text-primary w-100 mt-auto">
                        <span>{!!
                            dinamikaHargaAvg(avgHarga($komoditas_sekarang->komoditas_id,0,$komoditas_sekarang->detail_tgl),avgHarga($komoditas_kemarin->komoditas_id,0,$komoditas_kemarin->detail_tgl))
                            !!}</span>
                    </div>
                </div>
                <!--end::Progress-->

                <!--begin::Stats-->
                <div class="d-flex mb-3 mb-lg-6">
                    <!--begin::Stat-->
                    <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 me-6">
                        <!--begin::Date-->
                        <span class="fs-6 text-gray-500 fw-bold">Sekarang</span>
                        <!--end::Date-->

                        <!--begin::Label-->
                        <div class="fs-2 fw-bold text-success">
                            {{rupiah(avgHarga($komoditas_sekarang->komoditas_id,0,$komoditas_sekarang->detail_tgl),0)}}
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Stat-->
                    <!--begin::Stat-->
                    <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 ">
                        <!--begin::Date-->
                        <span class="fs-6 text-gray-500 fw-bold">Kemarin</span>
                        <!--end::Date-->

                        <!--begin::Label-->
                        <div class="fs-2 fw-bold text-danger">
                            {{rupiah(avgHarga($komoditas_kemarin->komoditas_id,0,$komoditas_kemarin->detail_tgl),0)}}
                        </div>
                        <!--end::Label-->
                    </div>
                    <!--end::Stat-->

                </div>
                <!--end::Stats-->

                <!--begin::Links-->
                <div class="mb-6">
                    <!--begin::Title-->
                    <h3 class="text-gray-800 fw-bold mb-8">Komoditas Lainnya</h3>
                    <!--end::Title-->

                    <!--begin::Row-->
                    <div class="row row-cols-3" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">

                        @foreach($list_komoditas as $kom)
                        <!--begin::Col-->
                        <div class="col mb-4">
                            <!--begin::Link-->
                            <a href="#" wire:click.windows="setKomoditas({{$kom->id}})"
                                class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column 
                                                {{$komoditas_id == $kom->id ? 'active' : ''}} flex-center w-lg-90px h-lg-90px w-70px h-70px border-gray-200"
                                data-kt-button="true">
                                <!--begin::Icon-->
                                <span class="mb-2">
                                    <div class="symbol symbol-40px">
                                        <img src="{{ Storage::disk('public')->url($kom->gambar) }}" alt="">
                                    </div>
                                </span>
                                <!--end::Icon-->

                                <!--begin::Label-->
                                <span class="fs-7 fw-bold">{{$kom->namakomoditas}}</span>
                                <!--end::Label-->
                            </a>
                            <!--end::Link-->
                        </div>
                        <!--end::Col-->
                        @endforeach
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Links-->




            </div>
            <!--end::Nav wrapper-->
        </div>
        <!--end::Sidebar nav-->
        <!--begin::Footer-->
        <div class="flex-column-auto d-flex flex-center px-4 px-lg-8 py-3 py-lg-8" id="kt_app_sidebar_footer">
            {{getDescriptionName()}}
        </div>
        <!--end::Footer-->
        @else
        <!--begin::Sidebar nav-->
        <div class="flex-column-fluid px-4 px-lg-8 py-4" id="kt_app_sidebar_nav">
            <!--begin::Nav wrapper-->
            <div id="kt_app_sidebar_nav_wrapper" class="d-flex flex-column hover-scroll-y pe-4 me-n4"
                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar, #kt_app_sidebar_nav" data-kt-scroll-offset="5px"
                style="height: 500px;">
                <!--begin::Progress-->
                <div class="d-flex align-items-center flex-column w-100 mb-6">
                    <div class="d-flex justify-content-between fw-bolder fs-6 text-gray-800  w-100 mt-auto mb-3">
                        <span>Data Belum Update</span>
                    </div>
                </div>
                <!--end::Progress-->


            </div>
            <!--end::Nav wrapper-->
        </div>
        <!--end::Sidebar nav-->
        <!--begin::Footer-->
        <div class="flex-column-auto d-flex flex-center px-4 px-lg-8 py-3 py-lg-8" id="kt_app_sidebar_footer">
            {{getDescriptionName()}}
        </div>
        <!--end::Footer-->
        @endif
    </div>
    <!--end::Sidebar-->
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl ">
                <!--begin::Row-->
                <div class="row g-5 g-xl-12">
                    <!--begin::Col-->
                    <div class="col-xl-12">
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
                        <div class="col-xl-12">
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
                                                id="kt_daterangepicker_1" wire:model.live="search" />
                                        </div>
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="row g-5 g-xl-10">
                                            @foreach ($model as $index => $item)
                                            <div class="col-sm-6 col-xl-4">
                                                <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-stack mb-3">
                                                        <!--begin::Wrapper-->
                                                        <div class="me-3">
                                                            <!--begin::Icon-->
                                                            <img src="/metronic8/demo23/assets/media/stock/ecommerce/210.png"
                                                                class="w-50px ms-n1 me-1" alt="">
                                                            <!--end::Icon-->

                                                            <!--begin::Title-->
                                                            <a href="/metronic8/demo23/apps/ecommerce/catalog/edit-product.html"
                                                                class="text-gray-800 text-hover-primary fw-bold">Elephant
                                                                1802</a>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Wrapper-->

                                                        <!--begin::Action-->
                                                        <div class="m-0">
                                                            <!--begin::Menu-->
                                                            <button
                                                                class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end"
                                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                                data-kt-menu-overflow="true">

                                                                <i class="ki-outline ki-dots-square fs-1"></i>
                                                            </button>

                                                            <!--begin::Menu 2-->
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                                                data-kt-menu="true">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <div
                                                                        class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">
                                                                        Quick Actions</div>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu separator-->
                                                                <div class="separator mb-3 opacity-75"></div>
                                                                <!--end::Menu separator-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        New Ticket
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        New Customer
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                                                    data-kt-menu-placement="right-start">
                                                                    <!--begin::Menu item-->
                                                                    <a href="#" class="menu-link px-3">
                                                                        <span class="menu-title">New Group</span>
                                                                        <span class="menu-arrow"></span>
                                                                    </a>
                                                                    <!--end::Menu item-->

                                                                    <!--begin::Menu sub-->
                                                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                                        <!--begin::Menu item-->
                                                                        <div class="menu-item px-3">
                                                                            <a href="#" class="menu-link px-3">
                                                                                Admin Group
                                                                            </a>
                                                                        </div>
                                                                        <!--end::Menu item-->

                                                                        <!--begin::Menu item-->
                                                                        <div class="menu-item px-3">
                                                                            <a href="#" class="menu-link px-3">
                                                                                Staff Group
                                                                            </a>
                                                                        </div>
                                                                        <!--end::Menu item-->

                                                                        <!--begin::Menu item-->
                                                                        <div class="menu-item px-3">
                                                                            <a href="#" class="menu-link px-3">
                                                                                Member Group
                                                                            </a>
                                                                        </div>
                                                                        <!--end::Menu item-->
                                                                    </div>
                                                                    <!--end::Menu sub-->
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a href="#" class="menu-link px-3">
                                                                        New Contact
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu item-->

                                                                <!--begin::Menu separator-->
                                                                <div class="separator mt-3 opacity-75"></div>
                                                                <!--end::Menu separator-->

                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <div class="menu-content px-3 py-3">
                                                                        <a class="btn btn-primary  btn-sm px-4" href="#">
                                                                            Generate Reports
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu 2-->

                                                            <!--end::Menu-->
                                                        </div>
                                                        <!--end::Action-->
                                                    </div>
                                                    <!--end::Info-->

                                                    <!--begin::Customer-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Name-->
                                                        <span class="text-gray-500 fw-bold">To:
                                                            <a href="/metronic8/demo23/apps/ecommerce/sales/details.html"
                                                                class="text-gray-800 text-hover-primary fw-bold">
                                                                Jason Bourne </a>
                                                        </span>
                                                        <!--end::Name-->

                                                        <!--begin::Label-->
                                                        <span class="badge badge-light-success">Delivered</span>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Customer-->
                                                </div>
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
                                                        class="form-select form-select-sm form-select-solid"
                                                        wire:model.live="perpage">
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
                                                {{ $model->links() }}
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
</div>

@push('js')
<script>
    $("#kt_daterangepicker_1").flatpickr();
</script>
@endpush