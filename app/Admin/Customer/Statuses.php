<?php

namespace App\Admin\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Customer\People;


class Statuses extends Model
{
    //table mapping
    protected $table='cts_statuses';

    protected $hidden=['created_at','updated_at','deleted_at',];

    // mass assignment
    protected $fillable=['name_en','name_kh'];

    // relationship
      // one to many with people
    public function peoples(){
      return $this->hasMany(People::class);
    }
}
