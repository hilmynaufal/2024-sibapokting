<div>
    <div wire:ignore.self class="modal fade" id="modal-approval-surat" tabindex="-1" aria-labelledby="modal-approval-suratLabel" aria-hidden="true" x-on:click="on = false">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <form>
          <div class="modal-header">
            <h5 class="modal-title">Approval Surat Keluar</h5>
            <a href="#" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="approval_status">Status</label>
              <div class="col-md-9" wire:ignore>
                <select required="true" data-pharaonic="select2" id="approval_status" name="approval_status" class="form-select select2 @error('approval_status') is-invalid @enderror" data-placeholder="-- Pilih Instruksi Disposisi --">
                  <option value="0">-- Pilih Status --</option>
                  <option value="1">Approve</option>
                  <option value="2">Reject</option>
                </select>
                @error('approval_status')
                <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label text-start text-md-end col-md-3 col-form-label" for="approval_catatan">Catatan</label>
              <div class="col-md-9">
                <textarea required="true" rows="3" id="approval_catatan" wire:model="approval_catatan" name="approval_catatan" class="form-control @error('approval_catatan') is-invalid @enderror" placeholder="Ketikkan uraian catatan disposisi"></textarea>
                @error('approval_catatan')
                <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            <button wire:offline.attr="disabled" wire:loading.class.remove="btn-success" wire:loading.attr="disabled"
            wire:click.prevent="disposisiInsert" type="button" class="btn btn-success"><i class="fa fa-save"></i> Simpan <span wire:loading  wire:target="disposisiInsert" class="spinner-border spinner-border-sm align-middle ms-2"></span></button>
                         
  
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
  
  @push('js')
  <script>
          $('#approval_status').on('change', function() {
              @this.set('approval_status',$('#approval_status').val(),true);
          });
  
        document.addEventListener('livewire:initialized',()=>{
          @this.on('refresh-products',(event)=>{
            var myModalEl=document.querySelector('#modal-approval-surat')
            var modal=bootstrap.Modal.getOrCreateInstance(myModalEl)
            
            setTimeout(() => {
              modal.hide();
              @this.dispatch('reset-modal');
            }, 5000);
          })
        })

        window.addEventListener('close-modal', event => {
              $('#modal-approval-surat').modal('hide');
          })
  </script>
  @endpush
  
  