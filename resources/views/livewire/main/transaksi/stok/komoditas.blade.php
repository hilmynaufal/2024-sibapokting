
@section('title')
    Transaksi Harga Komoditas Pangan
@stop
@section('menu')
    Layanan > BPHTB > <b>Transaksi Harga Komoditas Pangan</b>
@stop

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
                        <a href="{{route('master.referensi.addagen')}}" class="btn btn-sm btn-light btn-active-primary">
                            <i class="ki-duotone ki-plus fs-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-3">
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
                                    <th>Nama Pasar
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
                                    <th>Bahan Pokok</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Harga Kemarin</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model as $index => $item)
                                <tr>
                                    <td>
                                        {{ $item->toPasar->namapasar }}
                                    </td>
                                    <td>
                                        {{ $item->toKomoditas->namakomoditas }}
                                        <span class="badge badge-light-primary">{{$item->toKomoditas->toSatuan->satuan}}</span>
                                    </td>
                                    <td>
                                        {{ TglTimeIndo($item->tanggal)}}
                                    </td>
                                    <td>
                                        {{ rupiah($item->harga_publish,0)}}
                                        {!! dinamikaHarga($item->id,$item->tanggal) !!}
                                    </td>
                                    <td>
                                        {{ hargaSebelum($item->id,$item->tanggal) }}
                                    </td>
                                    <td>
                                        <span
                                            class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->nama}}</span>
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