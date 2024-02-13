<div>
    <form action="">
        <div class="form-body">
            <div class="row align-items-center">
                <div class="col-sm-1 text-center">
                    <a type="button" wire:click.prevent="toggle" class="mailbox-trigger-close" data-bs-toggle="tooltip" title="Tutup"><i class="fa fa-times f-s-18 text-muted"></i></a>
                </div>
                <div class="col-sm-11">
                    <div class="alert alert-secondary p-y-8 text-muted mb-0">
                        <i>*) Wajib diisi</i>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="tgl_terima">Tanggal Terima<span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="date" wire:model.blur="tgl_terima" name="tgl_terima" class="form-control datepicker @error('tgl_terima') is-invalid @enderror" placeholder="Pilih tanggal terima surat">
                    <input type="hidden" class="form-control  @error('surat_masuk_id') is-invalid @enderror" wire:model="nama_id" />

                    @error('tgl_terima')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="tgl_surat">Tanggal Surat<span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="date" wire:model.blur="tgl_surat" name="tgl_surat" class="form-control datepicker @error('tgl_surat') is-invalid @enderror" placeholder="Pilih tanggal surat">
                    @error('tgl_surat')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="no_surat">Nomor Surat<span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" wire:model="no_surat" name="no_surat" class="form-control @error('no_surat') is-invalid @enderror" placeholder="Ketikkan nomor surat">
                    @error('no_surat')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="alamat_pengirim">Alamat Pengirim</label>
                <div class="col-md-9">
                    <textarea rows="3" wire:model="alamat_pengirim" class="form-control @error('alamat_pengirim') is-invalid @enderror" placeholder="Ketikkan alamat pengirim"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="perihal_surat">Perihal<span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" wire:model="perihal_surat" name="perihal_surat" class="form-control @error('perihal_surat') is-invalid @enderror" placeholder="Ketikkan perihal surat">
                    @error('perihal_surat')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="sekretaris_surat_id">Sekretaris<span class="text-danger">*</span></label>
              <div class="col-md-9">
                  <select id="sekretaris_surat_id" wire:model="sekretaris_surat_id" name="sekretaris_surat_id" class="form-select select2 @error('sekretaris_surat_id') is-invalid @enderror" data-placeholder="-- Pilih Sekretaris --">
                      <option value="">-- Pilih Sekretaris --</option>  
                    @foreach ($sekretaris_list as $item)
                       <option value="{{ $item->pegawai_id }}">{{ $item->jabatan_kode }} - {{ $item->jabatan_nama }} ( {{ $item->pegawai_nama }} )</option>
                      @endforeach
                  </select>
                  @error('sekretaris_surat_id')
                  <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                  @enderror
              </div>
          </div>

                     

            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="tujuan_surat_id">Tujuan<span class="text-danger">*</span></label>
                <div class="col-md-9">
                  <div wire:ignore.self>
                    <select id="tujuan_surat_id" wire:model.live="tujuan_surat_id" name="tujuan_surat_id" class="form-select select2 @error('tujuan_surat_id') is-invalid @enderror" data-placeholder="-- Pilih Tujuan --">
                        <option value="">-- Pilih Tujuan Surat --</option>
                        @foreach ($unit_kerja_list as $item)
                        <option value="{{ $item->pegawai_id }}">{{ $item->jabatan_kode }} - {{ $item->jabatan_nama }} ( {{ $item->pegawai_nama }} )</option>
                        @endforeach
                    </select>
                  </div>
                    @error('tujuan_surat_id')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                    @enderror
                </div>
            </div>


            @if ($tujuan_surat_id!=NULL)

            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="no_arsip">Nomor Arsip</label>
              <div class="col-md-9">

                @if ($mode == 'create') 
                <input type="text" id="no_arsip_surat" name="no_arsip" value="{{ generateArsipMasukNumber($tujuan_surat_id) }}" class="form-control disable" placeholder="Terisi otomatis oleh sistem">
                @else 
                <input wire:model="no_arsip" name="no_arsip" class="form-control @error('no_arsip') is-invalid @enderror" placeholder="Terisi otomatis oleh sistem">
                @endif
                          
                @error('no_arsip')
                <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                @enderror
              </div>
            </div>

            @endif
                      

            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="isi_surat">Isi Surat</label>
                <div class="col-md-9">
                    <textarea rows="4" id="isi_surat" wire:model="isi_surat" name="isi_surat" class="form-control ckeditor4 @error('isi_surat') is-invalid @enderror" data-placeholder="Ketikkan uraian isi surat"></textarea>
                    @error('isi_surat')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="keterangan_surat">Keterangan</label>
                <div class="col-md-9">
                    <textarea rows="3" id="keterangan_surat" wire:model="keterangan_surat" name="keterangan_surat" class="form-control @error('keterangan_surat') is-invalid @enderror" placeholder="Ketikkan uraian keterangan"></textarea>
                    @error('keterangan_surat')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label text-start text-md-end col-md-3 col-form-label" for="pengirim_surat">Pengirim</label>
                <div class="col-md-9">
                    <input type="text" wire:model="pengirim_surat" name="pengirim_surat" class="form-control @error('pengirim_surat') is-invalid @enderror" placeholder="Ketikkan nama pengirim surat">
                    @error('pengirim_surat')
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
        <!--end: Card Body-->

        <div class="card-footer">

            <div class="row">
                @if ($mode == 'create')

                <div class="col-sm-6">
                  <button wire:click.prevent="toggle" type="button" class="btn btn-secondary w-100 mailbox-trigger-close"><i class="fa fa-times"></i> Batal</button>
                </div>
                <div class="col-sm-6">
                  <button wire:offline.attr="disabled" wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
                  @if ($mode == 'create') wire:click.prevent="store" @else wire:click.prevent="update" @endif type="button" class="btn btn-success w-100 mailbox-trigger-close"><i class="fa fa-save"></i> Simpan <span wire:loading  @if ($mode == 'create') wire:target="store" @else wire:target="update" @endif class="spinner-border spinner-border-sm align-middle ms-2"></span></button>
                </div>

                @else

                <div class="col-sm-3">
                    <button wire:offline.attr="disabled" wire:loading.class.remove="btn-danger" wire:loading.attr="disabled" wire:click="deleteConfirm({{ $surat_masuk_id }})" type="button" class="btn btn-danger w-100 mailbox-trigger-close"><i class="fa fa-times"></i> Hapus</button>
                  </div>
                <div class="col-sm-3">
                  <button wire:click.prevent="toggle" type="button" class="btn btn-secondary w-100 mailbox-trigger-close"><i class="fa fa-times"></i> Batal</button>
                </div>
                <div class="col-sm-6">
                  <button wire:offline.attr="disabled" wire:loading.class.remove="btn-success" wire:loading.attr="disabled"
                  @if ($mode == 'create') wire:click.prevent="store" @else wire:click.prevent="update" @endif type="button" class="btn btn-success w-100 mailbox-trigger-close"><i class="fa fa-save"></i> Simpan <span wire:loading  @if ($mode == 'create') wire:target="store" @else wire:target="update" @endif class="spinner-border spinner-border-sm align-middle ms-2"></span></button>
                </div>

                @endif

              </div>

        </div>
                    
    </form>
</div>
