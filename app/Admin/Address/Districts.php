<?php

namespace App\Admin\Address;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Adress\Provinces;
use App\Admin\Adress\Communes;
use App\Admin\Customer\People;

class Districts extends Model
{
    //table mapping
    protected $table='adr_districts';

    protected $hidden=['created_at','updated_at','deleted_at',];

    // mass assignment
    protected $fillable=[
      'province_id',
      'name_kh',
      'name_en',
      'actived',
    ];

    // relationship###################################################33
      //belong to province
      public function province(){
        return $this->belongsTo(Provinces::class);
      }

      // one to many with communes
      public function communes(){
        return $this->hasMany(Communes::class);
      }

      // one to many people
      public function peoples(){
        return $this->hasMany(People::class);
      }
}
