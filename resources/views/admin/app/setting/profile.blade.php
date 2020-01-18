@extends('layouts.admin-menu')
@section('title')
  ប្រូហ្វាល
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
      <form id="profileForm" action="{{route('admin.profile.post')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <h4 class="form-header">
          <i class="fa fa-user"></i>
           ប្រូហ្វាល
        </h4>
        <div class="row">
          <div class="col-sm-4">
            <div class="fileinput fileinput-new mx-5" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                  <img src="{{asset($user->image) ?? 'http://placehold.it/150x150'}}" alt="Photo" style="display: block;
                    margin-left: auto;
                    margin-right: auto;
                    width: 100%;">

                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 280px; max-height: 150px; border-radius: 50%;"></div>
                <div class="text-center">
                    <span  class="btn btn-light waves-effect waves-light btn-file"><span class="fileinput-new"><a>រើសរូបភាព</a></span><span class="fileinput-exists"><a>ប្ដូររូបភាព</a></span><input type="file" name="images"></span>
                    <a href="#" class="btn btn-light waves-effect waves-light fileinput-exists" data-dismiss="fileinput">លុបចេញ</a>
                </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
            <label for="input-1">ឈ្មោះពេញ</label>
            <input type="text" class="form-control" name="full_name" id="input-1" value="{{$user->name}}" placeholder="បញ្ចូលឈ្មោះរបស់អ្នក">
           </div>
           <div class="form-group">
           <label for="input-1">អ៊ីម៉ែល</label>
           <input type="email" class="form-control" name="email" id="input-1" value="{{$user->email}}" placeholder="បញ្ចូលអ៊ីម៉ែលរបស់អ្នក">
          </div>
          <button type="button" id="button_password" class="btn btn-light waves-effect waves-light my-2" name="button">ប្ដូរពាក្យសម្ងាត់</button>
          <div class="password_toggle" id="password_toggle" style="display:none;">
            <div class="form-group mt-2">
              <div class="position-relative has-icon-right">
                <input type="password" class="form-control" name="old_password" id="input-1" placeholder="ពាក្យសម្ងាត់ចាស់" autocomplete="current-password">
                <div class="form-control-position">
      					  <i toggle="#password-field" class="fa fa-fw fa-eye toggle-password" style="cursor:pointer"></i>
      				  </div>
              </div>
           </div>

           <div class="form-group">
             <div class="position-relative has-icon-right">
               <input type="password" class="form-control" name="new_password" id="input-1"  placeholder="ពាក្យសម្ងាត់ថ្មី" autocomplete="current-password">
               <div class="form-control-position">
     					  <i toggle="#password-field" class="fa fa-fw fa-eye toggle-password" style="cursor:pointer"></i>
     				  </div>
             </div>
          </div>

          <div class="form-group">
          <div class="position-relative has-icon-right">
            <input type="password" class="form-control" id="input-1" name="confirm_new"  placeholder="បញ្ជាក់ពាក្យសម្ងាត់ថ្មី" autocomplete="current-password">
            <div class="form-control-position">
  					  <i toggle="#password-field" class="fa fa-fw fa-eye toggle-password" style="cursor:pointer"></i>
  				  </div>
          </div>
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
  <script type="text/javascript">
      $("#button_password").click(function(){
          $("#password_toggle").toggle();
      });
  </script>
@endsection
