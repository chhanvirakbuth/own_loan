@extends('layouts.admin-menu')

@section('custom-css')
  {{-- jasny bootstrap --}}
  <link href="{{asset('assets/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">


@endsection

@section('content')
  <div class="card">
        <div class="card-body">
          <form id="signupForm" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <h4 class="form-header">
              <i class="zmdi zmdi-account-o"></i>
               គណនីលេខ {{$loans->account->account_no}}
            </h4>
            <h4 class="form-header">
              <i class="fa fa-address-book-o"></i>
               ព័ត៍មានទូទៅ
            </h4>
            <div class="form-group row">
              <label for="input-1" class="col-sm-2 col-form-label">ឈ្មោះពេញ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="input-1" name="full_name" placeholder="ជាអក្សរខ្មែរ"
                value="{{$loans->people->name_kh}}" disabled>
              </div>
              <label for="input-2" class="col-sm-2 col-form-label">ឈ្មោះឡាតាំង</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="latin_name" name="latin_name" placeholder="ជាអក្សរឡាតាំង"
                value="{{$loans->people->name_en}}" disabled>
              </div>
            </div>
            <div class="form-group row">
              <label for="input-3" class="col-sm-2 col-form-label">ឈ្មោះហៅក្រៅ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="input-3" name="nickname" placeholder="បើសិនជាមាន"
                value="{{$loans->people->nick_name}}" disabled>
              </div>
              <label for="input-4" class="col-sm-2 col-form-label">ភេទ</label>
                @if ($loans->people->gender->id == 1)
                  <div class="icheck-material-primary icheck-inline">
                  <input type="radio" id="inline-radio-primary" name="inlineradio" checked="" value="1">
                  <label for="inline-radio-primary">ប្រុស</label>
                  </div>
                  <div class="icheck-material-info icheck-inline">
                  <input type="radio" id="inline-radio-info" name="inlineradio" value="2" disabled>
                  <label for="inline-radio-info">ស្រី</label>
                  </div>
                @endif

                @if ($loans->people->gender->id == 2)
                  <div class="icheck-material-primary icheck-inline">
                  <input type="radio" id="inline-radio-primary" name="inlineradio"  value="1" disabled>
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
                    <select class="form-control" id="occupation" name="occupation" disabled>
                        <option value="default">--រើសមុខរបរ--</option>
                        <option selected value="{{$loans->people->occupation->id}}">{{$loans->people->occupation->name_kh}}</option>
                    </select>
                </div>
                <label for="input-6" class="col-sm-2 col-form-label">ថ្ងៃ ខែ ឆ្នាំកំណើត</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="birth_of_date" name="birth_of_date" placeholder="សូមជ្រើសរើស"
                    value="{{$loans->people->date_of_birth}}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="input-7" class="col-sm-2 col-form-label">អត្តសញ្ញាណប័ណ្ណលេខ</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="id_card_number" name="id_card_number" placeholder="អាចប្រើការបាន"
                    value="{{$loans->people->id_card_number}}" disabled>
                </div>
                <label for="input-8" class="col-sm-2 col-form-label">ស្ថានភាព</label>
                <div class="col-sm-4">
                    <select class="form-control" id="status" name="status" disabled>
                        <option value="default">--សូមជ្រើសរើសស្ថានភាព--</option>
                        <option selected value="{{$loans->people->status->id}}">{{$loans->people->status->name_kh}}</option>
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
                value="{{$loans->people->phone_no}}" disabled>
              </div>
              <label for="input-10" class="col-sm-2 col-form-label">អ៊ីម៉ែល</label>
              <div class="col-sm-4">
                <input type="email" class="form-control" id="email" name="email"
                value="{{$loans->people->email}}" disabled>
              </div>
            </div>

            <div class="form-group row">
                <label for="input-11" class="col-sm-2 col-form-label">នៅខេត្ត/ក្រុង</label>
                <div class="col-sm-4">
                    <select class="form-control" id="provinces" name="provinces" disabled>
                        <option  value="default">--រើសខេត្ត--</option>
                        <option selected value="{{$loans->people->province->id}}">{{$loans->people->province->name_kh}}</option>
                    </select>
                </div>
                <label for="input-12" class="col-sm-2 col-form-label">ស្រុក/ខណ្ឌ</label>
                <div class="col-sm-4">
                    <select class="form-control" id="districts" name="districts" disabled>
                      <option selected value="{{$loans->people->district->id}}">{{$loans->people->district->name_kh}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="input-13" class="col-sm-2 col-form-label">ឃុំ/សង្កាត់</label>
                <div class="col-sm-4">
                    <select class="form-control" id="communes" name="communes" disabled>
                      <option selected value="{{$loans->people->commune->id}}">{{$loans->people->commune->name_kh}}</option>
                    </select>
                </div>
                <label for="input-15" class="col-sm-2 col-form-label">ភូមិ</label>
                <div class="col-sm-4">
                    <select class="form-control" id="villages" name="villages" disabled>
                      <option selected value="{{$loans->people->village->id}}">{{$loans->people->village->name_kh}}</option>
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

                </div>
                </div>

                <label for="input-17" class="col-sm-2 col-form-label">រូបអត្តសញ្ញាណប័ណ្ណ</label>
                <div class="col-sm-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 250px; height: 200px;">
                            <img src="{{asset($loans->people->idcard)}}" alt="Photo">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>

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
                    <select class="form-control" id="loan_type" name="loan_type" disabled>
                        <option value="default">--រើសប្រភេទកម្ចី--</option>
                        <option selected value="{{$loans->account_type_item->id}}">{{$loans->account_type_item->name_kh}}</option>
                    </select>
                </div>
                <label for="input-19" class="col-sm-2 col-form-label">ការប្រាក់</label>
                <div class="col-sm-4">
                  <input type="text" name="percent_rate" id="percent_rate"  class="form-control" placeholder="គិតជា %" autocomplete="off"
                  value="{{$loans->interest_rate * 100}} %" disabled>

                </div>
            </div>

            <div class="form-group row">
                <label for="input-20" class="col-sm-2 col-form-label">ចំនួនប្រាក់កម្ចី</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" placeholder="1,000,000" name="begin_amount" id="begin_amount"
                    value="<?php echo number_format($loans->begin_amount)?> &#6107;" disabled>
                </div>
                <label for="input-21" class="col-sm-2 col-form-label">មូលហេតុការខ្ចី</label>
                <div class="col-sm-4">
                    <input type="text" name="reason" class="form-control" id="reason" placeholder="ខ្ចីយកទៅធ្វើអ្វី?"
                    value="{{$loans->people->reason->title}}" disabled>
                </div>
            </div>

            <div class="form-group row">
                <label for="input-22" class="col-sm-2 col-form-label">ខ្ចីនៅថ្ងៃ</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="start_at" name="start_at" placeholder="រើសថ្ងៃខ្ចី"
                    value="{{$loans->started_at}}" disabled>
                </div>
                <label for="input-23" class="col-sm-2 col-form-label">ប្រាក់នៅជំពាក់</label>
                <div class="col-sm-4">
                    <input type="text" disabled class="form-control" id="input-23" name="balance"
                    value="<?php echo number_format($loans->balance)?> &#6107;" disabled>
                </div>
            </div>

            <div class="form-footer​">
                <a href="{{route('admin.loan.index')}}" class="btn btn-light waves-effect waves-light mx-2"><i class="zmdi zmdi-long-arrow-return"></i> ថយក្រោយ</a>
                <a href="{{route('admin.loan.payment',['id'=>$loans->id])}}" class="btn btn-light waves-effect waves-light mx-2"><i class="zmdi zmdi-money"></i> បង់ការប្រាក់</a>
            </div>
          </form>
        </div>
      </div>
@endsection

@section('custom-script')

@endsection
