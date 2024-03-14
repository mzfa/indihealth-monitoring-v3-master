<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Helpers\JSon;
use App\Http\Resources\ProjectSelect;
use App\Rules\UniqueProjectClient;
use App\Rules\UniqueProjectMember;
use App\Mail\ProjectAssign;
use Mail;

class ProjectController extends Controller
{
    public function index()
    {
    	return view('project.index');
    }

    public function save(Request $request)
    {
    	 $validate = [
                            'tanggal' => "date|required",
                            'deadline' => ["required","date"],
                            'nama_projek' => ["string","required",new UniqueProjectClient($request->client)],
                            'deskripsi' => "string|required",
                            'client' => "string|required",
                    ];
		$this->validate($request, $validate);

	 	$data['data'] = Project::create($this->params($request));
        $data['messages'] = "Berhasil menyimpan projek";


       return JSon::response(200,'task',$data,[]);
    }

    public function getDataSelect(Request $request)
    {
        $project = Project::where('name','like','%'.$request->search.'%')->whereHas('members',function($query){
          $query->where('user_id', auth()->user()->id);
        })->orderBy('name','ASC')->limit(10)->get();
        $data = ProjectSelect::collection($project);

        return response()->json($data);
    }


    public function update(Request $request)
    {
    	 $validate = [
                            'id' => "required|exists:\App\Models\Project",
                            'tanggal' => "date|required",
                            'deadline' => ["required","date"],
                            'nama_projek' =>  ["string","required",new UniqueProjectClient($request->client,$request->id)],
                            'deskripsi' => "string|required",
                            'client' => "string|required",
                    ];
		$this->validate($request, $validate);

	 	$data['data'] = Project::where('id',$request->id)->update($this->params($request));
        $data['messages'] = "Berhasil mengubah projek";


       return JSon::response(200,'task',$data,[]);
    }

    public function delete(Request $request)
    {
         $validate = [
                            'id' => "required|exists:\App\Models\Project",
                    ];
        $this->validate($request, $validate);

        $data['data'] = Project::where('id',$request->id)->delete();
        $data['messages'] = "Berhasil mengarsipkan projek";


       return JSon::response(200,'task',$data,[]);
    }

    public function show(Request $request)
    {
    	  $validate = [
                            'id' => "required|exists:\App\Models\Project,id",
                    ];
            $this->validate($request, $validate);
        $data['data'] = Project::where('id',$request->id)->first();
        $data['messages'] = "Sukses menampilkan Tugas";


       return JSon::response(200,'project',$data,[]);
    }
    public function getDataProject(Request $request)
    {

       $data = Project::get();
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('aksi', function ($data) {
               return view('project.partials.aksi')->with(['data' => $data])->render();
            })
            ->addColumn('anggota_projek', function ($data) {
               return view('project.partials.member_project')->with(['data' => $data])->render();
            })
            ->editColumn('description', function ($data) {
               return \Str::limit($data->description, 120);
            })
            ->rawColumns(['aksi','anggota_projek'])
            ->make(true);
    }
    public function karyawan_get(Request $request)
    {

       $data = ProjectMember::where('user_id',$request->id)->get();
        return \DataTables::of($data)
            ->editColumn("ditambahkan_pada", function ($data) {
                return date('Y-m-d',strtotime($data->created_at));
            })
            ->addColumn('client', function ($data) {
                return \Str::limit($data->project->client, 64);
            })
            ->addColumn('tipe', function ($data) {
                return $data->is_pm?"<span class='badge badge-primary'>PM/Leader</span>":"<span class='badge badge-secondary'>Member</span>";
            })
            ->addColumn('nama_projek', function ($data) {
              return \Str::limit($data->project->name, 64);
            })
            ->rawColumns(['tipe'])
            ->make(true);
    }

    public function getDataProjectMember(Request $request)
    {

       $data = ProjectMember::where('project_id', $request->id)->get();
        return \DataTables::of($data)
            ->editColumn("ditambahkan_pada", function ($data) {
                return date('Y-m-d',strtotime($data->created_at));
            })
            ->editColumn("jabatan", function ($data) {
                return empty($data->user->karyawan) ? "-":$data->user->karyawan->jabatan->nama;
            })
            ->addColumn('aksi', function ($data) {
               return view('project.partials.aksi_member')->with(['data' => $data])->render();
            })
            ->editColumn('nama', function ($data) {
                return view('project.partials.member_name')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','nama'])
            ->make(true);
    }
    public function member_save(Request $request)
    {
        $validate = [
                            'user_id' => "required|exists:\App\Models\User,id",
                            'project_id' => ["required","exists:\App\Models\Project,id",new UniqueProjectMember($request->user_id,$request->project_id)],
                            'is_pm' => ["nullable","boolean"],
                    ];
        $this->validate($request, $validate);

        //Uncomment jika ingin satu PM saja
        // if(!empty($request->is_pm))
        // {
        //   $cekpm = ProjectMember::where(['project_id' => $request->project_id,'is_pm' => 1])->first();
        //   if(!empty($cekpm))
        //   {
        //     $data['project_manager']="Project Manager sudah ada di projek ini.";
        //     return JSon::validateError(422,'errors',$data);
        //   }
        // }
        $params = ['user_id' => $request->user_id,'project_id' => $request->project_id,'is_pm' => empty($request->is_pm)?0:1,'updated_by' => auth()->user()->id];
        $data['data'] = ProjectMember::create($params);
        $data['messages'] = "Berhasil menambahkan member";

        try{
           $pr = $data['data'];
           // dd($taskMT->member->email);
           Mail::to($pr->user->email)->send(new ProjectAssign($pr));

        } catch(\Exception $e){

        }


        return JSon::response(200,'member',$data,[]);
    }
    public function member_delete(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\ProjectMember,id",
                    ];
        $this->validate($request, $validate);

        ProjectMember::where('id', $request->id)->delete();
        $data['messages'] = "Berhasil menghapus member";


        return JSon::response(200,'member',$data,[]);
    }
    public function set_pm(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\ProjectMember,id",
                            'setPM' => "required|boolean",
                    ];
        $this->validate($request, $validate);
        $getProjectMember = ProjectMember::where(['id' => $request->id])->firstOrFail();
        // $cekpm = ProjectMember::where(['project_id' => $getProjectMember->project_id,'is_pm' => intval($request->setPM)])->get();
        // if(!empty(count($cekpm)))
        // {
        //   foreach($cekpm as $cp)
        //   {
        //     ProjectMember::where('id',$cp->id)->update(['is_pm' => 0]);
        //   }
        // }

        ProjectMember::where('id', $request->id)->update(['is_pm' => intval($request->setPM)]);

        if($request->setPM)
        {
          try{
                   $pm = ProjectMember::where('id', $request->id)->first();
                   $pr = $pm;
                   Mail::to($pr->user->email)->send(new ProjectAssign($pr));

            } catch(\Exception $e){

            }
          $data['messages'] = "Berhasil mengubah member ini menjadi Project Manager";
        } else{
            $data['messages'] = "Berhasil menghapus Project Manager";
        }
         

        return JSon::response(200,'member',$data,[]);
    }
    private function params($request)
    {
    	$params = ["name" 			=> $request->nama_projek,
    				"client" 		=> $request->client,
    				"tanggal"		=> $request->tanggal,
    				"deadline" 		=> $request->deadline,
    				"description"	=> $request->deskripsi,
    				"updated_by" 	=> auth()->user()->id,
    			];

    	return $params;
    }
}
