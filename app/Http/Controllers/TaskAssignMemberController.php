<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskMember;
use App\Models\TaskReportLog;
use App\Rules\UniqueTaskMember;
use App\Helpers\JSon;
use App\Mail\TaskAssignMail;
use App\Http\Resources\ProjectMemberTaskLogDetail;
use Mail;
use Calendar;

class TaskAssignMemberController extends Controller
{

    public function testCalendar(Request $request)
    {
        $event_config = [
                            'name' => 'TEST',
                            'description' => 'LOREM IPSUM',
                            'startDateTime' => now(),
                            'endDateTime' => now()->addHour(1),
                            'email' => 'irfardy2@gmail.com',
                            'name_user' => 'Irfa Ardiansyah',
                            'comment' => 'Comment',
                        ];
           Calendar::createEvent( $event_config );
         
    }
    public function save(Request $request)
    {
    	$validate = [
                            'user_id' => "required|exists:\App\Models\User,id",
                            'keterangan' => "nullable|max:120",
                            'task_id' => ['required',new UniqueTaskMember($request->user_id)]
                        ];
        $this->validate($request, $validate);
        $data['data'] = TaskMember::create($this->params($request));
        $data['messages'] = "Berhasil menambahkan anggota team.";
        // $event_config = [
        //                     'name' => 'TEST',
        //                     'description' => 'LOREM IPSUM',
        //                     'startDateTime' => now(),
        //                     'endDateTime' => now()->addHour(1),
        //                     'email' => 'irfardy2@gmail.com',
        //                     'name_user' => 'Irfa Ardiansyah',
        //                     'comment' => 'Comment',
        //                 ];
        //    Calendar::createEvent( $event_config );
         try{
           $taskMT = $data['data'];
           // dd($taskMT->member->email);
           Mail::to($taskMT->member->email)->send(new TaskAssignMail($taskMT));

        } catch(\Exception $e){

        }


       return JSon::response(200,'taskMember',$data,[]);
    }

    public function testMail(){
        $ticket = TaskMember::where('id',9)->first();

        return view('email.taskMT')->with(['taskMT' => $ticket]);
    }
    public function notif(Request $request)
    {
        $data = [];
        $member = TaskMember::where('user_id', auth()->user()->id)->where('is_read_toast',false)->get();
        foreach ($member as $member) {
            $data[] = ['title' => "Tugas Maintenance Baru", 'body' => "Anda telah ditugaskan untuk ".$member->tugas_individu." pada task ".$member->taskMaintenance->task_name. ", klik untuk menuju task maintenance"];
        }
        TaskMember::where('user_id', auth()->user()->id)->update(['is_read_toast' => true]);



        return JSon::response(200,'taskMember',$data,[]);
    }
    public function notifDeadline(Request $request)
    {
        $data = [];
        $member = TaskMember::where('user_id', auth()->user()->id)->where('is_read_deadline_toast',false)->get();
        foreach($member as $member)
        {
            if(\TaskHelper::notifDL($member->user_id,$member->task_id,10))
            {
              $data[] = ['title' => "Pemberitahuan Deadline", 'body' => "Kami mengingatkan bahwa deadline untuk perbaikan ".$member->taskMaintenance->task_name." 10 menit lagi"];
            }
        }
        TaskMember::where('user_id', auth()->user()->id)->update(['is_read_deadline_toast' => true]);

        return JSon::response(200,'taskMember',$data,[]);

    }
    public function show(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\TaskMember,id",
                        ];
        $this->validate($request, $validate);
        $data['data'] = TaskMember::where('id', $request->id)->first();
        $data['messages'] = "Sukses menampilkan member";


       return JSon::response(200,'taskMember',$data,[]);
    }
    public function delete(Request $request)
    {
        $validate = [
                            'id' => "required|exists:\App\Models\TaskMember,id",
                        ];
        $this->validate($request, $validate);
        $data['data'] = TaskMember::where('id', $request->id)->delete();
        $data['messages'] = "Sukses menghapus member";


       return JSon::response(200,'taskMember',$data,[]);
    }
    public function datatables(Request $request)
    {

       $data = TaskMember::where('task_id',$request->task_id)->get();
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('nama',function($data){
              $jabatan = empty($data->member->karyawan)?"-":$data->member->karyawan->jabatan->nama;
                return strip_tags($data->member->karyawan->nama_lengkap)."<br>".   "<small>".$jabatan ."</small>";
            })
            ->addColumn('tugas_individu',function($data){
                return $data->tugas_individu;
            })

            ->addColumn('aksi', function ($data) {
               return view('project_monitoring.task.partials.aksi_member_task')->with(['data' => $data])->render();
            })
            ->addColumn('status', function ($data) {
               return view('task_maintenance_member.partials.status')->with(['data' => $data])->render();
            })

            ->rawColumns(['nama','aksi','status'])
            ->make(true);
    }
    public function detailLog(Request $request)
    {
      $data['data'] = new ProjectMemberTaskLogDetail(TaskReportLog::select('task_id','user_id','process','detail_report','kesulitan','solusi','report_date')
              ->where('id',$request->id)
              ->first());

      return JSon::response(200,'member',$data,[]);
    }
    public function datatables_log(Request $request)
    {

       $data = TaskReportLog::where('task_id',$request->task_id)->where('user_id',$request->user_id)->get();
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return $data->created_at;
            })
            ->addColumn('nama_tugas',function($data){
              return $data->task->task_name;
            })
            ->addColumn('tanggal',function($data){
                return $data->report_date;
            })

            ->addColumn('progress', function ($data) {
               return view('project_monitoring.task.partials.progress')->with(['data' => $data])->render();
            })
            ->addColumn('aksi', function ($data) {
               return view('project_monitoring.task.partials.aksi_member_log')->with(['data' => $data])->render();
            })

            ->rawColumns(['nama','aksi','progress'])
            ->make(true);
    }

    private function params($request)
    {
    	$params =[
    				'user_id' => $request->user_id,
    				'task_id' => $request->task_id,
            'keterangan' => $request->keterangan,
    				'updated_by' => auth()->user()->id,
    		];

    	return $params;
    }
}
