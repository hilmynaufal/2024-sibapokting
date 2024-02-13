@push('css')
<style>
    .select2-container--open {
        z-index: 999999999;
    }

    .select2-container {
        z-index: 999999999;
    }
</style>
@endpush
<div>
    @section('title')
    Verifikasi BPHTB
    @stop
    @section('menu')
    Layanan > BPHTB > <b>Verifikasi BPHTB</b>
    @stop
    <div id="kt_app_content_container" class="app-container  container-xxl ">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">

                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="mb-0 mt-1">
                                        {{Auth::user()->nama;}}
                                    </h4>
                                    <small
                                        class="text-muted">{{Auth::user()->unit_kerja;}}-{{Auth::user()->satuan_kerja;}}</small>
                                </div>
                            </div>
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-3">
                        @livewire('main.layanan.bphtb.detail.head',[Crypt::encrypt($this->id_bphtb)])
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-light-danger"><i class="fa fa-close"></i> Data Tidak
                            Sesuai</a>&nbsp;&nbsp;
                        <a class="btn btn-light-primary"><i class="fa fa-check"></i> Data Sesuai</a>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="mb-0 mt-1">
                                        VERIFIKASI PERSYARATAN
                                    </h4>
                                    <small class="text-muted">Oleh Pelayanan Verifikasi</small>
                                </div>
                            </div>
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <!-- <div class="card-toolbar">
                            <a class="btn btn-light-danger"><i class="fa fa-close"></i> Data Tidak
                                Sesuai</a>&nbsp;&nbsp;
                            <a class="btn btn-light-primary"><i class="fa fa-check"></i> Data Sesuai</a>
                        </div> -->
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-3">
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-striped text-nowrap dataTable no-footer" id="tableLampiran">
                                <thead>
                                    <tr>
                                        <td align="center"><b>Ceklis</b></td>
                                        <td align="center"><b>Persyaratan</b></td>
                                        <td align="center"><b>Jenis</b></td>
                                        <td align="center"><b>file</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($persyaratan as $syarat)
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckStatus{{ $syarat->id }}"
                                                    wire:click="status({{ $syarat->id }})"
                                                    {{$syarat->status_verifikasi == 1 ? 'checked' : '' }} />
                                        </td>
                                        <td>
                                                <label class="form-check-label text-center text-gray-800"
                                                    for="flexCheckDefault">
                                                    {{$syarat->nama_persyaratan}}
                                                    @if($syarat->is_required == 1)
                                                    <span
                                                        class="badge badge-changelog badge-light-success fw-semibold fs-8 px-2 ms-2">wajib</span>
                                                    @else
                                                    <span
                                                        class="badge badge-changelog badge-light-danger fw-semibold fs-8 px-2 ms-2">tidak
                                                        wajib</span>
                                                    @endif
                                                </label>
                                        </td>
                                        <td>
                                            @if($syarat->jenis_persyaratan == 1)
                                                <label class="form-check-label text-center text-gray-800"for="flexCheckDefault"> Verifikasi </label>
                                            @elseif($syarat->jenis_persyaratan == 2)
                                                <label class="form-check-label text-center text-gray-800"for="flexCheckDefault"> Validasi </label>
                                            @elseif($syarat->jenis_persyaratan == 3)
                                                <label class="form-check-label text-center text-gray-800"for="flexCheckDefault"> Pelaporan </label>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($syarat->file_dokumen==NULL)
                                                <a class="btn btn-sm btn-icon btn-light-danger btn-active-light-default me-1" title="Tidak Ada Data">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                            @else

                                                <a target="_blank"
                                                    href="{{ asset($syarat->file_dokumen) }}"
                                                    class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1" title="Download">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <div class="card">
                    <div class="card-header align-items-center border-0">
                        <h3 class="fw-bold text-gray-900 m-0">Detail Objek Pajak</h3>
                        <!-- <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                <i class="ki-outline ki-dots-square fs-1"></i>                             
                            </button>   -->
                    </div>
                    <div class="card-body pt-2">
                        <ul class="nav nav-pills nav-pills-custom mb-3" role="tablist">
                            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-85px min-w-100px py-4 active" style="width: 135px;"
                                    data-bs-toggle="pill" href="#kt_stats_widget_2_tab_1" aria-selected="false"
                                    role="tab" tabindex="-1">
                                    <!--begin::Icon-->
                                    <div class="nav-icon">
                                        <img alt=""
                                            src="{{ asset('backend/themes/assets/media/object/pihak1.svg') }}"
                                            class="">
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Subtitle-->
                                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-center mt-2">
                                        Pihak 1
                                    </span>
                                    <!--end::Subtitle-->

                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                <!--begin::Link-->
                                <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-85px min-w-100px py-4" style="width: 135px;"
                                    data-bs-toggle="pill" href="#kt_stats_widget_2_tab_2" aria-selected="false"
                                    role="tab" tabindex="-1">
                                    <!--begin::Icon-->
                                    <div class="nav-icon">
                                        <img alt=""
                                            src="{{ asset('backend/themes/assets/media/object/pihak2.svg') }}"
                                            class="">
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Subtitle-->
                                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-center mt-2">
                                        Pihak 2
                                    </span>
                                    <!--end::Subtitle-->

                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                <!--begin::Link-->
                                <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-85px min-w-100px py-4" style="width: 135px;"
                                    data-bs-toggle="pill" href="#kt_stats_widget_2_tab_3" aria-selected="false"
                                    role="tab" tabindex="-1">
                                    <!--begin::Icon-->
                                    <div class="nav-icon">
                                        <img alt=""
                                            src="{{ asset('backend/themes/assets/media/object/objek.svg') }}"
                                            class="">
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Subtitle-->
                                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-center mt-2">
                                        Objek Pajak
                                    </span>
                                    <!--end::Subtitle-->

                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                                <!--begin::Link-->
                                <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-85px min-w-100px py-4" style="width: 135px;"
                                    data-bs-toggle="pill" href="#kt_stats_widget_2_tab_4" aria-selected="false"
                                    role="tab" tabindex="-1">
                                    <!--begin::Icon-->
                                    <div class="nav-icon">
                                        <img alt=""
                                            src="{{ asset('backend/themes/assets/media/object/self.svg') }}"
                                            class="nav-icon">
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Subtitle-->
                                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-center mt-2">
                                        Self Assesment
                                    </span>
                                    <!--end::Subtitle-->

                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            @if(!empty($objek_pajak_verifikasi))
                            <!--begin::Item-->
                            <li class="nav-item mb-3" role="presentation">
                                <!--begin::Link-->
                                <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden h-85px min-w-100px py-4" style="width: 135px;"
                                    data-bs-toggle="pill" href="#kt_stats_widget_2_tab_5" aria-selected="true"
                                    role="tab">
                                    <!--begin::Icon-->
                                    <div class="nav-icon">
                                        <img alt=""
                                            src="{{ asset('backend/themes/assets/media/object/office.svg') }}"
                                            class="nav-icon">
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Subtitle-->
                                    <span class="nav-text text-gray-600 fw-bold fs-6 lh-1 text-center mt-2">
                                        Office Assesment
                                    </span>
                                    <!--end::Subtitle-->

                                    <!--begin::Bullet-->
                                    <span
                                        class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                    <!--end::Bullet-->
                                </a>
                                <!--end::Link-->
                            </li>
                            <!--end::Item-->
                            @endif
                        </ul>
                        <!--end::Nav-->

                        <!--begin::Tab Content-->
                        <div class="tab-content">

                            <!--begin::Tap pane-->
                            <div class="tab-pane fade active show" id="kt_stats_widget_2_tab_1" role="tabpanel">
                                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                                    <div class="card-header" data-bs-toggle="collapse">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h4 class="mb-0 mt-1">
                                                        Pihak Ke-1
                                                    </h4>
                                                    <small class="text-muted">Penerima Hak/Informasi Pembeli/Penerima Waris/Penerima
                                                        Hibah/Pemenang Lelang</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <a class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1" title="Ubah Data"
                                            wire:click="$dispatch('openModal', { component: 'main.layanan.bphtb.modal.penerima-hak' , arguments: { id: {{ $this->id_bphtb }} }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-3">
                                        @livewire('main.layanan.bphtb.detail.penerimahak',[Crypt::encrypt($this->id_bphtb)])
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <!--end::Tap pane-->

                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_stats_widget_2_tab_2" role="tabpanel">
                            <div class="card card-flush pt-3 mb-5 mb-xl-10">
                                    <div class="card-header" data-bs-toggle="collapse">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h4 class="mb-0 mt-1">
                                                        Pihak Ke-2
                                                    </h4>
                                                    <small class="text-muted">Pelepas Hak/Informasi Penjual/Pemberi Waris/Pemberi
                                                        Hibah/Penyelanggara Lelang</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <a class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1" title="Ubah Data"
                                            wire:click="$dispatch('openModal', { component: 'main.layanan.bphtb.modal.pelepas-hak' , arguments: { id: {{ $this->id_bphtb }} }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-3">
                                        @livewire('main.layanan.bphtb.detail.pelepashak',[Crypt::encrypt($this->id_bphtb)])
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <!--end::Tap pane-->

                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_stats_widget_2_tab_3" role="tabpanel">
                            <div class="card card-flush pt-3 mb-5 mb-xl-10">
                                    <div class="card-header" data-bs-toggle="collapse">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h4 class="mb-0 mt-1">
                                                        Informasi Objek Pajak
                                                    </h4>
                                                    <small class="text-muted">Informasi Nomor Objek Pajak (SPPT)</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!-- <a class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1" title="Ubah Data"
                                            wire:click="$dispatch('openModal', { component: 'main.layanan.bphtb.modal.penerima-hak' , arguments: { id: {{ $this->id_bphtb }} }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </a> -->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-3">
                                        @livewire('main.layanan.bphtb.detail.objekpajak',[Crypt::encrypt($this->id_bphtb)])
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <!--end::Tap pane-->

                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_stats_widget_2_tab_4" role="tabpanel">
                            <div class="card card-flush pt-3 mb-5 mb-xl-10">
                                    <div class="card-header" data-bs-toggle="collapse">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h4>Perhitungan Objek Pajak: Self Assesment</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!-- <a class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1" title="Ubah Data"
                                            wire:click="$dispatch('openModal', { component: 'main.layanan.bphtb.modal.penerima-hak' , arguments: { id: {{ $this->id_bphtb }} }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </a> -->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-3">
                                        @livewire('main.layanan.bphtb.detail.perhitungan',[Crypt::encrypt($this->id_bphtb)])
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <!--end::Tap pane-->

                            @if(!empty($objek_pajak_verifikasi))
                            <!--begin::Tap pane-->
                            <div class="tab-pane fade" id="kt_stats_widget_2_tab_5" role="tabpanel">
                                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                                    <div class="card-header" data-bs-toggle="collapse">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h4 class="mb-0 mt-1">
                                                        Perhitungan Objek Pajak: Office Assesment
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!-- <a class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1" title="Ubah Data"
                                            wire:click="$dispatch('openModal', { component: 'main.layanan.bphtb.modal.penerima-hak' , arguments: { id: {{ $this->id_bphtb }} }})">
                                                <i class="bi bi-pencil-square"></i>
                                            </a> -->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body pt-3">
                                        @livewire('main.layanan.bphtb.detail.perhitungan-verifikasi',[Crypt::encrypt($this->id_bphtb)])
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <!--end::Tap pane-->
                            @endif
                        </div>
                        <!--end::Tab Content-->
                    </div>
                    <!--end: Card Body-->
                </div>
            </div>
            <!--end::Content-->

            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2"
                id="subscription-summary">
                <!--begin::Card-->
                <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary"
                    data-kt-sticky-offset="{default: false, lg: '200px'}"
                    data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto"
                    data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95" style="">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Pembayaran</h2>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::More options-->
                            <a href="#" class="btn btn-sm btn-light btn-icon" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-outline ki-dots-square fs-3"></i> </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-6 w-200px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link text-danger px-3"
                                        data-kt-subscriptions-view-action="edit">
                                        Batalkan Permohonan
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                            <!--end::More options-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0 fs-6">
                        <!--begin::Section-->
                        @livewire('main.layanan.bphtb.detail.pembayaran',[Crypt::encrypt($this->id_bphtb)])

                    </div>
                    <!--end::Section-->
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->
        </div>
        <!--end::Layout-->
    </div>

</div>
