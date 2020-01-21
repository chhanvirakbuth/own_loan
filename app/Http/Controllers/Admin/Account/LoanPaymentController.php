<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Admin\Account\Loans;
use App\Admin\Account\PaymentTypes;
use App\Admin\Account\Accounts;
use App\Admin\Account\PaymentTransactions;

use App\Admin\Customer\People;

use App\Enums\AccountEnum;
use App\Enums\LoanStatusEnum;
use App\Enums\StatusEnum;
use App\Enums\PaymentTypeEnum;

use App\Admin\App\Theme;

use Session;
use Carbon\Carbon;
use Auth;
class LoanPaymentController extends Controller
{
  public function __construct(){
    $this->middleware('auth');

  }
    //index of loan payment
    public function index(){
      $theme=Theme::findOrFail(1);
      return view('admin.loan.index-payment')->with('theme',$theme);
    }
    // loan payment view
    public function payment($id){
      $loans=Loans::findOrFail($id);
      if ($loans->status == false) { //mean that this loaner already paid for rate
        Session::flash('warning','បានបង់ការប្រាក់រួចរាល់ហើយ!');
        return redirect()->back();
      }
      $theme=Theme::findOrFail(1);
      $payment_types=PaymentTypes::where('account_type_id',AccountEnum::LOAN)->get();
      return view('admin.loan.payment')
      ->with('loans',$loans)
      ->with('payment_types',$payment_types)
      ->with('theme',$theme);
    }

    // #### loan payment update of index view####
    public function update(Request $request,$id){
      $this->validate($request,[
        'payment_type'=>'required',
        'hidden_redeem_amount'=>'nullable|numeric',
        'hidden_main_amount'=>'nullable'
      ]);
      try {
        DB::beginTransaction();
        $loan=Loans::findOrFail($id);
        // check condition
        if ($request->payment_type == PaymentTypeEnum::REDEEM) { //if was redeem
          $redeem=$request->hidden_redeem_amount;
          if($redeem > $loan->balance){
            Session::flash('error','បង់រំលោះមិនអាចលើសប្រាក់ជំពាក់ទេ');
            return redirect()->back();
          }
        }
        if ($request->payment_type == PaymentTypeEnum::PAY_OFF) { //if was pay off
          $redeem=$loan->balance;
        }
        if ($request->payment_type== PaymentTypeEnum::LOAN_INTEREST) { //if was interest
          $redeem=0;
        }
        // update loan
        $interest=$loan->balance * $loan->interest_rate;
        $total=$interest + $redeem;

        $loan->balance-=$redeem;
        $loan->n_of_paid_interest+=1;
        $loan->last_paid_interest_at=Carbon::now();
        $loan->status=LoanStatusEnum::PAID;
        $loan->updated_by=Auth::user()->id;
        $loan->save();

        // create transactions
        $trans=new PaymentTransactions();
        $p_type=PaymentTypes::findOrFail($request->payment_type);

        $trans->people_id=$loan->people->id;
        $trans->loan_id=$loan->id;
        $trans->account_id=$loan->account->id;
        $trans->status=LoanStatusEnum::PAID;
        $trans->payment_type=$p_type->name_kh;
        $trans->payment_type_id=$p_type->id;
        $trans->payment_date=Carbon::now();
        $trans->account_no=$loan->account->account_no;
        $trans->begin_amount=$redeem;
        $trans->amount=$total;
        $trans->balance=$loan->balance;
        $trans->transaction_at=Carbon::now();
        $trans->actived=StatusEnum::ACTIVE;
        $trans->created_by=Auth::user()->id;
        $trans->save();

        DB::commit();
        Session::flash('success','បង់ប្រាក់រួចរាល់!');
        return redirect(route('admin.loan.index'));

      } catch (Exception $e) {
        DB::rollback();
      }

    }

    // searching account
    public function search(Request $request){
      $this->validate($request,[
       'keyword'=>'required|numeric'
     ]);
     $keyword=$request->keyword;

     $payment_types=PaymentTypes::where('account_type_id',AccountEnum::LOAN)->get();
     $accounts=Accounts::where('account_no',$keyword)->where('account_type_id',AccountEnum::LOAN)->get();
     $theme=Theme::findOrFail(1);
     if ($accounts->count()>0) {
       foreach ($accounts as $account) {
         $loans=Loans::findOrFail($account->id);
         return view('admin.loan.search-view')->with('account',$account)
           ->with('payment_types',$payment_types)
           ->with('loans',$loans)
           ->with('theme',$theme);
       }
     } else {
       Session::flash('info','គណនីមិនត្រឹមត្រូវ​!');
       return redirect()->back();
     }


    }
    //update payment by serch
    public function search_update(Request $request, $id){
      try {
        DB::beginTransaction();

        $this->validate($request,[
          'payment_type'=>'required|numeric',
          'main_amount'=>'nullable',
          'payment_rate'=>'nullable',
          'redeem_amount'=>'nullable',
          'rate_amount'=>'nullable',
          'total_amount'=>'nullable'
        ]);

        // update loan
        $loans=Loans::findOrFail($id);
        if ($loans->status == false) {
          // mean that already paid
          Session::flash('warning','បានបង់ការប្រាក់រួចហើយ!');
          return redirect()->route('admin.loan.payment-index');
        }

        // some declearation
        $user = Auth::user();
        $rate=$loans->interest_rate;
        $balance=$loans->balance;
        $paid_rate= $rate * $balance;
        $number_of_paid=$loans->n_of_paid_interest + 1;
        $current_Date=Carbon::now();
        $people_id=$loans->people->id;
        $account_id=$loans->account->id;
        $loan_id=$loans->id;
        $account_no=$loans->account->account_no;
        $beginAmount=$loans->begin_amount;
        // check if payment type was ...
        if ($request->payment_type == PaymentTypeEnum::PAY_OFF) {
          $paid_amount=$loans->balance;
        }elseif ($request->payment_type == PaymentTypeEnum::REDEEM) {
          $paid_amount=$request->redeem_amount;
        }else {
          $paid_amount=0;
        }
        // end condition
        // check is active
        if ($balance - $paid_amount == 0) {
          $active=StatusEnum::INACTIVE; //mean that close this account cuz no more loan
        } else {
          $active=StatusEnum::ACTIVE;
        }

        $total_paid=$paid_rate + $paid_amount;

        // update loan
        $loans->status=LoanStatusEnum::PAID;
        $loans->balance=$balance - $paid_amount;
        $loans->n_of_paid_interest =$number_of_paid;
        $loans->last_paid_interest_at=$current_Date;
        $loans->updated_by=$user->id;
        $loans->actived=$active;
        $loans->save();

        // create transactions
        $transactions=new PaymentTransactions();
        $balance=$loans->balance;

        $transactions->people_id=$people_id;
        $transactions->loan_id=$loan_id;
        $transactions->account_id=$account_id;
        $transactions->status=LoanStatusEnum::PAID;
        $payment_type=PaymentTypes::findOrFail($request->payment_type);
        $transactions->payment_type=$payment_type->name_kh;
        $transactions->payment_type_id=$request->payment_type;
        $transactions->payment_date=$current_Date;
        $transactions->account_no=$account_no;
        $transactions->begin_amount=$beginAmount;
        $transactions->amount=$total_paid;
        $transactions->balance=$balance;
        $transactions->transaction_at=$current_Date;
        $transactions->actived=StatusEnum::ACTIVE;
        $transactions->created_by=$user->id;
        $transactions->save();

        DB::commit();
        Session::flash('success','បង់ប្រាក់រួចហើយ!');
        return redirect()->route('admin.loan.payment-index');
      } catch (\Exception $e) {
        DB::rollback();
      }

    }
}
