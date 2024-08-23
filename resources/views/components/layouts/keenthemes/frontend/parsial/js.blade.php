
    <!--begin::Javascript-->
    <script>
        var hostUrl = "/metronic8/demo23/assets/";
    </script>

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('frontend/assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/scripts.bundle.js')}}"></script>
    <script src="{{ asset('backend/themes/assets/plugins/custom/fslightbox/fslightbox.bundle.js'); }}"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('frontend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}">
    </script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="{{ asset('frontend/assets/plugins/custom/datatables/datatables.bundle.js')}}">
    </script>
    <!--end::Vendors Javascript-->

    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('frontend/assets/js/widgets.bundle.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/custom/widgets.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/custom/apps/chat/chat.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/custom/utilities/modals/upgrade-plan.js')}}">
    </script>
    <script src="{{ asset('frontend/assets/js/custom/utilities/modals/users-search.js')}}">
    </script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    <!-- GetButton.io widget -->
    <script type="text/javascript">
        (function () {
            var a = "<?= getApp()->sandbox_wa ?>";
            var b = "<?= getApp()->phone ?>";
            var options = {
                whatsapp: a, // Ganti dengan nomor WhatsApp Anda
                call: b, // Ganti dengan nomor WhatsApp And
                call_to_action: "Hubungi kami", // Pesan yang akan muncul di tombol
                position: "right", // Posisi tombol (left atau right)
            };
            var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
<!-- /GetButton.io widget -->
<!-- jQuery -->
@livewireScripts
@livewire('wire-elements-modal')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@stack('js')
<x-livewire-alert::scripts />
<x:pharaonic-select2::scripts />
