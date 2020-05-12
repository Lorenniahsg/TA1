<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DimPenilaian;
use Session;
use App\Exports\DimPenilaianExport;
use App\Imports\AskmDimPenilaianImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class DimPenilaianController extends Controller
{
  public function index()
{
  $askm_dim_penilaian = DimPenilaian::paginate(10);
  return view('askm_dim_penilaian',['askm_dim_penilaian'=>$askm_dim_penilaian]);
}

public function export_excel()
{
  return Excel::download(new DimPenilaianExport, 'askm_dim_penilaian.xlsx');
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
		Excel::import(new AskmDimPenilaianImport, public_path('/file_excell/'.$nama_file));

		// notifikasi dengan session
		Session::flash('sukses','Data Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect('/askm_dim_penilaian');
	}

}
