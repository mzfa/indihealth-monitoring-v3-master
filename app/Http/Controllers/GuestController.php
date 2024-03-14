<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\LinkedProject;
use Hash;
use App\Helpers\JSon;

class GuestController extends Controller
{

    public function index()
    {
    	return view('guest.index');
    }

    public function show(Request $request)
    {
    	$validate = [
                            'id' => "required|exists:\App\Models\Guest,id",
                    ];
            $this->validate($request, $validate);
        $data['data'] = Guest::where('id',$request->id)->first();
        $data['messages'] = "Sukses menampilkan Guest";


       return JSon::response(200,'guest',$data,[]); 
    }

    public function disable(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\Guest,id",
                    ];
            $this->validate($request, $validate);
        $data['data'] = Guest::where('id',$request->id)->update(['is_banned' => true]);
        $data['messages'] = "Sukses menghapus Guest";


       return JSon::response(200,'guest',$data,[]); 
    } 

    public function enable(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\Guest,id",
                    ];
            $this->validate($request, $validate);
        $data['data'] = Guest::where('id',$request->id)->update(['is_banned' => false]);
        $data['messages'] = "Sukses mengaktifkan Guest";


       return JSon::response(200,'guest',$data,[]); 
    }

    public function save(Request $request)
    {
    	 $validate = [
                            'name' => "required",
                            'nama_perusahaan' => "required",
                            'jabatan' => "string|required",
                            'username' => "string|min:3|required|unique:\App\Models\Guest",
                            'email' => "string|required|unique:\App\Models\Guest",
                            'no_telp' => "nullable",
                            'password' => "required|confirmed|min:6",
                    ];
		$this->validate($request, $validate);
		
	 	$data['data'] = Guest::create($this->params($request));
        $data['messages'] = "Berhasil menyimpan Guest";


       return JSon::response(200,'guest',$data,[]);
    } 

    public function update(Request $request)
    {
    	 $validate = [
                            'name' => "required",
                            'nama_perusahaan' => "required",
                            'jabatan' => "string|required",
                            'username' => "string|min:3|required|unique:\App\Models\Guest,username,".$request->id,
                            'email' => "string|required|unique:\App\Models\Guest,email,".$request->id,
                            'no_telp' => "nullable",
                            'password' => "nullable|confirmed|min:6",
                    ];
		$this->validate($request, $validate);
		
	 	$data['data'] = Guest::where('id',$request->id)->update($this->params($request));
        $data['messages'] = "Berhasil menyimpan Guest";


       return JSon::response(200,'guest',$data,[]);
    }

    public function getDataGuest(Request $request)
    {
       
       $data = Guest::get();	
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('online', function ($data) {
               return \UserHelper::isGuestOnline($data->id) ? "<span class='badge badge-success'>Online</span>":"<span class='badge badge-secondary'>Offline</span>";
            })
            ->addColumn('status', function ($data) {
               if($data->is_banned && !empty($data->activated_at))
               {
                  return "<span class='badge badge-warning'>Non-aktif</span>";
               } elseif(!$data->is_banned && !empty($data->activated_at)){
                  return "<span class='badge badge-success'>Aktif</span>";
               } elseif(empty($data->activated_at))
               {
                  return "<span class='badge badge-light'>Belum diaktifasi</span>";
               }
            })
            ->addColumn("projek_terhubung", function ($data) {
                return "<a href='#showProject' onclick='addProject(".$data->id.")'>".$this->countProject($data->id). " projek</a>";
            })
            ->addColumn('aksi', function ($data) {
               return view('guest.partials.aksi')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','projek_terhubung','online','status'])
            ->make(true);
    }
    private function countProject($id)
    {
        return LinkedProject::where('guest_id',$id)->count();
    }
    private function params($request)
    {
    	 $params = [
               		'name'         			=> $request->name,
	                'nama_perusahaan'       => $request->nama_perusahaan, 
	                'jabatan'   			=> $request->jabatan,
	                'username'       		=> $request->username,
	                'email'    				=> $request->email,
	                'no_telp'    			=> $request->no_telp,
	                'updated_by'    		=> auth()->user()->id,
          			];			

      if(!empty($request->password))
      {
        $params['password'] = Hash::make($request->password);
      }

    	return $params;
    }
}
