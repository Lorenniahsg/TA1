<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kriteria;
use App\SKKM;
use App\Mahasiswa;
use App\DimPenilaian;
use App\AdakRegistrasi;
use DB;

class SKKMController extends Controller
{

  public function route_tambah_skkm(){
    return view('/tambah_skkm');
  }

  public function tambah()
  {
    return $this->hasOne(App\mahasiswa);
  }

  public function store_skkm(Request $request){
        SKKM::create([
      'dim_id'=>$request->dim_id,
      'skkm'=>$request->skkm
    ]);
    return redirect()->back();

  }

  public function edit_skkm(Request $request, $id){
    $this->validate($request,[
      'skkm'=>'required'
    ]);
    $skkm_ = skkm::find($id);
    $skkm_->skkm = $request->input('skkm');
    $skkm_->save();
    return redirect()->back();
  }

  public function delete_skkm($id){
    $data = new Controller();
    $data->index();
    $skkm_ = skkm::find($id);
    if(($skkm_ != null) && ($data != null )) {
      $skkm_->delete();
      return redirect()->back();
    }
    return redirect()->back();
  }
}
