@section('title')
Tambah Bulk Harga Komoditas
@stop
@section('menu')
Layanan > BPHTB > <b>Tambah Bulk Harga Komoditas</b>
@stop

@push('css')
    <style>
        .select2-container--open {
            z-index: 999999999;
        }

        .select2-container {
            z-index: 999999999;
        }
        
        .table-harga td {
            vertical-align: middle;
        }
    </style>
@endpush

<div id="kt_app_content_container" class="app-container  container-xxl ">
    <div class="row g-5 g-xl-8">
        <div class="col-lg-12 col-xxl-12">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">Tambah Banyak Harga Pangan</span>
                    </h3>
                    <div class="d-flex gap-2">
                        <div class="card-toolbar">
                            <a href="{{ route('main.komoditas') }}" class="btn btn-sm btn-light btn-active-secondary">
                                <i class="ki-duotone ki-arrow-left fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body py-3">
                    <form wire:submit="create">
                        <div class="row mb-8">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Tanggal Penginputan</label>
                                <input required type="datetime-local" class="form-control" id="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                                    wire:model.live="tanggal" />
                                @error('tanggal') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Pasar</label>
                                <select required class="form-control form-select-solid @error('pasarId') is-invalid @enderror" name="pasarId"
                                    wire:model.live="pasarId" id="pasarId">
                                    <option value="">-- Pilih Pasar --</option>
                                    @foreach($listPasar as $val)
                                        <option value="{{$val->id}}">{{$val->namapasar}}</option>
                                    @endforeach
                                </select>
                                @error('pasarId') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="separator separator-dashed my-5"></div>

                        @if($pasarId && $tanggal)
                            @if(count($rows) > 0)
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 table-harga">
                                        <thead>
                                            <tr class="fw-bolder text-muted">
                                                <th class="min-w-50px">No</th>
                                                <th class="min-w-200px">Komoditas</th>
                                                <th class="min-w-150px">Harga Kemarin</th>
                                                <th class="min-w-200px">Input Harga Baru (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach($rows as $komoditasId => $row)
                                            <tr wire:key="row-{{ $komoditasId }}">
                                                <td>{{ $no++ }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex justify-content-start flex-column">
                                                            <span class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                                                {{ $row['nama'] }}
                                                            </span>
                                                            <span class="text-muted fw-semibold text-muted d-block fs-7">
                                                                Satuan: {{ $row['satuan'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($row['hargaKemarin'] > 0)
                                                        <span class="badge badge-light-info fs-7">{{ rupiah($row['hargaKemarin'], 0) }}</span>
                                                    @else
                                                        <span class="badge badge-light-secondary fs-7">Belum Ada Data</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" wire:model="rows.{{ $komoditasId }}.harga" placeholder="0" min="0">
                                                    @error('rows.'.$komoditasId.'.harga') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary" wire:target="create">Simpan Harga</button>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Semua komoditas untuk pasar ini pada tanggal tersebut sudah diinput.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info">
                                Silakan pilih Tanggal dan Pasar terlebih dahulu untuk menampilkan daftar komoditas.
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
