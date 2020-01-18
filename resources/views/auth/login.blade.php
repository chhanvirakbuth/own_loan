
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/dashtreme/demo/dashtreme-dark/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2019 10:01:47 GMT -->
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>ចូលកម្មវិធី</title>
  <!--favicon-->
  <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="{{asset('assets/css/app-style.css')}}" rel="stylesheet"/>
  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">
  {{-- Font khmer --}}
  <link href="https://fonts.googleapis.com/css?family=Dangrek|Koulen|Kantumruy|Nokora&display=swap" rel="stylesheet">

</head>

<body class="bg-theme bg-theme9">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

 <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
	<div class="card card-authentication1 mx-auto my-5">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		{{-- <img src="{{asset($theme->logo)}}" alt="logo icon" style="max-width:150px;"> --}}
		 	</div>
		  <div class="card-title text-uppercase text-center py-3">ចូលកម្មវិធី</div>
		    <form method="POST" action="{{ route('login') }}">
          @csrf
			  <div class="form-group">
			  <label for="exampleInputUsername" class="sr-only">អ៊ីម៉ែល</label>
			   <div class="position-relative has-icon-right">
				  <input id="email" type="email" class="form-control input-shadow @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="បញ្ចូលអ៊ីម៉ែល">
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
				  <div class="form-control-position">
					  <i class="zmdi zmdi-email"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			  <label for="exampleInputPassword" class="sr-only">លេខកូដសម្ងាត់</label>
			   <div class="position-relative has-icon-right">
				  <input id="password" type="password" class="form-control input-shadow @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="បញ្ចូលលេខកូដសម្ងាត់">
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
				  <div class="form-control-position">
					  <i toggle="#password-field" class="fa fa-fw fa-eye toggle-password" style="cursor:pointer"></i>
				  </div>
			   </div>
			  </div>
			<div class="form-row">
			 <div class="form-group col-6">
			   <div class="icheck-material-white">
                <input class="form-check-input" type="checkbox" id="user-checkbox remember"name="remember" id="remember" checked="" />
                <label for="user-checkbox">ចងចាំខ្ញុំលើកក្រោយ</label>
			  </div>
			 </div>
			 <div class="form-group col-6 text-right">
         @if (Route::has('password.request'))
			  <a href="{{ route('password.request') }}" ><label style="cursor: pointer;">ភ្លេចលេខកូដសម្ងាត់?</label></a>
        @endif
			 </div>
			</div>
			 <button type="submit" class="btn btn-light btn-block">ចូលកម្មវិធី</button>
			  <div class="text-center mt-3"><label>ចូលតាមរយះ</label></div>

			 <div class="form-row mt-4">
			  <div class="form-group mb-0 col-6">
			   <button type="button" class="btn btn-light btn-block"><i class="fa fa-facebook-square"></i> Facebook</button>
			 </div>
			 <div class="form-group mb-0 col-6 text-right">
			  <button type="button" class="btn btn-light btn-block"><i class="fa fa-twitter-square"></i> Twitter</button>
			 </div>
			</div>

			 </form>
		   </div>
		  </div>
		  <div class="card-footer text-center py-3">
		    <label class="text-warning mb-0">មានគណនីហើយឬនៅ? <a href="{{route('register')}}"><label style="cursor: pointer;">ចុះឈ្មោះទីនេះ</label></a></label>
		  </div>
	     </div>

     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

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

  <!-- sidebar-menu js -->
  <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>

  <!-- Custom scripts -->
  <script src="{{asset('assets/js/app-script.js')}}"></script>
  <script type="text/javascript">
    $("body").on('click', '.toggle-password', function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $("#password");
      if (input.attr("type") === "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }

    });
  </script>
</body>

<!-- Mirrored from codervent.com/dashtreme/demo/dashtreme-dark/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2019 10:01:47 GMT -->
</html>
