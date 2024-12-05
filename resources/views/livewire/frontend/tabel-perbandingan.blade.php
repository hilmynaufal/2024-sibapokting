@section('title')
PERBANDINGAN HARGA
@stop
<div class="card card-flush h-xl-100">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">PERBANDINGAN HARGA BAHAN POKOK</span>
        </h3>
        <!--end::Title-->
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3  wire:ignore">
        <div class="row col-md-12 mb-5">
            <div class="col-md-12 mb-3">
                <label class="form-label">Pilih Pasar</label>
                <div wire:ignore>
                    <select x-init="$($el).select2();
                                                $($el).on('change', function() {
                                                    $wire.set('pasar_tabel', $($el).val());
                                                })" wire:model.live="pasar_tabel" name="pasar_tabel" id="pasar_tabel"
                        class="form-control form-control-sm form-select-solid">
                        <option value="">Semua Pasar</option>
                        @foreach($list_pasar as $pasar)
                        <option value="{{$pasar->id}}">{{$pasar->namapasar}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Awal</label>
                <div class="w-200 mw-350px position-relative">
                    <!--begin::Input-->
                    <input class="form-control form-control-sm" wire:model.live="start" name="start"
                        id="start" />
                    <!--end::Input-->

                    <!--begin::CVV icon-->
                    <div class="position-absolute translate-middle-y top-50 mt-1 end-0 me-3">
                        <i class="ki-duotone ki-calendar text-gray-500 fs-2"><span class="path1"></span><span
                                class="path2"></span></i>
                    </div>
                    <!--end::CVV icon-->
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tanggal Akhir</label>
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
        </div>
        <div class="hover-scroll h-750px">
            <!--begin::Table-->
            <table class="table table-row-dashed align-middle gs-0 gy-4">
                <!--end::Table head-->
                <!--begin::Table head-->
                <thead>
                    <tr class="fs-7 fw-bold border-0 text-gray-500">
                        <th class="min-w-150px">VARIANT</th>
                        <th class="min-w-80px text-start pe-0">{{tglIndoBulan($start)}}</th>
                        <th class="min-w-80px text-start pe-0">{{tglIndoBulan($end)}}</th>
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
                                class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item['price_start']}}</span>
                        </td>
                        <td>
                            <span
                                class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item['price_end']}}</span>
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
    <!--end::Body-->
</div>

@push('js')
<script>
    $(document).ready(function () {
        $("#date_komoditas").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
        $("#start").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
        $("#end").flatpickr({
            "setDate": new Date(),
            "autoclose": true
        });
    });
</script>
@endpush