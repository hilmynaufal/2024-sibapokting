<div>
    <h3 class="text-center text-gray-800 font-weight-bold ">
        LAPORAN STOK BARANG {{ getBarang($barang)->namabarang }}
        <br>DARI TANGGAL {{  strtoupper(TglIndo($this->start)) }} S/D {{  strtoupper(TglIndo($this->end)) }} <br>
    </h3>
        <table class="table table-sm m-2">
        <thead>
                                    <tr class="fs-7 bg-dark fw-bold border-0 text-white">
                                        <th class="p-4">Nama Pasar</th>
                                        @foreach ($jsonData->meta->date as $index => $date)
                                            <th class="min-w-80px p-4">{{ TglIndoBulan($jsonData->meta->date[$index]) }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jsonData->data as $pasar)
                                        <tr>
                                            <td class="fw-bold p-4">{{ $pasar->name }}</td>
                                            @foreach ($jsonData->meta->date as $date)
                                                @php
                                                    $data = collect($pasar->by_date)->firstWhere('date', $date);
                                                @endphp
                                                <td class="min-w-80px p-4">
                                                <div class="d-flex flex-column content-justify-center flex-grow-1">
                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                                        <!--begin::Label-->
                                                        <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">Stok Awal</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="ms-auto fw-bolder text-gray-500 text-end">{{ $data ? nilai($data->awal,0) : '-' }}</div>
                                                        <!--end::Stats-->
                                                    </div>
                                                    <!--end::Label-->

                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center my-1">
                                                        <!--begin::Label-->
                                                        <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">Stok Masuk</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="ms-auto fw-bolder text-gray-500 text-end">{{ $data ? nilai($data->masuk,0) : '-' }}</div>
                                                        <!--end::Stats-->                    
                                                    </div>
                                                    <!--end::Label-->

                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                                        <!--begin::Label-->
                                                        <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">Stok Keluar</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="ms-auto fw-bolder text-gray-500 text-end">{{ $data ? nilai($data->keluar,0) : '-' }}</div>
                                                        <!--end::Stats-->                      
                                                    </div>
                                                    <!--end::Label-->
                                                    
                                                    <!--begin::Label-->
                                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                                        <!--begin::Label-->
                                                        <div class="fs-6 fw-semibold text-gray-500 flex-shrink-0">Stok Akhir</div>
                                                        <!--end::Label-->
                                                        <!--begin::Stats-->
                                                        <div class="ms-auto fw-bolder text-gray-500 text-end">{{ $data ? nilai($data->akhir,0) : '-' }}</div>
                                                        <!--end::Stats-->                      
                                                    </div>
                                                    <!--end::Label-->
                                                </div>    
                                            </td>
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
