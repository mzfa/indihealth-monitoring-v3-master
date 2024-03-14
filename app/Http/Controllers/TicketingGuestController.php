<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketingRequest;
use App\Models\TicketingMaintenance;
use App\Models\TaskMaintenance;
use App\Models\User;
use AuthGuest;
use Image;
use Ramsey\Uuid\Uuid;
use App\Helpers\JSon;
use Mail;
use App\Mail\TicketingMail;

class TicketingGuestController extends Controller
{
    public function create()
    {
      return view('ticketing_mt.create');
    }
    public function index()
    {
      return view('ticketing_mt.index');
    }
   public function sendFeedback(Request $request)
    {
           $validate = [
                            'id' => "required|exists:\App\Models\TicketingMaintenance,id",
                            'feedback' => "nullable|string",
                    ];
        $this->validate($request, $validate);
        TicketingMaintenance::where('id',$request->id)->update(['feedback' => $request->feedback,'status' => 'CONFIRMED']);
        $data['messages'] = "Sukses mengirimkan feedback Ticket";


       return JSon::response(200,'MTTicket',$data,[]);
    }

   public function checkDone(Request $request)
    {
        $data = TicketingMaintenance::where('id',$request->id)->whereIn('status',['DONE'])->first();
         if(empty($data))
         {
            $data['ticketing']="Tiket tidak ditemukan";
             return JSon::validateError(422,'errors',$data);
         }

       return JSon::response(200,'MTTicket',$data,[]);
    }
    public function save(Request $request){
      $request->validate([
                        'judul' => 'required',
                        'project_id' => 'required|exists:\App\Models\Project,id',
                        'division_id' => 'required|exists:\App\Models\TargetTicketingDivision,id',
                        'target_user' => 'required|exists:\App\Models\User,id',
                        'site_address' => 'required',
                        'kronologi' => 'required',
                        'img' => 'nullable|mimes:jpg,png,gif|max:4000',
                    ]);
        $ticket = TicketingMaintenance::create($this->params($request));
        try{
           $user = User::where('id',$request->target_user)->first();
         //   dd($user);
           Mail::to($user->email)->send(new TicketingMail($ticket));

        } catch(\Exception $e){
         // dd($e);
        }

        return redirect()->route('guest.ticketing.status')->with(['message_success' => 'Berhasil membuat ticketing']);
    }
    public function getData(Request $request)
    {

       $data = TicketingMaintenance::where('guest_id', AuthGuest::guest()->id)->get();
        return \DataTables::of($data)
            ->editColumn("created_at", function ($data) {
                return date('Y-m-d H:i:s',strtotime($data->created_at));
            })
            ->editColumn("target_user", function ($data) {
                return empty($data->user_target)?"-":$data->user_target->karyawan->nama_lengkap." (".$data->user_target->karyawan->jabatan->nama.")";
            })

            ->editColumn('status',function($data){
               return view('ticketing_mt.partials.status')->with(['data' => $data])->render();
            })
            ->addColumn('project', function ($data) {
               return empty($data->project)?"-":$data->project->name;
            })
            ->addColumn('division', function ($data) {
               return empty($data->ticketing_target)?"-":$data->ticketing_target->name;
            })

            ->addColumn('progress', function ($data) {
               $mt = TaskMaintenance::where('project_id',$data->project_id)->avg('process');
               return view('ticketing_mt.partials.progress')->with(['data' =>$data,'mt'=>$mt])->render();
            })
            ->addColumn('aksi', function ($data) {
               $mt = TaskMaintenance::where('project_id',$data->project_id)->avg('process');
               return view('ticketing_mt.partials.aksi_guest')->with(['data' =>$data,'mt'=>$mt])->render();
            })

            ->rawColumns(['aksi','timing','progress','status'])
            ->make(true);
    }
    private function params($request)
    {
      if(!empty($request->file('img')))
      {
         $img = $this->imageProcessing($request->file('img'));
      } else{
        $img = null;
      }
       $params = ['project_id' => $request->project_id,
                  'guest_id' => AuthGuest::guest()->id,
                  'target_ticketing' => $request->division_id,
                  'title' => $request->judul,
                  'kronologi' => $request->kronologi,
                  'target_user' => $request->target_user,
                  'alamat_situs' => $request->site_address,
                  'screenshot' => $img,
                  'updated_by' => AuthGuest::guest()->id];
      return $params;
    }

    private function imageProcessing($file)
    {
         $uuid = Uuid::uuid4();
         $file = $file;
         $ext =  $file->getClientOriginalExtension();
         $imgname = 'ticketing-'.date('Ymd')."_".$uuid->toString().'.'.$ext;

         $dest_path = storage_path('app/ticketing/');
          if(!is_dir($dest_path)){
             mkdir($dest_path,770);
          }

          Image::make($file->getRealPath())
                          ->resize(3200,null,function($constraint)
                            {
                              $constraint->aspectRatio();
                              $constraint->upsize();
                             })
                          ->save($dest_path."/".$imgname,75);
          return $imgname;
    }
}
