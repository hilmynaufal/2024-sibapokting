<div class="app-navbar flex-shrink-0 gap-2 gap-lg-4">

    <!--begin::Notifications-->
    <div class="app-navbar-item">
        <!--begin::Menu- wrapper-->
        

        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true"
            id="kt_menu_notifications">
            <!--begin::Heading-->
            <div class="d-flex flex-column bgi-no-repeat rounded-top"
                style="background-image:url('{{ asset('backend/themes/assets/media/misc/menu-header-bg.jpg');}}') }}')">
            </div>
            <!--end::Heading-->

            <!--end::Tab content-->
        </div>
        <!--end::Menu-->
        <!--end::Menu wrapper-->
    </div>
    <!--end::Notifications-->

    <!--begin::User menu-->
    <div class="app-navbar-item ms-lg-5" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <!--begin:Info-->
            <div class="text-end d-none d-sm-flex flex-column justify-content-center me-3">
                <span class="/metronic8/demo63/../demo63/pages/user-profile/overview.html"
                    class="text-gray-500 fs-8 fw-bold">Hello</span>
                <a href="pages/user-profile/overview.html"
                    class="text-gray-800 text-hover-primary fs-7 fw-bold d-block">{{Auth::user()->username;}}</a>
            </div>
            <!--end:Info-->

            <!--begin::User-->
            <div class="cursor-pointer symbol symbol symbol-circle symbol-35px symbol-md-40px">
                <img class src="{{ asset('backend/themes/assets/media/avatars/300-3.jpg') }}" alt="user" />
                <div
                    class="position-absolute translate-middle bottom-0 mb-1 start-100 ms-n1 bg-success rounded-circle h-8px w-8px">
                </div>
            </div>
            <!--end::User-->
        </div>

        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <img alt="Logo" src="{{ asset('backend/themes/assets/media/avatars/300-3.jpg') }}" />
                    </div>
                    <!--end::Avatar-->

                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">
                            {{Auth::user()->username;}} <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"></span>
                        </div>

                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                            {{Auth::user()->nama;}} </a>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{ route('account.profile') }}" class="menu-link px-5">
                Profil Saya
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{ route('account.password') }}" class="menu-link px-5">
                    <span class="menu-text">Ubah Password</span>
                    <span class="menu-badge">
                        <span class="badge badge-light-danger badge-circle fw-bold fs-7"></span>
                    </span>
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">
                        Mode

                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                            <i class="ki-outline ki-night-day theme-light-show fs-2"></i> <i
                                class="ki-outline ki-moon theme-dark-show fs-2"></i> </span>
                    </span>
                </a>

                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                    data-kt-menu="true" data-kt-element="theme-mode-menu">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-outline ki-night-day fs-2"></i> </span>
                            <span class="menu-title">
                                Light
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-outline ki-moon fs-2"></i> </span>
                            <span class="menu-title">
                                Dark
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                        <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                            <span class="menu-icon" data-kt-element="icon">
                                <i class="ki-outline ki-screen fs-2"></i> </span>
                            <span class="menu-title">
                                System
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->

            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <livewire:auth.logout />
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::User account menu-->

        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->

</div>