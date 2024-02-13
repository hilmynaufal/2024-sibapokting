<div>
  <div class="timeline-centered">
    @foreach (getVerifikasi($surat_masuk_id,1,0) as $index => $item)
        <article class="timeline-entry">
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
                    <p>{{ TglTimeIndo($item->created_at) }} - {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                    
                                    
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
                      @if ($item->is_disposisi==1)
                      <span class="label label-danger float-end">Disposisi</span>
                      @endif

                    </p>
                    @if ($index==0)
                    @foreach (getLampiran($surat_masuk_id) as $index => $item)
                    <div class="card shadow-none border-primary mt-3">
                      <div class="card-body text-primary">
                        {{-- <a href="{{ url('main/lampiran/preview/'.$surat_masuk_id.'/'.Crypt::encrypt($item->id_lampiran)) }}" target="_blank"> --}}
                          <a type="button" @click="$dispatch('view-lampiran',{primaryId:'{{$item->file_lampiran_url}}'})" data-bs-toggle="modal" data-bs-target="#modal-lampiran">
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
          
        @foreach (getVerifikasi($surat_masuk_id,3,0) as $index => $item)
        <article class="timeline-entry">
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
                    <h2>{!!$item->is_direct == 0 ? "<span class='label label-info'>CC</span>" : "<span class='label label-primary'>Direct</span>"!!} : <a title="{{$item->deskripsi}}" href="#">{{$item->jabatan_penerima_nama}} - {{$item->jabatan_penerima_posisi}}</a>                            
                    </h2>
                    <p>{{ TglTimeIndo($item->created_at) }} - {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                      

                      @if ($item->is_status==0)
                      <span class="label label-warning float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Belum Lihat</span>
                      @elseif ($item->is_status==1)
                      <span class="label label-info float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Sudah Dilihat</span>
                      @elseif ($item->is_status==2)
                      <span class="label label-success float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->read_at) }}">Sudah Dibaca</span>        
                      @endif

                      @if ($item->is_disposisi==1)
                      <span class="label label-danger float-end">Disposisi</span>
                      @endif

                      @if ($item->is_response==1)
                      <span class="label label-inverse float-end">Laporan</span>
                      @endif

                    </p>
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