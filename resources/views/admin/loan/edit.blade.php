@extends('layouts.admin-menu')

@section('custom-css')
  {{-- jasny bootstrap --}}
  <link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">

  {{-- date picker (flatpickr) --}}
  <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

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
          <form id="EditForm" action="{{route('admin.loan.update',$loans->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- get user id --}}
            @if (Auth::check())
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @endif
            {{-- <input type="hidden" name="user_id" value="{{Auth::user()->id}}"> --}}
            <h4 class="form-header">
              <i class="fa fa-address-book-o"></i>
               ព័ត៍មានទូទៅ
            </h4>
            <div class="form-group row">
              <label for="input-1" class="col-sm-2 col-form-label">ឈ្មោះពេញ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="input-1" name="full_name" placeholder="ជាអក្សរខ្មែរ"
                value="{{$loans->people->name_kh}}" >
              </div>
              <label for="input-2" class="col-sm-2 col-form-label">ឈ្មោះឡាតាំង</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="latin_name" name="latin_name" placeholder="ជាអក្សរឡាតាំង"
                value="{{$loans->people->name_en}}" >
              </div>
            </div>
            <div class="form-group row">
              <label for="input-3" class="col-sm-2 col-form-label">ឈ្មោះហៅក្រៅ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="input-3" name="nickname" placeholder="បើសិនជាមាន"
                value="{{$loans->people->nick_name}}" >
              </div>
              <label for="input-4" class="col-sm-2 col-form-label">ភេទ</label>
                @if ($loans->people->gender->id == 1)
                  <div class="icheck-material-primary icheck-inline">
                  <input type="radio" id="inline-radio-primary" name="inlineradio" checked="" value="1">
                  <label for="inline-radio-primary">ប្រុស</label>
                  </div>
                  <div class="icheck-material-info icheck-inline">
                  <input type="radio" id="inline-radio-info" name="inlineradio" value="2" >
                  <label for="inline-radio-info">ស្រី</label>
                  </div>
                @endif

                @if ($loans->people->gender->id == 2)
                  <div class="icheck-material-primary icheck-inline">
                  <input type="radio" id="inline-radio-primary" name="inlineradio"  value="1" >
                  <label for="inline-radio-primary">ប្រុស</label>
                  </div>
                  <div class="icheck-material-info icheck-inline">
                  <input type="radio" id="inline-radio-info" name="inlineradio" checked="" value="2">
                  <label for="inline-radio-info">ស្រី</label>
                  </div>
                @endif
            </div>
            <div class="form-group row">
                <label for="input-5" class="col-sm-2 col-form-label">មុខរបរជា</label>
                <div class="col-sm-4">
                    <select class="form-control" id="occupation" name="occupation">
                        <option value="default">--រើសមុខរបរ--</option>
                        @foreach ($occupations as $key => $value)
                          {{-- <option selected value="{{$loans->people->occupation->id}}">{{$value->name_kh}}</option> --}}
                          <option value="{{$value->id}}" @if ($value->id == $loans->people->occupation->id )
                            selected
                          @endif>{{$value->name_kh}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="input-6" class="col-sm-2 col-form-label">ថ្ងៃ ខែ ឆ្នាំកំណើត</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="birth_of_date" name="birth_of_date" placeholder="សូមជ្រើសរើស"
                    value="{{$loans->people->date_of_birth}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="input-7" class="col-sm-2 col-form-label">អត្តសញ្ញាណប័ណ្ណលេខ</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="id_card_number" name="id_card_number" placeholder="អាចប្រើការបាន"
                    value="{{$loans->people->id_card_number}}">
                </div>
                <label for="input-8" class="col-sm-2 col-form-label">ស្ថានភាព</label>
                <div class="col-sm-4">
                    <select class="form-control" id="status" name="status">
                        <option value="default">--សូមជ្រើសរើសស្ថានភាព--</option>
                        {{-- <option selected value="{{$loans->people->status->id}}">{{$loans->people->status->name_kh}}</option> --}}
                        @foreach ($statuses as $key => $value)
                          <option value="{{$value->id}}" @if ($value->id == $loans->people->status->id)
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
                <input type="text" class="form-control" id="your_phone_number" name="your_phone_number"
                value="{{$loans->people->phone_no}}">
              </div>
              <label for="input-10" class="col-sm-2 col-form-label">អ៊ីម៉ែល</label>
              <div class="col-sm-4">
                <input type="email" class="form-control" id="email" name="email"
                value="{{$loans->people->email}}">
              </div>
            </div>

            <div class="form-group row">
                <label for="input-11" class="col-sm-2 col-form-label">នៅខេត្ត/ក្រុង</label>
                <div class="col-sm-4">
                    <select class="form-control" id="provinces" name="provinces">
                        <option  value="default">--រើសខេត្ត--</option>
                        {{-- <option value="{{$loans->people->province->id}}">{{$loans->people->province->name_kh}}</option> --}}
                        @foreach ($provinces as $key => $value)
                          <option value="{{$value->id}}" @if ($value->id == $loans->people->province->id)
                            selected
                          @endif>{{$value->name_kh}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="input-12" class="col-sm-2 col-form-label">ស្រុក/ខណ្ឌ</label>
                <div class="col-sm-4">
                    <select class="form-control" id="districts" name="districts">
                      {{-- <option selected value="{{$loans->people->district->id}}">{{$loans->people->district->name_kh}}</option> --}}
                      @foreach ($districts as $key => $value)
                        <option value="{{$value->id}}" @if ($value->id == $loans->people->district->id)
                          selected
                        @endif>{{$value->name_kh}}</option>
                      @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="input-13" class="col-sm-2 col-form-label">ឃុំ/សង្កាត់</label>
                <div class="col-sm-4">
                    <select class="form-control" id="communes" name="communes">
                      {{-- <option selected value="{{$loans->people->commune->id}}">{{$loans->people->commune->name_kh}}</option> --}}
                      @foreach ($communes as $key => $value)
                        <option value="{{$value->id}}" @if ($value->id == $loans->people->commune->id)
                          selected
                        @endif>{{$value->name_kh}}</option>
                      @endforeach
                    </select>
                </div>
                <label for="input-15" class="col-sm-2 col-form-label">ភូមិ</label>
                <div class="col-sm-4">
                    <select class="form-control" id="villages" name="villages">
                      {{-- <option selected value="{{$loans->people->village->id}}">{{$loans->people->village->name_kh}}</option> --}}
                      @foreach ($villages as $key => $value)
                        <option value="{{$value->id}}" @if ($value->id == $loans->people->village->id)
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
                    <div class="fileinput-new thumbnail" style="width: 250px; height: 200px;">
                        <img src="{{asset($loans->people->avatar)}}" alt="Photo">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                    <div class="text-center">
                        <span class="btn btn-light waves-effect waves-light btn-file"><span class="fileinput-new">រើសរូបភាព</span><span class="fileinput-exists">ប្ដូររូបភាព</span><input type="file" name="avatar"></span>
                        <a href="#" class="btn btn-light waves-effect waves-light fileinput-exists" data-dismiss="fileinput">លុបចេញ</a>
                    </div>
                </div>
                </div>

                <label for="input-17" class="col-sm-2 col-form-label">រូបអត្តសញ្ញាណប័ណ្ណ</label>
                <div class="col-sm-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 250px; height: 200px;">
                            <img src="{{asset($loans->people->idcard)}}" alt="Photo">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                        <div class="text-center">
                            <span class="btn btn-light waves-effect waves-light btn-file"><span class="fileinput-new">រើសរូបភាព</span><span class="fileinput-exists">ប្ដូររូបភាព</span><input type="file" name="id_card"></span>
                            <a href="#" class="btn btn-light waves-effect waves-light fileinput-exists" data-dismiss="fileinput">លុបចេញ</a>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="form-header">
            <i class="zmdi zmdi-comment-text"></i>
                ព័ត៍មានកម្ចី
            </h4>

            <div class="form-group row">
                <label for="input-18" class="col-sm-2 col-form-label">ប្រភេទកម្ចី</label>
                <div class="col-sm-4">
                    <select class="form-control" id="loan_type" name="loan_type">
                        <option value="default">--រើសប្រភេទកម្ចី--</option>
                        {{-- <option selected value="{{$loans->account_type_item->id}}">{{$loans->account_type_item->name_kh}}</option> --}}
                        @foreach ($account_type_items as $key => $value)
                          <option value="{{$value->id}}" @if ($value->id == $loans->account_type_item->id)
                            selected
                          @endif>{{$value->name_kh}}</option>
                        @endforeach
                    </select>
                </div>
                <label for="input-19" class="col-sm-2 col-form-label">ការប្រាក់</label>
                <div class="col-sm-4">
                  <input type="text" name="percent_rate" id="percent_rate"  class="form-control" placeholder="គិតជា %" autocomplete="off"
                  value="{{$loans->interest_rate}}" readonly>

                </div>
            </div>

            <div class="form-group row">
                <label for="input-20" class="col-sm-2 col-form-label">ចំនួនប្រាក់កម្ចី</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" placeholder="1,000,000" name="begin_amount" id="begin_amount"
                    value="{{$loans->begin_amount}}">
                </div>
                <label for="input-21" class="col-sm-2 col-form-label">មូលហេតុការខ្ចី</label>
                <div class="col-sm-4">
                    <input type="text" name="reason" class="form-control" id="reason" placeholder="ខ្ចីយកទៅធ្វើអ្វី?"
                    value="{{$loans->people->reason->title}}">
                </div>
            </div>

            <div class="form-group row">
                <label for="input-22" class="col-sm-2 col-form-label">ខ្ចីនៅថ្ងៃ</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="start_at" name="start_at" placeholder="រើសថ្ងៃខ្ចី"
                    value="{{$loans->started_at}}">
                </div>
                <label for="input-23" class="col-sm-2 col-form-label">ប្រាក់នៅជំពាក់</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="balance" name="balance"
                    value="{{$loans->balance}}" >
                </div>
            </div>
            <h4 class="form-header"></h4>
            <div class="form-footer​ py-3">
                <a href="{{route('admin.loan.index')}}" class="btn btn-light waves-effect waves-light mx-2"><i class="zmdi zmdi-long-arrow-return"></i> ថយក្រោយ</a>
                <button type="submit" class="btn btn-light waves-effect waves-light mx-2"><i class="zmdi zmdi-badge-check"></i> កែតម្រូវ</button>
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
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  {{-- autoNumeric //currency format --}}
  {{-- autoNumeric --}}
  <script src="https://cdn.jsdelivr.net/autonumeric/2.0.0/autoNumeric.min.js"></script>
  {{-- <script type="text/javascript">
    jQuery(function($) {
      $('#begin_amount').autoNumeric('init',{
          currencySymbol: "៛",
          currencySymbolPlacement: "s",
          unformatOnSubmit: true
      });

      $('#balance').autoNumeric({
        currencySymbol: "៛",
        currencySymbolPlacement: "s",
        unformatOnSubmit: true
      });

    });
  </script> --}}
@endsection
