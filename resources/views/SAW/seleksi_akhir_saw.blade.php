@extends('template')
@section('title', 'SAW')
@section('intro-header')

<div class="container">
  <h1>SAW</h1>
  <hr>
  <h2>Ranking Mahasiswa</h2>

  <table class="table">
    <thead>
      <th>No</th>
      <th>Nama</th>
      <th>Nilai</th>
    </thead>
    <tbody>
      <tr>
        <?php $no=1; ?>
        @foreach($hasil_akhir_saw as $key)
        <td><?= $no++; ?></td>
        <td>{{$key['nama']}}</td>
        <td>{{$key['hasil_akhir_saw']}}</td>
      </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endsection
