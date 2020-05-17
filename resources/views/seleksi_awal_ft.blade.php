@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

  <!-- Header -->
  <header class="intro-header text-black">

  </header>
  <!-- END : Header -->
@endsection

<br><br><br><br><br><br>

<<<<<<< HEAD
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

=======
>>>>>>> 1020a5a117258ceeb9a850762f4ddac7810e3525






    <table border="1" class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Tahun</th>
<<<<<<< HEAD
          <th>SEM</th>
=======
          <th>SEMESTER</th>
>>>>>>> 1020a5a117258ceeb9a850762f4ddac7810e3525
          <th>IP</th>
          <th>TFN1</th>
          <th>PRILAKU</th>
          <th>TFN2</th>
          <th>TEST IP</th>
          <th>TEST Prilaku</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; $hasilMin = []; ?>
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
            <?php $min = $tfn['Very High'][0];
                  $min2 = $tfn['High'][0];
                  $min3 = $tfn['Average'][0];
                  $min4 = $tfn['Low'][0];
                  $min5 = $tfn['Very Low'][0];

                  ?>
          <td>
            <?php $valMatch = null; ?>
            @if($s['ta'] == 2017 && $s['sem_ta']== 2 || $s['sem_ta']== 1)
                <!-- Very High -->
                @if( $s['nr'] >= 3.30 && $s['nr'] <= 4.00 )
                  <?php $valMatch = $min; ?>

                <!-- High -->
                @elseif($s['nr'] >= 2.50 && $s['nr'] <=3.29)
                  <?php $valMatch = $tfn['High'][0]; ?>

                <!-- Average  -->
                @elseif( $s['nr'] >= 1.70 && $s['nr'] <= 2.49)
                  <?php $valMatch = $tfn['Average'][0]; ?>

                <!-- Low -->
                @elseif( $s['nr'] >= 0.90 && $s['nr'] <=1.69)
                  <?php $valMatch = $tfn['Low'][0]; ?>

                <!-- Very Low -->
                @elseif($s['nr'] >= 0.0 && $s['nr'] <=0.89)
                  <?php $valMatch = $tfn['Very Low'][0]; ?>
                @endif

                @if(isset($valMatch))
                  {{ $valMatch }}
                @else
                  {{ 'data tidak terdefenisi' }}
                @endif

                <?php
                  if ((!isset($hasilMin[$s['nama']]["test_ip_min"])) || ($hasilMin[$s['nama']]["test_ip_min"] > $valMatch)) {
                    $hasilMin[$s['nama']]["test_ip_min"] = $valMatch;
                  }
                ?>
            @endif
          </td>
          <td>
            <?php $valMatch = null; ?>
            @if($s['ta'] == 2017 && $s['sem_ta']==2 || $s['sem_ta']==1)
                <!-- Very Low -->
              @if($s['akumulasi_skor'] >=0 && $s['akumulasi_skor'] <=5)
                <?php $valMatch = $tfn['Very Low'][0]; ?>

                <!-- Low -->
              @elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10)
                <?php $valMatch = $tfn['Low'][0]; ?>

                <!-- Average -->
              @elseif( $s['akumulasi_skor'] >=11 && $s['akumulasi_skor'] <=15)
                <?php $valMatch = $tfn['Average'][0]; ?>

                <!-- High -->
              @elseif( $s['akumulasi_skor'] >=16 && $s['akumulasi_skor'] <=25)
<<<<<<< HEAD
                {{$tfn['High'][0]}}
=======
                <?php $valMatch = $tfn['High'][0]; ?>
>>>>>>> 1020a5a117258ceeb9a850762f4ddac7810e3525

                <!-- Very High -->
              @elseif( $s['akumulasi_skor'] >=26 && $s['akumulasi_skor'] <= 100)
                <?php $valMatch = $tfn['Very High'][0]; ?>
              @endif

              @if(isset($valMatch))
                {{ $valMatch }}
              @else
                {{ 'data tidak terdefenisi' }}
              @endif
<<<<<<< HEAD
=======

              <?php
                if ((!isset($hasilMin[$s['nama']]["test_perilaku_min"])) || ($hasilMin[$s['nama']]["test_perilaku_min"] > $valMatch)) {
                  $hasilMin[$s['nama']]["test_perilaku_min"] = $valMatch;
                }
              ?>

>>>>>>> 1020a5a117258ceeb9a850762f4ddac7810e3525
            @endif
          </td>
          @endforeach

          </tr>
</div>
      </tbody>
    </table>

    {{dd($hasilMin)}}

    <!-- @foreach($hasilMin as $ii)
      @foreach($ii as $rr)
        <p>{{dd($rr)}}</p>
      @endforeach
    @endforeach -->
