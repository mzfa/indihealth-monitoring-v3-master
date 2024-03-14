<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskMaintenanceMember;
use App\Rules\UniqueMTMember;
use App\Helpers\JSon;
use App\Mail\TaskMaintenanceMail;
use Mail;

class TaskMaintenanceMemberController extends Controller
{
    public function save(Request $request)
    {
    	$validate = [
                            'user_id' => "required|exists:\App\Models\User,id",
                            'task_user' => "required",
                            'task_maintenance_id' => ['required',new UniqueMTMember($request->user_id)]
                        ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenanceMember::create($this->params($request));
        $data['messages'] = "Sukses menampilkan Guest";
         try{
           $taskMT = $data['data'];
         //   dd($user);
           Mail::to($taskMT->member->email)->send(new TaskMaintenanceMail($taskMT));

        } catch(\Exception $e){
         dd($e);
        }


       return JSon::response(200,'taskMember',$data,[]);
    }
    
    public function testMail(){
        $ticket = TaskMaintenanceMember::where('id',9)->first();

        return view('email.taskMT')->with(['taskMT' => $ticket]);
    }
    public function notif(Request $request)
    {
        $data = [];
        $member = TaskMaintenanceMember::where('user_id', auth()->user()->id)->where('is_read_toast',false)->get();
        foreach ($member as $member) {
            $data[] = ['title' => "Tugas Maintenance Baru", 'body' => "Anda telah ditugaskan untuk ".$member->tugas_individu." pada task ".$member->taskMaintenance->task_name. ", klik untuk menuju task maintenance"];
        }
        TaskMaintenanceMember::where('user_id', auth()->user()->id)->update(['is_read_toast' => true]);



        return JSon::response(200,'taskMember',$data,[]);
    }
    public function notifDeadline(Request $request)
    {
        $data = [];
        $member = TaskMaintenanceMember::where('user_id', auth()->user()->id)->where('is_read_deadline_toast',false)->get();
        foreach($member as $member)
        {
            if(\TaskHelper::notifDL($member->user_id,$member->task_maintenance_id,10))
            {
              $data[] = ['title' => "Pemberitahuan Deadline", 'body' => "Kami mengingatkan bahwa deadline untuk perbaikan ".$member->taskMaintenance->task_name." 10 menit lagi"];
            }
        }
        TaskMaintenanceMember::where('user_id', auth()->user()->id)->update(['is_read_deadline_toast' => true]);

        return JSon::response(200,'taskMember',$data,[]);

    }
    public function show(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\TaskMaintenanceMember,id",
                        ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenanceMember::where('id', $request->id)->first();
        $data['messages'] = "Sukses menampilkan member";


       return JSon::response(200,'taskMember',$data,[]);
    }
    public function delete(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\TaskMaintenanceMember,id",
                        ];
        $this->validate($request, $validate);
        $data['data'] = TaskMaintenanceMember::where('id', $request->id)->delete();
        $data['messages'] = "Sukses menampilkan member";


       return JSon::response(200,'taskMember',$data,[]);
    }
    public function getDataMember(Request $request)
    {

       $data = TaskMaintenanceMember::where('task_maintenance_id',$request->task_mt_id)->get(); 
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('nama',function($data){
                return $data->member->karyawan->nama_lengkap;
            })
            ->addColumn('tugas_individu',function($data){
                return $data->tugas_individu;
            })
            ->addColumn('email',function($data){
                return $data->member->email;
            })
            ->addColumn('aksi', function ($data) {
               return view('task_maintenance_member.partials.aksi')->with(['data' => $data])->render();
            })
            ->addColumn('status', function ($data) {
               return view('task_maintenance_member.partials.status')->with(['data' => $data])->render();
            })
            ->addColumn('jabatan',function($data){
                return $data->member->karyawan->jabatan->nama;
            })
            ->rawColumns(['aksi','status'])
            ->make(true);
    }

    private function params($request)
    {
    	$params =[
    				'user_id' => $request->user_id,
    				'task_maintenance_id' => $request->task_maintenance_id,
                    'tugas_individu' => $request->task_user,
    				'updated_by' => auth()->user()->id,
    		];

    	return $params;
    }
}
