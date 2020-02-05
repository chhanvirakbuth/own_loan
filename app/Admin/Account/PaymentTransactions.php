<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Customer\People;
use App\Admin\Account\Loans;
use App\Admin\Account\Deposits;
use App\Admin\Account\Accounts;
use App\Admin\Account\PaymentTypes;
use Phanna\Converter\KhmerDatetime;
class PaymentTransactions extends Model
{
    //table mapping
    protected $table='acc_payment_transactions';
    // hidden
    protected $hidden=['created_at','deleted_at','updated_at'];
    // mass assignemnt
    protected $fillable=[
      'people_id',
      'loan_id',
      'deposit_id',
      'account_id',
      'status',
      'payment_type_id',
      'payment_date',
      'account_no',
      'begin_amount',
      'amount',
      'balance',
      'transaction_at',
      'actived',
      'created_by',
      'deleted_by'
    ];
    // #########################relationships##################################
    // belongsTo people
    public function people(){
      return $this->belongsTo(People::class);
    }

    // belong to loan
    public function loan(){
      return $this->belongsTo(Loans::class);
    }

    // belong to deposit
    public function deposit(){
      return $this->belongsTo(Deposits::class);
    }

    // belong to account
    public function account(){
      return $this->belongsTo(Accounts::class);
    }

    // // belong to payment type
    public function payment_type(){
      return $this->belongsTo(PaymentTypes::class);
    }


    // ###################end relationship#####################################

    // ########################Accessors and Mutators#########################
    // get payment date
    public function getPaymentDateAttribute($value){
      $date=$value;
      $khmer=new KhmerDatetime($date);
      $value=$khmer->getFullDay().'-'.$khmer->getFullMonth().'-'.$khmer->getFullYear();
      return $value;
    }
}
