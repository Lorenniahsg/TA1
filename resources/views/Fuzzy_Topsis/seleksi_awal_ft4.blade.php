@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
  <h1>Fuzzy Topsis</h1>
  <hr>
<a class="btn btn-primary float-right col-sm-6" href="{{ url('FPIS_FNIS')}}">Hasil FPIS dan FNIS</a>
  <h1>Hasil Perhitungan Bobot dari Hasil Normalisasi Fuzzy Decision Matrix </h1>

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
      @foreach($hasilAkhir as $key=>$value)
      <tr>
        <td>{{$key}}</td>
        <td>{{ $tfn['Very High'][0] * $value['test_ip_min'] / $Cj['Cj'] }}</td>
        <td>{{ $tfn['Very High'][1] * $value['total_test_ip'] * 1/3 / $Cj['Cj'] }}</td>
        <td>{{ $tfn['Very High'][2] * $value['test_ip_max'] / $Cj['Cj'] }}</td>

        <td>{{ $tfn['Very Low'][0] * $Aj['Aj'] / $value['test_prilaku_max']}}</td>
        <td>{{ $tfn['Very Low'][1] * ($Aj['Aj'] / ($value['total_test_perilaku'] * 1/3))}}</td>
        <td>{{ $tfn['Very Low'][2] * $Aj['Aj'] / $value['test_perilaku_min']}}</td>
        @endforeach
      </tr>
    </tbody>
  </table>
</div>
@endsection
