<div>
  @section('title', 'Disposisi Keluar')
      
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
      
              @include('livewire.main.disposisi-keluar.admin')

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
                  <a type="button" href="{{route('main.disposisimasuk.cetak', ['id' => $disposisiDetailId])}}" target="_blank" data-bs-toggle="tooltip" aria-label="Cetak Disposisi" data-bs-original-title="Cetak Disposisi"><i class="fa fa-print f-s-18 text-success m-e-12"></i></a>
                  {{-- <a type="button" wire:click="viewTracking({{ $primaryId }})" data-bs-toggle="tooltip" aria-label="Lihat Timeline Surat" data-bs-original-title="Lihat Timeline Surat"><i class="fa fa-th-list f-s-18 text-primary"></i></a> --}}
                  <a type="button" @click="$dispatch('view-timeline',{primaryId:'{{$surat_masuk_token}}'})" data-bs-toggle="modal" data-bs-target="#modal-tracking-surat" data-has-access="direktur"><i class="fa fa-th-list f-s-18 text-primary"></i></a>
                </div>
              </div>
              <br>
  
              @include('livewire.main.disposisi-keluar.detail')

              @include('livewire.main.disposisi-keluar.detail-surat',['id'=>$disposisiDetailId])
  
              @if ($disposisiDetailDirect==1 && Auth::user()->role_id!=6)
                    
              <HR>
  
              @livewire('main.disposisi-masuk.form-verifikasi',['id'=>$surat_masuk_id])
  
              @endif
  
              @livewire('main.disposisi-masuk.form',['id'=>$surat_masuk_id])
                  
              <HR>
                      
                @livewire('main.disposisi-keluar.index-laporan',['id'=>$surat_masuk_token])
  
   
  
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
  
              {{-- @livewire('main.surat-masuk.timeline',['id'=>$surat_masuk_id]) --}}
      
            </div>
  
              
        </div>
      </div>
    </div>
      
    @endif
          
    @endif
      
      
  </div>
  
  @livewire('main.disposisi-masuk.form-disposisi',['id'=>$surat_masuk_id])
  
  @livewire('main.surat-masuk.timeline-modal',['id'=>$surat_masuk_id])
     
  @livewire('main.surat-masuk.lampiran-modal',['id'=>$surat_masuk_id])
      
  </div>
  
      
  @push('css')
  <style>
    :root {
      --avatar-size: 2rem;
    }

    .circle {
      background-color: #ccc;
      border-radius: 50%;
      height: var(--avatar-size);
      text-align: center;
      width: var(--avatar-size);
    }

    .initials {
      font-size: calc(var(--avatar-size) / 2);
      line-height: 1;
      position: relative;
      top: calc(var(--avatar-size) / 4); 
    }
  </style>
  @endpush