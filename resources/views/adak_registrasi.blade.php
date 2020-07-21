@extends('template')
@section('title', 'Import Data IP')
@section('intro-header')

<div class="container">
    <h2>Import IP Mahasiswa</h2>
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
			<h4>Import Excel IP Mahasiswa</h4>
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
			Import IP Mahasiswa
		</button>

		<!-- Import Excel -->
		<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form method="post" action="/adak_registrasi/import_excel" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Import IP Excel</h5>
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


		<a href="/adak_registrasi/export_excel" class="btn btn-success my-3" target="_blank" hidden>EXPORT EXCEL</a>
		<table class="table table-striped table-hover">
      <strong style="float: right;">Data Per Halaman : {{ $adak_registrasi->count() }}</strong>
			<thead>
				<tr>
					<th>No</th>
					<th>TA</th>
					<th>SEM TA</th>
					<th>NR</th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@foreach($adak_registrasi as $ip)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$ip->ta}}</td>
					<td>{{$ip->sem_ta}}</td>
					<td>{{$ip->nr}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
    <strong>Halaman : {{ $adak_registrasi->currentPage() }}</strong>
    <strong style="float: right;">Jumlah Data : {{ $adak_registrasi->total() }}</strong>
      {{ $adak_registrasi->links()}}
</div>
@endsection
