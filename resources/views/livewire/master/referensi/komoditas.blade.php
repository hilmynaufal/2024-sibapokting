@section('title')
Master Data komoditas
@stop
@section('menu')
Referensi > <b>Komoditas</b>
@stop
@section('add')
tambah
@stop
<!--begin::Col-->
<div>
    <div class="table-responsive">
        <div class="table-loading-message">
            Loading...
        </div>
        <table class="table table-bordered" id="datatableKomoditas">
            <thead>
                <tr class="fw-bold fs-6 text-gray-800">
                    <th>No</th>
                    <th>Nama Komoditas</th>
                    <th>Satuan</th>
                    <th>Gambar</th>
                    <th>Action</th>
                </tr>
            </thead>
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
                            <a href="{{route('main.verifikasi.bphtbkb.detail', [Crypt::encrypt($item->id)])}}"
                                class="btn btn-sm btn-icon btn-light-primary btn-active-light-default me-1"
                                title="Ubah">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a target="_blank" href="{{route('bphtb.cetak.resi', [Crypt::encrypt($item->id)])}}"
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
        </table>
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