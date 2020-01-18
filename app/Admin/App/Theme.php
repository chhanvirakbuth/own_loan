<?php

namespace App\Admin\App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
  // table mapping
  protected $table='app_themes';

  protected $hidden=['created_at','deleted_at','updated_at'];

  // mass assignment
  protected $fillable=['name','created_by','brand','logo'];

  // accessor and mutator
  public function getLogoAttribute($value){
    return('storage/'.$value);
  }

  public function getBrandAttribute($value){
    return $value;
  }

  public function getNameAttribute($value){
    return $value;
  }
}
