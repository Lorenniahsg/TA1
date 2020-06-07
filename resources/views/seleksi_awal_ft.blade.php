@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

  <!-- Header -->
  <header class="intro-header text-black">

  </header>
  <!-- END : Header -->
@endsection

<br><br><br><br>


<div class="container">
  <ul class="nav nav-tabs" role="tablist">
    <!-- <li class="nav-item">
      <a class="nav-link" href="{{ url('MahasiswaFT') }}" role="tab">Data Mahasiswa</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('PenilaianFT') }}" role="tab">Data Penilaian</a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="{{ url('PerhitunganFT') }}" role="tab">Data  Mahasiswa</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="{{ url('test2') }}" role="tab">Seleksi  Mahasiswa</a>
    </li> -->
  </ul>
</div>



<div class="container">
  <h2>Daftar Mahasiswa</h2>
<a class="btn btn-primary" href="{{ url('Seleksi_FT') }}">Seleksi Mahasiswa</a>
  <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Tahun</th>
          <th>SEMESTER</th>
          <th>IP</th>
          <th>TFN1</th>
          <th>PRILAKU</th>
          <th>TFN2</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no=1;

         ?>
          @foreach($semua as $s)
        <tr>
          <td><?php echo $no++; ?></td>
          <td>{{$s['nama']}}</td>
          <td>{{$s['ta']}}</td>
          <td>{{$s['sem_ta']}}</td>
          <td>{{$s['nr']}}</td>
          <td>
            <!-- Veery High -->
            @if( $s['nr'] >= 3.30 && $s['nr'] <= 4.00 )
            @foreach(array_keys($tfn) as $key => $value)
              @if($key == 0)
                {{$value . '('}}
              @endif
            @endforeach

            @foreach($tfn['Very High'] as  $a)
              {{$a}}
            @endforeach
              {{')'}}

            <!-- High -->
            @elseif($s['nr'] >= 2.50 && $s['nr'] <=3.29)
              @foreach(array_keys($tfn) as $key => $value)
                @if($key == 1)
                  {{$value . '('}}
                @endif
              @endforeach

              @foreach($tfn['High'] as $a)
                {{$a}}
              @endforeach
                  {{')'}}

            <!-- Average  -->
            @elseif( $s['nr'] >= 1.70 && $s['nr'] <= 2.49)
              @foreach(array_keys($tfn) as $key => $value)
                @if($key == 2)
                  {{$value . '('}}
                @endif
              @endforeach

              @foreach($tfn['Average'] as $a)
                {{$a}}
              @endforeach

              {{')'}}

            <!-- Low -->
            @elseif( $s['nr'] >= 0.90 && $s['nr'] <=1.69)
            @foreach(array_keys($tfn) as $key => $value)
              @if($key == 3)
                {{$value . '('}}
              @endif
            @endforeach

            @foreach($tfn['Low'] as $a)
              {{$a}}
            @endforeach

              {{')'}}
            <!-- Very Low -->
            @elseif($s['nr'] >= 0.0 && $s['nr'] <=0.89)
            @foreach(array_keys($tfn) as $key => $value)
              @if($key == 4)
                {{$value . '('}}
              @endif
            @endforeach

            @foreach($tfn['Very Low'] as $a)
              {{$a}}
            @endforeach
            {{')'}}
            @else
              {{ 'data tidak terdefenisi' }}
            @endif

          </td>
          <td>
            @if( $s['akumulasi_skor'] == 0 )
                {{ 'A' }}
            @elseif($s['akumulasi_skor'] >=1 && $s['akumulasi_skor'] <=5)
                {{ 'AB' }}
            @elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10)
                {{ 'B' }}
            @elseif( $s['akumulasi_skor'] >=11 && $s['akumulasi_skor'] <=15)
                {{ 'BC' }}
            @elseif( $s['akumulasi_skor'] >=16 && $s['akumulasi_skor'] <=25)
                {{ 'C' }}
            @elseif( $s['akumulasi_skor'] >=26 && $s['akumulasi_skor'] <=30)
                {{ 'D' }}
            @elseif( $s['akumulasi_skor'] > 30)
                {{ 'E' }}
            @else
                {{ 'data tidak terdefenisi' }}
            @endif
          =  {{$s['akumulasi_skor']}}
          </td>
          <td>
            <!-- Very Low -->
        @if($s['akumulasi_skor'] >=0 && $s['akumulasi_skor'] <=5)
          @foreach(array_keys($tfn) as $key => $value)
            @if($key == 4)
              {{$value . '('}}
            @endif
          @endforeach

          @foreach($tfn['Very Low'] as $a)
            {{$a}}
          @endforeach
            {{')'}}

          <!-- Low -->
        @elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10)
          @foreach(array_keys($tfn) as $key => $value)
            @if($key == 3)
              {{$value . '('}}
            @endif
          @endforeach

          @foreach($tfn['Low'] as $a)
            {{$a}}
          @endforeach
            {{')'}}

          <!-- Average -->
        @elseif( $s['akumulasi_skor'] >=11 && $s['akumulasi_skor'] <=15)
          @foreach(array_keys($tfn) as $key => $value)
            @if($key == 2)
              {{$value . '('}}
            @endif
          @endforeach

          @foreach($tfn['Average'] as $a)
            {{$a}}
          @endforeach
            {{')'}}

          <!-- High -->
        @elseif( $s['akumulasi_skor'] >=16 && $s['akumulasi_skor'] <=25)
          @foreach(array_keys($tfn) as $key => $value)
            @if($key == 1)
              {{$value . '('}}
            @endif
          @endforeach

          @foreach($tfn['High'] as $a)
            {{$a}}
          @endforeach
            {{')'}}

          <!-- Very High -->
        @elseif( $s['akumulasi_skor'] >=26 && $s['akumulasi_skor'] <= 100)
          @foreach(array_keys($tfn) as $key => $value)
            @if($key == 0)
              {{$value . '('}}
            @endif
          @endforeach

          @foreach($tfn['Very High'] as $a)
            {{$a}}
          @endforeach
            {{')'}}

        @else
          {{ 'data tidak terdefenisi' }}
        @endif
          </td>

          @endforeach

          </tr>
      </tbody>
    </table>

</div>
