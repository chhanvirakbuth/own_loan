@extends('layouts.admin-menu') @section('title') ប្រវិត្តការបង់ប្រាក់ @endsection @section('custom-css')
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
</style>
@endsection @section('content')
<h5 class="card-title btn btn-sm btn-info" onclick="history.back()" style="cursor:pointer;"><i class="fa fa-arrow-left"></i> ថយក្រោយ</h5>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">របាយការណ៍បង់ប្រាក់ </h5>
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
                    @php $i=1; @endphp @if (count($loans)>0) @foreach ($loans as $key => $value)
                    <tr>
                        <th scope="row" class="text text-center">
                            <?php echo $i;?>
                        </th>
                        <td class="text text-center">{{$value->people->name_kh}}</td>
                        <td class="text text-center">{{$value->people->gender->name_kh}}</td>
                        <td class="text text-center">{{$value->account->account_no}}</td>
                        <td class="text text-center"> <span class="badge badge-success">{{$value->n_of_paid_interest}}ដង</span></td>
                        <td class="text text-center">{!!$value->last_paid_interest_at!!}</td>
                        <td class="text text-center">
                            @if ($value->balance ==0)
                            <span class="badge badge-success">សងអស់</span> @else
                            <span class="badge badge-danger">នៅជំពាក់</span> @endif
                        </td>
                        <td>
                            <form class="" action="{{route('reports.loan.softDelete',$value->id)}}" method="post">
                                @csrf @method('DELETE')
                                <a href="{{route('reports.loan.detail',$value->id)}}" class="btn btn-info waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="លម្អិត"> <i class="zmdi zmdi-eye"></i></a>
                                <a href="#" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="tooltip" data-placement="top" title="បង់ការ"> <i class="zmdi zmdi-money"></i></a>
                                <button type="submit" name="button" class="btn btn-danger waves-effect waves-light btn-sm"><i class="zmdi zmdi-delete"data-toggle="tooltip" data-placement="top" title="លុប"></i></button>
                            </form>
                        </td>
                    </tr>
                    @php $i++; @endphp @endforeach @else
                    <tr>
                        <td colspan="8" class="text-center">គ្មានទិន្ន័យត្រូវបង្ហាញទេ!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection @section('custom-script') @endsection
