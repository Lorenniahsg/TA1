@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
  <h2>Kandidat Calon Mahasiswa Teladan</h2>
  <hr>
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
        @foreach($hasilFinals as $key => $value)
        <td><?= $no++; ?></td>
        <td>
          {{$value['nim']}}
        </td>
        <td>{{$value['nama']}}</td>
        <td>
          {{number_format($value['cci2'],2)}}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
