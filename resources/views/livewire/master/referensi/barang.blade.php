@section('title')
Master Data Barang
@stop
@section('menu')
Referensi > <b>Barang</b>
@stop

@push('js')
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    new DataTable('#datatableBarang', {
        responsive: true
    });
</script>
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
        <div class="col-lg-{{$isOpen ? '8' : '12' }} col-xxl-{{$isOpen ? '8' : '12' }}">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Data Master Barang</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        data-bs-original-title="Click to add a user" data-kt-initialized="1">
                        <a wire:click.prevent="toggle" class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_invite_friends">
                            <i class="ki-duotone ki-plus fs-2"></i> Tambah Barang
                        </a>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="datatableBarang">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($model as $index => $item)
                                <tr>
                                    <td class="text-center">{{$no}}</td>
                                    <td>
                                        <span
                                            class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->namabarang}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->satuan}}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="symbol symbol-50px">
                                            <img src="{{ Storage::disk('public')->url($item->gambar) }}"
                                                alt="">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-list">
                                            <a wire:click="$dispatch('openModal', { component: 'modal.master.referensi.barang.view' , arguments: { id: {{ $item->id }} }})"
                                                class="btn btn-sm btn-icon btn-light-primary btn-active-light-default me-1"
                                                title="Ubah">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a wire:click="edit({{ $item->id }})"
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
                                <?php $no++; ?>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>

                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
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
                            <!--begin::Input -->
                            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Nama<span class="text-danger"></span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text"
                                            class="form-control form-control-sm @error('namabarang') is-invalid @enderror"
                                            name="namabarang" wire:model="namabarang" id="namabarang">
                                        @error('namabarang') <span class="invalid-feedback"
                                            role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Satuan Berat<span class="text-danger"></span></label>
                                    </div>
                                    <div class="col-md-10" wire:ignore>
                                        <select x-init="$($el).select2({ placeholder: '-- Pilih Satuan --', });
                                        $($el).on('change', function() {
                                            $wire.set('satuan', $($el).val());
                                        })" wire:model="satuan" name="satuan" id="satuan" class="form-control form-control-sm form-select-solid">
                                            @foreach($list_satuan as $satuan)
                                            <option value="{{$satuan->satuan}}">{{$satuan->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Gambar<span class="text-danger"></span></label>
                                    </div>
                                    <div class="col-md-10">
                                        <x-filepond title="Upload" required="1" file-document="gambar"
                                            data-max-file-size="1MB" wire:model="gambar" id="gambar" />
                                        @if($gambar)
                                        <div class="symbol symbol-50px">
                                            <img src="{{ Storage::disk('public')->url($gambar) }}"
                                                alt="">
                                        </div>
                                        @endif
                                    </div>
                                </div>
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
</div>


<!--end::Col-->

@push('meta')
<meta name="turbolinks-visit-control" content="reload">
<meta name="turbolinks-cache-control" content="no-cache">
@endpush


@push('css')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@endpush

@push('js')
<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
@endpush