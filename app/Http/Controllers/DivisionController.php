<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetTicketingDivision;
use App\Http\Resources\DivisionSelect;

class DivisionController extends Controller
{
  public function getSelect(Request $request)
  {
      $data = DivisionSelect::collection(TargetTicketingDivision::where('name','like','%'.$request->search.'%')->limit(10)->get());

      return response()->json($data);
  }
}
