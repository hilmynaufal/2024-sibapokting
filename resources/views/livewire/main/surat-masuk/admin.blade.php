
<!--begin::Table-->
<div class="inbox-center table-responsive" wire:poll.15s>
    <table class="table table-hover no-wrap mailbox-table">
        <tbody>
            @foreach ($model as $index => $item)
            <tr class="mailbox-item {{ $item->verifikasi_is_read==0 ? "unread" : "" }}" wire:click="viewVerifikasi({{ $item->verifikasi_id }})">
                <td class="hidden-xs-down">
                  <span class="text-muted f-s-12 d-block m-b-4">{{ $item->no_surat}}</span>
                  {{ $item->pengirim_surat }}
                  @if ($item->is_complete==1)
                  <span class="label label-success" data-bs-toggle="tooltip" title="Sudah di Buat Laporan Tindaklanjut">Completed</span>
                  @endif
                </td>
                <td class="max-texts">
                    {{ $item->perihal_surat}} 
                  <div class="m-t-4">
                    <a @click="$dispatch('view-lampiran',{primaryId:'{{$item->file_lampiran_url}}'})" data-bs-toggle="modal" data-bs-target="#modal-lampiran" class="btn btn-sm btn-outline-primary text-truncate d-inline-block" style="max-width: 160px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{ $item->file_lampiran }}"><i class="fa fa-paperclip"></i> {{ $item->file_lampiran }}</a>
                  </div>
                </td>
                <td class="text-end">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
              </tr>
            @endforeach
        </tbody>
    </table>