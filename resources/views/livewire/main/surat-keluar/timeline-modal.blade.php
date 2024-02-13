<div>
    <div wire:ignore.self class="modal fade" id="modal-tracking-surat" tabindex="-1" aria-labelledby="modal-tracking-suratLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <form>
              <div class="modal-header">
                <h5 class="modal-title">Tracking Surat Keluar</h5>
                <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
              </div>
              <div class="modal-body">


                <div class="timeline-centered">
                    @foreach (getVerifikasi($tokenId,4,2) as $index => $item)
                        <article class="timeline-entry" data-toggle="tooltip" data-placement="top" title="{{$item->deskripsi}}">
                            <div class="timeline-entry-inner">
                              @if ($item->is_status==0)
                                <div class="timeline-icon bg-warning">
                                  @elseif ($item->is_status==1)
                                  <div class="timeline-icon bg-info">
                                    @elseif ($item->is_status==2)
                                    <div class="timeline-icon bg-success">
                                      @elseif ($item->is_status==3)
                                      <div class="timeline-icon bg-primary">
                                    @endif
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="timeline-label">
                                  <h2><a href="#" title="{{$item->deskripsi}}">{{$item->jabatan_penerima_nama}} - {{$item->jabatan_penerima_posisi}}</a></h2>
                                  <p>{{ $item->deskripsi }}</p>

                                  @if ($item->is_approve!=0)
                                  <b class="font-700">Catatan: {{ $item->catatan }}</b> - <b class="font-100 text-muted">{{ TglTimeIndo($item->approve_at) }} - {{ \Carbon\Carbon::parse($item->approve_at)->diffForHumans() }}</b>
                                  @endif

                                    <p>Dikirim {{ TglTimeIndo($item->created_at) }} - {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                    
                                    
                                      @if ($item->is_status==0)
                                      <span class="label label-warning float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Belum Lihat</span>
                                      @elseif ($item->is_status==1)
                                      <span class="label label-info float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Sudah Dilihat</span>
                                      @elseif ($item->is_status==2)
                                      <span class="label label-success float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->read_at) }}">Sudah Dibaca</span>
                                      @elseif ($item->is_status==3)
                                      @endif
                      
                                      @if ($item->is_approve==1)
                                      <span class="label label-primary float-end">Approve</span>
                                      @endif

                                      @if ($item->is_approve==2)
                                      <span class="label label-danger float-end">Reject</span>
                                      @endif

                                      @if ($item->is_disposisi==1)
                                      <span class="label label-danger float-end">Disposisi</span>
                                      @endif
                                      
                                    </p>
                                    @if ($index==0)
                                    @foreach (getLampiran($tokenId) as $index => $item)
                                    <div class="card shadow-none border-primary mt-3">
                                      <div class="card-body text-primary">
                                        <a type="button" @click="$dispatch('view-lampiran',{primaryId:'{{$item->file_lampiran_url}}'})" data-bs-toggle="modal" data-bs-target="#modal-lampiran">
                                        {{-- <a href="{{ url('main/lampiran/preview/'.$primaryId.'/'.Crypt::encrypt($item->id_lampiran)) }}" target="_blank"> --}}
                                          <i class="fa fa-paperclip"></i>&nbsp; {{$item->file_lampiran}}
                                        </a>
                                      </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    
                             
                                    
                                </div>
                            </div>
                        </article>
                        @endforeach
                   
                        
          
                        <article class="timeline-entry begin">
                            <div class="timeline-entry-inner">
                                <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                                    <i class="entypo-flight"></i> +
                                </div>
                            </div>
                        </article>
  
                  </div>

              </div>
              {{-- <div class="modal-footer">
                @livewire('main.surat-masuk.form-verifikasi',['id'=>$primaryId])
              </div> --}}
              </div>
    </div>
    </div>
</div>
