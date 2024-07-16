<div>
    <!--begin::Card-->
    <div class="card mb-4 bg-light text-center ">
        <!--begin::Body-->
        <div class="card-body py-12">
            <!--begin::Icon-->
            <div class="d-flex gap-4 gap-lg-13">
                <!--begin::Item-->
                <div class="d-flex flex-column">
                    <!--begin::Number-->
                    <span class="text fw-bold fs-3 mb-1">{{ nilai($all,0) }}</span>
                    <!--end::Number-->

                    <!--begin::Section-->
                    <div class="text opacity-50 fw-bold">Semua Pengunjung</div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-column">
                    <!--begin::Number-->
                    <span class="text fw-bold fs-3 mb-1">{{ nilai($month,0) }}</span>
                    <!--end::Number-->

                    <!--begin::Section-->
                    <div class="text opacity-50 fw-bold">Pengunjung bulan ini</div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-column">
                    <!--begin::Number-->
                    <span class="text fw-bold fs-3 mb-1">{{ nilai($week,0) }}</span>
                    <!--end::Number-->

                    <!--begin::Section-->
                    <div class="text opacity-50 fw-bold">Pengunjung minggu ini</div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex flex-column">
                    <!--begin::Number-->
                    <span class="text fw-bold fs-3 mb-1">{{ nilai($now,0) }}</span>
                    <!--end::Number-->

                    <!--begin::Section-->
                    <div class="text opacity-50 fw-bold">Pengunjung hari ini</div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->

            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
</div>