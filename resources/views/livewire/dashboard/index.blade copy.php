@section('title','Dashboard')

<div>
<div class="row ">

            <div class="col-xl-3 col-lg-3">
                <div class="card l-bg-blue-dark">
                    <div class="card-statistic-3 py-4 px-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-archive"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Permohonan Masuk</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <span wire:poll.5s>{{ getTotalStatistik("Surat Masuk","is_read",0,Auth::user()->id) }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3">
                <div class="card l-bg-cherry">
                    <div class="card-statistic-3 py-4 px-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-file"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Permohonan Keluar</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <span wire:poll.5s>{{ getTotalStatistik("Surat Keluar","is_read",0,Auth::user()->id) }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-3">
                <div class="card l-bg-green-dark">
                    <div class="card-statistic-3 py-4 px-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Disposisi Masuk</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <span wire:poll.5s>{{ getTotalStatistik("Disposisi Masuk","is_read",0,Auth::user()->id) }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 col-lg-3">
                <div class="card l-bg-orange-dark">
                    <div class="card-statistic-3 py-4 px-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-user"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">Disposisi Keluar</h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <span wire:poll.5s>{{ getTotalStatistik("Disposisi Keluar","is_read",0,Auth::user()->id) }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


       
            <div class="row">
           
                    @livewire('dashboard.SuratMasuk')
            
                    @livewire('dashboard.SuratKeluar')
   
                    @livewire('dashboard.DisposisiMasuk')
            
                    @livewire('dashboard.DisposisiKeluar')
                
            </div>
            
        <HR class="text-muted">

        <div class="row">
            <div class="col-sm-6">
                @livewire('dashboard.SuratMasukTerbaru')
            </div>
            
            <div class="col-sm-6">
                @livewire('dashboard.DisposisiMasukTerbaru')
            </div>
        </div>
      

        
</div>

@push('css')
<style>
/* STYLE DASHBOARD */
.card { background-color: #fff; border-radius: 10px; border: none; position: relative; box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1); } .l-bg-cherry { background: linear-gradient(to right, #493240, #f09) !important; color: #fff; } .l-bg-blue-dark { background: linear-gradient(to right, #373b44, #4286f4) !important; color: #fff; } .l-bg-green-dark { background: linear-gradient(to right, #0a504a, #38ef7d) !important; color: #fff; } .l-bg-orange-dark { background: linear-gradient(to right, #a86008, #ffba56) !important; color: #fff; } .card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal { font-size: 110px; } .card .card-statistic-3 .card-icon { text-align: center; line-height: 50px; margin-left: 15px; color: #000; position: absolute; right: 25px; top: 20px; opacity: 0.1; } .l-bg-cyan { background: linear-gradient(135deg, #289cf5, #84c0ec) !important; color: #fff; } .l-bg-green { background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important; color: #fff; } .l-bg-orange { background: linear-gradient(to right, #f9900e, #ffba56) !important; color: #fff; } .l-bg-cyan { background: linear-gradient(135deg, #289cf5, #84c0ec) !important; color: #fff; }
/* List */
.text-muted { color: #99a0ac!important } .block, .card { background: #fff; border-width: 0; border-radius: .25rem; box-shadow: 0 1px 3px rgba(0, 0, 0, .05); margin-bottom: 1.5rem } .avatar { position: relative; line-height: 1; border-radius: 500px; white-space: nowrap; font-weight: 700; border-radius: 100%; display: -ms-flexbox; display: flex; -ms-flex-pack: center; justify-content: center; -ms-flex-align: center; align-items: center; -ms-flex-negative: 0; flex-shrink: 0; border-radius: 500px; box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15) } .avatar img { border-radius: inherit; width: 100% } .gd-primary { color: #fff; border: none; background: #448bff linear-gradient(45deg, #448bff, #44e9ff) } .gd-success { color: #fff; border: none; background: #31c971 linear-gradient(45deg, #31c971, #3dc931) } .gd-info { color: #fff; border: none; background: #14bae4 linear-gradient(45deg, #14bae4, #14e4a6) } .gd-warning { color: #fff; border: none; background: #f4c414 linear-gradient(45deg, #f4c414, #f45414) } @media (min-width:992px) { .page-container { max-width: 1140px; margin: 0 auto } .page-sidenav { display: block!important } } .list { padding-left: 0; padding-right: 0 } .list-item { position: relative; display: -ms-flexbox; display: flex; -ms-flex-direction: column; flex-direction: column; min-width: 0; word-wrap: break-word } .list-row .list-item { -ms-flex-direction: row; flex-direction: row; -ms-flex-align: center; align-items: center; padding: .75rem .625rem } .list-row .list-item>* { padding-left: .625rem; padding-right: .625rem } .no-wrap { white-space: nowrap } .text-color { color: #5e676f } .text-gd { -webkit-background-clip: text; -moz-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; -moz-text-fill-color: transparent; text-fill-color: transparent } .text-sm { font-size: .825rem } .h-1x { height: 1.25rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical } .w-48 { width: 48px!important; height: 48px!important } a:link{ text-decoration: none; }
/* List Counter */
.fa { font-size: 50px;text-align: right;position: absolute;top: 7px;right: 27px;outline: none; opacity: 0.1; color:#99a0ac } a { transition: all .3s ease;-webkit-transition: all .3s ease;-moz-transition: all .3s ease;-o-transition: all .3s ease; } p { margin-top: 0; margin-bottom: 0px; } /* SURAT MASUK */ a.surat-masuk i,.surat-masuk h4.list-group-item-heading { color:#3b5998; } a.surat-masuk:hover { background-color:#3b5998; } a.surat-masuk:hover * { color:#FFF; } /* SURAT KELUAR */ a.surat-keluar i,.surat-keluar h4.list-group-item-heading { color:#493240; } a.surat-keluar:hover { background-color:#493240; } a.surat-keluar:hover * { color:#FFF; } /* DISPOSISI MASUK */ a.disposisi-masuk i,.disposisi-masuk h4.list-group-item-heading { color:#0a504a; } a.disposisi-masuk:hover { background-color:#0a504a; } a.disposisi-masuk:hover * { color:#FFF; } /* DISPOSISI KELUAR */ a.disposisi-keluar i,.disposisi-keluar h4.list-group-item-heading { color:#a86008; } a.disposisi-keluar:hover { background-color:#a86008; } a.disposisi-keluar:hover * { color:#FFF; }
</style>
@endpush