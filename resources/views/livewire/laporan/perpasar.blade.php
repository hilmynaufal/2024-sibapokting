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
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3" >
                    <div class="row col-md-12 mb-5">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Pasar</label>
                            <div wire:ignore>
                                <select x-init="$($el).select2();
                                                            $($el).on('change', function() {
                                                                $wire.set('pasar_tabel', $($el).val());
                                                            })" wire:model.live="pasar_tabel" name="pasar_tabel" id="pasar_tabel"
                                    class="form-control form-control-sm form-select-solid">
                                    <option value="100">Semua Pasar</option>
                                    @foreach($list_pasar as $pasar)
                                    <option value="{{$pasar->id}}">{{$pasar->namapasar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <div class="w-200 mw-350px position-relative">
                                <!--begin::Input-->
                                <input class="form-control form-control-sm" wire:model.live="end" name="end" id="end" />
                                <!--end::Input-->
            
                                <!--begin::CVV icon-->
                                <div class="position-absolute translate-middle-y top-50 mt-1 end-0 me-3">
                                    <i class="ki-duotone ki-calendar text-gray-500 fs-2"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>
                                
                                <!--end::CVV icon-->
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"></label>
                            <div class="w-200 mt-2 mw-350px position-relative">
                                <a href="{{route('laporan.perpasar-print', ['pasar_tabel' => $pasar_tabel, 'end' => $end ])}}"
                                    class="btn btn-sm btn-light-danger btn-active-light-primary me-1"
                                    title="Cetak">
                                    <i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span
                                            class="path2"></span></i>Cetak
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="hover-scroll h-750px">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="kt_advance_table_widget_2">
                            <thead>
                                <tr class="fs-7 fw-bold border-0 text-gray-500">
                                    <th class="min-w-150px">VARIANT</th>
                                    <th class="min-w-80px text-start pe-0">HARGA AWAL</th>
                                    <th class="min-w-80px text-start pe-0">HARGA HARI INI</th>
                                    <th class="min-w-80px text-start pe-0">NAIK</th>
                                    <th class="min-w-80px text-start pe-0">TURUN</th>
                                    <th class="min-w-80px text-start pe-0">STABIL</th>
                                    <th class="text-start min-w-50px">PERUBAHAN</th>
                                </tr>
                            </thead>
                            <!--begin::Table body-->
                            <tbody>
                                @forelse ($model as $index => $item)
                                <tr>
                                    <td>
                                        <span
                                            class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item['nama']}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">Rp.{{ number_format($item['price_start'], 0, ',', '.')}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">Rp.{{ number_format($item['price_end'], 0, ',', '.')}}</span>
                                    </td>
                                    <td>
                                        @if($item['kondisi'] == 'naik')
                                        <span
                                            class="text-center text-danger-80 font-weight-bolder text-hover-success font-size-lg">{{ statusKondisi($item['kondisi'],$item['price_start'],$item['price_end']) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item['kondisi'] == 'turun')
                                        <span
                                            class="text-center text-success-80 font-weight-bolder text-hover-success font-size-lg">{{ statusKondisi($item['kondisi'],$item['price_start'],$item['price_end']) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item['kondisi'] == 'stabil')
                                        <span
                                            class="text-center text-primary-80 font-weight-bolder text-hover-success font-size-lg">STABIL</span>
                                        @endif
                                    </td>

                                    <td>
                                            @if($item['kondisi'] == 'naik')
                                                <span class="badge badge-light-danger"><i class="ki-outline ki-arrow-up-right fs-2 text-danger me-2"></i>
                                                    {{$item['persen']}}
                                                </span>
                                            @elseif($item['kondisi'] == 'turun')
                                                <span class="badge badge-light-success"><i class="ki-outline ki-arrow-down-right fs-2 text-success me-2"></i>
                                                    {{$item['persen']}}
                                                </span>
                                            @elseif($item['kondisi'] == 'stabil')
                                                <span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i>0%</span>
                                            @else
                                                <span class="badge badge-light-primary"><i class="ki-outline ki-minus fs-2 text-primary me-2"></i>0%</span>
                                            @endif
                                    </td>
                                </tr>
                                @empty
                                <tr class="odd">
                                    <td valign="top" colspan="8" class="text-center dataTables_empty">Data Tidak Ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                </div>
                <!--end::Body-->
            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    $("#start").flatpickr();
    $("#end").flatpickr();
</script>
@endpush