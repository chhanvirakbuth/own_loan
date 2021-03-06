@extends('layouts.admin-menu')
@section('title')
  កែ- {{$deposit->people->name_kh}}
@endsection
@section('custom-css')
  {{-- jasny bootstrap --}}
  <link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">

  {{-- date picker (flatpickr) --}}
  <link rel="stylesheet" href="{{asset('assets/css/flatpickr.dark.css')}}">
  {{-- cleave js --}}
  <script src="{{asset('assets/js/cleave.min.js')}}" charset="utf-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.3/addons/cleave-phone.kh.js"></script>
  <!-- ...AutoNumeric :-->
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.1.0"></script>
<style media="screen">
  .image_center{
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
  }
</style>
@endsection

@section('content')
  <a onclick="history.back()" class="btn btn-sm btn-info mb-3" style="cursor:pointer;"><i class="fa fa-mail-reply"></i> ថយក្រោយ</a>
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
          <form id="signupForm" action="{{route('deposit.update',$deposit->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h4 class="form-header">
              <i class="fa fa-address-book-o"></i>
               ព័ត៍មានទូទៅ
            </h4>
            <div class="form-group row">
              <label for="input-1" class="col-sm-2 col-form-label">ឈ្មោះពេញ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="input-1" name="full_name" placeholder="ជាអក្សរខ្មែរ"
                value="{{$deposit->people->name_kh}}" autocomplete="off">
              </div>
              <label for="input-2" class="col-sm-2 col-form-label">ឈ្មោះឡាតាំង</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="latin_name" name="latin_name" placeholder="ជាអក្សរឡាតាំង"
                value="{{$deposit->people->name_en}}"  autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label for="input-3" class="col-sm-2 col-form-label">ឈ្មោះហៅក្រៅ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="input-3" name="nickname" placeholder="បើសិនជាមាន"
                value="{{$deposit->people->nick_name}}" autocomplete="off" >
              </div>
              <label for="input-4" class="col-sm-2 col-form-label">ភេទ</label>
                @if ($deposit->people->gender_id == 1)
                  <div class="icheck-material-primary icheck-inline">
                  <input type="radio" id="inline-radio-primary" name="inlineradio" checked="" value="1">
                  <label for="inline-radio-primary">ប្រុស</label>
                  </div>
                  <div class="icheck-material-info icheck-inline">
                  <input type="radio" id="inline-radio-info" name="inlineradio" value="2" >
                  <label for="inline-radio-info">ស្រី</label>
                  </div>
                @else
                  <div class="icheck-material-primary icheck-inline">
                  <input type="radio" id="inline-radio-primary" name="inlineradio"  value="1" >
                  <label for="inline-radio-primary">ប្រុស</label>
                  </div>
                  <div class="icheck-material-info icheck-inline">
                  <input type="radio" id="inline-radio-info" name="inlineradio"checked="" value="2">
                  <label for="inline-radio-info">ស្រី</label>
                  </div>
                @endif
            </div>
            <div class="form-group row">
                <label for="input-5" class="col-sm-2 col-form-label">មុខរបរជា</label>
                <div class="col-sm-4">
                    <select class="form-control" id="occupation" name="occupation" >
                        <option value="default">--រើសមុខរបរ--</option>
                        @foreach ($occupations as $key => $value)
                          <option value="{{$value->id}}" @if ($value->id == $deposit->people->occupation->id )
                            selected
                          @endif>{{$value->name_kh}}</option>
                        @endforeach

                    </select>
                </div>
                <label for="input-6" class="col-sm-2 col-form-label">ថ្ងៃ ខែ ឆ្នាំកំណើត</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="birth_of_date" name="birth_of_date" placeholder="សូមជ្រើសរើស"
                    value="{{$deposit->people->date_of_birth}}" >
                </div>
            </div>
            <div class="form-group row">
                <label for="input-7" class="col-sm-2 col-form-label">អត្តសញ្ញាណប័ណ្ណលេខ</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control id_card_number" id="id_card_number" name="id_card_number" placeholder="អាចប្រើការបាន"
                    autocomplete="off" value="{{$deposit->people->id_card_number}}"  autocomplete="off">
                </div>
                <label for="input-8" class="col-sm-2 col-form-label">ស្ថានភាព</label>
                <div class="col-sm-4">
                    <select class="form-control" id="status" name="status" >
                        <option value="default">--សូមជ្រើសរើសស្ថានភាព--</option>
                        @foreach ($statuses as $key => $value)
                          <option value="{{$value->id}}" @if ($value->id == $deposit->people->status->id)
                            selected
                          @endif>{{$value->name_kh}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <h4 class="form-header">
            <i class="zmdi zmdi-phone-msg"></i>
              ទំនាក់ទំនង
            </h4>

            <div class="form-group row">
              <label for="input-9" class="col-sm-2 col-form-label">លេខទូរស័ព្ទផ្ទាល់ខ្លួន</label>
              <div class="col-sm-4">
                <input type="text" class="form-control input-phone" id="your_phone_number" name="your_phone_number"
                value="{{$deposit->people->phone_no}}"  autocomplete="off">
              </div>
              <label for="input-10" class="col-sm-2 col-form-label">អ៊ីម៉ែល</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="email" name="email" value="{{$deposit->people->email}}"  autocomplete="off">
              </div>
            </div>

            <div class="form-group row">
                <label for="input-11" class="col-sm-2 col-form-label">នៅខេត្ត/ក្រុង</label>
                <div class="col-sm-4">
                    <select class="form-control" id="provinces" name="provinces" >
                        <option  value="default">--រើសខេត្ត--</option>
                        @foreach ($provinces as $key => $value)
                          <option value="{{$value->id}}" @if ($value->id == $deposit->people->province->id)
                            selected
                          @endif>{{$value->name_kh}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="input-12" class="col-sm-2 col-form-label">ស្រុក/ខណ្ឌ</label>
                <div class="col-sm-4">
                    <select class="form-control" id="districts" name="districts" >
                      @foreach ($districts as $key => $value)
                        <option value="{{$value->id}}" @if ($value->id == $deposit->people->district->id)
                          selected
                        @endif>{{$value->name_kh}}</option>
                      @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="input-13" class="col-sm-2 col-form-label">ឃុំ/សង្កាត់</label>
                <div class="col-sm-4">
                    <select class="form-control" id="communes" name="communes" >
                      @foreach ($communes as $key => $value)
                        <option value="{{$value->id}}" @if ($value->id == $deposit->people->commune->id)
                          selected
                        @endif>{{$value->name_kh}}</option>
                      @endforeach
                    </select>
                </div>
                <label for="input-15" class="col-sm-2 col-form-label">ភូមិ</label>
                <div class="col-sm-4">
                    <select class="form-control" id="villages" name="villages" >
                      @foreach ($villages as $key => $value)
                        <option value="{{$value->id}}" @if ($value->id == $deposit->people->village->id)
                          selected
                        @endif>{{$value->name_kh}}</option>
                      @endforeach
                    </select>
                </div>
            </div>

            <h4 class="form-header">
            <i class="zmdi zmdi-folder-person"></i>
                រូបភាពឯកសារ
            </h4>

            <div class="form-group row">
                <label for="input-16" class="col-sm-2 col-form-label">រូបបុគ្គលអ្នកខ្ចី</label>
                <div class="col-sm-4">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 100%; height: 150px;">
                        <img src="{{asset($deposit->people->avatar)}}" alt="Photo">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 100%; max-height: 100%;"></div>
                    <div class="text-center">
                        <span class="btn btn-light waves-effect waves-light btn-file"><span class="fileinput-new"><a>រើសរូបភាព</a></span><span class="fileinput-exists"><a>ប្ដូររូបភាព</a></span><input type="file" name="avatar"></span>
                        <a href="#" class="btn btn-light waves-effect waves-light fileinput-exists" data-dismiss="fileinput">លុបចេញ</a>
                    </div>
                </div>
                </div>

                <label for="input-17" class="col-sm-2 col-form-label">រូបអត្តសញ្ញាណប័ណ្ណ</label>
                <div class="col-sm-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 280px; height: 150px;">
                            <img src="{{asset($deposit->people->idcard)}}" alt="Photo">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 280px; max-height: 150px;"></div>
                        <div class="text-center">
                            <span class="btn btn-light waves-effect waves-light btn-file"><span class="fileinput-new"><a>រើសរូបភាព</a></span><span class="fileinput-exists"><a>ប្ដូររូបភាព</a></span><input type="file" name="id_card"></span>
                            <a href="#" class="btn btn-light waves-effect waves-light fileinput-exists" data-dismiss="fileinput">លុបចេញ</a>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="form-header">
            <i class="zmdi zmdi-comment-text"></i>
                ព័ត៍មានសន្សំ
            </h4>

            <div class="form-group row">
                <label for="input-18" class="col-sm-2 col-form-label">ប្រភេទសន្សំ</label>
                <div class="col-sm-4">
                    <select class="form-control" id="loan_type" name="loan_type" >
                        <option value="default">--រើសប្រភេទសន្សំ--</option>
                        @foreach ($account_type_items as $key => $value)
                          <option value="{{$value->id}}" @if ($value->id == $deposit->account_type_item->id)
                            selected
                          @endif>{{$value->name_kh}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="input-19" class="col-sm-2 col-form-label">ការប្រាក់</label>
                <div class="col-sm-4">
                  <input type="text" name="percent_rate" id="percent_rate" class="form-control" placeholder="គិតជា %" autocomplete="off"
                  value="{{$deposit->interest_rate * 100}} %" disabled>

                </div>
            </div>

            <div class="form-group row">
                <label for="input-20" class="col-sm-2 col-form-label">ចំនួនប្រាក់សន្សំ</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control myInput" placeholder="1,000,000" name="begin_amount" id="begin_amount"
                    value="{{$deposit->balance}}"  autocomplete="off">
                </div>
                <label for="input-22" class="col-sm-2 col-form-label">ថ្ងៃសន្សំ</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="start_at" name="start_at" placeholder="រើសថ្ងៃខ្ចី"
                    value="{{$deposit->started_at}}" >
                </div>
            </div>



            <div class="form-footer​">
                <a onclick="history.back();" class="btn btn-light waves-effect waves-light mx-2"><i class="zmdi zmdi-arrow-left"></i> ថយក្រោយ</a>
                <button type="submit" class="btn btn-success  waves-effect waves-light mx-2" name="button">ស្នើសុំកែប្រែ <i class="zmdi zmdi-arrow-right"></i></button>
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

    <script src="{{asset('assets/js/custom-create-loan-script.js')}}" charset="utf-8"></script>

    {{-- date picker --}}
      <script src="{{asset('assets/js/flatpickr.js')}}" charset="utf-8"></script>

      {{-- cleave --}}
      <script>
        var cleave = new Cleave('.input-phone', {
          phone: true,
          phoneRegionCode: 'KH'
        });


        var cleave = new Cleave('.id_card_number', {
            blocks: [3, 3, 3],
            uppercase: true
        });
      </script>
      <script>
        new AutoNumeric('.myInput', {
          decimalPlaces: 0,
          currencySymbol: "៛",
          currencySymbolPlacement: "s",
          unformatOnSubmit: true

         });
      </script>
@endsection
