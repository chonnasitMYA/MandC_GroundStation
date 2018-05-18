<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TLE;
use Auth;
use App\control;
use App\ControlTime;
use App\configAZEL;
use DateTime;
class AntennaController extends Controller
{
    public function control()
    {
        if(Auth::check()){

            $now = new  DateTime();
            $timestamp =  date_format($now, 'U');
            $formatted_date = $now->format('Y-m-d h:i:s A');
            // dd( ($timestamp));
            $listTLE = TLE::get();
            $listControl = control::where('status','N')->orderBy('timestamp', 'asc') -> where('timestamp', '>',$timestamp)->get();
            // dd($listControl);
            // dd( $listControlNext);
            $deletelist = ControlTime::get();

            for ($i = 0 ; $i < sizeof($deletelist); $i++){
                $data = ControlTime::find($deletelist[$i]->id);
                $data->delete();
            }
             $now = new  DateTime();
            $timestamp =  date_format($now, 'U');
           // $formatted_date = $now->format('Y-m-d h:i:s A');
            $listControlNext=control::where('status','N') -> where('timestamp', '>',$timestamp)->orderBy('timestamp', 'asc')->get();
              // dd($listControlNext);
            for ($i = 0 ; $i < sizeof($listControlNext); $i++){
                $store = new ControlTime;
                $store->idControl=$listControlNext[$i]->_id;
                $store->namesatellite=$listControlNext[$i]->namesatellite;
                $store->status=$listControlNext[$i]->status;
                $store->timestart=$listControlNext[$i]->timestart;
                $store->timestop=$listControlNext[$i]->timestop;
                $store->timestamp=$listControlNext[$i]->timestamp;
                $store->Date=$listControlNext[$i]->Date;
                $store->control=$listControlNext[$i]->control;
                $store->created_at=$listControlNext[$i]->created_at;
                $store->updated_at=$listControlNext[$i]->updated_at;
                $store->save();
                // dd($store);
            }
            // dd($listControl);
            $configAZEL = configAZEL::first();
            
            return view('Project.control')->with('listTLE',$listTLE)->with('listControl',$listControl)->with('configAZEL',$configAZEL);
        }else{
          return redirect('/login');
      }
    }

    public function showtimecontrol(Request $request)
    {
    	// dd($request);
    	$namesatellite = $request->namesatellite;
    	$data= $request->control;
    	$dataspilt = explode(",", $data);
        // dd(($dataspilt));
    	// dd(sizeof($dataspilt));
    	$arraylist= array();
    	$timestart="";
    	for($i = 0 ; $i < sizeof($dataspilt);$i+=4 ){
    		if($timestart==''){
                $timestart=$dataspilt[$i].$dataspilt[$i+1];
                
            }
           
    		$arrayfree= array();
    
            array_push($arrayfree,$dataspilt[$i],$dataspilt[$i+1],$dataspilt[$i+2],$dataspilt[$i+3]);
    		array_push($arraylist,$arrayfree);
            // dd($arrayfree);
    	}
    	 //dd($arraylist);
    	$listTLE = TLE::get();
        return view('Project.showtimecontrol')->with('arraylist',$arraylist)->with('namesatellite',$namesatellite)->with('timestart',$timestart)->with('data',$data)->with('timestamp',$request->timestamp);
    }
    public function settimecontrol(Request $request)
    {
    	
    	// dd($request);
    	$data= $request->control;
    	$dataspilt = explode(",", $data);
    	// dd($dataspilt);
    	$control= [];
    	$timestart="";
    	$timestop="";
 
    	for($i = 0 ; $i < sizeof($dataspilt);$i+=4 ){
            if($timestart==""){
                $timestart=$dataspilt[$i].$dataspilt[$i+1];
                
            
                
            }
    		$arrayfree= [];
    		$arrayfree['time'] = $dataspilt[$i].$dataspilt[$i+1];
    		$arrayfree['azimuth'] = $dataspilt[$i+2];
    		$arrayfree['elevation'] = $dataspilt[$i+3];
    		array_push($control,$arrayfree);
    		$timestop=$dataspilt[$i].$dataspilt[$i+1];
    	}
        // dd($control);
    	$store = new control;
		$store->namesatellite = $request->namesatellite;
		$store->status = $request->status;
		$store->timestart =	$timestart;
		$store->timestop =	$timestop;
        $Date =  DateTime::createFromFormat('m/d/Y h:i:s A', $timestart);//ตามformat
       //d($Date->format('Y-m-d h:i:s'));
        $store->Date = $Date->format('Y-m-d h:i:s');
        // $test=date_format($Date, 'U');
        //dd($Date);
        $store->timestamp =  date_format($Date, 'U');
		$store->control = $control;
        // dd($store);
		$store->save();

        
        


    	
    	$listTLE = TLE::get();
        return redirect('/control')->with('listTLE',$listTLE);
    }
    public function deleteTimeControl(Request $request)
    {
        
        $data = control::find($request->id);
        $data->delete();
       
        return redirect()->back();
    }
    public function logCollection()
    {
        if(Auth::check()){
            $listControl = control::orderBy('timestamp', 'asc')->get();
            // dd($listControl);
            return view('Project.logCollection')->with('listControl',$listControl);
            
        }else{
            return redirect('/login');
        }
    }
    public function schedulecontrol(Request $request)
    {
        
        $listdata = control::find($request->id);
        // dd($listdata->control);
        return view('Project.schedulecontrol')->with('listdata',$listdata);
    }
    public function findControl(Request $request)
    {
        $StartDate = date_create_from_format('d/m/Y', ($request->StartDate));   
        $EndDate = date_create_from_format('d/m/Y', ($request->EndDate));   

        $listControl = control::whereBetween('Date', [ $StartDate->format('Y-m-d h:i:s'), $EndDate->format('Y-m-d h:i:s')])->get();
    // dd($StartDate);
        return view('Project.logCollection')->with('listControl',$listControl);
       
    }
    public function configAZEL(Request $request)
    {
        // dd($request);

        $now = new  DateTime();
        $timestamp =  date_format($now, 'U');

        $data = configAZEL::find($request->id);
        // dd($request);
        $checkAZ=intval($request->AzNew);
        if($request->AzNew == null){
            $data->azimuth=$data->azimuth;
        }else{
            $data->azimuth=$request->AzNew;
        }
        $checkEL=intval($request->ElNew);
        if($request->ElNew == null){
            $data->elevation=$data->elevation;

        }else{
            $data->elevation=$request->ElNew;
        }

        $data->timestamp=$timestamp;
        $data->save();

      

        return redirect()->back();
    }
    public function getAZEL(){
        $data = configAZEL::first();
      
        return response()->json($data);
    }
}
