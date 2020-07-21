<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Kriteria;
use App\DimPenilaian;
use App\AdakRegistrasi;
use DB;

class PageController extends Controller
{
    public function perbandingan(){
      $data = new FuzzyTopsisController();
      $ft = $data->hasilAkhirFT();

      $data2 = new SawController();
      $saw = $data2->hasilAkhirSaw();

      return view('perbandingan',['Fuzzy_Topsis'=>$ft['hasilFinals'],'saw'=>$saw['hasil_akhir_saw']]);
    }
}
