@extends('layouts.admin-menu')
@section('title')
  បង់ការប្រាក់
@endsection
@section('custom-css')

  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">

  {{-- date picker (flatpickr) --}}
  <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

@endsection

@section('content')
  <div class="card">
			   <div class="card-header  sidebar-header">គណនីដែលត្រូវបង់ប្រាក់</div>
			     <div class="card-body">
				    <form action="{{route('admin.loan.payment-search')}}" method="post" id="search_form">
              @csrf
						<div class="form-group row">
						  <label for="both-side-spinner" class="col-sm-2 col-form-label">លេខគណនី</label>
						  <div class="col-sm-6 py-2">
                <div class="col-sm-10">
                      <input type="text" class="form-control error" id="keyword" name="keyword" autocomplete="off">
                    </div>
						  </div>
              <div class="col-sm-4​​ mx-auto py-2">
                <button type="submit" class="btn btn-light waves-effect waves-light">ស្វែងរកគណនី <i class="zmdi zmdi-check"></i></button>
              </div>
						</div>
					</form>
			     </div>
           @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
			 </div>
@endsection

@section('custom-script')
  <!--Form Validatin Script-->
  <script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
  <script type="text/javascript">
    // validate
    $("#search_form").validate({
        rules: {
          keyword: {
                  required: true,
                  digits: true
          }
        },
        messages: {
          keyword: {
                  required:"សូមបញ្ចូលលេខគណនី",
                  digits: "សូមបញ្ចូលជាលេខ"
          }
        }
    });
  </script>

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
      $("#keyword").inputFilter(function(value) {
        return /^\d*$/.test(value);    // Allow digits only, using a RegExp
      });
    });
  </script>


@endsection
