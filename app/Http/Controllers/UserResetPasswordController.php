<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SN;
Use AuthGuest;
use App\Models\UserResetPwd;
use App\Models\User;
use App\Mail\UserSendReset;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mail;

class UserResetPasswordController extends Controller
{
    public function reset_form()
    {
        if(\Session::has('_uid'))
        {
            Session::forget('_uid');
        }
        return view('user.auth.password.email');
    }
    public function resetPwd(Request $request)
    {
         $validate = [
                            'password' => "required|confirmed",
                    ];
		$this->validate($request, $validate);
         $check = UserResetPwd::where('reset_code',$request->code)->count();
         if($check == 1)
         {
            $pwd = UserResetPwd::where('reset_code',$request->code)->first();
            if(time() > $pwd->expired)
            {
                return redirect()->route('user.reset')->with(['message_fail'=>'Link sudah tidak berlaku silahkan untuk mengajukan ulang.']);
            }
            
            User::where('id',$pwd->user_id)->update(['password' => Hash::make($request->password)]);
            $user = User::where('id',$pwd->user_id)->first();
            $title = "USER RESET PWD";
            $message['username'] = $user->email;
            $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
            $message['ip_address'] = $request->ip();
            $message['time'] = date('Y-m-d H:i:s');
            Log::info($title." ".json_encode($message));
            UserResetPwd::where('reset_code',$request->code)->delete();
            
            return redirect()->route('login')->with(['message' => 'Kata sandi berhasil diubah, mohon untuk login kembali.']);
            
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
        $user = User::select(['id','email','name'])->where('email',$request->email)->first();
        if(empty($user))
        {
            return redirect()->back()->with(['message_fail'=>'Pengguna ini tidak ditemukan.']);
        }

       $sn =  SN::setConfig([	
                            'length' => 80,
                            'segment' => 1,
                            'seperator' => null,
                            'charset' => "0123456789abcdefghijklmnopqrstuwxyzAbCDEFGHIJKLMNOPQRSTUVWXYZ"]);
	    $reset_code = $sn->generate();
        $gReset = UserResetPwd::where('id',$user->id);
        $params = $this->params($user,$reset_code);
        
        if($gReset->count() > 0)
        {
            UserResetPwd::where('id',$user->id)->update($params);
        } else{
            UserResetPwd::create($params);
        }
        
        Mail::to($user->email)->send(new UserSendReset($reset_code,$user));
        return redirect()->back()->with(['message_success' => "Kami telah mengirimkan instruksi selanjutnya ke email anda."]);       
    }
    public function confirm($token)
    {   
        $pwd = UserResetPwd::where('reset_code',$token)->count();
        if($pwd > 0)
        {
            return view('user.auth.password.reset')->with(['code' => $token]);
        } 

        return abort(404);
    }

    private function params($user,$reset_code)
    {
        $expired = strtotime(Carbon::now()->addMinutes(15));
        $params = [ 
                    'user_id'      => $user->id,
                    'reset_code'    => $reset_code,
                    'expired'       => $expired,
                  ];

        return $params;
    }
}
