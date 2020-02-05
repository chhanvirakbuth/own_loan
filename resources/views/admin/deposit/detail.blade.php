@extends('layouts.admin-menu')
@section('title')
  មើលលម្អិត - {{$deposit->people->name_kh}}
@endsection
@section('custom-css')

  <link rel="stylesheet" href="{{asset('assets/css/custom-css.css')}}">
  {{-- cleave js --}}
  <script src="{{asset('assets/js/cleave.min.js')}}" charset="utf-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.5.3/addons/cleave-phone.kh.js"></script>
  <!-- ...AutoNumeric :-->
  <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.1.0"></script>
  <style media="screen">
    .inside_card:hover{
      cursor: pointer;
      box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    }
  </style>
@endsection

@section('content')
  <button class="btn btn-sm btn-info mb-2"type="button" name="button" onclick="history.back()"><i class="fa fa-mail-reply"></i> ថយក្រោយវិញ</button>
<div class="card">
  <div class="card-body">
      <h4 class="text text-center my3" style="font-size:15px;">គណនីសន្សំ - {{$deposit->people->name_kh}}</h4>
      <div class="row mt-3">
      <div class="col-12 col-lg-6 col-xl-4">
        <div class="card gradient-blooker inside_card">
        <div class="card-body">
            <p class="text-white mb-0"><a>ប្រាក់សន្សំសរុប</a> <span class="float-right badge badge-light"><a>ទាំងអស់</a></span></p>
             <div class="">
             <h4 class="mb-0 py-3">{{number_format($deposit->balance)}} ៛ <span class="float-right"><i class="fa fa-cc"></i></span></h4>
             </div>
          </div>
        </div>
       </div>


       <div class="col-12 col-lg-6 col-xl-4">
        <div class="card gradient-purpink inside_card">
        <div class="card-body">
            <p class="text-white mb-0"><a>ប្រាក់សន្សំចុងក្រោយ</a> <span class="float-right badge badge-light"><a>សរុប</a></span></p>
             <div class="">
             <h4 class="mb-0 py-3">{{number_format($transaction[0]->amount)}} ៛<span class="float-right"><i class="fa fa-money"></i></span></h4>
             </div>
          </div>
        </div>
       </div>

       <div class="col-12 col-lg-6 col-xl-4">
        <div class="card gradient-bloody inside_card">
        <div class="card-body">
            <p class="text-white mb-0"><a>ការប្រាក់ទទួល</a> <span class="float-right badge badge-light"><a>សរុប</a></span></p>
             <div class="">
               <h4 class="mb-0 py-3">@php
                 $rate=$deposit->interest_rate;
                 $sum=0;
                 foreach ($transaction as $key => $value) {
                   $sum+= $value->balance * $rate;
                 }
                 echo number_format($sum);
               @endphp ៛<span class="float-right"><i class="fa fa-plus"></i></span></h4>
             </div>
          </div>
        </div>
       </div>

     </div>



  </div>
</div>
@endsection

@section('custom-script')

  
@endsection
