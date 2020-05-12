<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Kriteria;
use App\DimPenilaian;
use App\AdakRegistrasi;
use App\Http\Controllers\Controller;
use DB;

class KriteriaController extends Controller
{

  public function route_tambah_krt_saw(){
    return view('/tambah_kriteria');
  }

  public function store_kriteria(Request $request){
    $data = new Controller();
    $data->Mahasiswa();
    $kriteria_saw = kriteria::all();
    $this->validate($request,[
      'kode'=>'required',
      'nama'=>'required',
      'atribut'=>'required',
      'bobot'=>'required',
      'keterangan'=>'required'
    ]);

    kriteria::create([
      'kode'=>$request->kode,
      'nama'=>$request->nama,
      'atribut'=>$request->atribut,
      'bobot'=>$request->bobot,
      'keterangan'=>$request->keterangan
    ]);

    return view('sawPage',['vdata'=>$kriteria_saw,'krt'=>$data]);
  }

  public function edit_kriteria($id){
    $kriteria_saw = kriteria::find($id);
    $data = new Controller();
    $data->Mahasiswa();
    return view('/edit_kriteria',['vdata'=>$kriteria_saw,'krt'=>$data]);
  }

  public function update_kriteria(Request $request, $id){
    $data = new Controller();
    $data->Mahasiswa();
    $this->validate($request,[
      'kode'=>'required',
      'nama'=>'required',
      'atribut'=>'required',
      'bobot'=>'required',
      'keterangan'=>'required'
    ]);

    $kriteria_saw = kriteria::find($id);
    $kriteria_saw->kode = $request->kode;
    $kriteria_saw->nama = $request->nama;
    $kriteria_saw->atribut = $request->atribut;
    $kriteria_saw->bobot = $request->bobot;
    $kriteria_saw->keterangan = $request->keterangan;
    $kriteria_saw->save();
    return view('sawPage',['vdata'=>$kriteria_saw,'krt'=>$data]);
  }

  public function hapus_kriteria($id){
    $data = new Controller();
    $data->Mahasiswa();
    $kriteria_saw = kriteria::find($id);
    if(($kriteria_saw != null) && ($data != null )) {
      $kriteria_saw->delete();
        return view('sawPage',['vdata'=>$kriteria_saw,'krt'=>$data]);
    }

    return view('sawPage',['vdata'=>$kriteria_saw,'krt'=>$data]);
  }
}
