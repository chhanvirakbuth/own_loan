<?php

namespace App\Http\Controllers\Admin\Reports;
use Phanna\Converter\KhmerDatetime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Admin\App\Theme;

use App\Admin\Account\PaymentTransactions;
use App\Admin\Account\Loans;
use Auth;
use Session;
use Carbon\Carbon;

class LoanReportController extends Controller
{
    //
    public function __construct(){
      $this->middleware('auth');
    }
    // show all loan report
    public function index(){
      $theme=Theme::findOrFail(1);
      $date=date('y-m-d');
      $khmer = new KhmerDatetime($date);
      $loans=Loans::paginate(15);
      return view('admin.reports.loan.index')->with('theme',$theme)
      ->with('loans',$loans)->with('khmer',$khmer);
    }
    // show detail of each reports
    public function detail($id){
      $theme=Theme::findOrFail(1);
      $date=date('y-m-d');
      $khmer = new KhmerDatetime($date);
      $loan=Loans::findOrFail($id);
      $transactions=PaymentTransactions::where('loan_id',$id)->orderBy('id', 'ASC')->get();
      return view('admin.reports.loan.detail')->with('theme',$theme)
      ->with('transactions',$transactions)->with('khmer',$khmer)
      ->with('loan',$loan);
    }
}
