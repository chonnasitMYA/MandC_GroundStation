<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TLE;
use App\Users;
use App\control;
use Auth;
use DateTime;
class MainController extends Controller
{
    public function info()
    {
        return view('Project.info');
    }
    public function indexdashboard()
    {
        if(Auth::check()){
            $listTLE = TLE::get();
            $now = new  DateTime();
            $timestamp =  date_format($now, 'U');
            $listControl = control::where('status','N')->where('timestamp', '>',$timestamp)->orderBy('timestamp', 'asc')->get();
            $timestart='';
            $timestop='';
            for($i = 0 ; $i < sizeof($listControl);$i++ ){
                if($timestart==''){
                    $timestart=$listControl[$i]['timestart'];
                }
                $timestop=$listControl[$i]['timestop'];
            }
            $time=[];
            array_push($time,$timestart);
            array_push($time,$timestop);

            
            $yearStart = date('01/01/Y');
            $yearEnd = date('31/12/Y');
            $StartDate = date_create_from_format('d/m/Y H:i:s', ($yearStart).' 00:00:00');   
            $EndDate = date_create_from_format('d/m/Y H:i:s', ($yearEnd).' 23:59:00');   
            $month = [0,0,0,0,0,0,0,0,0,0,0,0];
            $controlComplete = control::whereBetween('Date', [$StartDate->format('Y-m-d H:i:s'), $EndDate->format('Y-m-d H:i:s')])->get();
            
             
            for($i = 0 ; $i < sizeof($controlComplete);$i++){
                $string1 = $controlComplete[$i]['timestart'];
                $dataspilt = explode(" ", $string1);
                $dataspilt2= explode("/", $dataspilt[0]);
                //dd($dataspilt2);
                if($dataspilt2[0] == "1")
                {
                    $month[0]=$month[0]+1;
                }else if($dataspilt2[0] == "2")
                {
                    $month[1]=$month[1]+1;
                }else if($dataspilt2[0] == "3")
                {
                    $month[2]=$month[2]+1;
                }else if($dataspilt2[0] == "4")
                {
                    $month[3]=$month[3]+1;
                }else if($dataspilt2[0] == "5")
                {
                    $month[4]=$month[4]+1;
                }else if($dataspilt2[0] == "6")
                {
                    $month[5]=$month[5]+1;
                }else if($dataspilt2[0] == "7")
                {
                    $month[6]=$month[6]+1;
                }else if($dataspilt2[0] == "8")
                {
                    $month[7]=$month[7]+1;
                }else if($dataspilt2[0] == "9")
                {
                    $month[8]=$month[8]+1;
                }else if($dataspilt2[0] == "10")
                {
                    $month[9]=$month[9]+1;
                }else if($dataspilt2[0] == "11")
                {
                    $month[10]=$month[10]+1;
                }else if($dataspilt2[0] == "12")
                {
                    $month[11]=$month[11]+1;
                }
                
            }
           $year = date("Y");
            
            return view('Project.dashboard')->with('listTLE',$listTLE)->with('listControl',$listControl)->with('time',$time)->with('month',$month)->with('year',$year);
        }else{
            return redirect('/login');
        }

    }
    public function checksatellite()
    {
        $listTLE = TLE::get();
        
        return view('Project.checksatellite')->with('listTLE',$listTLE);
    }
    public function index()
    {
        $tleNOAA15 =TLE::where('name', 'NOAA-15')->first();
        // dd($tleNOAA15);
        $tleNOAA18 =TLE::where('name', 'NOAA-18')->first();
        $tleNOAA20 =TLE::where('name', 'NOAA-20')->first();
        return view('Project.index')->with('tleNOAA15',$tleNOAA15)->with('tleNOAA18',$tleNOAA18)->with('tleNOAA20',$tleNOAA20);
    }
    public function checktle()
    {
        return view('Project.checktle');
    }
    public function test()
    {   
        $data=control::first();
        return view('Project.test')->with('data',$data);
    }
    public function testupload(Request $request)
    {

        return redirect()->back();
    }
   


}
