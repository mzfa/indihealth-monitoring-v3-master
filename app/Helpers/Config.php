<?php
namespace App\Helpers;

use Cache;

class Config
{
	public static function load($name){
        $jsonString = file_get_contents(storage_path('app/config/'.$name.'.json'));
		$data = json_decode($jsonString);

		return $data;
    }

    public static function navbarMode()
    {
    	if(Cache::has(auth()->user()->id.'-darkmode'))
    	{
    		$mode = "navbar-inverse navbar-dark";
    	} else{
    		$mode = "navbar-light navbar-white";
    	}

    	return $mode;
    }

    public static function sidebarMode()
    {
    	if(Cache::has(auth()->user()->id.'-darkmode'))
    	{
    		$mode = "sidebar-dark-lightblue";
    	} else{
    		$mode = "sidebar-light-lightblue";
    	}

    	return $mode;
    } 

    public static function textDarkMode()
    {
        if(Cache::has(auth()->user()->id.'-darkmode'))
        {
            $mode = "Light Mode";
        } else{
            $mode = "Dark Mode";
        }

        return $mode;
    } 

    public static function bodyMode()
    {
    	if(Cache::has(auth()->user()->id.'-darkmode'))
    	{
    		$mode = "dark-mode";
    	} else{
    		$mode = "";
    	}

    	return $mode;
    } 
    public static function iconDarkMode()
    {
    	if(Cache::has(auth()->user()->id.'-darkmode'))
    	{
    		$mode = "fas fa-sun";
    	} else{
    		$mode = "far fa-moon";
    	}

    	return $mode;
    }
   


}
