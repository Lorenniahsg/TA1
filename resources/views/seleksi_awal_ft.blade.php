@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

  <!-- Header -->
  <header class="intro-header text-black">

  </header>
  <!-- END : Header -->
@endsection

<br><br><br><br><br><br>

<table border="1">
  <tr>
    <th>TFn</th>
    <th>AA</th>
  </tr>
  <tr>
    <td>
      @foreach($tfn as $a)
      <br>
        @foreach($a as $q)
          {{$q}}
        @endforeach
          @if($a == $tfn["Very High"])
          {{"Very High"}}
          @elseif($a == $tfn['High'])
          {{'High'}}
          @elseif($a == $tfn['Average'])
          {{'Average'}}
          @elseif($a == $tfn['Low'])
          {{'Low'}}
          @elseif($a == $tfn['Very Low'])
          {{'Very Low'}}
          @else
          {{'not found'}}
          @endif
      @endforeach
    </td>
  </tr>
</table>

<br>
@foreach(array_keys($tfn) as $s => $v)
<br>
  @foreach($tfn as $qw)

    @foreach($qw as $ww)

    @endforeach


    @endforeach
    @if($s == 0)
      {{$v}}
    @elseif($s == 1)
      {{$v}}
    @elseif($s == 2)
      {{$v}}
    @elseif($s == 3)
      {{$v}}
    @elseif($s == 4)
      {{$v}}
    @else
      {{'Nothing'}}
    @endif




@endforeach


<br><br>Pemisah



    <table border="1" class="table">
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
          <th>TEST IP</th>
          <th>TEST Prilaku</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; ?>
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
          <td>{{$s['akumulasi_skor']}}</td>
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

          <td>
            @if($s['ta'] == 2017 && $s['sem_ta']== 2 || $s['sem_ta']== 1)
                @if( $s['nr'] >= 3.30 && $s['nr'] <= 4.00 )
                  {{$tfn['Very High'][0]}}

                <!-- High -->
                @elseif($s['nr'] >= 2.50 && $s['nr'] <=3.29)
                  {{$tfn['High'][0]}}

                <!-- Average  -->
                @elseif( $s['nr'] >= 1.70 && $s['nr'] <= 2.49)
                  {{$tfn['Average'][0]}}

                <!-- Low -->
                @elseif( $s['nr'] >= 0.90 && $s['nr'] <=1.69)
                  {{$tfn['Low'][0]}}

                <!-- Very Low -->
                @elseif($s['nr'] >= 0.0 && $s['nr'] <=0.89)
                  {{$tfn['Very Low'][0]}}

                @else
                  {{ 'data tidak terdefenisi' }}
                @endif

            @elseif($s['ta'] == 2018 && $s['sem_ta'] == 2)
              {{'ola'}}
            @endif
          </td>
          <td>
            @if($s['ta'] == 2017 && $s['sem_ta']==2 || $s['sem_ta']==1)
              @if($s['akumulasi_skor'] >=0 && $s['akumulasi_skor'] <=5)
              {{$tfn['Very Low'][0]}}

                <!-- Low -->
              @elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10)
                {{$tfn['Low'][0]}}

                <!-- Average -->
              @elseif( $s['akumulasi_skor'] >=11 && $s['akumulasi_skor'] <=15)
                {{$tfn['Average'][0]}}

                <!-- High -->
              @elseif( $s['akumulasi_skor'] >=16 && $s['akumulasi_skor'] <=25)
                {{$tfn['Very High'][0]}}

                <!-- Very High -->
              @elseif( $s['akumulasi_skor'] >=26 && $s['akumulasi_skor'] <= 100)
                {{$tfn['Very High'][0]}}

              @else
                {{ 'data tidak terdefenisi' }}
              @endif
            @endif
          </td>
          @endforeach

          </tr>
</div>
      </tbody>
    </table>
