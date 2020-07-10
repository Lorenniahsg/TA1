@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
  <h1>Calon Mahasiswa Teladan</h1>
  <table class="table table-striped table-hover">
    <thead>
      <th>No</th>
      <th>Nama</th>
      <th>Nilai</th>
    </thead>
    <tbody>
      <tr>
        <?php $no=1; ?>
        @foreach($hasilFinals as $key => $value)
        <td><?= $no++; ?></td>
        <td>
          {{$key}}
        </td>
        <td>
          {{$value}}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
