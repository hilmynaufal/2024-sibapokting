<div>
    
    @if (getJabatan()=="2d0c7222-c8ce-4b7d-9c5f-af5ee674ac6a")
      <button @click="$dispatch('disposisi-review',{primaryId:{{$primaryId}}})" type="button" class="btn btn-primary w-100 mb-2"><i class="fa fa-check"></i> Approve Surat</button>
          @if ($tujuan_surat_token=="2d0c7222-c8ce-4b7d-9c5f-af5ee674ac6a")
          <button @click="$dispatch('disposisi-created',{primaryId:{{$primaryId}}})" type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modal-kirim-disposisi" data-has-access="direktur"><i class="fa fa-paper-plane"></i> Kirim Disposisi</button>
          @endif
      @else
       <button @click="$dispatch('disposisi-created',{primaryId:{{$primaryId}}})" type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modal-kirim-disposisi" data-has-access="direktur"><i class="fa fa-paper-plane"></i> Kirim Disposisi</button>
      @endif

</div>


