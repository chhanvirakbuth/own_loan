@extends('layouts.admin-menu')
@section('title')
  ដកប្រាក់
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

    <label for="title" class="my-3">លេខគណនីសន្សំ</label>
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <form class="" action="{{route('deposit.withdraw.result')}}" method="post" id="search_form">
          @csrf
          <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-address-card-o"></i></span>
             </div>
             <input type="text" class="form-control account_no" maxlength="8" name="account_no"
             placeholder="បញ្ចូលលេខគណនីសន្សំ" autocomplete="off">
             <div class="input-group-append">
                <span class="input-group-text submit" style="cursor:pointer;"><i class="fa fa-search"></i></span>
            </div>
          </div>
          @error ('account_no')
          <label class="text text-danger">*សូមបញ្ចូលលេខគណនីសន្សំ</label>

          @enderror
          <button id="hidden_submit" type="submit" style="display:none;"></button>
        </form>
      </div>
      </div>
    </div>
</div>
@endsection

@section('custom-script')
  <script type="text/javascript">
    // input only number
    // Restricts input for the set of matched elements to the given inputFilter function.
    (function($) {
      $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          } else {
            this.value = "";
          }
        });
      };
    }(jQuery));

    $(document).ready(function() {
      $('.account_no').focus();
      $(".account_no").inputFilter(function(value) {
        return /^\d*$/.test(value);    // Allow digits only, using a RegExp
      });
    });
  </script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.account_no').focus();
      $('.submit').on('click',function(){
        $('#hidden_submit').click();
      });
    });
</script>

@endsection
