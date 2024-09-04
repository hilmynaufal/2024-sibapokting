<div>
    <br>
    <h3 class="text-center text-gray-800 font-weight-bold ">
        DATA KEPOKMAS KABUPATEN BANDUNG
        <br>DARI TANGGAL {{ strtoupper(tglIndo($this->end)) }}
    </h3>
    
        <table class="table table-sm p-4">
            <thead>
                <tr class="fs-7 bg-default fw-bold border-1 text-black">
                    <th class="min-w-200px p-4">Nama Komoditas</th>
                    @foreach($jsonData->meta->pasar as $pasar)
                        <th class="min-w-100px">{{ $pasar }}</th>
                    @endforeach
                    <th class="min-w-100px p-4">Jumlah Pasar</th>
                    <th class="min-w-100px p-4">Rata-Rata</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jsonData->meta->komoditas as $komoditas)
                    <tr class="fs-7 text-black" style="border:1px solid black;">
                        <td class="fw-bold p-2">{{ $komoditas->namakomoditas }}</td>
                        @php
                            $jumlah_pasar = 0;
                            $total_harga = 0;
                        @endphp
                        @foreach ($jsonData->meta->pasar as $pasar)
                            @php
                                $perpasar = collect($jsonData->data)->firstWhere('name', $pasar);
                                $perkomoditas = $perpasar ? collect($perpasar->data)->firstWhere('komoditas', $komoditas->namakomoditas) : null;
                                if ($perkomoditas) {
                                    $jumlah_pasar++;
                                    $total_harga += $perkomoditas->harga;
                                }
                            @endphp
                            <td class="min-w-80px p-1">
                                Rp. {{ $perkomoditas ? number_format($perkomoditas->harga, 0) : '-' }}
                            </td>
                        @endforeach
                        <td class="p-1">{{ $jumlah_pasar }}</td>
                        <td class="p-1">Rp. {{ $jumlah_pasar > 0 ? number_format($total_harga / $jumlah_pasar, 0) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align:right;">
            <p>Soreang, {{ date('d M Y') }}</p>
            <p style="right:160px;position:relative;">Mengetahui,</p>
            <p style="position: relative;padding-left: 1008px;text-align:center;">KEPALA DINAS 
                <br>PERDAGANGAN DAN PERINDUSTRIAN 
                <br> KABUPATEN BANDUNG
                <br><br><br><br><br>
            <p style="position: relative;padding-left: 1008px;text-align:center;">
                <strong><u>DICKY ANUGRAH, SH, M.Si</u></strong>
                <br>Pembina Utama Muda
                <br>NIP. 19740717 199803 1 003
            </p>
        </div>
</div>
