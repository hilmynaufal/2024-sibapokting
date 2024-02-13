<div>
  <div>
    <HR>
      <form action="">
    <h6 class="f-w-600">Laporan Tindak Lanjut Disposisi</h6>
    <div class="form-group row">
      <div class="col-md-12">
        <textarea rows="4" id="deskripsi" name="deskripsi" wire:model='deskripsi' class="form-control" data-placeholder="Ketikkan uraian laporan tindak lanjut disposisi"></textarea>
        @error('deskripsi')
        <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
        @enderror
    </div>
    </div>
    <div class="form-group row">
        <label class="control-label text-start text-md-end col-md-3 col-form-label" for="file_lampiran">Lampiran <span wire:loading wire:target="file_lampiran" class="spinner-border spinner-border-sm align-middle ms-2"></span></label>
        <div class="col-md-9">
            <input multiple type="file" id="file_lampiran" wire:model="file_lampiran" name="file_lampiran" class="form-control @error('file_lampiran') is-invalid @enderror">
            <small class="form-text">Format file *.PDF atau *.JPG, ukuran maks. 10 MB</small>
            @error('file_lampiran')
            <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
            @enderror
        </div>
    </div>
  </div>
  <div class="form-action m-t-24">
    <div class="row">
        <div class="col-sm-6">
            <button wire:click.prevent="toggle" type="button" class="btn btn-secondary w-100 mailbox-trigger-close"><i class="fa fa-times"></i> Batal</button>
          </div>
          <div class="col-sm-6">
            <button wire:offline.attr="disabled" wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
            wire:click.prevent="store" type="button" class="btn btn-success w-100 mailbox-trigger-close"><i class="fa fa-save"></i> Simpan <span wire:loading wire:target="store" class="spinner-border spinner-border-sm align-middle ms-2"></span></button>
          </div>
    </div>
  </div>
</form>
</div>
