@extends('layouts.admin-menu')
@section('title')
  ការកំណត់
@endsection
@section('custom-css')
  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">
  {{-- jasny bootstrap --}}
  <link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
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

      {{-- show validation error --}}
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      {{-- end --}}
      <form id="settingForm" action="{{route('admin.setting.update',$theme->id)}}" method="POST" enctype="multipart/form-data">
        @csrf

        <h4 class="form-header">
          <i class="zmdi zmdi-settings"></i>
           កំណត់កម្មវិធី
        </h4>
        <div class="form-group row">
          <label for="input-1" class="col-sm-2 col-form-label">ឈ្មោះកម្មវិធី</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="input-1" name="brand" @if ($theme->brand !=null)
              value="{{$theme->brand}}"
            @else
              value=""
            @endif>
          </div>
        </div>

        <div class="form-group row">
            <label for="input-16" class="col-sm-2 col-form-label">រូបតំណាង</label>
            <div class="col-sm-4">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 100%; height: 100px;">
                    <img src="{{asset($theme->logo)}}" alt="Photo">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100%; max-height: 100%;"></div>
                <div class="text-center">
                    <span class="btn btn-light waves-effect waves-light btn-file"><span class="fileinput-new"><a>រើសរូបភាព</a></span><span class="fileinput-exists"><a>ប្ដូររូបភាព</a></span><input type="file" name="logo"></span>
                    <a href="#" class="btn btn-light waves-effect waves-light fileinput-exists" data-dismiss="fileinput">លុបចេញ</a>
                </div>
            </div>
            </div>

        </div>


        <div class="form-footer​">
          <a onclick="history.back();" class="btn btn-light waves-effect waves-light mx-2"><i class="zmdi zmdi-undo"></i> ថយក្រោយ</a>
            <button type="submit" class="btn btn-light waves-effect waves-light mx-2"><i class="fa fa-check-square-o"></i> រក្សាទុក</button>
        </div>
      </form>

    </div>
  </div>
@endsection

@section('custom-script')
  {{-- jasny javascript --}}
  <script src="{{asset('assets/js/jasny-bootstrap.min.js')}}"></script>

  {{-- ajax select optoin --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <!--Form Validatin Script-->
  <script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>

  <script type="text/javascript">
  $("#settingForm").validate({
      rules: {
          brand:{
            required:true,
            maxlength:20,
          }


      },
      messages: {
          brand:{
            required:"សូមបញ្ចូលឈ្មោះកម្មវិធី",
            maxlength:"អក្សរត្រូវតិចជាងឬស្មើ២០"
          }

      }
  });

  </script>
@endsection
