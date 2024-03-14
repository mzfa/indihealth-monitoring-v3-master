<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\MailHelper;
use File;
use Symfony\Component\Process\Process;
use Artisan;
use Storage;
use Log;

class BackupController extends Controller
{
	private $total_files = 0;
	private $total_size	 = 0;

  //   public function index()
  //   {
 	// 	$filelist = [];
  //   	foreach (File::allFiles(storage_path('app/backups')) as $file) {
  //   		$file =  pathinfo($file);
  //   		$file_path = storage_path('app/backups/'.$file['basename']);
  //   		unset($file['dirname']);
  //   		unset($file['filename']);
  //   		$file['size'] = $this->formatBytes(File::size($file_path));
  //   		$file['created_at'] = date("Y-m-d, H:m:s", filemtime($file_path));
  //   		$filelist[] = $file;

  //   		$this->total_size += File::size($file_path);
  //   		$this->total_files += 1;

		// }

		// return \Json::response(200, 'backup', [
		// 	'total_size' 	=> $this->formatBytes($this->total_size),
		// 	'total_files' 	=> $this->total_files,
		// 	'files' 		=> $filelist],[]
		// );
  //   }

    public function run(Request $request)
    {
    	 if(md5($request->access_key) != md5(config('app.access_key')))
            {
                return abort(401);
            }
    	try{
				ignore_user_abort(true);
				set_time_limit(0);
    		$dir = str_replace(DIRECTORY_SEPARATOR,"/", dirname(__DIR__,5));
    		Artisan::call('clean:directories');//Hapus file yang berumur lebih dari 14 hari
    		$output[] = Artisan::output();
    		Artisan::call('backup:clean');//Clean Backup database.
    		$output[] = Artisan::output();
    		Artisan::call('backup:run --only-db');//Jalankan backup database
    		$output[] = Artisan::output();

    		$total_size = 0;
    		foreach( File::allFiles(storage_path('app/backups/')) as $file)
		    {
		        $total_size += $file->getSize();
		    }
		    $size = $this->formatBytes($total_size);
				$message['status'] =  "BACKUP SUCCESS";
				$message['total_size'] = $size;
				$message['ip_address'] = $request->ip();
				$message['reqMethod'] = strtoupper($request->method());
				$message['path_request'] = $request->path();
				$message['agent'] = $_SERVER['HTTP_USER_AGENT'];
				$message['output'] = $output;
				$message['time'] = date('Y-m-d H:i:s');
				Log::notice("BACKUP-LOG"." ".json_encode($message));
    		return response()->json(['message' => 'BACKUP BERHASIL.','total_size' => $size,'code' => 'BK01','console_log' => $output]);

    	} catch(\Exception $e){
				// dd($e);
				$message['status'] =  "BACKUP FAILED";
				$message['ip_address'] = $request->ip();
				$message['reqMethod'] = strtoupper($request->method());
				$message['path_request'] = $request->path();
				$message['agent'] = $_SERVER['HTTP_USER_AGENT'];
				$message['output'] = json_encode($e->getMessage());
				$message['time'] = date('Y-m-d H:i:s');
				Log::notice("BACKUP-LOG"." ".json_encode($message));
            return response()->json(['message' => 'Internal Server ERROR.','code' => 'ERR01']);
    	}
    }

    // public function download(Request $request)
    // {
    // 	$path = storage_path('app/backups/'.$request->basename);
    // 	if(File::exists($path))
    // 	{
    // 		return response()->download($path);
    // 	} else{
    // 		 return \Json::response(400, 'backup', null,['File not exists.']);
    // 	}
    // }

    private function formatBytes($size, $precision = 2)
	{
		if(empty($size))
		{
			return "0 B";
		}
	    $base = log($size, 1024);
	    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

	    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}
}
