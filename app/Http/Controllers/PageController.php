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
    public function index()
    {
      $data = $this->Kriteria();
      $data = $this->Mahasiswa();
      return view('homepage',['krt_ft'=>$data,'vdata'=>$data]);
    }
    public function fuzzytopsisPage()
    {
      $kriteria_ft = kriteria::all();
      $data = $this->Mahasiswa();
      return view('fuzzytopsisPage',['krt_ft'=>$data,'vdata'=>$kriteria_ft]);
    }
    public function Perbandingan(){
      $ft = $this->hasilAkhirFT();
      $saw = $this->hasilAkhirSAW();

      return view('perbandingan',['Fuzzy_Topsis'=>$ft['hasilFinals'],'saw'=>$saw['hasil_akhir_saw']]);
    }

    public function Kriteria()
    {
      $kriteria_ft = kriteria::all();
      $data = $this->Mahasiswa();
      return view('fuzzytopsisPage',['krt_ft'=>$data,'vdata'=>$kriteria_ft]);
    }

    public function PenilaianFT()
    {
      $ft = DimPenilaian::selectRaw("
      askm_dim_penilaian.akumulasi_skor,
      askm_dim_penilaian.dim_id,
      askm_dim_penilaian.ta,
      askm_dim_penilaian.sem_ta");
        $query = AdakRegistrasi::selectRaw("dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin(\DB::raw("(" . $ft->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })
            ->orderBy('dimx_dim.dim_id', 'desc')
            ->orderBy('adak_registrasi.ta', 'asc')
            ->orderBy('adak_registrasi.sem_ta', 'asc')
            ->groupBy('dimx_dim.dim_id')
            ->get();

        $VeryHigh = [7,9,9];
        $High = [5,7,9];
        $Average = [3,5,7];
        $Low = [1,3,5];
        $VeryLow = [1,1,3];
        foreach($query as $data){
            if($data['IPK'] >=3.30 && $data['IPK'] <=4.00){ $data['IPK'] = $VeryHigh;}
            if($data['IPK'] >=2.50 && $data['IPK'] <=3.29){ $data['IPK'] = $High;}
            if($data['IPK'] >=1.70 && $data['IPK'] <=2.49){ $data['IPK'] = $Average;}
            if($data['IPK'] >=0.90 && $data['IPK'] <=1.69){ $data['IPK'] = $Low;}
            if($data['IPK'] >=0.00 && $data['IPK'] <=0.89){ $data['IPK'] = $VeryLow;}

            if($data['akumulasi_skor'] >= 26){ $data['akumulasi_skor'] = $VeryHigh;}
            if($data['akumulasi_skor'] >=16 && $data['akumulasi_skor'] <=25){ $data['akumulasi_skor'] = $High;}
            if($data['akumulasi_skor'] >=11 && $data['akumulasi_skor'] <=15){ $data['akumulasi_skor'] = $Average;}
            if($data['akumulasi_skor'] >=6 && $data['akumulasi_skor'] <=10){ $data['akumulasi_skor'] = $Low;}
            if($data['akumulasi_skor'] <=5){ $data['akumulasi_skor'] = $VeryLow;}
        }
      return view('fuzzytopsisPage',['krt'=>$query,'vdata'=>$ft]);
    }


    public function PerhitunganFT(){
      $kriteria_ft = kriteria::all();
      $data = $this->Mahasiswa();
      return view('fuzzytopsisPage',['krt_ft'=>$data,'vdata'=>$kriteria_ft]);
    }


    public function edit_ft(){
      $kriteria_ft = kriteria::all();
      return view('fuzzytopsisPage',['vdata'=>$kriteria_ft]);
    }
}
