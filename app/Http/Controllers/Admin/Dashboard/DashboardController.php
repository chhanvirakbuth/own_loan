<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\App\Theme;

use App\Admin\Account\Loans;
use App\Admin\Account\PaymentTransactions;

use Carbon\Carbon;
class DashboardController extends Controller
{
  // index
  public function index()
  {
    $theme=Theme::findOrFail(1);
    return view('admin.dashboard.index')->with('theme',$theme);
  }

  // loan
  public function loan()
  {
      $theme=Theme::findOrFail(1);
      $loans=Loans::all();
      $top_loan=Loans::orderBy('begin_amount','desc')->where('balance','!=' , 0)->paginate(5);
      $bot_loan=Loans::orderBy('begin_amount','asc')->where('balance','!=' , 0)->paginate(5);

      $now=Carbon::now('GMT+7');
      $month=$now->month;
      $sub_month=$now->subMonth()->month;
      // exit;
      $monthly_loan=Loans::whereMonth('started_at',$month)->get();
      $last_month=Loans::whereMonth('started_at',$sub_month)->get();

      $income=PaymentTransactions::whereNotNull('loan_id')->get();

      $now_payment=PaymentTransactions::whereNotNull('loan_id')->whereMonth('transaction_at',$month)->get();
      $sub_payment=PaymentTransactions::whereNotNull('loan_id')->whereMonth('transaction_at',$sub_month)->get();

      return view('admin.dashboard.loan')->with('theme',$theme)->with('loans',$loans)
      ->with('monthly_loan',$monthly_loan)->with('last_month',$last_month)
      ->with('now_payment',$now_payment)->with('sub_payment',$sub_payment)
      ->with('income',$income)->with('top_loan',$top_loan)->with('bot_loan',$bot_loan);
  }

}
