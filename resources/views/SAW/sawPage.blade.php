@extends('template')
@section('title', 'SAW')
@section('intro-header')
<!-- Main -->
<br><br><br>
<div class="container">
    <h1>SAW</h1>
    <hr>
    <h3>Data Mahasiswa</h3>
    <hr>
    <a href="{{ url('PenilaianSaw') }}" class="btn btn-info btn-md">Seleksi Awal</a>

    <table class="table table-striped table-hover">
        <th>No</th>
        <th>Nama</th>
        <th>Nilai IPK</th>
        <tr>
            <?php $no = 1; ?>
            @foreach ($dataMahasiswa as $dt_mhs)
            @if ($dt_mhs['ta'] == 2017 && $dt_mhs['sem_ta']==2 || $dt_mhs['sem_ta']==1)
                <td><?php echo($no++); ?></td>
                <td>{{ $dt_mhs['nama'] }}</td>
                <td>{{ $dt_mhs['ipTotal'] }}</td>
        </tr>
          @endif
        @endforeach
    </table>
</div>
