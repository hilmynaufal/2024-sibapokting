<div>

    {{-- <input type="text" wire:model='id_bphtb'/> --}}
    @foreach ($listPersyaratanVerifikasi as $item)
        <div class="form-group row" id="{{ $item->nama_field }}">
            <div class="col-md-12">
                <b>{{ $item->nama_persyaratan }}</b> <?= $item->is_required==1 ? '<span class="text-danger">*</span>' : ''; ?>
                <small class="form-text text-muted">{{ $item->keterangan }}</small> 
                    <x-filepond title="{{ $item->nama_persyaratan }}" required="{{ $item->file_dokumen==NULL ? $item->is_required : 0 }}" file-document="{{ $item->file_dokumen }}" data-max-file-size="1MB" wire:model="{{ $item->nama_field }}" id="{{ $item->nama_field }}"/>   
            </div>            
        </div>
    @endforeach
    
    <HR>
    
    @foreach ($listPersyaratanValidasi as $item)
    <div class="form-group row" id="{{ $item->nama_field }}">
        <div class="col-md-12">
            <b>{{ $item->nama_persyaratan }}</b> <?= $item->is_required==1 ? '<span class="text-danger">*</span>' : ''; ?>
            <small class="form-text text-muted">{{ $item->keterangan }}</small> 
                <x-filepond title="{{ $item->nama_persyaratan }}" required="{{ $item->file_dokumen==NULL ? $item->is_required : 0 }}" file-document="{{ $item->file_dokumen }}"  data-max-file-size="1MB" wire:model="{{ $item->nama_field }}" id="{{ $item->nama_field }}"/>   
        </div>            
    </div>
    @endforeach
</div>


@push('css')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@endpush

@push('js')
<!-- include FilePond library -->
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>    
@endpush
