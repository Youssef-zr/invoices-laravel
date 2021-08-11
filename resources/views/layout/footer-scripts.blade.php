<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
{{-- <script src="{{url('assets/plugins/jquery/jquery.min.js')}}"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="{{ url('assets/plugins/jquery/jquery.min.js')}} "></script>

{{-- select 2 --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script src="{{ url("assets/plugins/select2/js/select2.min.js") }}"></script>

<!-- Bootstrap Bundle js -->
<script src="{{url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{url('assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{url('assets/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{url('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{url('assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{url('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{url('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
<!--Internal Sparkline js -->
<script src="{{url('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{url('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{url('assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{url('assets/plugins/sidebar/sidebar-custom.js')}}"></script>

<!-- Eva-icons js -->
<script src="{{url('assets/js/eva-icons.min.js')}}"></script>

<!-- Sticky js -->
<script src="{{url('assets/js/sticky.js')}}"></script>

<!-- External Data tables -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready( function () {

        $('#example1').DataTable({
            direction: "rtl",
            "order": [[ 0, 'desc' ]],
            "aLengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "الكل"]
            ],
            "oLanguage": {"sUrl": "{{ url('js/datatables_ar.json') }}"}
        });

        // datatable length select 
        setTimeout(() => {
            let $datatable_length = $('body').find('select[name="example1_length"]');
            $datatable_length.select2()
        }, 1000);

        // select2 plugin
        $('.select2').select2();
    
    });
</script>
<!--External  Datepicker js -->


<!-- custom js -->
<script src="{{url('assets/plugins/side-menu/sidemenu.js')}}"></script>
<script src="{{url('assets/js/custom.js')}}"></script><!-- Left-menu js-->

@yield('js')

