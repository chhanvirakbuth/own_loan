<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin\App\Theme;

use App\Admin\Account\Deposits;
use App\Admin\Account\PaymentTypes;
use App\Admin\Account\PaymentTransactions;

use App\Enums\AccountEnum;
use App\Enums\DepositEnum;
use App\Enums\StatusEnum;
use Carbon\Carbon;
use Session;
use DB;
use Auth;
class DepositPayController extends Controller
{
    // add more saving
    public function add(Request $request,$id){
      $theme=Theme::findOrFail(1);
      $deposit=Deposits::findOrFail($id);
      $payment_types=PaymentTypes::where('account_type_id',AccountEnum::DEPOSIT)->get();
      return view('admin.deposit.add')->with('theme',$theme)
      ->with('deposit',$deposit)->with('payment_types',$payment_types);
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
      $now=Carbon::now();
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
          $transaction->account_no=$a_no;
          $transaction->begin_amount=$b_amount;
          $transaction->amount=$b_amount+$save_amount;
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
    //

}
