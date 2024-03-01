
<div class="modal fade show" id="add" data-bs-focus="false" style="display: block; padding-left: 0px;"
    aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Barang {{tglIndoHari(date('Y-m-d'))}}</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="$dispatch('closeModal')">
                </button>
            </div>

            <div class="modal-body" style="text-align:left;">
                <form class="form-horizontal" wire:submit="update">
                    <input type="hidden" id="id" name="id" wire:model.live="id" class="form-control">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Tanggal Penginputan<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input required type="datetime-local" class="form-control" placeholder="Pick date rage" id="tanggal"
                                class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                                wire:model="tanggal"/>
                                @error('tanggal') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Pasar<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10" wire:ignore>
                                <select x-init="$($el).select2({ placeholder: '-- Pilih Pasar --', });
                                    $($el).on('change', function() {
                                        $wire.set('pasarId', $($el).val());
                                    })"  required type="text" class="form-control form-control-lg form-select-solid @error('pasarId') is-invalid @enderror" name="pasarId"
                                    wire:model.live="pasarId" id="pasarId">
                                    <option value="">-- Pilih Pasar --</option>
                                    @foreach($listPasar as $val)
                                        <option value="{{$val->id}}">{{$val->namapasar}}</option>
                                    @endforeach
                                </select>
                                @error('pasarId') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Nama Barang<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <select x-init="$($el).select2({ placeholder: '-- Pilih Barang --', });
                                    $($el).on('change', function() {
                                        $wire.set('barangId', $($el).val());
                                    })" required type="text" class="form-control form-control-lg form-select-solid @error('barangId') is-invalid @enderror" name="barangId"
                                    wire:model="barangId" id="barangId">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($listBarang as $val)
                                        <option value="{{$val->id}}">{{$val->namabarang}}</option>
                                    @endforeach
                                </select>
                                @error('barangId') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Stok Awal<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input required type="number" class="form-control" id="stok_awal"
                                class="form-control @error('stok_awal') is-invalid @enderror" name="stok_awal"
                                wire:model="stok_awal"/>
                                @error('stok_awal') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Barang Masuk<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input required type="number" class="form-control" id="stok_masuk"
                                class="form-control @error('stok_masuk') is-invalid @enderror" name="stok_masuk"
                                wire:model="stok_masuk"/>
                                @error('stok_masuk') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Barang Keluar<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input required type="number" class="form-control" id="stok_keluar"
                                class="form-control @error('stok_keluar') is-invalid @enderror" name="stok_keluar"
                                wire:model="stok_keluar"/>
                                @error('stok_keluar') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Stok Akhir<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input required type="number" class="form-control" id="stok_akhir"
                                class="form-control @error('stok_akhir') is-invalid @enderror" name="stok_akhir"
                                wire:model="stok_akhir"/>
                                @error('stok_akhir') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    </div>
                    

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info float-start" wire:target="create">Submit</button>
                        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>