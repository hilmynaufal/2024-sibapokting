<div>
    <br>
    <h3 class="text-center text-gray-800 font-weight-bold ">
        HARGA YANG MENGALAMI KENAIKAN DAN PENURUNAN
        <br>DARI TANGGAL {{ date('d M Y', strtotime($this->start)) }} S/D {{ date('d M Y', strtotime($this->end)) }} <br>
        {{ $pasar_tabel == 100 ? 'Semua Pasar' : getNamaPasar($pasar_tabel) }}
    </h3>
    <br>
    <table class="table table-bordered align-middle"
           id="kt_advance_table_widget_2">
        <thead>
            <tr class="fs-7 fw-bold text-gray-500 text-center">
                <th class="min-w-50px">NO</th>
                <th class="min-w-150px">VARIANT</th>
                <th class="min-w-80px">HARGA AWAL</th>
                <th class="min-w-80px">HARGA HARI INI</th>
                <th class="min-w-80px">NAIK</th>
                <th class="min-w-80px">TURUN</th>
                <th class="min-w-80px">STABIL</th>
                <th class="min-w-50px">PERUBAHAN</th>
            </tr>
        </thead>
        <!--begin::Table body-->
        <tbody>
            <?php $no=0;?>
            @forelse ($model as $index => $item)
            <?php $no++?>
            <tr>
                <td class="text-center text-gray-800">{{ $no }}.</td>
                <td class="text-left text-gray-800">
                    {{ $item['nama'] }}
                </td>
                <td class="text-center text-gray-800">
                    Rp.{{ number_format($item['price_start'], 0, ',', '.') }}
                </td>
                <td class="text-center text-gray-800">
                    Rp.{{ number_format($item['price_end'], 0, ',', '.') }}
                </td>
                <td class="text-center">
                    @if($item['kondisi'] == 'naik')
                    <span class="text-danger">{{ statusKondisi($item['kondisi'],$item['price_start'],$item['price_end']) }}</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($item['kondisi'] == 'turun')
                    <span class="text-success">{{ statusKondisi($item['kondisi'],$item['price_start'],$item['price_end']) }}</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($item['kondisi'] == 'stabil')
                    <span class="text-primary">STABIL</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($item['kondisi'] == 'naik')
                        <span class="badge badge-light-danger">
                            <i class="ki-outline ki-arrow-up-right fs-2 text-danger me-2"></i>
                            {{$item['persen']}}
                        </span>
                    @elseif($item['kondisi'] == 'turun')
                        <span class="badge badge-light-success">
                            <i class="ki-outline ki-arrow-down-right fs-2 text-success me-2"></i>
                            {{$item['persen']}}
                        </span>
                    @elseif($item['kondisi'] == 'stabil')
                        <span class="badge badge-light-primary">
                            <i class="ki-outline ki-minus fs-2 text-primary me-2"></i>0%
                        </span>
                    @else
                        <span class="badge badge-light-primary">
                            <i class="ki-outline ki-minus fs-2 text-primary me-2"></i>0%
                        </span>
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
    <!--begin::Signature-->
    <div style="text-align:right;">
            <p>Soreang, {{ date('d M Y') }}</p>
            <p style="right:100px;position:relative;">Mengetahui,</p>
            <p style="left:205px;position:relative;text-align:center;">KEPALA DINAS 
                <br>PERDAGANGAN DAN PERINDUSTRIAN 
                <br> KABUPATEN BANDUNG
                <br><br><br><br><br>
            <p style="left:205px;position:relative;text-align:center;">
                <strong><u>DICKY ANUGRAH, SH, M.Si</u></strong>
                <br>Pembina Utama Muda
                <br>NIP. 19740717 199803 1 003
            </p>

    </div>
    <!--end::Signature-->
</div>
