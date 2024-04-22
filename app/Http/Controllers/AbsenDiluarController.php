<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkedProject;
use Hash;
use App\Helpers\JSon;
use App\Models\Karyawan;
use App\Models\Penggajian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AbsenDiluarController extends Controller
{

   public function index()
   {
      $data = DB::table('alasan_absen')->select('alasan_absen.*','karyawan.nama_lengkap','karyawan.nip')->leftJoin('karyawan','karyawan.id','alasan_absen.karyawan_id')->where('alasan_absen.created_at', date('Y-m-d'))->get();
      return view('absen_diluar.index', compact('data'));
   }

   public function status($status, $id)
   {
      // dd($status,$id);  
      if($status == 'terima'){
         $data = [
            'updated_at' => date('Y-m-d'),
            'acc_by' => auth()->user()->id,
            'status' => 'terima',
         ];
         DB::table('alasan_absen')->where(['id' => $id])->update($data);
      }elseif($status == 'tolak'){
         $data = [
            'updated_at' => date('Y-m-d'),
            'acc_by' => auth()->user()->id,
            'status' => 'tolak',
         ];
         DB::table('alasan_absen')->where(['id' => $id])->update($data);
      }else{
         $data = [
            'updated_at' => date('Y-m-d'),
            'acc_by' => null,
            'status' => null,
         ];
         DB::table('alasan_absen')->where(['id' => $id])->update($data);
      }
      return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
      // return JSon::response(200, 'penggajian', $data, []);
   }
   public function delete($id)
   {
      $data = [
         'is_delete' => 1,
      ];
      DB::table('penggajian')->where(['id' => $id])->update($data);

      return Redirect::back()->with(['success' => 'Data Berhasil Di Ubah!']);
      // return JSon::response(200, 'penggajian', $data, []);
   }
   public function slip_gaji($id)
   {
      $data = DB::table('penggajian_detail')->select('penggajian_detail.*','penggajian.nama_penggajian','karyawan.nama_lengkap','karyawan.tempat_lahir','karyawan.tanggal_lahir','karyawan.no_npwp','karyawan.nip','karyawan.no_ktp','karyawan.tipe_karyawan','karyawan.jabatan_id')->leftJoin('penggajian', 'penggajian_detail.penggajian_id', 'penggajian.id')->leftJoin('karyawan', 'penggajian_detail.karyawan_id', 'karyawan.id')->where(['penggajian_detail.id' => $id])->first();
      // dd($data);
      return view('penggajian.slip_gaji', compact('data','id'));
      // return JSon::response(200, 'penggajian', $data, []);
   }

   public function getDatapenggajian(Request $request)
   {

      $data = Penggajian::get();
      return \DataTables::of($data)
         ->editColumn("created_at", function ($data) {
            return $data->created_at;
         })
         ->addColumn('status', function ($data) {
            if ($data->is_banned && !empty($data->is_delete)) {
               return "<span class='badge badge-warning'>Non-aktif</span>";
            } elseif (!$data->is_banned && !empty($data->is_delete)) {
               return "<span class='badge badge-success'>Aktif</span>";
            } elseif (empty($data->is_delete)) {
               return "<span class='badge badge-light'>Belum diaktifasi</span>";
            }
         })
         ->addColumn('aksi', function ($data) {
            return view('penggajian.partials.aksi')->with(['data' => $data])->render();
         })
         ->rawColumns(['aksi', 'status'])
         ->make(true);
   }
   private function countProject($id)
   {
      return LinkedProject::where('penggajian_id', $id)->count();
   }
   private function params($request)
   {
      $params = [
         'name'                  => $request->name,
         'nama_perusahaan'       => $request->nama_perusahaan,
         'jabatan'            => $request->jabatan,
         'username'             => $request->username,
         'email'                => $request->email,
         'no_telp'             => $request->no_telp,
         'updated_by'          => auth()->user()->id,
      ];

      if (!empty($request->password)) {
         $params['password'] = Hash::make($request->password);
      }

      return $params;
   }
}
