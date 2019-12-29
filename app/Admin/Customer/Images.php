<?php

namespace App\Admin\Customer;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //table mapping
    protected $table='cts_images';
    protected $hidden=['created_at','deleted_at','updated_at'];

    // mass assignment
    protected $fillable =['directory','name'];
}
