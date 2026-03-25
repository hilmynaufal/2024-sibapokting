@section('title')
    Rekap Input Harga Komoditas
@stop
@section('menu')
    Laporan > <b>Rekap Input Harga Komoditas</b>
@stop

<!--begin::Col-->
<div id="kt_app_content_container" class="app-container container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <div class="col-lg-12 col-xxl-12">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Rekap Input Harga Komoditas Per Pasar</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Jumlah data harga komoditas yang terinput per pasar (5 hari terakhir)</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <div class="hover-scroll-x">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-bordered">
                            <thead>
                                <tr class="fs-7 fw-bold border-0 bg-light text-gray-700">
                                    <th class="min-w-200px ps-4">NAMA PASAR</th>
                                    @foreach($tanggals as $tgl)
                                    <th class="min-w-120px text-center">
                                        {{ \Carbon\Carbon::parse($tgl)->translatedFormat('d M Y') }}
                                    </th>
                                    @endforeach
                                    <th class="min-w-80px text-center">TOTAL</th>
                                </tr>
                            </thead>
                            <!--begin::Table body-->
                            <tbody>
                                @forelse($pasars as $pasar)
                                @php
                                    $pasarCounts = $counts->get($pasar->id, collect());
                                    $totalPasar = 0;
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-gray-800 fw-semibold">{{ $pasar->namapasar }}</span>
                                    </td>
                                    @foreach($tanggals as $tgl)
                                    @php
                                        $entry = $pasarCounts->firstWhere('detail_tgl', $tgl);
                                        $jumlah = $entry ? $entry->jumlah : 0;
                                        $totalPasar += $jumlah;
                                    @endphp
                                    <td class="text-center">
                                        @if($jumlah > 0)
                                            <span class="badge badge-light-success fw-bold fs-7">{{ $jumlah }}</span>
                                        @else
                                            <span class="badge badge-light-danger fw-bold fs-7">0</span>
                                        @endif
                                    </td>
                                    @endforeach
                                    <td class="text-center">
                                        <span class="badge badge-light-primary fw-bold fs-7">{{ $totalPasar }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ count($tanggals) + 2 }}" class="text-center text-muted py-5">
                                        Data pasar tidak ditemukan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <!--begin::Tfoot-->
                            @if(count($pasars) > 0 && count($tanggals) > 0)
                            <tfoot>
                                <tr class="fs-7 fw-bold bg-light text-gray-700">
                                    <td class="ps-4">TOTAL</td>
                                    @foreach($tanggals as $tgl)
                                    @php
                                        $totalTgl = $counts->flatten(1)->where('detail_tgl', $tgl)->sum('jumlah');
                                    @endphp
                                    <td class="text-center">
                                        <span class="fw-bold">{{ $totalTgl }}</span>
                                    </td>
                                    @endforeach
                                    @php
                                        $grandTotal = $counts->flatten(1)->sum('jumlah');
                                    @endphp
                                    <td class="text-center">
                                        <span class="fw-bold">{{ $grandTotal }}</span>
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                            <!--end::Tfoot-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Body-->
            </div>
        </div>
    </div>
    <!--end::Row-->
</div>
<!--end::Col-->
