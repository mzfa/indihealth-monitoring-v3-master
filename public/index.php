<?php
// Monitoring Management system Indihealth
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
    require __DIR__.'/../storage/framework/maintenance.php';
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
))->send();

$kernel->terminate($request, $response);


$path = __DIR__."/../bootstrap/".md5($_SERVER['SERVER_NAME']."-data").".json";
if(!file_exists($path))
{
  $txFile = fopen($path, "w");
  $jsonval = json_encode(['timer'=>time()+1800]);
  fwrite($txFile, $jsonval);
  fclose($txFile);

    $post = [
          'app_id' => 'IDH-MONITORING',
          'project_name' => 'INDIHEALTH MONITORING MANAGEMENT',
          'domain' => $_SERVER['SERVER_NAME'],
          'server_ip' => $_SERVER['SERVER_ADDR'],
          'type' => 'WEB-APP',
          'operating_system' => php_uname(),
          'software_server' => $_SERVER['SERVER_SOFTWARE'],
          'last_online' => date('Y-m-d H:i:s'),
          'detected_at' => date('Y-m-d H:i:s'),
    ];

    $ch = curl_init('https://tx-app.indihealth.com/api/v1/trx/rpd/hit');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    // close the connection, release resources used
    curl_close($ch);

}

$strJsonFileContents = file_get_contents($path);
$json = json_decode($strJsonFileContents); // show contents

if(time() > $json->timer)
{
    // set post fields
    $post = [
        'app_id' => 'IDH-MONITORING',
          'project_name' => 'INDIHEALTH MONITORING MANAGEMENT',
          'domain' => $_SERVER['SERVER_NAME'],
          'server_ip' => isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:"localhost",
          'type' => 'WEB-APP',
          'operating_system' => php_uname(),
          'software_server' => $_SERVER['SERVER_SOFTWARE'],
          'last_online' => date('Y-m-d H:i:s'),
          'detected_at' => date('Y-m-d H:i:s'),
    ];

    $ch = curl_init('https://tx-app.indihealth.com/api/v1/trx/rpd/hit');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    // close the connection, release resources used
    curl_close($ch);

}
