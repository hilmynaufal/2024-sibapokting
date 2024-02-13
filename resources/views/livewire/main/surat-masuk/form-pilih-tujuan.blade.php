<div>
    <span class="text-gray-700">{{ __('Select Users') }}</span>
    <div>
        <div id="users-select" wire:ignore></div>
    </div>

@push('js')
<script>
    let myOptions = [
        @foreach($struktural_list as $item)
            { label: "{{ $item->jabatan_kode }} - {{ $item->jabatan_nama }} ( {{ $item->pegawai_nama }}", value: "{{ $item->pegawai_id }}" },
        @endforeach
        ];
        VirtualSelect.init({
            ele: '#users-select',
            options: myOptions,
            multiple: false,
            search: true,
            placeholder: "{{__('Pilih Tujuan Surat')}}",
            noOptionsText: "{{__('Tidak Ditemukan')}}",
        });
     
        let selectedUsers = document.querySelector('#users-select')
        selectedUsers.addEventListener('change', () => {
            let data = selectedUsers.value
            @this.set('selectedUsers', data)
        })
    </script>
@endpush
</div>
