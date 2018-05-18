@extends('layout')
@section('content')

<div class="eight wide computer eight wide tablet sixteen wide mobile column"> 
	<div class="ui segment" style="height: 100%">
		<div class="ui grey inverted segment " >
			<h2>ตั้งค่าเสาอากาศล่วงหน้า</h2>
		</div>

		<div class="ui form" style="padding-top: 10px">
			<div class="two fields">
				<div class="field" style="display: inline-block; width: 50%	">
					<label>ดาวเทียม</label>
					<div class="ui selection dropdown testonchange">
						<i class="dropdown icon"></i>
						<div class="default text" id="selectSatellite">ดาวเทียม</div>
						<div class="menu">
							@foreach($listTLE as $Item)
							<div class="item" data-line1="{{ $Item->line1 }}" data-line2="{{ $Item->line2 }}" data-_id="{{ $Item->_id }}">{{ $Item->name }}</div>

							@endforeach
						</div>
					</div>
				</div>
				<div class="field" style="display: inline-block; width: 50%	">
					<label>ช่วงเวลา</label>
					<div class="ui selection dropdown " >
						<i class="dropdown icon"></i>
						<div class="default text" id="SelectTime" data-value="daylight">กลางวัน</div>
						<div class="menu">
							<div class="item" data-value="daylight">กลางวัน</div>
							<div class="item" data-value="Night">กลางคืน</div>
							<div class="item" data-value="All">ทั้งหมด</div>

						</div>
					</div>
				</div>
			</div>
			<div class="two fields">
				<div class="field" style="display: inline-block;">
					<label>เวลาเริ่มต้น</label>
					<div class="ui calendar" id="Startcalendar">
						<div class="ui left icon input">
							<input type="text" name="StartDate" id="StartDate" value="<?php echo date('d/m/Y'); ?>">
							<i class="calendar icon"></i>
						</div>
					</div>
				</div>
				<div class="field" style="display: inline-block; margin-left: 5px">
					<label>เวลาสิ้นสุด</label> 
					<div class="ui calendar" id="Endcalendar">
						<div class="ui left icon input">
							<input type="text" name="EndDate" id="EndDate" value="<?php echo date('d/m/Y'); ?>">
							<i class="calendar icon"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="fields">
			<button class="ui secondary button SubmitCal">คำนวณวงโคจร</button>
			<button class="ui red button removeLayerALL ">ล้าง</button>
			<table class="ui celled structured table ">
				<thead>
					<tr>
						<th style="width: 25%"><center>Date </center></th>
						<th style="width: 25%"><center>Start Time</center></th>
						<th style="width: 25%"><center>End time</center></th>
						<th style="width: 25%"><center>รายละเอียด</center></th>
					</tr>
				</thead>
				<tbody id="tableshow">

				</tbody>

			</table>
		</div>
		
	</div>
</div>
<div class="eight wide computer eight wide tablet sixteen wide mobile column"> 
	<div class="ui segment">
		<div class="ui grey inverted segment ">
			<h2>มุมองศาของเสาอากาศ</h2>
		</div>
		<form action="{{ route('Project.configAZEL') }}"  method="post" class="ui form" style="padding-top: 10px" >
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="id" value=" {{ $configAZEL->id }} ">
			<div class="two fields">
				<div class="field" style="display: inline-block;">
					<label>Azimuth (ปัจจุบัน)</label>
					
					<input type="number" id="AzOld" name="AzOld" value="{{ $configAZEL->azimuth }}" disabled >
				</div>
				<div class="field" style="display: inline-block;">
					<label>Azimuth </label>
					<input type="number" id="AzNew" name="AzNew" min="0" max="360"  placeholder="ค่ามุมองษาระหว่าง 0-360"  name="azimuthnew" value=""  oninvalid="this.setCustomValidity('ค่ามุมองษาระหว่าง 0-360')" oninput="setCustomValidity('')" >
				</div>
			</div>
			<div class="two fields">
				<div class="field" style="display: inline-block;">
					<label>Elevation (ปัจจุบัน)</label>
					<input type="number" id="ElOld" name="ElOld" value="{{ $configAZEL->elevation }}" disabled >
				</div>
				<div class="field" style="display: inline-block;">
					<label>Elevation </label>
					<input type="number" id="ElNew" name="ElNew" min="0" max="180" placeholder="ค่ามุมองษาระหว่าง 0-180"  name="azimuthnew" value=""  oninvalid="this.setCustomValidity('ค่ามุมองษาระหว่าง 0-180')" oninput="setCustomValidity('')"  >
				</div>
			</div>

			<center>
				<button class="ui black button submitConfig" type='submit'>ปรับมุมองศา</button>
			</center>
		</form>

		<center>
			
			
		</center>

		
	</div>
</div>
<div class="sixteen wide  column ui segment" style="margin: 10px !important">
	<div class="ui grey inverted segment ">
		<center><h2>ตารางเวลาการควบคุมเสาอากาศ</h2></center>
	</div>

	<table class="ui celled table">


		<thead>
			<th style="width: 12.5%"><center>Date</center></th>
			<th style="width: 12.5%"><center>Satellite</center></th>
			<th style="width: 12.5%"><center>Start Time</center></th>
			<th style="width: 12.5%"><center>End time </center></th>
			<th style="width: 12.5%"><center>Start<br> Azimuth</center></th>
			<th style="width: 12.5%"><center>Start<br> Elevation</center></th>
			<th style="width: 12.5%"><center>รายละเอียด</center></th>
			<th style="width: 12.5%"><center>ลบการตั้งค่าล่วงหน้า</center></th>




		</thead>
		<tbody>
			@foreach($listControl as $Data)
			<tr>
				<td> 
					<center>
						<?php 
						$dataspilt = explode(" ", $Data->timestart);
						$dataspilt2 = explode("/",$dataspilt[0]);
					//$dataspilt2 =explode("-",$dataspilt[0]);;
					echo $dataspilt2[1].'/'.$dataspilt2[0].'/'.$dataspilt2[2];

						?> 
					</center>
				</td>
				<td> 
					<center>{{$Data->namesatellite}}</center>
				</td>
				<td> 
					<center>
						<?php 
						$dataspilt = explode(" ", $Data->timestart);
						echo $dataspilt[1];
						echo ' ' .$dataspilt[2];
						?> 
					</center>
				</td>
				<td> 
					<center>
						<?php 
						$dataspilt = explode(" ", $Data->timestop);
						echo $dataspilt[1];
						echo ' '.$dataspilt[2];
						?> 
					</center>
				</td>
				<td> 
					<center>{{$Data->control[0]['azimuth']}}</center>
				</td>
				<td> 
					<center>{{$Data->control[0]['elevation']}}</center>
				</td>
				<td> 
					<form action="{{ route('Project.schedulecontrol') }}"  method='post'>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $Data->_id }}">
							<button class='ui green button' style="width: 95%" type='submit'>ดูรายระเอียด</button>
						</form>
				</td>
				<td> 
					<form action="{{ route('Project.deleteTimeControl') }}"  method='post'>
						<input type='hidden' name='_token' value='{{ csrf_token() }}'>
						<input type='hidden' name='id' value='{{$Data->_id}}'>
						<center><button class='ui red button' type='submit'>ลบการสั่งการ</button></center>
					</form>
				</td>

			</tr>
			@endforeach

		</tbody>


	</table>
</div>




<script type="text/javascript" >
var today = new Date();
$('#Startcalendar').calendar({
	type: 'date',
	
	endCalendar: $('#Endcalendar'),
	monthFirst: false,
	formatter: {
		date: function (date, settings) {
			
			if(!date) return '';
			var day = ("0" + date.getDate()).slice(-2);
			var month = ("0" + (date.getMonth() + 1)).slice(-2);
			var year = date.getFullYear();
			return day + '/' + month + '/' + year;
		}
	}
});
$('#Endcalendar').calendar({
	type: 'date',
	startCalendar: $('#Startcalendar'),
	monthFirst: false,
	formatter: {
		date: function (date, settings) {
			if(!date) return '';
			var day = ("0" + date.getDate()).slice(-2);
			var month = ("0" + (date.getMonth() + 1)).slice(-2);
			var year = date.getFullYear();
			return day + '/' + month + '/' + year;
		}
	}
});
</script>
<script type="text/javascript">
	
	circle = L.circle([13.12036, 100.91972], 2000000);
	var tleLine1 = '',
	tleLine2 = '',
	_id='';

		// Initialize a satellite record
		var longitudeStrArr = new Array(),
		latitudeStrArr  = new Array(),
		latlngsArr  = new Array(),
		latlngsTest  = new Array(),
		azimuthArr  = new Array(),
		elevationArr  = new Array(),
		latlngsDaylight = new Array(),
		latlngsNight = new Array(),
		PolygonArr  = [];
		timeArr = new Array();
		var DateSecond;
		var polygon;
		var circle;

		/* L.polyline([latitudeStrArr[1],longitudeStrArr[1]]).addTo(mymap);*/
		
		$(document).on('click', '.SubmitCal', function(){
		//console.log(mymap);
		longitudeStrArr =  Array(),
		latitudeStrArr  =  Array(),
		latlngsArr  =  Array(),
		azimuthArr  =  Array(),
		elevationArr  =  Array()
		PolygonArr  = [];
		timeArr =  Array();
		var timestamp=-999;
		var arrControl = Array();
		var ArrData  = new Array();
		var ArrDataControl = Array();
		var DateStartDefault=$('#StartDate').val();
		var DateStartSet=DateStartDefault.split('/')[0];
		var MonthStartSet=DateStartDefault.split('/')[1];
		var YearStartSet=DateStartDefault.split('/')[2];

		var DateEndDefault=$('#EndDate').val();
		var DateEndtSet=DateEndDefault.split('/')[0];
		var MonthEndSet=DateEndDefault.split('/')[1];
		var YearhEndSet=DateEndDefault.split('/')[2];

		var StartDateMDY = MonthStartSet+'/'+DateStartSet+'/'+YearStartSet;
		var EndDateMDY = MonthEndSet+'/'+DateEndtSet+'/'+YearhEndSet;
		var StartDateTemp = Date.parse(StartDateMDY);
		var EndDateTemp = Date.parse(EndDateMDY);

		var SelectTime = $('#SelectTime').val();
		if( StartDateTemp > EndDateTemp || isNaN(EndDateTemp) || isNaN(StartDateTemp) ){
			$.uiAlert({
		            textHead: "กรุณากรอกเวลาให้ถูกต้อง", // header
		            text: '', // Text
		            bgcolor: '#DB2828', // background-color
		            textcolor: '#fff', // color
		            position: 'top-center',// position . top And bottom ||  left / center / right
		            icon: 'remove circle', // icon in semantic-UI
		            time: 3, // time
		        })

		}
		if( ($('#selectSatellite')[0].innerHTML == 'ดาวเทียม')){
			$.uiAlert({
		            textHead: "กรุณาเลือกดาวเทียม", // header
		            text: '', // Text
		            bgcolor: '#DB2828', // background-color
		            textcolor: '#fff', // color
		            position: 'top-center',// position . top And bottom ||  left / center / right
		            icon: 'remove circle', // icon in semantic-UI
		            time: 3, // time
		        })
		}

		if( ($('#selectSatellite')[0].innerHTML != 'ดาวเทียม') && ( StartDateTemp <= EndDateTemp) )
		{

			alert('กำลังประมวณผล')

			circle = L.circle([13.12036, 100.91972], 2000000);

			StartDateTemp=StartDateTemp; //ปรับเวลาเป็นเืี่ยงคืน
			EndDateTemp=EndDateTemp;

			//var subDate=StartDateTemp.substring(1, 4);
			var StartDateTime = new Date();
			StartDateTime.setTime(StartDateTemp);
			var EndDateTime = new Date();
			EndDateTime.setTime(EndDateTemp);

			EndDateTime.setDate(EndDateTime.getDate()+1);
			EndDateTime.setSeconds(EndDateTime.getSeconds()-1);


			DateSecond=(EndDateTime.getTime() - StartDateTemp)/1000; //เวลาที่จะพล็อตกี่วิ
			var satrec = satellite.twoline2satrec(tleLine1, tleLine2);

			calculate();
			function calculate()
			{
				
				
				for(var i = 1 ; i < DateSecond; i+=1)
				{

					var date = new Date();
					date.setTime(StartDateTemp);
					date.setSeconds( date.getSeconds() +i );
					var positionAndVelocity = satellite.propagate(satrec, date);


					var positionEci = positionAndVelocity.position,
					velocityEci = positionAndVelocity.velocity;

				// Set the Observer at 122.03 West by 36.96 North, in RADIANS
				var observerGd = {
					longitude:100.92974  * (Math.PI/180),
					latitude: 13.10219	 * (Math.PI/180),
					height:0
				};
				var gmst = satellite.gstimeFromDate(date);

					// You can get ECF, Geodetic, Look Angles, and Doppler Factor.
					var positionEcf   = satellite.eciToEcf(positionEci, gmst),
					observerEcf   = satellite.geodeticToEcf(observerGd),
					positionGd    = satellite.eciToGeodetic(positionEci, gmst),
					lookAngles    = satellite.ecfToLookAngles(observerGd, positionEcf);
					
					//  dopplerFactor = satellite.dopplerFactor(observerCoordsEcf, positionEcf, velocityEcf);

					// The coordinates are all stored in key-value pairs.
					// ECI and ECF are accessed by `x`, `y`, `z` properties.
					var satelliteX = positionEci.x,
					satelliteY = positionEci.y,
					satelliteZ = positionEci.z;

					// Look Angles may be accessed by `azimuth`, `elevation`, `range_sat` properties.
					var azimuth   = lookAngles.azimuth,
					elevation = lookAngles.elevation,
					rangeSat  = lookAngles.rangeSat;

					// Geodetic coords are accessed via `longitude`, `latitude`, `height`.
					var longitude = positionGd.longitude,
					latitude  = positionGd.latitude,
					height    = positionGd.height;

					//  Convert the RADIANS to DEGREES for pretty printing (appends "N", "S", "E", "W", etc).
					var longitudeStr = satellite.degreesLong(longitude),
					latitudeStr  = satellite.degreesLat(latitude);
					longitudeStrArr[i] =  longitudeStr;
					latitudeStrArr[i] =  latitudeStr;
					timeArr[i] = date;
					azimuthArr[i] = Math.ceil(azimuth*(180/Math.PI));
					elevationArr[i] = Math.ceil(elevation*(180/Math.PI));

				}
				var arrFree  = new Array(3);
				var countINrec=0;
				var jumlatStart = -999;
				var jumlongStart = -999;
				var jumlatStop = -999;
				var jumlongStop = -999;
				var azimuthStart=-999;
				var azimuthEnd=-999;
				var Maxelevation=-999;
				var timeStart=-999;
				var timestamp=-999;

				var timeStop=-999;
				var Maxelevation=-999;
				var ArrTT  = new Array();
				ArrData  = new Array();
				ArrDataControl  = new Array();
				arrControl = new Array();
				for(var i = 1 ; i <  DateSecond; i+=1)
				{
					arrFree  = new Array(3);
					if(($('#SelectTime').text()) == "กลางวัน")
					{

						if( (timeArr[i].getHours()) >= 6  && (timeArr[i].getHours())<18 )
						{

							if( (circle.getLatLng().distanceTo([latitudeStrArr[i],longitudeStrArr[i]])) <= circle.getRadius() )
							{
								if(jumlatStart==-999 && jumlongStart==-999)
								{
									jumlatStart=latitudeStrArr[i];
									jumlongStart=longitudeStrArr[i];
									azimuthStart=azimuthArr[i];
									timeStart=timeArr[i];
									timestamp=timeArr[i].getTime();
									

								}
								if(Maxelevation<elevationArr[i])
								{
									Maxelevation=elevationArr[i];
								}
								jumlatStop=latitudeStrArr[i];
								jumlongStop=longitudeStrArr[i];
								azimuthEnd=azimuthArr[i];
								timeStop=timeArr[i];

								var temp =  moment(timeArr[i]); 
								var date = temp.format("M/D/YYYY, h:mm:ss A");
								arrFree[0] = date;
								arrFree[1] = azimuthArr[i];
								arrFree[2] = elevationArr[i];
								arrControl.push(arrFree);

							}
							else if(jumlatStart != -999)
							{
								/*ArrTT.push([ [jumlatStart,jumlongStart], [jumlatStop,jumlongStop]]);*/
								ArrData.push([timeStart,timeStop,azimuthStart,azimuthEnd,Maxelevation,_id,timestamp]);
								ArrDataControl.push(arrControl);

								jumlatStart = -999;
								jumlongStart = -999;
								jumlatStop = -999;
								jumlongStop = -999;
								azimuthEnd=-999;
								azimuthStart=-999;
								Maxelevation=-999;
								timeStop=-999;
								timeStop=-999;
								arrControl = new Array();
							}

							
						}
					}
					else if(($('#SelectTime').text()) == "กลางคืน")
					{	

						if( ( (timeArr[i].getHours()) >= 18  && (timeArr[i].getHours())<24) || ( (timeArr[i].getHours()) > 0  && (timeArr[i].getHours())<6) )
						{
							if( (circle.getLatLng().distanceTo([latitudeStrArr[i],longitudeStrArr[i]])) <= circle.getRadius() )
							{
								if(jumlatStart==-999 && jumlongStart==-999)
								{
									jumlatStart=latitudeStrArr[i];
									jumlongStart=longitudeStrArr[i];
									azimuthStart=azimuthArr[i];
									timeStart=timeArr[i];
									timestamp=timeArr[i].getTime();
								}
								if(Maxelevation<elevationArr[i])
								{
									Maxelevation=elevationArr[i];
								}
								jumlatStop=latitudeStrArr[i];
								jumlongStop=longitudeStrArr[i];
								azimuthEnd=azimuthArr[i];
								timeStop=timeArr[i];

								var temp =  moment(timeArr[i]); 
								var date = temp.format("M/D/YYYY, h:mm:ss A");
								arrFree[0] = date;
								arrFree[1] = azimuthArr[i];
								arrFree[2] = elevationArr[i]
								arrControl.push(arrFree);
							}
							else if(jumlatStart != -999)
							{


								ArrData.push([timeStart,timeStop,azimuthStart,azimuthEnd,Maxelevation,_id,timestamp]);

								ArrDataControl.push(arrControl);
								jumlatStart = -999;
								jumlongStart = -999;
								jumlatStop = -999;
								jumlongStop = -999;
								azimuthEnd=-999;
								azimuthStart=-999;
								Maxelevation=-999;
								timeStop=-999;
								timeStop=-999;
								arrControl = new Array();
							}
						}

					}
					else if( ($('#SelectTime').text()) == "ทั้งหมด")
					{
						if( (circle.getLatLng().distanceTo([latitudeStrArr[i],longitudeStrArr[i]])) <= circle.getRadius() )
						{
							if(jumlatStart==-999 && jumlongStart==-999)
							{
								jumlatStart=latitudeStrArr[i];
								jumlongStart=longitudeStrArr[i];
								azimuthStart=azimuthArr[i];
								timeStart=timeArr[i];
								timestamp=timeArr[i].getTime();

							}
							if(Maxelevation<elevationArr[i])
							{
								Maxelevation=elevationArr[i];
							}
							jumlatStop=latitudeStrArr[i];
							jumlongStop=longitudeStrArr[i];
							azimuthEnd=azimuthArr[i];
							timeStop=timeArr[i];
							var temp =  moment(timeArr[i]); 
							var date = temp.format("M/D/YYYY, h:mm:ss A");
							//console.log(date);
							arrFree[0] = date;;
							arrFree[1] = azimuthArr[i];
							arrFree[2] = elevationArr[i]
							arrControl.push(arrFree);
						}
						else if(jumlatStart != -999)
						{
							ArrData.push([timeStart,timeStop,azimuthStart,azimuthEnd,Maxelevation,_id,timestamp]);
							ArrDataControl.push(arrControl);

							jumlatStart = -999;
							jumlongStart = -999;
							jumlatStop = -999;
							jumlongStop = -999;
							azimuthEnd=-999;
							azimuthStart=-999;
							Maxelevation=-999;
							timeStop=-999;

							arrControl = new Array();
						}
					}

				}
				if(ArrData.length==0){
					$.uiAlert({
		            textHead: "ไม่มีเวลาที่สามารถรับสัญญาณได้", // header
		            text: '', // Text
		            bgcolor: '#DB2828', // background-color
		            textcolor: '#fff', // color
		            position: 'top-center',// position . top And bottom ||  left / center / right
		            icon: 'remove circle', // icon in semantic-UI
		            time: 3, // time
		        })
				}
			}

		}
		//console.log(ArrDataControl);
		$("#tableshow tr").remove();	
		var tostring = ArrDataControl.toString();
		// console.log(ArrDataControl);
		for (var i = 0; i < ArrData.length ; i++) 
		{
			var text ='';
			for(var j = 0 ; j < ArrDataControl[i].length ; j++)
			{
				if( j == ArrDataControl[i].length -1)
				{
					text =text+ String(ArrDataControl[i][j][0])+','+String(ArrDataControl[i][j][1])+','+String(ArrDataControl[i][j][2]);
				}
				else if( j != ArrDataControl[i].length)
				{
					text =text+ String(ArrDataControl[i][j][0])+','+String(ArrDataControl[i][j][1])+','+String(ArrDataControl[i][j][2])+',';
				}
			}
			
			var temp =  moment(ArrData[i][0]); 
			var date = temp.format("D/M/YYYY");
			var StartTimeTemp = temp.format("h:mm:ss A");

			var temp2 =  moment(ArrData[i][1]); 
			var EndTimeTemp = temp2.format("h:mm:ss A");
			$('#tableshow').append("<tr class='item' id="+ArrData[i][5]+"> <td>"+date+"</td><td>"+StartTimeTemp+"</td><td>"+EndTimeTemp+"</td>"+
				"<td class=ui compact striped> <form action='{{ route('Project.showtimecontrol') }}'  method='post'>"+
				"<input type='hidden' name='_token' value='{{ csrf_token() }}'>"+
				"<input type='number' name='timestamp' value="+ArrData[i][6]+" style=display:none;>" +
				"<input type='hidden' name='control' value='"+text+"'>"+
				"<input type='hidden' name='namesatellite' value='"+ $('#selectSatellite').text()+"'>"+
				"<center><button class='ui green button' style='width:80%' type='submit'>ดูรายละเอียด</button> </center>"+
				"</form></td></tr>");
		}

	});


$(document).on('click', '.removeLayerALL', function() {

	$("#tableshow tr").remove();




});


$( document ).ready(function() {
	$(".testonchange").dropdown({
		onChange: function (value, text , choice) {

			tleLine1=choice[0].dataset.line1;
			tleLine2=choice[0].dataset.line2;
			_id=choice[0].dataset._id;

		}
	});
});

setInterval(function(){
    $.ajax({
      type: 'get',
      url: '/getAZEL',
      data: {
      },
      success: function(data) {
      	// var obj = JSON.parse(data);
      	//console.log(data);
      	$("#AzOld").val(data.azimuth);
     	$("#ElOld").val(data.elevation);
      },
      

    })
}, 1000);

</script>

@stop