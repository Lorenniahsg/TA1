@extends('template')
@section('title', 'SAW')
@section('intro-header')
<!-- Main -->
<br><br><br>
<div class="container">
    <h2>Simple Additive Weighting(SAW)</h2>
    <hr>
    <h3>Data Mahasiswa</h3>
    <hr>
    <a href="{{ url('PenilaianSaw') }}" class="btn btn-info btn-md">Seleksi Awal</a>

    <table class="table table-striped table-hover">
      <thead class="table-success">
        <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Nilai IPK</th>
        <th>Nilai Perilaku</th>
      </thead>
      <tbody>
        <tr>
          <?php $no = 1; ?>
          @foreach ($dataMahasiswa as $dt_mhs)

          @if ($dt_mhs['ta'] == 2017 && $dt_mhs['sem_ta']==2 || $dt_mhs['sem_ta']==1)
          <td><?php echo($no++); ?></td>
          <td>{{ $dt_mhs['nim'] }}</td>
          <td>{{ $dt_mhs['nama'] }}</td>
          <td>{{ number_format($dt_mhs['ipTotal'], 2) }}</td>
          <td>{{ $dt_mhs['akumulasi_skor'] }}</td>
        </tr>
        @endif
        @endforeach
      </tbody>
    </table>
</div>
