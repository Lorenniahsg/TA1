@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

  <!-- Header -->
  <header class="intro-header text-black">

  </header>
  <!-- END : Header -->
@endsection
<br><br><br><br><br>

<div class="container">
  <ul class="nav nav-tabs" role="tablist">
    <!-- <li class="nav-item">
      <a class="nav-link" href="{{ url('MahasiswaFT') }}" role="tab">Data Mahasiswa</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('PenilaianFT') }}" role="tab">Data Penilaian</a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="{{ url('PerhitunganFT') }}" role="tab">Data  Mahasiswa</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="{{ url('test2') }}" role="tab">Seleksi  Mahasiswa</a>
    </li> -->
  </ul>
<a class="btn btn-primary float-right col-sm-6" href="{{ url('hasilAwal')}}">Hasil Awal</a>

  <h1>Jarak FPIS dan FNIS</h1>

  <br><br>
    <?php
      $maxfpis = [];
      $minfniis = []; ?>
        @foreach($hasilAkhir as $key =>$value)
        <?php


        $fpis1 = $tfn['Very High'][0] * $value['test_ip_min'] / $Cj['Cj'];
        $fpis2 = $tfn['Very High'][1] * $value['total_test_ip'] * 1/3 / $Cj['Cj'];
        $fpis3 = $tfn['Very High'][2] * $value['test_ip_max'] / $Cj['Cj'];

        $fnis1 = $tfn['Very Low'][0] * $Aj['Aj'] / $value['test_prilaku_max'];
        $fnis2 = $tfn['Very Low'][1] * ($Aj['Aj'] / ($value['total_test_perilaku'] * 1/3));
        $fnis3 = $tfn['Very Low'][2] * $Aj['Aj'] / $value['test_perilaku_min'];


        if ((!isset($maxfpis[$key]["FPIS_MAX1"])) || ($maxfpis[$key]["FPIS_MAX1"] > $fpis1))
        {
          $maxfpis[$key]["FPIS_MAX1"] = $fpis1;
        }
        if ((!isset($maxfpis[$key]["FPIS_MAX2"])) || ($maxfpis[$key]["FPIS_MAX2"] > $fpis2))
        {
          $maxfpis[$key]["FPIS_MAX2"] = $fpis2;
        }
        if ((!isset($maxfpis[$key]["FPIS_MAX3"])) || ($maxfpis[$key]["FPIS_MAX3"] > $fpis3))
        {
          $maxfpis[$key]["FPIS_MAX3"] = $fpis3;
        }

        if ((!isset($minfnis[$key]["FNIS_MIN1"])) || ($minfnis[$key]["FNIS_MIN1"] < $fnis1))
        {
          $minfnis[$key]["FNIS_MIN1"] = $fnis1;
        }
        if ((!isset($minfnis[$key]["FNIS_MIN2"])) || ($minfnis[$key]["FNIS_MIN2"] < $fnis2))
        {
          $minfnis[$key]["FNIS_MIN2"] = $fnis2;
        }
        if ((!isset($minfnis[$key]["FNIS_MIN3"])) || ($minfnis[$key]["FNIS_MIN3"] < $fnis3))
        {
          $minfnis[$key]["FNIS_MIN3"] = $fnis3;
        }
         ?>
        @endforeach

        <?php
          $fpis_ip = max($maxfpis);
          $fpis_prilaku = max($minfnis);

          $fnis_IP = min($maxfpis);
          $fnis_prilaku = min($minfnis);
          ?>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Nama</th>
        <th>FPIS IPK</th>
        <th>FPIS Prilaku</th>
        <th>FNIS IPK</th>
        <th>FNIS PRILAKU</th>
        <th>d*</th>
        <th>d&macr;</th>
        <th>CCi</th>
      </tr>
    </thead>
    <tbody>
    <tr>
      @foreach($hasilAkhir as $key => $value)
      <?php $b = null; ?>

        <?php
        $fpis1 = pow($tfn['Very High'][0] * $value['test_ip_min'] / $Cj['Cj'] - $fpis_ip['FPIS_MAX1'], 2);
        $fpis2 = pow($tfn['Very High'][1] * $value['total_test_ip'] * 1/3 / $Cj['Cj'] - $fpis_ip['FPIS_MAX2'], 2);
        $fpis3 = pow($tfn['Very High'][2] * $value['test_ip_max'] / $Cj['Cj'] - $fpis_ip['FPIS_MAX3'], 2);
        $totalIP_fpis = sqrt(1/3 * ($fpis1 + $fpis2 + $fpis3));

        $fpis11 = pow($tfn['Very High'][0] * $value['test_ip_min'] / $Cj['Cj'] - $fpis_prilaku['FNIS_MIN1'], 2);
        $fpis22 = pow($tfn['Very High'][1] * $value['total_test_ip'] * 1/3 / $Cj['Cj'] - $fpis_prilaku['FNIS_MIN2'], 2);
        $fpis33 = pow($tfn['Very High'][2] * $value['test_ip_max'] / $Cj['Cj'] - $fpis_prilaku['FNIS_MIN3'], 2);
        $total_prilaku_fpis = sqrt(1/3 * ($fpis11 + $fpis22 + $fpis33));



        $fnis1 = pow($tfn['Very High'][0] * $value['test_ip_min'] / $Cj['Cj'] - $fnis_IP['FPIS_MAX1'], 2);
        $fnis2 = pow($tfn['Very High'][1] * $value['total_test_ip'] * 1/3 / $Cj['Cj'] - $fnis_IP['FPIS_MAX2'], 2);
        $fnis3 = pow($tfn['Very High'][2] * $value['test_ip_max'] / $Cj['Cj'] - $fnis_IP['FPIS_MAX3'], 2);
        $totalIP_fnis = sqrt(1/3 * ($fnis1 + $fnis2 + $fnis3));

        $fnis11 = pow($tfn['Very Low'][0] * $Aj['Aj'] / $value['test_perilaku_min'] - $fnis_prilaku['FNIS_MIN1'],2);
        $fnis22 = pow($tfn['Very Low'][1] * $Aj['Aj'] / $value['total_test_perilaku'] * 1/3 - $fnis_prilaku['FNIS_MIN2'] ,2);
        $fnis33 = pow($tfn['Very Low'][2] * $Aj['Aj'] / $value['test_prilaku_max'] - $fnis_prilaku['FNIS_MIN3'],2);
        $totalpri = sqrt( 1/3 * ($fnis11 + $fnis22 + $fnis33));
        ?>
        <td>{{$key}}</td>
        <td>{{$totalIP_fpis}}</td>
        <td>{{$total_prilaku_fpis}}</td>
        <td>{{$totalIP_fnis}}</td>
        <td>{{$totalpri}}</td>
        <?php $dFPIS = $totalIP_fpis + $total_prilaku_fpis; ?>
        <td>{{$dFPIS}}</td>
        <?php $dFNIS = $totalIP_fnis + $totalpri; ?>
        <td>{{$dFNIS}}</td>
        <?php $Cci = $dFNIS / ($dFNIS + $dFPIS); ?>
        <td>{{$Cci}}</td>
        </tr>
      <?php $Ccii [] = $Cci ?>
      <?php $collection_Cci = $Ccii; ?>
      <?php $nama[] = $key; ?>
      <?php $nama2 = $nama; ?>
      @endforeach

  </tbody>
  </table>



  <table border="1">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Nilai</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $combineData = array_combine($nama2, $collection_Cci);
      arsort($combineData);
      // $krt = array_slice($combineData, 0, 20);
      $i = 1;
     ?>
      @foreach($combineData as $key => $value)
      <tr>
        <td>{{$i++}}</td>
        <td>{{$key}}</td>
        <td>{{$value}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
