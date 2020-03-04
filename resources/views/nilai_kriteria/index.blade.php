@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="float-left">Nilai Kriteria</h2>
                        <form action="{{route('nilai_kriteria')}}" class="form-inline float-right" method="GET">
                        <div class="form-group">
                            <select name="k" onchange="this.form.submit()" class="form-control">
                                <option value="">-- Pilih Kriteria --</option>
                                @foreach($kriteria as $k)
                                    <option value="{{$k->id}}" {{(request('k') == $k->id)?'selected':''}}>{{$k->kode." - ".$k->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="float-right">
                            <a href="{{route('nilai_kriteria.tambah')}}" class="btn btn-success">Tambah</a>
                        </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Keterangan</th>
                                    <th>Nilai</th>
                                    <th class="text-center" style="width:15%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($nilai_kriterias->isEmpty() || empty($nilai_kriterias))
                                    <tr>
                                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @else
                                    @foreach($nilai_kriterias as $data)
                                        <tr>
                                            <td>{{$data->kriteria->nama}}</td>
                                            <td>{{$data->nama}}</td>
                                            <td>{{$data->nilai}}</td>
                                            <td class="text-center">
                                                <form action="{{route('nilai_kriteria.hapus',['id' => $data->id])}}" method="POST">
                                                    @csrf
                                                    <a href="{{route('nilai_kriteria.edit',['id' => $data->id])}}" class="btn btn-sm btn-warning">Edit</a>
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
