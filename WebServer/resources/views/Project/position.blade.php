@extends('layout')

@section('content')

<div class="thirteen wide computer sixteen wide tablet sixteen wide mobile column  ">
	<div class="ui segment" >
		<div id="mapposition" >
		</div>
	</div>
</div>

<div class="three wide computer sixteen wide tablet sixteen wide mobile column "  >
	<div class="ui segment" style="height: 100%; overflow: auto;">
		<div class="fields box1"  style="height: 500px;  " >
			<div class="ui form">
        <table class="ui celled table ">
         <thead>
          <tr>
           <th>ดาวเทียม<br></th>
         </tr></thead>
         <tbody>
           @foreach($listTLE as $Item)
           <tr>

            <td>
             <form class="ui form" action="{{ route('Project.positionSelect')}}" method="post" >

               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <input type="hidden" name="id" value="{{ $Item->id }}">
               <input type="hidden" name="name" value="{{ $Item->name }}">
               <input type="hidden" name="line1" value="{{ $Item->line1 }}">
               <input type="hidden" name="line2" value="{{ $Item->line2 }}">

               <button type="submit" class="ui primary button" style="width: 100%">
                {{ $Item->name }}
              </button>
            </form>
          </td>


        </tr>
        @endforeach

      </tbody>

    </table>
  </div>

</div>


</div>

</div>
<div class="sixteen wide computer sixteen wide tablet sixteen wide mobile column  ">
  <div class="ui segment" >
    <div class="ui negative message">
          <li>ดาวเทียมบางดวงเป็นดาวเทียมที่เคลื่อนที่ช้าหรือดาวเทียมค้างฟ้า</li>
          <li>ท่านสามารถเลื่อนหาตำแหน่งดาวเทียมได้บนแผนที่</li>
          <li>เส้นทางบนแผนที่จะเป็นเส้นทางการเคลื่อนที่ของดาวเทียมล่วงหน้า 2 ชั่วโมง</li>
          
        
          
        </div> 
      
  </div>
</div>
</div>
<br>
<script type="text/javascript">

  

// Sample TLE 
var nameSatellite = '<?php echo $tleFrist->name ?>';
var tleLine1 = '<?php echo $tleFrist->line1 ?>';
tleLine2 = '<?php echo $tleFrist->line2 ?>';

// Initialize a satellite record 
var longitudeStrArr = new Array(),
latitudeStrArr  = new Array(),
latlngsArr  = new Array(),
azimuthArr  = new Array(),
elevationArr  = new Array(),
latlngs = new Array(),
timeArr = new Array(),
startlat=-99,
startlngs=-99;

var SatelliteIcon = L.layerGroup();
var satrec = satellite.twoline2satrec(tleLine1, tleLine2);

for ( var i = -60*10 ;i < 2*60*60; i+=5){
  var date = new Date();
  
  date.setSeconds( date.getSeconds() +i );

  timeArr[i]=date;
  var positionAndVelocity = satellite.propagate(satrec, date);


  var positionEci = positionAndVelocity.position,
  velocityEci = positionAndVelocity.velocity;

  // Set the Observer at 122.03 West by 36.96 North, in RADIANS 
  var observerGd = {
    longitude:100.92974  * (Math.PI/180),
    latitude: 13.10219   * (Math.PI/180),
    height:10
  };
  var gmst = satellite.gstimeFromDate(date);

  // You can get ECF, Geodetic, Look Angles, and Doppler Factor. 
  var positionEcf   = satellite.eciToEcf(positionEci, gmst),
  observerEcf   = satellite.geodeticToEcf(observerGd),
  positionGd    = satellite.eciToGeodetic(positionEci, gmst),
  lookAngles    = satellite.ecfToLookAngles(observerGd, positionEcf);

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
  azimuthArr[i]=azimuth;
  elevationArr[i]=elevation;
  if(startlat==-99 && startlngs == -99)
  {
    startlat=latitudeStr;
    startlngs=longitudeStr;
  }
}


for(var i = -60*10 ; i < 2*60*60; i+=5){
  arrFree  = new Array(2);

  
  
  if(longitudeStrArr[i-5]>0 && longitudeStrArr[i]>0){

    arrFree[0]=([ latitudeStrArr[i-5],longitudeStrArr[i-5] ]);
    arrFree[1]=([ latitudeStrArr[i],longitudeStrArr[i] ]);
    latlngsArr.push(arrFree);
  }else if(longitudeStrArr[i-5]<0 && longitudeStrArr[i]<0){
    arrFree[0]=([ latitudeStrArr[i-5],longitudeStrArr[i-5] ]);
    arrFree[1]=([ latitudeStrArr[i],longitudeStrArr[i] ]);
    latlngsArr.push(arrFree);  

  }
  
  
  
  
  
  
}
/*draw map*/
  var mymap = L.map('mapposition',{
    worldCopyJump: true,
    inertia:false,
  }).setView([startlat, startlngs], 2);
  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Department of Computer Engineering,<a href="http://www.src.ku.ac.th/"> Kasetsart University Sriracha Campus </a>',
    minZoom: 2,
    maxZoom: 5, 
    /*zoomSnap: 0.25,*/
    id: 'mapbox.streets',
    accessToken: 'your.mapbox.access.token'
  }).addTo(mymap);
  // L.polygon(WorldWarp).addTo(mymap);
  var WorldWarp=[[85,-180], [85, 232], [-85,232], [-85,-180]];
  mymap.setMaxBounds(WorldWarp);
  /*----------------------------------*/


L.control.scale().addTo(mymap);
L.control.mousePosition().addTo(mymap);

L.polyline(latlngsArr, {
  color: 'red',
                weight: 2,//ขนาดของเส้น
                opacity: .50, //ความโปร่งแสง
                
              }).addTo(mymap);





/*update updateSatellite*/
function updateSatellite(){


  var date = new Date();
  

  var positionAndVelocity = satellite.propagate(satrec, date);


  var positionEci = positionAndVelocity.position,
  velocityEci = positionAndVelocity.velocity;

  // Set the Observer at 122.03 West by 36.96 North, in RADIANS 
  var observerGd = {
    longitude:100.92974  * (Math.PI/180),
    latitude: 13.10219   * (Math.PI/180),
    height:10
  };
  var gmst = satellite.gstimeFromDate(date);

  // You can get ECF, Geodetic, Look Angles, and Doppler Factor. 
  var positionEcf   = satellite.eciToEcf(positionEci, gmst),
  observerEcf   = satellite.geodeticToEcf(observerGd),
  positionGd    = satellite.eciToGeodetic(positionEci, gmst),
  lookAngles    = satellite.ecfToLookAngles(observerGd, positionEcf);


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
  
  var greenIcon = L.icon({
    iconUrl: 'Satellite.png',
    iconSize:     [50, 50], // size of the icon
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
  });
  
  L.marker([latitudeStr,longitudeStr],{icon: greenIcon}).addTo(SatelliteIcon);
  info.update = function () {
   /* console.log('latitudeStr = '+latitudeStr);
    console.log('longitudeStr = '+longitudeStr);
    */
    this._div.innerHTML = '<h4>Satellite : '+nameSatellite+'</h4>LAT : '+latitudeStr.toFixed( 2 ) +'<br>LNG : '+longitudeStr.toFixed(2)+'';
  };

  info.addTo(mymap);
}
  // control that shows state info on hover
  var info = L.control();

  info.onAdd = function (mymap) {
    this._div = L.DomUtil.create('div', 'info' );
    this.update();
    return this._div;
  };

  


  SatelliteIcon.addTo(mymap);
  /*---------------*/

  /*update checktime*/


  setInterval(function () {
    for(i in SatelliteIcon._layers) {
      mymap.removeLayer(SatelliteIcon._layers[i]);
    }
    
    updateSatellite();
    
  }, 1000);
 /* $(function(){


    setInterval(updateSatellite, 1000);
  });*/

  /*---------------*/

</script>
@stop
