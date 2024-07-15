@section('title')
Detail Event
@stop
@section('utama')
Informasi
@stop
@section('submenu')
Event
@stop
<div>
@livewire('Frontend.Sidebar')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl ">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid me-xl-15">
                        <!--begin::Post content-->
                        <div class="mb-17">
                            <!--begin::Wrapper-->
                            <div class="mb-8">
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-6">
                                    <!--begin::Item-->
                                    <div class="me-9 my-1">
                                        <!--begin::Icon-->
                                        <i class="ki-outline ki-element-11 text-primary fs-2 me-1"></i>
                                        <!--end::Icon-->

                                        <!--begin::Label-->
                                        <span class="fw-bold text-gray-500">{{tglIndo($detail->tanggal)}}</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="me-9 my-1">
                                        <!--begin::Icon-->
                                        <i class="ki-outline ki-briefcase text-primary fs-2 me-1"></i>
                                        <!--end::Icon-->

                                        <!--begin::Label-->
                                        <span class="fw-bold text-gray-500">{{$detail->toKategori->nama}}</span>
                                        <!--begin::Label-->
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="my-1">
                                        <!--begin::Icon-->
                                        <i class="ki-outline ki-abstract-45 text-primary fs-2 me-1"></i>
                                        <!--end::Icon-->

                                        <!--begin::Label-->
                                        <span class="fw-bold text-gray-500">{{$detail->hit}} View</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Info-->

                                <!--begin::Title-->
                                <a class="text-gray-900 text-hover-primary fs-2 fw-bold">
                                    {{$detail->judul}}
                                </a>
                                <!--end::Title-->

                                <!--begin::Container-->
                                <div class="overlay mt-8">
                                    <!--begin::Image-->
                                    <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-350px"
                                        style="background-image:url('{{Storage::disk('public')->url($detail->gambar)}}')">
                                    </div>
                                    <!--end::Image-->
                                </div>
                                <!--end::Container-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Description-->
                            <div class="fs-5 fw-semibold text-gray-600">
                                <!--begin::Text-->
                                <p class="mb-8">
                                    {!! $detail->konten !!}
                                </p>
                                <!--end::Text-->
                            </div>
                            <!--end::Description-->

                            <!--begin::Block-->
                            <div class="d-flex align-items-center border-1 border-dashed card-rounded p-5 p-lg-10 mb-14">
                                <!--begin::Section-->
                                <div class="text-center flex-shrink-0 me-7 me-lg-13">
                                    <!--begin::Info-->
                                    <div class="mb-0">
                                        <a class="text-gray-700 text-hover-primary">{{$detail->toUser->nama}}</a>
                                        <span class="text-muted">on {{tglIndo($detail->created_at)}}</span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Block-->

                        </div>
                        <!--end::Post content-->
                    </div>
                    <!--end::Content-->

                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-10">

                        <!--begin::Recent posts-->
                        <div class="m-0">
                            <h4 class="text-gray-900 mb-7">Event Lainnya</h4>
                            @foreach($list_event as $list)
                            <!--begin::Item-->
                            <div class="d-flex flex-stack mb-7">
                                <!--begin::Symbol-->

                                <div class="symbol symbol-60px symbol-2by3 me-4">
                                    <div class="symbol-label"
                                        style="background-image: url('{{Storage::disk('public')->url($list->gambar)}}')">
                                    </div>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Title-->
                                <div class="m-0">
                                    <a href="{{route('eventdetail',[Crypt::encrypt($list->id)])}}" class="text-gray-900 fw-bold text-hover-primary fs-6">{{strlen($list->judul) > 20 ? substr($list->judul, 0, 20)
                                                        . '...' : $list->judul}}</a>

                                    <span class="text-gray-600 fw-semibold d-block pt-1 fs-7">{!! strlen($list->konten) > 50 ? substr($list->konten, 0, 50)
                                                        . '...' : $list->konten !!}
                                        sky</span>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Item-->
                            @endforeach
                        </div>
                        <!--end::Recent posts-->
                    </div>
                    <!--end::Sidebar-->
                </div>
                <!--end::Layout-->

            </div>
        </div>
    </div>
</div


