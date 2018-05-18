<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TLE;
class PositionController extends Controller
{
    public function position()
    {
         $listTLE = TLE::get();
         $tleFrist =TLE::first();
        // dd($tleFrist);
        return view('Project.position')->with('listTLE',$listTLE)->with('tleFrist',$tleFrist);
    }
    public function positionSelect(Request $request)
    {
    
         $listTLE = TLE::get();

        $tleFrist = TLE::where('_id',$request->id)->first();
         //dd($tleFrist);

        return view('Project.position')->with('listTLE',$listTLE)->with('tleFrist',$tleFrist);
    }
}
