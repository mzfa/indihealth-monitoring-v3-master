<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*
|--------------------------------------------------------------------------
| Cronjob.org Routes
|--------------------------------------------------------------------------
|
*/
Route::post('/services/mailer/sendReminderAbsenKeluar', [App\Http\Controllers\MailSenderController::class, 'absenKeluarReminder']);
Route::post('/services/idh/telemetry/get', [App\Http\Controllers\MonitoringAppController::class, 'telemetry']);
Route::post('/services/idh/devices/get', [App\Http\Controllers\MonitoringAppController::class, 'user_devices']);
Route::post('/services/idh/users/get', [App\Http\Controllers\MonitoringAppController::class, 'user_data']);
Route::post('/services/mailer/sendReportAbsen', [App\Http\Controllers\MailSenderController::class, 'sendLaporanAbsensi']);
Route::post('/services/mailer/sendReportNotulensi', [App\Http\Controllers\MailSenderController::class, 'reportNotulensi']);
Route::post('/services/mailer/TaskReport', [App\Http\Controllers\MailSenderController::class, 'taskReport']);

Route::get('services/autobackup/run',[App\Http\Controllers\BackupController::class, 'run']);
