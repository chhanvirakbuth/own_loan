<?php

namespace App\Admin\Address;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Address\Villages;
use App\Admin\Address\Districts;
use App\Admin\Customer\People;

class Communes extends Model
{
    //table mapping
    protected $table='adr_communes';

    protected $hidden=['created_at','updated_at','deleted_at',];

    // mass assignment
    protected $fillable=['province_id',
                        'district_id',
                        'name_kh',
                        'name_en',
                        'actived',
                        ];

    // relationship#################################
      // one to many with villages
    public function villages(){
      return $this->hasMany(Villages::class);

    }

      // belong to districts
    public function district(){
      return $this->belongsTo(Districts::class);
    }

      // one to many people
    public function peoples(){
      return $this->hasMany(People::class);
    }
}
