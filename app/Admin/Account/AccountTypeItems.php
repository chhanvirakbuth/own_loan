<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Account\Accounts;
use App\Admin\Account\AccountTypes;
use App\Admin\Account\Loans;
use App\Admin\Account\Deposits;

class AccountTypeItems extends Model
{
    //
    protected $table='acc_account_type_items';

    protected $hidden=['created_at','updated_at','deleted_at',];

    // mass assignment
    protected $fillable=['account_type_id',
                        'name_kh',
                        'name_en',
                        'interest_rate',
                        'actived',
                        ];
    // return value format of rate #accessor
    public function getInterestRateAttribute($value){
      return ($value);
    }

    // #####################start making some relationship####################
      // one to many with account
    public function accounts(){
      return $this->hasMany(Accounts::class);
    }

    // belongsTo account type
    public function accountType(){
      return $this->belongsTo(AccountTypes::class);
    }

    // hasMany loan
    public function loans(){
      return $this->hasMany(Loans::class);
    }

    // has many deposits
    public function deposits(){
      return $this->hasMany(Deposits::class);
    }
    // ####################end the relationship :(############################
}
