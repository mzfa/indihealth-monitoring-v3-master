<?php
namespace App\Helpers;

use App\Models\Guest;

class AuthGuest
{
	public static function guest()
	{
		$guest = Guest::where('id', session('id'))->first();
		if(empty($guest))
		{
			self::logout();
			return redirect()->route('guest.login_form');
		}
		return $guest;
	}

	public static function logout()
	{
		$session['is_logged'] = false;
	    $session['id'] = null;
	    session()->forget($session);
	    session()->regenerate();
	    return true;
	}

	public static function check()
	{
		return session('is_logged')?true:false;
	}


}
