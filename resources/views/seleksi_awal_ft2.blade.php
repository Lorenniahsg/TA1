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
</div>

<div class="container">
<br>

  <a class="btn btn-primary float-right" href="{{ url('NFDM')}}">Perhitungan Normalisasi Fuzzy Decision Matrix</a>
    <h1>Matrix Kombinasi</h1>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
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
      @foreach($hasilAkhir as $key=>$value)
      <tr>
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
