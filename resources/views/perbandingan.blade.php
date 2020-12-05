@extends('template')
@section('title', 'SAW')
@section('intro-header')
<div class="container d-flex justify-content-center">



<?php
  $data_ft = array_slice($Fuzzy_Topsis,0,10);
  $data_saw = array_slice($saw,0,10);
 ?>
<div class="row">


 
 <div class="col-lg-6 col-md-6">
   <h2>Hasil Ranking Fuzzy Topsis</h2>
   <table class="table table-striped table-hover">
     <thead class="table-info">
       <th>No</th>
       <th>NIM</th>
       <th>Nama</th>
       <th>Nilai</th>
     </thead>
     <tbody>
       <tr>
         <?php $no=1; ?>
         @foreach($data_ft as $nama => $nilai )
         <td><?=$no++; ?></td>
         <td>{{$nilai['nim']}}</td>
         <td>{{$nilai['nama']}}</td>
         <td>{{number_format($nilai['cci2'],2)}}</td>
       </tr>
       @endforeach
     </tbody>
   </table>
 </div>

<div class="col-lg-6 col-md-6">
  <h2>Hasil Ranking SAW</h2>
  <table class="table table-striped table-hover">
    <thead class="table-info">
      <th>No</th>
      <th>NIM</th>
      <th>Nama</th>
      <th>Nilai</th>
    </thead>
    <tbody>
      <tr>
        <?php $no=1; ?>
        @foreach($data_saw as $hasil)
        <td><?= $no++; ?></td>
        <td>{{$hasil['nim']}}</td>
        <td>{{$hasil['nama']}}</td>
        <td>{{number_format($hasil['hasil_akhir_saw'],2)}}</td>
      </tr>
        @endforeach
    </tbody>
  </table>
</div>
</div>
</div>
@endsection
