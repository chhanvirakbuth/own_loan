<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin\App\Theme;

use App\Admin\Account\Loans;
use App\Admin\Account\Accounts;
use App\Admin\Account\Deposits;
use App\Admin\Account\PaymentTypes;
use App\Admin\Account\PaymentTransactions;

use App\Enums\AccountEnum;
use App\Enums\DepositEnum;
use App\Enums\StatusEnum;
use App\Enums\PaymentTypeEnum;
use Carbon\Carbon;
use Session;
use DB;
use Auth;
class DepositPayController extends Controller
{
    // add more saving  view from index
    public function add(Request $request,$id){
      $theme=Theme::findOrFail(1);
      $account=Accounts::where('account_type_id',AccountEnum::DEPOSIT)->where('account_no',$id)->firstOrFail();
      $id=$account->people->deposits[0]->id;
      $deposit=Deposits::findOrFail($id);
      $payment_types=PaymentTypes::where('account_type_id',AccountEnum::DEPOSIT)->get();
      $transaction=PaymentTransactions::where('account_id',$deposit->account_id)->where('payment_type_id','!=',PaymentTypeEnum::WITHDRAW)->orderBy('id','DESC')->get();
      return view('admin.deposit.add')->with('theme',$theme)
      ->with('deposit',$deposit)->with('payment_types',$payment_types)
      ->with('transaction',$transaction);
    }

    // update deposit
    public function update(Request $request, $id){
      $this->validate($request,[
        'payment_type'=>'required',
        'hidden_redeem_amount'=>'required',
        'redeem_amount'=>'required'
      ]);
      // decleartion
      $save_amount=$request->hidden_redeem_amount;
      $p_type=PaymentTypes::findOrFail($request->payment_type);

      $now=Carbon::now('GMT+7');
      // dd($request->all());
      // exit;
      try {
          DB::beginTransaction();
          // update deposit
          $deposit=Deposits::findOrFail($id);
          // some decleartion
          $p_id=$deposit->people->id;
          $d_id=$deposit->id;
          $a_id=$deposit->account->id;
          $a_no=$deposit->account->account_no;
          $b_amount=$deposit->balance;
          $user=Auth::user();

          $deposit->balance+=$save_amount;
          $deposit->n_of_paid_interest+=1;
          $deposit->last_paid_interest_at=$now;
          $deposit->save();
          // create transaction
          $transaction=new PaymentTransactions();
          $transaction->people_id=$p_id;
          $transaction->deposit_id=$d_id;
          $transaction->account_id=$a_id;
          $transaction->status=DepositEnum::PAID;
          $transaction->payment_date=$now;
          $transaction->payment_type_id=$request->payment_type;
          $transaction->payment_type=$p_type->name_kh;
          $transaction->account_no=$a_no;
          $transaction->begin_amount=$b_amount;
          $transaction->amount=$save_amount;
          $transaction->balance=$b_amount+$save_amount;
          $transaction->transaction_at=$now;
          $transaction->actived=StatusEnum::ACTIVE;
          $transaction->created_by=$user->id;
          $transaction->save();
          DB::commit();
          Session::flash('success','ការសន្សំប្រាក់បានជោគជ័យ');
          return redirect(route('deposit.index'));
      } catch (\Exception $e) {
        DB::rollBack();
      }

    }
    //saving deposit from searching
    public function save(Request $request,$account){
      $this->validate($request,[
      'save_amount'=>'required|numeric'
      ]);
      $account=Accounts::where('account_no',$account)->firstOrFail();
      $p_type=PaymentTypes::findOrFail($account->account_type_item_id);
      $save_amount=$request->save_amount;
      try {
        DB::beginTransaction();
        // decleartion
        $deposit=Deposits::findOrFail($account->people->deposits[0]->id);

        $p_id=$deposit->people->id;
        $d_id=$deposit->id;
        $a_id=$deposit->account->id;
        $a_no=$deposit->account->account_no;
        $b_amount=$deposit->balance;
        $user=Auth::user();
        $now=Carbon::now('GMT+7');
        // update balance at deposit table
        $deposit->balance+=$request->save_amount;
        $deposit->n_of_paid_interest+=1;
        $deposit->last_paid_interest_at=$now;
        $deposit->updated_by=$user->id;
        $deposit->save();
        // create transaction
        $transaction=new PaymentTransactions();
        $transaction->people_id=$p_id;
        $transaction->deposit_id=$d_id;
        $transaction->account_id=$a_id;
        $transaction->status=DepositEnum::PAID;
        $transaction->payment_date=$now;
        $transaction->payment_type_id=$p_type->id;
        $transaction->payment_type=$p_type->name_kh;
        $transaction->account_no=$a_no;
        $transaction->begin_amount=$b_amount;
        $transaction->amount=$save_amount;
        $transaction->balance=$b_amount+$save_amount;
        $transaction->transaction_at=$now;
        $transaction->actived=StatusEnum::ACTIVE;
        $transaction->created_by=$user->id;
        $transaction->save();
        DB::commit();
        Session::flash('success','ដំណើរការដាក់ប្រាក់បានជោគជ័យ!');
        return redirect()->route('deposit.index');
      } catch (Exception $e) {
        DB::rollBack();
      }

    }

    // search account for withdraw
    public function search_withdraw()
    {
      $theme=Theme::findOrFail(1);
      return view('admin.deposit.search_withdraw')->with('theme',$theme);
    }

    // searching withdraw result
    public function search_withdraw_result(Request $request)
    {
      $this->validate($request,[
        'account_no'=>'required|numeric'
      ]);
      $no=$request->account_no;
      $theme=Theme::findOrFail(1);
      $account=Accounts::where('account_type_id',AccountEnum::DEPOSIT)->where('account_no',$no)->first();
      if ($account == null) {
        Session::flash('warning','មិនមានក្នុងប្រព័ន្ធ!');
        return redirect()->back();
      } else {
        $id=$account->people->deposits[0]->id;
        $deposit=Deposits::findOrFail($id);
        $transaction=PaymentTransactions::where('account_id',$deposit->account->id)
                    ->where('payment_type_id','!=',PaymentTypeEnum::WITHDRAW)->orderBy('id','DESC')->get();
        return view('admin.deposit.withdraw')->with('theme',$theme)
        ->with('deposit',$deposit)->with('account',$account)
        ->with('transaction',$transaction);
      }

    }

    // withdraw process
    public function withdraw(Request $request,$account_no)
    {
      $this->validate($request,[
        'withdraw_amount'=>'required|numeric'
      ]);
      $account=Accounts::where('account_no',$account_no)->firstOrFail();
      $balance=$account->people->deposits[0]->balance;
      $withdraw=$request->withdraw_amount;
      $deposit=Deposits::findOrFail($account->people->deposits[0]->id);
      $p_type=PaymentTypes::findOrFail(PaymentTypeEnum::WITHDRAW);
      $now=Carbon::now('GMT+7');
      $user=Auth::user();
      // find out all the total money
      $transaction=PaymentTransactions::sum('amount'); //it the income
      $total_withdraw=PaymentTransactions::where('payment_type_id',PaymentTypeEnum::WITHDRAW)->sum('balance');
      $loan=Loans::sum('begin_amount');
      $left_amount=$transaction-$loan - $total_withdraw;
      if ($left_amount > $withdraw) {
        if ($withdraw <= $balance) {
          try {
            DB::beginTransaction();
            // update balance
            $deposit->balance-=$withdraw;
            $deposit->updated_by=$user->id;
            $deposit->updated_at=$now;
            $deposit->save();

            //create transaction
            $transaction=new PaymentTransactions();
            $transaction->people_id=$deposit->people->id;
            $transaction->deposit_id=$deposit->id;
            $transaction->account_id=$deposit->account->id;
            $transaction->status=DepositEnum::PAID;
            $transaction->payment_date=$now;
            $transaction->payment_type_id=PaymentTypeEnum::WITHDRAW;
            $transaction->payment_type=$p_type->name_kh;
            $transaction->account_no=$deposit->account->account_no;
            $transaction->begin_amount=$deposit->begin_amount;
            $transaction->amount=0; //beacuse withdraw not save
            $transaction->balance=$withdraw; //the amount of withdraw
            $transaction->transaction_at=$now;
            $transaction->actived=StatusEnum::ACTIVE;
            $transaction->created_by=$user->id;
            $transaction->save();
            DB::commit();
            Session::flash('success','ការដកប្រាក់បានជោគជ័យ!');
            return redirect()->route('deposit.index');
          } catch (Exception $e) {
            DB::rollBack();
          }
        }else {
          Session::flash('warning','មិនមានលុយគ្រប់ទេ');
          return redirect()->back();
        }
      }else {
        Session::flash('info','យើងមិនទាន់មានលុយគ្រប់ទេ');
        return redirect()->back();
      }
    }
    //
}
