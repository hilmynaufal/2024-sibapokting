
<div class="modal fade show" id="view" tabindex="-1" style="display: block; padding-left: 0px;"
    aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Data {{$namakomoditas}}</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="$dispatch('closeModal')">
                </button>
            </div>
            <div class="modal-body" style="text-align:left;">
                <form class="form-horizontal" wire:submit="create">
                    <input type="hidden" id="id" name="id" wire:model="id" class="form-control">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Nama<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('namakomoditas') is-invalid @enderror" name="namakomoditas"
                                    wire:model="namakomoditas" id="namakomoditas" >
                                @error('namakomoditas') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Harga Eceran Tertingg<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('het') is-invalid @enderror" name="het"
                                    wire:model="het" id="het" >
                                @error('het') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Satuan Berat<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan"
                                    wire:model="satuan" id="satuan" >
                                @error('satuan') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Gambar<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                    <img src="{{ Storage::disk('public')->url($gambar) }}" alt="image">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>