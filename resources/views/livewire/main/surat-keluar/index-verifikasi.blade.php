<div>
  @section('title', 'Surat Keluar')
  
  <div class="row">
      
      <div class="col-lg-{{ $isOpen ? '6' : '12' }}">
          <div>
              <!--begin::Header-->
              <div class="card-header">
                  <div class="row">
                      <div class="col-sm-12 col-md-6">
                    
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
  
              <!--begin::Table-->
              <div class="inbox-center table-responsive" wire:poll.15s>
                  <table class="table table-hover no-wrap mailbox-table">
                      <tbody>
                          @foreach ($model as $index => $item)
                          <tr class="mailbox-item {{ $item->verifikasi_is_read==0 ? "unread" : "" }}" wire:click="viewVerifikasi({{ $item->verifikasi_id }})">
                              <td class="hidden-xs-down">
                                <span class="text-muted f-s-12 d-block m-b-4">{{ $item->no_surat }}</span>
                                {{ $item->jabatan_penerima_posisi }}
                              </td>
                              <td>
                                {{-- <span class="badge bg-info m-b-8">{{ $item->jenis->nama }}</span>
                                <span class="badge bg-warning m-b-4">{{ $item->sifat->nama }}</span> --}}
                                @if ($item->verifikasi_is_approve==1)
                                <span class="badge m-t-4 bg-success"><i class="fa fa-check"></i> Disetujui</span>
                                @elseif($item->verifikasi_is_approve==2)
                                <span class="badge m-t-4 bg-danger"><i class="fa fa-times"></i> Tidak Disetujui</span>
                                @else
                                <span class="badge m-t-4 bg-secondary"><i class="fa fa-clock"></i> Belum di Approve</span>
                                @endif
                              </td>
                              <td class="max-texts">
                                  {{ $item->perihal_surat}}
                                <div class="m-t-4">
                                  <a @click="$dispatch('view-lampiran',{primaryId:'{{$item->file_lampiran_url}}'})" data-bs-toggle="modal" data-bs-target="#modal-lampiran" class="btn btn-sm btn-outline-primary text-truncate d-inline-block" style="max-width: 160px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{ $item->file_lampiran }}"><i class="fa fa-paperclip"></i> {{ $item->file_lampiran }}</a>
                                  {{-- <a href="{{ Storage::disk('public')->url($item->file_lampiran_url) }}" target="_blank" class="btn btn-sm btn-outline-primary text-truncate d-inline-block" style="max-width: 160px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{ $item->file_lampiran }}"><i class="fa fa-paperclip"></i> {{ $item->file_lampiran }}</a> --}}
                                  {{-- <a href="{{ url('main/lampiran/preview/'.Crypt::encrypt($item->file_lampiran_url)) }}" target="_blank" class="btn btn-sm btn-outline-primary text-truncate d-inline-block" style="max-width: 160px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{ $item->file_lampiran }}"><i class="fa fa-paperclip"></i> {{ $item->file_lampiran }}</a> --}}
                                </div>
                              </td>
                              <td class="text-end">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                            </tr>
                          @endforeach
                      </tbody>
                  </table>
                  
                  
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
                  {{-- <a type="button" wire:click="edit({{ $primaryId }})" class="mailbox-trigger-edit" data-bs-toggle="tooltip" data-has-access="operator" aria-label="Ubah Data" data-bs-original-title="Ubah Data"><i class="fa fa-edit f-s-18 text-warning m-e-12"></i></a> --}}
                  {{-- <a type="button" wire:click="viewTracking({{ $primaryId }})" data-bs-toggle="tooltip" aria-label="Cetak Surat" data-bs-original-title="Cetak Surat"><i class="fa fa-print f-s-18 text-success"></i></a> --}}
                  {{-- <a type="button" wire:click="viewTracking({{ $primaryId }})" data-bs-toggle="tooltip" aria-label="Lihat Timeline Surat" data-bs-original-title="Lihat Timeline Surat"><i class="fa fa-th-list f-s-18 text-primary"></i></a> --}}
                  <a type="button" @click="$dispatch('view-timeline',{primaryId:'{{$surat_masuk_token}}'})" data-bs-toggle="modal" data-bs-target="#modal-tracking-surat" data-has-access="direktur"><i class="fa fa-th-list f-s-18 text-primary"></i></a>
  
                </div>
              </div>
              <br>
        
       
              @livewire('main.surat-keluar.detail-surat',['id'=>$surat_masuk_token])

              
            </div>
            <div class="form-action m-t-24">
              <div class="row">
                <div class="col-sm-6">
                  <button type="button" wire:click.prevent="toggle" class="btn btn-secondary w-100 mailbox-trigger-close"><i class="fa fa-times"></i> Tutup</button>
                </div>
                <div class="col-sm-6">
                  @livewire('main.surat-keluar.form-verifikasi',['id'=>$surat_masuk_id]) 
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
  
  
              @livewire('main.surat-keluar.timeline',['id'=>$surat_masuk_token])
        
  
            </div>
  
            <div class="form-action m-t-24">
              <div class="row">
                <div class="col-sm-6">
                  <button type="button" wire:click.prevent="toggle" class="btn btn-secondary w-100 mailbox-trigger-close"><i class="fa fa-times"></i> Tutup</button>
                </div>
                <div class="col-sm-6">
                  
                  @livewire('main.surat-keluar.form-verifikasi',['id'=>$surat_masuk_id])
  
                </div>
              </div>
            </div>
          
        </div>
      </div>
    </div>
  
    @endif
      
    @endif
  
    @livewire('main.surat-keluar.form-verifikasi-surat',['id'=>$primaryId])
  
    @livewire('main.surat-keluar.timeline-modal',['id'=>$surat_masuk_token])

    @livewire('main.surat-masuk.lampiran-modal', ['id' => $surat_masuk_id])
  
  
  </div>
  
  
  
  </div>
  
  
  