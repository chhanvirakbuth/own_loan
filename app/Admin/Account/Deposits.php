<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Account\PaymentTransactions;

use App\Admin\Customer\People;
use App\Admin\Account\Accounts;
use App\Admin\Account\AccountTypeItems;

class Deposits extends Model
{
    //table mapping
    protected $table='acc_deposits';
    // hidden
    protected $hidden=['created_at','deleted_at','updated_at'];
    // mass assignemnt
    protected $fillable=[
      'people_id',
      'account_id',
      'status',
      'account_type_item_id',
      'started_at',
      'closed_at',
      'begin_amount',
      'balance',
      'interest_rate',
      'n_of_paid_interest',
      'last_paid_interest_at',
      'actived',
      'created_by',
      'deleted_by'
    ];

    // ###########start making relationship with someone#####################

    // has many payment transactions
    public function payment_transactions(){
      return $this->hasMany(PaymentTransactions::class);
    }

    // belong to people
    public function people(){
      return $this->belongsTo(People::class);
    }

    // belong to account
    public function account(){
      return $this->belongsTo(Accounts::class);
    }

    // belong to account type items
    public function account_type_items(){
      return $this->belongsTo(AccountTypeItems::class);
    }
    // ####################end relationship :( ##############################
}
