<div>
    @section('title', 'Laporan - Surat Masuk')

    <form wire:submit.prevent="store" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-2">
            <input wire:model.live="tgl_awal" id="tgl_awal" type="date" class="form-control" placeholder="Pilih Tanggal Awal">
        </div>
        <div class="col-sm-2">
            <input wire:model.live="tgl_akhir" id="tgl_akhir" type="date" class="form-control" placeholder="Pilih Tanggal Akhir">
        </div>
        <div class="col-sm-2">
            <input wire:model.live="no_surat" type="text" class="form-control" placeholder="Nomor Surat">
        </div>
        <div class="col-sm-2">
                <div wire:ignore>
                <select x-init="$($el).select2({
                    placeholder: '-- Pilih Tujuan Surat --'
                });
                $($el).on('change', function() {
                    $wire.set('tujuan', $($el).val())
                })" id="tujuan" wire:model="tujuan"
                name="tujuan"
                class="form-select select2 @error('tujuan') is-invalid @enderror"
                data-placeholder="-- Pilih Tujuan --">
                <option value="">-- Pilih Tujuan Surat --</option>
                @foreach ($struktural_list as $item)
                <option
                value="{{ $item->token }}">
                {{ $item->jabatan }}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="col-sm-1">
            <div wire:ignore>
            <select
            x-init="$($el).select2({
                placeholder: '-- Pilih Status Surat --'
            });
            $($el).on('change', function() {
                $wire.set('status', $($el).val())
            })"
            wire:model.live="status" class="form-select select2" placeholder="Pilih Status">
                <option value="">-- Status --</option>
                <option value="1">Selesai</option>
                <option value="0">Belum</option>
            </select>
            </div>
        </div>

        <div class="col-sm-2">
            <input type="text" class="form-control h-45px" placeholder="Cari Perihal Surat..." wire:model.live="search" />
        </div>
        <div class="col-sm-1">
            <button type="submit" class="btn btn-success float-end">Eksport<span wire:loading wire:target="store" class="spinner-border spinner-border-sm align-middle ms-2"></span></button>
        </div>
    </div>
    </form>


    <HR>

        {{-- <livewire:components.input.date id="tgl_awal" wire:model="tgl_awal" class="form-control" /> --}}

        <span wire:loading wire:target="store" class="spinner-border spinner-border-sm align-middle ms-2"></span>

    <table class="table table-head-custom table-vertical-center table-hover table-striped" width="100%" id="kt_advance_table_widget_2"> 
        <thead class="bg-dark">
            <th><b>No.</b></th>
            <th><b>No. Surat</b></th>
            <th><b>No. Arsip</b></th>
            <th><b>Tanggal Surat</b></th>
            <th><b>Tanggal Masuk</b></th>
            <th><b>Pengirim</b></th>
            <th><b>Perihal</b></th>
            <th><b>Tujuan</b></th>
            <th><b>Status Laporan</b></th>
        </thead>
        <tbody>
            @foreach ($model as $index => $item)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $item->no_surat}}</td>
                <td>{{ $item->no_arsip}}</td>
                <td>{{ $item->tgl_surat}}</td>
                <td>{{ $item->tgl_terima}}</td>
                <td>{{ $item->pengirim_surat}}</td>
                <td>{{ $item->perihal_surat}}</td>
                <td>{{ $item->tujuan->jabatan}}</td>
                <td>{{ $item->is_complete == 1 ? "Selesai" : "Belum" }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
    <div class="col-sm-12 col-md-10">
                  
        <select wire:model.live="perpage" class="form-control form-sm" style="width: 75px;">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
                
        Menampilkan {{ $model->firstItem() }} - {{ $model->lastItem() }} dari {{ $model->total() }}
        entri
                
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="float-right">
            {{ $model->links() }}
        </div>
    </div>
    </div>

    @push('js')
    <script>
    //         flatpickr('#tgl_awal', {
    //             dateFormat: 'Y-m-d',
    //             allowInput: true,
    //             onChange: function(selectedDates, dateStr, instance) {
    //             // Set tanggal akhir minimum
    //             flatpickr('#tgl_akhir', {
    //             minDate: dateStr,
    //             dateFormat: 'Y-m-d',
    //             allowInput: true
    //             });
    //             }
    //             });

    // flatpickr('#tgl_akhir', {
                // dateFormat: 'Y-m-d',
                // allowInput: true
    // });
    </script>
    @endpush

</div>