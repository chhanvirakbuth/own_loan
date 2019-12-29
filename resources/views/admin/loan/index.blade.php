@extends('layouts.admin-menu')

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
              <h5 class="card-title">កម្ចីខែនេះ</h5>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">ឈ្មោះ</th>
                      <th scope="col">ភេទ</th>
                      <th scope="col">លេខគណនី</th>
                      <th scope="col">ប្រាក់កម្ចី</th>
                      <th scope="col">ប្រាក់ជំពាក់</th>
                      <th scope="col">ស្ថានភាព</th>
                      <th scope="col">ផ្សេងៗ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $i=1;
                    @endphp
                    @if (count($loans)>0)
                      @foreach ($loans as $loan)
                      <tr>
                          <th scope="row"><?php echo $i;?></th>
                          <td>{{$loan->people->name_kh}}</td>
                          <td>{{$loan->people->gender->name_kh}}</td>
                          <td>{{$loan->account->account_no}}</td>
                          <td id="money">{{$loan->begin_amount}} <span>&#6107;</span></td>
                          <td id="money">{{$loan->balance}} <span>&#6107;</span></td>
                          <td>{!! $loan->status !!}</td>
                          <td>
                            <form class="" action="#" method="post">
                              <a href="{{route('admin.loan.show',['id'=> $loan->id])}}" class="btn btn-light btn-sm waves-effect waves-light m-1 " data-toggle="tooltip" data-placement="top" title="លម្អិត" > <i class="zmdi zmdi-eye"></i></a>
                              <a href="{{route('admin.loan.payment',['id'=>$loan->id])}}" class="btn btn-light btn-sm waves-effect waves-light m-1 " data-toggle="tooltip" data-placement="top" title="បង់ការ"> <i class="zmdi zmdi-money"></i></a>
                              <button type="button" class="btn btn-light btn-sm waves-effect waves-light m-1 " data-toggle="tooltip" data-placement="top" title="កែប្រែ"> <i class="zmdi zmdi-edit"></i></button>
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
                  @if (count($loans)>0)
                    {{ $loans->links() }}
                  @endif
              </div>
            </div>
          </div>
@endsection

@section('custom-script')
  {{-- currency format comma --}}
  <script type="text/javascript">
    $.fn.digits = function(){
      return this.each(function(){
          $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
      })
    }

    $(" table tbody tr td#money").digits();
  </script>
@endsection
