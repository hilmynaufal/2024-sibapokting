<div>
    <div class="timeline-centered">
      @foreach ($disposisi_laporan as $index => $item)
          <article class="timeline-entry">
              <div class="timeline-entry-inner">
                @if ($item->is_status==0)
                  <div class="timeline-icon bg-warning">
                    @elseif ($item->is_status==1)
                    <div class="timeline-icon bg-info">
                      @elseif ($item->is_status==2)
                      <div class="timeline-icon bg-success">
                    @endif
                      <i class="fa fa-file"></i>
                  </div>
                  <div class="timeline-label">
                      <h2><a href="#">{{$item->jabatan_nama}} - {{$item->jabatan_posisi}}</a> 
                        <BR>
                        <span>{{$item->deskripsi}}</span>                            
                      </h2>
                      <p>{{ TglTimeIndo($item->created_at) }} - {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                             
                        @if ($item->is_expire==0)
                        <span class="label label-danger float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->expired_at) }}">Laporan Terlambat</span>     
                        @endif
                                  
                        @if ($item->is_status==0)
                        <span class="label label-warning float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Belum Lihat</span>
                                    
                        @elseif ($item->is_status==1)
                        <span class="label label-info float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Sudah Dilihat</span>
                                    
                        @elseif ($item->is_status==2)
                        <span class="label label-success float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->read_at) }}">Sudah Dibaca</span>
                                    
                        @endif
                      </p>

            
                      @foreach (getLampiranLaporanDisposisi($item->id) as $index => $item)
                      <div class="card shadow-none border-primary mt-3">
                        <div class="card-body text-primary">
                          <a type="button" @click="$dispatch('view-lampiran-laporan',{primaryId:'{{$item->file_lampiran_url}}'})" data-bs-toggle="modal" data-bs-target="#modal-lampiran-laporan">
                            <i class="fa fa-paperclip"></i>&nbsp; {{$item->file_lampiran}}
                          </a>
                        </div>
                      </div>
                      @endforeach
            
                      
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