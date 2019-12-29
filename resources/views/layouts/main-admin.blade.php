<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/dashtreme/demo/dashtreme-dark/pages-blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2019 10:02:53 GMT -->
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>Dashtreme - Multipurpose Bootstrap4 Admin Template</title>
  <!--favicon-->
  <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
  <!-- simplebar CSS-->
  <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="{{asset('assets/css/sidebar-menu.css')}}" rel="stylesheet"/>
  {{-- toastr notifications --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- Custom Style-->
  <link href="{{asset('assets/css/app-style.css')}}" rel="stylesheet"/>
  {{-- Font khmer --}}
  <link href="https://fonts.googleapis.com/css?family=Dangrek|Kantumruy|Nokora&display=swap" rel="stylesheet">
  @yield('custom-css')
</head>

<body class="bg-theme bg-{{$theme->name}}">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->


@yield('admin-menu')



  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

  <!-- simplebar js -->
  <script src="{{asset('assets/plugins/simplebar/js/simplebar.js')}}"></script>
  <!-- sidebar-menu js -->
  <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
  {{-- toastr notifications --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" charset="utf-8"></script>
  <!-- Custom scripts -->
  <script src="{{asset('assets/js/app-script.js')}}"></script>
  <script type="text/javascript">
    @if (Session::has('success'))
      Command: toastr["success"]("{{Session::get('success')}}", "រីករាយ")
    @endif

    @if (Session::has('error'))
      Command: toastr["error"]("{{Session::get('error')}}", "សូមអភ័យទោស!")
    @endif

    @if (Session::has('info'))
      Command: toastr["info"]("{{Session::get('info')}}", "សូមអភ័យទោស!")
    @endif
  </script>
  @yield('custom-script')
</body>

<!-- Mirrored from codervent.com/dashtreme/demo/dashtreme-dark/pages-blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2019 10:02:53 GMT -->
</html>
