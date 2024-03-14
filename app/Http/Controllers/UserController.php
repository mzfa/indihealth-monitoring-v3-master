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

class UserController extends Controller
{
    public function index()
    {
    	return view('user.index');
    }

    public function myAccountPassword()
    {
        return view("account.change_password");
    }

    public function setnewpassword()
    {
       $user = User::where('id',auth()->user()->id);
        if(empty($user->first()->activated_at))
        {
           return view("account.setnewpassword");
        } else{
           return redirect()->route('home')->with(['message_warning' => "Tidak perlu, Anda telah mengaktifkan akun ini."]);
        }
    }

    public function myAccountPasswordUpdate(UserPwdRequest $request)
    {
        $user = User::where('id',auth()->user()->id);

        if(Hash::check($request->password_old, $user->first()->password))
        {
          $params['password'] = Hash::make($request->password);
          $user->update($params);
          return redirect()->back()->with(['message_success' => "Berhasil Mengubah Kata Sandi"]);
        }
          return redirect()->back()->with(['message_fail' => "Kata sandi lama tidak sesuai"]);

    } 

    public function activateAccount(UserActivatePwdRequest $request)
    {
        $user = User::where('id',auth()->user()->id);
        if(!empty($user->first()->activated_at))
        {
          return redirect()->route('home')->with(['message_warning' => "Tidak perlu, Anda telah mengaktifkan akun ini."]);
        }
          $params['password'] = Hash::make($request->password);
          $params['activated_at'] = now();
          $user->update($params);
          return redirect()->route('home')->with(['message_success' => "Selamat Datang, Akun anda telah aktif."]);

    }
    public function selectUser(Request $request)
    {
      $usr = User::where('karyawan_id','!=',null)->where('name','like','%'.$request->search.'%');
        if(!empty($request->target_user_division))
        {
          $usr->where('target_ticketing_division_id',$request->target_user_division);
        }

        $user = $usr->orderBy('name','ASC')->limit(10)->get();

        return response()->json(UserSelect::collection($user));
    }
    public function create()
    {
    	return view('user.create');
    } 

    public function edit($id)
    {
        $data = User::where('id',$id)->first();
        return view('user.edit')->with(['data' => $data]);
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

    public function disable(Request $request)
    {
        User::where('id',$request->id)->update(['is_disabled' => true]);

       return redirect()->route('pengguna')->with(['message_success' => "Berhasil menonaktifkan Pengguna"]);
    }
    public function enable(Request $request)
    {
        User::where('id',$request->id)->update(['is_disabled' => false]);

       return redirect()->route('pengguna')->with(['message_success' => "Berhasil mengaktifkan Pengguna"]);
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
               return view('user.partials.aksi')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','mode','karyawan_terkait','status','online'])
            ->make(true);
    }
    public function getRolesSelect(Request $request)
    {
        $data = RoleSelect::collection(Role::where('name','like','%'.$request->search.'%')->orderBy('name','ASC')->limit(10)->get());

        return response()->json($data);
    }
    private function params($request)
    {
         $params = [
                'email'                               => $request->email,
                'name'                                => $request->name, 
                'karyawan_id'                         => $request->karyawan_terkait,
                'role_id'                             => $request->role,
                'target_ticketing_division_id'        => $request->division_id,
                'updated_by'                          => auth()->user()->id,
          ];

      if(!empty($request->password))
      {
        $params['password'] = Hash::make($request->password);
        $params['activated_at'] = null;
      }

      return $params;
    }
}
