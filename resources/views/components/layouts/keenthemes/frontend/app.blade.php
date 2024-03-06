<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('meta')
    <title>@yield('title')</title>
    @include('components.layouts.keenthemes.frontend.parsial.css')
    <link rel="shortcut icon" href="{!! getAppFavicon() !!}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    @livewireStyles
    @stack('css')
</head>
<!--end::Head-->

<!--begin::Body-->
<!--begin::Theme mode setup on page load-->

<body id="kt_app_body" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;

        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--Begin::Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!--End::Google Tag Manager (noscript) -->

    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">

            <x-layouts.keenthemes.frontend._topbar></x-layouts.keenthemes.frontend._topbar>
            <!--begin::Wrapper-->
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">

                <x-layouts.keenthemes.frontend._sidebar></x-layouts.keenthemes.frontend._sidebar>
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    <!--begin::Toolbar-->
                    <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-0 ">
                        <!--begin::Toolbar container-->
                        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column justify-content-center me-3 ">
                                <!--begin::Title-->
                                <h1
                                    class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                                    @yield('title')
                                </h1>
                                <!--end::Title-->

                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                    @yield('menu')
                                    </li>
                                    <!--end::Item-->

                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Toolbar container-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content  flex-column-fluid ">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container  container-xxl ">
                            {{$slot}}
                        </div>
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->

                </div>
                <!--end::Content wrapper-->


            </div>
            <!--end::App-->


            <!--end::Drawers-->
            <!--begin::Engage-->
            <!-- <div class="app-engage " id="kt_app_engage"></div> -->
            <!--end::Engage-->
            <!--begin::Modal - Sitemap-->
            <div class="modal fade bg-dark bg-opacity-75" id="kt_app_engage_prebuilts_modal" tabindex="-1"
                aria-hidden="true">
            </div>
            <!--end::Engage modals-->
            <!--begin::Scrolltop-->
            <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
                <i class="ki-outline ki-arrow-up"></i>
            </div>
            <!--end::Scrolltop-->
            <!--end::Theme mode setup on page load-->
            @include('components.layouts.keenthemes.frontend.parsial.js')
            <script>
                var defaultThemeMode = "light";
                var themeMode;

                if (document.documentElement) {
                    if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                    } else {
                        if (localStorage.getItem("data-bs-theme") !== null) {
                            themeMode = localStorage.getItem("data-bs-theme");
                        } else {
                            themeMode = defaultThemeMode;
                        }
                    }

                    if (themeMode === "system") {
                        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                    }

                    document.documentElement.setAttribute("data-bs-theme", themeMode);
                }
            </script>

</body>

</html>