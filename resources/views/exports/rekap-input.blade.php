<table>
    <thead>
        <tr>
            <th colspan="{{ count($tanggals) + 2 }}" style="text-align: center; font-weight: bold; font-size: 14px;">
                REKAPITULASI INPUT HARGA KOMODITAS PER PASAR
            </th>
        </tr>
        <tr>
            <th colspan="{{ count($tanggals) + 2 }}" style="text-align: center; font-weight: bold; font-size: 12px;">
                @if($dateFrom && $dateTo)
                    PERIODE : {{ \Carbon\Carbon::parse($dateFrom)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($dateTo)->translatedFormat('d F Y') }}
                @else
                    SEMUA PERIODE
                @endif
            </th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center; background-color: #f2f2f2;">NAMA PASAR</th>
            @foreach($tanggals as $tgl)
                <th style="font-weight: bold; text-align: center; background-color: #f2f2f2;">
                    {{ \Carbon\Carbon::parse($tgl)->translatedFormat('d M Y') }}
                </th>
            @endforeach
            <th style="font-weight: bold; text-align: center; background-color: #f2f2f2;">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pasars as $pasar)
            @php
                $pasarCounts = $counts->get($pasar->id, collect());
                $totalPasar = 0;
            @endphp
            <tr>
                <td>{{ $pasar->namapasar }}</td>
                @foreach($tanggals as $tgl)
                    @php
                        $entry = $pasarCounts->firstWhere('detail_tgl', $tgl);
                        $jumlah = $entry ? $entry->jumlah : 0;
                        $totalPasar += $jumlah;
                    @endphp
                    <td style="text-align: center;">{{ $jumlah }}</td>
                @endforeach
                <td style="text-align: center; font-weight: bold;">{{ $totalPasar }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($tanggals) + 2 }}" style="text-align: center;">Data pasar tidak ditemukan</td>
            </tr>
        @endforelse
    </tbody>
    @if(count($pasars) > 0)
        <tfoot>
            <tr>
                <td style="font-weight: bold; background-color: #f2f2f2;">TOTAL KESELURUHAN</td>
                @foreach($tanggals as $tgl)
                    @php
                        $totalTgl = $counts->flatten(1)->where('detail_tgl', $tgl)->sum('jumlah');
                    @endphp
                    <td style="font-weight: bold; text-align: center; background-color: #f2f2f2;">{{ $totalTgl }}</td>
                @endforeach
                @php
                    $grandTotal = $counts->flatten(1)->sum('jumlah');
                @endphp
                <td style="font-weight: bold; text-align: center; background-color: #f2f2f2;">{{ $grandTotal }}</td>
            </tr>
        </tfoot>
    @endif
</table>
