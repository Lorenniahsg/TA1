@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

  <!-- Header -->
  <header class="intro-header text-black">

  </header>
  <!-- END : Header -->
@endsection

<br><br><br><br><br><br>

<div class="container">
  <table border='2'>
  <th>TFN</th>
  <th></th>
  <th></th>
  <th>s</th>

  @foreach($tfn as $t)
    @foreach($t as $q)
    <tr>

    </tr>
      @foreach($q as $w)
          <td style="color:red;">{{$w}}</td>
      @endforeach
        @if($q == $tfn[0]["very_high"])
          <td>{{"Very_High"}}</td>
          @elseif($q == $tfn[1]['high'])
          <td>{{'High'}}</td>
          @elseif($q == $tfn[2]['average'])
          <td>{{'Average'}}</td>
          @elseif($q == $tfn[3]['low'])
          <td>{{'Low'}}</td>
          @elseif($q == $tfn[4]['very_low'])
          <td>{{'Very Low'}}</td>
          @else
          {{'not found'}}
        @endif
    @endforeach
  @endforeach
  </table>



@foreach($tfn as $t)
  @foreach($t as $q)
    @foreach($q as $w)
    {{$w}}
    @if( $w == 0 )
    {{'A'}}
    @elseif($w >=1 && $w <=5)
      {{ 'AB' }}
    @elseif( $w >=6 && $w <=10)
      {{ 'B' }}
    @elseif( $w >=11 && $w <=15)
      {{ 'BC' }}
    @elseif( $w >=16 && $w <=25)
      {{ 'C' }}
    @elseif( $w >=26 && $w <=30)
      {{ 'D' }}
    @elseif( $w > 30)
      {{ 'E' }}
    @else
      {{ 'data tidak terdefenisi' }}
    @endif
    @endforeach
  @endforeach

@endforeach

<br><br>Pemisah

    <table border="1" class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Tahun</th>
          <th>SEMESTEr</th>
          <th>IP</th>
          <th>TFN1</th>
          <th>PRILAKU</th>
          <th>TFN2</th>
          <th></th>
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
            @if( $s['nr'] >= 3.30 && $s['nr'] <= 4.00 )
            {{'Very High ('}}
              @foreach($tfn[0]['very_high'] as $k)
                {{$k}}
              @endforeach
              {{')'}}
            @elseif($s['nr'] >=2.50 && $s['nr'] <=3.29)
            {{'High ('}}
              @foreach($tfn[1]['high'] as $k)
                {{$k}}
              @endforeach
              {{')'}}

            @elseif( $s['nr'] >=1.70 && $s['nr'] <= 2.49)
            {{'Average ('}}
              @foreach($tfn[2]['average'] as $k)
                {{$k}}
              @endforeach
              {{')'}}
            @elseif( $s['nr'] >=0.90 && $s['nr'] <=1.69)
            {{'Low ('}}
              @foreach($tfn[3]['low'] as $k)
                {{$k}}
              @endforeach
              {{')'}}
            @elseif( $s['nr'] >=0 && $s['nr'] <=0.89)
            {{'Very Low ('}}
              @foreach($tfn[4]['very_low'] as $k)
                {{$k}}
              @endforeach
              {{')'}}
            @else
              {{ 'data tidak terdefenisi' }}
            @endif

          </td>
          <td>{{$s['akumulasi_skor']}}</td>
          <td>
        @if($s['akumulasi_skor'] >=0 && $s['akumulasi_skor'] <=5)
          {{ 'Very Low (' }}
          @foreach($tfn[4]['very_low'] as $p)
            {{ $p }}
          @endforeach
          {{')'}}
        @elseif( $s['akumulasi_skor'] >=6 && $s['akumulasi_skor'] <=10)
          {{ 'Low (' }}
          @foreach($tfn[3]['low'] as $p)
            {{ $p }}
          @endforeach
          {{')'}}
        @elseif( $s['akumulasi_skor'] >=11 && $s['akumulasi_skor'] <=15)
          {{ 'Average (' }}
          @foreach($tfn[2]['average'] as $p)
            {{ $p }}
          @endforeach
          {{')'}}
        @elseif( $s['akumulasi_skor'] >=16 && $s['akumulasi_skor'] <=25)
          {{ 'High (' }}
          @foreach($tfn[1]['high'] as $p)
            {{ $p }}
          @endforeach
          {{')'}}
        @elseif( $s['akumulasi_skor'] >=26)
          {{ 'Very High (' }}
          @foreach($tfn[0]['very_high'] as $p)
            {{ $p }}
          @endforeach
          {{')'}}
        @else
          {{ 'data tidak terdefenisi' }}
        @endif

          </td>
          <td>
            @if($s['ta'] == 2017 && $s['sem_ta']==2 || $s['sem_ta']==1)
              @foreach($tfn[0]['very_high'] as $tt)
                {{$tt}}
              @endforeach
            @endif


          </td>
          @endforeach

          </tr>
</div>
      </tbody>
    </table>