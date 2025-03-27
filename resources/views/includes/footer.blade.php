<script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/popper.js/dist/umd/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('plugins/modernizr/modernizr.js') }}"></script>
<!-- Chart js -->
<script type="text/javascript" src="{{ asset('plugins/chart.js/dist/Chart.js') }}"></script>
<!-- amchart js -->
<script src="{{ asset('dist/pages/widget/amchart/amcharts.js') }}"></script>
<script src="{{ asset('dist/pages/widget/amchart/serial.js') }}"></script>
<script src="{{ asset('dist/pages/widget/amchart/light.js') }}"></script>
<script src="{{ asset('dist/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/js/SmoothScroll.js') }}"></script>
<script src="{{ asset('dist/js/pcoded.min.js') }}"></script>

@isset($pageScripts)
    {{ $pageScripts }}
@endisset
<!-- custom js -->
<script src="{{ asset('dist/js/vartical-layout.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/pages/dashboard/custom-dashboard.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/js/script.min.js') }}"></script>
