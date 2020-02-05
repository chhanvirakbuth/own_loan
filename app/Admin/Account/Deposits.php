<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Account\PaymentTransactions;

use App\Admin\Customer\People;
use App\Admin\Account\Accounts;
use App\Admin\Account\AccountTypeItems;

use Carbon\Carbon;
use Phanna\Converter\KhmerDatetime;
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
    public function account_type_item(){
      return $this->belongsTo(AccountTypeItems::class);
    }
    // ####################end relationship :( ##############################

    // ####################start Accessor :) ##############################
    public function getStatusAttribute($value){
      $now=Carbon::now('GMT+7');
      $last_paid=$this->getOriginal('last_paid_interest_at');
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

    // ############# get update at format to khmer date
    public function getUpdatedAtAttribute($value){
      if ($value == null) {
        return $value='<span class="badge badge-warning">មិនទាន់មាន</span>';
      }
      $date=$value;
      $khmer=new KhmerDatetime($date);
      $value=$khmer->getFullDay().'-'.$khmer->getFullMonth().'-'.$khmer->getFullYear();
      return $value;
    }
}
