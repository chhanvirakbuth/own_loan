@extends('layouts.admin-menu') @section('title') ផ្ទាំងព័ត៍មានរបស់កម្ចី @endsection @section('custom-css')
<link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">

<style media="screen">
    table thead tr th {
        font-family: 'Kantumruy', sans-serif;
    }

    table tbody tr td {
        font-family: 'Nokora', serif;
    }

    h5 {
        font-family: 'Dangrek', cursive;
    }

    .text-white {
        font-family: 'Kantumruy', sans-serif;
        font-weight: bold;
    }

    .text-footer {
        font-size: 10px;
    }
    .customer-img{
      width:50px;
      height: 50px;
      border-radius:50px;

    }
</style>
@endsection @section('content')
<div class="row mt-3">
    <div class="col-12 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <p class="text-white mb-0">ចំនួនអ្នកខ្ចី <span class="float-right badge badge-success"><a class="mx-1">សរុប</a></span></p>
                <div class="">
                    <h4 class="mb-0 py-3">{{number_format($loans->count())}} នាក់<span class="float-right"><i class="fa fa-users"></i></span></h4>
                </div>
                <div class="progress-wrapper">
                    <div class="progress" style="height:5px;">
                        <div class="progress-bar bg-success" style="width:100%"></div>
                    </div>
                </div>
                <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ជាចំនួនភាគរយ</a> <span class="float-right text text-success">100%<i class="fa fa-arrows-h"></i></span></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <p class="text-white mb-0">ចំនួនអ្នកខ្ចី <span class="float-right badge badge-success"><a class="mx-1">ខែនេះ</a></span></p>
                <div class="">
                    <h4 class="mb-0 py-3">{{number_format($monthly_loan->count())}} នាក់<span class="float-right"><i class="fa fa-user"></i></span></h4>
                </div>
                @if (count($last_month)>0)
                  @if ($monthly_loan->count()>$last_month->count())
                    <div class="progress-wrapper">
                        <div class="progress" style="height:5px;">
                          <?php
                          $old=$last_month->count();
                          $new=$monthly_loan->count();
                          $increase=(($new-$old) / $old) * 100;
                          echo "  <div class=\"progress-bar bg-success\" style=\"width:".$increase."%\"></div>";
                          ?>

                        </div>
                    </div>
                    <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ច្រើនជាងខែមុន</a><span class="float-right text-success">
                      <?php
                      $old=$last_month->count();
                      $new=$monthly_loan->count();
                      $increase=(($new-$old) / $old) * 100;
                      echo '+'.number_format($increase,2).'%';
                      ?>
                      <i class="fa fa-long-arrow-up"></i></span></p>
                  @else
                    <div class="progress-wrapper">
                        <div class="progress" style="height:5px;">
                          <?php
                          $old=$last_month->count();
                          $new=$monthly_loan->count();
                          $descrease=(($old-$new)/$old) * 100;
                          echo "  <div class=\"progress-bar bg-success\" style=\"width:".$descrease."%\"></div>";
                          ?>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">តិចជាងខែមុន</a><span class="float-right text-success">
                      <?php
                      $old=$last_month->count();
                      $new=$monthly_loan->count();
                      $descrease=(($old-$new)/$old) * 100;
                      echo '-'.number_format($descrease,2).'%';
                      ?><i class="fa fa-long-arrow-down"></i></span></p>
                  @endif
                @else
                  <div class="progress-wrapper">
                      <div class="progress" style="height:5px;">

                          <div class="progress-bar bg-success" style="width:100%"></div>
                      </div>
                  </div>
                  <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ជាចំនួនភាគរយ</a> <span class="float-right text-success">100% <i class="fa fa-arrows-h"></i></span></p>
                @endif

            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <p class="text-white mb-0">ចំនួនប្រាក់កម្ចី <span class="float-right badge badge-danger"><a class="mx-1">សរុប</a></span></p>
                <div class="">
                    <h4 class="mb-0 py-3">{{number_format($loans->sum('begin_amount'))}} ៛<span class="float-right"><i class="fa fa-money"></i></span></h4>
                </div>
                <div class="progress-wrapper">
                    <div class="progress" style="height:5px;">

                        <div class="progress-bar bg-danger" style="width:100%"></div>
                    </div>
                </div>
                <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ជាចំនួនភាគរយ</a> <span class="float-right text-danger">100% <i class="fa fa-arrows-h"></i></span></p>
            </div>
        </div>
    </div>

</div>
<!--end row-->

<div class="row mt-3">
    <div class="col-12 col-lg-6 col-xl-8">
        <div class="card">
            <div class="card-body" style="height:337px;">
                <div id="submitted-application"></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <p class="text-white mb-0">ចំនួនប្រាក់កម្ចី <span class="float-right badge badge-danger"><a class="mx-1">ខែនេះ</a></span></p>
                <div class="">
                    <h4 class="mb-0 py-3">{{number_format($monthly_loan->sum('begin_amount'))}} ៛ <span class="float-right"><i class="fa fa-money"></i></span></h4>
                </div>
                @if (count($last_month)>0)
                  @if ($monthly_loan->sum('begin_amount')>$last_month->sum('begin_amount'))
                    <div class="progress-wrapper">
                        <div class="progress" style="height:5px;">
                          <?php
                          $old=$last_month->sum('begin_amount');
                          $new=$monthly_loan->sum('begin_amount');
                          $increase=(($new-$old) / $old) * 100;
                          echo "  <div class=\"progress-bar bg-danger\" style=\"width:".$increase."%\"></div>";
                          ?>

                        </div>
                    </div>
                    <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ច្រើនជាងខែមុន</a><span class="float-right text-danger">
                      <?php
                      $old=$last_month->sum('begin_amount');
                      $new=$monthly_loan->sum('begin_amount');
                      $increase=(($new-$old) / $old) * 100;
                      echo '+'.number_format($increase,2).'%';
                      ?>
                      <i class="fa fa-long-arrow-up"></i></span></p>
                  @else
                    <div class="progress-wrapper">
                        <div class="progress" style="height:5px;">
                          <?php
                          $old=$last_month->sum('begin_amount');
                          $new=$monthly_loan->sum('begin_amount');
                          $descrease=(($old-$new)/$old) * 100;
                          echo "  <div class=\"progress-bar bg-danger\" style=\"width:".$descrease."%\"></div>";
                          ?>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">តិចជាងខែមុន</a><span class="float-right text-danger">
                      <?php
                      $old=$last_month->sum('begin_amount');
                      $new=$monthly_loan->sum('begin_amount');
                      $descrease=(($old-$new)/$old) * 100;
                      echo '-'.number_format($descrease,2).'%';
                      ?><i class="fa fa-long-arrow-down"></i></span></p>
                  @endif
                @else
                  <div class="progress-wrapper">
                      <div class="progress" style="height:5px;">
                          <div class="progress-bar bg-danger" style="width:100%"></div>
                      </div>
                  </div>
                  <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ច្រើនជាងខែមុន</a> <span class="float-right text-danger">100% <i class="fa fa-long-arrows-h"></i></span></p>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-white mb-0">ប្រាក់ទទួលបាន <span class="float-right badge badge-primary"><a class="mx-1">សរុប</a></span></p>
                <div class="">
                    <h4 class="mb-0 py-3">{{number_format($income->sum('amount'))}} ៛<span class="float-right"><i class="fa fa-money"></i></span></h4>
                </div>
                <div class="progress-wrapper">
                    <div class="progress" style="height:5px;">
                        <div class="progress-bar bg-primary" style="width:100%"></div>
                    </div>
                </div>
                <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ជាចំនួនភាគរយ</a> <span class="float-right text-primary">+100% <i class="fa fa-long-arrows-h"></i></span></p>
            </div>
        </div>

    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="card-header"><label>អ្នកខ្ខីច្រើនជាងគេ ៥នាក់</label>
                </div>

                <ul class="list-group list-group-flush">
                  @foreach ($top_loan as $key => $value)
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="{{asset($value->people->avatar)}}" alt="user avatar" class="customer-img center">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">{{$value->people->name_kh}}</h6>
                                <small class="small-font">{{number_format($value->begin_amount)}} <a>៛</a></small>
                            </div>
                        </div>
                    </li>
                  @endforeach
                </ul>
                <div class="card-footer text-center bg-transparent border-0">
                    <a href="javascript:void();">View all listings</a>
                </div>
            </div>
        </div>
    </div>

    {{-- secondary --}}
    <div class="col-12 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="card-header"><label>អ្នកខ្ខីតិចជាងគេ ៥នាក់</label>

                </div>

                <ul class="list-group list-group-flush">
                  @foreach ($bot_loan as $key => $value)
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <img src="{{asset($value->people->avatar)}}" alt="user avatar" class="customer-img center">
                            <div class="media-body ml-3">
                                <h6 class="mb-0">{{$value->people->name_kh}}</h6>
                                <small class="small-font">{{number_format($value->begin_amount)}} <a>៛</a></small>
                            </div>
                        </div>
                    </li>
                  @endforeach
                </ul>
                <div class="card-footer text-center bg-transparent border-0">
                    <a href="javascript:void();">View all listings</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <p class="text-white mb-0">ប្រាក់ទទួលបាន <span class="float-right badge badge-primary"><a class="mx-1">ខែនេះ</a></span></p>
                <div class="">
                    <h4 class="mb-0 py-3">{{number_format($now_payment->sum('amount'))}} ៛ <span class="float-right"><i class="fa fa-money"></i></span></h4>
                </div>
                @if (count($sub_payment)>0)
                  @if ($now_payment->sum('amount') > $sub_payment->sum('amount'))
                    <div class="progress-wrapper">
                        <div class="progress" style="height:5px;">
                          <?php
                            $old=$sub_payment->sum('amount');
                            $new=$now_payment->sum('amount');
                            $increase=(($new-$old) / $old) * 100;
                            echo "  <div class=\"progress-bar bg-primary\" style=\"width:".$increase."%\"></div>";
                          ?>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ច្រើនជាងខែមុន</a> <span class="float-right text-primary">+<?php
                    $old=$sub_payment->sum('amount');
                    $new=$now_payment->sum('amount');
                    $increase=(($new-$old) / $old) * 100;
                    echo number_format($increase,2);
                    ?>
                    % <i class="fa fa-long-arrow-up"></i></span></p>
                  @else
                    <div class="progress-wrapper">
                        <div class="progress" style="height:5px;">
                          <?php
                          $old=$sub_payment->sum('amount');
                          $new=$now_payment->sum('amount');
                          $descrease=(($old-$new)/$old) * 100;
                          echo "  <div class=\"progress-bar bg-primary\" style=\"width:".$descrease."%\"></div>";
                          ?>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">តិចជាងខែមុន</a><span class="float-right text-primary">
                      <?php
                      $old=$sub_payment->sum('amount');
                      $new=$now_payment->sum('amount');
                      $descrease=(($old-$new)/$old) * 100;
                      echo '-'.number_format($descrease,2).'%';
                      ?><i class="fa fa-long-arrow-down"></i></span></p>
                  @endif

                @else
                  <div class="progress-wrapper">
                      <div class="progress" style="height:5px;">
                          <div class="progress-bar bg-primary" style="width:100%"></div>
                      </div>
                  </div>
                  <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ច្រើនជាងខែមុន</a> <span class="float-right text-primary">100% <i class="fa fa-long-arrows-h"></i></span></p>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-white mb-0">ចំនួនប្រាក់កម្ចី <span class="float-right badge badge-warning"><a class="mx-1">សរុប</a></span></p>
                <div class="">
                    <h4 class="mb-0 py-3">92,403 <span class="float-right"><i class="fa fa-money"></i></span></h4>
                </div>
                <div class="progress-wrapper">
                    <div class="progress" style="height:5px;">
                        <div class="progress-bar bg-warning" style="width:60%"></div>
                    </div>
                </div>
                <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ជាចំនួនភាគរយ</a> <span class="float-right text-warning">+15% <i class="fa fa-long-arrow-up"></i></span></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <p class="text-white mb-0">ចំនួនប្រាក់កម្ចី <span class="float-right badge badge-warning"><a class="mx-1">សរុប</a></span></p>
                <div class="">
                    <h4 class="mb-0 py-3">92,403 <span class="float-right"><i class="fa fa-money"></i></span></h4>
                </div>
                <div class="progress-wrapper">
                    <div class="progress" style="height:5px;">
                        <div class="progress-bar bg-warning" style="width:60%"></div>
                    </div>
                </div>
                <p class="mb-0 mt-2 text-white small-font"><a class="text-footer">ជាចំនួនភាគរយ</a> <span class="float-right text-warning">+15% <i class="fa fa-long-arrow-up"></i></span></p>
            </div>
        </div>
    </div>
</div>
@endsection @section('custom-script')
<!-- Apex Chart JS -->
<script src="{{asset('assets/plugins/apexcharts/apexcharts.js')}}"></script>
<script src="{{asset('assets/js/dashboard-human-resources.js')}}"></script>
<!-- Easy Pie Chart JS -->
<script src="{{asset('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
<!-- Chart JS -->
<script src="{{asset('assets/plugins/Chart.js/Chart.min.js')}}"></script>

<!-- Custom scripts -->
<script src="{{asset('assets/js/dashboard-logistics.js')}}"></script>
<script type="text/javascript">
     var sites = {!! json_encode($loans->toArray()) !!};
     console.log(sites);
</script>
@endsection
