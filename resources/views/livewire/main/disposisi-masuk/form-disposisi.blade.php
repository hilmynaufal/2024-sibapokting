<div>
  <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form>
        <div class="modal-header">
          <h5 class="modal-title">Kirim Disposisi</h5>
          <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          
          <div class="form-group row">
            <label class="control-label text-start text-md-end col-md-3 col-form-label" for="disposisi_tujuan">Tujuan Disposisi</label>
            <div class="col-md-9"  wire:ignore>

              <select required="true" data-pharaonic="select2" id="disposisi_tujuan" name="disposisi_tujuan" wire:model="disposisi_tujuan" class="form-select select2 select2-multiple @error('disposisi_tujuan') is-invalid @enderror" multiple="multiple" data-placeholder="-- Pilih Tujuan Disposisi --">
                 @foreach ($struktural_list as $item)
                <option value="{{ $item->pegawai_id }}:{{ $item->jabatan_id_token }}">{{ Str::upper($item->pegawai_no_induk) }} - {{ Str::upper($item->pegawai_nama) }} - {{ Str::upper($item->jabatan_nama) }}</option>
                @endforeach
              </select>
     
            </div>
            @error('disposisi_tujuan')
            <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
            @enderror
          </div>
          <div class="form-group row">
            <label class="control-label text-start text-md-end col-md-3 col-form-label" for="disposisi_instruksi">Instruksi Disposisi</label>
            <div class="col-md-9" wire:ignore>
              <select required="true" data-pharaonic="select2" id="disposisi_instruksi" name="disposisi_instruksi" class="form-select select2 select2-multiple @error('disposisi_instruksi') is-invalid @enderror" multiple="multiple" data-placeholder="-- Pilih Instruksi Disposisi --">
                @foreach ($jenis_disposisi_list as $item)
                <option value="{{ $item->nama }}">{{ Str::upper($item->nama) }}</option>
                @endforeach
              </select>
              @error('disposisi_instruksi')
              <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label text-start text-md-end col-md-3 col-form-label" for="disposisi_batas_waktu">Tenggat Waktu</label>
            <div class="col-md-9">
              <input required="true" type="date" id="disposisi_batas_waktu" name="disposisi_batas_waktu" wire:model="disposisi_batas_waktu" class="form-control datepicker @error('disposisi_batas_waktu') is-invalid @enderror" placeholder="Pilih tanggal akhir tenggat waktu">
              @error('disposisi_batas_waktu')
              <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label text-start text-md-end col-md-3 col-form-label" for="disposisi_catatan">Catatan</label>
            <div class="col-md-9">
              <textarea required="true" rows="3" id="disposisi_catatan" wire:model="disposisi_catatan" name="disposisi_catatan" class="form-control @error('disposisi_catatan') is-invalid @enderror" placeholder="Ketikkan uraian catatan disposisi"></textarea>
              @error('disposisi_catatan')
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
        $('#no_arsip_surat').on('change', function() {
          alert($('#no_arsip_surat').val());
            @this.set('no_arsip_surat',$('#no_arsip_surat').val(),true);
        });

        $('#disposisi_tujuan').on('change', function() {
            @this.set('disposisi_tujuan',$('#disposisi_tujuan').val(),true);
        });

        $('#disposisi_instruksi').on('change', function() {
            @this.set('disposisi_instruksi',$('#disposisi_instruksi').val(),true);
        });

      document.addEventListener('livewire:initialized',()=>{
        @this.on('refresh-products',(event)=>{
          var myModalEl=document.querySelector('#exampleModal')
          var modal=bootstrap.Modal.getOrCreateInstance(myModalEl)
          
          setTimeout(() => {
            modal.hide();
            @this.dispatch('reset-modal');
          }, 5000);
        })
      })
</script>
@endpush
