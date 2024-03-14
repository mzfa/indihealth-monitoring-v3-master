<?php
namespace App\Helpers;
use App\Models\User;
use App\Models\Role;
use Auth;
use Session;

class Permission
{
	public static function for($role_name)
	{
			$role = self::getRole(Auth::user()->role_id);
			$level = self::arrStrToLower($role_name);

		if($role != null){
			if(in_array(strtolower($role->name),$level))
			{
				return true;
			} else{
				return false;
			}

		} else{
			return false;
		}
	}

	public static function getAllRole()
	{
		 return Role::select(['name','id as id_role'])->where('hidden',0)->orderBy('name','ASC')->get();
	}

	public static function roleName($role_id)
	{
		$role = Role::select('name')->where('id',$role_id)->first();
		if($role != null){
			$ret = $role->name;
		} else{
			$ret = "-";
		}
		return $ret;
	}

	private static function arrStrToLower($arr)
	{
		foreach($arr as $a){
			$ret[]=strtolower($a);
		}
		return $ret;
	}

	private static function getRole($role)
	{
		$role = Role::select('name')->where('id',$role)->first();

		return $role;
	}

	public function userRole()
	{
		return Auth::user()->role->name;
	}
}
