<div>
    <h3 class="text-center text-gray-800 font-weight-bold ">
        RENTANG HARGA KOMODITAS {{ getKomoditas($komoditas)->namakomoditas }}
        <br>DARI TANGGAL {{ date('d M Y', strtotime($this->start)) }} S/D {{ date('d M Y', strtotime($this->end)) }} <br>
    </h3>
        <table class="table table-sm m-2">
            <thead>
                <tr class="fs-7 bg-default fw-bold border-1 text-black">
                    <th class="p-4">Nama Pasar</th>
                    @foreach ($jsonData->meta->date as $index => $date)
                        <th class="min-w-90px p-4">{{ TglIndoBulan($jsonData->meta->date[$index]) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($jsonData->data as $pasar)
                    <tr class="fs-7 text-black" style="border:1px solid black;">
                        <td class="fw-bold p-2">{{ $pasar->name }}</td>
                        @foreach ($jsonData->meta->date as $date)
                            @php
                                $data = collect($pasar->by_date)->firstWhere('date', $date);
                            @endphp
                            <td class="min-w-50px p-2">{{ $data ? nilai($data->prices,0) : '-' }}</td>
                        @endforeach
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
