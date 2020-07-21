@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
  <h2>Fuzzy Topsis</h2>
  <hr>
    <a class="btn btn-info float-right" href="{{ url('hasilAwal')}}">Hasil Seleksi Awal</a>
  <h3>Jarak FPIS dan FNIS</h3>
  <hr>
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
    <thead class="table-info">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>FPIS IP</th>
        <th>FPIS Perilaku</th>
        <th>FNIS IP</th>
        <th>FNIS Perilaku</th>
        <th>d*</th>
        <th>d&macr;</th>
        <th>CCi</th>
      </tr>
    </thead>
    <tbody>
    <tr>
      <?php $no=1; ?>
      @foreach($hasilAkhir as $key => $value)
      <?php $b = null; ?>
        <?php
        $fpis1 = pow($tfn['Very High'][0] * $value['test_ip_min'] / $Cj['Cj'] - $fpis_ip['FPIS_MAX1'], 2);
        $fpis2 = pow($tfn['Very High'][1] * $value['total_test_ip'] * 1/3 / $Cj['Cj'] - $fpis_ip['FPIS_MAX2'], 2);
        $fpis3 = pow($tfn['Very High'][2] * $value['test_ip_max'] / $Cj['Cj'] - $fpis_ip['FPIS_MAX3'], 2);
        $totalIP_fpis = sqrt(1/3 * ($fpis1 + $fpis2 + $fpis3));

        $fpis11 = pow($tfn['Very Low'][2] *  $Aj['Aj'] / $value['test_perilaku_min'] - $fpis_prilaku['FNIS_MIN1'], 2);
        $fpis22 = pow($tfn['Very Low'][1] * $Aj['Aj'] / (1/3 * $value['total_test_perilaku']) - $fpis_prilaku['FNIS_MIN2'], 2);
        $fpis33 = pow($tfn['Very Low'][0] *  $Aj['Aj'] / $value['test_prilaku_max'] - $fpis_prilaku['FNIS_MIN3'], 2);
        $total_prilaku_fpis = sqrt(1/3 * ($fpis11 + $fpis22 + $fpis33));


        $fnis1 = pow($tfn['Very High'][0] * $value['test_ip_min'] / $Cj['Cj'] - $fnis_IP['FPIS_MAX1'], 2);
        $fnis2 = pow($tfn['Very High'][1] * $value['total_test_ip'] * 1/3 / $Cj['Cj'] - $fnis_IP['FPIS_MAX2'], 2);
        $fnis3 = pow($tfn['Very High'][2] * $value['test_ip_max'] / $Cj['Cj'] - $fnis_IP['FPIS_MAX3'], 2);
        $totalIP_fnis = sqrt(1/3 * ($fnis1 + $fnis2 + $fnis3));

        $fnis11 = pow($tfn['Very Low'][0] * $Aj['Aj'] / $value['test_perilaku_min'] - $fnis_prilaku['FNIS_MIN1'],2);
        $fnis22 = pow($tfn['Very Low'][1] * $Aj['Aj'] / (1/3 * $value['total_test_perilaku'])  - $fnis_prilaku['FNIS_MIN2'] ,2);
        $fnis33 = pow($tfn['Very Low'][2] * $Aj['Aj'] / $value['test_prilaku_max'] - $fnis_prilaku['FNIS_MIN3'],2);
        $totalpri = sqrt( 1/3 * ($fnis11 + $fnis22 + $fnis33));

        ?>
        <td><?= $no++; ?></td>
        <td>{{$key}}</td>
        <td>{{ number_format($totalIP_fpis,2) }}</td>
        <td>{{ number_format($total_prilaku_fpis,2) }}</td>
        <td>{{ number_format($totalIP_fnis,2) }}</td>
        <td>{{ number_format($totalpri,2) }}</td>
        <?php $dFPIS = $totalIP_fpis + $total_prilaku_fpis; ?>
        <td>{{ number_format($dFPIS,2) }}</td>
        <?php $dFNIS = $totalIP_fnis + $totalpri; ?>
        <td>{{ number_format($dFNIS,2) }}</td>
        <?php $Cci = $dFNIS / ($dFNIS + $dFPIS); ?>
        <td class="table-primary">{{ number_format($Cci,2) }}</td>
        </tr>
      <?php $Ccii [] = $Cci ?>
      <?php $collection_Cci = $Ccii; ?>
      <?php $nama[] = $key; ?>
      <?php $nama2 = $nama; ?>
      @endforeach
  </tbody>
  </table>
</div>
@endsection
