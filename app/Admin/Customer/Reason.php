<?php

namespace App\Admin\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Customer\People;
class Reason extends Model
{
    //table mapping
    protected $table='cts_reasons';
    protected $hidden=['created_at','updated_at','deleted_at'];

    // mass assignment
    protected $fillable=['people_id','title'];

    // relationship
    public function people(){
      return $this->belongsTo(People::class);
    }


    // accesssor
      // get reason
      public function getTitleAttribute($value){
        if ($value ==null) {
          return ('អត់មូលហេតុ');
        }
        return $value;
      }
}
