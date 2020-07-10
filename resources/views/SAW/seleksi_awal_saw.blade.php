@extends('template')
@section('title', 'SAW')
@section('intro-header')

<div class="container">
  <h1>SAW</h1>
  <hr>
  <h2>Hasil Seleksi Awal</h2>
  <hr>
<a href="{{ url('hasilAkhirSaw') }}" class="btn btn-info btn-md">Hasil Akhir</a>
  <table class="table ">
    <thead>
      <th>No</th>
      <th>Nama</th>
      <th>Nilai Awal</th>
      <th>Action</th>
      <th></th>
      <th></th>
    </thead>
    <tbody>
      <tr>
        <?php $no=1; ?>
        @foreach($data_20_besar as $value)
        <td><?= $no++; ?></td>
        <td>{{$value['nama']}}</td>
        <td>{{$value['hasil_awal_saw']}}</td>
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
        @endforeach()
    </tbody>
  </table>
</div>
@endsection
