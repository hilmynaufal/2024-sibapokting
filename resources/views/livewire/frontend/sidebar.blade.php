
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
        @if(!empty($komoditas_sekarang->komoditas_id))
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