  {{-- <h4>Surat Masuk</h4> --}}
  <div class="list list-row block">

    @if (count(getNotifikasiTerbaru(1)) > 0)
    @foreach (getNotifikasiTerbaru(1) as $index => $item)
        <div class="list-item" data-id="{{$index}}">
            <div><a href="#" data-abc="true"><span class="w-48 avatar gd-primary"></span></a></div>
            <div class="flex">
                <a href="#" class="item-author text-color" data-abc="true"> {{ $item->pengirim_surat }}</a>
                <div class="item-except text-muted text-sm h-1x"> {{ $item->no_surat }}</div>
                <div class="item-except text-muted text-sm h-1x"> {{ $item->perihal_surat }}</div>
            </div>
            <div class="no-wrap">
                <div class="item-date text-muted text-sm d-none d-md-block">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                @if ($item->verifikasi_is_status==0)
                <span class="label label-warning float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->verifikasi_view_at) }}">Belum Lihat</span>
                @elseif ($item->verifikasi_is_status==1)
                <span class="label label-info float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->verifikasi_view_at) }}">Sudah Dilihat</span>
                @elseif ($item->verifikasi_is_status==2)
                <span class="label label-success float-end" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->verifikasi_read_at) }}">Sudah Dibaca</span>
                @endif
            </div>
        </div>
    @endforeach
@else
<div class="list-item">
    <div class="text-muted text-center">Belum ada surat masuk terbaru.</div>
</div>
@endif
        
</div>