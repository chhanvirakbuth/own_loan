<?php

namespace App\Admin\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Customer\Reason;
use App\Admin\Account\Accounts;
use App\Admin\Account\Loans;
use App\Admin\Account\PaymentTransactions;
use App\Admin\Customer\Gender;
use App\Admin\Customer\Occupations;
use App\Admin\Customer\Statuses;
use App\Admin\Address\Provinces;
use App\Admin\Address\Districts;
use App\Admin\Address\Communes;
use App\Admin\Address\Villages;

class People extends Model
{
    //
    protected $table='cts_people';
    protected $hidden=['created_at','deleted_at','updated_at'];

    // mass assignment
    protected $fillable=[
      'gender_id',
      'occupation_id',
      'province_id',
      'district_id',
      'commune_id',
      'village_id',
      'image_id',
      'document_id',
      'name_kh',
      'name_en',
      'nick_name',
      'date_of_birth',
      'phone_no',
      'id_card_number',
      'email',
      'status_id',
      '	meta',
      'actived',
      'created_by'
    ];


  // relationship###########################################
    // relationship to reason
    public function reason(){
      return $this->hasOne(Reason::class);
    }

    // one to many with account
    public function accounts(){
      return $this->hasMany(Accounts::class);
    }

    // one to many with Loans
    public function loans(){
      return $this->hasMany(Loans::class);
    }

    // belongsTo Gender
    public function gender(){
      return $this->belongsTo(Gender::class);
    }

    // belongsTo occupation
    public function occupation(){
      return $this->belongsTo(Occupations::class);
    }

    // belongsTo status
    public function status(){
      return $this->belongsTo(Statuses::class);
    }

    // belong to province
    public function province(){
      return $this->belongsTo(Provinces::class);
    }

    // belong to districts
    public function district(){
      return $this->belongsTo(Districts::class);
    }

    // belong to communes
    public function commune(){
      return $this->belongsTo(Communes::class);
    }

    // belong to villages
    public function village(){
      return $this->belongsTo(Villages::class);
    }

    //has many payment transactions
    public function payment_transactions(){
      return $this->hasMany(PaymentTransactions::class);
    }
    //#########################################################
    // accessor
    // get nick name
    public function getNickNameAttribute($value){
      if ($value == null) {
        return ('គ្មានទេ ');
      } else {
        return ($value);
      }
    }

    // get id card
    public function getIdCardNumberAttribute($value){
      if ($value == null) {
        return('មិនបានបញ្ចូល');
      } else {
        return $value;
      }
    }

    // get statuses
    public function getStatusIdAttribute($value){
      if ($value == null) {
        return true;
      } else {
        return($value);
      }

    }

    // get phone email
    public function getEmailAttribute($value){
      if ($value == null) {
        return ('អត់មាន');
      } else {
        return $value;
      }
    }

    // get avatar
    public function getAvatarAttribute($value){
      if ($value == null) {
        return ('https://i.ya-webdesign.com/images/cool-png-avatar-4.png');
      }
      return ('storage/'.$value);
    }

    // get id card
    public function getIdCardAttribute($value){
      if ($value ==null) {
        return ('https://pngimage.net/wp-content/uploads/2018/05/credencial-png.png');
      }
        return ('storage/'.$value);
    }
    // set latin name to uppercase
    public function setNameEnAttribute($value){
      $this->attributes['name_en'] = mb_strtoupper($value);
    }

}
