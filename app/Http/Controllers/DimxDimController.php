<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DimxDim;
use Session;
use App\Exports\DimxDimExport;
use App\Imports\DimxDimImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class DimxDimController extends Controller
{
  public function index()
{
  $dimx_dim = DimxDim::paginate(10);
  return view('dimx_dim',['dimx_dim'=>$dimx_dim]);
}

public function export_excel()
{
  return Excel::download(new DimxDimExport, 'dimx_dim.xlsx');
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
		Excel::import(new DimxDimImport, public_path('/file_excell/'.$nama_file));

		// notifikasi dengan session
		Session::flash('sukses','Data Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect('/dimx_dim');
	}

}
