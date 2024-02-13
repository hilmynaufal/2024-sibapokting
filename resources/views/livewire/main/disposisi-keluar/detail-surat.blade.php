 {{-- Informasi Detail Surat Masuk --}}
 <div class="accordion" id="accordionDetailSurat">
    <div class="accordion-item">
    <h2 class="accordion-header">

    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
    <i class="fa fa-envelope m-e-10"></i> Detail Surat
    </button>
      
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionDetailSurat">
    <div class="accordion-body">
      

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
      <label class="control-label text-start text-md-end col-md-3 col-form-label">Isi Disposisi</label>
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

      @foreach (getLampiran($surat_masuk_token) as $index => $item)
      <div class="card shadow-none border-primary">
        <div class="card-body p-10 text-primary">
          {{-- <a href="{{ Storage::disk('public')->url($item->file_lampiran_url) }}" target="_blank"> --}}
          {{-- <a href="{{ url('main/lampiran/preview/'.Crypt::encrypt($item->id_lampiran)) }}" target="_blank"> --}}
            <a type="button" @click="$dispatch('view-lampiran',{primaryId:'{{$item->file_lampiran_url}}'})" data-bs-toggle="modal" data-bs-target="#modal-lampiran">
            <i class="fa fa-paperclip"></i>&nbsp; {{$item->file_lampiran}}
          </a>
        </div>
      </div>
      @endforeach


      </div>
    </div>


</div>
</div>
</div>
</div>