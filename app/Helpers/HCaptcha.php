<?php
namespace App\Helpers;

use App\Models\Guest;
use Illuminate\Support\Facades\Config;

class HCaptcha
{
	public static function check($post_resp)
	{
		if($_SERVER['SERVER_NAME'] == 'localhost')
		{ 
			return true; // Skip if localhost
		}
		$data = array(
	            'secret' => Config::get('app.h_key'),
	            'response' => $post_resp
	        );
		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($verify); 

		$responseData = json_decode($response);
		if($responseData->success) {
		    return true;
		} 

		return false;
	}
	

}
