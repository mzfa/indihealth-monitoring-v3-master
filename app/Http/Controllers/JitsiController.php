<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\MeetingAttedance;
use SN;

class JitsiController extends Controller
{
    public function index(Request $request)
    {
        $meeting = Meeting::orderBy('created_at','DESC')->limit(20)->get();
        return view('jitsi.index')->with(['meeting' => $meeting]);
    } 

    public function pub_share($shr_code,Request $request)
    {
         $meeting = Meeting::where('share_code', $shr_code)->first();

         if(!empty($meeting))
         {
           if(!empty($meeting->password))
            {
               $meetAtt = MeetingAttedance::where('meeting_room_id', $meeting->id)->get();
               return view('jitsi.pub_insert_pin')->with(['attmeet' => $meetAtt,'meet' => $meeting,'message_success' => "Mohon masukan PIN dahulu"]);
            } else{
              if(!empty($meeting->external_meeting_room))
              {
                  return redirect($meeting->external_meeting_room);
              }
                 $request->session()->put('meet-auth-'.$meeting->id, true);
                return redirect()->route('pubmeet',['room_code' => $meeting->room_code]);
            }
         }
            return "meeting tidak  ditemukan";
    }
    public function pubMeet($room_code,Request $request)
    {

         $meeting = Meeting::where('room_code', $room_code);
         if(empty($meeting->count()))
         {
            return redirect()->route('meeting.index')->with(['message_fail' => "Ruang Meeting Tidak Ditemukan"]);
         }
         $meet = $meeting->first();


         // dd($meet->password);
         if(!empty($meet->password))
         {
            if (\Hash::check($request->password, $meet->password)) {
               $request->session()->put('meet-auth-'.$meet->id, true);
            } else{
                return redirect()->back()->with(['message_fail' => "Kata sandi ruang meeting tidak sesuai"]);
            }



         } else{
             $request->session()->put('meet-auth-'.$meet->id, true);
         }
         if(time() < strtotime($meet->room_open_at))
         {
            return redirect()->route('meeting.index')->with(['message_fail' => "Ruang Meeting Belum Dibuka"]);
         }
        
         $meetAtt = MeetingAttedance::where('meeting_room_id', $meet->id)->get();

        return view('jitsi.pubindex')->with(['room_name' => $room_code,'meet' => $meet,'attd' => $meetAtt]);
    
    }
    public function meeting($room_name,Request $request)
    {


         $meeting = Meeting::where('room_code', $room_name);
         if(empty($meeting->count()))
         {
            return redirect()->route('meeting.index')->with(['message_fail' => "Ruang Meeting Tidak Ditemukan"]);
         }
         $meet = $meeting->first();


         // dd($meet->password);
         if(!empty($meet->password))
         {
            if (\Hash::check($request->password, $meet->password)) {
               $request->session()->put('meet-auth-'.$meet->id, true);
            } else{
                return redirect()->back()->with(['message_fail' => "Kata sandi ruang meeting tidak sesuai"]);
            }



         } else{
             $request->session()->put('meet-auth-'.$meet->id, true);
         }
         if(time() < strtotime($meet->room_open_at))
         {
            return redirect()->route('meeting.index')->with(['message_fail' => "Ruang Meeting Belum Dibuka"]);
         }
         $count = MeetingAttedance::where('meeting_room_id', $meet->id)
         ->where('user_id',  auth()->user()->id)
         ->count();
        if(empty($count))
        {
           MeetingAttedance::create(['meeting_room_id' => $meet->id,'user_id' => auth()->user()->id,'updated_by' => auth()->user()->id]);
        }
         $meetAtt = MeetingAttedance::where('meeting_room_id', $meet->id)->get();

        return view('jitsi.meeting')->with(['room_name' => $room_name,'meet' => $meet,'attd' => $meetAtt]);
    }

    public function create(Request $request)
    {
        $validate = [
                            'name_room' => "required|string",
                            'deskripsi' => "nullable",
                    ];
        $validate['tanggal_mulai'] = "required|date";
        $validate['jam_mulai'] = "required|date_format:H:i";
        $validate['tanggal_selesai'] = "required|date";
        $validate['jam_selesai'] = "required|date_format:H:i";
        if(empty($request->external_link))
        {
          $validate['password'] = "nullable|min:4";

        }

        $this->validate($request, $validate);
        $params = $this->params($request);
        Meeting::create($params);

        return redirect()->back()->with(['message_success' => "Berhasil Membuat Ruang Meeting"]);
    }

    public function delete(Request $request)
    {
        $validate = [
                            'id' => "required|integer|exists:\App\Models\Meeting,id",
                    ];
        $this->validate($request, $validate);
        $meeting = Meeting::where('id',$request->id)->where('updated_by', \Auth::user()->id);
        $cek = $meeting->count();
       if($cek > 0)
       {
        $meeting->delete();
        return redirect()->back()->with(['message_success' => "Berhasil Menghapus Ruang Meeting"]);
       }

        return redirect()->back()->with(['message_fail' => "Tidak dapat menghapus ruang meeting ini, karena anda bukan pemilik ruang ini"]);

    }
    public function share($shr_code,Request $request)
    {
         $meeting = Meeting::where('share_code', $shr_code)->first();

         if(!empty($meeting))
         {
           if(!empty($meeting->password))
            {
               $meetAtt = MeetingAttedance::where('meeting_room_id', $meeting->id)->get();
               return view('jitsi.insert_pin')->with(['attmeet' => $meetAtt,'meet' => $meeting,'message_success' => "Mohon masukan PIN dahulu"]);
            } else{
              if(!empty($meeting->external_meeting_room))
              {
                  return redirect($meeting->external_meeting_room);
              }
                 $request->session()->put('meet-auth-'.$meeting->id, true);
                return redirect()->route('meeting.room',['room_name' => $meeting->room_code]);
            }
         }
            return "meeting tidak  ditemukan";
    }
    private function params($request)
    {
        $open = date('Y-m-d H:i:s', strtotime($request->tanggal_mulai." ".$request->jam_mulai));
        $close = date('Y-m-d H:i:s', strtotime($request->tanggal_selesai." ".$request->jam_selesai));
       $gencode =  SN::setConfig([
                                    'length' => 5,
                                    'segment' => 4,
                                    'seperator' => '',
                                    'charset' => "0123456789ABCDEFGHIJKLMNPQRSTUWXYZ"])
                                ->generate();
        $params = ['room_name' => $request->name_room,
                    'room_code' => 'PIKKC-'.time()."_".$gencode,
                    'password' => empty($request->password) ? null:\Hash::make($request->password),
                    'password' => empty($request->password) ? null:\Hash::make($request->password),
                    'description' => nl2br($request->deskripsi),
                    'external_meeting_room' => $request->external_link,
                    'share_code' => strtoupper(\Str::random(6)),
                    'room_open_at' => $open,
                    'room_close_at' => $close,
                    'updated_by' => \Auth::user()->id,
                ];

        return $params;
    }
}
