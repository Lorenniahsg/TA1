@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
  <h1>Fuzzy Topsis</h1>
  <hr>
  <a class="btn btn-primary float-right" href="{{ url('NFDM')}}">Perhitungan Normalisasi Fuzzy Decision Matrix</a>
    <h1>Matrix Kombinasi</h1>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Min Test IP</th>
        <th>Total Test Ip</th>
        <th>IP Max</th>
        <th>Min Test Prilaku</th>
        <th>Total Test Prilaku</th>
        <th>Prilaku Max</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; ?>
      @foreach($hasilAkhir as $key=>$value)
      <tr>
        <td><?= $no++; ?></td>
        <td>{{$key}}</td>
        <td>{{$value['test_ip_min']}}</td>
        <td>{{$value['total_test_ip'] * 1/3}}</td>
        <td>{{$value['test_ip_max']}}</td>
        <td>{{$value['test_perilaku_min']}}</td>
        <td>{{$value['total_test_perilaku'] * 1/3}}</td>
        <td>{{$value['test_prilaku_max']}}</td>
        @endforeach
      </tr>
    </tbody>
  </table>
@endsection@endsection
