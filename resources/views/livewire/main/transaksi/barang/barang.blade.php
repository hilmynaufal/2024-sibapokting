
@section('title')
    Transaksi Ketersediaan Stok Barang
@stop
@section('menu')
    Layanan > Transaksi > <b>Transaksi Ketersediaan Stok Barang</b>
@stop

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

<!--begin::Col-->
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-lg-12 col-xxl-12">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Harga Pangan Kabupaten Bandung</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        data-bs-original-title="Click to add a user" data-kt-initialized="1">
                        <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.barang.add'})" class="btn btn-sm btn-light btn-active-primary">
                            <i class="ki-duotone ki-plus fs-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3" >
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <div class="col-sm-12 col-md-6">
                            <select wire:model.live="perpage" class="form-select form-select-sm" style="width: 75px;">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="kt_advance_table_widget_2">
                            <thead>
                                <tr class="text-uppercase">
                                    <th rowspan="2" >Nama Pasar
                                        @if ($sortColoumName === 'id_pasar')
                                        <span wire:click="sortBy('id_pasar')" class="float-end text-sm"
                                            style="cursor: pointer;">
                                            <i
                                                class="{{ $sortColoumName === 'id_pasar' && $sortDirection === 'desc' ? ' fas fa-sort-up ' : 'fas fa-sort-down' }}"></i>
                                        </span>
                                        @else
                                        <span wire:click="sortBy('id_pasar')" class="float-end text-sm"
                                            style="cursor: pointer;">
                                            <i class="fas fa-sort"></i>
                                        </span>
                                        @endif
                                    </th>
                                    <th rowspan="2" >Nama Barang</th>
                                    <th rowspan="2" >Tanggal</th>
                                    <th rowspan="2" >Stok Awal</th>
                                    <th style="text-align:center;" colspan="2">Informasi Barang</th>
                                    <th rowspan="2">Stok Akhir</th>
                                    <th rowspan="2">Action</th>
                                </tr>
                                <tr class="text-uppercase">
                                    <th>Barang Masuk</th>
                                    <th>Barang Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model as $index => $item)
                                <tr>
                                    <td>
                                        {{ $item->toPasar->namapasar }}
                                    </td>
                                    <td>
                                        {{ $item->toBarang->namabarang }}
                                        <span class="badge badge-light-primary">{{$item->toBarang->toSatuan->satuan}}</span>
                                    </td>
                                    <td>
                                        {{ TglTimeIndo($item->tanggal)}}
                                    </td>
                                    <td>
                                        {{ rupiah($item->harga_publish,0)}}
                                        {!! dinamikaHarga($item->id,$item->detail_tgl) !!}
                                    </td>
                                    <td>
                                        {{ rupiah(hargaSebelum($item->id,$item->detail_tgl),0) }}
                                    </td>
                                    <td>
                                        <div class="btn-list">
                                            <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.barang.view' , arguments: { id: {{ $item->id }} }})"
                                                class="btn btn-sm btn-icon btn-light-primary btn-active-light-default me-1"
                                                title="Ubah">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.barang.edit' , arguments: { id: {{ $item->id }} }})"
                                                class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1"
                                                title="Lihat">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <button wire:click="deleteRequest({{ $item->id }})"
                                                class="btn btn-sm btn-icon btn-light-danger btn-active-light-default me-1"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>


                        <div class="col-sm-12 col-md-12">
                            <div class="float-start">
                            Menampilkan {{ $model->firstItem() }} - {{ $model->lastItem() }} dari {{$model->total() }}
                            entri
                            </div>
                            <div class="float-end">
                                {{ $model->links() }}
                            </div>
                        </div>


                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Body-->
            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    $("#tanggal").flatpickr();
</script>
@endpush