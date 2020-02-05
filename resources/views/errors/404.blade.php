
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/dashtreme/demo/dashtreme-dark/pages-404.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2019 10:02:53 GMT -->
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
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
  {{-- fonts --}}
  <link href="https://fonts.googleapis.com/css?family=Dangrek|Koulen|Kantumruy|Preahvihear|Nokora&display=swap" rel="stylesheet">
  <!-- Custom Style-->
  <link href="{{asset('assets/css/app-style.css')}}" rel="stylesheet"/>
  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">


</head>

<body class="bg-theme bg-theme1">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center error-pages">
                        <h1 class="error-title text-white"> 404</h1>
                        <h2 class="error-sub-title text-white">404 រក​មិន​ឃើញ</h2>

                        <p style="font-family: 'Preahvihear', cursive;padding-top:20px;">ស្រងេះស្រងោចដែលត្រូវបានជ្រើសរើសបានស្នើសុំទំព័រមិនគួរឱ្យជឿ!</p>

                        <div class="mt-4">
                          <a href="{{route('home')}}" class="btn btn-light btn-round m-1">ទៅផ្ទះយើងវិញ </a>
                          <a style="cursor:pointer;"onclick="window.history.go(-1); return false;" class="btn btn-light btn-round m-1">ថយក្រោយវិញ </a>
                        </div>

                        <div class="mt-4">
                            <p class="text-white">Copyright © 2018 Dashtreme | All rights reserved.</p>
                        </div>
                           <hr class="w-50 border-light">
                        <div class="mt-2">
                            <a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1"><i class="fa fa-facebook"></i></a>
                            <a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1"><i class="fa fa-google-plus"></i></a>
                            <a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1"><i class="fa fa-behance"></i></a>
                            <a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1"><i class="fa fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<!--start color switcher-->
   <div class="right-sidebar">
    <div class="switcher-icon">
      <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
    </div>
    <div class="right-sidebar-content">

      <p class="mb-0">Gaussion Texture</p>
      <hr>

      <ul class="switcher">
        <li id="theme1"></li>
        <li id="theme2"></li>
        <li id="theme3"></li>
        <li id="theme4"></li>
        <li id="theme5"></li>
        <li id="theme6"></li>
      </ul>

      <p class="mb-0">Gradient Background</p>
      <hr>

      <ul class="switcher">
        <li id="theme7"></li>
        <li id="theme8"></li>
        <li id="theme9"></li>
        <li id="theme10"></li>
        <li id="theme11"></li>
        <li id="theme12"></li>
      </ul>

     </div>
   </div>
  <!--end color switcher-->

 </div><!--wrapper-->


  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

  <!-- simplebar js -->
  <script src="{{asset('assets/plugins/simplebar/js/simplebar.js')}}"></script>
  <!-- sidebar-menu js -->
  <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>

  <!-- Custom scripts -->
  <script src="{{asset('assets/js/app-script.js')}}"></script>

</body>

<!-- Mirrored from codervent.com/dashtreme/demo/dashtreme-dark/pages-404.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2019 10:02:53 GMT -->
</html>
