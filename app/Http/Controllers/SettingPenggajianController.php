<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserPwdRequest;
use App\Http\Requests\UserActivatePwdRequest;
use App\Models\User;
use App\Models\Role;
use App\Http\Resources\RoleSelect;
use App\Http\Resources\UserSelect;
use Hash;

class SettingPenggajianController extends Controller
{
    public function index()
    {
    	return view('setting_penggajian.index');
    }
   //  public function selectUser(Request $request)
   //  {
   //    $usr = User::where('karyawan_id','!=',null)->where('name','like','%'.$request->search.'%');
   //      if(!empty($request->target_user_division))
   //      {
   //        $usr->where('target_ticketing_division_id',$request->target_user_division);
   //      }

   //      $user = $usr->orderBy('name','ASC')->limit(10)->get();

   //      return response()->json(UserSelect::collection($user));
   //  }
    public function create()
    {
    	return view('setting_penggajian.create');
    } 

    public function edit($id)
    {
        $data = User::where('id',$id)->first();
        return view('setting_penggajian.edit')->with(['data' => $data]);
    }

    public function save(UserCreateRequest $request)
    {
        User::create($this->params($request));

       return redirect()->route('pengguna')->with(['message_success' => "Berhasil menambahkan Pengguna"]);
    }

    public function update(UserUpdateRequest $request)
    {
        User::where('id',$request->id)->update($this->params($request));

       return redirect()->route('pengguna')->with(['message_success' => "Berhasil mengubah data Pengguna"]);
    } 
    public function getDataPengguna()
    {
       $data = User::orderBy('created_at','DESC')->get();
       return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('karyawan_terkait', function ($data) {
               return empty($data->karyawan) ? "<i>Tidak Terkait</i>":$data->karyawan->nama_lengkap." (".$data->karyawan->jabatan->nama.")";
            })
            ->addColumn('online', function ($data) {
                if(!empty($data->last_online))
                {
                    $diff = \Carbon\Carbon::createFromTimeStamp(strtotime($data->last_online))->diffForHumans();
                } else{
                    $diff = "";
                }
               return \UserHelper::isOnline($data->id) ? "<span class='badge badge-success'>Online</span>":"<span class='badge badge-secondary'>Offline</span><br><small>". $diff."</small>";
            }) 
            ->addColumn('mode', function ($data) {
               return \UserHelper::userMode($data->id) ? "<i class='far fa-moon'></i>":"<i class='fas fa-sun'></i>";
            })
            ->addColumn('status', function ($data) {
               if($data->is_disabled && !empty($data->activated_at))
               {
                  return "<span class='badge badge-warning'>Non-aktif</span>";
               } elseif(!$data->is_disabled && !empty($data->activated_at)){
                  return "<span class='badge badge-success'>Aktif</span>";
               } elseif(empty($data->activated_at))
               {
                  return "<span class='badge badge-light'>Belum diaktifasi</span>";
               }
            })
            ->addColumn('role', function ($data) {
               return empty($data->role)?'-':strtoupper($data->role->name);
            })
            ->addColumn('aksi', function ($data) {
               return view('setting_penggajian.partials.aksi')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','mode','karyawan_terkait','status','online'])
            ->make(true);
    }
}
