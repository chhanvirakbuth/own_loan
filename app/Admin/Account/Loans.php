<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Customer\People;
use App\Admin\Account\Accounts;
use App\Admin\Account\AccountTypeItems;
use App\Admin\Account\PaymentTransactions;

use Carbon\Carbon;
class Loans extends Model
{
    // table mapping
    protected $table='acc_loans';
    protected $hidden=['created_at','deleted_at','updated_at'];

    // mass assignment
    protected $fillable=[
      'people_id',
      'account_id',
      'status_id',
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
      'updated_by'
    ];

    // #########################relationship#################################
      // belongsTo people one to many
      public function people(){
        return $this->belongsTo(People::class);
      }

      // belongsTo account one to many
      public function account(){
        return $this->belongsTo(Accounts::class);
      }

      // belongsTo AccountTypes Item one to many
      public function account_type_item(){
        return $this->belongsTo(AccountTypeItems::class);
      }

      // has many payment transaction
      public function payment_transactions(){
        return $this->hasMany(PaymentTransactions::class);
      }
      // #####################end relationship###############################
      // accessor
      public function getStatusAttribute($value){
        $now=Carbon::now();
        $last_paid=$this->last_paid_interest_at;
        if ( !empty ( $last_paid ) ) {
          $year=Carbon::parse($last_paid)->year;
          $month=Carbon::parse($last_paid)->month;
          if ($now->subMonth()->month ==$month) {
            if ($this->balance == 0) {
              return $value=false;
            }
            return $value=true;
          }else {
            return $value=false;
          }
        }

        return $value;

      }
}
