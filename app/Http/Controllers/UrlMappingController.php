<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\UrlMapping;

class UrlMappingController extends Controller
{
    function index()
    {
        // Role::create(['name' => "TEST",'permissions' => json_encode(['id_map_routes' => '1232131','allowed' => true])]);
        $ret['mapping'] = UrlMapping::orderBy('name','asc')->get();
        return view('url_mapping.index')->with($ret);
    }

    function addMapping()
    {
        $ret['mapping'] = UrlMapping::orderBy('name','asc')->get();
        return view('url_mapping.add')->with($ret);
    }
    function editMapping($id)
    {
        $ret['data'] = UrlMapping::where('id',$id)->firstOrFail();
        $ret['mapping'] = UrlMapping::orderBy('name','asc')->get();
        return view('url_mapping.edit')->with($ret);
    }

    function saveMapping(Request $request)
    {
        // dd("");
        $validate = [
                            'name' => "required|unique:\App\Models\UrlMapping,name",
                            'url' => "nullable|unique:\App\Models\UrlMapping,url",
                            'icon' => ['nullable'],
                            'parent_id' => ['nullable'],
                            'order_menus' => ['nullable'],
                            'type' => ['required','in:button,page'],
                        ];
        $this->validate($request, $validate);

        $p = UrlMapping::create($this->params($request));


         return redirect()->route("config.url.mapping")->with(['message_success' => "Berhasil menyimpan mapping"]);


    }

    function updateMapping(Request $request)
    {
        // dd("");
        $validate = [
                            'id' => "required|exists:\App\Models\UrlMapping,id",
                            'name' => "required|unique:\App\Models\UrlMapping,name,".$request->id,
                            'url' => "nullable|unique:\App\Models\UrlMapping,url,".$request->id,
                            'icon' => ['nullable'],
                            'parent_id' => ['nullable'],
                            'order_menus' => ['nullable'],
                            'type' => ['required','in:button,page'],
                        ];
        $this->validate($request, $validate);

        $p = UrlMapping::where('id',$request->id)->update($this->params($request));


         return redirect()->route("config.url.mapping")->with(['message_success' => "Berhasil mengubah url mapping"]);


    }

    function deleteMapping($id)
    {
       

        $p = UrlMapping::where('id',$id)->delete();


         return redirect()->route("config.url.mapping")->with(['message_success' => "Berhasil menghapus url mapping"]);


    }

    function params($request)
    {
        $params = [
                    'name' => $request->name,
                    'parent_id' => $request->parent_id,
                    'icon' => $request->icon,
                    'url' => $request->url,
                    'order_menus' => $request->order_menus,
                    'created_by' => auth()->user()->id
                  ];


        return $params;
    }
}


