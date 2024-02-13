<div>
  <div class="form-group row">
    <label class="control-label text-start text-md-end col-md-3 col-form-label">Tipe Surat</label>
    <div class="col-md-9">
      <input type="text" class="form-control-plaintext" wire:model="is_type" disabled="">
    </div>
  </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Tanggal Surat</label>
      <div class="col-md-9">
        <input type="text" class="form-control-plaintext" wire:model="tgl_surat" disabled="">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Nomor Surat</label>
      <div class="col-md-9">
        <input type="text" class="form-control-plaintext" wire:model="no_surat" disabled="">
      </div>
    </div>
    <div class="form-group row">
        <label class="control-label text-start text-md-end col-md-3 col-form-label">Jenis Surat</label>
        <div class="col-md-9">
          <input type="text" class="form-control-plaintext" wire:model="jenis_surat_id" disabled="">
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label text-start text-md-end col-md-3 col-form-label">Sifat Surat</label>
        <div class="col-md-9">
          <input type="text" class="form-control-plaintext" wire:model="sifat_surat_id" disabled="">
        </div>
      </div>
    <div class="form-group row">
        <label class="control-label text-start text-md-end col-md-3 col-form-label pt-0">Perihal</label>
        <div class="col-md-9 d-flex align-items-start">
            <textarea type="text" class="form-control-plaintext" wire:model="perihal_surat" disabled=""></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Tujuan</label>
      <div class="col-md-9">
        <input type="text" class="form-control-plaintext" wire:model="tujuan_surat_id" disabled="">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Nomor Arsip</label>
      <div class="col-md-9">
        <input type="text" class="form-control-plaintext" wire:model="no_arsip" disabled="">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Keterangan</label>
      <div class="col-md-9">
        <textarea type="text" class="form-control-plaintext" wire:model="keterangan_surat" disabled=""></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Lampiran</label>
      <div class="col-md-9">

      @livewire('main.surat-keluar.detail-surat-lampiran',['id'=>$surat_masuk_token])

      </div>
    </div>

</div>