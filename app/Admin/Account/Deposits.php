<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Account\PaymentTransactions;

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
    // ####################end relationship :( ##############################
}
