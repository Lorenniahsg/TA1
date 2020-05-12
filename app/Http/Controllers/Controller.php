<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Kriteria;
use App\SKKM;
use App\Mahasiswa;
use App\DimPenilaian;
use App\AdekRegistrasi;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('homepage');
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
        $query = AdekRegistrasi::selectRaw("dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })
            ->groupBy('dimx_dim.dim_id')
            ->get();

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
        $query = AdekRegistrasi::selectRaw("dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })
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
        $query = AdekRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm, dimx_dim.dim_id, dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
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
