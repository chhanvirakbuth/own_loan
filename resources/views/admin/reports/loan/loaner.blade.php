@extends('layouts.admin-menu')
@section('title')
  អ្នកខ្ចីទាំងអស់
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
              <h5 class="card-title">អ្នកខ្ចីប្រាក់ទាំងអស់ សរុប {{count($loans)}}នាក់</h5>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col" class="text text-left">#</th>
                      <th scope="col" class="text text-left">ឈ្មោះ</th>
                      <th scope="col" class="text text-left">ខ្ចីចំនួន</th>
                      <th scope="col" class="text text-left">ថ្ងៃខ្ចី</th>
                      <th scope="col" class="text text-left">រូបភាព</th>
                      <th scope="col" class="text text-left">ស្ថានភាព</th>
                      <th scope="col" class="text text-left">អ្នកផ្ដល់កម្ចី</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $i=1;
                    @endphp
                    @if ($loans->count()>0)
                      @foreach ($loans as $key => $value)
                        <tr>
                          <td class="text text-left">{{$i}}</td>
                          <td class="text text-left">{{$value->people->name_kh}}
                            @if ($value->people->gender->id ==1)
                              ♂
                            @else
                              ♀
                            @endif
                          </td>
                          <td class="text text-left">{{number_format($value->begin_amount)}} ៛</td>
                          <td class="text text-left">{{$value->started_at}}</td>
                          <td>
                            <img style="max-width:35px; max-height:35px;" src="{{asset($value->people->avatar)}}" alt="">
                          </td>
                          <td class="text text-left">
                            @if ($value->balance == 0)
                              <span class="badge badge-success badge-pill">សងអស់</span>
                            @else
                              <span class="badge badge-warning badge-pill">នៅជំពាក់</span>
                            @endif
                          </td>
                          <td class="text text-left">{{Auth::user($value->created_by)->name}}</td>
                        </tr>
                      @php
                        $i++;
                      @endphp
                      @endforeach
                    @else
                      <td colspan="7" class="text-center">គ្មានទិន្ន័យត្រូវបង្ហាញទេ!</td>
                    @endif
                  </tbody>
                  @if (count($loans)>0)
                    {{ $loans->links() }}
                  @endif
                </table>

              </div>
            </div>
          </div>
@endsection

@section('custom-script')

@endsection
