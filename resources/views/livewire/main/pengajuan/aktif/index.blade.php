<div>
    @section('title', 'Pengajuan Permohonan Aktif')

    <div class="row">
        <div>
            <!--begin::Table-->
            <table class="table table-bordered table-striped text-nowrap dataTable no-footer" id="kt_advance_table_widget_2">
                <thead>
                    <tr class="text-uppercase">
                        <th></th>
                        <th>Aksi</th>
                        <th>No. Registrasi</th>
                        <th>Status</th>
                        <th>Jenis Perolehan</th>
                        <th>Penerima Hak</th>
                        <th>Nilai transaksi</th>
                        <th>Verifikator</th>
                        <th>Status Bayar</th>
                        <th>Posisi Berkas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($model as $index => $item)
                    <tr>
                        <td>{{$no}}</td>
                        <td>
                            <div class="btn-list">
                                <button data-button="delete-button"  
                                    class="btn btn-sm btn-icon btn-light-danger btn-active-light-default me-1" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <a href="{{route('main.verifikasi.bphtbkb.detail', [Crypt::encrypt($item->id_bphtb)])}}"
                                    class="btn btn-sm btn-icon btn-light-primary btn-active-light-default me-1" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a target="_blank"
                                    href="{{route('bphtb.cetak.resi', [Crypt::encrypt($item->id_bphtb)])}}"
                                    class="btn btn-sm btn-icon btn-light-success btn-active-light-default me-1" title="Cetak Resi">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->pembayaranPajak->no_registrasi}}</span>
                            <br>
                            {{tglPendaftaran($item->id_bphtb)}}
                        </td>
                        <td>
                            {!! statusValidasi($item->id_bphtb) !!}
                        </td>
                        <td>
                            {{ $item->objekPajak->jenisPerolehan->nm_jenis_transaksi }}
                        </td>
                        <td>
                            <span
                                class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->nama_wp}}</span>
                        </td>
                        <td>
                            <span
                                class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ rupiah($item->pembayaranPajak->total_tagihan,2)}}</span>
                        </td>
                        <td>
                            VERIFIKATOR
                        </td>
                        <td>
                            <span
                                class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->pembayaranPajak->status_bayar}}</span>
                        </td>
                        <td class="pr-0 text-right">
                            {!! statusBerkas($item->id_bphtb) !!}
                        </td>
                    </tr>
                    <?php $no++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    new DataTable('#kt_advance_table_widget_2', {
        responsive: true
    });
</script>

@endpush