<div>
    @section('title', 'Permohonan SSPD')

    <div class="row">

            <div>
                <!--begin::Card header-->
                <div class="card-header align-items-center gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i> <input type="text"
                                data-kt-ecommerce-product-filter="search" wire:model.live="search"
                                class="form-control form-control-solid w-250px ps-12" placeholder="Cari No. Registrasi">
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->

                    <!--begin::Card toolbar-->
                    <!-- <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <button wire:click="createForm" class="btn btn-primary btn-sm" type="button"><i
                                class="fa fa-plus"></i>
                            Tambah </button>
                    </div> -->
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--end::Header-->

                <!--begin::Table-->
                <div class="table-responsive">

                    <table class="table table-head-custom table-vertical-center table-hover table-striped"
                        id="kt_advance_table_widget_2">
                        <thead>
                            <tr class="text-uppercase">
                                <th class="pl-0" style="min-width: 100px text-center;">

                                    <label>
                                        <select name="kt_ecommerce_products_table_length"
                                            aria-controls="kt_ecommerce_products_table"
                                            class="form-select form-select-sm form-select-solid"
                                            wire:model.live="perpage">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </label>
                                </th>
                                <th style="min-width: 120px text-center">NO. REGISTRASI</th>
                                <th style="min-width: 120px text-center">PENERIMA HAK</th>
                                <th style="min-width: 120px text-center">TANGGAL PENGAJUAN</th>
                                <th style="min-width: 120px text-center">JENIS PEROLEHAN</th>
                                <th style="min-width: 120px text-center">NILAI TRANSAKSI</th>
                                <th style="min-width: 120px text-center">STATUS BERKAS</th>
                                <th style="min-width: 120px text-center">DIPROSES OLEH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $index => $item)
                            <tr>
                                <td class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">
                                    <a href="{{route('main.verifikasi.bphtbkb.detail', [Crypt::encrypt($item->id_bphtb)])}}"  class="btn btn-sm btn-icon btn-light-success btn-active-light-success  me-1" 
                                    type="button" data-bs-toggle="tooltip" title="Verifikasi Data">
                                    <i class="ki-outline bi-calendar2-check fs-3"></i>
                                </a>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->no_registrasi}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->penerimaHak->nama_wp}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ tglIndo($item->tanggal_pendaftaran)}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->objekPajak->jenisPerolehan->nm_jenis_transaksi}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ rupiah($item->total_tagihan,2)}}</span><br>
                                    <span class="badge badge-light-success">{{ $item->status_bayar }}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{!! statusBerkas($item->id_bphtb) !!}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->notaris->nama}}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>



                </div>
                <!--end::Table-->

            </div>

    </div>
</div>