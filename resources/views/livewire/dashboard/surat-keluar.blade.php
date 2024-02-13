
    {{-- Surat Keluar --}}
    <div class="col-md-3">
        <h4>Surat Keluar</h4>
        <div class="list-group">
            <a href="{{ route('main.suratkeluar.index') }}" class="list-group-item surat-keluar">
                <h3 class="pull-right">
                    <i class="fa fa-file"></i>
                </h3>
                <h4 class="list-group-item-heading count">
                    {{ getTotalStatistik("Surat Keluar","is_approve",0,Auth::user()->id) }}</h4>
                <p class="list-group-item-text">
                     Draft</p>
            </a>
            <a href="{{ route('main.suratkeluar.index') }}" class="list-group-item surat-keluar">
                <h3 class="pull-right">
                    <i class="fa fa-ban"></i>
                </h3>
                <h4 class="list-group-item-heading count">
                    {{ getTotalStatistik("Surat Masuk","is_approve",2,Auth::user()->id) }}</h4>
                <p class="list-group-item-text">
                     Ditolak</p>
            </a>
            <a href="{{ route('main.suratkeluar.index') }}" class="list-group-item surat-keluar">
                <h3 class="pull-right">
                    <i class="fa fa-check"></i>
                </h3>
                <h4 class="list-group-item-heading count">
                    {{ getTotalStatistik("Surat Masuk","is_approve",1,Auth::user()->id) }}</h4>
                <p class="list-group-item-text">
                     Diterima</p>
            </a>
            <a href="{{ route('main.suratkeluar.index') }}" class="list-group-item surat-keluar">
                <h3 class="pull-right">
                    <i class="fa fa-archive"></i>
                </h3>
                <h4 class="list-group-item-heading count">
                    {{ getTotalStatistik("Surat Masuk","is_active",1,Auth::user()->id) }}</h4>
                <p class="list-group-item-text">
                    Total </p>
            </a>
        </div>
    </div>

