@extends('sawPage')

<br><br><br>

@section('kontent')

<div class="container">
  <div class="tab-pane {{ request()->is('Penilaian') ? 'active': null }}" href="{{ url('Penilaian') }}"
       role="tabpanel">
      <h3>Hasil Seleksi Awal IPK dan Nilai Perilaku (SAW)</h3>
      <a href="{{ url('Skkm') }}" class="btn btn-info btn-md">Seleksi Akhir</a>
      <table class="table">
          <th>No</th>
          <th>Nama</th>
          <th>Nilai IPK</th>
          <th>Nilai Perilaku</th>
          <th>Nilai</th>
          <tr>
              <?php $no = 1; ?>
              <?php if (is_array($krt) || is_object($krt)){ ?>
              @foreach ($krt as $key => $value)
                  <td><?php echo($no++); ?></td>
                      <td>{{ $value['nama'] }}</td>
                      <td>
                          {{ $value['IPK']}}
                      </td>
                      <td>
                      @if( $value['akumulasi_skor'] == 0 )
                          {{ 'A' }}
                      @elseif($value['akumulasi_skor'] >=1 && $value['akumulasi_skor'] <=5)
                          {{ 'AB' }}
                      @elseif( $value['akumulasi_skor'] >=6 && $value['akumulasi_skor'] <=10)
                          {{ 'B' }}
                      @elseif( $value['akumulasi_skor'] >=11 && $value['akumulasi_skor'] <=15)
                          {{ 'BC' }}
                      @elseif( $value['akumulasi_skor'] >=16 && $value['akumulasi_skor'] <=25)
                          {{ 'C' }}
                      @elseif( $value['akumulasi_skor'] >=26 && $value['akumulasi_skor'] <=30)
                          {{ 'D' }}
                      @elseif( $value['akumulasi_skor'] > 30)
                          {{ 'E' }}
                      @else
                          {{ 'data tidak terdefenisi' }}
                      @endif
                      </td>
                  <td>
                      {{ $key }}
                  </td>
          </tr>
          @endforeach
          <?php } ?>
      </table>
  </div>
</div>
@endsection
