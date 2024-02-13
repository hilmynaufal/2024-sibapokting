<div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Tanggal Terima</label>
      <div class="col-md-9">
        <input type="text" class="form-control-plaintext" wire:model="tgl_terima" disabled="">
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
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Alamat Pengirim</label>
      <div class="col-md-9">
          <input type="text" class="form-control-plaintext" wire:model="alamat_pengirim" disabled="">
        </div>
    </div>
    <div class="form-group row">
        <label class="control-label text-start text-md-end col-md-3 col-form-label pt-0">Perihal</label>
        <div class="col-md-9 d-flex align-items-start">
            <input type="text" class="form-control-plaintext" wire:model="perihal_surat" disabled="">
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
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Isi Surat</label>
      <div class="col-md-9">
        <input type="text" class="form-control-plaintext" wire:model="isi_surat" disabled="">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Keterangan</label>
      <div class="col-md-9">
        <input type="text" class="form-control-plaintext" wire:model="keterangan_surat" disabled="">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Pengirim</label>
      <div class="col-md-9">
        <input type="text" class="form-control-plaintext" wire:model="pengirim_surat" disabled="">
      </div>
    </div>
    <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Lampiran</label>
      <div class="col-md-9">
        {{-- @dump($surat_masuk_token) --}}
      @include('livewire.main.surat-masuk.detail-surat-lampiran',['id'=>$surat_masuk_token])

      </div>
    </div>

</div>