<div>
    <div class="card-body p-10">
        <div class="row g-5 g-xl-10">
                @foreach ($model as $index => $item)
                <div class="col-sm-6 col-xl-4">
                    <div class="border border-dashed border-gray-300 rounded px-7 py-3                             
                            {!!
                                classInflasi(iphHarga($item->id,$date),iphHarga($item->id,$date_before),$item->nilai_peringatan)
                            !!} ribbon ribbon-top">
                            <div class="ribbon-label" style="background-color: #fefefe; color:black;">HET : {{rupiah($item->het,0)}}</div>
                        <!--begin::Info-->
                        <div class="d-flex flex-stack mb-3">
                            <!--begin::Wrapper-->
                            <div class="me-3">
                                <!--begin::Icon-->
                                <div class="symbol symbol-70px">
                                    <img src="{{ Storage::disk('public')->url($item->gambar) }}" alt="">
                                </div>
                                <!--end::Icon-->

                                <!--begin::Title-->
                                <a class="text-gray-800 text-hover-primary fw-bold">{{limitasiKarakter($item->namakomoditas,25)}}</a>
                                <!--end::Title-->
                            </div>
                            <!--end::Wrapper-->


                        </div>
                        <!--end::Info-->

                        <!--begin::Customer-->
                        <div class="d-flex flex-stack">
                            <!--begin::Name-->
                            <span class="text-gray-500 fw-bold">
                                Harga Minggu ini:
                                <div
                                    class="text-gray-800 text-hover-primary fw-bold">
                                    {{rupiah(iphHarga($item->id,$date),0)}} </div>
                                Harga Minggu Sebelumnya:
                                <div
                                    class="text-gray-800 text-hover-primary fw-bold">
                                    {{rupiah(iphHarga($item->id,$date_before),0)}} </div>
                            </span>
                            <!--end::Name-->

                            <!--begin::Label-->
                            {!!
                                inflasi(iphHarga($item->id,$date),iphHarga($item->id,$date_before),$item->nilai_peringatan)
                            !!}
                            <!--end::Label-->
                        </div>
                        <!--end::Customer-->
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div>
