<?php

namespace App\Http\Controllers\Admin\Reports;

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
      $loans=Loans::paginate(15);
      return view('admin.reports.loan.index')->with('theme',$theme)
      ->with('loans',$loans);
    }
    // show detail of each reports
    public function detail($id){
      $theme=Theme::findOrFail(1);
      $loan=Loans::findOrFail($id);
      $transactions=PaymentTransactions::where('loan_id',$id)->orderBy('id', 'ASC')->get();
      return view('admin.reports.loan.detail')->with('theme',$theme)
      ->with('transactions',$transactions)
      ->with('loan',$loan);
    }

    // show all loaner
    public function loaner(){
      $theme=Theme::findOrFail(1);
      $loans=Loans::paginate(15);
      return view('admin.reports.loan.loaner')->with('theme',$theme)
      ->with('loans',$loans);
    }

    public function softDelete($id){
      $loan=Loans::findOrFail($id);
      $loan->delete();
      Session::flash('success','គណនីនេះបានដាក់ក្នុងធុងសម្រាម!');
      return redirect()->back();
    }
}
