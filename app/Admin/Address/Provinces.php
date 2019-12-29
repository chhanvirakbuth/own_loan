<?php

namespace App\Admin\Address;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Address\Districts;
use App\Admin\Customer\People;

class Provinces extends Model
{
    //table mapping
    protected $table='adr_provinces';

    protected $hidden=['created_at','updated_at','deleted_at',];

    // mass assignment
    protected $fillable=[
      'name_kh',
      'name_en',
      'actived',
    ];

    // relationship
      // to districts on to many
    public function districts(){
      return $this->hasMany(Districts::class);
    }

    // one to many with peoples
    public function peoples(){
      return $this->hasMany(People::class);
    }
}
