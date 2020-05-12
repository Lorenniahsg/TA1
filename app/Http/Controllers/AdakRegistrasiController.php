<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AdakRegistrasi;
use Session;
use App\Exports\AdakRegistrasiExport;
use App\Imports\AdakRegistrasiImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class AdakRegistrasiController extends Controller
{
  public function index()
{
  $adak_regis = AdakRegistrasi::paginate(10);
  return view('adak_registrasi',['adak_registrasi'=>$adak_regis]);
}
public function export_excel()
{
  return Excel::download(new AdakRegistrasiExport, 'adak_registrasi.xlsx');
}

public function import_excel(Request $request)
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);

		// menangkap file excel
		$file = $request->file('file');

		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		$file->move('file_excell',$nama_file);

		// import data
		Excel::import(new AdakRegistrasiImport, public_path('/file_excell/'.$nama_file));

		// notifikasi dengan session
		Session::flash('sukses','Data Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect('/adak_registrasi');
	}
}
