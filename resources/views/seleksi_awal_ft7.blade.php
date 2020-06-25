@extends('template')
@section('title', 'Fuzzy Topsis')
@section('intro-header')

  <!-- Header -->
  <header class="intro-header text-black">

  </header>
  <!-- END : Header -->
@endsection
<br><br><br><br><br>

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
<a class="btn btn-primary float-right col-sm-6" href="{{ url('hasilAkhirFT')}}">Hasil Akhir</a>

  <h1>Jarak FPIS dan FNIS</h1>

  <br><br>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Nilai</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      ?>

      @foreach($krt2 as $key => $value)
      <tr>
        <td>{{$i++}}</td>
        <td>{{$value['nama']}}</td>
        <td>{{$key}}</td>
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
                          <form method="post" action="{{ URL('/Skkm/edit_skkm/'. $value->skkm_id)}}" id='editform'>
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

    </tbody>
  </table>
</div>
