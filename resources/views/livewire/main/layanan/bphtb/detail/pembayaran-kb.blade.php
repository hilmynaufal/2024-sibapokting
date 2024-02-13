<div>
  
        <!--begin::Section-->
        <div class="mb-7">
                        
            <!--begin::Details-->
            <div class="d-flex align-items-center">
                {{-- <!--begin::Avatar-->
                <div class="symbol symbol-60px symbol-circle me-3">
                    <img alt="Pic" src="/metronic8/demo56/assets/media/avatars/300-5.jpg">
                </div>
                <!--end::Avatar--> --}}

                <!--begin::Info-->
                <div class="d-flex flex-column">
                    <!--begin::Name-->
                    <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-2">{{ $objek_pajak->notaris->nama }}</a>
                    <!--end::Name-->

                    <!--begin::Email-->
                    <a href="#" class="fw-semibold text-gray-600 text-hover-primary">{{ $objek_pajak->notaris->jabatan }} - {{ $objek_pajak->notaris->satuan_kerja }}</a>
                    <!--end::Email-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
        </div>
        <!--end::Section-->

        <!--begin::Seperator-->
        <div class="separator separator-dashed mb-7"></div>
        <!--end::Seperator-->

        <!--begin::Section-->
        <div class="mb-10">
            <!--begin::Title-->
            <h5 class="mb-4">Detail Tagihan (NTPD)</h5>
            <!--end::Title-->

            <!--begin::Details-->
            <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2">
                <!--begin::Row-->
                <tbody><tr class="">
                    <td class="text-gray-500">Kode NPTD</td>
                    <td class="text-gray-800">{{ empty($pembayaran_pajak->kode_bayar) ? '-' : $pembayaran_pajak->kode_bayar }}</td>
                </tr>
                <!--end::Row-->

                <!--begin::Row-->
                <tr class="">
                    <td class="text-gray-500">Status:</td>
                    <td><span class="badge badge-light-success">{{ empty($pembayaran_pajak->status_tagihan) ? '-' : $pembayaran_pajak->status_tagihan }}</span></td>
                </tr>
                <!--end::Row-->
                @if(!empty($pembayaran_pajak->status_tagihan))

                    @if ($pembayaran_pajak->status_tagihan=="Aktif")
                    <!--begin::Row-->
                    <tr class="">
                        <td class="text-gray-500">Tanggal:</td>
                        <td class="text-gray-800">{{ TglIndoHari($pembayaran_pajak->tanggal_tagihan) }}</td>
                    </tr>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <tr class="">
                        <td class="text-gray-500">Expired:</td>
                        <td class="text-gray-800">{{ TglIndoHari($pembayaran_pajak->batas_waktu_tagihan) }}</td>
                    </tr>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <tr class="">
                        <td class="text-gray-500">Sisa Waktu:</td>
                        <td class="text-gray-800">

                            <div class="badge badge-light-danger" id="countdown"></div>

                            @push('js')
                            <script>
                                $(document).ready(function() {
                                    var targetDate = new Date('{{ $pembayaran_pajak->batas_waktu_tagihan }}');
                                    var countdownDisplay = $('#countdown');

                                    function countdown() {
                                        setInterval(function() {
                                            var now = new Date();
                                            var difference = targetDate - now;

                                            var days = Math.floor(difference / (1000 * 60 * 60 * 24));
                                            var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                            var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                                            var seconds = Math.floor((difference % (1000 * 60)) / 1000);

                                            countdownDisplay.html(days + "hari " + hours + "jam " + minutes + "menit " + seconds + "detik ");
                                        }, 1000);
                                    }

                                    countdown(); // Memulai countdown saat dokumen siap
                                });
                            </script>
                            @endpush

                        </td>
                    </tr>
                    <!--end::Row-->


                    @endif
                @endif
                <!--begin::Row-->
                <tr class="">
                    <td class="text-gray-500">Self Assesment:</td>
                    <td class="text-gray-800">Rp. {{empty($objek_pajak->nilai_bayar_bphtb) ? 0 : number_format($objek_pajak->nilai_bayar_bphtb)}},</td>
                </tr>
                <tr class="">
                    <td class="text-gray-500">Office Assesment:</td>
                    <td class="text-gray-800">Rp. {{empty($objek_pajak_verifikasi->nilai_bayar_bphtb) ? 0 : number_format($objek_pajak_verifikasi->nilai_bayar_bphtb)}},</td>
                </tr>
                <tr class="">
                    <td class="text-gray-500">Tagihan:</td>
                    <td class="text-gray-800">Rp. {{empty($pembayaran_pajak->total_tagihan) ? 0 : number_format($pembayaran_pajak->total_tagihan)}},</td>
                </tr>
                <!--end::Row-->
            </tbody></table>
            <!--end::Details-->
        </div>
        <!--end::Section-->

        <!--begin::Section-->
        <div class="mb-10">
            <!--begin::Title-->
            <h5 class="mb-4">Detail Pembayaran</h5>
            <!--end::Title-->

            <!--begin::Details-->
            <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2">
    

                <!--begin::Row-->
                <tr class="">
                    <td class="text-gray-500">Status Bayar:</td>
                    <td><span class="badge badge-light-danger">{{ empty($pembayaran_pajak->status_bayar) ? 'belum bayar' : $pembayaran_pajak->status_bayar}}</span></td>
                </tr>
                <!--end::Row-->
                @if (!empty($pembayaran_pajak->status_bayar))
                    @if ($pembayaran_pajak->status_bayar=="Sudah di Validasi")
                    <!--begin::Row-->
                    <tr class="">
                        <td class="text-gray-500">Tanggal Bayar:</td>
                        <td class="text-gray-800">{{ TglIndoHari($pembayaran_pajak->tanggal_bayar) }}</td>
                    </tr>
                    <!--end::Row-->
                    @endif
                @endif

            </tbody></table>
            <!--end::Details-->
        </div>
        <!--end::Section-->

          <!--begin::Seperator-->
          <div class="separator separator-dashed mb-7"></div>
          <!--end::Seperator-->


        <!--begin::Section-->
        <div class="mb-10">
            <!--begin::Title-->
            <h5 class="mb-4">Detail Validasi</h5>
            <!--end::Title-->

            <!--begin::Details-->
            <table class="table fs-6 fw-semibold gs-0 gy-2 gx-2">
            @if ($pembayaran_pajak->first())
                @if ($pembayaran_pajak->status_validasi==0)
                <!--begin::Row-->
                <tr class="">
                    <td class="text-gray-500">Status Validasi:</td>
                    <td><span class="badge badge-light-danger">Belum Validasi</span></td>
                </tr>
                <!--end::Row-->
                @endif
                @if ($pembayaran_pajak->status_validasi==1)
                <!--begin::Row-->
                <tr class="">
                    <td class="text-gray-500">Status Validasi:</td>
                    <td><span class="badge badge-light-success">Sudah Divalidasi - Lunas</span></td>
                </tr>
                <tr class="">
                    <td class="text-gray-500">Tanggal Validasi:</td>
                    <td class="text-gray-800">{{ TglIndoHari($pembayaran_pajak->tanggal_validasi) }}</td>
                </tr>
                <!--end::Row-->
                @endif
                @if ($pembayaran_pajak->status_validasi==2)
                <!--begin::Row-->
                <tr class="">
                    <td class="text-gray-500">Status Validasi:</td>
                    <td><span class="badge badge-light-primary">Sudah Divalidasi - Kurang Bayar</span></td>
                </tr>
                <tr class="">
                    <td class="text-gray-500">Tanggal Validasi:</td>
                    <td class="text-gray-800">{{ TglIndoHari($pembayaran_pajak->tanggal_validasi) }}</td>
                </tr>
                <tr class="">
                    <td class="text-gray-500">Self Assesment:</td>
                    <td><span class="badge badge-light-primary">Rp. {{number_format($objek_pajak->nilai_bayar_bphtb)}}</span></td>
                </tr>
                <tr class="">
                    <td class="text-gray-500">Office Assesment:</td>
                    <td><span class="badge badge-light-primary">Rp. {{number_format($objek_pajak_verifikasi->nilai_bayar_bphtb)}}</span></td>
                </tr>
                <tr class="">
                    <td class="text-gray-500">Kurang Bayar:</td>
                    <td><span class="badge badge-light-primary">Rp. {{number_format($selisih_pembayaran)}}</span></td>
                </tr>
                <!--end::Row-->
                @endif
            @endif

            </tbody></table>
            <!--end::Details-->
        </div>
        <!--end::Section-->
        @if(empty($pembayaran_pajak->status_tagihan))
            <div class="separator separator-dashed mb-7"></div>
                <form wire:submit="create">
                <center>
                    <div class="d-grid gap-2">
                        <button class="btn btn-warning text-center btn-block" type="submit" wire:target="create" >
                            <span wire:loading class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            Selesai & Kirim <i class="fa fa-arrow-up"></i>
                        </button>
                    </div>
                </center>
                </form>
        @endif

        <!--begin::Actions-->
        <div class="mb-0">

                
        </div>
        <!--end::Actions-->
</div>
