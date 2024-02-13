<div>

    @foreach (getLampiran($surat_masuk_id) as $index => $item)
      <div class="card shadow-none border-primary">
        <div class="card-body p-10 text-primary">
          {{-- <a href="{{ url('main/lampiran/preview/'.$surat_masuk_id.'/'.Crypt::encrypt($item->id_lampiran)) }}" target="_blank"> --}}
            <a type="button" @click="$dispatch('view-lampiran',{primaryId:'{{$item->file_lampiran_url}}'})" data-bs-toggle="modal" data-bs-target="#modal-lampiran">
            <i class="fa fa-paperclip"></i>&nbsp; {{$item->file_lampiran}}
          </a>

          @if ($item->create_id==Auth::user()->id)
          <a type="button" wire:click="deleteConfirmLampiran({{ $item->id_lampiran }})" class="btn btn-danger float-end float-right">
            <i class="fa fa-trash"></i>
          </a>
          @endif

        </div>
      </div>
      @endforeach
      

</div>
