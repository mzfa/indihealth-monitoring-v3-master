<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskMaintenanceLevel;
use App\Helpers\JSon;
use App\Http\Resources\TaskMaintenanceLevelResource;

class TaskMaintenanceLevelController extends Controller
{
    public function index()
    {
    	return view('task_maintenance_level.index');
    }
    public function save(Request $request)
    {
    	$validate = [
                            'name' => "required|unique:\App\Models\TaskMaintenanceLevel,name",
                            'minutes' => "required|min:1|integer",
                            'description' => "required",
                    ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenanceLevel::create($this->params($request));
        $data['messages'] = "Sukses menampilkan Guest";


       return JSon::response(200,'level',$data,[]); 
    }
    public function show(Request $request)
    {
    	$validate = [
                            'id' => "required|exists:\App\Models\TaskMaintenanceLevel,id",
                    ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenanceLevel::where('id',$request->id)->first();
        $data['messages'] = "Sukses menampilkan data Level";


       return JSon::response(200,'level',$data,[]); 
    }

    public function getDescription(Request $request)
    {
    	$validate = [
                            'id' => "required|exists:\App\Models\TaskMaintenanceLevel,id",
                    ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenanceLevel::select('description','minutes')->where('id',$request->id)->first();
        $data['messages'] = "Sukses menampilkan data Level";

       	return JSon::response(200,'level',$data,[]); 
    }
    public function getLevelSelect(Request $request)
    {
        $data = TaskMaintenanceLevelResource::collection(TaskMaintenanceLevel::where('name','like','%'.$request->search.'%')->orderBy('name','ASC')->limit(10)->get());

        return response()->json($data);
    }

    public function delete(Request $request)
    {
    	$validate = [
                            'id' => "required|exists:\App\Models\TaskMaintenanceLevel,id",
                    ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenanceLevel::where('id',$request->id)->delete();
        $data['messages'] = "Sukses menghapus data Level";


       return JSon::response(200,'level',$data,[]); 
    }
    public function update(Request $request)
    {
    	$validate = [
                            'id' => "required|exists:\App\Models\TaskMaintenanceLevel,id",
                            'name' => "required|unique:\App\Models\TaskMaintenanceLevel,name,".$request->id,
                            'minutes' => "required|min:1|integer",
                            'description' => "required",
                    ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenanceLevel::where('id',$request->id)->update($this->params($request));
        $data['messages'] = "Sukses update data Level";


       return JSon::response(200,'level',$data,[]); 
    }
    public function getDataLevel(Request $request)
    {
       
       $data = TaskMaintenanceLevel::get();	
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('aksi', function ($data) {
               return view('task_maintenance_level.partials.aksi')->with(['data' => $data])->render();
            })
            ->editColumn('description', function ($data) {
               return \Str::limit($data->description, 120);
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function params($request)
    {
    	$params = ['name' => $request->name,
    				'description' => $request->description,
    				'minutes' => $request->minutes,
    				'updated_by' => auth()->user()->id,
    			];
    	return $params;
    }
}
