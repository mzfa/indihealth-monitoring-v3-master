<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetTicketingDivision extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable =['name','keterangan'];
    protected $table ='target_ticketing_divisions';
}
