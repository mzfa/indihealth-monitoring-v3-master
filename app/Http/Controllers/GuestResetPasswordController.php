<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SN;
Use AuthGuest;
use App\Models\GuestResetPwd;
use App\Models\Guest;
use App\Mail\GuestSendReset;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mail;

class GuestResetPasswordController extends Controller
{
    public function reset_form()
    {
        if(\Session::has('_gid'))
        {
            Session::forget('_gid');
        }
        return view('guest.auth.password.email');
    }
    public function resetPwd(Request $request)
    {
         $validate = [
                            'password' => "required|confirmed",
                    ];
		$this->validate($request, $validate);
         $check = GuestResetPwd::where('reset_code',$request->code)->count();
         if($check == 1)
         {
            $pwd = GuestResetPwd::where('reset_code',$request->code)->first();
            if(time() > $pwd->expired)
            {
                return redirect()->route('guest.reset')->with(['message_fail'=>'Link sudah tidak berlaku.']);
            }
            
            Guest::where('id',$pwd->guest_id)->update(['password' => Hash::make($request->password)]);
            $user = Guest::where('id',$pwd->guest_id)->first();
            $request->session()->regenerate();
            $session['is_logged'] = true;
            $session['id'] = $user->id;
            $title = "GUEST RESET PWD";
            $message['username'] = $user->username." (".$user->email.")";
            $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
            $message['ip_address'] = $request->ip();
            $message['time'] = date('Y-m-d H:i:s');
            Log::info($title." ".json_encode($message));
            session($session);
            GuestResetPwd::where('reset_code',$request->code)->delete();
            
            return redirect()->route('guest.dashboard')->with(['message_success' => 'Selamat datang kembali.']);
            
         } else{
              return redirect()->back()->with(['message_fail'=>'Token invalid.']);
         }
    }
    public function send_reset(Request $request)
    {
        $validate = [
                            'email' => "required|email",
                            recaptchaFieldName() => recaptchaRuleName()
                    ];
		$this->validate($request, $validate);
        // 
        $guest = Guest::select(['id','email','name'])->where('email',$request->email)->first();
        if(empty($guest))
        {
            return redirect()->back()->with(['message_fail'=>'Pengguna ini tidak ditemukan.']);
        }

       $sn =  SN::setConfig([	
                            'length' => 64,
                            'segment' => 1,
                            'seperator' => null,
                            'charset' => "0123456789abcdefghijklmnopqrstuwxyzAbCDEFGHIJKLMNOPQRSTUVWXYZ"]);
	    $reset_code = $sn->generate();
        $gReset = GuestResetPwd::where('guest_id',$guest->id);
        $params = $this->params($guest,$reset_code);
        
        if($gReset->count() > 0)
        {
            GuestResetPwd::where('guest_id',$guest->id)->update($params);
        } else{
            GuestResetPwd::create($params);
        }
        
        Mail::to($guest->email)->send(new GuestSendReset($reset_code,$guest));
        return redirect()->back()->with(['message_success' => "Kami telah mengirimkan instruksi selanjutnya ke email anda."]);       
    }
    public function confirm($token)
    {   
        $pwd = GuestResetPwd::where('reset_code',$token)->count();
        if($pwd > 0)
        {
            return view('guest.auth.password.reset')->with(['code' => $token]);
        } 

        return abort(404);
    }

    private function params($guest,$reset_code)
    {
        $expired = strtotime(Carbon::now()->addMinutes(10));
        $params = [ 
                    'guest_id'      => $guest->id,
                    'reset_code'    => $reset_code,
                    'expired'       => $expired,
                  ];

        return $params;
    }
}
