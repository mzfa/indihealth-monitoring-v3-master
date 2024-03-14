<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkedProject;
use App\Helpers\JSon;
use App\Rules\UniqueProject;
use App\Http\Resources\ProjectSelectGuest;
use Str;
use AuthGuest;

class LinkedProjectController extends Controller
{
	public function save(Request $request)
	{
		$validate = [
                            'guest_id' => "required|exists:\App\Models\Guest,id",
                            'project_id' => ['required',"exists:\App\Models\Project,id",new UniqueProject($request->guest_id)],

                      ];
        $this->validate($request, $validate);
        $data['data'] =  LinkedProject::create($this->params($request));
				$data['messages'] = "Sukses menambahkan projek";


       return JSon::response(200,'project',$data,[]);
	}

	public function getDataSelectGuest(Request $request)
	{
			$data = ProjectSelectGuest::collection(LinkedProject::where('guest_id', AuthGuest::guest()->id)
			->whereHas('project',function($query) use($request){
				$query->where('name','like','%'.$request->search.'%')->orderBy('name','ASC');
			})
			->limit(10)->get());

			return response()->json($data);
	}

	public function delete(Request $request)
	{
		$validate = [
                            'id' => "required|exists:\App\Models\LinkedProject,id",

                      ];
       $data['data'] =  LinkedProject::where('id',$request->id)->delete();
       $data['messages'] = "Sukses menambahkan projek";


       return JSon::response(200,'project',$data,[]);
	}
    public function getDataLinkedProject(Request $request)
    {

       $data = LinkedProject::where('guest_id',$request->guest_id)->get();
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('project_name', function ($data) {
               return empty($data->project)?"-":$data->project->name;
            })
            ->addColumn('tanggal', function ($data) {
               return empty($data->project)?"-":$data->project->tanggal;
            })
            ->addColumn('deadline', function ($data) {
               return empty($data->project)?"-":$data->project->deadline;
            })
            ->addColumn('link', function ($data) {
                return view('linkedProject.partials.shareLink')->with(['data' => $data])->render();
            })
            ->addColumn('project_client', function ($data) {
               return empty($data->project)?"-":$data->project->client;
            })
            ->addColumn('aksi', function ($data) {
               return view('linkedProject.partials.aksi')->with(['data' => $data])->render();
            })
            ->rawColumns(['aksi','link'])
            ->make(true);
    }

    private function params($request){
    	$params = [
		    		'guest_id' 		    => $request->guest_id,
		    		'project_id' 	    => $request->project_id,
            'shareable_link'  => Str::random(10),
            'shareable_task_dev' => empty($request->shareable_task_dev)?false:true,
            'shareable_task_mt' =>  empty($request->shareable_task_mt)?false:true,
            'shareable_notulen' => empty($request->shareable_notulensi)?false:true,
		    		'updated_by' 	    => auth()->user()->id,
    			];

    	return $params;
    }
}
