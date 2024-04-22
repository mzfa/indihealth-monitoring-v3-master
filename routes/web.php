<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\JSon;
use App\Helpers\AuthGuest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});
Route::get("/sandbox", function () {
    $created = \Carbon\Carbon::createFromTimeStamp(strtotime(now()));

    return \Carbon\Carbon::parse(now())->format('H:i');
});

// Route::get("/tests", [])->name('testtt');
Route::get("/p/meet/{room_code}", [App\Http\Controllers\JitsiController::class, 'pubMeet'])->name('pubmeet');
Route::get("/pub/m/share/{shr_code}", [App\Http\Controllers\JitsiController::class, 'pub_share'])->name('pubshare');

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => ['AuthGuestCheck']], function () {
    Route::group(['middleware' => ['GuestOnlineCheck']], function () {
        Route::prefix('s')->group(function () {
            Route::get('/{shareable_link}', [App\Http\Controllers\GuestPages::class, 'shareable_link'])->name('share.link');
        });
    });
});

Route::prefix('user')->group(function () {
    Route::prefix('reset')->group(function () {
        Route::get('/password', [App\Http\Controllers\UserResetPasswordController::class, 'reset_form'])->name('user.reset');
        Route::post('/send', [App\Http\Controllers\UserResetPasswordController::class, 'send_reset'])->name('user.send_mail');
        Route::get('/passwordCreate/{token}', [App\Http\Controllers\UserResetPasswordController::class, 'confirm'])->name('user.pwd.confirm');
        Route::post('/act', [App\Http\Controllers\UserResetPasswordController::class, 'resetPwd'])->name('user.reset.act');
    });
});
Route::prefix('guest')->group(function () {
    Route::prefix('reset')->group(function () {
        Route::get('/password', [App\Http\Controllers\GuestResetPasswordController::class, 'reset_form'])->name('guest.reset');
        Route::post('/send', [App\Http\Controllers\GuestResetPasswordController::class, 'send_reset'])->name('guest.send_mail');
        Route::get('/passwordCreate/{token}', [App\Http\Controllers\GuestResetPasswordController::class, 'confirm'])->name('guest.pwd.confirm');
        Route::post('/act', [App\Http\Controllers\GuestResetPasswordController::class, 'resetPwd'])->name('guest.reset.act');
    });

    Route::get('/login', [App\Http\Controllers\AuthGuestController::class, 'login_form'])->name('guest.login_form');
    Route::post('/login/act', [App\Http\Controllers\AuthGuestController::class, 'login'])->name('guest.login');


    Route::group(['middleware' => ['AuthGuestCheck']], function () {
        Route::group(['middleware' => ['GuestOnlineCheck']], function () {
            Route::get('/activeAccount', [App\Http\Controllers\GuestPages::class, 'setnewpassword'])->name('password.guest');
            Route::post('/activeAccount/act', [App\Http\Controllers\GuestPages::class, 'activateAccount'])->name('password.guest.active');
            Route::group(['middleware' => ['ActivatingGuest']], function () {
                Route::prefix('services')->group(function () {

                    Route::prefix('action')->group(function () {
                        Route::post('/togglemenu', function () {
                            if (Cache::has('tgmg-' . AuthGuest::guest()->id)) {
                                $toggle = false;
                                Cache::forget('tgmg-' . AuthGuest::guest()->id);
                            } else {
                                $toggle = true;
                                cache(['tgmg-' . AuthGuest::guest()->id => true], now()->addMonths(6));
                            }
                            return JSon::response(200, 'absensi', ['toggle' => $toggle], []);
                        })->name('guest.service.togglemenu');
                    });
                });
                Route::get('/dashboard', [App\Http\Controllers\GuestPages::class, 'dashboard'])->name('guest.dashboard');
                /*
            |--------------------------------------------------------------------------
            | Ticketing MT Routes
            |--------------------------------------------------------------------------
            |
            */
                Route::prefix('ticketing')->group(function () {

                    Route::post('/save', [App\Http\Controllers\TicketingGuestController::class, 'save'])->name('guest.ticketing.save');
                    Route::get('/status', [App\Http\Controllers\TicketingGuestController::class, 'index'])->name('guest.ticketing.status');
                    Route::get('/request', [App\Http\Controllers\TicketingGuestController::class, 'create'])->name('guest.ticketing.request');
                });


                Route::get('/task/dev/{project_id}', [App\Http\Controllers\GuestPages::class, 'taskDev'])->name('guest.project.task.development');
                // Route::get('/task/MT/{project_id}', [App\Http\Controllers\GuestPages::class, 'taskMT'])->name('guest.project.task.maintenance');
                Route::get('/notulensi/{project_id}', [App\Http\Controllers\GuestPages::class, 'notulensi'])->name('guest.project.notulensi');
                Route::get('/logout', [App\Http\Controllers\AuthGuestController::class, 'logout'])->name('guest.logout');
                Route::prefix('api')->group(function () {
                    Route::get('/fetchTaskDev/{id}', [App\Http\Controllers\GuestPages::class, 'getDataTaskDev'])->name('guest.taskdev.datatables');
                    Route::get('/fetchTaskMT/{id}', [App\Http\Controllers\GuestPages::class, 'getDataTaskMT'])->name('guest.taskMT.datatables');
                    Route::get('/getLinkedProject', [App\Http\Controllers\LinkedProjectController::class, 'getDataSelectGuest'])->name('guest.linkedProject.select');
                    Route::get('/getDivision', [App\Http\Controllers\DivisionController::class, 'getSelect'])->name('guest.division.select');
                    Route::get('/getTicketing', [App\Http\Controllers\TicketingGuestController::class, 'getData'])->name('guest.ticketing.datatables');
                    Route::post('/sendFeedback', [App\Http\Controllers\TicketingGuestController::class, 'sendFeedback'])->name('guest.ticketing.sendFeedback');
                    Route::post('/checkTicket', [App\Http\Controllers\TicketingGuestController::class, 'checkDone'])->name('guest.check.ticketdone');
                });

                Route::post('notulensi/show', [App\Http\Controllers\NotulensiController::class, 'show'])->name('notulensi.guest.show');
                Route::get('/selectUser', [App\Http\Controllers\UserController::class, 'selectUser'])->name('guest.pengguna.select');
            });
        });
    });
});


/*
|--------------------------------------------------------------------------
| Internal Routes
|--------------------------------------------------------------------------
|
*/
// Route::group(['middleware' => ['CaptchaCheck']], function () {
Auth::routes(['register' => false]);
// });
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['CheckBanned', 'roles']], function () {
        Route::group(['middleware' => ['ActivatingUser', 'OnlineHistory']], function () {
            Route::prefix('meeting')->group(function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::get('/', [App\Http\Controllers\JitsiController::class, 'index'])->name('meeting.index');
                    Route::any('/room/{room_name}', [App\Http\Controllers\JitsiController::class, 'meeting'])->name('meeting.room');
                    Route::post('/create', [App\Http\Controllers\JitsiController::class, 'create'])->name('meeting.create');
                    Route::post('/delete', [App\Http\Controllers\JitsiController::class, 'delete'])->name('meeting.delete');
                });
            });
            // https://dev.virtualearth.net/REST/v1/Locations?q=Institut%20Teknologi%20Bandung&key=AgCRMh3Aq-zhk5GKgMC9NX25AHTnH5RjDbJ5zJapwOVhaynZu-iQl4YK28aVzJig

            /*
         |--------------------------------------------------------------------------
         | Ticketing MT Routes
         |--------------------------------------------------------------------------
         |
         */
            Route::prefix('cloud')->group(function () {
                Route::group(['middleware' => ['RequireAbsen']], function () {
                    Route::group(['middleware' => ['Tracking']], function () {

                        Route::post('/save', [App\Http\Controllers\CloudController::class, 'save'])->name('cloud.save');
                        Route::post('/delete', [App\Http\Controllers\CloudController::class, 'delete'])->name('cloud.delete');
                        Route::get('/public/{project_id}', [App\Http\Controllers\CloudController::class, 'index'])->name('cloud');
                        Route::get('/private/{project_id}', [App\Http\Controllers\CloudController::class, 'private_storage'])->name('cloud.private');
                        Route::post('/download/{url}', [App\Http\Controllers\CloudController::class, 'download'])->name('cloud.download');
                    });
                });
            });

            Route::prefix('meet')->group(function () {

                Route::group(['middleware' => ['RequireAbsen']], function () {
                    Route::group(['middleware' => ['Tracking']], function () {

                        Route::get('/s/{shr_code}', [App\Http\Controllers\JitsiController::class, 'share'])->name('meeting.share');
                    });
                });
            });
            /*
            |--------------------------------------------------------------------------
            | Project Routes
            |--------------------------------------------------------------------------
            |
            */
            Route::prefix('absensi')->group(function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::get('/self', [App\Http\Controllers\AbsensiController::class, 'indexSelf'])->name('absensi.sendiri');
                    Route::post('/keluar/request', [App\Http\Controllers\AbsensiController::class, 'request_absen'])->name('absen.keluar.request');
                    Route::post('/getAbsenSelf', [App\Http\Controllers\AbsensiController::class, 'showAbsenSelf'])->name('absensi.showAbsenSelf');
                });
                Route::get('/api/absensi/self', [App\Http\Controllers\AbsensiController::class, 'getDataAbsenSelf'])->name('absen.datatables.self');
                Route::post('/api/absensi/stat', [App\Http\Controllers\AbsensiController::class, 'getDataAbsenStatSelf'])->name('absen.getDataAbsenStatSelf');
            });
            Route::prefix('chart')->group(function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::get('/absensi', [App\Http\Controllers\ChartController::class, 'absensi'])->name('chart.absensi');
                    Route::get('/karyawan', [App\Http\Controllers\ChartController::class, 'karyawan'])->name('chart.karyawan');
                    Route::get('/karyawan', [App\Http\Controllers\ChartController::class, 'karyawan'])->name('chart.karyawan');
                    Route::get('/karyawan/detail', [App\Http\Controllers\ChartController::class, 'chartKaryawan'])->name('chart.karyawan.pilih');
                });
                Route::group(['middleware' => ['RequireAbsen']], function () {
                    Route::prefix('api')->group(function () {
                        Route::post('/fetch/chartAbsenKaryawan', [App\Http\Controllers\ChartController::class, 'absensiDataKaryawan'])->name('chart.api.absensi.karyawan');
                        Route::post('/fetch/ChartAbsen', [App\Http\Controllers\ChartController::class, 'absensiData'])->name('chart.api.absensi');
                        Route::post('/fetch/ChartAbsenJamKerja', [App\Http\Controllers\ChartController::class, 'absensiJamKerja'])->name('chart.api.absensiJamKerja');
                        Route::post('/fetch/chartDev', [App\Http\Controllers\ChartController::class, 'chartDev'])->name('chart.api.chartDev');
                        Route::post('/fetch/chartOnline', [App\Http\Controllers\ChartController::class, 'OnlineChart'])->name('chart.api.online');
                        Route::post('/fetch/chartMT', [App\Http\Controllers\ChartController::class, 'chartMT'])->name('chart.api.chartMT');
                        Route::post('/fetch/radar', [App\Http\Controllers\ChartController::class, 'chartRadar'])->name('chart.api.chartRadar');
                        Route::post('/fetch/TipeKaryawan', [App\Http\Controllers\ChartController::class, 'karyawanTipeData'])->name('chart.api.karyawanTipe');
                        Route::post('/fetch/KaryawanOnline', [App\Http\Controllers\ChartController::class, 'KaryawanOnlineData'])->name('chart.api.KaryawanOnline');
                        Route::post('/fetch/jabatanKaryawan', [App\Http\Controllers\ChartController::class, 'jabatanData'])->name('chart.api.jabatan');
                    });
                });
            });

            Route::prefix('onlineKaryawan')->group(function () {
                Route::prefix('api')->group(function () {
                    Route::get('/fetch/OnlinekaryawanTable', [App\Http\Controllers\OnlineKaryawanController::class, 'getDataOnlineKaryawan'])->name('online.datatable');
                });
            });
            /*
            |--------------------------------------------------------------------------
            | Project Routes
            |--------------------------------------------------------------------------
            |
            */
            Route::prefix('project')->group(function () {

                Route::prefix('api')->group(function () {
                    Route::get('/select/fetchProjects', [App\Http\Controllers\ProjectController::class, 'getDataSelect'])->name('project.select');
                });
            });

            /*
        |--------------------------------------------------------------------------
        | services Routes
        |--------------------------------------------------------------------------
        |
        */
            Route::prefix('services')->group(function () {

                Route::prefix('action')->group(function () {
                    Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                        Route::post('/togglemenu', function () {
                            if (Cache::has('tgm-' . auth()->user()->id)) {
                                $toggle = false;
                                Cache::forget('tgm-' . auth()->user()->id);
                            } else {
                                $toggle = true;
                                cache(['tgm-' . auth()->user()->id => true], now()->addYears(1));
                            }
                            return JSon::response(200, 'menu', ['toggle' => $toggle], []);
                        })->name('service.togglemenu');


                        Route::post('/dark-mode', function () {
                            if (Cache::has(auth()->user()->id . '-darkmode')) {
                                $toggle = false;
                                Cache::forget(auth()->user()->id . '-darkmode');
                            } else {
                                $toggle = true;
                                cache([auth()->user()->id . '-darkmode' => true], now()->addYears(3));
                            }
                            return JSon::response(200, 'menu', ['toggle' => $toggle], []);
                        })->name('service.darkmode');
                    });
                });
                Route::prefix('notification')->group(function () {
                    Route::post('/checkMemberInvitation', [App\Http\Controllers\NotificationController::class, 'notif'])->name('services.notif.memberMTInvite');
                    Route::post('/checkDeadLine', [App\Http\Controllers\TaskMaintenanceMemberController::class, 'notifDeadline'])->name('services.notif.Deadline');
                    Route::post('/MTRequest', [App\Http\Controllers\TaskMaintenanceController::class, 'mtRequestNotif'])->name('services.notif.mtRequestNotif');
                    Route::post('/countNotification', [App\Http\Controllers\NotificationController::class, 'countNotification'])->name('services.notif.countNotification');
                    Route::post('/notifList', [App\Http\Controllers\NotificationController::class, 'notifContent'])->name('services.notif.content');
                    Route::group(['roles' => ['superadmin']], function () {
                        Route::post('/notif-absensi', [App\Http\Controllers\NotificationController::class, 'notifAbsensi'])->name('services.notif.absensi');
                        Route::post('/count-notif-absensi', [App\Http\Controllers\NotificationController::class, 'countNotificationAbsensi'])->name('services.notif.count_absensi');
                        Route::post('/request-absen-list', [App\Http\Controllers\NotificationController::class, 'notifContentAbsensi'])->name('services.notif.absenContent');
                    });
                    Route::post('/pulang', [App\Http\Controllers\SystemConfigController::class, 'notifPulang'])->name('services.notif.pulang');
                    Route::post('getCoordinates', [App\Http\Controllers\SystemConfigController::class, 'getlatlng'])->name('services.getLatLng');
                });
            });
            /*
        |--------------------------------------------------------------------------
        | Notulensi Routes
        |--------------------------------------------------------------------------
        |
        */
            Route::prefix('notulensi')->group(function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::group(['roles' => ['hrd', 'superadmin', 'owner']], function () {
                        Route::post('/export', [App\Http\Controllers\NotulensiController::class, 'exportPDF'])->name('notulensi.export');
                    });
                    Route::get('/project', [App\Http\Controllers\NotulensiController::class, 'index'])->name('notulensi');
                    Route::post('/save', [App\Http\Controllers\NotulensiController::class, 'save'])->name('notulensi.save');
                    Route::post('/delete', [App\Http\Controllers\NotulensiController::class, 'delete'])->name('notulensi.delete');
                    Route::post('/update', [App\Http\Controllers\NotulensiController::class, 'update'])->name('notulensi.update');
                    Route::post('/show', [App\Http\Controllers\NotulensiController::class, 'show'])->name('notulensi.show');
                });
                Route::prefix('api')->group(function () {
                    Route::get('/fetch', [App\Http\Controllers\NotulensiController::class, 'getDataTask'])->name('notulensi.datatables');
                });
                // Route::prefix('roadmap')->group(function(){
                //     Route::post('/save', [App\Http\Controllers\RoadmapController::class, 'save'])->name('notulensi.roadmap.save');
                //     Route::post('/delete', [App\Http\Controllers\RoadmapController::class, 'delete'])->name('notulensi.roadmap.delete');
                //     Route::post('/update', [App\Http\Controllers\RoadmapController::class, 'update'])->name('notulensi.roadmap.update');
                //     Route::post('/show', [App\Http\Controllers\RoadmapController::class, 'show'])->name('notulensi.roadmap.show');
                // });
            });
            /*
        |--------------------------------------------------------------------------
        | Task Maintenance Routes
        |--------------------------------------------------------------------------
        |
        */
            Route::prefix('ticketingMT')->group(function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    // Route::get('/testMail', [App\Http\Controllers\TaskMaintenanceMemberController::class, 'testMail'])->name('ticketing.testMail');
                    Route::get('/', [App\Http\Controllers\TicketingController::class, 'index'])->name('ticketing.maintenance');
                    Route::post('/updateStatus', [App\Http\Controllers\TicketingController::class, 'update'])->name('ticketing.maintenance.update');
                    Route::get('/images/{file}', [App\Http\Controllers\ImageController::class, 'showMTT'])->name('ticketing.maintenance.showFoto');
                });
                Route::prefix('api')->group(function () {
                    Route::get('/getSelect', [App\Http\Controllers\TicketingController::class, 'getSelect'])->name('ticketing.maintenance.select');
                    Route::post('/showData', [App\Http\Controllers\TicketingController::class, 'show'])->name('ticketing.maintenance.showData');
                    Route::get('/getTicketing', [App\Http\Controllers\TicketingController::class, 'getDatatables'])->name('ticketing.maintenance.datatables');

                    Route::get('/getDivision', [App\Http\Controllers\DivisionController::class, 'getSelect'])->name('division.select');
                });
            });
            /*
        |--------------------------------------------------------------------------
        | Task Maintenance Routes
        |--------------------------------------------------------------------------
        |
        */
            Route::prefix('taskMT')->group(function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::get('/', [App\Http\Controllers\TaskMaintenanceController::class, 'index'])->name('task.maintenance');
                    Route::post('/save', [App\Http\Controllers\TaskMaintenanceController::class, 'save'])->name('task.maintenance.save');
                    Route::post('/delete', [App\Http\Controllers\TaskMaintenanceController::class, 'delete'])->name('task.maintenance.delete');
                    Route::post('/update', [App\Http\Controllers\TaskMaintenanceController::class, 'update'])->name('task.maintenance.update');
                    Route::post('/show', [App\Http\Controllers\TaskMaintenanceController::class, 'show'])->name('task.maintenance.show');
                });
                Route::prefix('api')->group(function () {
                    Route::get('/fetchTask', [App\Http\Controllers\TaskMaintenanceController::class, 'getDataTask'])->name('task.maintenance.datatables');
                    Route::post('/calculateTime', [App\Http\Controllers\TaskMaintenanceController::class, 'calcEnd'])->name('task.maintenance.calctime');
                });
                /*
            |--------------------------------------------------------------------------
            | Member Maintenance Routes
            |--------------------------------------------------------------------------
            |
            */
                Route::prefix('member')->group(function () {
                    Route::post('/save', [App\Http\Controllers\TaskMaintenanceMemberController::class, 'save'])->name('task.maintenance.member.save');
                    Route::post('/delete', [App\Http\Controllers\TaskMaintenanceMemberController::class, 'delete'])->name('task.maintenance.member.delete');
                    Route::post('/show', [App\Http\Controllers\TaskMaintenanceMemberController::class, 'show'])->name('task.maintenance.member.show');
                    Route::prefix('api')->group(function () {
                        Route::get('/fetchMember', [App\Http\Controllers\TaskMaintenanceMemberController::class, 'getDataMember'])->name('task.maintenance.member.datatables');
                    });
                });
                /*
            |--------------------------------------------------------------------------
            | Level Maintenance Routes
            |--------------------------------------------------------------------------
            |
            */
                Route::prefix('level')->group(function () {
                    Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                        Route::get('/', [App\Http\Controllers\TaskMaintenanceLevelController::class, 'index'])->name('task.maintenance.level');
                        Route::post('/save', [App\Http\Controllers\TaskMaintenanceLevelController::class, 'save'])->name('task.maintenance.level.save');
                        Route::post('/delete', [App\Http\Controllers\TaskMaintenanceLevelController::class, 'delete'])->name('task.maintenance.level.delete');
                        Route::post('/update', [App\Http\Controllers\TaskMaintenanceLevelController::class, 'update'])->name('task.maintenance.level.update');
                        Route::post('/show', [App\Http\Controllers\TaskMaintenanceLevelController::class, 'show'])->name('task.maintenance.level.show');
                    });
                    Route::prefix('api')->group(function () {
                        Route::get('/fetchLevel', [App\Http\Controllers\TaskMaintenanceLevelController::class, 'getDataLevel'])->name('task.maintenance.level.datatables');
                        Route::get('/select', [App\Http\Controllers\TaskMaintenanceLevelController::class, 'getLevelSelect'])->name('task.maintenance.level.select');
                        Route::post('/showDescription', [App\Http\Controllers\TaskMaintenanceLevelController::class, 'getDescription'])->name('task.maintenance.level.description');
                    });
                });
            });
            /*
        |--------------------------------------------------------------------------
        | Task Routes
        |--------------------------------------------------------------------------
        |
        */
            Route::prefix('task')->group(function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::get('/task-list/{project_id}', [App\Http\Controllers\TaskController::class, 'index'])->name('task');
                    Route::post('/save', [App\Http\Controllers\TaskController::class, 'save'])->name('task.save');
                    Route::post('/api/project-plan/task/request', [App\Http\Controllers\TaskAssignController::class, 'taskRequest'])->name('project.task.assign.request');
                    Route::get('/api/project-plan/task/plan-list', [App\Http\Controllers\TaskAssignController::class, 'taskPlanCategory'])->name('project.task.assign.plan.list');
                    Route::get('/api/project-plan/task/get-date', [App\Http\Controllers\TaskAssignController::class, 'taskPlanGetDate'])->name('task.assign.get.date');
                    Route::post('/delete', [App\Http\Controllers\TaskController::class, 'delete'])->name('task.delete');
                    Route::post('/update', [App\Http\Controllers\TaskController::class, 'update'])->name('task.update');
                    Route::post('/show', [App\Http\Controllers\TaskController::class, 'show'])->name('task.show');
                });
                Route::prefix('api')->group(function () {
                    Route::get('/fetchTask', [App\Http\Controllers\TaskController::class, 'getDataTask'])->name('task.datatables');
                    Route::post('/check-plan', [App\Http\Controllers\TaskController::class, 'checkPlan'])->name('task.planProject.select');
                });

                /*
            |--------------------------------------------------------------------------
            | Superadmin and HRD Routes
            |--------------------------------------------------------------------------
            |
            */
                Route::group(['roles' => ['hrd', 'superadmin', 'owner']], function () {
                    Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                        Route::get('/karyawan', [App\Http\Controllers\TaskController::class, 'getTaskKaryawan'])->name('task.karyawan');
                        Route::get('/detail-absensi/karyawan/{kry_id}', [App\Http\Controllers\AbsensiController::class, 'indexKaryawan'])->name('absensi.detail.karyawan');
                    });
                    Route::prefix('api')->group(function () {
                        Route::post('/api/detail/absensi/karyawan/detail-absen', [App\Http\Controllers\AbsensiController::class, 'showAbsenKaryawan'])->name('absen.showAbsenKaryawan');
                        Route::get('/api/detail/absensi/karyawan/stat', [App\Http\Controllers\AbsensiController::class, 'getDataAbsenStatKaryawan'])->name('absen.getDataAbsenStatKaryawan');
                        Route::get('/get-absensi-detail', [App\Http\Controllers\AbsensiController::class, 'getKaryawanAbsensi'])->name('absensi.api.karyawan');
                        Route::post('/unlock', [App\Http\Controllers\TaskController::class, 'unlockTask'])->name('task.unlockTask');
                        Route::get('/fetchTaskKaryawan/{id}', [App\Http\Controllers\TaskController::class, 'getDataTaskByKaryawan'])->name('task.karyawan.datatables');
                    });
                });

                Route::group(['roles' => ['hrd', 'superadmin']], function () {
                    Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {

                        Route::get('/izin-sakit/download/{file}', [App\Http\Controllers\IzinSakitController::class, 'download'])->name('izin.download');
                        Route::get('/izin-sakit/list', [App\Http\Controllers\IzinSakitController::class, 'izin_all'])->name('izin.data');
                        Route::get('/izin-sakit/create', [App\Http\Controllers\IzinSakitController::class, 'create'])->name('izin.create');
                        Route::post('/izin-sakit/update', [App\Http\Controllers\IzinSakitController::class, 'update'])->name('izin.update');
                        Route::post('/izin-sakit/save', [App\Http\Controllers\IzinSakitController::class, 'save'])->name('izin.save');
                        Route::get('/izin-sakit/approve', [App\Http\Controllers\IzinSakitController::class, 'approve'])->name('izin.approve');
                        Route::get('/izin-sakit/tolak', [App\Http\Controllers\IzinSakitController::class, 'tolak'])->name('izin.tolak');
                        Route::get('/izin-sakit/delete', [App\Http\Controllers\IzinSakitController::class, 'delete'])->name('izin.hapus');
                        Route::get('/izin-sakit/edit/{id}', [App\Http\Controllers\IzinSakitController::class, 'edit'])->name('izin.edit');
                        Route::post('/izin-sakit/get-data-all', [App\Http\Controllers\IzinSakitController::class, 'getIzinAll'])->name('izin.data.datatables');
                    });
                });
            });
            Route::group(['roles' => ['hrd', 'superadmin', 'employee']], function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::get('/izin-sakit', [App\Http\Controllers\IzinSakitController::class, 'index'])->name('izin');
                    Route::get('/izin-sakit/request', [App\Http\Controllers\IzinSakitController::class, 'request'])->name('izin.request');
                    Route::get('/izin-sakit/request/edit/{id}', [App\Http\Controllers\IzinSakitController::class, 'editSelf'])->name('izin.editSelf');
                    Route::get('/izin-sakit/cancel', [App\Http\Controllers\IzinSakitController::class, 'cancel_req'])->name('izin.cancel_req');
                    Route::post('/izin-sakit/request/edit-act', [App\Http\Controllers\IzinSakitController::class, 'update_req'])->name('izin.edit_act');
                    Route::post('/izin-sakit/send-request', [App\Http\Controllers\IzinSakitController::class, 'submit_request'])->name('izin.submit_request');
                    Route::post('/izin-sakit/get-data-self', [App\Http\Controllers\IzinSakitController::class, 'getIzinSelf'])->name('izin.datatables');
                });
            });
            /*
        |--------------------------------------------------------------------------
        | Absensi Routes
        |--------------------------------------------------------------------------
        |
        */
            Route::prefix('absen')->group(function () {
                Route::get('cek_lokasi', [App\Http\Controllers\AbsensiController::class, 'cek_lokasi'])->name('absen.cek_lokasi');
                Route::post('doAbsen', [App\Http\Controllers\AbsensiController::class, 'doAbsen'])->name('absen.doAbsen');
                Route::group(['roles' => ['hrd', 'superadmin', 'owner']], function () {
                    Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                        Route::post('export', [App\Http\Controllers\AbsensiController::class, 'export'])->name('absen.export');
                        Route::get('/', [App\Http\Controllers\AbsensiController::class, 'index'])->name('absen');
                    });
                    Route::prefix('api')->group(function () {
                        Route::get('/fetchAbsen', [App\Http\Controllers\AbsensiController::class, 'getDataAbsen'])->name('absen.datatables');
                        Route::post('/absen', [App\Http\Controllers\AbsensiController::class, 'showAbsen'])->name('absen.showAbsen');
                        Route::post('/absen/register', [App\Http\Controllers\AbsensiController::class, 'create'])->name('absen.register');
                        Route::post('/getDataAbsensiStat', [App\Http\Controllers\AbsensiController::class, 'absenStat'])->name('absen.getDataAbsensiStat');
                    });
                });
            });

            Route::group(['roles' => ['hrd', 'superadmin', 'owner']], function () {
                /*
            |--------------------------------------------------------------------------
            | Karyawan Routes
            |--------------------------------------------------------------------------
            |
            */
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::prefix('karyawan')->group(function () {
                        Route::get('create', [App\Http\Controllers\KaryawanController::class, 'create'])->name('karyawan.create');

                        Route::get('curriculum_vitae/{cv}', [App\Http\Controllers\KaryawanController::class, 'downloadCV'])->name('karyawan.cv');
                        Route::get('edit/{id}', [App\Http\Controllers\KaryawanController::class, 'edit'])->name('karyawan.edit');
                        Route::post('save', [App\Http\Controllers\KaryawanController::class, 'save'])->name('karyawan.save');
                        Route::post('update', [App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');
                        Route::post('delete', [App\Http\Controllers\KaryawanController::class, 'delete'])->name('karyawan.hapus');
                        Route::get('/', [App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan');
                    });
                    // Route::prefix('penggajian')->group(function () {
                    //     Route::get('create', [App\Http\Controllers\KaryawanController::class, 'create'])->name('penggajian.create');

                    //     Route::get('curriculum_vitae/{cv}', [App\Http\Controllers\PenggajianController::class, 'downloadCV'])->name('penggajian.cv');
                    //     Route::get('edit/{id}', [App\Http\Controllers\PenggajianController::class, 'edit'])->name('penggajian.edit');
                    //     Route::get('detail/{id}/{periode}', [App\Http\Controllers\PenggajianController::class, 'detail'])->name('penggajian.detail');
                    //     Route::post('save', [App\Http\Controllers\PenggajianController::class, 'save'])->name('penggajian.save');
                    //     Route::post('update', [App\Http\Controllers\PenggajianController::class, 'update'])->name('penggajian.update');
                    //     Route::post('delete', [App\Http\Controllers\PenggajianController::class, 'delete'])->name('penggajian.hapus');
                    //     Route::get('/', [App\Http\Controllers\PenggajianController::class, 'index'])->name('penggajian');
                    // });
                });
                Route::prefix('api')->group(function () {
                    Route::get('/fetchKaryawan', [App\Http\Controllers\KaryawanController::class, 'getDataKaryawan'])->name('karyawan.datatables');
                    Route::get('/fetchPenggajian', [App\Http\Controllers\PenggajianController::class, 'getDataPenggajian'])->name('penggajian.datatables');

                    Route::get('/fetchSelectKaryawan', [App\Http\Controllers\KaryawanController::class, 'getKaryawanSelect'])->name('karyawan.getSelectKaryawan');
                });
            });

            /*
        |--------------------------------------------------------------------------
        | Super Admin Routes
        |--------------------------------------------------------------------------
        |
        */
            
            Route::group(['roles' => ['superadmin','owner','hrd']], function () {
                Route::prefix('absen_diluar')->group(function () {
                    // Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                        Route::get('/', [App\Http\Controllers\AbsenDiluarController::class, 'index'])->name('absen_diluar');
                        Route::get('/{status}/{id}', [App\Http\Controllers\AbsenDiluarController::class, 'status'])->name('absen_diluar.status');
                    // });
                });

                Route::prefix('penggajian')->group(function () {
                    // Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                        Route::get('/', [App\Http\Controllers\PenggajianController::class, 'index'])->name('penggajian');
                        Route::get('/edit/{id}', [App\Http\Controllers\PenggajianController::class, 'edit'])->name('penggajian.edit');
                        Route::get('/detail/{id}', [App\Http\Controllers\PenggajianController::class, 'detail'])->name('penggajian.detail');
                        Route::get('/delete/{id}', [App\Http\Controllers\PenggajianController::class, 'delete'])->name('penggajian.delete');
                        Route::get('/slip_gaji/{id}', [App\Http\Controllers\PenggajianController::class, 'slip_gaji'])->name('penggajian.slip_gaji');
                        Route::post('/save', [App\Http\Controllers\PenggajianController::class, 'save'])->name('penggajian.save');
                        Route::post('/pengajuan', [App\Http\Controllers\PenggajianController::class, 'pengajuan'])->name('penggajian.save');
                        Route::post('/update', [App\Http\Controllers\PenggajianController::class, 'update'])->name('penggajian.update');
                        Route::post('/disable', [App\Http\Controllers\PenggajianController::class, 'disable'])->name('penggajian.disable');
                        Route::post('/enable', [App\Http\Controllers\PenggajianController::class, 'enable'])->name('penggajian.enable');

                        Route::post('/show', [App\Http\Controllers\PenggajianController::class, 'show'])->name('penggajian.show');
                    // });
                    Route::prefix('api')->group(function () {
                        Route::get('/fetchPenggajian', [App\Http\Controllers\PenggajianController::class, 'getDataPenggajian'])->name('penggajian.datatables');
                    });
                });
            });


            Route::group(['roles' => ['superadmin']], function () {
                Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                    Route::post('absensi-services/acc-absen-keluar', [App\Http\Controllers\AbsensiController::class, 'acc_absen_keluar'])->name('services.notif.accAbsen');
                    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');
                    Route::get('system/system-update', [App\Http\Controllers\SystemUpdateController::class, 'index'])->name('system.update');
                });
                Route::group(['middleware' => ['Tracking']], function () {
                    Route::get('appmon', [App\Http\Controllers\MonitoringAppController::class, 'index'])->name('appmon');
                });
                /*
            |--------------------------------------------------------------------------
            | User Routes
            |--------------------------------------------------------------------------
            |
            */
                Route::prefix('pengguna')->group(function () {
                    Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                        Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('pengguna.create');
                        Route::get('edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('pengguna.edit');
                        Route::post('save', [App\Http\Controllers\UserController::class, 'save'])->name('pengguna.save');
                        Route::post('update', [App\Http\Controllers\UserController::class, 'update'])->name('pengguna.update');
                        Route::post('disable', [App\Http\Controllers\UserController::class, 'disable'])->name('pengguna.disable');
                        Route::post('enable', [App\Http\Controllers\UserController::class, 'enable'])->name('pengguna.enable');
                        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('pengguna');
                    });
                    Route::prefix('api')->group(function () {
                        Route::get('/fetchPengguna', [App\Http\Controllers\UserController::class, 'getDataPengguna'])->name('pengguna.datatables');
                        Route::get('/fetchRoles', [App\Http\Controllers\UserController::class, 'getRolesSelect'])->name('pengguna.getSelectRoles');
                        Route::get('/selectUser', [App\Http\Controllers\UserController::class, 'selectUser'])->name('pengguna.select');
                    });
                    /*
                |--------------------------------------------------------------------------
                | Guest Account Routes
                |--------------------------------------------------------------------------
                |
                */
                    Route::prefix('guest')->group(function () {
                        Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                            Route::get('/', [App\Http\Controllers\GuestController::class, 'index'])->name('guest');
                            Route::post('/save', [App\Http\Controllers\GuestController::class, 'save'])->name('guest.save');
                            Route::post('/update', [App\Http\Controllers\GuestController::class, 'update'])->name('guest.update');
                            Route::post('/disable', [App\Http\Controllers\GuestController::class, 'disable'])->name('guest.disable');
                            Route::post('/enable', [App\Http\Controllers\GuestController::class, 'enable'])->name('guest.enable');

                            Route::post('/show', [App\Http\Controllers\GuestController::class, 'show'])->name('guest.show');
                        });
                        Route::prefix('api')->group(function () {
                            Route::get('/fetchGuest', [App\Http\Controllers\GuestController::class, 'getDataGuest'])->name('guest.datatables');
                        });
                        /*
                    |--------------------------------------------------------------------------
                    | Linked Project Guest Account Routes
                    |--------------------------------------------------------------------------
                    |
                    */
                        Route::prefix('linkedProject')->group(function () {
                            Route::post('/save', [App\Http\Controllers\LinkedProjectController::class, 'save'])->name('linkedProject.save');
                            Route::post('/delete', [App\Http\Controllers\LinkedProjectController::class, 'delete'])->name('linkedProject.delete');
                            Route::prefix('api')->group(function () {
                                Route::get('/fetchproject', [App\Http\Controllers\LinkedProjectController::class, 'getDataLinkedProject'])->name('linkedProject.datatables');
                            });
                        });
                    });
                    
                });
                /*
            |--------------------------------------------------------------------------
            | System Config Routes
            |--------------------------------------------------------------------------
            |
            */
                Route::prefix('system')->group(function () {
                    Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {

                        Route::get('config/roles', [App\Http\Controllers\RolesPermissionControler::class, 'index'])->name('config.roles');
                        Route::get('config/roles/add', [App\Http\Controllers\RolesPermissionControler::class, 'index'])->name('config.roles.add');


                        Route::get('config/url-mapping', [App\Http\Controllers\UrlMappingController::class, 'index'])->name('config.url.mapping');
                        Route::get('config/url-mapping/add', [App\Http\Controllers\UrlMappingController::class, 'addMapping'])->name('config.url.mapping.create');
                        Route::get('config/url-mapping/edit/{id}', [App\Http\Controllers\UrlMappingController::class, 'editMapping'])->name('config.url.mapping.edit');
                        Route::get('config/url-mapping/delete/{id}', [App\Http\Controllers\UrlMappingController::class, 'deleteMapping'])->name('config.url.mapping.delete');
                        Route::post('config/url-mapping/update', [App\Http\Controllers\UrlMappingController::class, 'updateMapping'])->name('config.url.mapping.update');
                        Route::post('config/url-mapping/save', [App\Http\Controllers\UrlMappingController::class, 'saveMapping'])->name('config.url.mapping.save');
                        Route::get('config/absensi', [App\Http\Controllers\SystemConfigController::class, 'absensi'])->name('config.absensi');
                        Route::get('config/penggajian', [App\Http\Controllers\SystemConfigController::class, 'penggajian'])->name('config.penggajian');
                        Route::get('config/pulang', [App\Http\Controllers\SystemConfigController::class, 'pulang'])->name('config.pulang');
                        Route::get('config/sys-config', [App\Http\Controllers\SystemConfigController::class, 'system_setting'])->name('config.sys');
                        Route::post('config/sys-config/save', [App\Http\Controllers\SystemConfigController::class, 'system_setting_save'])->name('config.sys.save');
                        Route::post('config/absensi/save', [App\Http\Controllers\SystemConfigController::class, 'absensiSave'])->name('config.absensi.save');
                        Route::post('config/penggajian/save', [App\Http\Controllers\SystemConfigController::class, 'penggajianSave'])->name('config.penggajian.save');
                        Route::post('config/pulang/save', [App\Http\Controllers\SystemConfigController::class, 'pulangSave'])->name('config.pulang.save');
                    });
                });
                /*
            |--------------------------------------------------------------------------
            | Project Routes
            |--------------------------------------------------------------------------
            |
            */
                Route::prefix('project')->group(function () {

                    Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                        Route::get('/', [App\Http\Controllers\ProjectController::class, 'index'])->name('project');
                        Route::get('/create', [App\Http\Controllers\ProjectController::class, 'create'])->name('project.create');
                        Route::post('/save', [App\Http\Controllers\ProjectController::class, 'save'])->name('project.save');
                        Route::post('/update', [App\Http\Controllers\ProjectController::class, 'update'])->name('project.update');
                        Route::post('/delete', [App\Http\Controllers\ProjectController::class, 'delete'])->name('project.delete');
                        Route::post('/show', [App\Http\Controllers\ProjectController::class, 'show'])->name('project.show');

                        Route::prefix('member')->group(function () {
                            Route::post('/add', [App\Http\Controllers\ProjectController::class, 'member_save'])->name('project.member.save');
                            Route::post('/delete', [App\Http\Controllers\ProjectController::class, 'member_delete'])->name('project.member.delete');
                            Route::post('/set-pm', [App\Http\Controllers\ProjectController::class, 'set_pm'])->name('project.member.setPM');
                        });
                    });
                    Route::prefix('api')->group(function () {
                        Route::get('/karyawan/get', [App\Http\Controllers\ProjectController::class, 'karyawan_get'])->name('project.karyawan.get');
                        Route::get('/fetchProjects', [App\Http\Controllers\ProjectController::class, 'getDataProject'])->name('project.datatables');
                        Route::get('/fetchProjectMembers', [App\Http\Controllers\ProjectController::class, 'getDataProjectMember'])->name('project.member.datatables');
                    });
                });
            });
            /*
        |--------------------------------------------------------------------------
        | General Routes
        |--------------------------------------------------------------------------
        |
        */
            // Cuti
            Route::prefix("cuti")->group(function () {
                Route::get('/', [App\Http\Controllers\CutiController::class, 'index'])->name("cuti");
                Route::group(['middleware' => ['Tracking']], function () {
                    Route::get('/request', [App\Http\Controllers\CutiController::class, 'create'])->name("cuti.create");
                    Route::get('/create', [App\Http\Controllers\CutiController::class, 'input'])->name("cuti.input");
                    Route::post('/export', [App\Http\Controllers\CutiController::class, 'export'])->name("cuti.export");
                    Route::post('/save', [App\Http\Controllers\CutiController::class, 'save'])->name("cuti.save");
                    Route::post('/delete', [App\Http\Controllers\CutiController::class, 'delete'])->name("cuti.delete");
                    Route::get('/edit/{id}', [App\Http\Controllers\CutiController::class, 'edit'])->name("cuti.edit");
                    Route::post('/update', [App\Http\Controllers\CutiController::class, 'update'])->name("cuti.update");
                    Route::post('/request/{id}/approve', [App\Http\Controllers\CutiController::class, 'approve'])->name("cuti.approve");
                });
                Route::post('/request/{id}/reject', [App\Http\Controllers\CutiController::class, 'disapprove'])->name("cuti.disapprove");
                Route::post('/request/submit', [App\Http\Controllers\CutiController::class, 'store'])->name("cuti.store");
            });
            Route::group(['middleware' => ['Tracking']], function () {
                Route::get('/security/password', [App\Http\Controllers\UserController::class, 'myAccountPassword'])->name('password');
            });
            Route::group(['middleware' => ['Tracking', 'RequireAbsen']], function () {
                Route::prefix('project-list')->group(function () {
                    Route::get('/', [App\Http\Controllers\TaskProjectMember::class, 'project'])->name('task.project.list');
                });
                Route::prefix('project-monitoring')->group(function () {
                    Route::get('/', [App\Http\Controllers\ProjectMonitoring::class, 'index'])->name('project.monitoring');

                    Route::group(['middleware' => ['CheckPM']], function () {
                        Route::get('/plan/{project_id}', [App\Http\Controllers\ProjectMonitoring::class, 'detail_plan'])->name('project.monitoring.plan');
                        Route::get('/plan/task-detail/{project_id}/{plan_id}', [App\Http\Controllers\ProjectMonitoring::class, 'taskDev'])->name('project.plan.tasks');
                        Route::get('/plan/detail/{project_id}/{plan_id}', [App\Http\Controllers\ProjectMonitoring::class, 'detail_plan_view'])->name('project.plan.detail.view');

                        Route::get('/plan/{project_id}', [App\Http\Controllers\ProjectMonitoring::class, 'detail_plan'])->name('project.monitoring.plan');
                        Route::get('/task-detail/{project_id}/{plan_id}', [App\Http\Controllers\ProjectMonitoring::class, 'taskDev'])->name('project.plan.tasks');
                        Route::post('task/project/{project_id}/unlock', [App\Http\Controllers\TaskController::class, 'unlockTask'])->name('task.project.unlockTask');
                    });

                    Route::get('api/project/selectUser', [App\Http\Controllers\ProjectMonitoring::class, 'selectUser'])->name('project.pengguna.select');
                    Route::post('/api/member/log-detail', [App\Http\Controllers\TaskAssignMemberController::class, 'detailLog'])->name('project.member.log_detail');
                    Route::post('/api/project-plan/task/save', [App\Http\Controllers\TaskAssignController::class, 'save'])->name('project.task.assign.save');
                    Route::post('/api/project-plan/task/update', [App\Http\Controllers\TaskAssignController::class, 'update'])->name('task.pm.update');
                    Route::post('/api/project-plan/task/unlink-member', [App\Http\Controllers\TaskAssignMemberController::class, 'delete'])->name('project.task.member.delete');
                    Route::post('/api/project-plan/task-member/save', [App\Http\Controllers\TaskAssignMemberController::class, 'save'])->name('project.task.member.save');
                    Route::post('/api/project-plan/task-member/add-member', [App\Http\Controllers\TaskAssignMemberController::class, 'save'])->name('project.task.member.add.member');


                    Route::post('/api/project-plan/detail/show', [App\Http\Controllers\ProjectMonitoring::class, 'planShow'])->name('project.plandetail.show');
                    Route::post('/api/project-plan', [App\Http\Controllers\ProjectMonitoring::class, 'getDataPlan'])->name('project.plan.datatables');
                    Route::post('/api/project-plan-detail', [App\Http\Controllers\ProjectMonitoring::class, 'getDataPlanDetail'])->name('project.plan.detail.datatables');
                    Route::post('/api/project-plan/add', [App\Http\Controllers\ProjectMonitoring::class, 'add_plan'])->name('project.plan.add');
                    Route::post('/api/project-plan/add-detail', [App\Http\Controllers\ProjectMonitoring::class, 'add_plan_detail'])->name('project.plan.add.detail');
                    Route::post('/api/project-plan/edit', [App\Http\Controllers\ProjectMonitoring::class, 'edit_plan'])->name('project.plan.edit');
                    Route::post('/api/project-plan/edit-detail', [App\Http\Controllers\ProjectMonitoring::class, 'edit_plan_detail'])->name('project.plan.edit.detail');
                    Route::post('/api/project-plan/delete', [App\Http\Controllers\ProjectMonitoring::class, 'delete_plan'])->name('project.plan.delete');
                    Route::post('/api/project-plan/delete-detail', [App\Http\Controllers\ProjectMonitoring::class, 'delete_plan_detail'])->name('project.plan.delete.detail');
                    Route::get('/api/project-plan/selectData', [App\Http\Controllers\ProjectMonitoring::class, 'getDataSelect'])->name('project.plan.select');
                    Route::post('/api/project-plan/show', [App\Http\Controllers\ProjectMonitoring::class, 'show'])->name('project.plan.show');
                    Route::post('/api/project-plan/show-detail', [App\Http\Controllers\ProjectMonitoring::class, 'showDetailPlan'])->name('project.plan.showDetailPlan');
                    Route::get('/show-project-task/{id}', [App\Http\Controllers\ProjectMonitoring::class, 'show_project'])->name('project.monitoring.details');
                });

                Route::post('/security/password/update', [App\Http\Controllers\UserController::class, 'myAccountPasswordUpdate'])->name('password.update');
            });
            Route::prefix('project-monitoring')->group(function () {
                Route::get('/api/project-plan/task-member/getData', [App\Http\Controllers\TaskAssignMemberController::class, 'datatables'])->name('project.task.member.datatables');
                Route::post('/api/project-plan/task-member/view-log.py', [App\Http\Controllers\TaskAssignMemberController::class, 'datatables_log'])->name('project.task.member.datatables_log');
            });
            Route::group(['middleware' => ['CheckPM']], function () {
                Route::get('api/task-list/{project_id}/{plan_id}', [App\Http\Controllers\ProjectMonitoring::class, 'getDataTaskDev'])->name('project.plan.tasks.dataTables');
            });
            Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



            Route::get('/absensi/images/{file}', [App\Http\Controllers\ImageController::class, 'showAbsen'])->name('showFoto');
            Route::get('/absensi/images/pulang/{file}', [App\Http\Controllers\ImageController::class, 'showAbsenPulang'])->name('showFotoPulang');
            Route::get('/karyawan/images/{file}', [App\Http\Controllers\ImageController::class, 'showKaryawan'])->name('showFotoKaryawan');
        });
        Route::get('/setnewpassword', [App\Http\Controllers\UserController::class, 'setnewpassword'])->name('password.new');
        Route::post('/security/account/active', [App\Http\Controllers\UserController::class, 'activateAccount'])->name('password.active');
    });
});
