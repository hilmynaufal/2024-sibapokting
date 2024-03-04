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
                <!--begin::Body-->
                <div class="card-body p-10 p-lg-15">
                    <!--begin::Content main-->
                    <div class="mb-14 ">
                        <!--begin::Heading-->
                        <div class="mb-15">
                            <!--begin::Title-->
                            <h1 class="fs-2x text-gray-900 mb-6">Integrasi Silinda Provinsi Jawa Barat</h1>
                            <!--end::Title-->

                            <!--begin::Text-->
                            <div class="fs-5 text-gray-600 fw-semibold">
                                <!-- First, a disclaimer – the entire process of writing a blog post often takes more
                                than a couple of hours, even if you can type
                                eighty words as per minute and your writing skills are sharp. -->
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Heading-->

                        <!--begin::Body-->

                        <!--begin::Table-->
                        <div class="mb-14">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800 text-center border-0 bg-light">
                                            <th class="min-w-200px rounded-start"></th>
                                            <th class="min-w-140px">Tanggal</th>
                                            <th class="min-w-120px">Status</th>
                                            <th class="min-w-100px rounded-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->

                                    <!--begin::Table body-->
                                    <tbody class="border-bottom border-dashed">
                                        @foreach($pasar as $value)

                                        <tr class="text-center">
                                            <td class="text-start ps-6">
                                                <div class="fw-semibold fs-4 text-gray-800">
                                                {{$value->namapasar}}
                                                </div>
                                            </td>
                                            <td>
                                                {{empty($value->last_integrasi) ? '-' : tglIndoHari($value->last_integrasi)}} 
                                            </td>

                                            <td>
                                                @if($value->last_integrasi != date("Y-m-d"))
                                                <i class="ki-outline ki-0 fs-2x text-danger"></i>
                                                <i class="ki-outline ki-cross fs-2x text-danger"></i> </td>
                                                @else
                                                <i class="ki-outline ki-check fs-2x text-success"></i>
                                                <i class="ki-outline ki-0 fs-2x text-success"></i> </td>
                                                @endif
                                            <td>
                                                <button class="btn btn-sm btn-dark lh-1 py-4" wire:click="singkronisasi({{$value->id}})">
                                                    <i class="ki-outline ki-setting-4 fs-4 me-1"></i> Singkronisasi data
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--end::Table-->
                        <!--end::Body-->
                    </div>
                    <!--end::Content main-->

                </div>
            </div>
            <!--begin::Body-->
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