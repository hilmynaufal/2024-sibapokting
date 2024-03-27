@section('title')
Home
@stop
@section('utama')
Grafik
@stop
@section('submenu')
Varians Komoditas
@stop

<div>
    @livewire('Frontend.Sidebar')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl ">
                <!--begin::Row-->
                <div class="row g-5 g-xl-12">
                    <!--begin::Col-->
                    <div class="col-xl-12">
                        <div class="card card-flush">
                            <!--begin::Header-->
                            <div class="card-header py-5">
                                <!--begin::Title-->
                                <h3 class="card-title fw-bold text-gray-800">Rentang Harga</h3>
                                <!--end::Title-->

                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                    
                                    </div>
                                    <!--end::Daterangepicker-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->

                            <!--begin::Card body-->
                            <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                @foreach ($jsonData->data as $pasar)
                                                    <th>{{ $pasar->name }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jsonData->meta->date as $index => $date)
                                                <tr>
                                                    <td>{{ $jsonData->meta->date_str[$index] }}</td>
                                                    @foreach ($jsonData->data as $pasar)
                                                        @php
                                                            $data = collect($pasar->by_date)->firstWhere('date', $date);
                                                        @endphp
                                                        <td>{{ $data ? $data->prices : '-' }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <!--end::Row-->
                   
                </div>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

    <!--end::Content wrapper-->
</div>

@push('js')
<script>
</script>
@endpush