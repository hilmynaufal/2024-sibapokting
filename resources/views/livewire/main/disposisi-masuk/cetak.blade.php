<div>
    <!-- Invoice 1 start -->
    @section('title','Lembar Disposisi - ',$disposisi_nomor)
    <div class="invoice-1 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner clearfix">
                        <div class="invoice-info clearfix" id="invoice_wrapper">
                            <div class="invoice-headar">
                                <div class="row g-0">
                                    <div class="col-sm-6">
                                        <div class="invoice-logo">
                                            <!-- logo started -->
                                            <div class="logo">
                                                <img src="{{ asset('backend/assets/images/logo-text.png') }}" class="max-h-75px" height="175px" alt="{{ getApp() }}" />
                                            </div>
                                            <!-- logo ended -->
                                        </div>
                                    </div>
                                    <div class="col-sm-6 invoice-id">
                                        <div class="info">
                                            <h1 class="color-white inv-header-1">LEMBAR DISPOSISI</h1>
                                            <p class="color-white mb-1">No. Disposisi <span>#{{$disposisi_nomor}}</span></p>
                                            <p class="color-white mb-0">Tgl. Disposisi <span>{{ TglIndo($disposisi_at) }}</span></p>
                                            <p class="color-white mb-0">Tgl. Tenggat <span>{{ TglIndo($disposisi_batas_waktu) }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <BR><BR>
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice-number mb-30">
                                            <table class="table mb-0 invoice-table">
                                                <tr>
                                                    <td><p class="inv-title-1">Surat Dari</p></td>
                                                    <td><p class="name">{{$pengirim_surat}}</p></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>{{$alamat_pengirim}}</td>
                                                </tr>
                                                <tr>
                                                    <td><p class="inv-title-1">No. Surat</p></td>
                                                    <td>{{$no_surat}}</td>
                                                </tr>
                                                <tr>
                                                    <td><p class="inv-title-1">Tgl. Surat</p></td>
                                                    <td>{{$tgl_surat}}</td>
                                                </tr>
                                                <tr>
                                                    <td><p class="inv-title-1">Perihal</p></td>
                                                    <td>{{$perihal_surat}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-number mb-30">
                                            <table class="table mb-0 invoice-table">
                                                <tr>
                                                    <td><p class="inv-title-1">Diterima Tanggal</p></td>
                                                    <td><p class="name">{{$tgl_terima}}</p></td>
                                                </tr>
                                                <tr>
                                                    <td><p class="inv-title-1">No. Arsip</p></td>
                                                    <td>{{$no_arsip}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><p class="inv-title-1">Dengan Hormat Harap</p></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                    <p class="name">
                                                        <ul class="p-s-10 mt-3">
                                                            <?php
                                                            $instruksi = explode(",",$disposisi_instruksi);
                                                            foreach ($instruksi as $key => $value) {
                                                               echo "<li>".$value."</li>";
                                                            }
                                                            ?>
                                                        </ul>
                                                    </p>
                                                </td>
                                                </tr>
                                            </table>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-center">

                                <h3 class="inv-title-1">Diteruskan Kepada</h3>
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped invoice-table">
                                        <thead class="bg-active">
                                        <tr class="tr">
                                            <th>No.</th>
                                            <th class="pl0 text-start">Nama</th>
                                            <th class="pl0 text-start">Jabatan</th>
                              
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (getVerifikasi($surat_masuk_token,2,$disposisi_tipe) as $index => $item)   
                                        <tr class="tr">
                                            <td>
                                                <div class="item-desc-1">
                                                    <span>{{$index+1}}</span>
                                                </div>
                                            </td>
                                            <td class="pl0">
                                                <p class="name">{{$item->jabatan_penerima_nama}}</p>
                                                @if ($item->is_status==0)
                                                <span class="label label-warning" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Belum Lihat</span>
                                                @elseif ($item->is_status==1)
                                                <span class="label label-info" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Sudah Dilihat</span>
                                                @elseif ($item->is_status==2)
                                                <span class="label label-success" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->read_at) }}">Sudah Dibaca</span>

                                                @if ($item->is_disposisi==1)
                                                <span class="label label-danger">& Disposisi</span>
                                                @endif

                                                @endif
                                            </td>
                                            <td class="pl0">
                                                <p class="name">{{$item->jabatan_penerima_posisi}}</p>
                                                <span class="text-muted">{{TglTimeIndo($item->created_at)}} - {{$item->deskripsi}}</span>
                                            </td>
                                        </tr>
                                        @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-bottom">
                                <div class="row">
                                    <div class="col-lg-10 col-md-8 col-sm-7">
                                        <div class="mb-30 dear-client">
                                            <h3 class="inv-title-1">Catatan</h3>
                                            <table class="table mb-0 invoice-table">
                                                <tr>
                                                    <td><p class="name">{{$disposisi_catatan}}</p><BR><BR><BR><BR><BR></td>
                                                </tr>
                                            </table>
                                        
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-5">
                                        <div class="mb-30 payment-method">
                                            <h3 class="inv-title-1">Scan QR-Code</h3>
                                            {!! QrCode::size(170)->generate(route('main.disposisimasuk.cetak', ['id' => $primaryId])) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-contact d-print-none">
                                <div class="row g-0">
                                    <div class="col-lg-10 col-md-11 col-sm-12">
                                        <div class="contact-info">
                                            <a href="tel:{{getSetting()->phone}}"><i class="fa fa-phone"></i> {{getSetting()->phone}}</a>
                                            <a href="tel:{{getSetting()->email}}"><i class="fa fa-envelope"></i> {{getSetting()->email}}</a>
                                            <a href="#" class="mr-0 d-none-580"><i class="fa fa-map-marker"></i> {{getSetting()->address}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-btn-section clearfix d-print-none">
                            <a href="javascript:window.print()" class="btn btn-lg btn-print btn-success">
                                <i class="fa fa-print"></i> Cetak
                            </a>
                            <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme btn-success">
                                <i class="fa fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice 1 end -->
                
    </div>