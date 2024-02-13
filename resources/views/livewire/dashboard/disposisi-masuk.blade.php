
  {{-- Disposisi Masuk --}}
  <div class="col-md-3">
    <h4>Disposisi Masuk</h4>
    <div class="list-group">
        <a href="{{ route('main.disposisimasuk.index') }}" class="list-group-item disposisi-masuk">
            <h3 class="pull-right">
                <i class="fa fa-eye-slash"></i>
            </h3>
            <h4 class="list-group-item-heading count" wire:poll.15s>
                {{ getTotalStatistik("Disposisi Masuk","is_status",0,Auth::user()->id) }}</h4>
            <p class="list-group-item-text">
                Belum Dilihat</p>
        </a>
        <a href="{{ route('main.disposisimasuk.index') }}" class="list-group-item disposisi-masuk">
            <h3 class="pull-right">
                <i class="fa fa-eye"></i>
            </h3>
            <h4 class="list-group-item-heading count" wire:poll.15s>
                {{ getTotalStatistik("Disposisi Masuk","is_status",1,Auth::user()->id) }}</h4>
            <p class="list-group-item-text">
             Sudah Dilihat</p>
        </a>
        <a href="{{ route('main.disposisimasuk.index') }}" class="list-group-item disposisi-masuk">
            <h3 class="pull-right">
                <i class="fa fa-book"></i>
            </h3>
            <h4 class="list-group-item-heading count" wire:poll.15s>
                {{ getTotalStatistik("Disposisi Masuk","is_status",2,Auth::user()->id) }}</h4>
            <p class="list-group-item-text">
             Sudah Dibaca</p>
        </a>
        <a href="{{ route('main.disposisimasuk.index') }}" class="list-group-item disposisi-masuk">
            <h3 class="pull-right">
                <i class="fa fa-archive"></i>
            </h3>
            <h4 class="list-group-item-heading count" wire:poll.15s>
                {{ getTotalStatistik("Disposisi Masuk","is_active",1,Auth::user()->id) }}</h4>
            <p class="list-group-item-text">
                Total</p>
        </a>
    </div>
</div>

