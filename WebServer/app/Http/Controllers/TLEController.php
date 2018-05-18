<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TLE;
use Auth;
class TLEController extends Controller
{
	public function showtle()
	{
		if(Auth::check()){

			$listTLE = TLE::get();
			return view('Project.tle')->with('listTLE',$listTLE);
		}else{
			return redirect('/login');
		}
	}
	public function addTLE(Request $request)
	{

		$findnametle = Tle::where('name',$request->name)->first();

		if( !(is_null($findnametle)) ){
            return redirect()->back()->with('status', '** มีดาวเทียมด้วนนี้แล้ว **')->withInput();
        }
		$store = new TLE;
		$store->name = $request->input('name');
		$store->line1 =	$request->input('line1');
		$store->line2 = $request->input('line2');
		$store->save();
		return redirect('/tle')->with('status2', '** เพิ่มดาวเทียมสำเร็จ **');
	}
	public function updateTLE(Request $request)
	{
		$update = Tle::where('_id',$request->id)->first();
		
		$update->name = $request->input('name');
		$update->line1 =$request->input('line1');
		$update->line2 = $request->input('line2');
		$update->save();
		
		 return response()->json($request);
	}
	public function deleteTle(Request $request)
    {
        
        $data = Tle::find($request->id);
        // dd($data);
        $data->delete();
       
        return redirect()->back();
    }
}
