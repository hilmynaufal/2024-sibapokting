<div>
    @section('title')
    5. Rangkuman Informasi Objek Pajak
    @stop
    @section('menu')
    Layanan > BPHTB > <b>5. Rangkuman Informasi Objek Pajak</b>
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
                                        {{ $objek_pajak->jenisPerolehan->nm_jenis_transaksi}}
                                    </h4>
                                    <small class="text-muted">Layanan BPHTB</small>
                                </div>
                            </div>
                        </div>
                        <!--begin::Card title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-3">

                        @livewire('main.layanan.bphtb.detail.headkb',[Crypt::encrypt($this->id_bphtb)])

                    </div>
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
                                        1. Pihak Ke-1
                                    </h4>
                                    <small class="text-muted">Penerima Hak/Informasi Pembeli/Penerima Waris/Penerima
                                        Hibah/Pemenang Lelang</small>
                                </div>
                            </div>
                        </div>
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            @if(!empty($pembayaran_pajak->status_tagihan))
                                @if ($pembayaran_pajak->status_tagihan!="Aktif")
                                <a class="btn btn-light-success" wire:click="editPenerimaHak"><i class="fa fa-edit"></i>
                                    Edit
                                </a>
                                @endif
                            @endif
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-3">

                        @livewire('main.layanan.bphtb.detail.penerima-hak',[Crypt::encrypt($this->id_bphtb)])

                        <!--end::Section-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header">

                        <div class="card-title">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="mb-0 mt-1">
                                        2. Pihak Ke-2
                                    </h4>
                                    <small class="text-muted">Pelepas Hak/Informasi Penjual/Pemberi Waris/Pemberi
                                        Hibah/Penyelanggara Lelang</small>
                                </div>
                            </div>
                        </div>

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                        @if(!empty($pembayaran_pajak->status_tagihan))
                            @if ($pembayaran_pajak->status_tagihan!="Aktif")
                            <a class="btn btn-light-success" wire:click="editPelepasHak"><i class="fa fa-edit"></i>
                                Edit
                            </a>
                            @endif
                        @endif
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">

                        @livewire('main.layanan.bphtb.detail.pelepas-hak',[Crypt::encrypt($this->id_bphtb)])

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
                                        3. Informasi Objek Pajak
                                    </h4>
                                    <small class="text-muted">Informasi Nomor Objek Pajak (SPPT)</small>
                                </div>
                            </div>
                        </div>

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                        @if(!empty($pembayaran_pajak->status_tagihan))
                            @if ($pembayaran_pajak->status_tagihan!="Aktif")
                            <a class="btn btn-light-success" wire:click="editObjekPajak"><i class="fa fa-edit"></i>
                                Edit</a>
                            @endif
                        @endif
                        </div>
                        <!--end::Card toolbar-->

                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">

                        <!--begin::Section-->
                        <div class="mb-10">
                            @livewire('main.layanan.bphtb.detail.objek-pajak',[Crypt::encrypt($this->id_bphtb)])

                        </div>
                        <!--end::Section-->

                    </div>
                    <!--end::Card body-->
                </div>



                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h4>4. Perhitungan Objek Pajak: Self Assesment</h4>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                        @if(!empty($pembayaran_pajak->status_tagihan))
                            @if ($pembayaran_pajak->status_tagihan!="Aktif")
                            <a class="btn btn-light-success" wire:click="editObjekPajak"><i class="fa fa-edit"></i>
                                Edit</a>
                            @endif
                        @endif
                        </div>
                        <!--end::Card toolbar-->

                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-2">
                        @livewire('main.layanan.bphtb.detail.perhitungan',[Crypt::encrypt($this->id_bphtb)])
                    </div>

                </div>


                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h4>5. Perhitungan Objek Pajak: Office Assesment</h4>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                        @if(!empty($pembayaran_pajak->status_tagihan))
                            @if ($pembayaran_pajak->status_tagihan!="Aktif")
                            <a class="btn btn-light-success" wire:click="editObjekPajak"><i class="fa fa-edit"></i>
                                Edit</a>
                            @endif
                        @endif
                        </div>
                        <!--end::Card toolbar-->

                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-2">
                        @livewire('main.layanan.bphtb.detail.perhitungan-verifikasi',[Crypt::encrypt($this->id_bphtb)])

                    </div>

                </div>

                <!--begin::Card-->
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h4>6. Lampiran Berkas</h4>
                        </div>
                        <!--end::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                        @if(!empty($pembayaran_pajak->status_tagihan))
                            @if ($pembayaran_pajak->status_tagihan!="Aktif")
                            <a class="btn btn-light-success" wire:click="editMaps"><i class="fa fa-edit"></i> Edit</a>
                            @endif
                        @endif
                        </div>
                        <!--end::Card toolbar-->

                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-2">

                        @livewire('main.layanan.bphtb.detail.lampiran',[Crypt::encrypt($this->id_bphtb)])

                    </div>


                    <div class="card-footer">
                        <div class="btn-list">
                        @if(!empty($pembayaran_pajak->status_tagihan))
                            @if ($pembayaran_pajak->status_tagihan!="Aktif")
                            <a class="btn btn-danger pull-left" wire:click="backForm"><i class="fa fa-arrow-left"></i>
                                Sebelumnya</a>
                            @endif
                        @endif
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
                            <h4>Pembayaran</h4>
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
                        @livewire('main.layanan.bphtb.detail.pembayarankb',[Crypt::encrypt($this->id_bphtb)])
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Sidebar-->
        </div>
        <!--end::Layout-->
    </div>

</div>