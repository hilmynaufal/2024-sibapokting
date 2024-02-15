@section('title')
Master Data komoditas
@stop
@section('menu')
Referensi > <b>Komoditas</b>
@stop

<!--begin::Col-->
<div id="kt_app_content_container" class="app-container  container-xxl ">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8"><div class="card mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-3 mb-1">Data Master Komoditas</span>
        </h3>

        <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
            data-bs-original-title="Click to add a user" data-kt-initialized="1">
            <a wire:click="$dispatch('openModal', { component: 'modal.master.referensi.komoditas.add'})" class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                data-bs-target="#kt_modal_invite_friends">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Komoditas
            </a>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="datatableKomoditas">
                <!--begin::Table head-->
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>No</th>
                        <th>Nama Komoditas</th>
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
                                class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->namakomoditas}}</span>
                        </td>
                        <td>
                            <span
                                class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->satuan}}</span>
                        </td>
                        <td class="text-center">
                            <div class="symbol symbol-50px">
                                <img src="{{ Storage::disk('public')->url('/komoditas/'.$item->gambar) }}" alt="">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-list">
                                <a wire:click="$dispatch('openModal', { component: 'modal.master.referensi.komoditas.view' , arguments: { id: {{ $item->id }} }})"
                                    class="btn btn-sm btn-icon btn-light-primary btn-active-light-default me-1"
                                    title="Ubah">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a wire:click="$dispatch('openModal', { component: 'modal.master.referensi.komoditas.edit' , arguments: { id: {{ $item->id }} }})"
                                    class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1"
                                    title="Lihat">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button data-button="delete-button"
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
</div>


<!--end::Col-->

@push('meta')
<meta name="turbolinks-visit-control" content="reload">
<meta name="turbolinks-cache-control" content="no-cache">
@endpush
@push('js')
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    new DataTable('#datatableKomoditas', {
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
