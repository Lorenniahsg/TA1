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
<a class="btn btn-primary float-right col-sm-6" href="{{ url('jarak_FPIS_FNIS')}}">Hitung jarak FPIS dan FNIS</a>

  <h1>Hasil FPIS dan FNIS</h1>

  <br><br>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Min Test IP</th>
        <th>Total Test Ip</th>
        <th>IP Max</th>
        <th>Prilaku Max</th>
        <th>Total Test Prilaku</th>
        <th>Min Test Prilaku</th>
      </tr>
    </thead>
    <tbody>
        <?php
        $maxfpis = [];
        $minfnis = [];
         ?>
      @foreach($hasilAkhir as $key=>$value)
      <?php
      $fpis1 = null;
      $fpis2 = null;
      $fpis3 = null;

      $fnis1 = null;
      $fnis2 = null;
      $fnis3 = null;
      ?>
      <tr>
        <td>{{$key}}</td>
        <?php
        $fpis1 = $tfn['Very High'][0] * $value['test_ip_min'] / $Cj['Cj'];
        $fpis2 = $tfn['Very High'][1] * $value['total_test_ip'] * 1/3 / $Cj['Cj'];
        $fpis3 = $tfn['Very High'][2] * $value['test_ip_max'] / $Cj['Cj'];

        $fnis1 = $tfn['Very Low'][0] * $Aj['Aj'] / $value['test_prilaku_max'];
        $fnis2 = $tfn['Very Low'][1] * ($Aj['Aj'] / ($value['total_test_perilaku'] * 1/3));
        $fnis3 = $tfn['Very Low'][2] * $Aj['Aj'] / $value['test_perilaku_min'];
        ?>
        <td>{{ $fpis1 }}</td>
        <td>{{ $fpis2 }}</td>
        <td>{{ $fpis3 }}</td>

        <td>{{ $fnis1 }}</td>
        <td>{{ $fnis2 }}</td>
        <td>{{ $fnis3 }}</td>
                    <?php
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
                    ?>

                    <?php
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
      </tr>
    </tbody>
  </table>

<br><br>
  <table border="1" class="table">

    <thead class="thead-dark">
      <tr>
        <th scope="col"><b>FPIS IP A*</b></th>
        <th scope="col"><b>FPIS Prilaku A*</b></th>

      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <?php $fpis = max($maxfpis); ?>
            @foreach($fpis as $MaXx => $valueMax)
            {{$valueMax}}
            @endforeach
      </td>
        <td>
          <?php $fpis_prilaku = max($minfnis) ?>
          @foreach($fpis_prilaku as $fpis_ => $fpis_pri)
          {{$fpis_pri}}
          @endforeach
        </td>
      </tr>
    </tbody>
  </table>

  <table border="1" class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col"><b>FNIS IP A&macr;</b></th>
        <th scope="col"><b>FNIS PRILAKU A&macr;</b></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <?php $fnis_IP = min($maxfpis); ?>
          @foreach($fnis_IP as $fpis_ => $fpis_ip_value)
            {{$fpis_ip_value}}
          @endforeach
        </td>
        <td>
          <?php $fnis = min($minfnis); ?>
          @foreach($fnis as $minXx => $valueminXx)
          {{$valueminXx}}
          @endforeach
        </td>
      </tr>
    </tbody>
  </table>
</div>
