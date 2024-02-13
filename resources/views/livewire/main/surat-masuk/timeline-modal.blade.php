<div>
    <div wire:ignore.self class="modal fade" id="modal-tracking-surat" tabindex="-1" aria-labelledby="modal-tracking-suratLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
              <form>
              <div class="modal-header">
                <h5 class="modal-title">Tracking Surat Masuk</h5>
                <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
              </div>
              <div class="modal-body">
                <h5>No. Surat : <b>{{ $no_surat }}</b> - <b>{{ TglIndoHari($tgl_surat) }}</b></h5>
                <h5>Pengirim : <b>{{ $pengirim_surat }}</b></h5>


                <div class="timeline-centered">
                  @foreach (getVerifikasi($tokenId,1,1) as $index => $item)
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
                              <div class="timeline-label bg-white">
                                <h2><a href="#" title="{{$item->deskripsi}}">
                                  @if ($index!=0)
                                  {!!$item->is_direct == 0 ? "<span class='label label-info'>CC</span>" : "<span class='label label-primary'>Direct</span>"!!} : 
                                  @endif
                                  <b>{{$item->jabatan_penerima_posisi}}</b> - {{$item->jabatan_penerima_nama}}</a></h2>
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

                                    @if ($item->is_disposisi==1)
                                    <HR>
                                    
                                      <div>
                                     
                                        <?php
                                        $data = getVerifikasi($tokenId, 3, 3)->toArray();
                                        $parentID = getVerifikasi($tokenId, 5, 5);
                                        echo buatTreeView($parentID, $data, $parentID);
                                        ?>

                                  </div>  

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
              </div>
    </div>
    </div>

    @push('css')
    <style>
      ul {
        margin-left: 20px;
      }
  
      .wtree li {
        list-style-type: none;
        margin: 10px 0 10px 10px;
        position: relative;
      }
      .wtree li:before {
        content: "";
        position: absolute;
        top: -10px;
        left: -20px;
        border-left: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        width: 20px;
        height: 15px;
      }
      .wtree li:after {
        position: absolute;
        content: "";
        top: 5px;
        left: -20px;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        width: 20px;
        height: 100%;
      }
      .wtree li:last-child:after {
        display: none;
      }
      .wtree li span {
        display: block;
        border: 1px solid #ddd;
        padding: 10px;
        color: #888;
        text-decoration: none;
      }
  
      .wtree li span:hover, .wtree li span:focus {
        background: #eee;
        color: #000;
        border: 1px solid #aaa;
      }
      .wtree li span:hover + ul li span, .wtree li span:focus + ul li span {
        background: #eee;
        color: #000;
        border: 1px solid #aaa;
      }
      .wtree li span:hover + ul li:after, .wtree li span:hover + ul li:before, .wtree li span:focus + ul li:after, .wtree li span:focus + ul li:before {
        border-color: #aaa;
      }
    </style>
    @endpush
</div>
