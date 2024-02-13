<div>
  @section('title', 'Surat Keluar')
  
  <div class="row">
      
      <div class="col-lg-{{ $isOpen ? '6' : '12' }}">
          <!--begin::Header-->
          <div class="card-header">
              <div class="row">
                  <div class="col-sm-12 col-md-6">
                      
                      <button wire:click="create" class="btn btn-success mailbox-trigger-edit" type="button"><i
                          class="fa fa-plus"></i> Tambah</button>
                          
                          
                      </div>
                      <div class="col-sm-12 col-md-6">
                          <!--begin::Form-->
                          <form method="get" class="quick-search-form">
                              <div class="input-group rounded bg-light">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">
                                          <span class="svg-icon svg-icon-lg">
                                              <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                              <svg xmlns="http://www.w3.org/2000/svg"
                                              xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                              viewBox="0 0 24 24" version="1.1">
                                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                  <rect x="0" y="0" width="24" height="24" />
                                                  <path
                                                  d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                  fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                  <path
                                                  d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                  fill="#000000" fill-rule="nonzero" />
                                              </g>
                                          </svg>
                                          <!--end::Svg Icon-->
                                      </span>
                                  </span>
                              </div>
                              <input type="text" class="form-control h-45px" placeholder="Search..."
                              wire:model.live="search" />
                          </div>
                      </form>
                      <!--end::Form-->
                  </div>
              </div>
          </div>
          
          <!--end::Header-->
          <!--begin::Body-->
          <div class="mailbox-list">
              
              <p class="alert alert-danger col-md-12" wire:offline>
                  Anda Sedang Offline
              </p>
              
              
              @include('livewire.main.surat-keluar.admin')
              
              <div class="col-sm-12 col-md-6">
                  
                  <select wire:model.live="perpage" class="form-control form-sm" style="width: 75px;">
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                  </select>
                  
                  Menampilkan {{ $model->firstItem() }} - {{ $model->lastItem() }} dari {{ $model->total() }}
                  entri
                  
              </div>
              <div class="col-sm-12 col-md-6">
                  <div class="float-end">
                      {{ $model->links() }}
                  </div>
              </div>
              
          </div>
          <!--end::Table-->
          <!--end::Body-->
      </div>
  </div>
  
  
  @if ($isOpen)
  
  @if ($mode == 'view')
  <div class="mailbox-detail col-sm-6">
      <div class="card shadow-none border-none">
          <div class="card-body">
              
              <div class="form-body">
                  <div class="row align-items-center">
                      <div class="col-sm-4 text-start">
                          <a type="button" wire:click.prevent="toggle" class="mailbox-trigger-close"
                          data-bs-toggle="tooltip" aria-label="Tutup" data-bs-original-title="Tutup"><i
                          class="fa fa-times f-s-18 text-muted m-e-12"></i></a>
                          <a type="button" wire:click="edit({{ $primaryId }})"
                          class="mailbox-trigger-edit" data-bs-toggle="tooltip" data-has-access="operator"
                          aria-label="Ubah Data" data-bs-original-title="Ubah Data"><i
                          class="fa fa-edit f-s-18 text-warning m-e-12"></i></a>
                          {{-- <a type="button" wire:click="viewTracking({{ $primaryId }})" data-bs-toggle="tooltip" aria-label="Cetak Surat" data-bs-original-title="Cetak Surat"><i class="fa fa-print f-s-18 text-success"></i></a> --}}
                          {{-- <a type="button" wire:click="viewTracking({{ $primaryId }})" data-bs-toggle="tooltip" aria-label="Lihat Timeline Surat" data-bs-original-title="Lihat Timeline Surat"><i class="fa fa-th-list f-s-18 text-primary"></i></a> --}}
                          <a type="button"
                          @click="$dispatch('view-timeline',{primaryId:'{{ $surat_masuk_token }}'})"
                          data-bs-toggle="modal" data-bs-target="#modal-tracking-surat"
                          data-has-access="direktur"><i class="fa fa-th-list f-s-18 text-primary"></i></a>
                          
                      </div>
                  </div>
                  <br>
                  
                  @livewire('main.surat-keluar.detail-surat', ['id' => $surat_masuk_token])
                  
              </div>
              <div class="form-action m-t-24">
                  <div class="row">
                      <div class="col-sm-6">
                          <button type="button" wire:click.prevent="toggle"
                          class="btn btn-secondary w-100 mailbox-trigger-close"><i
                          class="fa fa-times"></i> Tutup</button>
                      </div>
                      <div class="col-sm-6">
                          {{-- <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modal-kirim-disposisi" data-has-access="direktur"><i class="fa fa-paper-plane"></i> Kirim Disposisi</button> --}}
                      </div>
                  </div>
              </div>
              
          </div>
      </div>
  </div>
  @endif
  
  
  @if ($mode == 'tracking')
  <div class="mailbox-detail col-sm-6">
      <div class="card shadow-none border-none">
          <div class="card-body">
              
              <div class="form-body">
                  <div class="row align-items-center">
                      <div class="col-sm-4 text-start">
                          <a type="button" wire:click="view({{ $primaryId }})"
                          class="mailbox-trigger-edit" data-bs-toggle="tooltip" aria-label="Kembali"
                          data-bs-original-title="Kembali"><i
                          class="fa fa-arrow-left f-s-18 text-primary m-e-12"></i></a>
                      </div>
                  </div>
                  <br>
                  
                  @livewire('main.surat-keluar.timeline', ['id' => $surat_masuk_token])
                  
                  
              </div>
              <div class="form-action m-t-24">
                  <div class="row">
                      <div class="col-sm-6">
                          <button type="button" wire:click.prevent="toggle"
                          class="btn btn-secondary w-100 mailbox-trigger-close"><i
                          class="fa fa-times"></i> Tutup</button>
                      </div>
                      <div class="col-sm-6">
                          {{-- <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modal-kirim-disposisi" data-has-access="direktur"><i class="fa fa-paper-plane"></i> Kirim Disposisi</button> --}}
                      </div>
                  </div>
              </div>
              
          </div>
      </div>
  </div>
  @endif
  
  
  @if ($mode == 'create' || $mode == 'update')
  
  
  <div class="mailbox-form col-sm-6" wire:ignore>
      <div class="card shadow-none border-none">
          <!--begin::Header-->
          <div class="card-header border-0">
              <h3 class="card-title font-weight-bolder text-dark">@yield('title') <div wire:dirty
                  class="text text-secondary">Draft</div>
                  <span wire:loading class="spinner-border spinner-border-sm align-middle ms-2"></span>
              </h3>
          </div>
          <!--end::Header-->
          <div class="card-body">
              <form action="">
                  <div class="form-body">
                      <div class="row align-items-center">
                          <div class="col-sm-1 text-center">
                              <a type="button" wire:click.prevent="toggle" class="mailbox-trigger-close"
                              data-bs-toggle="tooltip" title="Tutup"><i
                              class="fa fa-times f-s-18 text-muted"></i></a>
                          </div>
                          <div class="col-sm-11">
                              <div class="alert alert-secondary p-y-8 text-muted mb-0">
                                  <i>*) Wajib diisi</i>
                              </div>
                          </div>
                      </div>
                      <br>
                      
                      <div class="form-group row">
                          <label class="control-label text-start text-md-end col-md-3 col-form-label"
                          for="tgl_surat">Tanggal Surat<span class="text-danger">*</span></label>
                          <div class="col-md-9">
                              <input type="date" wire:model.blur="tgl_surat" name="tgl_surat"
                              class="form-control datepicker @error('tgl_surat') is-invalid @enderror"
                              placeholder="Pilih tanggal surat">
                              @error('tgl_surat')
                              <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                              @enderror
                          </div>
                      </div>
                      
                      <div class="form-group row">
                          <label class="control-label text-start text-md-end col-md-3 col-form-label"
                          for="jenis_surat_id">Jenis Surat<span class="text-danger">*</span></label>
                          <div class="col-md-9">
                              <div wire:ignore>
                                  <select x-init="$($el).select2({
                                      placeholder: '-- Pilih Tujuan --',
                                      {{-- allowClear: true, --}}
                                  });
                                  $($el).on('change', function() {
                                      $wire.set('jenis_surat_id', $($el).val())
                                  })" id="jenis_surat_id"
                                  wire:model="jenis_surat_id" name="jenis_surat_id"
                                  class="form-select @error('jenis_surat_id') is-invalid @enderror"
                                  data-placeholder="-- Pilih Tujuan --">
                                  <option value="">-- Pilih Jenis Surat --</option>
                                  @foreach ($jenis_surat_list as $item)
                                  <option value="{{ $item->id }}">{{ $item->kode }} - {{ $item->nama }}</option>
                                  @endforeach
                              </select>
                          </div>
                          @error('jenis_surat_id')
                          <div class="invalid-feedback form-text text-danger"> {{ $message }}
                          </div>
                          @enderror
                      </div>
                  </div>
                  
                  <div class="form-group row">
                      <label class="control-label text-start text-md-end col-md-3 col-form-label"
                      for="sifat_surat_id">Sifat Surat<span class="text-danger">*</span></label>
                      <div class="col-md-9">
                          <div wire:ignore.self>
                              <select x-init="$($el).select2({
                                  placeholder: '-- Pilih Sifat Surat --',
                                  {{-- allowClear: true, --}}
                              });
                              $($el).on('change', function() {
                                  $wire.set('sifat_surat_id', $($el).val())
                              })" id="sifat_surat_id"
                              wire:model="sifat_surat_id" name="sifat_surat_id"
                              class="form-select  @error('sifat_surat_id') is-invalid @enderror">
                              <option value="">-- Pilih Sifat Surat --</option>
                              @foreach ($sifat_surat_list as $item)
                              <option value="{{ $item->id }}">{{ $item->kode }} - {{ $item->nama }}</option>
                              @endforeach
                          </select>
                      </div>
                      @error('sifat_surat_id')
                      <div class="invalid-feedback form-text text-danger"> {{ $message }}
                      </div>
                      @enderror
                  </div>
              </div>
              
              <div class="form-group row">
                  <label class="control-label text-start text-md-end col-md-3 col-form-label"
                  for="penandatangan_surat">Penandatangan Surat<span
                  class="text-danger">*</span></label>
                  <div class="col-md-9" wire:ignore>
                      <select x-init="$($el).select2({
                        placeholder: '-- Pilih Penandatangan Surat --',
                        multiple: true,
                        {{-- allowClear: true, --}}
                    });
                    $($el).on('change', function() {
                        $wire.set('penandatangan_surat', $($el).val())
                    });
                    $($el).val({{ $list_penandatangan_surat }});
                    $($el).trigger('change');
                    " id="penandatangan_surat"
                      wire:model.live="penandatangan_surat" name="penandatangan_surat"
                      class="form-select  @error('penandatangan_surat') is-invalid @enderror">
                      <option value="" disabled="disabled">-- Pilih Penandatangan Surat --</option>
                      @foreach ($struktural_list as $item)
                      <option
                      value="{{ $item->pegawai_id }}:{{ $item->jabatan_id_token }}">
                      {{ $item->jabatan_kode }} - {{ $item->jabatan_nama }} (
                      {{ $item->pegawai_nama }} )</option>
                      @endforeach
                  </select>
                  @error('penandatangan_surat')
                  <div class="invalid-feedback form-text text-danger"> {{ $message }}
                  </div>
                  @enderror
              </div>
          </div>
          
          <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label"
              for="verifikator_id">Approval Kabag<span
              class="text-danger">*</span></label>
              <div class="col-md-9" wire:ignore>
                  <select x-init="$($el).select2({
                      placeholder: '-- Pilih Kabag --'
                  });
                  $($el).on('change', function() {
                      $wire.set('verifikator_id', $($el).val())
                  })" id="verifikator_id"
                  wire:model="verifikator_id" name="verifikator_id"
                  class="form-select  @error('verifikator_id') is-invalid @enderror">
                  <option value="">-- Pilih Kabag --</option>
                  @foreach ($unit_kerja_list_kabag as $item)
                  <option
                  value="{{ $item->pegawai_id }}:{{ $item->jabatan_id_token }}">
                  {{ $item->jabatan_kode }} - {{ $item->jabatan_nama }} (
                  {{ $item->pegawai_nama }} )</option>
                  @endforeach
              </select>
              @error('verifikator_id')
              <div class="invalid-feedback form-text text-danger"> {{ $message }}
              </div>
              @enderror
          </div>
      </div>
      
      <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-3 col-form-label"
          for="unit_kerja_id">Unit Kerja<span
          class="text-danger">*</span></label>
          <div class="col-md-9" wire:ignore>
              <select x-init="$($el).select2({
                  placeholder: '-- Pilih Unit Kerja --'
              });
              $($el).on('change', function() {
                  $wire.set('unit_kerja_id', $($el).val())
              })" id="unit_kerja_id"
              wire:model.live="unit_kerja_id" name="unit_kerja_id"
              class="form-select  @error('unit_kerja_id') is-invalid @enderror">
              <option value="">-- Pilih Unit Kerja --</option>
              @foreach ($unit_kerja_list as $item)
              <option
              value="{{ $item->id }}:{{ $item->token }}">
              {{ $item->kode }} - {{ $item->unit_kerja }}</option>
              @endforeach
          </select>
          @error('unit_kerja_id')
          <div class="invalid-feedback form-text text-danger"> {{ $message }}
          </div>
          @enderror
      </div>
  </div>
  
  <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label"
      for="no_surat">Nomor Surat</label>
      <div class="col-md-9">
          
          <input type="text" id="no_surat" disabled="true" name="no_surat"
          wire:model = "no_surat" class="form-control disable"
          placeholder="Terisi otomatis oleh sistem">
          
          @error('no_surat')
          <div class="invalid-feedback form-text text-danger"> {{ $message }}
          </div>
          @enderror
      </div>
  </div>
  
  <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label"
      for="perihal_surat">Perihal<span class="text-danger">*</span></label>
      <div class="col-md-9">
          <input type="text" wire:model="perihal_surat" name="perihal_surat"
          class="form-control @error('perihal_surat') is-invalid @enderror"
          placeholder="Ketikkan perihal surat">
          @error('perihal_surat')
          <div class="invalid-feedback form-text text-danger"> {{ $message }}
          </div>
          @enderror
      </div>
  </div>
  
  <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label"
      for="keterangan_surat">Keterangan</label>
      <div class="col-md-9">
          <textarea rows="3" id="keterangan_surat" wire:model="keterangan_surat" name="keterangan_surat"
          class="form-control @error('keterangan_surat') is-invalid @enderror" placeholder="Ketikkan uraian keterangan"></textarea>
          @error('keterangan_surat')
          <div class="invalid-feedback form-text text-danger"> {{ $message }}
          </div>
          @enderror
      </div>
  </div>
  
  <div x-data="{payFor: '{{ $is_type }}'}">
      
      <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-3 col-form-label"
          for="is_type">Internal / Eksternal<span class="text-danger">*</span></label>
          <div class="col-md-9" >
              <select x-model="payFor" name="payFor" id="is_type" wire:model.live="is_type"
              name="is_type"
              class="form-select  @error('is_type') is-invalid @enderror">
              <option value="">-- Pilih Internal / External--</option>
              <option value="1">Internal</option>
              <option value="2">Eksternal</option>
          </select>
          @error('is_type')
          <div class="invalid-feedback form-text text-danger"> {{ $message }}
          </div>
          @enderror
      </div>
  </div>                                    
  
  
  <div x-show="payFor == '1'">
      
      
      <div class="form-group row">
          <label class="control-label text-start text-md-end col-md-3 col-form-label"
          for="tujuan_surat_id">Tujuan<span class="text-danger">*</span></label>
          <div class="col-md-9">
              <div wire:ignore.self>
                  <select x-init="$($el).select2({
                      placeholder: '-- Pilih Tujuan Internal --'
                  });
                  $($el).on('change', function() {
                      $wire.set('tujuan_surat_id', $($el).val())
                  })" id="tujuan_surat_id" wire:model="tujuan_surat_id"
                  name="tujuan_surat_id"
                  class="form-select select2 @error('tujuan_surat_id') is-invalid @enderror"
                  data-placeholder="-- Pilih Tujuan --">
                  <option value="">-- Pilih Tujuan Surat --</option>
                  @foreach ($struktural_list as $item)
                  <option
                  value="{{ $item->pegawai_id }}:{{ $item->jabatan_id_token }}">
                  {{ $item->jabatan_kode }} - {{ $item->jabatan_nama }} (
                  {{ $item->pegawai_nama }} )</option>
                  @endforeach
              </select>
          </div>
          @error('tujuan_surat_id')
          <div class="invalid-feedback form-text text-danger"> {{ $message }}
          </div>
          @enderror
      </div>
  </div>
  
</div>

<div x-show="payFor == '2'">
  
  
  <div class="form-group row">
      <label class="control-label text-start text-md-end col-md-3 col-form-label"
      for="tujuan_surat_eksternal_id">Tujuan Eksternal<span class="text-danger">*</span></label>
      <div class="col-md-9">
          <div wire:ignore.self>
              <select
                x-init="$($el).select2({
                    theme: 'bootstrap-5',
                    allowClear: true,
                    placeholder: '-- Pilih Tujuan Internal --',
                    selectOnClose: true,
                    minimumInputLength: 1,
                    ajax: {
                        delay: 250,
                        url: '{{ route('search.tujuan.eksternal') }}',
                        dataType: 'json',
                    },
                });
                $($el).on('change', function() {
                    $wire.set('tujuan_surat_eksternal_id', $(this).val());
                });"
              id="tujuan_surat_eksternal_id" wire:model="tujuan_surat_eksternal_id"
              name="tujuan_surat_eksternal_id"
              class="form-select select2 @error('tujuan_surat_eksternal_id') is-invalid @enderror"
              data-placeholder="-- Pilih Tujuan Eksternal --">
              <option value="">-- Pilih Tujuan Surat --</option>
              @foreach ($instansi_list as $item)
              <option
              value="{{ $item->id }}:{{ $item->token }}">
              {{ $item->kode }} - {{ $item->nama }} (
              {{ $item->alamat }} )</option>
              @endforeach
          </select>
      </div>
      @error('tujuan_surat_eksternal_id')
      <div class="invalid-feedback form-text text-danger"> {{ $message }}
      </div>
      @enderror
  </div>
</div>



</div>

</div>




<div class="form-group row">
  <label class="control-label text-start text-md-end col-md-3 col-form-label"
  for="file_lampiran">Lampiran <span wire:loading wire:target="file_lampiran"
  class="spinner-border spinner-border-sm align-middle ms-2"></span></label>
  <div class="col-md-9">
      <input multiple type="file" id="file_lampiran" wire:model="file_lampiran"
      name="file_lampiran"
      class="form-control @error('file_lampiran') is-invalid @enderror">
      <small class="form-text">Format file *.PDF atau *.JPG, ukuran maks. 10
          MB</small>
          @error('file_lampiran')
          <div class="invalid-feedback form-text text-danger"> {{ $message }}
          </div>
          @enderror
          
      </div>
  </div>
  
  
</div>
<!--end: Card Body-->

<div class="card-footer">
  
  <div class="row">
      @if ($mode == 'create')
      <div class="col-sm-6">
          <button wire:click.prevent="toggle" type="button"
          class="btn btn-secondary w-100 mailbox-trigger-close"><i
          class="fa fa-times"></i> Batal</button>
      </div>
      <div class="col-sm-6">
          <button wire:offline.attr="disabled"
          wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
          @if ($mode == 'create') wire:click.prevent="store" @else wire:click.prevent="update" @endif
          type="button" class="btn btn-success w-100 mailbox-trigger-close"><i
          class="fa fa-save"></i> Simpan <span wire:loading
          @if ($mode == 'create') wire:target="store" @else wire:target="update" @endif
          class="spinner-border spinner-border-sm align-middle ms-2"></span></button>
      </div>
      @else
      <div class="col-sm-3">
          <button wire:offline.attr="disabled"
          wire:loading.class.remove="btn-danger" wire:loading.attr="disabled"
          wire:click="deleteConfirm({{ $surat_masuk_id }})" type="button"
          class="btn btn-danger w-100 mailbox-trigger-close"><i
          class="fa fa-times"></i> Hapus</button>
      </div>
      <div class="col-sm-3">
          <button wire:click.prevent="toggle" type="button"
          class="btn btn-secondary w-100 mailbox-trigger-close"><i
          class="fa fa-times"></i> Batal</button>
      </div>
      <div class="col-sm-6">
          <button wire:offline.attr="disabled"
          wire:loading.class.remove="btn-success" wire:loading.attr="disabled"
          @if ($mode == 'create') wire:click.prevent="store" @else wire:click.prevent="update" @endif
          type="button" class="btn btn-success w-100 mailbox-trigger-close"><i
          class="fa fa-save"></i> Simpan <span wire:loading
          @if ($mode == 'create') wire:target="store" @else wire:target="update" @endif
          class="spinner-border spinner-border-sm align-middle ms-2"></span></button>
      </div>
      @endif
      
  </div>
  
</div>

</form>
</div>
</div>
</div>

@endif

@endif


@livewire('main.surat-keluar.timeline-modal', ['id' => $surat_masuk_token])

@livewire('main.surat-masuk.lampiran-modal', ['id' => $surat_masuk_id])


</div>
</div>

@push('js')
<script>
  $('#is_type').on('change', function() {
      alert($('#is_type').val());
      // @this.set('no_surat', $('#no_surat').val(), true);
  });

</script>
@endpush
