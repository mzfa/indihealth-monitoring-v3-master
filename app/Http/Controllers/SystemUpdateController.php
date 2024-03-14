<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetTicketingDivision;
use App\Http\Resources\DivisionSelect;

class SystemUpdateController extends Controller
{
  public function index(Request $request)
  {
    return view('system_update.index');
  }
}
