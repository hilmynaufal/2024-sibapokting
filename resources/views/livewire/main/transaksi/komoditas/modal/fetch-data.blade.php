<div class="modal fade show" id="fetchDataModal" data-bs-focus="false" style="display: block; padding-left: 0px;"
    aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ambil Data Komoditas</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="$dispatch('closeModal')">
                </button>
            </div>

            <div class="modal-body" style="text-align:left;">
                @if(!$showPreview)
                    {{-- State 1: Form Input --}}
                    <form wire:submit="loadPreview">
                        {{-- Alert Info --}}
                        <div class="alert alert-info d-flex align-items-center mb-5">
                            <i class="ki-duotone ki-information-5 fs-2hx text-info me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-dark">Informasi</h4>
                                <span>Fitur ini akan menyalin data komoditas dari tanggal yang dipilih ke tanggal tujuan.
                                    Data yang sudah ada akan dilewati (skip).</span>
                            </div>
                        </div>

                        {{-- Form Group: Pasar --}}
                        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Filter Pasar <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select @error('pasar_id') is-invalid @enderror"
                                        wire:model="pasar_id" required>
                                        <option value="">-- Pilih Semua Pasar --</option>
                                        @foreach($listPasar as $pasar)
                                            <option value="{{$pasar->id}}">{{$pasar->namapasar}}</option>
                                        @endforeach
                                    </select>
                                    @error('pasar_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                    <div class="form-text">Pilih pasar untuk filter data, atau pilih "Semua" untuk semua
                                        pasar</div>
                                </div>
                            </div>
                        </div>

                        {{-- Form Group: Tanggal Asal --}}
                        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Tanggal Asal (Sumber Data) <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="date" class="form-control @error('tanggal_asal') is-invalid @enderror"
                                        wire:model="tanggal_asal" required />
                                    @error('tanggal_asal')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                    <div class="form-text">Data komoditas akan diambil dari tanggal ini</div>
                                </div>
                            </div>
                        </div>

                        {{-- Form Group: Tanggal Tujuan --}}
                        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Tanggal Tujuan <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="date" class="form-control @error('tanggal_tujuan') is-invalid @enderror"
                                        wire:model="tanggal_tujuan" required />
                                    @error('tanggal_tujuan')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                    <div class="form-text">Data akan disalin ke tanggal ini</div>
                                </div>
                            </div>
                        </div>

                        {{-- Button Submit --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                wire:target="loadPreview">
                                <span wire:loading.remove wire:target="loadPreview">
                                    <i class="ki-duotone ki-eye fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    Tampilkan Preview
                                </span>
                                <span wire:loading wire:target="loadPreview">
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    Loading...
                                </span>
                            </button>
                        </div>
                    </form>
                @else
                    {{-- State 2: Preview Table --}}

                    {{-- Alert Summary --}}
                    @if($totalWillCopy > 0)
                        <div class="alert alert-success d-flex align-items-center mb-3">
                            <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-dark">{{ $totalWillCopy }} komoditas akan disalin</h4>
                                <span>Data ini akan disalin dari {{tglIndo($tanggal_asal)}} ke
                                    {{tglIndo($tanggal_tujuan)}}</span>
                            </div>
                        </div>
                    @endif

                    @if($totalSkipped > 0)
                        <div class="alert alert-warning d-flex align-items-center mb-3">
                            <i class="ki-duotone ki-information fs-2hx text-warning me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-dark">{{ $totalSkipped }} komoditas sudah ada (akan di-skip)</h4>
                                <span>Data komoditas ini sudah tersedia di tanggal tujuan {{tglIndo($tanggal_tujuan)}}</span>
                            </div>
                        </div>
                    @endif

                    @if($totalWillCopy == 0)
                        <div class="alert alert-danger d-flex align-items-center mb-3">
                            <i class="ki-duotone ki-cross-circle fs-2hx text-danger me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-dark">Tidak ada data yang bisa disalin</h4>
                                <span>Semua komoditas sudah ada di tanggal tujuan atau tidak ada data di tanggal asal</span>
                            </div>
                        </div>
                    @endif

                    {{-- Preview Table --}}
                    <div class="table-responsive mb-5" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th class="text-center" width="50px">No</th>
                                    <th width="200px">Nama Pasar</th>
                                    <th>Nama Komoditas</th>
                                    <th class="text-end" width="150px">Harga</th>
                                    <th class="text-center" width="150px">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($previewData as $index => $data)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $data['nama_pasar'] }}</td>
                                        <td>{{ $data['nama_komoditas'] }}</td>
                                        <td class="text-end">{{ rupiah($data['harga_publish'], 0) }}</td>
                                        <td class="text-center">
                                            @if($data['status'] == 'copy')
                                                <span class="badge badge-success">Akan disalin</span>
                                            @else
                                                <span class="badge badge-warning">Sudah ada (skip)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Button Group --}}
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" wire:click="resetPreview">
                            <i class="ki-duotone ki-arrow-left fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Kembali
                        </button>
                        <button type="button" class="btn btn-success" wire:click="copyData" wire:loading.attr="disabled"
                            wire:target="copyData" @if($totalWillCopy == 0) disabled @endif>
                            <span wire:loading.remove wire:target="copyData">
                                <i class="ki-duotone ki-check fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Salin Data ({{ $totalWillCopy }})
                            </span>
                            <span wire:loading wire:target="copyData">
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                Menyalin...
                            </span>
                        </button>
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" wire:click="$dispatch('closeModal')">Tutup</button>
            </div>
        </div>
    </div>
</div>