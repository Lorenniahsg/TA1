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

    public function hasilAwal(){
      $dimx_dim = DimPenilaian::selectRaw("
      askm_dim_penilaian.akumulasi_skor,
      askm_dim_penilaian.dim_id,
      askm_dim_penilaian.ta,
      askm_dim_penilaian.sem_ta");
        $query = AdakRegistrasi::selectRaw("dimx_dim.nama,adak_registrasi.ta,adak_registrasi.nr AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")

            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
            ->leftJoin(\DB::raw("(" . $dimx_dim->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })
            ->orderBy('dimx_dim.nama','asc')
            ->get();




      $data = $this->jarak_FPIS_FNIS();
      $Aj = $data['Aj'];
      $Cj = $data['Cj'];

      $hasilAkhir = $data['hasilAkhir'];
      $tfn = $data['tfn'];

      return view("seleksi_awal_ft7",['Aj'=>$Aj,'Cj'=>$Cj,'semua'=>$data,'tfn'=>$tfn,'hasilAkhir'=>$hasilAkhir]);
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
        $query = AdakRegistrasi::selectRaw("dimx_dim.nama,adak_registrasi.ta,adak_registrasi.nr AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")

            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
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
            if ($s['nr'] >= 3.30 && $s['nr'] <= 4.00) {
              $valMatch = $tfn['Very High'][0];
              $seperK = $tfn['Very High'][1];
              $valMatchMax = $tfn['Very High'][2];
            }elseif($s['nr'] >= 2.50 && $s['nr'] <=3.29){
              $valMatch = $tfn['High'][0];
              $seperK = $tfn['High'][1];
              $valMatchMax = $tfn['High'][2];
            }elseif( $s['nr'] >= 1.70 && $s['nr'] <= 2.49){
              $valMatch = $tfn['Average'][0];
              $seperK = $tfn['Average'][1];
              $valMatchMax = $tfn['Average'][2];
            }elseif( $s['nr'] >= 0.90 && $s['nr'] <=1.69){
              $valMatch = $tfn['Low'][0];
              $seperK = $tfn['Low'][1];
              $valMatchMax = $tfn['Low'][2];
            }elseif($s['nr'] >= 0.0 && $s['nr'] <=0.89){
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
              $valMatch = $tfn['Very Low'][0];
              $seperK = $tfn['Very Low'][1];
              $valMatchMax = $tfn['Very Low'][2];
            }elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10){
              $valMatch = $tfn['Low'][0];
              $seperK = $tfn['Low'][1];
              $valMatchMax = $tfn['Low'][2];
            }elseif( $s['akumulasi_skor'] >=11 && $s['akumulasi_skor'] <=15){
              $valMatch = $tfn['Average'][0];
              $seperK = $tfn['Average'][1];
              $valMatchMax = $tfn['Average'][2];
            }elseif( $s['akumulasi_skor'] >=16 && $s['akumulasi_skor'] <=25){
              $valMatch = $tfn['High'][0];
              $seperK = $tfn['High'][1];
              $valMatchMax = $tfn['High'][2];
            }elseif( $s['akumulasi_skor'] >=26 && $s['akumulasi_skor'] <= 100){
              $valMatch = $tfn['Very High'][0];
              $seperK = $tfn['Very High'][1];
              $valMatchMax = $tfn['Very High'][2];
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
            ->orderBy('dimx_dim.nama','asc')
            ->groupBy('dimx_dim.dim_id')
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
        $query = AdakRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm, dimx_dim.dim_id, dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
            ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })
            ->groupBy('dimx_dim.dim_id')
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
