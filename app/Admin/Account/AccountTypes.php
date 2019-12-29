<?php

namespace App\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Account\Accounts;
use App\Admin\Account\AccountTypeItems;
use App\Admin\Account\PaymentTypes;

class AccountTypes extends Model
{
    //table mapping
    protected $table='acc_account_types';
    protected $hidden=['created_at','updated_at','deleted_at'];

    protected $fillable=['name_en','name_kh','actived','created_by'];

    // relationship
      // one to many with account
    public function accounts(){
      return $this->hasMany(Accounts::class);
    }

    // one to many with account_type_items
    public function account_type_items(){
        return $this->hasMany(AccountTypeItems::class);
    }

    // one to many payment type
    public function paymentTypes(){
      return $this->hasMany(PaymentTypes::class);
    }
}
