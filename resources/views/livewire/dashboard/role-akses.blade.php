@section('title', 'Login')
<!--begin::Authentication - Sign-in -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">
  <!--begin::Body-->
  <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
      <!--begin::Form-->
      <div class="d-flex flex-center flex-column flex-lg-row-fluid">
          <!--begin::Wrapper-->
          <div class="w-xl-500px p-10">

              <!--begin::Form-->
              <form class="form w-100" wire:submit.prevent="signin" accept-charset="utf-8">

                  <!--begin::Heading-->
                  <div class="text-center mb-11">
                      <!--begin::Title-->

                      <a href="javascript:void(0)" class="text-center d-block m-b-10">
                        <img src="{{ Storage::disk('public')->url(getApp()->logo_url) }}" class="max-h-75px" height="75px" alt="{{ getApp()->name }}" />
                      </a>

                      <h1 class="text-gray-900 fw-bolder mb-3">
                       @yield('title')
                      </h1>
                      <!--end::Title-->

                      <!--begin::Subtitle-->
                      <div class="text-gray-500 fw-semibold fs-6">
                        {{-- {{getAppName()}} --}}
                      </div>
                      <!--end::Subtitle--->
                  </div>
                  <!--begin::Heading-->

                  <div class="login-box login-sidebar" style="margin-top:auto !important;">
                    <div class="white-box">

                

              <div class="list list-row block">

                @if (count(getRoleAkses(Auth::user()->id)) > 0)
                @foreach (getRoleAkses(Auth::user()->id) as $index => $item)

                    <div class="list-item" data-id="{{$index}}" data-bs-toggle="tooltip" title="Login Sebagai {{ $item->jabatan }}">
                        <div><a href="{{ route('dashboard.auto.login', [1, Crypt::encryptString($item->id)]) }}" data-abc="true"><span class="w-48 avatar gd-success"></span></a></div>
                        <div class="flex">
                            <a href="{{ route('dashboard.auto.login', [1, Crypt::encryptString($item->id)]) }}" class="item-author text-color" data-abc="true"> {{ $item->nama }}</a>
                            <div class="item-except text-muted text-sm h-1x"> {{ $item->jabatan }}</div>
                        </div>
                    </div>


                <div class="list-item" data-id="{{$index}}" data-bs-toggle="tooltip" title="Login Sebagai {{ $item->jabatan_pembantu }}">
                    <div><a href="{{ route('dashboard.auto.login', [2, Crypt::encryptString($item->id)]) }}" data-abc="true"><span class="w-48 avatar gd-success"></span></a></div>
                    <div class="flex">
                        <a href="{{ route('dashboard.auto.login', [2, Crypt::encryptString($item->id)]) }}" class="item-author text-color" data-abc="true"> {{ $item->nama }}</a>

                        <div class="item-except text-muted text-sm h-1x"> {{ $item->jabatan_pembantu }}</div>
                    </div>
                </div>

                @endforeach
            @else
            <div class="list-item">
                <div class="text-muted text-center">Tidak Memiliki Jabatan Tambahan</div>
            </div>
            @endif

    
            </div>

  
            </div>

            </div>


                  <!--begin::Submit button-->
                  <div class="d-grid mb-10">
                      <button type="submit" class="btn btn-success">

                          <!--begin::Indicator label-->
                          <span class="indicator-label">
                              Sign In</span>
                          <!--end::Indicator label-->

                          <!--begin::Indicator progress-->
                          <span class="indicator-progress" wire:loading wire:target="logout">
                              Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                          </span>
                          <!--end::Indicator progress-->
                      </button>
                  </div>
                  <!--end::Submit button-->
         
           
              <!--end::Form-->
          </div>
          <!--end::Wrapper-->
      </div>
      <!--end::Form-->
    </form>
    

  </div>
  <!--end::Body-->

  <!--begin::Aside-->
  <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2 bg-success">
      <!--begin::Content-->
      <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
          <!--begin::Image-->
          <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
              src="{!! asset('backend/themes/assets/media/misc/intro-data.svg') !!}" alt="" />
          <!--end::Image-->

          <!--begin::Title-->
          <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
            {{getAppName()}}
          </h1>
          <!--end::Title-->

          <!--begin::Text-->
          <div class="d-none d-lg-block text-white fs-base text-center">
            {{getDescriptionName()}}
          </div>
          <!--end::Text-->
      </div>
      <!--end::Content-->
  </div>
  <!--end::Aside-->

  @push('css')
  <style>
  /* List */
  .text-muted { color: #99a0ac!important } .block, .card { background: #fff; border-width: 0; border-radius: .25rem; box-shadow: 0 1px 3px rgba(0, 0, 0, .05); margin-bottom: 1.5rem } .avatar { position: relative; line-height: 1; border-radius: 500px; white-space: nowrap; font-weight: 700; border-radius: 100%; display: -ms-flexbox; display: flex; -ms-flex-pack: center; justify-content: center; -ms-flex-align: center; align-items: center; -ms-flex-negative: 0; flex-shrink: 0; border-radius: 500px; box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15) } .avatar img { border-radius: inherit; width: 100% } .gd-primary { color: #fff; border: none; background: #448bff linear-gradient(45deg, #448bff, #44e9ff) } .gd-success { color: #fff; border: none; background: #31c971 linear-gradient(45deg, #31c971, #3dc931) } .gd-info { color: #fff; border: none; background: #14bae4 linear-gradient(45deg, #14bae4, #14e4a6) } .gd-warning { color: #fff; border: none; background: #f4c414 linear-gradient(45deg, #f4c414, #f45414) } @media (min-width:992px) { .page-container { max-width: 1140px; margin: 0 auto } .page-sidenav { display: block!important } } .list { padding-left: 0; padding-right: 0 } .list-item { position: relative; display: -ms-flexbox; display: flex; -ms-flex-direction: column; flex-direction: column; min-width: 0; word-wrap: break-word } .list-row .list-item { -ms-flex-direction: row; flex-direction: row; -ms-flex-align: center; align-items: center; padding: .75rem .625rem } .list-row .list-item>* { padding-left: .625rem; padding-right: .625rem } .no-wrap { white-space: nowrap } .text-color { color: #5e676f } .text-gd { -webkit-background-clip: text; -moz-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; -moz-text-fill-color: transparent; text-fill-color: transparent } .text-sm { font-size: .825rem } .h-1x { height: 1.25rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical } .w-48 { width: 48px!important; height: 48px!important } a:link{ text-decoration: none; }
  </style>
  @endpush

  
</div>
<!--end::Authentication - Sign-in-->