<div>
    @section('title', 'Master Instansi')
    
    <div class="row">
    
    <div class="col-lg-{{ $isOpen ? '8' : '12' }}">
    <div>
    <!--begin::Card header-->
    <div class="card-header align-items-center gap-2 gap-md-5">
        <!--begin::Card title-->
        <div class="card-title">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i> <input type="text"
                    data-kt-ecommerce-product-filter="search" wire:model.live="search"
                    class="form-control form-control-solid w-250px ps-12" placeholder="">
            </div>
            <!--end::Search-->
        </div>
        <!--end::Card title-->

        <!--begin::Card toolbar-->
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <button wire:click="toggle" class="btn btn-primary btn-sm" type="button"><i
                    class="fa fa-plus"></i> Tambah</button>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Table-->
        <div class="table-responsive">
                
            <table class="table table-head-custom table-vertical-center table-hover table-striped" id="kt_advance_table_widget_2">
                <thead>
                    <tr class="text-uppercase">
                        <th class="pl-0" style="min-width: 100px">
                        
                            <label>
                                <select name="kt_ecommerce_products_table_length"
                                    aria-controls="kt_ecommerce_products_table"
                                    class="form-select form-select-sm form-select-solid"
                                    wire:model.live="perpage">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </label>
                            

                        </th>
                        <th style="min-width: 120px text-center">Kode
                            @if ($sortColoumName === 'kode')
                                <span wire:click="sortBy('kode')" class="float-end text-sm" style="cursor: pointer;">
                                    <i class="{{ $sortColoumName === 'kode' && $sortDirection === 'desc' ? ' fas fa-sort-up ' : 'fas fa-sort-down' }}"></i>
                                </span> 
                            @else
                                <span wire:click="sortBy('kode')" class="float-end text-sm" style="cursor: pointer;">
                                    <i class="fas fa-sort"></i>
                                </span>
                            @endif
                            </th>                                
                        <th style="min-width: 120px text-center">Nama Instansi
                        @if ($sortColoumName === 'nama')
                            <span wire:click="sortBy('nama')" class="float-end text-sm" style="cursor: pointer;">
                                <i class="{{ $sortColoumName === 'nama' && $sortDirection === 'desc' ? ' fas fa-sort-up ' : 'fas fa-sort-down' }}"></i>
                            </span> 
                        @else
                            <span wire:click="sortBy('nama')" class="float-end text-sm" style="cursor: pointer;">
                                <i class="fas fa-sort"></i>
                            </span>
                        @endif
                        </th>
                        <th style="min-width: 120px text-center">Alamat
                            @if ($sortColoumName === 'alamat')
                                <span wire:click="sortBy('alamat')" class="float-end text-sm" style="cursor: pointer;">
                                    <i class="{{ $sortColoumName === 'alamat' && $sortDirection === 'desc' ? ' fas fa-sort-up ' : 'fas fa-sort-down' }}"></i>
                                </span> 
                            @else
                                <span wire:click="sortBy('alamat')" class="float-end text-sm" style="cursor: pointer;">
                                    <i class="fas fa-sort"></i>
                                </span>
                            @endif
                            </th>
                            <th style="min-width: 120px text-center">Kontak
                                @if ($sortColoumName === 'kontak')
                                    <span wire:click="sortBy('kontak')" class="float-end text-sm" style="cursor: pointer;">
                                        <i class="{{ $sortColoumName === 'kontak' && $sortDirection === 'desc' ? ' fas fa-sort-up ' : 'fas fa-sort-down' }}"></i>
                                    </span> 
                                @else
                                    <span wire:click="sortBy('kontak')" class="float-end text-sm" style="cursor: pointer;">
                                        <i class="fas fa-sort"></i>
                                    </span>
                                @endif
                                </th>  
                                <th style="min-width: 120px text-center">Email
                                    @if ($sortColoumName === 'email')
                                        <span wire:click="sortBy('email')" class="float-end text-sm" style="cursor: pointer;">
                                            <i class="{{ $sortColoumName === 'email' && $sortDirection === 'desc' ? ' fas fa-sort-up ' : 'fas fa-sort-down' }}"></i>
                                        </span> 
                                    @else
                                        <span wire:click="sortBy('email')" class="float-end text-sm" style="cursor: pointer;">
                                            <i class="fas fa-sort"></i>
                                        </span>
                                    @endif
                                    </th>                                                    
                        <th class="pr-0 text-right" style="min-width: 160px">Aktif</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item)
                        <tr>
                            <td>
                                <a href="#"
                                class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                Aksi <i class="ki-outline ki-down fs-5 ms-1"></i>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                data-kt-menu="true"
                                style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-60px, 299px);"
                                data-popper-placement="bottom-end">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" wire:click="edit({{ $item->id }})"
                                        class="menu-link px-3">
                                        Edit
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" wire:click="deleteRequest({{ $item->id }})"
                                        class="menu-link px-3">
                                        Delete
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            </td>
                            <td>
                                <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->kode}}</span>
                            </td>                                    
                            <td>
                                <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->nama}}</span>
                            </td>
                            <td>
                                <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->alamat}}</span>
                            </td>
                            <td>
                                <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->kontak}}</span>
                            </td>                            
                            <td>
                                <span class="text-center text-gray-80 font-weight-bolder text-hover-success font-size-lg">{{ $item->email}}</span>
                            </td>                            
                            <td class="pr-0 text-right">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckStatus{{ $item->id }}" wire:click="status({{ $item->id }})" {{ $item->is_active == 0 ? '' : 'checked' }}>
                                    <label class="form-check-label" for="flexSwitchCheckStatus{{ $item->id }}">{{ $item->is_active == 0 ? 'Tidak Aktif' : 'Aktif' }}</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
     
                
    
        </div>
        <!--end::Table-->
    </div>
    <!--end::Body-->
    </div>
    </div>
    
    
    
    
    
    @if ($isOpen)
    <div class="col-lg-4">
    <div>
    <!--begin::Header-->
    <div class="card-header border-0">
        <h2 class="card-title font-weight-bolder">@yield('title') <div wire:dirty class="text text-secondary">Draft</div> 
            <span wire:loading class="spinner-border spinner-border-sm align-middle ms-2"></span></h2>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <form action="">
        <div class="card-body">
            <div class="mb-3 fv-row fv-plugins-icon-container">
                <label>Kode
                <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid @error('kode') is-invalid @enderror" placeholder="Ex: JB" wire:model="kode" />
                <input type="hidden" class="form-control form-control-solid @error('nama_id') is-invalid @enderror" wire:model="nama_id" />
                @error('kode')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                @enderror
            </div>
            <div class="mb-3 fv-row fv-plugins-icon-container">
                <label>Nama Instansi
                <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid @error('nama') is-invalid @enderror" placeholder="Ex: Jamkrida Jawa Barat" wire:model="nama" />
                @error('nama')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                @enderror
            </div>
            <div class="mb-3 fv-row fv-plugins-icon-container">
                <label>Alamat
                <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid @error('nama') is-invalid @enderror" placeholder="Ex: Alamat" wire:model="alamat" />
                @error('alamat')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                @enderror
            </div>                      
            <div class="mb-3 fv-row fv-plugins-icon-container">
                <label>Kontak
                <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid @error('nama') is-invalid @enderror" placeholder="Ex: Kontak" wire:model="kontak" />
                @error('kontak')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                @enderror
            </div>     
            <div class="mb-3 fv-row fv-plugins-icon-container">
                <label>Email
                <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-solid @error('nama') is-invalid @enderror" placeholder="Ex: email@instansi.co.id" wire:model="email" />
                @error('email')
                    <div class="invalid-feedback form-text text-danger"> {{ $message }} </div>
                @enderror
            </div>                                                         
        </div>
        <!--end: Card Body-->
        <div class="card-footer pt-0">
            <button type="button" wire:offline.attr="disabled" wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
                @if ($mode == 'create') wire:click.prevent="store" @else wire:click.prevent="update" @endif
                class="btn btn-success">
                <i class="fa fa-save"></i>
                {{ $mode == 'create' ? 'Simpan' : 'Edit' }}
                <span wire:loading  @if ($mode == 'create') wire:target="store" @else wire:target="update" @endif class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </button>
            <button type="button" wire:click.prevent="cancel" wire:click="toggle" class="btn btn-secondary">Batal</button>

    </div>
    </form>
    </div>
    </div>
    @endif
    
    
    </div>
    </div>