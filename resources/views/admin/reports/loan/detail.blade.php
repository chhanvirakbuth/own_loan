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
              <h5 class="card-title">ប្រវិត្តការបង់ប្រាក់របស់ <span class="text text-warning">{{$loan->people->name_kh}}</span></h5>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col" class="text text-left">ចំនួន</th>
                      <th scope="col" class="text text-left">ថ្ងៃបង់</th>
                      <th scope="col" class="text text-left">ប្រភេទ</th>
                      <th scope="col" class="text text-left">បង់ចំនួន</th>
                      <th scope="col" class="text text-left">បង់សរុប</th>
                      <th scope="col" class="text text-left">នៅជំពាក់</th>
                      <th scope="col" class="text text-left">អ្នកទទួល</th>

                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $i=1;
                    @endphp
                    @if (count($transactions)>0)
                      @foreach ($transactions as $key => $value)
                        <tr>
                          <td class="text text-left">លើកទី <?php echo $i;?></td>
                          <td class="text text-left">{{$khmer->getFullDay($value->payment_date).'-'.$khmer->getFullMonth($value->payment_date).'-'.$khmer->getFullYear($value->payment_date)}}</td>
                          <td class="text text-left">{{$value->payment_type}}</td>
                          <td class="text text-left">
                            @if ($value->payment_type_id == 1)
                              {{number_format($value->amount)}}
                            @else
                              {{number_format($value->begin_amount)}}
                            @endif
                           ៛</td>
                          <td class="text text-left">{{number_format($value->amount)}} ៛</td>
                          <td class="text text-left">{{number_format($value->balance)}} ៛</td>
                          <td class="text text-left text-uppercase">{{Auth::user($value->created_by)->name}}</td>
                        </tr>
                        @php
                          $i++;
                        @endphp
                      @endforeach
                    @else

                    @endif
                  </tbody>
                </table>

              </div>
            </div>
          </div>
@endsection

@section('custom-script')

@endsection
