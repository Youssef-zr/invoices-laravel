<!-- Title -->
<title> 
    برنامج الفواتير
    @if (isset($title))
        -
        {{ $title }}
    @endif
</title>
<!-- Favicon -->
<link rel="icon" href="{{url('assets/img/brand/favicon.png')}}" type="image/x-icon"/>
<!-- Icons css -->
<link href="{{url('assets/css/icons.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{url('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--  Sidebar css -->
<link href="{{url('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{url('assets/css-rtl/sidemenu.css')}}">
@yield('css')
<!--- Style css -->
<link href="{{url('assets/css-rtl/style.css')}}" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{url('assets/css-rtl/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{url('assets/css-rtl/skin-modes.css')}}" rel="stylesheet">

{{-- noty plugin --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script> 

{{-- select2 --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<link rel="stylesheet" href="{{ url('assets/plugins/select2/css/select2.min.css') }}">

{{-- datatables style --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">


{{-- font awesome 4.7 --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

<style>
	div.dataTables_wrapper {
        direction: rtl;
    }
 
    /* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
        margin: 0 auto;
    }
</style>

{{-- fonts --}}
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet"> 

{{-- Custom style --}}
<link rel="stylesheet" href="{{ url('css/style.css') }}">