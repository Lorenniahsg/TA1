@extends('template')
@section('title', 'SAW')
@section('intro-header')

<div class="container">
  <h2>Simple Additive Weighting(SAW)</h2>
  <hr>
  <h3>Rekomendasi Mahasiswa Teladan</h3>
  <hr>
  <table class="table table-striped table-hover">
    <thead class="table-success">
      <th>No</th>
      <th>NIM</th>
      <th>Nama</th>
      <th>Nilai</th>
    </thead>
    <tbody>
      <tr>
        <?php $no=1; ?>
        @foreach($hasil_akhir_saw as $key)
        <td><?= $no++; ?></td>
        <td>{{ $key['nim'] }}</td>
        <td>{{$key['nama']}}</td>
        <td>{{number_format($key['hasil_akhir_saw'],2)}}</td>
      </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endsection
