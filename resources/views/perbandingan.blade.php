@extends('template')
@section('title', 'SAW')
@section('intro-header')
<div class="container">


<h1>Hasil Perankingan Fuzzy Topsis</h1>

<table class="table">
  <thead>
    <th>No</th>
    <th>Nama</th>
    <th>Nilai</th>
  </thead>
  <tbody>
    <tr>
      <?php $no=1; ?>
      @foreach($Fuzzy_Topsis as $nama => $nilai )
      <td><?=$no++; ?></td>
      <td>{{$nama}}</td>
      <td>{{$nilai}}</td>
    </tr>
      @endforeach
  </tbody>
</table>

<br><br>


<h1>Hasil Perangkingan SAW</h1>
<table class="table">
  <thead>
    <th>No</th>
    <th>Nama</th>
    <th>Nilai</th>
  </thead>
  <tbody>
    <tr>
      <?php $no=1; ?>
      @foreach($saw as $hasil)
      <td><?= $no++; ?></td>
      <td>{{$hasil['nama']}}</td>
      <td>{{$hasil['hasil_akhir_saw']}}</td>
    </tr>
      @endforeach
  </tbody>
</table>
</div>
@endsection
