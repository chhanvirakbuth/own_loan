<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Account\AccountTypes;
use App\Admin\Account\PaymentTransactions;

class PaymentTypes extends Model
{
    //table mapping
    protected $table='acc_payment_types';

    protected $hidden=['created_at','deleted_at','updated_at'];

    // mass assignemnt
    protected $fillable=['account_type_id','name_kh','name_en','created_by'];

    //###############let make relationship with someone ######################
      // belong to account type
    public function accountType(){
      return $this->belongsTo(AccountTypes::class);
    }

    // has many payment transactions
    public function payment_transactions(){
      return $this->hasMany(PaymentTransactions::class);
    }
    // #####################end of relationship ##############################
}
