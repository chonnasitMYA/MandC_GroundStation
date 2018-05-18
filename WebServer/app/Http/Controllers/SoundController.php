<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\TLE;
use App\Sound;
use Auth;
class SoundController extends Controller
{
    //
	public function SoundArchive()
	{
		$listSound = Sound::orderBy('Date', 'desc')->get();
		$listTLE = TLE::get();	
		
		$data = ['All','All',date("Y/m/d"),date("Y/m/d")];
		/*dd($listSound);*/

		return view('Project.SoundArchive')->with('listSound',$listSound)->with('listTLE',$listTLE)->with('data',$data);
	}
	public function AddSound(Request $request)
	{

		if($request->hasFile('Sound')){
			$store = new Sound;
			$store->SatelliteName = $request->SatelliteName;
			$store->TimeAcquired = $request->TimeAcquired;
			$store->DateAcquired = $request->DateAcquired;

			$s=($request->DateAcquired).(' ').$request->TimeAcquired.(':00');
			$date = date_create_from_format('d/m/Y H:i:s', $s);	 //31-12-2018 

			//$store->Date = $date;
			$store->Date = $date->format('Y-m-d H:i:s');
			/*------------------save Sound to server---------------------*/
			$sound = $request->file('Sound');
			$fileName = $request->SatelliteName.'_'.uniqid().'.'.$request->file('Sound')->getClientOriginalExtension();

			$path =  'sound/'.$request->SatelliteName;
			$sound->move($path, $fileName);
			/*-----------------------------------------------------------*/
			$store->path=$path.'/'.$fileName;
			/*	dd($store);*/
			$store->save();





		}

// 		$listSound = Sound::orderBy('Date', 'desc')->get();
// 		$listTLE = TLE::get();	
// 		$data = ['All','All',date("Y/m/d"),date("Y/m/d")];
// ;
// 		return view('Project.SoundArchive')->with('listSound',$listSound)->with('listTLE',$listTLE)->with('data',$data);
		return redirect()->back();
	}

	public function findSound(Request $request)
	{
	
		/*Session::put('selectSatellite',$request->input('SatelliteName'));*/
		$StartDate = date_create_from_format('d/m/Y H:i:s', ($request->StartDate).' 00:00:00');
        $EndDate = date_create_from_format('d/m/Y H:i:s', ($request->EndDate).' 23:59:00');  
		$listTLE = TLE::get();


		if($request->SatelliteName == 'All')
		{
			if($request->Durations == 'All')
			{
				$listSound = Sound::orderBy('Date', 'desc')->orderBy('Date', 'desc')->get();

			}else
			{
				$listSound = Sound::whereBetween('Date',[ $StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->get();


			}
		}else if($request->SatelliteName != 'All')
		{
			if($request->Durations == 'All')
			{
				$listSound = Sound::where('SatelliteName',$request->SatelliteName)->orderBy('Date', 'desc')->get();
				

			}else if($request->Durations != 'All')
			{
				$listSound = Sound::where('SatelliteName',$request->SatelliteName)->whereBetween('Date', [ $StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->orderBy('Date', 'desc')->get();

			}
		}


		$data = [$request->SatelliteName ,$request->Durations ,$request->StartDate ,$request->EndDate];
		
		
		
		return view('Project.SoundArchive')->with('listSound',$listSound)->with('listTLE',$listTLE)
		->with('data',$data);
	}

	public function listsound()
	{
		if(Auth::check()){
			$listSound = Sound::orderBy('Date', 'desc')->get();
			$listTLE = TLE::get();	
			
			$data = ['All','All',date("Y/m/d"),date("Y/m/d")];
			// dd($listSound);

			return view('Project.listsound')->with('listSound',$listSound)->with('listTLE',$listTLE)->with('data',$data);
		}else{
			return redirect('/login');
		}
	}
	public function deletesound(Request $request)
	{
		 //dd($request);
		$data = Sound::find($request->id);
		$filepath=$data->path;
		// dd($filepath);
		unlink($filepath);
		$data->delete();
		//dd($data);
		return redirect()->back();
		
	}
	public function listfindSound(Request $request)
	{
	
		/*Session::put('selectSatellite',$request->input('SatelliteName'));*/
		$StartDate = date_create_from_format('d/m/Y H:i:s', ($request->StartDate).' 00:00:00');
        $EndDate = date_create_from_format('d/m/Y H:i:s', ($request->EndDate).' 23:59:00');  
		$listTLE = TLE::get();


		if($request->SatelliteName == 'All')
		{
			if($request->Durations == 'All')
			{
				$listSound = Sound::orderBy('Date', 'desc')->orderBy('Date', 'desc')->get();

			}else
			{
				$listSound = Sound::whereBetween('Date',[ $StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->get();


			}
		}else if($request->SatelliteName != 'All')
		{
			if($request->Durations == 'All')
			{
				$listSound = Sound::where('SatelliteName',$request->SatelliteName)->orderBy('Date', 'desc')->get();
				

			}else if($request->Durations != 'All')
			{
				$listSound = Sound::where('SatelliteName',$request->SatelliteName)->whereBetween('Date', [ $StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->orderBy('Date', 'desc')->get();

			}
		}


		$data = [$request->SatelliteName ,$request->Durations ,$request->StartDate ,$request->EndDate];
		
		
		
		return view('Project.listsound')->with('listSound',$listSound)->with('listTLE',$listTLE)
		->with('data',$data);
	}

}
