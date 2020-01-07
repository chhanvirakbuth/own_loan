@extends('layouts.admin-menu')

@section('custom-css')

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
          <div class="card-title">អ្នកបង់ប្រាក់ <span class="customer-name">{{$loans->people->name_kh}}</span> 🤑 </div>
				   <hr>
				    <form method="post" action="{{route('admin.loan.payment-update',$loans->id)}}">
              @csrf
              @method('PUT')

					 <div class="form-group row">
					  <label for="input-21" class="col-sm-2 col-form-label">លេខគណនី</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="input-21" disabled
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
						<input type="text" class="form-control" name="main_amount" id="main_amount" class="main_amount"
            value="<?php echo number_format($loans->balance)?> &#6107;" disabled>
						</div>
					  </div>
					<div class="form-group row">
					  <label for="input-24" class="col-sm-2 col-form-label">ការប្រាក់ &#37;</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="input-24" name="payment_rate"
            value="{{$loans->interest_rate *100 .'%'}}" readonly>
					  </div>
					</div>
					<div class="form-group row">
						<label for="input-25" class="col-sm-2 col-form-label">ការប្រាក់ត្រូវបង់</label>
						<div class="col-sm-10">
						<input type="text" class="form-control" id="money" name="rate_amount"
            value="<?php echo number_format($loans->balance * $loans->interest_rate)?> &#6107;" readonly>
						</div>
					 </div>
           <div class="form-group row">
 						<label for="input-26" class="col-sm-2 col-form-label">បង់រំលោះចំនួន</label>
 						<div class="col-sm-10">
 						<input type="text" class="form-control redeem_amount" id="money" name="redeem_amount"​>
            <input type="hidden" name="" id="reedeem" value="">
 						</div>
 					 </div>
          <div class="form-group row">
						<label for="input-27" class="col-sm-2 col-form-label">ប្រាក់សរុបត្រួវបង់</label>
						<div class="col-sm-10">
						<input type="text" class="form-control" id="total" name="total_amount"
            value="{{$loans->balance * $loans->interest_rate}}" readonly>
						</div>
					 </div>

					 <div class="form-group row">
					  <label class="col-sm-2 col-form-label"></label>
					  <div class="col-sm-10">
						<button type="button" onclick="history.back();" class="btn btn-light waves-effect waves-light px-3 mx-2"><i class="zmdi zmdi-long-arrow-return"></i> ថយក្រោយ</button>
            <button type="submit" class="btn btn-light waves-effect waves-light px-3 mx-2"><i class="zmdi zmdi-check"></i> បង់ប្រាក់</button>
					  </div>
					</div>
					</form>
        </div>
      </div>
@endsection

@section('custom-script')
  <script type="text/javascript">
  // input number only
   $(".form-group #money").on("keypress keyup blur",function (event) {
      $(this).val($(this).val().replace(/[^\d].+/, ""));
       if ((event.which < 48 || event.which > 57)) {
           event.preventDefault();
       }
   });
   // enable redeem_amount
   var total_amount=$('#total').val();
   $(".form-group .redeem_amount").prop('disabled', true);
   $('#type_loan').on('change',function(){
     if ($(this).val()== 4) {
       $(".form-group .redeem_amount").prop('disabled', false);
     }else {
       $(".form-group .redeem_amount").prop('disabled', true);
       $(".form-group .redeem_amount").val(0);
     }
     // if payoff
     if($(this).val()== 5){
       var main_amount=$('#main_amount').val();
       $('#total').val(main_amount);
     }else {
       $('#total').val(total_amount);
     }
   });
   // live sum of input
    $('.form-group').on('input','#money',function(){
      var totalSum=0;
      $('.form-group #money').each(function(){
        var inputVal=$(this).val();
        if ($.isNumeric(inputVal)) {
          totalSum += parseFloat(inputVal);
        }
      });
      $('#total').val(totalSum);
    });
  </script>
@endsection
