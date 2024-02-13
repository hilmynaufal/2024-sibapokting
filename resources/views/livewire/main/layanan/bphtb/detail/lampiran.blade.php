<div>

    @foreach ($listPersyaratanVerifikasi as $item)

    <div class="form-group row">
        <div class="col-md-9">
            <span class="fs-5">{{ $item->nama_persyaratan }}</span><BR>
            <span class="text-muted">{{ $item->keterangan }}</span>
        </div>
        <div class="col-md-3">
            <div class="d-grid gap-2">
            @if ($item->file_dokumen==NULL)
            <a class="btn btn-light-danger mb-3 float-end disabled btn-block">Belum Upload</a>  
            @else
            <a class="btn btn-success mb-3 float-end btn-block" href="{{ asset($item->file_dokumen) }} ">Download </a>  
            @endif
            </div>
        </div>
    </div>
            
    @endforeach
    
    <HR>
    
    @foreach ($listPersyaratanValidasi as $item)

    <div class="form-group row">
        <div class="col-md-9">
            <span class="fs-5">{{ $item->nama_persyaratan }}</span><BR>
            <span class="text-muted">{{ $item->keterangan }}</span>
        </div>

        <div class="col-md-3">
            <div class="d-grid gap-2">
                @if ($item->file_dokumen==NULL)
                <a class="btn btn-light-danger mb-3 float-end disabled btn-block">Belum Upload</a>  
                @else
                <a class="btn btn-success mb-3 float-end btn-block" href="{{ asset($item->file_dokumen) }} ">Download </a>  
                @endif
                </div>
        </div>
    </div>

    @endforeach

</div>
