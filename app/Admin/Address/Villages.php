<?php

namespace App\Admin\Address;

use Illuminate\Database\Eloquent\Model;
use App\Admmin\Address\Communes;
class Villages extends Model
{
    //table mapping
    protected $table='adr_villages';

    protected $hidden=['created_at','updated_at','deleted_at',];

    // mass assignment
    protected $fillable=[
      'province_id',
      'district_id',
      'commune_id',
      'name_kh',
      'name_en',
      'actived',
    ];

    // relationship################################################
      // belongsTo communes
    public function commune(){
      return $this->belongsTo(Communes::class);
    }

    // one to many with peoples
    public function peoples(){
      return $this->hasMany(People::class);
    }
}
