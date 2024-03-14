<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Alfa6661\AutoNumber\AutoNumberTrait;


class TicketingMaintenance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AutoNumberTrait;
    protected $fillable = ['no_ticket','feedback','project_id','guest_id','target_ticketing','title','kronologi','screenshot','status','updated_by','alamat_situs','is_read_notif','is_read_toast',
        'target_user'];
    protected $table = 'ticketing_maintenance';

    public function getAutoNumberOptions()
    {
        return [
            'no_ticket' => [
                'format' => 'MT'.date('Ym').'?', // MT20210500001
                'length' => 6
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function user_target()
    {
        return $this->belongsTo(User::class,'target_user');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }

    public function ticketing_target()
    {
        return $this->belongsTo(TargetTicketingDivision::class,'target_ticketing');
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class,'guest_id');
    }
}
