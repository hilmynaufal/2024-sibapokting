<div>
    <div>
        <div wire:ignore.self class="modal fade" id="modal-lampiran" tabindex="-1" aria-labelledby="modal-lampiranLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <form>
                  <div class="modal-header">
                    <h5 class="modal-title">{{ $file_lampiran }}</h5>
                    <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                  </div>
                  <div class="modal-body">

                    <iframe src="{{ $file_lampiran_url }}" frameborder="0" style="overflow:hidden;height:800px;width:100%" height="800px" width="100%"></iframe>

                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
