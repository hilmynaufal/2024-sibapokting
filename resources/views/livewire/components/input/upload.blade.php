<div>


    <div
    wire:ignore
    x-data
    x-init="
    FilePond.setOptions({
    server: {
    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
    },
    @this.upload(file_lampiran, file, load, error, progress)
    revert: (filename, load) => {
    @this.removeUpload(file_lampiran, filename, load)
    },
    },
    });
    FilePond.create($refs.input);
    "
    >
    <input type="file" x-ref="input"/>
    </div>  

    @push('css')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    @endpush
    @push('js')
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create( inputElement );
    </script>
    @endpush


</div>