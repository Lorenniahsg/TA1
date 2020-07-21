<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DimPenilaian;
use App\AdakRegistrasi;

class FuzzyTopsisController extends Controller
{
  public function PerhitunganFT()
  {
    $dimx_dim = DimPenilaian::selectRaw("
    askm_dim_penilaian.akumulasi_skor,
    askm_dim_penilaian.dim_id,
    askm_dim_penilaian.ta,
    askm_dim_penilaian.sem_ta");
    $query = AdakRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm,dimx_dim.nama,
    dimx_dim.dim_id,adak_registrasi.ta,adak_registrasi.nr AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
      ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
      ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
      ->leftJoin(\DB::raw("(" . $dimx_dim->toSql() . ") as p"), function ($query) {
          $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
          $query->on('p.ta', '=', 'adak_registrasi.ta');
          $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
      })
      ->orderBy('dimx_dim.nama','asc')
      ->get();

    $tfn = [
      "Very High"=>[7,9,9],
      "High"=>[5,7,9],
      "Average"=>[3,5,7],
      "Low"=>[1,3,5],
      "Very Low"=>[1,1,3]
    ];

    $hasilAkhir = [];
    foreach ($query as $s) {
    $valMatch = null;
    $seperK = null;
    $valMatchMax = null;

      if ($s['ta'] == 2017 && $s['sem_ta']== 2 || $s['sem_ta']== 1) {
        if ($s['nr'] >= 3.50 && $s['nr'] <= 4.00) {
          $valMatch = $tfn['Very High'][0];
          $seperK = $tfn['Very High'][1];
          $valMatchMax = $tfn['Very High'][2];
        }elseif($s['nr'] >= 3.00 && $s['nr'] <=3.49){
          $valMatch = $tfn['High'][0];
          $seperK = $tfn['High'][1];
          $valMatchMax = $tfn['High'][2];
        }elseif( $s['nr'] >= 2.00 && $s['nr'] <= 2.99){
          $valMatch = $tfn['Average'][0];
          $seperK = $tfn['Average'][1];
          $valMatchMax = $tfn['Average'][2];
        }elseif( $s['nr'] >= 1.00 && $s['nr'] <=1.99){
          $valMatch = $tfn['Low'][0];
          $seperK = $tfn['Low'][1];
          $valMatchMax = $tfn['Low'][2];
        }elseif($s['nr'] >= 0.00 && $s['nr'] <=0.99){
          $valMatch = $tfn['Very Low'][0];
          $seperK = $tfn['Very Low'][1];
          $valMatchMax = $tfn['Very Low'][2];
        }

        if(isset($valMatch)){
          /* Menghitung nilai minimal test_ip */
          if ((!isset($hasilAkhir[$s['nama']]["test_ip_min"])) || ($hasilAkhir[$s['nama']]["test_ip_min"] > $valMatch)) {
            $hasilAkhir[$s['nama']]["test_ip_min"] = $valMatch;
          }

          /* Menghitung total test_ip */
          if (!isset($hasilAkhir[$s['nama']]["total_test_ip"])) {
            $hasilAkhir[$s['nama']]["total_test_ip"] = $seperK;
          } else {
            $hasilAkhir[$s['nama']]["total_test_ip"] += $seperK;
          }

          /* Mencari Maximal IP */
          if ((!isset($hailAkhir[$s['nama']]['test_ip_max'])) || ($hasilAkhir[$s['nama']]['test_ip_max'] < $valMatchMax)) {
            $hasilAkhir[$s['nama']]['test_ip_max'] = $valMatchMax;
          }
        }
      }

      $valMatch = null;
      $seperK = null;
      $valMatchMax = null;
      if ($s['ta'] == 2017 && $s['sem_ta']==2 || $s['sem_ta']==1) {
        //  Very Low
        if($s['akumulasi_skor'] >=0 && $s['akumulasi_skor'] <=5){
          $valMatch = $tfn['Very High'][0];
          $seperK = $tfn['Very High'][1];
          $valMatchMax = $tfn['Very High'][2];
        }elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10){
          $valMatch = $tfn['High'][0];
          $seperK = $tfn['High'][1];
          $valMatchMax = $tfn['High'][2];
        }elseif( $s['akumulasi_skor'] >=11 && $s['akumulasi_skor'] <=15){
          $valMatch = $tfn['Average'][0];
          $seperK = $tfn['Average'][1];
          $valMatchMax = $tfn['Average'][2];
        }elseif( $s['akumulasi_skor'] >=16 && $s['akumulasi_skor'] <=25){
          $valMatch = $tfn['Low'][0];
          $seperK = $tfn['Low'][1];
          $valMatchMax = $tfn['Low'][2];
        }elseif( $s['akumulasi_skor'] >=26 && $s['akumulasi_skor'] <= 100){
          $valMatch = $tfn['Very Low'][0];
          $seperK = $tfn['Very Low'][1];
          $valMatchMax = $tfn['Very Low'][2];
        }
      }
      if(isset($valMatch)){
        /* Menghitung nilai minimal test_perilaku */
        if ((!isset($hasilAkhir[$s['nama']]["test_perilaku_min"])) || ($hasilAkhir[$s['nama']]["test_perilaku_min"] > $valMatch)) {
          $hasilAkhir[$s['nama']]["test_perilaku_min"] = $valMatch;
        }

        /* Menghitung total test_perilaku */
        if (!isset($hasilAkhir[$s['nama']]["total_test_perilaku"])) {
          $hasilAkhir[$s['nama']]["total_test_perilaku"] = $seperK;
        } else {
          $hasilAkhir[$s['nama']]["total_test_perilaku"] += $seperK;
        }
        if ((!isset($hasilAkhir[$s['nama']]['test_prilaku_max'])) || ($hasilAkhir[$s['nama']]['test_prilaku_max'] < $valMatchMax)) {
          $hasilAkhir[$s['nama']]['test_prilaku_max'] = $valMatchMax;
        }
      }
    }
    return view("Fuzzy_Topsis.seleksi_awal_ft",['semua'=>$query,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
  }


  public function Seleksi_FT()
  {
    $data = $this->PerhitunganFT();
    $hasilAkhir = $data['hasilAkhir'];
    $tfn = $data['tfn'];
    return view("Fuzzy_Topsis.seleksi_awal_ft2",['tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
  }


  public function NFDM()
  {
    $data = $this->Seleksi_FT();
    $hasilAkhir = $data['hasilAkhir'];
    $tfn = $data['tfn'];

    $Cj = [];
    $Aj = [];
    foreach ($hasilAkhir as $key => $value) {
    $Cij = null;
    $Aij = null;

    $Cij = $value['test_ip_max'];
    $Aij = $value['test_perilaku_min'];

    if ((!isset($Cj[$key]["Cj"])) || ($Cj[$key]["Cj"] > $Cij))
      {
        $Cj[$key]["Cj"] = $Cij;
      }
    if ((!isset($Aj[$key]["Aj"])) || ($Aj[$key]["Aj"] > $Aij))
      {
        $Aj[$key]["Aj"] = $Aij;
      }
    }

    $Cj = max($Cj);
    $Aj = min($Aj);
    return view("Fuzzy_Topsis.seleksi_awal_ft3",['Aj'=>$Aj,'Cj'=>$Cj,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
  }


  public function PBHNFDM(){
    $data = $this->NFDM();
    $Aj = $data['Aj'];
    $Cj = $data['Cj'];
    $hasilAkhir = $data['hasilAkhir'];
    $tfn = $data['tfn'];
    return view("Fuzzy_Topsis.seleksi_awal_ft4",['Aj'=>$Aj,'Cj'=>$Cj,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
  }


  public function FPIS_FNIS(){
    $data = $this->PBHNFDM();
    $Aj = $data['Aj'];
    $Cj = $data['Cj'];
    $hasilAkhir = $data['hasilAkhir'];
    $tfn = $data['tfn'];
    return view("Fuzzy_Topsis.seleksi_awal_ft5",['Aj'=>$Aj,'Cj'=>$Cj,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
  }


  public function jarak_FPIS_FNIS(){
    $data = $this->FPIS_FNIS();
    $Aj = $data['Aj'];
    $Cj = $data['Cj'];
    $hasilAkhir = $data['hasilAkhir'];
    $tfn = $data['tfn'];
    return view("Fuzzy_Topsis.seleksi_awal_ft6",['Aj'=>$Aj,'Cj'=>$Cj,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
  }


  public function hasilAwal()
  {
  $saw = DimPenilaian::selectRaw("
  askm_dim_penilaian.akumulasi_skor,
  askm_dim_penilaian.dim_id,
  askm_dim_penilaian.ta,
  askm_dim_penilaian.sem_ta");
  $query = AdakRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm as skkm,dimx_dim.dim_id,dimx_dim.nama,adak_registrasi.ta,adak_registrasi.nr AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
    ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
    ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
    ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
        $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
        $query->on('p.ta', '=', 'adak_registrasi.ta');
        $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
    })
    ->orderBy('dimx_dim.nama','asc')
    ->get();

  $tfn = [
    "Very High"=>[7,9,9],
    "High"=>[5,7,9],
    "Average"=>[3,5,7],
    "Low"=>[1,3,5],
    "Very Low"=>[1,1,3]
  ];

  $hasilAkhir = [];
  foreach ($query as $s) {
    $valMatch = null;
    $seperK = null;
    $valMatchMax = null;

    if ($s['ta'] == 2017 && $s['sem_ta']== 2 || $s['sem_ta']== 1) {
      if ($s['nr'] >= 3.50 && $s['nr'] <= 4.00) {
        $valMatch = $tfn['Very High'][0];
        $seperK = $tfn['Very High'][1];
        $valMatchMax = $tfn['Very High'][2];
      }elseif($s['nr'] >= 3.00 && $s['nr'] <=3.49){
        $valMatch = $tfn['High'][0];
        $seperK = $tfn['High'][1];
        $valMatchMax = $tfn['High'][2];
      }elseif( $s['nr'] >= 2.00 && $s['nr'] <= 2.99){
        $valMatch = $tfn['Average'][0];
        $seperK = $tfn['Average'][1];
        $valMatchMax = $tfn['Average'][2];
      }elseif( $s['nr'] >= 1.00 && $s['nr'] <=1.99){
        $valMatch = $tfn['Low'][0];
        $seperK = $tfn['Low'][1];
        $valMatchMax = $tfn['Low'][2];
      }elseif($s['nr'] >= 0.00 && $s['nr'] <=0.99){
        $valMatch = $tfn['Very Low'][0];
        $seperK = $tfn['Very Low'][1];
        $valMatchMax = $tfn['Very Low'][2];
      }

      if(isset($valMatch)){
        /* Menghitung nilai minimal test_ip */
        if ((!isset($hasilAkhir[$s['nama']]["test_ip_min"])) || ($hasilAkhir[$s['nama']]["test_ip_min"] > $valMatch)) {
          $hasilAkhir[$s['nama']]["test_ip_min"] = $valMatch;
        }

        /* Menghitung total test_ip */
        if (!isset($hasilAkhir[$s['nama']]["total_test_ip"])) {
          $hasilAkhir[$s['nama']]["total_test_ip"] = $seperK;
        } else {
          $hasilAkhir[$s['nama']]["total_test_ip"] += $seperK;
        }

        /* Mencari Maximal IP */
        if ((!isset($hailAkhir[$s['nama']]['test_ip_max'])) || ($hasilAkhir[$s['nama']]['test_ip_max'] < $valMatchMax)) {
          $hasilAkhir[$s['nama']]['test_ip_max'] = $valMatchMax;
        }
      }
    }

    $valMatch = null;
    $seperK = null;
    $valMatchMax = null;
    if ($s['ta'] == 2017 && $s['sem_ta']==2 || $s['sem_ta']==1) {
      //  Very Low
      if($s['akumulasi_skor'] >=0 && $s['akumulasi_skor'] <=5){
        $valMatch = $tfn['Very High'][0];
        $seperK = $tfn['Very High'][1];
        $valMatchMax = $tfn['Very High'][2];
      }elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10){
        $valMatch = $tfn['High'][0];
        $seperK = $tfn['High'][1];
        $valMatchMax = $tfn['High'][2];
      }elseif( $s['akumulasi_skor'] >=11 && $s['akumulasi_skor'] <=15){
        $valMatch = $tfn['Average'][0];
        $seperK = $tfn['Average'][1];
        $valMatchMax = $tfn['Average'][2];
      }elseif( $s['akumulasi_skor'] >=16 && $s['akumulasi_skor'] <=25){
        $valMatch = $tfn['Low'][0];
        $seperK = $tfn['Low'][1];
        $valMatchMax = $tfn['Low'][2];
      }elseif( $s['akumulasi_skor'] >=26 && $s['akumulasi_skor'] <= 100){
        $valMatch = $tfn['Very Low'][0];
        $seperK = $tfn['Very Low'][1];
        $valMatchMax = $tfn['Very Low'][2];
      }
    }
    if(isset($valMatch)){
      /* Menghitung nilai minimal test_perilaku */
      if ((!isset($hasilAkhir[$s['nama']]["test_prilaku_min"])) || ($hasilAkhir[$s['nama']]["test_prilaku_min"] > $valMatch)) {
        $hasilAkhir[$s['nama']]["test_prilaku_min"] = $valMatch;
      }

      /* Menghitung total test_perilaku */
      if (!isset($hasilAkhir[$s['nama']]["total_test_prilaku"])) {
        $hasilAkhir[$s['nama']]["total_test_prilaku"] = $seperK;
      } else {
        $hasilAkhir[$s['nama']]["total_test_prilaku"] += $seperK;
      }
      if ((!isset($hasilAkhir[$s['nama']]['test_prilaku_max'])) || ($hasilAkhir[$s['nama']]['test_prilaku_max'] < $valMatchMax)) {
        $hasilAkhir[$s['nama']]['test_prilaku_max'] = $valMatchMax;
      }
    }
  }

    foreach ($hasilAkhir as $key => $value) {
      $Cij[] = $value['test_ip_max'];
      $Aij[] = $value['test_prilaku_min'];
    }

    $Cj = max($Cij);
    $Aj = min($Aij);

    foreach ($hasilAkhir as $key => $value) {
      $Rij1_IP[] = $tfn['Very High'][0] * $value['test_ip_min'] / $Cj;
      $Rij2_IP[] = $tfn['Very High'][1] * (1/3 * $value['total_test_ip']) / $Cj;
      $Rij3_IP[] = $tfn['Very High'][2] * $value['test_ip_max'] / $Cj;

      $Rij1_Prilaku[] = $tfn['Very Low'][2] * $Aj / $value['test_prilaku_min'];
      $Rij2_Prilaku[] = $tfn['Very Low'][1] * $Aj / (1/3 * $value['total_test_prilaku']);
      $Rij3_Prilaku[] = $tfn['Very Low'][0] * $Aj / $value['test_prilaku_max'];
    }

    $FPIS_IP_dan_Prilaku = [max($Rij1_IP), max($Rij2_IP), max($Rij3_IP), max($Rij3_Prilaku), max($Rij2_Prilaku), max($Rij1_Prilaku)];
    $FNIS_IP_dan_Prilaku = [min($Rij1_IP), min($Rij2_IP), min($Rij3_IP), min($Rij3_Prilaku), min($Rij2_Prilaku), min($Rij1_Prilaku)];

    foreach ($hasilAkhir as $key => $value) {
      //FPIS IP
      $fpis1 = pow($tfn['Very High'][0] * $value['test_ip_min'] / $Cj - $FPIS_IP_dan_Prilaku[0], 2);
      $fpis2 = pow($tfn['Very High'][1] * (1/3 * $value['total_test_ip']) / $Cj - $FPIS_IP_dan_Prilaku[1], 2);
      $fpis3 = pow($tfn['Very High'][2] * $value['test_ip_max'] / $Cj - $FPIS_IP_dan_Prilaku[2], 2);
      $totalIP_fpis = sqrt(1/3 * ($fpis1 + $fpis2 + $fpis3));
      //FPIS PRILAKU
      $fpis11 = pow($tfn['Very Low'][2] * $Aj / $value['test_prilaku_min'] - $FPIS_IP_dan_Prilaku[3], 2);
      $fpis12 = pow($tfn['Very Low'][1] * $Aj / (1/3 * $value['total_test_prilaku']) - $FPIS_IP_dan_Prilaku[4], 2);
      $fpis13 = pow($tfn['Very Low'][0] * $Aj / $value['test_prilaku_max'] - $FPIS_IP_dan_Prilaku[5], 2);
      $totalPrilaku_fpis = sqrt(1/3 * ($fpis11 + $fpis12 + $fpis13));
      //FNIS IP
      $fnis1 = pow($tfn['Very High'][0] * $value['test_ip_min'] / $Cj - $FNIS_IP_dan_Prilaku[0], 2);
      $fnis2 = pow($tfn['Very High'][1] * (1/3 * $value['total_test_ip']) / $Cj - $FNIS_IP_dan_Prilaku[1], 2);
      $fnis3 = pow($tfn['Very High'][2] * $value['test_ip_max'] / $Cj - $FNIS_IP_dan_Prilaku[2], 2);
      $totalIP_fnis = sqrt(1/3 * ($fnis1 + $fnis2 + $fnis3));
      //FNIS PRILAKU
      $fnis11 = pow($tfn['Very Low'][0] * $Aj / $value['test_prilaku_min'] - $FNIS_IP_dan_Prilaku[3],2);
      $fnis12 = pow($tfn['Very Low'][1] * $Aj / (1/3 * $value['total_test_prilaku']) - $FNIS_IP_dan_Prilaku[4],2);
      $fnis13 = pow($tfn['Very Low'][2] * $Aj / $value['test_prilaku_max'] - $FNIS_IP_dan_Prilaku[5],2);
      $totalPrilaku_fnis = sqrt( 1/3 * ($fnis11 + $fnis12 + $fnis13));

      $dBintang = $totalIP_fpis + $totalPrilaku_fpis;
      $dmin = $totalIP_fnis + $totalPrilaku_fnis;
      $Cci[] = $dmin / ($dmin + $dBintang);
    }

    $saw2 = DimPenilaian::selectRaw("
    askm_dim_penilaian.akumulasi_skor,
    askm_dim_penilaian.dim_id,
    askm_dim_penilaian.ta,
    askm_dim_penilaian.sem_ta");
    $query2 = AdakRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm,dimx_dim.nim,dimx_dim.dim_id, dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK,
    adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
      ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
      ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
      ->leftJoin(\DB::raw("(" . $saw2->toSql() . ") as p"), function ($query2) {
          $query2->on('p.dim_id', '=', 'adak_registrasi.dim_id');
          $query2->on('p.ta', '=', 'adak_registrasi.ta');
          $query2->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
      })
      ->orderBy('dimx_dim.nama','asc')
      ->groupBy('dimx_dim.dim_id')
      ->get();

    foreach ($query2 as $key => $value) {
      $data_mahasiswa[] = $value;
    }



    foreach ($data_mahasiswa as $key => &$value) {
      $value["cci"] = $Cci[$key];
    }

    $key = array_column($data_mahasiswa, 'cci');
    array_multisort($key, SORT_DESC, $data_mahasiswa);
    $krt2 = array_slice($data_mahasiswa, 0, 20);

    return view('Fuzzy_Topsis.seleksi_awal_ft7',['krt2'=>$krt2]);
  }



  public function hasilAkhirFT()
  {
    $data = $this->hasilAwal();
    $dtMhs = $data['krt2'];

    $tfn = [
      "Very High"=>[7,9,9],
      "High"=>[5,7,9],
      "Average"=>[3,5,7],
      "Low"=>[1,3,5],
      "Very Low"=>[1,1,3]
    ];


    $hasilAkhir = [];
    foreach ($dtMhs as $s) {
    $valMatch = null;
    $seperK = null;
    $valMatchMax = null;

      if ($s['cci'] >= 0.81 && $s['cci'] <= 1) {
        $valMatch = $tfn['Very High'][0];
        $seperK = $tfn['Very High'][1];
        $valMatchMax = $tfn['Very High'][2];
      }elseif($s['cci'] >= 0.61 && $s['cci'] <= 0.80){
        $valMatch = $tfn['High'][0];
        $seperK = $tfn['High'][1];
        $valMatchMax = $tfn['High'][2];
      }elseif( $s['cci'] >= 0.41 && $s['cci'] <= 0.60){
        $valMatch = $tfn['Average'][0];
        $seperK = $tfn['Average'][1];
        $valMatchMax = $tfn['Average'][2];
      }elseif( $s['cci'] >= 0.21 && $s['cci'] <= 0.40){
        $valMatch = $tfn['Low'][0];
        $seperK = $tfn['Low'][1];
        $valMatchMax = $tfn['Low'][2];
      }elseif($s['cci'] >= 0.00 && $s['cci'] <= 0.20){
        $valMatch = $tfn['Very Low'][0];
        $seperK = $tfn['Very Low'][1];
        $valMatchMax = $tfn['Very Low'][2];
      }

      if(isset($valMatch)){
        /* Menghitung nilai minimal test_hasilAwal */
        if ((!isset($hasilAkhir[$s['nama']]["test_hasilAwal_min"])) || ($hasilAkhir[$s['nama']]["test_hasilAwal_min"] > $valMatch)) {
          $hasilAkhir[$s['nama']]["test_hasilAwal_min"] = $valMatch;
        }

        /* Menghitung total test_hasilAwal */
        if (!isset($hasilAkhir[$s['nama']]["total_test_hasilAwal"])) {
          $hasilAkhir[$s['nama']]["total_test_hasilAwal"] = $seperK;
        } else {
          $hasilAkhir[$s['nama']]["total_test_hasilAwal"] += $seperK;
        }

        /* Mencari Maximal hasilAwal */
        if ((!isset($hailAkhir[$s['nama']]['test_hasilAwal_max'])) || ($hasilAkhir[$s['nama']]['test_hasilAwal_max'] < $valMatchMax)) {
          $hasilAkhir[$s['nama']]['test_hasilAwal_max'] = $valMatchMax;
        }
      }

      $valMatch = null;
      $seperK = null;
      $valMatchMax = null;

      if($s['skkm'] > 35){
        $valMatch = $tfn['Very High'][0];
        $seperK = $tfn['Very High'][1];
        $valMatchMax = $tfn['Very High'][2];
      }
      elseif($s['skkm'] >= 29 && $s['skkm'] <=35){
        $valMatch = $tfn['High'][0];
        $seperK = $tfn['High'][1];
        $valMatchMax = $tfn['High'][2];
      }
      elseif($s['skkm'] >= 22 && $s['skkm'] <= 28){
        $valMatch = $tfn['Average'][0];
        $seperK = $tfn['Average'][1];
        $valMatchMax = $tfn['Average'][2];
      }
      elseif($s['skkm'] >= 15 && $s['skkm'] <= 21){
        $valMatch = $tfn['Low'][0];
        $seperK = $tfn['Low'][1];
        $valMatchMax = $tfn['Low'][2];
      }
      elseif($s['skkm'] >= 8 && $s['skkm'] <=14){
        $valMatch = $tfn['Very Low'][0];
        $seperK = $tfn['Very Low'][1];
        $valMatchMax = $tfn['Very Low'][2];
      }

      if(isset($valMatch)){
        /* Menghitung nilai minimal test_perilaku */
        if ((!isset($hasilAkhir[$s['nama']]["test_skkm_min"])) || ($hasilAkhir[$s['nama']]["test_skkm_min"] > $valMatch)) {
          $hasilAkhir[$s['nama']]["test_skkm_min"] = $valMatch;
        }

        /* Menghitung total test_perilaku */
        if (!isset($hasilAkhir[$s['nama']]["total_test_skkm"])) {
          $hasilAkhir[$s['nama']]["total_test_skkm"] = $seperK;
        } else {
          $hasilAkhir[$s['nama']]["total_test_prilaku"] += $seperK;
        }
        if ((!isset($hasilAkhir[$s['nama']]['test_skkm_max'])) || ($hasilAkhir[$s['nama']]['test_skkm_max'] < $valMatchMax)) {
          $hasilAkhir[$s['nama']]['test_skkm_max'] = $valMatchMax;
        }
      }
    }


    foreach ($hasilAkhir as $key => $value) {
    $Cij[] = $value['test_hasilAwal_max'];
    $Aij[] = $value['test_skkm_max'];
    }

    $Cj = max($Cij);
    $Aj = max($Aij);

    foreach($hasilAkhir as $key => $value){
      $a[] = $tfn['Very High'][0] * $value['test_hasilAwal_min'] / $Cj;
      $b[] = $tfn['Very High'][1] * $value['total_test_hasilAwal'] / $Cj;
      $c[] = $tfn['Very High'][2] * $value['test_hasilAwal_max'] / $Cj;

      $d[] = $tfn['Very High'][0] * $value['test_skkm_min'] / $Aj;
      $e[] = $tfn['Very High'][1] * $value['total_test_skkm'] / $Aj;
      $f[] = $tfn['Very High'][2] * $value['test_skkm_max'] / $Aj;
    }

    $FPISHA = [max($a),max($b),max($c)];
    $FPISSKKM = [max($d),max($e),max($f)];

    $FNISHA = [min($a),min($b),min($c)];
    $FNISSKKM = [min($d),min($e),min($f)];

    foreach($hasilAkhir as $key => $value){
      //FPIS
      $aa = pow(($tfn['Very High'][0] * $value['test_hasilAwal_min'] / $Cj) - $FPISHA[0], 2);
      $bb = pow(($tfn['Very High'][1] * $value['total_test_hasilAwal'] / $Cj) - $FPISHA[1], 2);
      $cc = pow(($tfn['Very High'][2] * $value['test_hasilAwal_max'] / $Cj) - $FPISHA[2], 2);
      $ttlHslAwl = sqrt(1/3 * ($aa + $bb + $cc));

      $dd = pow(($tfn['Very High'][0] * $value['test_skkm_min'] / $Aj) - $FPISSKKM[0], 2);
      $ee = pow(($tfn['Very High'][1] * $value['total_test_skkm'] / $Aj) - $FPISSKKM[1], 2);
      $ff = pow(($tfn['Very High'][2] * $value['test_skkm_max'] / $Aj) - $FPISSKKM[2], 2);
      $ttlSkkm = sqrt(1/3  * ($dd + $ee + $ff));
      //FNIS
      $aa = pow(($tfn['Very High'][0] * $value['test_hasilAwal_min'] / $Cj) - $FNISHA[0], 2);
      $bb = pow(($tfn['Very High'][1] * $value['total_test_hasilAwal'] / $Cj) - $FNISHA[1], 2);
      $cc = pow(($tfn['Very High'][2] * $value['test_hasilAwal_max'] / $Cj) - $FNISHA[2], 2);
      $ttlHslAwl2 = sqrt(1/3 * ($aa + $bb + $cc));

      $dd = pow(($tfn['Very High'][0] * $value['test_skkm_min'] / $Aj) - $FNISSKKM[0], 2);
      $ee = pow(($tfn['Very High'][1] * $value['total_test_skkm'] / $Aj) - $FNISSKKM[1], 2);
      $ff = pow(($tfn['Very High'][2] * $value['test_skkm_max'] / $Aj) - $FNISSKKM[2], 2);
      $ttlSkkm2 = sqrt(1/3  * ($dd + $ee + $ff));

      $dStar = $ttlHslAwl + $ttlSkkm;
      $dmin = $ttlHslAwl2 + $ttlSkkm2;
      $Cci[] = $dmin / ($dmin - $dStar);
    }

    foreach ($dtMhs as $key => $value) {
      $dataMhs2[] = $value;
    }


    foreach ($dataMhs2 as $key => $value) {
      $data_mahasiswa[] = $value;
    }

    foreach ($data_mahasiswa as $key => &$value) {
      $value["cci2"] = $Cci[$key];
    }

    $key = array_column($data_mahasiswa, 'cci2');

    array_multisort($key, SORT_DESC, $data_mahasiswa);
    $krt2 = array_slice($data_mahasiswa, 0, 10);


    // $combineData2 = array_combine($data_mahasiswa, $Cci);
    //
    //
    // arsort($combineData2);

    // $krt2 = array_slice($combineData2, 0,10);
    return view('Fuzzy_Topsis.hasil_akhir_ft',['hasilAkhir'=>$hasilAkhir,'tfn'=>$tfn,'Cj'=>$Cj,'Aj'=>$Aj,'hasilFinals' => $krt2]);
  }
}
