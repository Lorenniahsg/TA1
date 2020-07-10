@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
  <h1>Fuzzy Topsis</h1>
  <hr>
  <a class="btn btn-primary float-right" href="{{ url('PBHNFDM')}}">Perhitungan Bobot Hasil Normalisasi Fuzzy Decision Matrix</a>
  <h1>Hasil Matriks Normalisasi Fuzzy Decision </h1>

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
        <td>{{$value['test_ip_min'] / $Cj['Cj'] }}</td>
        <td>{{($value['total_test_ip'] * 1/3) / $Cj['Cj'] }}</td>
        <td>{{$value['test_ip_max'] / $Cj['Cj'] }}</td>
        <td>{{$Aj['Aj'] / $value['test_prilaku_max']}}</td>
        <td>{{$Aj['Aj'] / ($value['total_test_perilaku'] * 1/3)}}</td>
        <td>{{$Aj['Aj'] / $value['test_perilaku_min']}}</td>
        @endforeach
      </tr>
    </tbody>
  </table>
</div>
@endsection
