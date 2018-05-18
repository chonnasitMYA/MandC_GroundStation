<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\TLE;
use Session;
use DateTime;
use Auth;
class PhotoController extends Controller
{
	public function AddPhoto(Request $request){ 
		if($request->hasFile('photo')){
			// dd($request);
			$store = new Photo;
			$store->SatelliteName = $request->SatelliteName;
			$store->Enhancement =	$request->Enhancement;
			$store->TimeAcquired = $request->TimeAcquired;
			$store->DateAcquired =  $request->DateAcquired; 
			$s=($request->DateAcquired).(' ').$request->TimeAcquired.(':00');
			$date = date_create_from_format('d/m/Y H:i:s', $s);	 //31-12-2018 
			// dd($request->DateAcquired);
			// $Date =  DateTime::createFromFormat('m/d/Y , H:i:s A', $timestart);//ตามformat
			$store->Date = $date->format('Y-m-d H:i:s');

			/*------------------save Photo to server---------------------*/
			$photo = $request->file('photo');
			$fileName = $request->SatelliteName.'_'.uniqid().'.'.$request->file('photo')->getClientOriginalExtension();

			$path =  'photo/'.$request->SatelliteName;
			$photo->move($path, $fileName);
			/*-----------------------------------------------------------*/
			$store->path=$path.'/'.$fileName;
			/*	dd($store);*/
			$store->save();
			
		}
		

		return redirect()->back();
		
	}
	public function PhotoGallery()
	{
		$listPhoto = Photo::orderBy('Date', 'desc')->get();
		$listTLE = TLE::get();	
		// dd($listPhoto);
		$data = ['All','All',date("Y/m/d"),date("Y/m/d")];
		
		return view('Project.PhotoGallery')->with('listPhoto',$listPhoto)->with('listTLE',$listTLE)->with('data',$data);
	}
	public function findPhoto(Request $request)
	{
		/*Session::put('selectSatellite',$request->input('SatelliteName'));*/


		$listTLE = TLE::get();
		
		// $listPhoto = Photo::whereBetween('Date',[$StartDate,$EndDate])->get();
		// dd($listPhoto);
		$StartDate = date_create_from_format('d/m/Y H:i:s', ($request->StartDate).' 00:00:00');
        $EndDate = date_create_from_format('d/m/Y H:i:s', ($request->EndDate).' 23:59:00'); 
        $StartDate=  DateTime::createFromFormat('d/m/Y H:i:s', ($request->StartDate).' 00:00:00');
      
        // dd($cc);
      
		if($request->SatelliteName == 'All')
		{
			if($request->Durations == 'All')
			{
				$listPhoto = Photo::orderBy('Date', 'desc')->orderBy('Date', 'desc')->get();

			}else
			{
				$listPhoto = Photo::whereBetween('Date',[ $StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->get();


			}
			// dd($listPhoto);
		}else if($request->SatelliteName != 'All')
		{
			if($request->Durations == 'All')
			{
				$listPhoto = Photo::where('SatelliteName',$request->SatelliteName)->orderBy('Date', 'desc')->get();
				

			}else if($request->Durations != 'All')
			{
				$listPhoto = Photo::where('SatelliteName',$request->SatelliteName)->whereBetween('Date', [$StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->orderBy('Date', 'desc')->get();

			}
		}
		


		$data = [$request->SatelliteName ,$request->Durations ,$request->StartDate ,$request->EndDate];
		
		
		
		return view('Project.PhotoGallery')->with('listPhoto',$listPhoto)->with('listTLE',$listTLE)->with('data',$data);
	}
	public function listphoto()
	{
		if(Auth::check()){
			$listPhoto = Photo::orderBy('Date', 'desc')->get();
			$listTLE = TLE::get();	
			//dd($listPhoto);
			$data = ['All','All',date("Y/m/d"),date("Y/m/d")];
			
			return view('Project.listphoto')->with('listPhoto',$listPhoto)->with('listTLE',$listTLE)->with('data',$data);
		}else{
			return redirect('/login');
		}
	}
	public function listfindPhoto(Request $request)
	{
		/*Session::put('selectSatellite',$request->input('SatelliteName'));*/


		$listTLE = TLE::get();
		
		// $listPhoto = Photo::whereBetween('Date',[$StartDate,$EndDate])->get();
		// dd($listPhoto);
		$StartDate = date_create_from_format('d/m/Y H:i:s', ($request->StartDate).' 00:00:00');
        $EndDate = date_create_from_format('d/m/Y H:i:s', ($request->EndDate).' 23:59:00'); 
        $StartDate=  DateTime::createFromFormat('d/m/Y H:i:s', ($request->StartDate).' 00:00:00');
      
        // dd($cc);
      
		if($request->SatelliteName == 'All')
		{
			if($request->Durations == 'All')
			{
				$listPhoto = Photo::orderBy('Date', 'desc')->orderBy('Date', 'desc')->get();

			}else
			{
				$listPhoto = Photo::whereBetween('Date',[ $StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->get();


			}
			// dd($listPhoto);
		}else if($request->SatelliteName != 'All')
		{
			if($request->Durations == 'All')
			{
				$listPhoto = Photo::where('SatelliteName',$request->SatelliteName)->orderBy('Date', 'desc')->get();
				

			}else if($request->Durations != 'All')
			{
				$listPhoto = Photo::where('SatelliteName',$request->SatelliteName)->whereBetween('Date', [$StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->orderBy('Date', 'desc')->get();

			}
		}
		


		$data = [$request->SatelliteName ,$request->Durations ,$request->StartDate ,$request->EndDate];
		
		
		
		return view('Project.listphoto')->with('listPhoto',$listPhoto)->with('listTLE',$listTLE)->with('data',$data);
	}

	public function deletephoto(Request $request)
	{
		// dd($request);
		$data = Photo::find($request->id);
		$filepath=$data->path;
		//dd($filepath);
		unlink($filepath);
		$data->delete();
		//dd($data);
		return redirect()->back();
		
	}
}
