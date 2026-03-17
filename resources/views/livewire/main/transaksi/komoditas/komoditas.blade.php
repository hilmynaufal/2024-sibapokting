@section('title')
Transaksi Harga Komoditas Pangan
@stop
@section('menu')
Layanan > BPHTB > <b>Transaksi Harga Komoditas Pangan</b>
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
                    <div class="d-flex gap-2">
                        <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-trigger="hover" data-bs-original-title="Click to add a user"
                            data-kt-initialized="1">
                            <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.komoditas.add'})"
                                class="btn btn-sm btn-light btn-active-primary">
                                <i class="ki-duotone ki-plus fs-2"></i> Tambah Data
                            </a>
                        </div>
                        <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-trigger="hover" data-bs-original-title="Tambah banyak data sekaligus"
                            data-kt-initialized="1">
                            <a href="{{ route('main.komoditas.add-bulk') }}"
                                class="btn btn-sm btn-light btn-active-primary">
                                <i class="ki-duotone ki-row-horizontal fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i> Tambah Banyak Data
                            </a>
                        </div>
                        <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-trigger="hover" data-bs-original-title="Click to add a user"
                            data-kt-initialized="1">
                            <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.komoditas.import'})"
                                class="btn btn-sm btn-light btn-active-primary">
                                <i class="ki-duotone ki-plus fs-2"></i> Import Data
                            </a>
                        </div>
                        <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-trigger="hover" data-bs-original-title="Ambil data dari tanggal lain"
                            data-kt-initialized="1">
                            <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.komoditas.fetch-data'})"
                                class="btn btn-sm btn-light btn-active-primary">
                                <i class="ki-duotone ki-calendar-search fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i> Ambil Data
                            </a>
                        </div>
                        @if(Auth::user()->role_id == 5)
                            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-trigger="hover" data-bs-original-title="Salin data komoditas dari kemarin"
                                data-kt-initialized="1">
                                <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.komoditas.copy-yesterday'})"
                                    class="btn btn-sm btn-warning btn-active-warning">
                                    <i class="ki-duotone ki-copy fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i> Salin dari Kemarin
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <div class="d-flex flex-row flex-column-fluid">
                            <div class="d-flex flex-row-auto w-800px flex-start">
                                <select wire:model.live="perpage" class="form-select form-select-sm"
                                    style="width: 75px;">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="d-flex flex-row-auto w-200px flex-end" style="margin-right: 10px;">
                                <select wire:model.live="selectPasar" class="form-select form-select-sm">
                                    @if(Auth::user()->role_id != 5)
                                        <option value="">-- Pilih Semua --</option>
                                    @endif
                                    @foreach($listPasar as $val)
                                        <option value="{{$val->id}}">{{$val->namapasar}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex flex-row-auto w-180px flex-end">
                                <input type="date" class="form-control form-control-sm" placeholder="Pick date rage"
                                    id="selectTanggal" class="form-control @error('selectTanggal') is-invalid @enderror"
                                    name="selectTanggal" wire:model.live="selectTanggal" />
                            </div>
                            <div class="d-flex flex-row-auto w-10px flex-end">
                            </div>
                        </div>

                        {{-- Keterangan MBG --}}
                        <div class="alert alert-dismissible bg-light-info d-flex flex-column flex-sm-row p-5 mb-5">
                            <i class="ki-duotone ki-information fs-2hx text-info me-4 mb-5 mb-sm-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-column pe-0 pe-sm-10">
                                <h5 class="mb-1">Keterangan</h5>
                                <span>Komoditas dengan tanda <span class="text-danger fw-bold">*</span> (bintang merah)
                                    menandakan bahwa komoditas tersebut termasuk dalam kategori <strong>MBG (Makan
                                        Bergizi Gratis)</strong></span>
                            </div>
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
                                @forelse ($model as $index => $item)
                                    <tr>
                                        <td>
                                            {{ $item->toPasar->namapasar }}
                                        </td>
                                        <td>
                                            {{ $item->toKomoditas->namakomoditas }}@if($item->toKomoditas->komoditas_mbg == 1)<span
                                            class="text-danger fw-bold">*</span>@endif
                                            <span
                                                class="badge badge-light-primary">{{$item->toKomoditas->toSatuan->satuan}}</span>
                                        </td>
                                        <td>
                                            {{ TglTimeIndo($item->tanggal)}}
                                        </td>
                                        <td>
                                            {{ rupiah($item->harga_publish, 0)}}
                                            {!! dinamikaHarga($item->id, $item->detail_tgl) !!}
                                        </td>
                                        <td>
                                            {{ rupiah(hargaSebelum($item->id, $item->detail_tgl), 0) }}
                                        </td>
                                        <td>
                                            <div class="btn-list">
                                                <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.komoditas.view' , arguments: { id: {{ $item->id }} }})"
                                                    class="btn btn-sm btn-icon btn-light-primary btn-active-light-default me-1"
                                                    title="Ubah">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a wire:click="$dispatch('openModal', { component: 'modal.transaksi.komoditas.edit' , arguments: { id: {{ $item->id }} }})"
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
                                @empty
                                    <tr class="odd">
                                        <td valign="top" class="text-center" colspan="8" class="dataTables_empty">Nama Tidak
                                            Ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                        <div class="col-sm-12 col-md-12">
                            <div class="float-start">
                                Menampilkan {{ $model->firstItem() }} - {{ $model->lastItem() }} dari
                                {{$model->total() }}
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
    <script>

        function updatePriceDisplay() {
            var priceInput = document.getElementById('harga');
            var priceDisplay = document.getElementById('price-display');
            var formattedPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(priceInput.value);
            priceDisplay.textContent = 'Harga yang diinput: ' + formattedPrice;
        }
    </script>
@endpush