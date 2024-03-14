<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CloudStorage;
use App\Models\Project;
use App\Models\CloudCategory;
use Illuminate\Support\Str;
use Storage;
use Hash;
use SN;
use App\Helpers\JSon;
use Irfa\FileSafe\Facades\FileSafe;

class CloudController extends Controller
{
    public function index($project_id)
    {
      $cc = CloudCategory::orderBy('category','ASC')->get();
      $cloud = CloudStorage::where('is_private',false)->where('project_id',$project_id)->get();
      $project = Project::where('id',$project_id)->first();
      return view('cloud/index')->with(['cloud' => $cloud,'category' => $cc,'project' => $project]);
    }

    public function delete(Request $request)
    {
      $validate = [
                    'id' => "required|exists:\App\Models\CloudStorage,id",
                    'project_id' => "required|exists:\App\Models\Project,id",
                    ];
      $this->validate($request, $validate);
      $cl = CloudStorage::where('id',$request->id)->where('user_id',auth()->user()->id);
      if($cl->count() == 1)
      {
        $cl->delete();
        $data['messages'] ="Berhasil Menghapus file.";
        return JSon::response(200,'file',$data,[]);
      }
        $data['messages'] ="Tidak dapat Menghapus file.";
        return JSon::validateError(422,'errors',$data);


    }

    public function private_storage()
    {
      $cc = CloudCategory::orderBy('category','ASC')->get();
      $cloud = CloudStorage::where('is_private',true)->where('user_id',auth()->user()->id)->get();
      return view('cloud/private')->with(['cloud' => $cloud,'category' => $cc]);
    }

    public function download($url,Request $request)
    {
        $cloud = CloudStorage::where('url_name', $url)->first();

        // Cek private
        if($cloud->is_private)
        {
          $file = CloudStorage::where('url_name', $url)->where('user_id',auth()->user()->id)->firstOrFail();

        } else{
          $file = CloudStorage::where('url_name', $url)->firstOrFail();

        }
          $filenameNew = strtr($file->name,[' ' => '-','\'' => '-','"' => '-']);
        if(!empty($cloud->password))
        {
          if(Hash::check($request->password,$cloud->password))
          {
            return Storage::disk('cloud_storage')->download($file->file_name, $filenameNew);
            // return FileSafe::download($file->file_name,$filenameNew.".".$file->extension);
          }  else{
              return redirect()->back()->with(['message_fail' => "Kata Sandi tidak sesuai"]);
          }
        } else{
            return Storage::disk('cloud_storage')->download($file->file_name, $filenameNew);
        }

    }

    public function save(Request $request)
    {
      // dd(empty($request->pwdcheck));
      $validate = [
                    'nama' => "required|unique:\App\Models\CloudStorage,name",
                    'project_id' => "required|exists:\App\Models\Project,id",
                    'kategori' => "required|exists:\App\Models\CloudCategory,id",
                    'pwdcheck' => "nullable|boolean",
                    'password' => "nullable|confirmed|min:8",
                    'file' => "max:51000",
                    'private' => "nullable|boolean"
                    ];
            $this->validate($request, $validate);
      $cloud = CloudStorage::create($this->params($request));
      return redirect()->route('cloud',['project_id' => $request->project_id])->with(['message_success' => "Berhasil Menyimpan File"]);
    }

    private function params($request)
    {
      $sn =  SN::setConfig([
                        'length' => 5,
                        'segment' => 1,
                        'seperator' => '-',
                        'charset' => "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"]);
      // dd(empty($request->pwdcheck));exit();
      if(!empty($request->pwdcheck))
      {
        $file = $this->fileProcessing($request);
        // $file = $this->fileProcessingEncrypt($request);
      } else{
        $file = $this->fileProcessing($request);
      }

       $params = [
                  'user_id' => auth()->user()->id,
                  'name' => $request->nama,
                  'cloud_category_id' => $request->kategori,
                  'url_name' => time().'-'.Str::uuid()->toString().'-'.$sn->generate(),
                  'file_name' => $file->filename,
                  'project_id' => $request->project_id,
                  'mimes'=> $file->mimes,
                  'extension'=> $file->extension,
                  'size' => $file->size,
                  'updated_by' => auth()->user()->id
                ];
      if(!empty($request->private))
      {
          $params['is_private'] = true;
      }
      if(!empty($request->pwdcheck))
      {
          $params['password'] = Hash::make($request->password);
      }

      return $params;

    }

    private function fileProcessing($request)
    {


      $file = $request->file('file');
      $data['filename'] = time()."_".Str::random(20).".".$file->guessExtension();
      $data['mimes'] = $file->getClientMimeType();
      $data['size'] = $file->getSize();
      $data['extension'] = $file->guessExtension();



        $request->file('file')->storeAs(
            'cloud_storage', $data['filename']
        );

      return (object) $data;
    }
    private function fileProcessingEncrypt($request)
    {
      $file = $request->file('file');
      $data['filename'] = time()."_".Str::random(20).".".$file->guessExtension();
      $data['mimes'] = $file->getClientMimeType();
      $data['size'] = $file->getSize();
      $data['extension'] = $file->guessExtension();
      FileSafe::store($file,$data['filename']);

      return (object) $data;
    }


}
