<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Kriteria;
use App\SKKM;
use App\Mahasiswa;
use App\DimPenilaian;
use App\AdakRegistrasi;
use App\DimxDim;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('homepage');
    }

    public function Seleksi_FT()
    {
      $data = $this->PerhitunganFT();
      $hasilAkhir = $data['hasilAkhir'];
      $tfn = $data['tfn'];

      // $paginate = $this->paginate($hasilAkhir, 2);
      return view("seleksi_awal_ft2",['semua'=>$data,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
    }

    public function NFDM(){
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

      return view("seleksi_awal_ft3",['Aj'=>$Aj,'Cj'=>$Cj,'semua'=>$data,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
    }

    public function PBHNFDM(){
      $data = $this->NFDM();
      $Aj = $data['Aj'];
      $Cj = $data['Cj'];

      $hasilAkhir = $data['hasilAkhir'];
      $tfn = $data['tfn'];

      return view("seleksi_awal_ft4",['Aj'=>$Aj,'Cj'=>$Cj,'semua'=>$data,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
    }

    public function FPIS_FNIS(){
      $data = $this->PBHNFDM();
      $Aj = $data['Aj'];
      $Cj = $data['Cj'];

      $hasilAkhir = $data['hasilAkhir'];
      $tfn = $data['tfn'];

      return view("seleksi_awal_ft5",['Aj'=>$Aj,'Cj'=>$Cj,'semua'=>$data,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
    }

    public function jarak_FPIS_FNIS(){
      $data = $this->FPIS_FNIS();
      $Aj = $data['Aj'];
      $Cj = $data['Cj'];

      $hasilAkhir = $data['hasilAkhir'];
      $tfn = $data['tfn'];

      return view("seleksi_awal_ft6",['Aj'=>$Aj,'Cj'=>$Cj,'semua'=>$data,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
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


          $ip = [];
          // $maxIp = (float)$query[0]['IPK'];
          // $minIp = $query[0]['IPK'];
          //
          // $maxPrilaku = $query[0]['akumulasi_skor'];
          // $minPrilaku = $query[0]['akumulasi_skor'];

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

            $totalBintang[] = $dBintang;
            $totalMin[] = $dmin;
            $Cci[] = $dmin / ($dmin + $dBintang);

          }

          $saw2 = DimPenilaian::selectRaw("
        askm_dim_penilaian.akumulasi_skor,
        askm_dim_penilaian.dim_id,
        askm_dim_penilaian.ta,
        askm_dim_penilaian.sem_ta");
          $query2 = AdakRegistrasi::selectRaw("skkm.skkm, dimx_dim.dim_id, dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
              ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
              ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
              ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
                  $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                  $query->on('p.ta', '=', 'adak_registrasi.ta');
                  $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
              })
              ->orderBy('dimx_dim.nama','asc')
              ->groupBy('dimx_dim.dim_id')
              ->get();

          foreach ($query2 as $key) {
            $data_mahasiswa[] = $key;
          }


          $combineData = array_combine($Cci,$data_mahasiswa);

          krsort($combineData);
          $krt = array_slice($combineData, 0, 20);




          return view('seleksi_awal_ft7')->with(compact('krt'));
    }

    // public function paginate($items, int $perPage) : LengthAwarePaginator
    // {
    //   $items = $items instanceof Collection ? $items : Collection::make($items);
    //
    //   $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //
    //   $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);
    //
    //   $paginator = new LengthAwarePaginator(
    //
    //     $currentPageItems, $items->count(), $perPage, $currentPage
    //   );
    //   return $paginator;
    // }

    public function PerhitunganFT()
    {
      $dimx_dim = DimPenilaian::selectRaw("
      askm_dim_penilaian.akumulasi_skor,
      askm_dim_penilaian.dim_id,
      askm_dim_penilaian.ta,
      askm_dim_penilaian.sem_ta");
        $query = AdakRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm,dimx_dim.nama,dimx_dim.dim_id,adak_registrasi.ta,adak_registrasi.nr AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")

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

      return view("seleksi_awal_ft",['semua'=>$query,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
    }


    public function sawPage()
    {
        $kriteria_saw = kriteria::all();
        $data = $this->Mahasiswa();

        return view('sawPage', ['krt' => $data], ['vdata' => $kriteria_saw]);
    }

    public function Penilaian()
    {
        $saw = DimPenilaian::selectRaw("
      askm_dim_penilaian.akumulasi_skor,
      askm_dim_penilaian.dim_id,
      askm_dim_penilaian.ta,
      askm_dim_penilaian.sem_ta");
        $query = AdakRegistrasi::selectRaw("dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })

            ->orderBy('dimx_dim.nama','asc')
            ->groupBy('dimx_dim.dim_id')
            ->get();
              // dd(array_search('Ruben Manurung', $query));
            // dd($query[0]);
        $arrayNilaiAkhir = array();
        $arrayMahasiswa = array();

        $max = (float)$query[0]['IPK'];
        $min = $query[0]['akumulasi_skor'];
        foreach($query as $data){
            if($data['IPK'] > $max){ $max = $data['IPK'];}
            if($data['akumulasi_skor'] < $min){ $min = $data['akumulasi_skor'];}
        }
        foreach ($query as $item) {
            $normalisasi = number_format(($item['IPK'] / $max), 2);
            if($min>0){
                $normali = number_format(($min / $item['akumulasi_skor']), 2);
            }else{
                $normali = 0;
            }

            $total = number_format((float)((0.5 * $normalisasi) + (0.5 *$normali)), 2);

            $arrayNilaiAkhir[] = $total;
        }
        foreach ($query as $item) {
            $arrayMahasiswa[] = $item;
        }
        $combineData = array_combine($arrayNilaiAkhir, $arrayMahasiswa);

        krsort($combineData);
        $krt = array_slice($combineData, 0, 20);

        return view('sawPage', ['vdata' => $saw])->with(compact('krt'));
    }



    public function Mahasiswa()
    {
        $saw = DimPenilaian::selectRaw("
      askm_dim_penilaian.akumulasi_skor,
      askm_dim_penilaian.dim_id,
      askm_dim_penilaian.ta,
      askm_dim_penilaian.sem_ta");
        $query = AdakRegistrasi::selectRaw("dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })
            ->where('adak_registrasi.ta','=',2017)
            ->orWhere('adak_registrasi.sem_ta','=',2)
            ->orWhere('adak_registrasi.sem_ta','=',1)
            ->groupBy('dimx_dim.dim_id')
            ->orderBy('dimx_dim.nama','asc')
            ->get();
            return view('sawPage', ['krt' => $query], ['vdata' => $saw]);
    }

    public function Skkm()
    {
        $saw = DimPenilaian::selectRaw("
      askm_dim_penilaian.akumulasi_skor,
      askm_dim_penilaian.dim_id,
      askm_dim_penilaian.ta,
      askm_dim_penilaian.sem_ta");
        $query = AdakRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm, dimx_dim.dim_id, dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/3) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
            ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })
            ->orWhere('adak_registrasi.ta','=',2017)
            ->Where('adak_registrasi.sem_ta','=',2)
            ->orWhere('adak_registrasi.sem_ta','=',1)
            ->groupBy('dimx_dim.dim_id')
            ->orderBy('dimx_dim.nama','asc')
            ->get();





            $arrayNilaiAkhir = array();
            $arrayMahasiswa = array();
            $arraySkkm = array();

            $max = (float)$query[0]['IPK'];
            $min = $query[0]['akumulasi_skor'];
            foreach($query as $data){
                if($data['IPK'] > $max){ $max = $data['IPK'];}
                if($data['akumulasi_skor'] < $min){ $min = $data['akumulasi_skor'];}
            }

            foreach ($query as $item) {
                $normalisasi = number_format(($item['IPK'] / $max), 2);
                if($min>0){
                    $normali = number_format(($min / $item['akumulasi_skor']), 2);
                }else{
                    $normali = 0;
                }

                $total = number_format((float)((0.5 * $normalisasi) + (0.5 *$normali)), 2);

                $arrayNilaiAkhir[] = $total;

                $hasilSeleksiSkkm = number_format((float)((0.5 * $total) + (0.5 *$item['skkm'])), 2);
                $arraySkkm[] = $hasilSeleksiSkkm;
            }

            foreach ($query as $item) {
                $arrayMahasiswa[] = $item;
            }

            $combineData = array_combine($arrayNilaiAkhir, $arrayMahasiswa);
            krsort($combineData);



            $krt = array_slice($combineData, 0, 20);


            return view('sawPage', ['vdata' => $saw])->with(compact('krt'));
    }

}
