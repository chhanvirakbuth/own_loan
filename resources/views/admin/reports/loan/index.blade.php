@extends('layouts.admin-menu')
@section('title')
  របាយការណ៍កម្ចីទាំងអស់
@endsection
@section('custom-css')
  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">

  <style media="screen">
    table thead tr th{
        font-family: 'Kantumruy', sans-serif;
    }

    table tbody tr td{
      font-family: 'Nokora', serif;
    }

    h5{
      font-family: 'Dangrek', cursive;
    }
  </style>
@endsection

@section('content')
  <div class="card">
            <div class="card-body">
              <h5 class="card-title">របាយការណ៍កម្ចីទាំងអស់ </h5>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col" class="text text-center">ល.រ</th>
                      <th scope="col" class="text text-center">ឈ្មោះ</th>
                      <th scope="col" class="text text-center">ភេទ</th>
                      <th scope="col" class="text text-center">លេខគណនី</th>
                      <th scope="col" class="text text-center">បង់បាន</th>
                      <th scope="col" class="text text-center">បង់ចុងក្រោយ</th>
                      <th scope="col" class="text text-center">ស្ថានភាព</th>
                      <th scope="col" class="text text-center">ផ្សេងៗ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $i=1;
                    @endphp
                    @if (count($loans)>0)
                      @foreach ($loans as $key => $value)
                        <tr>
                            <th scope="row" class="text text-center"><?php echo $i;?></th>
                            <td class="text text-center">{{$value->people->name_kh}}</td>
                            <td class="text text-center">{{$value->people->gender->name_kh}}</td>
                            <td class="text text-center">{{$value->account->account_no}}</td>
                            <td class="text text-center">{{$value->n_of_paid_interest}} ដង</td>
                            <td class="text text-center">{{$khmer->getFullDay($value->last_paid_interest_at).'-'.$khmer->getFullMonth($value->last_paid_interest_at).'-'.$khmer->getFullYear($value->last_paid_interest_at)}}</td>
                            <td class="text text-center">
                            @if ($value->balance ==0)
                              <span class="badge badge-success">សងរួចអស់</span>
                            @else
                              <span class="badge badge-danger">នៅជំពាក់</span>
                            @endif</td>
                            <td>
                              <form class="text text-center" action="#" method="post">
                                <a href="{{route('reports.loan.detail',$value->id)}}" class="btn btn-light btn-sm waves-effect waves-light m-1 " data-toggle="tooltip" data-placement="top" title="លម្អិត" > <i class="zmdi zmdi-eye"></i></a>
                                <a href="#" class="btn btn-light btn-sm waves-effect waves-light m-1 " data-toggle="tooltip" data-placement="top" title="បង់ការ"> <i class="zmdi zmdi-money"></i></a>
                                <a href="#" class="btn btn-light btn-sm waves-effect waves-light m-1 " data-toggle="tooltip" data-placement="top" title="លុប"> <i class="zmdi zmdi-window-minimize"></i></a>
                              </form>
                            </td>
                        </tr>
                        @php
                          $i++;
                        @endphp
                      @endforeach
                    @else
                    <tr>
                      <td colspan="8" class="text-center">គ្មានទិន្ន័យត្រូវបង្ហាញទេ!</td>
                    </tr>
                    @endif
                  </tbody>
                </table>

              </div>
            </div>
          </div>
@endsection

@section('custom-script')

@endsection
