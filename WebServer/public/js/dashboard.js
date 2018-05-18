		// Sample TLE*/
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

		$(document).on('click', '.SubmitCal', function(){
			//console.log(mymap);
			longitudeStrArr =  Array(),
			latitudeStrArr  =  Array(),
			latlngsArr  =  Array(),
			azimuthArr  =  Array(),
			elevationArr  =  Array()
			PolygonArr  = [];
			timeArr =  Array();
			var ArrData  = new Array();
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

			if( ($('#selectSatellite')[0].innerHTML != 'ดาวเทียม') && ( StartDateTemp <= EndDateTemp) )
			{

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
				
				for(var i = 30 ; i < DateSecond; i+=30)
				{
					var date = new Date();
					date.setTime(StartDateTemp);
					date.setSeconds( date.getSeconds() +i );

					timeArr[i]=date;
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
				var arrFree  = new Array(2);
				var countINrec=0;
				var jumlatStart = -999;
				var jumlongStart = -999;
				var jumlatStop = -999;
				var jumlongStop = -999;
				var azimuthStart=-999;
				var azimuthEnd=-999;
				var Maxelevation=-999;
				var timeStart=-999;
				var timeStop=-999;
				var Maxelevation=-999;
				var ArrTT  = new Array();
				ArrData  = new Array();
				for(var i = 30 ; i <  DateSecond; i+=30)
				{

					arrFree  = new Array(2);
					if(longitudeStrArr[i-30] > 43 && longitudeStrArr[i] < 150 && latitudeStrArr[i-30] > -29 && latitudeStrArr[i] < 45 )
					{

						arrFree[0]=([ latitudeStrArr[i-30],longitudeStrArr[i-30] ]);
						arrFree[1]=([ latitudeStrArr[i],longitudeStrArr[i] ]);
						latlngsArr.push(arrFree);
						

						var nameSattellite = $('#selectSatellite')[0].innerHTML;
						
					}
					
					if(longitudeStrArr[i-30] > 85 && longitudeStrArr[i] < 116 && latitudeStrArr[i-30] > -3 && latitudeStrArr[i] < 29 )
					{
						if(jumlatStart==-999 && jumlongStart==-999)
						{
							jumlatStart=latitudeStrArr[i];
							jumlongStart=longitudeStrArr[i];
							azimuthStart=azimuthArr[i];
							timeStart=timeArr[i];
						}
						if(Maxelevation<elevationArr[i]){
							Maxelevation=elevationArr[i];
						}
						jumlatStop=latitudeStrArr[i];
						jumlongStop=longitudeStrArr[i];
						azimuthEnd=azimuthArr[i];
						timeStop=timeArr[i];
					}
					else if(jumlatStart != -999){
						/*ArrTT.push([ [jumlatStart,jumlongStart], [jumlatStop,jumlongStop]]);*/
						ArrData.push([timeStart,timeStop,azimuthStart,azimuthEnd,Maxelevation,_id]);
						
						jumlatStart = -999;
						jumlongStart = -999;
						jumlatStop = -999;
						jumlongStop = -999;
						azimuthEnd=-999;
						azimuthStart=-999;
						Maxelevation=-999;
						timeStop=-999;
						timeStop=-999;
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

			if( StartDateTemp > EndDateTemp || isNaN(EndDateTemp) || isNaN(StartDateTemp)){
				
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

			$("#tableshow tr").remove();
			for (var i = 0; i < ArrData.length ; i++) { 
				var temp =  moment(ArrData[i][0]); 
				var date = temp.format("D/M/YYYY");
				var StartTimeTemp = temp.format("h:mm:ss A");

				var temp2 =  moment(ArrData[i][1]); 
				var EndTimeTemp = temp2.format("h:mm:ss A");
				//console.log(date);
				$('#tableshow').append(
					"<tr class='item' id="+ArrData[i][5]+">"+
					"<td>"+date+"</td>"+
					"<td>"+StartTimeTemp+"</td>"+
					"<td>"+ArrData[i][2]+"</td>"+
					"<td>"+ArrData[i][3]+"</td>"+
					"<td>"+ArrData[i][4]+"</td>"+
					"<td>"+EndTimeTemp+"</tr>");

			}
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
		$(document).on('click', '.btTLE', function() {

			$('#id').val($(this).data('id'));
			$('#name').val($(this).data('name'));
			$('#line1').val($(this).data('line1'));
			$('#line2').val($(this).data('line2'));


			$('#updateTLEmodal').modal('show');
		});   
		$('.actions').on('click', '.updateTLE', function() {
			if( (($('#line1').val()).length)!=69 || (($('#line2').val()).length)!=69  ){
				
				$.uiAlert({
	              textHead: "กรุณากรอกข้อมูลให้ถูกต้อง", // header
	              text: '', // Text
	              bgcolor: '#DB2828', // background-color
	              textcolor: '#fff', // color
	              position: 'top-center',// position . top And bottom ||  left / center / right
	              icon: 'remove circle', // icon in semantic-UI
	              time: 3, // time
	          })
				return false;
			}
			$.ajax({
				type: 'post',
				url: '/updateTLE',
				data: {
					'_token': $('input[name=_token]').val(),
					'id': $('#id').val(),
					'name': $('#name').val(),
					'line1' : $('#line1').val(),
					'line2': $('#line2').val()
				},
				success: function(data) {
					
					/*$('#messageEditTLE').modal('show');*/
					$('#messageEditTLE').modal({
						onHide: function(){
							location.reload();

						},
						onShow: function(){
							console.log('shown');
						}
						
					}).modal('show');
					
				}
			})
			
		});