@section('title')
Integrasi Data
@stop
@section('menu')
Referensi > <b>Integrasi Data</b>
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
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    new DataTable('#datatablePangkalan', {
        responsive: true
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
                        <span class="card-label fw-bold fs-3 mb-1">Data Pangkalan</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        data-bs-original-title="Click to add a user" data-kt-initialized="1">
                        <a href="{{route('master.referensi.addpangkalan')}}" class="btn btn-sm btn-light btn-active-primary">
                            <i class="ki-duotone ki-plus fs-2"></i> Tambah Kios
                        </a>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="datatablePangkalan">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th>No</th>
                                    <th>Bahan Pokok</th>
                                    <th>Tanggal</th>
                                    <th>Pasar</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($komoditas as $i => $val) 
                                    @foreach ($val->data as $value) 
                                    <tr>
                                        <td>{{$no;}}</td>
                                        <td style="vertical-align: middle;">{{$value->commodity_id}}-{{$value->commodity_name}}</td>
                                        <td style="vertical-align: middle;">{{tglIndoHari($value->time)}}</td>
                                        <td style="vertical-align: middle;">{{$value->market_name}}</td>
                                        <td style="vertical-align: middle;">{{rupiah($value->value,0)}}</td>
                                    </tr>
                                    <?php $no++; ?>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>

                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
        </div>
    </div>
</div>


<!--end::Col-->

@push('meta')
<meta name="turbolinks-visit-control" content="reload">
<meta name="turbolinks-cache-control" content="no-cache">
@endpush


@push('css')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@endpush

@push('js')
<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
@endpush


