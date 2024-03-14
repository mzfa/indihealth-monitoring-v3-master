<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnlineHistory;

class OnlineKaryawanController extends Controller
{
    public function getDataOnlineKaryawan(Request $request)
    {

       $data = OnlineHistory::where('tanggal',$request->tanggal,)->get();
        return \DataTables::of($data)
            ->addColumn("nama", function ($data) {
                return $data->user->karyawan->nama_lengkap;
            })
            ->addColumn("jabatan", function ($data) {
                return $data->user->karyawan->jabatan->nama;
            })
            ->editColumn("waktu", function ($data) {
                return $data->created_at;
            })
            ->make(true);
    }

}
