<?php

namespace App\Admin\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Customer\People;

class Gender extends Model
{
    //table mapping
    protected $table='cts_genders';
    protected $hidden=['created_at','deleted_at','updated_at'];

    // mass assingment
    protected $fillable=['name_en','name_kh','actived','created_by'];

    // relationship
      // one to many people
      public function peoples(){
        return $this->hasMany(People::class);
      }
}
