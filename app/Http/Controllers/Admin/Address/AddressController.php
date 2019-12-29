<?php

namespace App\Http\Controllers\Admin\Address;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Address\Communes;
use App\Admin\Address\Districts;
use App\Admin\Address\Villages;
class AddressController extends Controller
{
  // fetching districts
  public function getDistricts($id){
      $districts=Districts::where('province_id',$id)->whereNotNull('name_kh')->pluck('name_kh','id');
      return json_encode($districts);
    }
    // fetching communes
    public function getCommunes($id){
      $communes=Communes::where('district_id',$id)->whereNotNull('name_kh')->pluck('name_kh','id');
      return json_encode($communes);
    }
    // fetching Villages
    public function getVillages($id){
      $villages=Villages::where('commune_id',$id)->whereNotNull('name_kh')->pluck('name_kh','id');
      return json_encode($villages);
    }
}
