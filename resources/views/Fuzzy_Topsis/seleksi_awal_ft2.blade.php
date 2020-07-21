@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
  <h2>Fuzzy Topsis</h2>
  <hr>
  <a class="btn btn-info float-right" href="{{ url('NFDM')}}">Perhitungan Normalisasi Fuzzy Decision Matrix</a>
  <h3>Matrix Kombinasi</h3>
  <hr>
  <table class="table table-striped table-hover">
    <thead class="table-info">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Min Test IP</th>
        <th>Total Test IP</th>
        <th>IP Max</th>
        <th>Min Test Perilaku</th>
        <th>Total Test Perilaku</th>
        <th>Perilaku Max</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; ?>
      @foreach($hasilAkhir as $key=>$value)
      <tr>
        <td><?= $no++; ?></td>
        <td>{{$key}}</td>
        <td>{{$value['test_ip_min']}}</td>
        <td>{{ number_format($value['total_test_ip'] * 1/3,2)}}</td>
        <td>{{$value['test_ip_max']}}</td>
        <td>{{$value['test_perilaku_min']}}</td>
        <td>{{number_format($value['total_test_perilaku'] * 1/3,2)}}</td>
        <td>{{$value['test_prilaku_max']}}</td>
        @endforeach
      </tr>
    </tbody>
  </table>
</div>
@endsection@endsection
