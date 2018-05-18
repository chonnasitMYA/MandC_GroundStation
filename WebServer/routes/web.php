<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/info',['as'=>'Project.info','uses'=>'MainController@info']); 


Route::get('/',['as'=>'Project.index','uses'=>'MainController@index']); 
Route::get('/map',['as'=>'Project.map','uses'=>'MainController@map']);

Route::get('/dashboard',['as'=>'Project.dashboard','uses'=>'MainController@indexdashboard']);
Route::get('/checksatellite',['as'=>'Project.checksatellite','uses'=>'MainController@checksatellite']);
Route::get('/member',['as'=>'Project.member','uses'=>'UserController@member']);

Route::get('/test',['as'=>'Project.test','uses'=>'MainController@test']);

Route::get('/PhotoGallery',['as'=>'Project.PhotoGallery','uses'=>'PhotoController@PhotoGallery']);
Route::post('/PhotoGallery',['as'=>'Project.findPhoto','uses'=>'PhotoController@findPhoto']);
Route::post('/AddPhoto',['as'=>'Project.AddPhoto','uses'=>'PhotoController@AddPhoto']);
Route::get('/listphoto',['as'=>'Project.listphoto','uses'=>'PhotoController@listphoto']);
Route::post('/deletephoto',['as'=>'Project.deletephoto','uses'=>'PhotoController@deletephoto']);
Route::post('/listphoto',['as'=>'Project.listfindPhoto','uses'=>'PhotoController@listfindPhoto']);

Route::get('/SoundArchive',['as'=>'Project.SoundArchive','uses'=>'SoundController@SoundArchive']);
Route::post('/SoundArchive',['as'=>'Project.findSound','uses'=>'SoundController@findSound']);
Route::post('/AddSound',['as'=>'Project.AddSound','uses'=>'SoundController@AddSound']);
Route::get('/listsound',['as'=>'Project.listsound','uses'=>'SoundController@listsound']);
Route::post('/deletesound',['as'=>'Project.deletesound','uses'=>'SoundController@deletesound']);
Route::post('/listsound',['as'=>'Project.listfindSound','uses'=>'SoundController@listfindSound']);

Route::get('/logCollection',['as'=>'Project.logCollection','uses'=>'AntennaController@logCollection']);
Route::post('/logCollection',['as'=>'Project.findControl','uses'=>'AntennaController@findControl']);

Route::get('/test',['as'=>'Project.test','uses'=>'MainController@test']);

Route::get('/login',['as'=>'Project.login','uses'=>'UserController@login']);
Route::post('/login',['as'=>'Project.login','uses'=>'UserController@checklogin']);

Route::get('/logout',['as'=>'Project.logout','uses'=>'UserController@logout']);

Route::get('/checktle',['as'=>'Project.checktle','uses'=>'MainController@checktle']);

Route::get('/register',['as'=>'Project.register','uses'=>'UserController@register']);
Route::post('/createuser',['as'=>'Project.createuser','uses'=>'UserController@createuser']);
Route::post('/deleteuser',['as'=>'Project.deleteuser','uses'=>'UserController@deleteuser']);
Route::get('/tle',['as'=>'Project.tle','uses'=>'TLEController@showtle']);
Route::post('/addTLE',['as'=>'Project.addTLE','uses'=>'TLEController@addTLE']);
Route::post('/updateTLE',['as'=>'Project.updateTLE','uses'=>'TLEController@updateTLE']);


Route::get('/position',['as'=>'Project.position','uses'=>'PositionController@position']);
Route::post('/position',['as'=>'Project.positionSelect','uses'=>'PositionController@positionSelect']);

Route::post('/settingPassword',['as'=>'Project.settingPassword','uses'=>'UserController@settingPassword']);


Route::post('/submitEditProfile',['as'=>'Project.submitEditProfile','uses'=>'UserController@submitEditProfile']);

Route::post('/editProfile',['as'=>'Project.editProfile','uses'=>'UserController@editProfile']);
Route::post('/editPasswordUser',['as'=>'Project.editPasswordUser','uses'=>'UserController@editPasswordUser']);
Route::post('/test',['as'=>'Project.testupload','uses'=>'MainController@testupload']);

Route::get('/control',['as'=>'Project.control','uses'=>'AntennaController@control']);

Route::post('/showtimecontrol',['as'=>'Project.showtimecontrol','uses'=>'AntennaController@showtimecontrol']);
Route::post('/settimecontrol',['as'=>'Project.settimecontrol','uses'=>'AntennaController@settimecontrol']);
Route::post('/deleteTimeControl',['as'=>'Project.deleteTimeControl','uses'=>'AntennaController@deleteTimeControl']);
Route::post('/schedulecontrol',['as'=>'Project.schedulecontrol','uses'=>'AntennaController@schedulecontrol']);

Route::post('/deleteTle',['as'=>'Project.deleteTle','uses'=>'TLEController@deleteTle']);
Route::post('/configAZEL',['as'=>'Project.configAZEL','uses'=>'AntennaController@configAZEL']);
Route::get('/getAZEL',['as'=>'Project.getAZEL','uses'=>'AntennaController@getAZEL']);
//Route::post('/callback',['as'=>'Project.callback','uses'=>'LineController@callback']);