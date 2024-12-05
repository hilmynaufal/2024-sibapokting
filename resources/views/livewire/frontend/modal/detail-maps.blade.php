
<div class="modal fade show" id="add" data-bs-focus="false" style="display: block; padding-left: 0px;" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi Pasar {{ $informasi->namapasar }}</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    wire:click="$dispatch('closeModal')">
                </button>
            </div>

            <div class="modal-body" style="text-align:left;">
                <div class="tab-content" style="margin-top:20px;">
                    <div class="tab-pane active" id="home">
                        <div class="page_detail">
                            <p>
                                <img alt="Foto"
                                    src="{{ Storage::disk('public')->url($informasi->gambar_utama) }}"
                                    style="float:right; height:169px; margin:10px 20px; width:300px"></p>
                            <p><strong>Sejarah Pendirian Pasar :</strong></p>
                            {!! $informasi->sejarah !!}
                            <p><strong>Alamat Pasar :</strong></p>
                            <p>{!! $informasi->alamat !!}</p>
                            <p><strong>Area Pasar :</strong></p>
                            {!! $informasi->area_pasar !!}
                            <p><strong>Jam Operasional :</strong></p>
                            {!! $informasi->jam_oprasional !!}
                            <p><strong>Luas Pasar :</strong></p>
                            {!! $informasi->luas_pasar !!}
                            <p><strong>Jumlah Kios/ Los :</strong></p>
                            {!! $informasi->jumlah_kios !!}
                            <p><strong>Jumlah Pedagang :</strong></p>
                            {!! $informasi->jumlah_pedagang !!}
                            <p><strong>Jenis barang yang diperdagangkan :</strong></p>
                            {!! $informasi->jenis_barang !!}
                            <p><strong>Fasilitas Umum :</strong></p>
                            {!! $informasi->fasilitas_umum !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$dispatch('closeModal')">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
