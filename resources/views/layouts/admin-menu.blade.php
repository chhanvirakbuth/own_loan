<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from codervent.com/dashtreme/demo/dashtreme-dark/pages-blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2019 10:02:53 GMT -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!--favicon-->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- simplebar CSS-->
    <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="{{asset('assets/css/sidebar-menu.css')}}" rel="stylesheet" /> {{-- toastr notifications --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Custom Style-->
    <link href="{{asset('assets/css/app-style.css')}}" rel="stylesheet" /> {{-- Font khmer --}}
    <link href="https://fonts.googleapis.com/css?family=Dangrek|Koulen|Kantumruy|Nokora&display=swap" rel="stylesheet"> @yield('custom-css')

    <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">
</head>

<body class="bg-theme bg-{{$theme->name}}">

    <!-- start loader -->
    <div id="pageloader-overlay" class="visible incoming">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <!-- end loader -->

    <!-- Start wrapper-->
    <div id="wrapper">
        <!--Start sidebar-wrapper-->
        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
            <div class="brand-logo">
                <a href="{{route('admin.home')}}">

          {{-- <img src="{{asset($theme->logo)}}" style="height:30px;" class="logo-icon" alt="logo icon"> --}}

          <a href="{{route('admin.home')}}"  class="logo-text">{{$theme->brand}}</a>
                </a>
            </div>
            <div class="user-details">
                <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
                    <div class="avatar"><img class="mr-3 side-user-img" src="{{asset(Auth::user()->image)}}" alt="user avatar"></div>
                    <div class="media-body">
                        <h6 class="side-user-name text-uppercase">@if (Auth::check()){{ Auth::user()->name }}@else Anyomous @endif</h6>
                    </div>
                </div>
                <div id="user-dropdown" class="collapse">
                    <ul class="user-setting-menu">
                        <li><a href="{{route('admin.profile')}}"><i class="icon-user"></i>  ប្រូហ្វាល</a></li>
                        <li><a href="{{route('admin.setting')}}"><i class="icon-settings"></i> កំណត់</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><i class="icon-power"></i> ចាកចេញ</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li class="sidebar-header">មីនុយ</li>
                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-view-dashboard"></i> <span>ផ្ទាំងព័ត៌មាន</span><i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{route('dashboard.index')}}"><i class="zmdi zmdi-dot-circle-alt"></i> ទូទៅ</a></li>
                        <li><a href="{{route('dashboard.loan')}}"><i class="zmdi zmdi-dot-circle-alt"></i> កម្ចី</a></li>
                        <li><a href="dashboard-digital-marketing.html"><i class="zmdi zmdi-dot-circle-alt"></i> សន្សំ</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-layers"></i>
                        <span>កម្ចី</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{route('admin.loan.index')}}"><i class="zmdi zmdi-dot-circle-alt"></i> បញ្ចីអ្នកខ្ចី</a></li>
                        <li><a href="{{route('admin.loan.create')}}"><i class="zmdi zmdi-dot-circle-alt"></i> ខ្ចីលុយ</a></li>
                        <li><a href="{{route('admin.loan.payment-index')}}"><i class="zmdi zmdi-dot-circle-alt"></i> បង់ការ</a></li>
                        <li><a href="{{route('admin.loan.unpaid')}}"><i class="zmdi zmdi-dot-circle-alt"></i> មិនទាន់បង់</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-card-travel"></i>
                        <span>សន្សំ</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{route('deposit.index')}}"><i class="zmdi zmdi-dot-circle-alt"></i> បញ្ចីអ្នកសន្សំ</a></li>
                        <li><a href="{{route('deposit.create')}}"><i class="zmdi zmdi-dot-circle-alt"></i> សមាជិកថ្មី</a></li>
                        <li><a href="{{route('deposit.search')}}"><i class="zmdi zmdi-dot-circle-alt"></i> ដាក់ប្រាក់</a></li>
                        <li><a href="{{route('deposit.withdraw')}}"><i class="zmdi zmdi-dot-circle-alt"></i> ដកប្រាក់</a></li>
                        <li><a href="components-pricing-table.html"><i class="zmdi zmdi-dot-circle-alt"></i> មិនទាន់សន្សំ</a></li>

                    </ul>
                </li>

                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-chart"></i> <span>របាយការណ៍កម្ចី</span>
                        <i class="fa fa-angle-left float-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{route('reports.loan.all')}}"><i class="zmdi zmdi-dot-circle-alt"></i> អ្នកខ្ចីទាំងអស់</a></li>
                        <li><a href="charts-apex.html"><i class="zmdi zmdi-dot-circle-alt"></i> ខ្ចីតាមខែ</a></li>
                        <li><a href="{{route('reports.loan.index')}}"><i class="zmdi zmdi-dot-circle-alt"></i> ការបង់ប្រាក់</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javaScript:void();" class="waves-effect">
                        <i class="zmdi zmdi-invert-colors"></i> <span>របាយការណ៍សន្សំ</span>
                        <i class="fa fa-angle-left float-right"></i>
                    </a>
                    <ul class="sidebar-submenu">
                        <li><a href="charts-chartjs.html"><i class="zmdi zmdi-dot-circle-alt"></i> តាមឈ្មោះ</a></li>
                        <li><a href="charts-apex.html"><i class="zmdi zmdi-dot-circle-alt"></i> តាមខែ</a></li>
                        <li><a href="charts-sparkline.html"><i class="zmdi zmdi-dot-circle-alt"></i> ទាំងអស់</a></li>
                    </ul>
                </li>

            </ul>

        </div>
        <!--End sidebar-wrapper-->

        <!--Start topbar header-->
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top">
                <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="javascript:void();">
                            <i class="icon-menu menu-icon"></i>
                        </a>
                    </li>
                    {{--
                    <li class="nav-item">
                        <form class="search-bar">
                            <input type="text" class="form-control" placeholder="Enter keywords">
                            <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                        </form>
                    </li> --}}
                </ul>

                <ul class="navbar-nav align-items-center right-nav-link">
                    <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                            <i class="fa fa-envelope-open-o"></i><span class="badge badge-light badge-up">12</span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    You have 12 new messages
                                    <span class="badge badge-light">12</span>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar"><img class="align-self-start mr-3" src="{{asset('assets/images/avatars/avatar-5.png')}}" alt="user avatar"></div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Jhon Deo</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                                <small>Today, 4:10 PM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar"><img class="align-self-start mr-3" src="{{asset('assets/images/avatars/avatar-6.png')}}" alt="user avatar"></div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Sara Jen</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                                <small>Yesterday, 8:30 AM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar"><img class="align-self-start mr-3" src="{{asset('assets/images/avatars/avatar-7.png')}}" alt="user avatar"></div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Dannish Josh</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                                <small>5/11/2018, 2:50 PM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <div class="avatar"><img class="align-self-start mr-3" src="{{asset('assets/images/avatars/avatar-8.png')}}" alt="user avatar"></div>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">Katrina Mccoy</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet.</p>
                                                <small>1/11/2018, 2:50 PM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item text-center"><a href="javaScript:void();">See All Messages</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                            <i class="fa fa-bell-o"></i><span class="badge badge-info badge-up">14</span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    You have 14 Notifications
                                    <span class="badge badge-info">14</span>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <i class="zmdi zmdi-accounts fa-2x mr-3 text-info"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">New Registered Users</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <i class="zmdi zmdi-coffee fa-2x mr-3 text-warning"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">New Received Orders</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <a href="javaScript:void();">
                                        <div class="media">
                                            <i class="zmdi zmdi-notifications-active fa-2x mr-3 text-danger"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 msg-title">New Updates</h6>
                                                <p class="msg-info">Lorem ipsum dolor sit amet...</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-group-item text-center"><a href="javaScript:void();">See All Notifications</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item language">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();"><i class="fa fa-flag"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-gb mr-2"></i> English</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-fr mr-2"></i> French</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-cn mr-2"></i> Chinese</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-de mr-2"></i> German</li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                            <span class="user-profile"><img src="{{asset(Auth::user()->image)}}" class="img-circle" alt="user avatar"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3" src="{{asset(Auth::user()->image)}}" alt="user avatar"></div>
                                        <div class="media-body">
                                            <h6 class="mt-2 user-title">@if (Auth::check()){{ Auth::user()->name }}@else Anyomous @endif</h6>
                                            <p class="user-subtitle">@if (Auth::check()){{ Auth::user()->email }}@else Anyomous @endif</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <!--End topbar header-->

        <div class="clearfix"></div>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @yield('content')
                    </div>
                </div>
                <!--start overlay-->
                <div class="overlay toggle-menu"></div>
                <!--end overlay-->
            </div>
            <!-- End container-fluid-->

        </div>
        <!--End content-wrapper-->
        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--Start footer-->
        <footer class="footer">
            <div class="container">
                <div class="text-center">
                    Copyright © 2018 Dashtreme Admin
                </div>
            </div>
        </footer>
        <!--End footer-->

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

    </div>
    <!--End wrapper-->
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
        @if(Session::has('success'))
        Command: toastr["success"]("{{Session::get('success')}}", "អបអរសាទរ!")
        @endif

        @if(Session::has('error'))
        Command: toastr["error"]("{{Session::get('error')}}", "សូមអភ័យទោស!")
        @endif

        @if(Session::has('info'))
        Command: toastr["info"]("{{Session::get('info')}}", "សូមអភ័យទោស!")
        @endif

        @if(Session::has('warning'))
        Command: toastr["warning"]("{{Session::get('warning')}}", "គណនីនេះ!")
        @endif
    </script>
    @yield('custom-script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.right-sidebar-content ul li ').on('click', function(e) {
            e.preventDefault();
            var name = $(this).attr('id');
            $.ajax({
                url: "/admin/theme/" + name,
                type: 'POST',
                dataType: 'json',
                success: function() {
                    console.log('good job');
                }
            });

        });
    </script>
</body>

<!-- Mirrored from codervent.com/dashtreme/demo/dashtreme-dark/pages-blank-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Dec 2019 10:02:53 GMT -->

</html>
