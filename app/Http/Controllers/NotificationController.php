<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TicketingMaintenance;
use App\Models\Absensi;
use App\Models\TaskMaintenanceMember;
use App\Models\TaskMember;
use App\Helpers\JSon;
use App\Http\Resources\NotifMember;
use App\Http\Resources\ReqAbsensiNotif;
use App\Http\Resources\NotifTicketing;


class NotificationController extends Controller
{
    public function countNotification()
    {
        $count_member       = TaskMember::where('is_read_notif',false)->where('user_id',auth()->user()->id)->count();
        $count_ticketing_mt = 0;
        $data['invitation'] = $count_member;
        $data['ticketing'] = $count_ticketing_mt;
        $data['total'] = $count_member + $count_ticketing_mt;
        return JSon::response(200,'notification',$data,[]);
    }
    public function notif(Request $request)
    {
        $data = [];
        $member = TaskMember::where('user_id', auth()->user()->id)->where('is_read_toast',false)->get();
        foreach ($member as $member) {
            $data[] = ['title' => "Tugas Baru", 'body' => "Anda telah ditugaskan untuk ".$member->keterangan." pada task ".$member->task->task_name. ", klik untuk menuju task project"];
        }
        TaskMember::where('user_id', auth()->user()->id)->update(['is_read_toast' => true]);



        return JSon::response(200,'taskMember',$data,[]);
    }
    public function notifAbsensi (Request $request)
    {
        $data = [];
        $absens = Absensi::where('is_req_acc', 0)->where('is_read_toast', false)->whereNotNull('request_absen_keluar')->get();
        foreach ($absens as $absens) {
            $data[] = ['title' => "Request Absen Keluar", 'body' => $absens->karyawan->nama_lengkap." melakukan request absen keluar untuk tanggal ".$absens->tanggal." jam ".$absens->request_absen_keluar];
            Absensi::where('id',$absens->id)->update(['is_read_toast' => true]);
        }




        return JSon::response(200,'absensi',$data,[]);
    }

    public function countNotificationAbsensi()
    {
        $absen     = Absensi::where('is_req_acc', 0)->whereNotNull('request_absen_keluar')->where('is_read', false)->count();
        $count_ticketing_mt = 0;
        $data['absensi'] = $absen;
        return JSon::response(200,'notification',$data,[]);
    }
    public function notifContent()
    {
      // dd(TaskMember::where('user_id',auth()->user()->id)->limit(10)->orderBy('created_at','DESC')->get());
        $member       = NotifMember::collection(TaskMember::where('user_id',auth()->user()->id)->where('is_read',0)->limit(10)->orderBy('created_at','DESC')->get());
        $ticketing_mt = NotifTicketing::collection(TicketingMaintenance::where('target_ticketing',auth()->user()->target_ticketing_division_id)->where('target_user', auth()->user()->id)->limit(10)->orderBy('created_at','DESC')->get());
        // TicketingMaintenance::where('target_ticketing',auth()->user()->target_ticketing_division_id)->where('target_user', auth()->user()->id)->where('is_read_notif',false)->update(['is_read_notif' => true]);
        TaskMaintenanceMember::where('is_read_notif',false)->where('user_id',auth()->user()->id)->update(['is_read_notif' => true]);
        $data['invitation'] = $member;
        // $data['ticketing'] = $ticketing_mt;
        return JSon::response(200,'notification',$data,[]);
    }

    public function notifContentAbsensi()
    {
      // dd(TaskMember::where('user_id',auth()->user()->id)->limit(10)->orderBy('created_at','DESC')->get());

        $absen = ReqAbsensiNotif::collection(Absensi::where('is_req_acc', 0)->where('is_read', false)->whereNotNull('request_absen_keluar')->get());
        // TicketingMaintenance::where('target_ticketing',auth()->user()->target_ticketing_division_id)->where('target_user', auth()->user()->id)->where('is_read_notif',false)->update(['is_read_notif' => true]);
        // TaskMaintenanceMember::where('is_read_notif',false)->where('user_id',auth()->user()->id)->update(['is_read_notif' => true]);
        $data['absensi'] = $absen;
        return JSon::response(200,'notification',$data,[]);
    }
}
