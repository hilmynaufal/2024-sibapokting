<div>
      <!--begin::Table-->
      <div class="inbox-center table-responsive" wire:poll.15s>
        <table class="table table-hover no-wrap mailbox-table">
            <tbody>
                @foreach ($model as $index => $item)
                <tr class="mailbox-item" wire:click="viewVerifikasi({{ $item->id }})">
                    <td class="hidden-xs-down">
                      <span class="text-muted f-s-12 d-block m-b-4">{{ $item->disposisi_nomor}}</span>

                      @if ($item->is_compelete==1)
                      <span class="label label-success" data-bs-toggle="tooltip" title="Sudah di Buat Laporan Tindaklanjut">Completed</span>
                      @endif
                 
                      @foreach (getVerifikasi($item->surat_id_token,2,2) as $indexs => $detail)
                      @if ($detail->is_direct==1)
                        <i class="fa fa-share"></i> 
                        <span data-bs-toggle="tooltip" title="{{$detail->jabatan_penerima_nama}}">{{$detail->jabatan_penerima_posisi}}</span><BR>
                        <span data-bs-toggle="tooltip" title="{{$detail->jabatan_penerima_posisi}}">{{$detail->jabatan_penerima_nama}}</span>
                                
                        @if ($detail->is_status==0)
                        <span class="badge bg-secondary" data-bs-toggle="tooltip" title="{{ TglTimeIndo($detail->view_at) }}">Belum Lihat</span>
                        @elseif ($detail->is_status==1)
                        <span class="badge bg-info" data-bs-toggle="tooltip" title="{{ TglTimeIndo($detail->view_at) }}">Sudah Dilihat</span>
                        @elseif ($detail->is_status==2)
                        <span class="badge bg-success" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->read_at) }}">Sudah Dibaca</span>
                        @endif

                        @endif
                      @endforeach 

                    </td>                               
                    <td class="max-texts">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $item->disposisi_catatan }}">{{ limitasiKarakter($item->disposisi_catatan) }}</span>
                        <div class="m-t-4">
                          <a href="{{route('main.disposisimasuk.cetak', ['id' => $item->id])}}"  target="_blank" class="btn btn-sm btn-outline-primary text-truncate d-inline-block" style="max-width: 160px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Lembar Disposisi {{ $item->disposisi_nomor }}"><i class="fa fa-paperclip"></i>Lembar Disposisi {{ $item->disposisi_nomor }}</a>
                        </div>
                    </td>
                    <td class="text-end">
                      {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }} <BR>
                      <span class="text-muted">Tenggat : {{ tglIndo($item->disposisi_batas_waktu) }} 
                        {{-- <BR> {{ \Carbon\Carbon::parse($item->disposisi_batas_waktu)->diffForHumans() }}</span> --}}
                                    
                    </td>
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
