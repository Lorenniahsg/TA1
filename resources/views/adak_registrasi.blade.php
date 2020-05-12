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
	<div class="container">
		<center>
			<h4>Import Excel IP Mahasiswa</h4>
			<!-- <h5><a target="_blank" href="https://www.malasngoding.com/">www.malasngoding.com</a></h5> -->
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
							<h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
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
    <br>
		<table class="table table-striped table-hover">
      <strong style="float: right;">Data Per Halaman : {{ $adak_registrasi->perPage() }}</strong>
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
				@foreach($adak_registrasi as $s)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$s->ta}}</td>
					<td>{{$s->sem_ta}}</td>
					<td>{{$s->nr}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
    <strong>Halaman : {{ $adak_registrasi->currentPage() }}</strong>
    <strong style="float: right;">Jumlah Data : {{ $adak_registrasi->total() }}</strong>
    <div class="card-body">
      {{ $adak_registrasi->links()}}
    </div>
	</div>
</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
