<div>
{{-- Informasi Disposisi --}}
<div class="form-group row">
  <label class="control-label text-start text-md-end col-md-3 col-form-label">Tanggal Disposisi</label>
  <div class="col-md-9">
    {{ $disposisi_at }} - 
    {{ \Carbon\Carbon::parse($disposisi_at)->diffForHumans() }}
  </div>
</div>
<div class="form-group row">
  <label class="control-label text-start text-md-end col-md-3 col-form-label">Tanggal Tenggat</label>
  <div class="col-md-9">
    {{ $disposisi_batas_waktu }} - 
    {{ \Carbon\Carbon::parse($disposisi_batas_waktu)->diffForHumans() }}
  </div>
</div>
<div class="form-group row">
  <label class="control-label text-start text-md-end col-md-3 col-form-label">Instruksi Disposisi</label>
  <div class="col-md-9">
    <ul class="p-s-10">
        <?php
        $instruksi = explode(",",$disposisi_instruksi);
        foreach ($instruksi as $key => $value) {
           echo "<li>".$value."</li>";
        }
        ?>
    </ul>
  </div>
</div>
<div class="form-group row">
  <label class="control-label text-start text-md-end col-md-3 col-form-label">Catatan</label>
  <div class="col-md-9">
    <p>{{$disposisi_catatan}}</p>
  </div>
</div>
<div class="form-group row">
  <label class="control-label text-start text-md-end col-md-3 col-form-label">Penerima Disposisi</label>
  <div class="col-md-9">
    <ul class="p-s-10">
      @foreach (getVerifikasi($surat_masuk_token,2,$disposisiDetailTipe) as $index => $item)
      <li>
        {{$item->jabatan_penerima_nama}} - {{$item->jabatan_penerima_posisi}}
        @if ($item->is_status==0)
        <span class="label label-warning" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Belum Lihat</span>
        @elseif ($item->is_status==1)
        <span class="label label-info" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->view_at) }}">Sudah Dilihat</span>
        @elseif ($item->is_status==2)
        <span class="label label-success" data-bs-toggle="tooltip" title="{{ TglTimeIndo($item->read_at) }}">Sudah Dibaca</span>
        @endif
      </li>
      </article>
      @endforeach  
    </ul>
  </div>
</div>                
</div>