<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use Illuminate\Support\Facades\Log;
use Hash;

class AuthGuestController extends Controller
{
    public function login_form()
    {
        if(\AuthGuest::check())
        {
            return redirect()->route('guest.dashboard');
        }
    	return view('guest.auth.login');
    }
    
    public function login(Request $request)
    {
        if(\AuthGuest::check())
        {
            return redirect()->route('guest.dashboard');
        }
    	$user = Guest::orWhere(['username' => $request->username,'email' => $request->username])->first();
    	if(empty($user))
    	{
    		return redirect()->back()->with(['message_fail' => "Pengguna tidak ditemukan."]);
    	}
    	if (Hash::check($request->password, $user->password)) {
		    $request->session()->regenerate();
		    $session['is_logged'] = true;
		    $session['id'] = $user->id;
            $title = "GUEST LOGIN";
            $message['username'] = $user->username." (".$user->email.")";
            $message['agent'] = $_SERVER['HTTP_USER_AGENT'];
            $message['ip_address'] = $request->ip();
            $message['time'] = date('Y-m-d H:i:s');
            Log::info($title." ".json_encode($message));
		    session($session);
            if(\Session::has('url_previous'))
            {
                return redirect(session('url_previous'));
            }
            
		    return redirect()->route('guest.dashboard');
		}
			return redirect()->back()->with(['message_fail' => "Username atau Kata Sandi salah."]);
    }

    public function logout(Request $request)
    {
    	\AuthGuest::logout();
    	return redirect()->route('guest.login_form');
    }
}
