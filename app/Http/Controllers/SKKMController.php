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
    $data->Mahasiswa();
    $skkm_ = skkm::find($id);
    if(($skkm_ != null) && ($data != null )) {
      $skkm_->delete();
      return redirect()->back();
    }

    return redirect()->back();
  }



  public function hapus_skkm($id){
    $data = new Controller();
    $data->Mahasiswa();
    $skkm_ = skkm::find($id);
    if(($skkm_ != null) && ($data != null )) {
      $skkm_->delete();
        return view('sawPage',['vdata'=>$skkm_,'krt'=>$data]);
    }

    return view('sawPage',['vdata'=>$skkm_,'krt'=>$data]);
  }

  public function hasil_skkm()
    {
        $saw = DimPenilaian::selectRaw("
      askm_dim_penilaian.akumulasi_skor,
      askm_dim_penilaian.dim_id,
      askm_dim_penilaian.ta,
      askm_dim_penilaian.sem_ta");
        $query = AdakRegistrasi::selectRaw("skkm.skkm, dimx_dim.dim_id, dimx_dim.nama,adak_registrasi.ta,(SUM(adak_registrasi.nr)/4) AS IPK, adak_registrasi.sem_ta, adak_registrasi.nr, p.akumulasi_skor")
            ->join('dimx_dim', 'dimx_dim.dim_id', 'adak_registrasi.dim_id')
            ->leftJoin('skkm', 'skkm.dim_id', 'dimx_dim.dim_id')
            ->leftJoin(\DB::raw("(" . $saw->toSql() . ") as p"), function ($query) {
                $query->on('p.dim_id', '=', 'adak_registrasi.dim_id');
                $query->on('p.ta', '=', 'adak_registrasi.ta');
                $query->on('p.sem_ta', '=', 'adak_registrasi.sem_ta');
            })
            ->groupBy('dimx_dim.dim_id')
            ->get();

        $arrayMahasiswa = array();
        $arraySkkm = array();

        $max = (float)$query[0]['IPK'];
        $min = $query[0]['akumulasi_skor'];
        foreach($query as $data){
            if($data['IPK'] > $max){ $max = $data['IPK'];}
            if($data['akumulasi_skor'] < $min){ $min = $data['akumulasi_skor'];}
        }

        $max_nilai = 0;
        $max_skkm = 0;
        foreach ($query as $item) {
            $normalisasi = number_format(($item['IPK'] / $max), 2);
            if($min>0){
              $normali = number_format(($min / $item['akumulasi_skor']), 2);
            }else{
              $normali = 0;
            }

            $total = number_format((float)((0.5 * $normalisasi) + (0.5 *$normali)), 2);
            if($total>$max_nilai){
              $max_nilai = $total;
            }

            if($item['skkm']>$max_skkm){
              $max_skkm = $item['skkm'];
            }
        }

        foreach ($query as $item) {
          $normalisasi = number_format(($item['IPK'] / $max), 2);
          if($min>0){
            $normali = number_format(($min / $item['akumulasi_skor']), 2);
          }else{
            $normali = 0;
          }

          $total = number_format((float)((0.5 * $normalisasi) + (0.5 *$normali)), 2);

          $nilai_akhir = $total/$max_nilai;
          $skkm = $item['skkm']/$max_skkm;

          $hasil = number_format((float)((0.5 * $nilai_akhir) + (0.5 *$skkm)), 2);

          $arraySkkm[] = $hasil;
      }

        foreach ($query as $item) {
            $arrayMahasiswa[] = $item;
        }

        $combineData = array_combine($arraySkkm, $arrayMahasiswa);
        krsort($combineData);
        $krt = array_slice($combineData, 0, 10);

        return view('sawPage', ['vdata' => $saw])->with(compact('krt'));
    }

}
