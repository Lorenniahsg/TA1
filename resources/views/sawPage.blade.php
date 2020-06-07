@extends('template')
@section('title', 'SAW')
@section('intro-header')
    <!-- Header -->
    <header class="intro-header text-black">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </header>
    <!-- END : Header -->
@endsection

<!-- Main -->
<br><br><br><br>
<div class="container">
    <h1>SAW</h1>
    <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item left">
            <a class="nav-link {{ request()->is('dimx_dim') ? 'active': null }}" href="{{ url('dimx_dim') }}" role="tab">Import Data Mahasiswa</a>
            </li>
            <li class="nav-item">
            <a class="nav-link {{ request()->is('adak_registrasi') ? 'active': null }}" href="{{ url('adak_registrasi') }}" role="tab">Import Data IP</a>
            </li>
            <li class="nav-item">
            <a class="nav-link {{ request()->is('askm_dim_penilaian') ? 'active': null }}" href="{{ url('askm_dim_penilaian') }}" role="tab">Import Data Prilaku</a>
            </li>
            <li class="nav-item">
            <a class="nav-link {{ request()->is('Mahasiswa') ? 'active': null }}" href="{{ url('Mahasiswa') }}"
               role="tab">Seleksi Mahasiswa</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane {{ request()->is('Mahasiswa') ? 'active': null }}" href="{{ url('Mahasiswa') }}"
             role="tabpanel">
            <h3>Mahasiswa</h3>
            <a href="{{ url('Penilaian') }}" class="btn btn-info btn-md">Seleksi Awal</a>
            <table class="table table-striped table-hover">

                <th>No</th>
                <th>Nama</th>
                <th>Nilai IPK</th>
                <th>Nilai Prilaku</th>
                <th>sem ta</th>
                <tr>
                    <?php $no = 1; ?>
                    <?php if (is_array($krt) || is_object($krt)){ ?>

                    @foreach ($krt as $dt_mhs)
                        <td><?php echo($no++); ?></td>
                        <td>{{ $dt_mhs['nama'] }}</td>
                        <td>{{ $dt_mhs['IPK'] }}</td>
                        <td>
                      @if( $dt_mhs['akumulasi_skor'] == 0 )
                        {{ 'A' }}
                      @elseif($dt_mhs['akumulasi_skor'] >=1 && $dt_mhs['akumulasi_skor'] <=5)
                        {{ 'AB' }}
                      @elseif( $dt_mhs['akumulasi_skor'] >=6 && $dt_mhs['akumulasi_skor'] <=10)
                        {{ 'B' }}
                      @elseif( $dt_mhs['akumulasi_skor'] >=11 && $dt_mhs['akumulasi_skor'] <=15)
                        {{ 'BC' }}
                      @elseif( $dt_mhs['akumulasi_skor'] >=16 && $dt_mhs['akumulasi_skor'] <=25)
                        {{ 'C' }}
                      @elseif( $dt_mhs['akumulasi_skor'] >=26 && $dt_mhs['akumulasi_skor'] <=30)
                        {{ 'D' }}
                      @elseif( $dt_mhs['akumulasi_skor'] > 30)
                        {{ 'E' }}
                      @else
                        {{ 'data tidak terdefenisi' }}
                      @endif

                        </td>
                        <td>{{ $dt_mhs['sem_ta'] }}</td>
                </tr>
                @endforeach
                <?php } ?>
            </table>
        </div>


        <div class="tab-pane {{ request()->is('Penilaian') ? 'active': null }}" href="{{ url('Penilaian') }}"
             role="tabpanel">
            <h3>Hasil Seleksi Awal IPK dan Nilai Perilaku (SAW)</h3>
            <a href="{{ url('Skkm') }}" class="btn btn-info btn-md">Seleksi Akhir</a>
            <table class="table table-striped table-hover">
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





        <div class="tab-pane {{ request()->is('Skkm') ? 'active': null }}" href="{{ url('Skkm') }}" role="tabpanel">
            <h3>Data SKKM</h3>
            <a href="{{ url('Skkm/hasil') }}" class="btn btn-info btn-md">Hasil</a>
             <table class="table table-striped table-hover">
                <th>No</th>
                <th>Nama</th>
                <th>Nilai Seleksi Pertama</th>
                <th>SKKM</th>
                <th></th>
                <tr>
                    <?php $no = 1; ?>
                    <?php if (is_array($krt) || is_object($krt)){ ?>
                        @foreach ($krt as $key => $value)
                        <td><?php echo($no++); ?></td>
                        <td>{{ $value['nama'] }}</td>
                        <td>{{ $key }}</td>
                        <td>
                            @if($value['skkm'] == null)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $value['dim_id']; ?>">
                                Tambah SKKM
                            </button>
                            @else
                            {{$value['skkm']}}
                            @endif
                        </td>
                        <td>
                            @if($value['skkm'] !=null)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $value['dim_id']; ?>">
                            Edit SKKM
                            </button>
                            @endif
                        </td>

                        <td>
                            @if($value['skkm'] !=null)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal<?php echo $value['dim_id']; ?>">
                            Hapus SKKM
                            </button>
                            @endif
                        </td>
                </tr>

<!--add Modal -->
<div class="modal fade" id="exampleModal<?php echo $value['dim_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $value['nama']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                    <form method="post" action="/Skkm/store_skkm">
                    {{ method_field('POST') }}
                    {{csrf_field()}}
                    <div class="form-group">
                        <label >SKKM</label>
                        <input type="number" name="skkm" class="form-control"  placeholder="Enter SKKM">
                        <input type="number" hidden name="dim_id" value="<?php echo $value['dim_id']; ?>" class="form-control"  placeholder="ID Mahasiswa">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                    </div>
                </div>
                </div>

                <!-- edit modal -->
                <div class="modal fade" id="editModal<?php echo $value['dim_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $value['nama']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form method="post" action="{{ URL('/Skkm/edit_skkm/'. $value->skkm_id)}}" id=editform>
                    <!-- {{ method_field('POST') }} -->
                    {{csrf_field()}}
                    <div class="form-group">
                        <label >SKKM</label>
                        <input type="number" name="skkm" id="skkm" value="<?php echo $value['skkm']; ?>" class="form-control"  placeholder="Enter SKKM">
                        <input type="number" hidden name="dim_id" value="<?php echo $value['dim_id']; ?>" class="form-control"  placeholder="ID Mahasiswa">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit SKKM</button>
                    </div>
                    </form>
                    </div>
                </div>
                </div>


                 <!--delete modal -->
                 <div class="modal fade" id="deleteModal<?php echo $value['dim_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $value['nama']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form method="post" action="{{ URL('/Skkm/delete_skkm/'. $value->skkm_id)}}" id=deleteform>
                    {{csrf_field()}}
                    <div class="form-group">
                        <label >SKKM</label>
                        <input disabled type="number" name="skkm" id="skkm" value="<?php echo $value['skkm']; ?>" class="form-control"  placeholder="Enter SKKM">
                        <input type="number" hidden name="dim_id" value="<?php echo $value['dim_id']; ?>" class="form-control"  placeholder="ID Mahasiswa">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Delete SKKM</button>
                    </div>
                    </form>
                    </div>
                </div>
                </div>

                @endforeach
                <?php } ?>
            </table>
        </div>


        <div class="tab-pane {{ request()->is('Skkm/hasil') ? 'active': null }}" href="{{ url('Skkm/hasil') }}" role="tabpanel">
            <h3>Hasil Seleksi SKKM</h3>
            <table class="table table-striped table-hover">
                <th>No</th>
                <th>Nama</th>
                <th>Hasil Seleksi SKKM</th>
                <th></th>
                <tr>
                    <?php $no = 1; ?>
                    <?php if (is_array($krt) || is_object($krt)){ ?>
                        @foreach ($krt as $key => $value)
                        <td><?php echo($no++); ?></td>
                        <td>{{ $value['nama'] }}</td>
                        <td>{{ $key }}</td>
                </tr>
                @endforeach
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
