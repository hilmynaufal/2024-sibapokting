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
    Verifikasi BPHTB Kurang Bayar
    @stop
    @section('menu')
    Layanan > Verifikasi > <b>Verifikasi BPHTB Kurang Bayar</b>
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
                        @livewire('main.layanan.bphtb.detail.head-kb',[Crypt::encrypt($this->id_bphtb)])
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
                                    <small
                                        class="text-muted">Oleh Pelayanan Verifikasi</small>
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
                        <div class="row">
                    
                                <TABLE class="table table-hover table-striped">
                                <thead>
                                    <TR>
                                        <TD align="center"><b>Ceklis</b></TD>
                                        <TD align="center"><b>Persyaratan</b></TD>
                                        <TD align="center"><b>file</b></TD>
                                    </TR>
                                </thead>
                                <TBODY>
                                {{-- @dump($persyaratan) --}}
                                @foreach($persyaratan as $syarat)
                                <tr>
                                    <td>
                                        <div class="form-check m-5">
                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckStatus{{ $syarat->id }}" wire:click="status({{ $syarat->id }})" {{$syarat->status_verifikasi == 1 ? 'checked' : '' }} />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check m-5">
                                            <label class="form-check-label text-center text-gray-800" for="flexCheckDefault">
                                                {{$syarat->nama_persyaratan}}
                                                @if($syarat->is_required == 1)
                                                    <span class="badge badge-changelog badge-light-success fw-semibold fs-8 px-2 ms-2">wajib</span>
                                                @else
                                                    <span class="badge badge-changelog badge-light-danger fw-semibold fs-8 px-2 ms-2">tidak wajib</span>
                                                @endif
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                            @if ($syarat->file_dokumen==NULL)
                                            <a class="btn btn-light-danger mb-3 float-end disabled btn-block">Belum Upload</a>  
                                            @else
                                            <a class="btn btn-success mb-3 float-end btn-block" href="{{ asset($syarat->file_dokumen) }} ">Download </a>  
                                            @endif
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </TBODY>
                            </TABLE>


                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">

                    <!--begin::Card header-->
                    <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
                        data-bs-target="#pemberi_hak">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bold">1. Pihak Pertama</h2>
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <i class="ki-duotone ki-down fs-1"></i>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div id="pemberi_hak" class="collapse">
                        <div class="card-body pt-3">
                            @livewire('main.layanan.bphtb.detail.penerimahak',[Crypt::encrypt($this->id_bphtb)])
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-light-success" wire:click="$dispatch('openModal', { component: 'main.layanan.bphtb.modal.penerima-hak' , arguments: { id: {{ $this->id_bphtb }} }})"><i class="fa fa-edit"></i>
                        Edit
                        </a>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
                        data-bs-target="#penerima_hak">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>2. Pihak Kedua</h2>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <i class="ki-duotone ki-down fs-1"></i>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div id="penerima_hak" class="collapse">
                        <div class="card-body pt-0">
                            @livewire('main.layanan.bphtb.detail.pelepashak',[Crypt::encrypt($this->id_bphtb)])
                        </div>
                    </div>
                    <!--end::Card body-->

                    <div class="card-footer">
                            <a class="btn btn-light-success" wire:click="$dispatch('openModal', { component: 'main.layanan.bphtb.modal.pelepas-hak' , arguments: { id: {{ $this->id_bphtb }} }})"><i class="fa fa-edit"></i>
                            Edit
                            </a>
                    </div>
                </div>
                <!--end::Card-->

                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
                        data-bs-target="#objek_pajak">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>3. Informasi Objek Pajak</h2>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <a class="btn btn-light-success" wire:click="editObjekPajak"><i class="fa fa-edit"></i>
                                Edit</a>
                            <i class="ki-duotone ki-down fs-1"></i>
                        </div>
                        <!--end::Card toolbar-->

                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div id="objek_pajak" class="collapse">
                        <div class="card-body pt-2">
                            @livewire('main.layanan.bphtb.detail.objekpajak',[Crypt::encrypt($this->id_bphtb)])
                        </div>
                    </div>

                </div>

                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
                        data-bs-target="#perhitungan">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>4. Perhitungan</h2>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <a class="btn btn-light-success" wire:click="editMaps"><i class="fa fa-edit"></i> Edit</a>
                            <i class="ki-duotone ki-down fs-1"></i>
                        </div>
                        <!--end::Card toolbar-->

                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div id="perhitungan" class="collapse">
                        <div class="card-body pt-2">


                        </div>
                    </div>

                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
                        data-bs-target="#pembayaran">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>5. Lampiran</h2>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <a class="btn btn-light-success" wire:click="editMaps"><i class="fa fa-edit"></i> Edit</a>
                            <i class="ki-duotone ki-down fs-1"></i>
                        </div>
                        <!--end::Card toolbar-->

                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div id="pembayaran" class="collapse">
                        <div class="card-body pt-2">

                            @livewire('main.layanan.bphtb.detail.lampiran',[Crypt::encrypt($this->id_bphtb)])

                        </div>
                    </div>

                    <!--end::Card body-->
                </div>
                <!--end::Card-->
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
                        @livewire('main.layanan.bphtb.detail.pembayaran-kb',[Crypt::encrypt($this->id_bphtb)])
                        
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


