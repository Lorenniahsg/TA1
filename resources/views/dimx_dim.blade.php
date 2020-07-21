@extends('template')
@section('title', 'Import Data Mahasiswa')
@section('intro-header')

<div class="container">
    <h2>Import Data Mahasiswa</h2>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item left">
        <a class="nav-link {{ request()->is('dimx_dim') ? 'active': null }}" href="{{ url('dimx_dim') }}" role="tab">Import Data Mahasiswa</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('adak_registrasi') ? 'active': null }}" href="{{ url('adak_registrasi') }}" role="tab">Import Data IP</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('askm_dim_penilaian') ? 'active': null }}" href="{{ url('askm_dim_penilaian') }}" role="tab">Import Data Perilaku</a>
      </li>
    </ul>
		<center>
			<h4>Import Excel Data Mahasiswa</h4>
		</center>

		{{-- notifikasi form validasi --}}
		@if ($errors->has('file'))
		<span class="invalid-feedback" role="alert">
			<strong>{{ $errors->first('file') }}</strong>
		</span>
		@endif

		{{-- notifikasi sukses --}}
		@if ($sukses = Session::get('sukses'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $sukses }}</strong>
		</div>
		@endif

		<button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importExcel">
			Import Data Mahasiswa
		</button>

		<!-- Import Excel -->
		<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="post" action="/dimx_dim/import_excel" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Import Data Mahasiswa</h5>
						</div>
						<div class="modal-body">
							{{ csrf_field() }}
							<label>Pilih file excel</label>
							<div class="form-group">
								<input type="file" name="file" required="required">
							</div>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>


		<a href="/dimx_dim/export_excel" class="btn btn-success my-3" target="_blank" hidden>EXPORT EXCEL</a>
		<table class="table table-striped table-hover">
      <strong style="float: right;">Jumlah Data Per Halaman : {{ $dimx_dim->count() }}</strong>
			<thead>
				<tr>
					<th>No</th>
					<th>NIM</th>
					<th>Nama</th>
					<th>Tahun Masuk</th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@foreach($dimx_dim as $data_Mhs)
				<tr>
					<td >{{ $i++ }}</td>
					<td>{{$data_Mhs->nim}}</td>
					<td>{{$data_Mhs->nama}}</td>
					<td>{{$data_Mhs->thn_masuk}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

    <strong>Halaman : {{ $dimx_dim->currentPage() }}</strong>
    <strong style="float: right;">Jumlah Data : {{ $dimx_dim->total() }}</strong>
    {{ $dimx_dim->links()}}
</div>
@endsection
