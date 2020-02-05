@extends('layouts.admin-menu')
@section('title')
  បង់ការប្រាក់
@endsection
@section('custom-css')

  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">
  {{-- cleave js --}}
  <script src="{{asset('assets/js/cleave.min.js')}}" charset="utf-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.3/addons/cleave-phone.kh.js"></script>
  <!-- ...AutoNumeric :-->
  <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.1.0"></script>
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
          <div class="card-title">គណនីរបស់ <span class="customer-name text text-warning">{{$loans->people->name_kh}}</span> 🤑 </div>
				   <hr>
				    <form id="PaymentForm" method="post" action="{{route('admin.loan.payment-update',$loans->id)}}">
              @csrf
              @method('PUT')

					 <div class="form-group row">
					  <label for="input-21" class="col-sm-2 col-form-label">លេខគណនី</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="account_no" disabled
            value="{{$loans->account->account_no}}">
					  </div>
					</div>
					<div class="form-group row">
					  <label for="input-22" class="col-sm-2 col-form-label">ប្រភេទនៃការបង់</label>
					  <div class="col-sm-10">
              <select class="form-control payment_type" id="type_loan" name="payment_type">
                <option value="default">សូមជ្រើសរើស</option>
                @if (count($payment_types)>0)
                  @foreach ($payment_types as $payment_type)
                    {{-- select on default payment type call បង់ការ --}}
                    <option value="{{$payment_type->id}}"
                      @if ($payment_type->id ==1)
                        selected
                      @endif >
                      {{$payment_type->name_kh}}
                    </option>
                  @endforeach
                @else
                  <option>មិនដឺងបង់អីទេ 🤒</option>
                @endif

              </select>
					  </div>
					</div>
					  <div class="form-group row">
						<label for="input-23" class="col-sm-2 col-form-label">ប្រាក់នៅជំពាក់</label>
						<div class="col-sm-10 amount">
						<input type="text" class="form-control main_amount" name="main_amount" id="main_amount" class="main_amount"
            value="{{$loans->balance}}" disabled>
            <input type="hidden" name="hidden_main_amount" class="hidden_main_amount" id="hidden_main_amount" value="{{$loans->balance}}">
						</div>
					  </div>
					<div class="form-group row">
					  <label for="input-24" class="col-sm-2 col-form-label">ការប្រាក់ &#37;</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="payment_rate" name="payment_rate"
            value="{{$loans->interest_rate *100 .'%'}}" readonly>
					  </div>
					</div>
					<div class="form-group row">
						<label for="input-25" class="col-sm-2 col-form-label">ការប្រាក់ត្រូវបង់</label>
						<div class="col-sm-10">
						<input type="text" class="form-control rate_amount" id="rate_amount" name="rate_amount"
            value="{{$loans->balance * $loans->interest_rate}}" readonly>
            <input type="hidden" name="hidden_rate_amount" id="hidden_rate_amount" class="hidden_rate_amount" value="{{$loans->balance * $loans->interest_rate}}">
						</div>
					 </div>
           <div class="form-group row">
 						<label for="input-26" class="col-sm-2 col-form-label">បង់រំលោះចំនួន</label>
 						<div class="col-sm-10">
 						<input type="text" class="form-control redeem_amount" id="redeem_amount" name="redeem_amount"​ autocomplete="off">
            <input type="hidden" name="hidden_redeem_amount" id="hidden_redeem_amount" class="hidden_redeem_amount" >
 						</div>
 					 </div>
          <div class="form-group row">
						<label for="input-27" class="col-sm-2 col-form-label">ប្រាក់សរុបត្រួវបង់</label>
						<div class="col-sm-10">
						<input type="text" class="form-control total_amount" id="total_amount" name="total_amount"
            value="{{$loans->balance * $loans->interest_rate}}" readonly>
						</div>
					 </div>

					 <div class="form-group row">
					  <label class="col-sm-2 col-form-label"></label>
					  <div class="col-sm-10">
						<button type="button" onclick="history.back();" class="btn btn-light waves-effect waves-light px-3 mx-2"><i class="zmdi zmdi-long-arrow-return"></i> ថយក្រោយ</button>
            <button type="submit" class="btn btn-light waves-effect waves-light px-3 mx-2"><i class="zmdi zmdi-check"></i> បង់ប្រាក់</button>
            {{-- <button type="button" name="button" id="test_button">Test ME</button> --}}
            </div>
					</div>
					</form>
        </div>
      </div>
@endsection

@section('custom-script')
  {{-- ajax select optoin --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <!--Form Validatin Script-->
  <script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
  {{-- accounting.js --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.4.1/accounting.min.js"></script>
  <script>
  // custom validator
  $.validator.addMethod("valueNotEquals", function(value, element, arg){
   return arg !== value;
  }, "Value must not equal arg.");
  // custom validator

    // end custom validator
  $("#PaymentForm").validate({
    rules: {
        payment_type:{
          valueNotEquals: "default"
        },

      },
      messages: {
        payment_type:{
          valueNotEquals: "សូមជ្រើសរើសប្រភេទកម្ចី"
        },
      }
    });
  </script>

  <script type="text/javascript">




  </script>

  {{-- custom number format --}}
  <script type="text/javascript">
    $(document).ready(function(){
      // part one
      $('.redeem_amount').prop("disabled", true);

      var cleave = new Cleave('#account_no', {
          blocks: [3, 2, 3],
          uppercase: true
      });

      $('#type_loan').on('change',function(){
        // if monthly paid
        if($(this).val()==1){
          $('.redeem_amount').prop("disabled", true);
          var rate=Number($('#hidden_rate_amount').val());
          var total=accounting.formatNumber(rate);
          $('#redeem_amount').val("");
          $('#total_amount').val(total + ' ៛');
        }
        // if change to redeem
        if($(this).val()==3){
          $('.redeem_amount').prop("disabled", false);
          $('.redeem_amount').val('');
          $('.redeem_amount').focus();
          var rate=Number($('#hidden_rate_amount').val());
          var total=accounting.formatNumber(rate);
          $('#total_amount').val(total + ' ៛');
        }

        // if change to pay off
        if($(this).val()==4){ //mean that it was pay off
          $('.redeem_amount').prop("disabled", true);
          $('.redeem_amount').val($('.main_amount').val());
          var rate=Number($('#hidden_rate_amount').val());
          var main=Number($('#hidden_main_amount').val());
          var total=accounting.formatNumber(rate + main);
          $('#total_amount').val(total + ' ៛');
        }
      });


      // part two
      var main_amount=accounting.formatNumber($('.main_amount').val());
      var rate_amount=accounting.formatNumber($('.rate_amount').val());
      var total_amount=accounting.formatNumber($('.total_amount').val());
      $('#main_amount').val(main_amount);
      $('#rate_amount').val(rate_amount);
      $('#total_amount').val(total_amount);

      $('#main_amount').val($('#main_amount').val() + ' ៛');
      $('#rate_amount').val($('#rate_amount').val() + ' ៛');
      $('#total_amount').val($('#total_amount').val() + ' ៛');

      new AutoNumeric('.redeem_amount', {
        decimalPlaces: 0,
        currencySymbol: " ៛",
        currencySymbolPlacement: "s",

      });
      // on keyup redeem_amount
      $('.redeem_amount').on('keyup',function(){
        var value=$(this).val();
        var unformat=accounting.unformat(value);
        var rate=Number($('#hidden_rate_amount').val());
        var num=Number(unformat);
        var total= rate + num;
        $('#hidden_redeem_amount').val(num);
        // $('#total_amount').val(total);
        var total_amount=accounting.formatNumber(total);
        $('#total_amount').val(total_amount + ' ៛');

      });


    });
  </script>

@endsection
