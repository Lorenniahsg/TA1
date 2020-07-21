@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
  <h2>Fuzzy Topsis</h2>
  <hr>
  <a class="btn btn-info float-right" href="{{ url('PBHNFDM')}}">Perhitungan Bobot Hasil Normalisasi Fuzzy Decision Matrix</a>
  <h3>Hasil Matriks Normalisasi Fuzzy Decision </h3>
  <hr>
  <table class="table table-striped table-hover">
    <thead class="table-info">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Min Test IP</th>
        <th>Total Test IP</th>
        <th>IP Max</th>
        <th>Perilaku Max</th>
        <th>Total Test Perilaku</th>
        <th>Min Test Perilaku</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; ?>
      @foreach($hasilAkhir as $key=>$value)
      <tr>
        <td>{{$no++}}</td>
        <td>{{$key}}</td>
        <td>{{ number_format($value['test_ip_min'] / $Cj['Cj'],2) }}</td>
        <td>{{ number_format(($value['total_test_ip'] * 1/3) / $Cj['Cj'],2) }}</td>
        <td>{{ number_format($value['test_ip_max'] / $Cj['Cj'],2) }}</td>
        <td>{{ number_format($Aj['Aj'] / $value['test_prilaku_max'],2) }}</td>
        <td>{{ number_format($Aj['Aj'] / ($value['total_test_perilaku'] * 1/3),2) }}</td>
        <td>{{ number_format($Aj['Aj'] / $value['test_perilaku_min'],2) }}</td>
        @endforeach
      </tr>
    </tbody>
  </table>
</div>
@endsection
