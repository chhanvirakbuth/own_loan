<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Customer\People;
use App\Admin\Customer\AccountTypes;
use App\Admin\Account\Loans;
use App\Admin\Account\PaymentTransactions;

class Accounts extends Model
{
    protected $table='acc_accounts';
    protected $hidden=['created_at','updated_at','deleted_at'];

    protected $fillable=['people_id','account_type_id','account_type_item_id','account_no','actived','created_by'];

    //###############let make relationship with someone######################
    // belongsTo people
    public function people(){
      return $this->belongsTo(People::class);
    }

    // belongsTo Account Type
    public function accountType(){
      return $this->belongsTo(AccountTypes::class);
    }

    // has many Loans
    public function loans(){
      return $this->hasMany(Loans::class);
    }

    // has many payment transactions
    public function payment_transactions(){
      return $this->hasMany(PaymentTransactions::class);
    }
    // #################end relationship :( ################################

    // accessor
    public function getAccountNoAttribute($value){
      if ($value == null) {
        return ('គ្មាន');
      } else {
        return $value;
      }

    }
}
