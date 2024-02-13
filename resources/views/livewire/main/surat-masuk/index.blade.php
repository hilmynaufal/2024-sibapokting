<div>
@section('title', 'Surat Masuk')

<div class="row">
    
    <div class="col-lg-{{ $isOpen ? '6' : '12' }}">
        <div>
            <!--begin::Header-->
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-12 col-md-6">

                        <button wire:click="create" class="btn btn-success mailbox-trigger-edit" type="button"><i class="fa fa-plus"></i> Tambah</button>
                
                  
                </div>
                <div class="col-sm-12 col-md-6">
                    <!--begin::Form-->
                    <form method="get" class="quick-search-form">
                        <div class="input-group rounded bg-light">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="svg-icon svg-icon-lg">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                            </div>
                            <input type="text" class="form-control h-45px" placeholder="Search..." wire:model.live="search" />
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

            @include('livewire.main.surat-masuk.admin')
                
                <div class="col-sm-12 col-md-6">

                  <select wire:model.live="perpage"
                        class="form-control form-sm"
                        style="width: 75px;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                  </select>

                    Menampilkan {{ $model->firstItem() }} - {{ $model->lastItem() }} dari {{$model->total() }} entri

                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="float-end">
                        {{ $model->links() }}
                    </div>
                </div>
                
            </div>
            <!--end::Table-->
        </div>
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
                <a type="button" wire:click.prevent="toggle" class="mailbox-trigger-close" data-bs-toggle="tooltip" aria-label="Tutup" data-bs-original-title="Tutup"><i class="fa fa-times f-s-18 text-muted m-e-12"></i></a>
                <a type="button" wire:click="edit({{ $primaryId }})" class="mailbox-trigger-edit" data-bs-toggle="tooltip" data-has-access="operator" aria-label="Ubah Data" data-bs-original-title="Ubah Data"><i class="fa fa-edit f-s-18 text-warning m-e-12"></i></a>
                {{-- <a type="button" wire:click="viewTracking({{ $primaryId }})" data-bs-toggle="tooltip" aria-label="Cetak Surat" data-bs-original-title="Cetak Surat"><i class="fa fa-print f-s-18 text-success"></i></a> --}}
                 {{-- <a type="button" wire:click="viewTracking({{ $primaryId }})" data-bs-toggle="tooltip" aria-label="Lihat Timeline Surat" data-bs-original-title="Lihat Timeline Surat"><i class="fa fa-th-list f-s-18 text-primary"></i></a> --}}
                 <a type="button" @click="$dispatch('view-timeline',{primaryId:'{{$surat_masuk_token}}'})" data-bs-toggle="modal" data-bs-target="#modal-tracking-surat" data-has-access="direktur"><i class="fa fa-th-list f-s-18 text-primary"></i></a>

              </div>
            </div>
            <br>
           
            @include('livewire.main.surat-masuk.detail-surat',['id'=>$surat_masuk_id])

          </div>
          <div class="form-action m-t-24">
            <div class="row">
              <div class="col-sm-6">
                <button type="button" wire:click.prevent="toggle" class="btn btn-secondary w-100 mailbox-trigger-close"><i class="fa fa-times"></i> Tutup</button>
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
                <a type="button" wire:click="view({{ $primaryId }})" class="mailbox-trigger-edit" data-bs-toggle="tooltip" aria-label="Kembali" data-bs-original-title="Kembali"><i class="fa fa-arrow-left f-s-18 text-primary m-e-12"></i></a>
              </div>
            </div>
            <br>

            @livewire('main.surat-masuk.timeline',['id'=>$surat_masuk_id])
      

          </div>
          <div class="form-action m-t-24">
            <div class="row">
              <div class="col-sm-6">
                <button type="button" wire:click.prevent="toggle" class="btn btn-secondary w-100 mailbox-trigger-close"><i class="fa fa-times"></i> Tutup</button>
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


<div class="mailbox-form col-sm-6">
    <div class="card shadow-none border-none">
        <!--begin::Header-->
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bolder text-dark">@yield('title') <div wire:dirty class="text text-secondary">Draft</div> 
                <span wire:loading class="spinner-border spinner-border-sm align-middle ms-2"></span></h3>
            </div>
            <!--end::Header-->
            <div class="card-body">
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

                        <div class="form-group row" style="display: none">
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
        </div>
    </div>

    @endif
    
    @endif

    @livewire('main.surat-masuk.timeline-modal',['id'=>$surat_masuk_id])

    @livewire('main.surat-masuk.lampiran-modal',['id'=>$surat_masuk_id])

</div>
</div>

@push('js')
<script>
        $('#no_arsip_surat').on('change', function() {
          alert($('#no_arsip_surat').val());
            @this.set('no_arsip_surat',$('#no_arsip_surat').val(),true);
        });
</script>
@endpush
