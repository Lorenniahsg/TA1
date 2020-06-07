@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

  <!-- Header -->
  <header class="intro-header text-black">

  </header>
  <!-- END : Header -->
@endsection

  <!-- Main -->
  <br><br><br><br>
  <div class="container">
  <!-- <h1>Fuzzy Topsis</h1> -->
    <ul class="nav nav-tabs" role="tablist">
      <!-- <li class="nav-item">
        <a class="nav-link" href="{{ url('MahasiswaFT') }}" role="tab">Data Mahasiswa</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('PenilaianFT') }}" role="tab">Data Penilaian</a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="{{ url('PerhitunganFT') }}" role="tab">Seleksi Mahasiswa</a>
      </li>
    </ul>

  <!-- Tab panes -->
  <div class="tab-content">
        <div class="tab-pane {{ request()->is('MahasiswaFT') ? 'active': null }}" href="{{ url('MahasiswaFT') }}"
             role="tabpanel">
            <h3>Mahasiswa</h3>
            <a href="{{ url('PenilaianFT') }}" class="btn btn-info btn-md">Seleksi Awal</a>
            <table class="table">
                <th>No</th>
                <th>Nama</th>
                <th>Nilai IPK</th>
                <th>Nilai Prilaku </th>
                <tr>
                    <?php $no = 1; ?>
                    <?php if (is_array($krt) || is_object($krt)){

                    ?>

                    @foreach ($krt as $dt_mhs)
                        <td><?php echo($no++); ?></td>
                        <td>{{ $dt_mhs['nama'] }}</td>
                        <td>
                      @if( $dt_mhs['IPK'] >=3.30 && $dt_mhs['IPK'] <=4.00)
                        {{ 'Very High' }}
                      @elseif($dt_mhs['IPK'] >=2.50 && $dt_mhs['IPK'] <=3.29)
                        {{ 'High' }}
                      @elseif( $dt_mhs['IPK'] >=1.70 && $dt_mhs['IPK'] <=2.49)
                        {{ 'Average' }}
                      @elseif( $dt_mhs['IPK'] >=0.90 && $dt_mhs['IPK'] <=1.69)
                        {{ 'Low' }}
                      @elseif( $dt_mhs['IPK'] <=0.00 && $dt_mhs['IPK'] <=0.89)
                        {{ 'Very Low' }}
                      @else
                        {{ 'data tidak terdefenisi' }}
                      @endif
                        </td>
                        <td>
                      @if( $dt_mhs['akumulasi_skor'] >= 26 )
                        {{ 'Very High' }}
                      @elseif($dt_mhs['akumulasi_skor'] >=16 && $dt_mhs['akumulasi_skor'] <=25)
                        {{ 'High' }}
                      @elseif( $dt_mhs['akumulasi_skor'] >=11 && $dt_mhs['akumulasi_skor'] <=15)
                        {{ 'Average' }}
                      @elseif( $dt_mhs['akumulasi_skor'] >=6 && $dt_mhs['akumulasi_skor'] <=10)
                        {{ 'Low' }}
                      @elseif( $dt_mhs['akumulasi_skor'] <=5 )
                        {{ 'Very Low' }}
                      @else
                        {{ 'data tidak terdefenisi' }}
                      @endif

                        </td>
                </tr>
                @endforeach
                <?php } ?>
            </table>

        </div>

  <div class="tab-pane {{ request()->is('PenilaianFT') ? 'active': null }}" href="{{ url('PenilaianFT') }}" role="tabpanel">
    <h3>Hasil Normalisasi</h3>
    <a href="{{ url('PenilaianFT') }}" class="btn btn-info btn-md">Seleksi Awal</a>
    <table class="table">
      <th>No</th>
      <th>Nama</th>
      <th>Nilai IPK</th>
      <th>Nilai Prilaku</th>
      <th>Hasil Normalisasi</th>
      <tr>
                    <?php $no = 1; ?>
                    <?php if (is_array($krt) || is_object($krt)){

                    ?>

                    @foreach ($krt as $dt_mhs)
                        <td><?php echo($no++); ?></td>
                        <td>{{ $dt_mhs['nama'] }}</td>
                        <td>
                      @if( $dt_mhs['IPK'] >=3.30 && $dt_mhs['IPK'] <=4.00)
                        {{ '7,9,9' }}
                      @elseif($dt_mhs['IPK'] >=2.50 && $dt_mhs['IPK'] <=3.29)
                        {{ '5,7,9' }}
                      @elseif( $dt_mhs['IPK'] >=1.70 && $dt_mhs['IPK'] <=2.49)
                        {{ '3,5,7' }}
                      @elseif( $dt_mhs['IPK'] >=0.90 && $dt_mhs['IPK'] <=1.69)
                        {{ '1,3,5' }}
                      @elseif( $dt_mhs['IPK'] <=0.00 && $dt_mhs['IPK'] <=0.89)
                        {{ '1,1,3' }}
                      @else
                        {{ 'data tidak terdefenisi' }}
                      @endif
                        </td>
                        <td>
                      @if( $dt_mhs['akumulasi_skor'] >= 26 )
                        {{ '7,9,9' }}
                      @elseif($dt_mhs['akumulasi_skor'] >=16 && $dt_mhs['akumulasi_skor'] <=25)
                        {{ '5,7,9' }}
                      @elseif( $dt_mhs['akumulasi_skor'] >=11 && $dt_mhs['akumulasi_skor'] <=15)
                        {{ '3,5,7' }}
                      @elseif( $dt_mhs['akumulasi_skor'] >=6 && $dt_mhs['akumulasi_skor'] <=10)
                        {{ '1,3,5' }}
                      @elseif( $dt_mhs['akumulasi_skor'] <=5 )
                        {{ '1,1,3' }}
                      @else
                        {{ 'data tidak terdefenisi' }}
                      @endif

                        </td>
                </tr>
                @endforeach
                <?php } ?>
            </table>
  </div>

  <div class="tab-pane {{ request()->is('PerhitunganFT') ? 'active': null }}" href="{{ url('PerhitunganFT') }}" role="tabpanel">
    <h3>Kriteria</h3>
      <table class="table">
        <th>No</th>
        <th>Alternatif</th>
        <th>C01</th>
        <th>C02</th>
        <th>SKKM</th>
          <tr>
            <td>sdasda</td>
            <td>asd</td>
            <td>asd</td>
            <td>asda</td>
            <td>asda</td>
          </tr>
      </table>
      <button type="button" name="button">Seleksi SKKM</button>
  <h4>Hasil Ranking</h4>
    <table class="table">
      <th>No</th>
      <th>Alternatif</th>
      <th>Ranking</th>
        <tr>
          <td>sdasda</td>
          <td>asd</td>
          <td>asd</td>
        </tr>
    </table>
    <span onclick="this.parentElement.style.display='none'"></span>
  </div>
</div>
  </div>
</body>
