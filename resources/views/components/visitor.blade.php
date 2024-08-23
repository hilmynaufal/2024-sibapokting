<div>
    <!--begin::Card-->
    <div class="card mb-4 bg-light text-center ">
        <!--begin::Body-->
        <div class="card-body py-12">
            <div class="d-flex flex-wrap d-grid gap-5 px-9 mb-5">   
                <!--begin::Item-->
                <div class="me-md-2">   
                    <!--begin::Statistics-->
                    <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ nilai($all,0) }}</span>                
                    </div>
                    <!--end::Statistics-->
    
                    <!--begin::Description-->
                    <span class="fs-6 fw-semibold text-gray-500">Semua Pengunjung</span>
                    <!--end::Description-->
                </div>
                <!--end::Item-->
    
                <!--begin::Item-->
                <div class="border-start-dashed border-start border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">   
                    <!--begin::Statistics-->
                    <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ nilai($month,0) }}</span>                
                    </div>
                    <!--end::Statistics-->
    
                    <!--begin::Description-->
                    <span class="fs-6 fw-semibold text-gray-500">Pengunjung Bulan ini</span>
                    <!--end::Description-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="border-start-dashed border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">   
                    <!--begin::Statistics-->
                    <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ nilai($week,0) }}</span>                
                    </div>
                    <!--end::Statistics-->

                    <!--begin::Description-->
                    <span class="fs-6 fw-semibold text-gray-500">Pengunjung Minggu ini</span>
                    <!--end::Description-->
                </div>
                <!--end::Item-->

                <!--begin::Item-->
                <div class="border-start-dashed border-start border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">   
                    <!--begin::Statistics-->
                    <div class="d-flex mb-2">
                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{ nilai($now,0) }}</span>                
                    </div>
                    <!--end::Statistics-->
    
                    <!--begin::Description-->
                    <span class="fs-6 fw-semibold text-gray-500">Pengunjung Hari ini</span>
                    <!--end::Description-->
                </div>
                <!--end::Item-->


            </div>
            <!--begin::Icon-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->
</div>

