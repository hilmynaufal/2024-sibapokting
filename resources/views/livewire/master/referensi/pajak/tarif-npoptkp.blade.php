@section('title')
Tarif NPOPTKP
@stop
@section('menu')
Referensi > Pajak > <b>Tarif NPOPTKP</b>
@stop
<!--begin::Col-->

<div class="row gx-6 gx-xl-9">
    <div class="col-lg-{{$isOpen ? '8' : '12' }} col-xxl-{{$isOpen ? '8' : '12' }}">
        <!--begin::Tables widget 14-->
        <div class="card card-flush h-md-100">
            <!--begin::Card header-->
            <div class="card-header align-items-center gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i> <input type="text"
                            data-kt-ecommerce-product-filter="search" wire:model.live="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari Dasar Hukum">
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div class="w-400 mw-550px" wire:ignore>
                        <select x-init="$($el).select2({ placeholder: '-- Pilih Jenis --', });
                        $($el).on('change', function() {
                            $wire.set('searchJenis', $($el).val())
                        })" wire:model.live="searchJenis"  name="searchJenis" id="searchJenis" class="form-control form-control-lg">
                                <option value=""></option>
                                @foreach($perolehan_list as $perolehan)
                                    <option value="{{$perolehan->id}}">[{{$perolehan->kd_jenis_transaksi}}] - {{$perolehan->nm_jenis_transaksi}}</option>
                                @endforeach
                        </select>
                    </div>
                    <button wire:click="toggle" class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i>
                        Tambah</button>
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Body-->
            <div class="card-body pt-2">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-uppercase">
                                <th class="pl-0" style="min-width: 100px">Jenis Transaksi </th>
                                <th class="pl-0" style="min-width: 100px">Tarif </th>
                                <th class="pl-0" style="min-width: 100px">Tarif Tambahan </th>
                                <th class="pl-0" style="min-width: 100px">Awal Berlaku </th>
                                <th class="pl-0" style="min-width: 100px">Akhir Berlaku </th>
                                <th class="pl-0" style="min-width: 100px">Dasar Hukum </th>
                                <th class="pr-0 text-right" style="min-width: 160px">#</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            @forelse ($model as $index => $item)
                            <tr>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->jenisPerolehan->nm_jenis_transaksi}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">Rp. {{ number_format($item->tarif, 0, ",", ".")}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->tarif_tambahan}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->tahun_awal_berlaku}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->tahun_akhir_berlaku}}</span>
                                </td>
                                <td>
                                    <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->dasar_hukum}}</span>
                                </td>
                                <td>
                                    <div class="btn-list text-right">
                                        <a href="#" wire:click="edit({{ $item->id }})" class="btn btn-sm btn-primary"
                                            title="Update">
                                            <span class="fas fa-edit"> </span>
                                        </a>&nbsp;
                                        <a href="#" wire:click="deleteRequest({{ $item->id }})" class="btn btn-sm btn-danger">
                                            <span class="fas fa-trash"> </span>
                                        </a>&nbsp;
                                    </div>
                                </td>
                            </tr>

                            @empty
                            <tr class="odd">
                                <td valign="top" colspan="8" class="dataTables_empty">Data Tidak Ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>

                <div class="row">
                    <div
                        class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="dataTables_length" id="kt_ecommerce_products_table_length">
                            <label>
                                <select name="kt_ecommerce_products_table_length"
                                    aria-controls="kt_ecommerce_products_table"
                                    class="form-select form-select-sm form-select-solid" wire:model.live="perpage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div
                        class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                        <div class="dataTables_paginate paging_simple_numbers"
                            id="kt_ecommerce_products_table_paginate">
                            {{ $model->links() }}
                        </div>
                    </div>
                    
                    
                    <div class="col-sm-12 col-md-6">
                        Menampilkan {{ $model->firstItem() }} - {{ $model->lastItem() }} dari {{$model->total() }} entri
                    </div>
                </div>
                <!--end::Table-->
            </div>
            <!--end: Card Body-->
        </div>
        <!--end::Tables widget 14-->
    </div>
    @if ($isOpen)
    <div class="col-lg-4 col-xxl-4">
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <form action="">
                <!--begin::General options-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{!!$actionTitle!!} @yield('title')</h2>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                            <label class="required form-label">Jenis Transaksi</label>
                            <select x-init="$($el).select2({ placeholder: '-- Jenis Perolehan --', });
                            $($el).on('change', function() {
                                $wire.set('jenis_transaksi_id', $($el).val())
                            })" 
                                wire:model.live="jenis_transaksi_id" name="jenis_transaksi_id" id="jenis_transaksi_id" class="form-control form-control-lg form-select-solid" required>
                                <option value=""></option>
                                @foreach($perolehan_list as $valuePerolehan)
                                    <option value="{{$valuePerolehan->id}}">[{{$valuePerolehan->kd_jenis_transaksi}}] - {{$valuePerolehan->nm_jenis_transaksi}}</option>
                                @endforeach
                            </select>
                            @error('jenis_transaksi_id')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                {{ $message }} 
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Tarif</label>
                            <input type="hidden" class="form-control  @error('id_tarif_npoptkp') is-invalid @enderror" wire:model="id_tarif_npoptkp" />
                            <input type="number" class="form-control  @error('tarif') is-invalid @enderror" wire:model="tarif" required/>
                            @error('tarif')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-3 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Tarif Tambahan</label>
                            <input type="number" class="form-control  @error('tarif_tambahan') is-invalid @enderror" wire:model="tarif_tambahan" required/>
                            @error('tarif_tambahan')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-3 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Dasar Hukum</label>
                            <input type="text" class="form-control  @error('dasar_hukum') is-invalid @enderror" wire:model="dasar_hukum" required/>
                            @error('dasar_hukum')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-3 fv-row fv-plugins-icon-container" wire:ignore>
                            <label class="required form-label">Status</label>
                            <select x-init="$($el).select2({ placeholder: '-- Status Hukum --', });
                            $($el).on('change', function() {
                                $wire.set('status', $($el).val())
                            })" wire:model.live="status" name="status" id="status" class="form-control form-control-lg form-select-solid" required>
                                <option value=""></option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                            @error('status')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-3 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Tahun Awal Berlaku</label>
                            <input type="number" class="form-control  @error('tahun_awal_berlaku') is-invalid @enderror" wire:model="tahun_awal_berlaku" required/>
                            @error('tahun_awal_berlaku')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="mb-3 fv-row fv-plugins-icon-container">
                            <label class="required form-label">Tahun Awal Berlaku</label>
                            <input type="number" class="form-control  @error('tahun_akhir_berlaku') is-invalid @enderror" wire:model="tahun_akhir_berlaku" required/>
                            @error('tahun_akhir_berlaku')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                {{ $message }} </div>
                            @enderror
                        </div>
                    </div>
                    <!--end::Card header-->
                    <div class="card-footer pt-0">
                        <button type="button" wire:offline.attr="disabled" wire:loading.class.remove="btn-primary"
                            wire:loading.attr="disabled" @if ($mode=='create' ) wire:click.prevent="store" @else
                            wire:click.prevent="update" @endif class="btn btn-success">
                            <i class="fa fa-save"></i>
                            {{ $mode == 'create' ? 'Simpan' : 'Edit' }}
                            <span wire:loading @if ($mode=='create' ) wire:target="store" @else wire:target="update"
                                @endif class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </button>
                        <button type="button" wire:click.prevent="cancel" wire:click="toggle"
                            class="btn btn-secondary">Batal</button>

                    </div>
                </div>
                <!--end::General options-->

            </form>
        </div>
    </div>
    @endif
</div>

<!--end::Col-->

@push('meta')
<meta name="turbolinks-visit-control" content="reload">
<meta name="turbolinks-cache-control" content="no-cache">
@endpush
@push('js')
<script>
    window.addEventListener('swal:deleteRequest', event => {
        Swal.fire({
            title: event.detail[0].title,
            text: event.detail[0].text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                @this.call('deleteSelectedRequest', event.detail[0].id);
                Swal.fire({
                    title: 'Data Berhasil tersimpan',
                    icon: 'success'
                });
            } else {
                Swal.fire({
                    title: 'Operasi Dibatalkan',
                    icon: 'success'
                });
            }
        });
    });
</script>
@endpush