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
                                <div class="card-body">
                                    <div class="card overflow-hidden h-md-50 mb-5 col-md-3">
                                        <!--begin::Card body-->
                                        <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                                            <!--begin::Statistics-->
                                            <div class="mb-4 px-9">
                                                <!--begin::Info-->
                                                <div class="d-flex align-items-center mb-2">
                                                    <!--begin::Currency-->
                                                    <span
                                                        class="fs-4 fw-semibold text-gray-500 align-self-start me-1>">$</span>
                                                    <!--end::Currency-->


                                                    <!--begin::Value-->
                                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">69,700</span>
                                                    <!--end::Value-->

                                                    <!--begin::Label-->
                                                    <span class="badge badge-light-success fs-base">
                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>
                                                        2.2% </span>

                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Info-->

                                                <!--begin::Description-->
                                                <span class="fs-6 fw-semibold text-gray-500">Total Online Sales</span>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Statistics-->

                                            <!--begin::Chart-->
                                            <div id="spark1" class="min-h-auto"></div>
                                            <!--end::Chart-->
                                        </div>
                                        <!--end::Card body-->
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
        
        var randomizeArray = function (arg) {
        var array = arg.slice();
        var currentIndex = array.length, temporaryValue, randomIndex;

        while (0 !== currentIndex) {

            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
        }
        // data for the sparklines that appear below header area
        var sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46];

        // the default colorPalette for this dashboard
        //var colorPalette = ['#01BFD6', '#5564BE', '#F7A600', '#EDCD24', '#F74F58'];
        var colorPalette = ['#00D8B6','#008FFB',  '#FEB019', '#FF4560', '#775DD0']
        
        var spark1 = {
            chart: {
                id: 'sparkline1',
                group: 'sparklines',
                type: 'area',
                height: 160,
                sparkline: {
                enabled: true
                },
            },
            stroke: {
                curve: 'straight'
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: 'Sales',
                data: randomizeArray(sparklineData)
            }],
            labels: [...Array(24).keys()].map(n => `2018-09-0${n+1}`),
            yaxis: {
                min: 0
            },
            xaxis: {
                type: 'datetime',
            },
            colors: ['#DCE6EC'],
            title: {
                text: '$424,652',
                offsetX: 30,
                style: {
                fontSize: '24px',
                cssClass: 'apexcharts-yaxis-title'
                }
            },
            subtitle: {
                text: 'Sales',
                offsetX: 30,
                style: {
                fontSize: '14px',
                cssClass: 'apexcharts-yaxis-title'
                }
            }
        }
        new ApexCharts(document.querySelector("#spark1"), spark1).render();
    </script>
    @endpush