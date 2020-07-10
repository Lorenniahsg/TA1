@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

<div class="container">
<h1>Fuzzy Topsis</h1>
<hr>
<a class="btn btn-primary float-right" href="{{ url('Seleksi_FT') }}">Seleksi Mahasiswa</a>
<h1>Daftar Mahasiswa</h1>
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
        <?php $no=1; ?>
          @foreach($semua as $s)
        <tr>
            @if ($s['ta']==2017 && $s['sem_ta'] == 2 || $s['sem_ta'] == 1)
            <td><?php echo $no++; ?></td>
            <td>{{$s['nama']}}</td>
            <td>{{$s['ta']}}</td>
            <td>{{$s['sem_ta']}}</td>
            <td>{{$s['nr']}}</td>
            <td>
            <!-- Veery High -->
            @if( $s['nr'] >= 3.50 && $s['nr'] <= 4.00 )
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
            @elseif($s['nr'] >= 3.00 && $s['nr'] <=3.49)
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
            @elseif( $s['nr'] >= 2.00 && $s['nr'] <= 2.99)
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
            @elseif( $s['nr'] >= 1.00 && $s['nr'] <=1.99)
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
            @elseif($s['nr'] >= 0.0 && $s['nr'] <=0.99)
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
            @if($key == 0)
              {{$value . '('}}
            @endif
          @endforeach

          @foreach($tfn['Very High'] as $a)
            {{$a}}
          @endforeach
            {{')'}}

          <!-- Low -->
        @elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10)
          @foreach(array_keys($tfn) as $key => $value)
            @if($key == 1)
              {{$value . '('}}
            @endif
          @endforeach

          @foreach($tfn['High'] as $a)
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
            @if($key == 3)
              {{$value . '('}}
            @endif
          @endforeach

          @foreach($tfn['Low'] as $a)
            {{$a}}
          @endforeach
            {{')'}}

          <!-- Very High -->
        @elseif( $s['akumulasi_skor'] >=26 && $s['akumulasi_skor'] <= 100)
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
        @endif
          </td>
          @endforeach
          </tr>
      </tbody>
    </table>
</div>
@endsection
