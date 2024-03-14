<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\UrlMapping;

class RolesPermissionControler extends Controller
{
    function index()
    {
        // Role::create(['name' => "TEST",'permissions' => json_encode(['id_map_routes' => '1232131','allowed' => true])]);
        $ret['roles'] = Role::orderBy('name','asc')->get();
        return view('roles.index')->with($ret);
    } 

  
}
