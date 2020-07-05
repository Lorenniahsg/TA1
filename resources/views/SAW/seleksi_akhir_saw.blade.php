@extends('template')
@section('title', 'SAW')
@section('intro-header')
    <!-- Header -->
    <header class="intro-header text-black">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </header>
    <!-- END : Header -->
@endsection
<br><br><br><br>

<div class="container">
  <h1>SAW</h1>
  <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item left">
          <a class="nav-link {{ request()->is('dimx_dim') ? 'active': null }}" href="{{ url('dimx_dim') }}" role="tab">Import Data Mahasiswa</a>
          </li>
          <li class="nav-item">
          <a class="nav-link {{ request()->is('adak_registrasi') ? 'active': null }}" href="{{ url('adak_registrasi') }}" role="tab">Import Data IP</a>
          </li>
          <li class="nav-item">
          <a class="nav-link {{ request()->is('askm_dim_penilaian') ? 'active': null }}" href="{{ url('askm_dim_penilaian') }}" role="tab">Import Data Prilaku</a>
          </li>
          <li class="nav-item">
          <a class="nav-link {{ request()->is('Mahasiswa') ? 'active': null }}" href="{{ url('Mahasiswa') }}"
             role="tab">Seleksi Mahasiswa</a>
      </li>
  </ul>
  <h2>Ranking</h2>

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
