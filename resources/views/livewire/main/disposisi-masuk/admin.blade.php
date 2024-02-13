   <!--begin::Table-->
   <div class="inbox-center table-responsive" wire:poll.15s>
    <table class="table table-hover no-wrap mailbox-table">
        <tbody>
            @foreach ($model as $index => $item)
            <tr class="mailbox-item {{ $item->is_read==0 ? "unread" : "" }}" wire:click="viewVerifikasi({{ $item->id }})">
                <td class="hidden-xs-down">
                  <span class="text-muted f-s-12 d-block m-b-4">{{ $item->disposisiUtama->disposisi_nomor}}</span>
                  <i class="fa fa-share"></i> {{ $item->jabatan_pengirim_nama}} <br> <span class="text-muted f-s-12 d-block m-b-4">{{ $item->jabatan_pengirim_posisi}}</span>
                    @if ($item->is_status==0)
                    <span class="label label-warning float-start" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Belum Lihat</span>
                    @elseif ($item->is_status==1)
                    <span class="label label-info float-start" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Sudah Dilihat</span>
                    @elseif ($item->is_status==2)
                    <span class="label label-success float-start" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->read_at) }}">Sudah Dibaca</span>
                    @endif
                </td>                               
                <td class="max-texts">
                    {{ $item->disposisiUtama->disposisi_catatan}}
                    <div class="m-t-4">
                      <a href="{{route('main.disposisimasuk.cetak', ['id' => $item->disposisiUtama->id])}}"  target="_blank" class="btn btn-sm btn-outline-primary text-truncate d-inline-block" style="max-width: 160px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Lembar Disposisi {{ $item->disposisiUtama->disposisi_nomor }}"><i class="fa fa-paperclip"></i>Lembar Disposisi {{ $item->disposisiUtama->disposisi_nomor }}</a>
                    </div>
                </td>
                <td class="text-end">
                  {{ \Carbon\Carbon::parse($item->create_at)->diffForHumans() }} <BR>
                  <span class="text-muted">Tenggat : {{ tglIndo($item->disposisiUtama->disposisi_batas_waktu) }} <BR> {{ \Carbon\Carbon::parse($item->disposisiUtama->disposisi_batas_waktu)->diffForHumans() }}</span>
                                    
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>