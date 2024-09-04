<div class="modal fade show" id="add" data-bs-focus="false" style="display: block; padding-left: 0px;"
    aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Harga Pangan</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="$dispatch('closeModal')">
                </button>
            </div>

            <div class="modal-body" style="text-align:left;">
                <form class="form-horizontal" wire:submit="update">
                    <input type="hidden" id="id_komoditas_update" name="id_komoditas_update" wire:model="id_komoditas_update" class="form-control">
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Tanggal Penginputan<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input disabled type="datetime-local" class="form-control" placeholder="Pick date rage" id="tanggal"
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
                                <select disabled type="text" class="form-control form-control-lg form-select-solid @error('pasarId') is-invalid @enderror" name="pasarId"
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
                                <label class="form-label">Komoditas<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <select disabled type="text" class="form-control form-control-lg form-select-solid @error('komoditasId') is-invalid @enderror" name="komoditasId"
                                    wire:model="komoditasId" id="komoditasId">
                                    <option value="">-- Pilih Komoditas --</option>
                                    @foreach($listKomoditas as $val)
                                        <option value="{{$val->id}}">{{$val->namakomoditas}}</option>
                                    @endforeach
                                </select>
                                @error('komoditasId') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 fv-row fv-plugins-icon-container">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Harga Sekarang<span class="text-danger"></span></label>
                            </div>
                            <div class="col-md-10">
                                <input disabled type="number" class="form-control" id="harga"
                                class="form-control @error('harga') is-invalid @enderror" name="harga"
                                wire:model="harga"/>
                                @error('harga') <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

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