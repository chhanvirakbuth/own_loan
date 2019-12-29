@extends('layouts.admin-menu')

@section('custom-css')

  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">

  {{-- date picker (flatpickr) --}}
  <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

@endsection

@section('content')
  <div class="card">
        <div class="card-body">
          <div class="card-title">គណនីកម្ចីរបស់ <span class="customer-name"></span>{{$account->people->name_kh}}  👥 </div>
				   <hr>
				    <form method="post" action="#">
              @csrf
              @method('PUT')
					 <div class="form-group row">
					  <label for="input-21" class="col-sm-2 col-form-label">លេខគណនី</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="input-21" disabled
            value="{{$account->account_no}}">
					  </div>
					</div>
					<div class="form-group row">
					  <label for="input-22" class="col-sm-2 col-form-label">ប្រភេទនៃការបង់</label>
					  <div class="col-sm-10">
              <select class="form-control payment_type" id="type_loan" name="payment_type" required>
                <option value="default">សូមជ្រើសរើស</option>
                @foreach ($payment_types as $payment_type)
                  <option value="{{$payment_type->id}}"
                    @if ($payment_type->id == 1)
                      selected
                    @endif>
                    {{$payment_type->name_kh}}</option>
                @endforeach
              </select>
					  </div>
					</div>
					  <div class="form-group row">
						<label for="input-23" class="col-sm-2 col-form-label">ប្រាក់នៅជំពាក់</label>
						<div class="col-sm-10 amount">
						<input type="text" class="form-control" name="main_amount" id="input-22" class="main_amount"
            value="<?php echo number_format($loans->balance)?>" readonly>
						</div>
					  </div>
					<div class="form-group row">
					  <label for="input-24" class="col-sm-2 col-form-label">ការប្រាក់ &#37;</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="input-24" name="payment_rate"
            value="{{$loans->interest_rate}}" readonly>
					  </div>
					</div>
					<div class="form-group row">
						<label for="input-25" class="col-sm-2 col-form-label">ការប្រាក់ត្រូវបង់</label>
						<div class="col-sm-10">
						<input type="text" class="form-control rate_amount" id="money" name="rate_amount"
            value="<?php echo number_format($loans->balance * $loans->interest_rate)?>" readonly>
						</div>
					 </div>
           <div class="form-group row">
 						<label for="input-26" class="col-sm-2 col-form-label">បង់រំលោះចំនួន</label>
 						<div class="col-sm-10">
 						<input type="text" class="form-control redeem_amount" id="money" name="redeem_amount"​>
            <input type="hidden" name="" id="reedeem" value="" autocomplete="off">
 						</div>
 					 </div>
          <div class="form-group row">
						<label for="input-27" class="col-sm-2 col-form-label">ប្រាក់សរុបត្រួវបង់</label>
						<div class="col-sm-10">
						<input type="text" class="form-control" id="total" name="total_amount"
            value="<?php echo number_format($loans->balance * $loans->interest_rate)?>" readonly>
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
   $(".form-group .redeem_amount").prop('disabled', true);
   $('#type_loan').on('change',function(){
     if ($(this).val()== 4) {
       $(".form-group .redeem_amount").prop('disabled', false);
     }else {
       $(".form-group .redeem_amount").prop('disabled', true);
       $(".form-group .redeem_amount").val(0);
     }
   });
   // live sum of input
    $(document).ready(function(){
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
    });
  </script>
@endsection
