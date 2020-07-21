<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DimPenilaian;
use App\AdakRegistrasi;

class SawController extends Controller
{
    public function index(){
      $saw = DimPenilaian::selectRaw("
      askm_dim_penilaian.akumulasi_skor,
      askm_dim_penilaian.dim_id,
      askm_dim_penilaian.ta,
      askm_dim_penilaian.sem_ta");
      $query = AdakRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm as skkm,dimx_dim.dim_id,dimx_dim.nama,
      adak_registrasi.ta,adak_registrasi.nr AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
        ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
        ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
        ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
          $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
          $query->on('p.ta', '=', 'adak_registrasi.ta');
          $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
          })
        ->orderBy('dimx_dim.nama','asc')
        ->get();

        $dataM = [];
        foreach ($query as $dt_mhs) {
          $ipsem1;
          $ipsem2;
          $ipsem3;

          if ($dt_mhs['ta'] == 2017 && $dt_mhs['sem_ta'] == 1) {
            $ipsem1 = $dt_mhs['nr'];
          }
          if ($dt_mhs['ta'] == 2017 && $dt_mhs['sem_ta'] == 2) {
            $ipsem2 = $dt_mhs['nr'];
          }
          if ($dt_mhs['ta'] == 2018 && $dt_mhs['sem_ta'] == 1) {
            $ipsem3 = $dt_mhs['nr'];
          }
          if (isset($ipsem1)) {
            $dataM[$dt_mhs['nama']]['ipsem1'] = $ipsem1;
          }
          if (isset($ipsem2)) {
            $dataM[$dt_mhs['nama']]['ipsem2'] = $ipsem2;
          }
          if (isset($ipsem3)) {
            $dataM[$dt_mhs['nama']]['ipsem3'] = $ipsem3;
          }
        }

        foreach ($dataM as $key => $value) {
          $IPK[] = ($value['ipsem1'] + $value['ipsem2'] + $value['ipsem3']) / 3;
        }

        $saw2 = DimPenilaian::selectRaw("
        askm_dim_penilaian.akumulasi_skor,
        askm_dim_penilaian.dim_id,
        askm_dim_penilaian.ta,
        askm_dim_penilaian.sem_ta");
        $query2 = AdakRegistrasi::selectRaw("skkm.id AS skkm_id,skkm.skkm,dimx_dim.dim_id,dimx_dim.nim,dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK,
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

        foreach ($query2 as $key) {
          $data_mahasiswa[] = $key;
        }

        foreach ($data_mahasiswa as $key => &$value) {
          $value["ipTotal"] = $IPK[$key];
        }
      return view('SAW.sawPage', ['dataMahasiswa' => $data_mahasiswa]);
    }


    public function PenilaianSaw()
    {
      $data = $this->index();
      $dataDetail = $data['dataMahasiswa'];

      foreach ($dataDetail as $key => $value) {
        $dataMahasiswas[] = $value;
        $IP_max[] = $value['ipTotal'];
        $Prilaku_min[] = $value['akumulasi_skor'];
      }

      foreach ($dataDetail as $key => $value) {
        $IP = ($value['ipTotal'] / max($IP_max)) * 0.5;
        if ($value['akumulasi_skor'] == 0) {
          $value['akumulasi_skor'] = 0.001;
        }
        $Prilaku = (min($Prilaku_min) / $value['akumulasi_skor']) * 0.5;
        $hasil[] = $IP + $Prilaku;
      }

      foreach ($dataMahasiswas as $key => &$value) {
        $value["hasil_awal_saw"] = $hasil[$key];
      }

      $key = array_column($dataMahasiswas, 'hasil_awal_saw');
      array_multisort($key, SORT_DESC, $dataMahasiswas);
      $krt2 = array_slice($dataMahasiswas, 0, 20);
      return view('SAW.seleksi_awal_saw',['data_20_besar'=>$krt2]);
    }

    public function hasilAkhirSaw(){
      $data = $this->PenilaianSaw();
      $dataDtl = $data['data_20_besar'];

      foreach ($dataDtl as $key => $value) {
        $dataMahasiswas[] = $value;
        $hasilAkhirSAW_max[] = $value['hasil_awal_saw'];
        $skkm_max[] = $value['skkm'];
      }


      foreach ($dataDtl as $key => $value) {
        $hasilAkhirSAW = ($value['hasil_awal_saw'] / max($hasilAkhirSAW_max)) * 0.5;
        $skkm = ($value['skkm'] / max($skkm_max)) * 0.5;
        $hasil[] = $hasilAkhirSAW + $skkm;
      }


      foreach ($dataMahasiswas as $key => &$value) {
        $value["hasil_akhir_saw"] = $hasil[$key];
      }

      $key = array_column($dataMahasiswas, 'hasil_akhir_saw');
      array_multisort($key, SORT_DESC, $dataMahasiswas);
      $krt2 = array_slice($dataMahasiswas, 0, 10); 

      return view('SAW.seleksi_akhir_saw',['hasil_akhir_saw'=>$krt2]);
    }
}
