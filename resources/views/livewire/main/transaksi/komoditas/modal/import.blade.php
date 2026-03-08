<div class="modal fade show" id="add" data-bs-focus="false" style="display: block; padding-left: 0px;" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Harga Pangan {{tglIndoHari(date('Y-m-d'))}}</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="$dispatch('closeModal')">
                </button>
            </div>

            <div class="modal-body" style="text-align:left;">
                <form class="form-horizontal" wire:submit.prevent="create" wire:ignore.self>
                    <input type="hidden" id="id" name="id" wire:model="id" class="form-control">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Tanggal Penginputan<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input required type="datetime-local" class="form-control" placeholder="Pick date rage"
                                    id="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                    name="tanggal" wire:model="tanggal" />
                                @error('tanggal') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Opsi Import</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" id="replaceMode" wire:model="replaceMode"/>
                                    <label class="form-check-label" for="replaceMode">
                                        Replace Data (Timpa data lama jika harga pada tanggal yang sama sudah ada)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Upload File Excel<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="file" class="form-control" wire:model="file" wire:ignore.self
                                    accept=".xlsx,.xls">
                                <small class="form-text text-muted">Format file: .xlsx atau .xls dengan header "nama
                                    komoditas" dan di ikuti nama pasar yang sesuai</small>
                                <br>
                                <a href="/assets/docs/panduan_import_komoditas.md" target="_blank"
                                    class="btn btn-outline-info btn-sm mt-1">
                                    <i class="fas fa-book"></i> Lihat Panduan
                                </a>
                                <button type="button" class="btn btn-warning btn-sm mt-2" wire:click="previewFile"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="previewFile">Preview Data</span>
                                    <span wire:loading wire:target="previewFile">Loading...</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Data Section -->
                    @if($showPreview)
                        <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Preview Data Excel</h6>
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                wire:click="hidePreview">Tutup Preview</button>
                                        </div>
                                        <div class="card-body">
                                            @if(count($previewData) > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Komoditas (Excel)</th>
                                                                <th>Status Komoditas</th>
                                                                @if(isset($previewData[0]['per_pasar']))
                                                                    @foreach($previewData[0]['per_pasar'] as $pasar)
                                                                        <th>{{ $pasar['pasar'] }}</th>
                                                                    @endforeach
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($previewData as $index => $data)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $data['nama_komoditas'] }}</td>
                                                                    <td>
                                                                        @if($data['komoditas_found'])
                                                                            <span
                                                                                class="badge badge-success">{{ $data['komoditas_name'] }}</span>
                                                                        @else
                                                                            <span class="badge badge-danger">Tidak ditemukan</span>
                                                                        @endif
                                                                    </td>
                                                                    @foreach($data['per_pasar'] as $perPasar)
                                                                        <td>
                                                                            @if($perPasar['harga'] !== null && $perPasar['harga'] !== '')
                                                                                <span>Baru: {{ number_format($perPasar['harga']) }}</span><br>
                                                                                
                                                                                @if($perPasar['existing'])
                                                                                    <span class="text-muted" style="font-size: 0.85em;">Lama: {{ number_format($perPasar['harga_lama']) }}</span><br>
                                                                                    @if($perPasar['selisih'] !== null)
                                                                                        @if($perPasar['selisih'] > 0)
                                                                                            <span class="text-danger" style="font-size: 0.85em;"><i class="fas fa-arrow-up text-danger"></i> {{ number_format(abs($perPasar['selisih'])) }}</span><br>
                                                                                        @elseif($perPasar['selisih'] < 0)
                                                                                            <span class="text-success" style="font-size: 0.85em;"><i class="fas fa-arrow-down text-success"></i> {{ number_format(abs($perPasar['selisih'])) }}</span><br>
                                                                                        @else
                                                                                            <span class="text-secondary" style="font-size: 0.85em;"><i class="fas fa-minus text-secondary"></i> Stabil</span><br>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                                
                                                                                @if($perPasar['is_valid'])
                                                                                    <span class="badge badge-success mt-1">Valid</span>
                                                                                @else
                                                                                    <span class="badge badge-danger mt-1">Tidak valid</span>
                                                                                @endif
                                                                            @else
                                                                                <span class="text-muted">-</span>
                                                                            @endif
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="alert alert-info">
                                                    <strong>Catatan:</strong>
                                                    <ul class="mb-0">
                                                        <li>Pastikan nama komoditas dan nama pasar sesuai dengan data master</li>
                                                        <li>Pastikan komiditas yang di import ada di database</li>
                                                        <li>Pastikan harga komoditas hari ini belum di input</li>
                                                        <li>Harga harus berupa angka positif</li>
                                                    </ul>
                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    Tidak ada data yang dapat ditampilkan dalam preview.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info float-start" wire:target="create"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="create">Import Data</span>
                            <span wire:loading wire:target="create">Importing...</span>
                        </button>
                        <button type="button" class="btn btn-secondary"
                            wire:click="$dispatch('closeModal')">Close</button>
                    </div>
                </form>

                @if(!empty($importErrors))
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach($importErrors as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>