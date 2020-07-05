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
