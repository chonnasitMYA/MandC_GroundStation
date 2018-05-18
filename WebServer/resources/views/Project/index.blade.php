@extends('layout') @section('content')
<!-- <link rel="stylesheet" type="text/css" href="/css/slider.css"/>
<link rel="stylesheet" type="text/css" href="/swiper-master/dist/css/swiper.min.css"/>

<script type="text/javascript" src="/swiper-master/dist/js/swiper.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="/css/csslider.default.css" />
<div class="sixteen wide computer sixteen wide tablet sixteen wide mobile column box1" style="">
  <div class="ui segment">
    <center>
      <h1>
        <i class="send icon"> </i>
        Satellite
      </h1>
    </center>
    <br>
    <center>
      <div class="csslider">
        <input type="radio" name="slides" id="slides_1" checked />
        <input type="radio" name="slides" id="slides_2" />
        <input type="radio" name="slides" id="slides_3" />

        <ul>
          <li>
            <div class="" id="mapindex1"></div>
          </li>
          <li>
            <div class="" id="mapindex2"></div>
          </li>
          <li>
            <div class="" id="mapindex3"></div>
          </li>

        </ul>
        <div class="arrows" id="">
          <label id="test22" for="slides_1" value="id1"></label>
          <label id="test23" for="slides_2" value="id2"></label>
          <label id="test24" for="slides_3" value="id3"></label>

        </div>
        <div class="navigation">
          <div>
            <label for="slides_1"></label>
            <label for="slides_2"></label>
            <label for="slides_3"></label>

          </div>
        </div>
      </div>
    </center>
  </div>

  <div class="ui form segment box3" style="margin: 20px!important;">
    <div class="fields">

      <div class="eight wide field">
        <h3>
          <i class="big file  icon"></i>ตรวจสอบตำแหน่งของดาวเทียม</h3>
        <label>ตรวจสอบตำแหน่งของดาวเทียม</label>
        <p>ตรวจสอบตำแหน่งของดาวเทียม จะระบบุตำแหน่งของดาวเทียมบนโลกโดยจะแสดงตำแหน่งของดาวเทียมและแสดงเส้นทางของดาวเทียมที่จะเคลื่อนที่ไป</p>
      </div>
      <div class="eight wide field">
        <h3>
          <i class="big calendar icon"></i>ตรวจสอบตารางเวลาการรับสัญญาณ</h3>
        <b>ตรวจสอบการเข้าถึงของดาวเทียม</b>
        <p>ตรวจสอบการเข้าถึงของดาวเทียม ของดาวเทียมแต่ละดวงโดยแสดงตามวันที่ต้องการค้นหา ทั้งวันที่ในอดีตและในปัจจุบัน</p>
      </div>
    </div>
  </div>
  <div class="ui form segment box3" style="margin: 20px!important;">
    <div class="fields">

      <div class="eight wide field">
        <h3>
          <i class="big photo  icon"></i>คลังรูปภาพ</h3>
        <label>คลังรูปภาพ</label>
        <p>คลังรูปภาพ แสดงข้อมูลรูปภาพที่ประมวลผลแล้วที่มีอยู่ในคลังข้อมูลนำไปใช้ประโยชน์ </p>
      </div>
      <div class="eight wide field">
        <h3>
          <i class="big signal icon"></i>คลังเสียง</h3>
        <b>คลังเสียง</b>
        <p>คลังเสียง แสดงข้อเสียงที่มีอยู่ในคลังข้อมูลเพื่อนำไปใช้ประโยชน์</p>
      </div>
    </div>
  </div>
</div>

</div>




<div class="ui inverted menu ">
  <div class="ui four column doubling stackable grid container" style="color: white;">
    <div class="column">
      <center>

        <h2>Satellite</h2>

        <a class="item" href="{{ route('Project.position') }}">
          <i class="file icon "></i> ตำแหน่งของดาวเทียม
        </a>
        <a class="item" href="{{ route('Project.checksatellite') }}">
          <i class="calendar  icon"></i> ตารางเวลาการรับสัญญาณ</a>
      </center>

    </div>
    <div class="column">
      <center>
        <h2>คลังข้อมูล</h2>
        <a class="item" href="{{ route('Project.PhotoGallery') }}">
          <i class="photo icon"></i>คลังรูปภาพ</a>
        <a class="item" href="{{ route('Project.SoundArchive') }}">
          <i class="signal icon"></i>คลังเสียง</a>

      </center>
    </div>
    <div class="column">
      <center>
        <h2>Social Network</h2>
        <a class="item" href="https://www.facebook.com/gistda/">
          <i class="icon facebook"></i> GISTDA</a>
        <a class="item" href="https://www.facebook.com/engineeringSRC/">
          <i class="icon facebook"></i> Faculty of Engineering at Sriracha</a>
      </center>
    </div>
    <div class="column">
      <center>
        <h2>About Us</h2>
        <p>Department of Computer Engineering</p>
        <p>Faculty of Engineering at Sriracha,</p>
        <p>Kasetsart University Sriracha Campus</p>
      </center>
    </div>

  </div>
  </center>
</div>




<script type="text/javascript">
  var imgIcon = "Satellite.png"

  /* ----------------------------NOAA15-----------------------------------------------*/



  // Sample TLE 
  var nameSatelliteNOAA15 = '<?php echo $tleNOAA15->name ?>';
  var tleLine1NOAA15 = '<?php echo $tleNOAA15->line1 ?>',
    tleLine2NOAA15 = '<?php echo $tleNOAA15->line2 ?>';

  // Initialize a satellite record 
  var longitudeStrArr1NOAA15 = new Array(),
    latitudeStrArr1NOAA15 = new Array(),
    latlngsArr1NOAA15 = new Array(),
    azimuthArr1NOAA15 = new Array(),
    elevationArr1NOAA15 = new Array(),
    timeArr1NOAA15 = new Array();
  startlat1NOAA15 = -99,
    startlngs1NOAA15 = -99;
  var SatelliteIcon1NOAA15 = L.layerGroup();
  var satrecNOAA15 = satellite.twoline2satrec(tleLine1NOAA15, tleLine2NOAA15);


  for (var i = -60 * 10; i < 2 * 60 * 60; i += 5) {
    var dateNOAA15 = new Date();

    dateNOAA15.setSeconds(dateNOAA15.getSeconds() + i);

    timeArr1NOAA15[i] = dateNOAA15;
    var positionAndVelocityNOAA15 = satellite.propagate(satrecNOAA15, dateNOAA15);


    var positionEciNOAA15 = positionAndVelocityNOAA15.position,
      velocityEciNOAA15 = positionAndVelocityNOAA15.velocity;

    // Set the Observer at 122.03 West by 36.96 North, in RADIANS 
    var observerGdNOAA15 = {
      longitude: 100.92974 * (Math.PI / 180),
      latitude: 13.10219 * (Math.PI / 180),
      height: 10
    };
    var gmstNOAA15 = satellite.gstimeFromDate(dateNOAA15);

    // You can get ECF, Geodetic, Look Angles, and Doppler Factor. 
    var positionEcfNOAA15 = satellite.eciToEcf(positionEciNOAA15, gmstNOAA15),
      observerEcfNOAA15 = satellite.geodeticToEcf(observerGdNOAA15),
      positionGdNOAA15 = satellite.eciToGeodetic(positionEciNOAA15, gmstNOAA15),
      lookAnglesNOAA15 = satellite.ecfToLookAngles(observerGdNOAA15, positionEcfNOAA15);


    // The coordinates are all stored in key-value pairs. 
    // ECI and ECF are accessed by `x`, `y`, `z` properties. 
    var satelliteXNOAA15 = positionEciNOAA15.x,
      satelliteYNOAA15 = positionEciNOAA15.y,
      satelliteZNOAA15 = positionEciNOAA15.z;

    // Look Angles may be accessed by `azimuth`, `elevation`, `range_sat` properties. 
    var azimuthNOAA15 = lookAnglesNOAA15.azimuth,
      elevationNOAA15 = lookAnglesNOAA15.elevation,
      rangeSatNOAA15 = lookAnglesNOAA15.rangeSat;

    // Geodetic coords are accessed via `longitude`, `latitude`, `height`. 
    var longitudeNOAA15 = positionGdNOAA15.longitude,
      latitudeNOAA15 = positionGdNOAA15.latitude,
      heightNOAA15 = positionGdNOAA15.height;

    //  Convert the RADIANS to DEGREES for pretty printing (appends "N", "S", "E", "W", etc). 
    var longitudeStrNOAA15 = satellite.degreesLong(longitudeNOAA15),
      latitudeStrNOAA15 = satellite.degreesLat(latitudeNOAA15);
    longitudeStrArr1NOAA15[i] = longitudeStrNOAA15;
    latitudeStrArr1NOAA15[i] = latitudeStrNOAA15;
    azimuthArr1NOAA15[i] = azimuthNOAA15;
    elevationArr1NOAA15[i] = elevationNOAA15;
    if (startlat1NOAA15 == -99 && startlngs1NOAA15 == -99) {
      startlat1NOAA15 = latitudeStrNOAA15;
      startlngs1NOAA15 = longitudeStrNOAA15;
    }
  }

  for (var i = -60 * 10; i < 2 * 60 * 60; i += 5) {
    arrFree = new Array(2);
    if (longitudeStrArr1NOAA15[i - 5] > 0 && longitudeStrArr1NOAA15[i] > 0) {

      arrFree[0] = ([latitudeStrArr1NOAA15[i - 5], longitudeStrArr1NOAA15[i - 5]]);
      arrFree[1] = ([latitudeStrArr1NOAA15[i], longitudeStrArr1NOAA15[i]]);
      latlngsArr1NOAA15.push(arrFree);
    } else if (longitudeStrArr1NOAA15[i - 5] < 0 && longitudeStrArr1NOAA15[i] < 0) {
      arrFree[0] = ([latitudeStrArr1NOAA15[i - 5], longitudeStrArr1NOAA15[i - 5]]);
      arrFree[1] = ([latitudeStrArr1NOAA15[i], longitudeStrArr1NOAA15[i]]);
      latlngsArr1NOAA15.push(arrFree);

    }


  }

  var mymap1 = L.map('mapindex1', {
    worldCopyJump: true,
    inertia: false,
  }).setView([startlat1NOAA15, startlngs1NOAA15], 2);
  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Department of Computer Engineering,<a href="http://www.src.ku.ac.th/"> Kasetsart University Sriracha Campus </a>',
    minZoom: 2,
    maxZoom: 5,
    /*zoomSnap: 0.25,*/
    id: 'mapbox.streets',
    // subdomains:['mt0','mt1','mt2','mt3'],
    accessToken: 'your.mapbox.access.token'
  }).addTo(mymap1);
  var WorldWarp = [
    [85, -180],
    [85, 232],
    [-85, 232],
    [-85, -180]
  ];
  mymap1.setMaxBounds(WorldWarp);
  L.control.scale().addTo(mymap1);

  L.polyline(latlngsArr1NOAA15, {
    color: 'red',
    weight: 2, //ขนาดของเส้น
    opacity: .50, //ความโปร่งแสง

  }).addTo(mymap1);

  /* ----------------------------End NOAA15-----------------------------------------------*/


  /* ----------------------------NOAA18-----------------------------------------------*/




  // Sample TLE 
  var nameSatelliteNOAA18 = '<?php echo $tleNOAA18->name ?>';
  var tleLine1NOAA18 = '<?php echo $tleNOAA18->line1 ?>',
    tleLine2NOAA18 = '<?php echo $tleNOAA18->line2 ?>';

  // Initialize a satellite record 
  var longitudeStrArr1NOAA18 = new Array(),
    latitudeStrArr1NOAA18 = new Array(),
    latlngsArr1NOAA18 = new Array(),
    azimuthArr1NOAA18 = new Array(),
    elevationArr1NOAA18 = new Array(),
    timeArr1NOAA18 = new Array();
  startlat1NOAA18 = -99,
    startlngs1NOAA18 = -99;
  var SatelliteIcon1NOAA18 = L.layerGroup();
  var satrecNOAA18 = satellite.twoline2satrec(tleLine1NOAA18, tleLine2NOAA18);


  for (var i = -60 * 10; i < 2 * 60 * 60; i += 5) {
    var dateNOAA18 = new Date();

    dateNOAA18.setSeconds(dateNOAA18.getSeconds() + i);

    timeArr1NOAA18[i] = dateNOAA18;
    var positionAndVelocityNOAA18 = satellite.propagate(satrecNOAA18, dateNOAA18);


    var positionEciNOAA18 = positionAndVelocityNOAA18.position,
      velocityEciNOAA18 = positionAndVelocityNOAA18.velocity;

    // Set the Observer at 122.03 West by 36.96 North, in RADIANS 
    var observerGdNOAA18 = {
      longitude: 100.92974 * (Math.PI / 180),
      latitude: 13.10219 * (Math.PI / 180),
      height: 10
    };
    var gmstNOAA18 = satellite.gstimeFromDate(dateNOAA18);

    // You can get ECF, Geodetic, Look Angles, and Doppler Factor. 
    var positionEcfNOAA18 = satellite.eciToEcf(positionEciNOAA18, gmstNOAA18),
      observerEcfNOAA18 = satellite.geodeticToEcf(observerGdNOAA18),
      positionGdNOAA18 = satellite.eciToGeodetic(positionEciNOAA18, gmstNOAA18),
      lookAnglesNOAA18 = satellite.ecfToLookAngles(observerGdNOAA18, positionEcfNOAA18);


    // The coordinates are all stored in key-value pairs. 
    // ECI and ECF are accessed by `x`, `y`, `z` properties. 
    var satelliteXNOAA18 = positionEciNOAA18.x,
      satelliteYNOAA18 = positionEciNOAA18.y,
      satelliteZNOAA18 = positionEciNOAA18.z;

    // Look Angles may be accessed by `azimuth`, `elevation`, `range_sat` properties. 
    var azimuthNOAA18 = lookAnglesNOAA18.azimuth,
      elevationNOAA18 = lookAnglesNOAA18.elevation,
      rangeSatNOAA18 = lookAnglesNOAA18.rangeSat;

    // Geodetic coords are accessed via `longitude`, `latitude`, `height`. 
    var longitudeNOAA18 = positionGdNOAA18.longitude,
      latitudeNOAA18 = positionGdNOAA18.latitude,
      heightNOAA18 = positionGdNOAA18.height;

    //  Convert the RADIANS to DEGREES for pretty printing (appends "N", "S", "E", "W", etc). 
    var longitudeStrNOAA18 = satellite.degreesLong(longitudeNOAA18),
      latitudeStrNOAA18 = satellite.degreesLat(latitudeNOAA18);
    longitudeStrArr1NOAA18[i] = longitudeStrNOAA18;
    latitudeStrArr1NOAA18[i] = latitudeStrNOAA18;
    azimuthArr1NOAA18[i] = azimuthNOAA18;
    elevationArr1NOAA18[i] = elevationNOAA18;
    if (startlat1NOAA18 == -99 && startlngs1NOAA18 == -99) {
      startlat1NOAA18 = latitudeStrNOAA18;
      startlngs1NOAA18 = longitudeStrNOAA18;
    }
  }

  for (var i = -60 * 10; i < 2 * 60 * 60; i += 5) {
    arrFree = new Array(2);
    if (longitudeStrArr1NOAA18[i - 5] > 0 && longitudeStrArr1NOAA18[i] > 0) {

      arrFree[0] = ([latitudeStrArr1NOAA18[i - 5], longitudeStrArr1NOAA18[i - 5]]);
      arrFree[1] = ([latitudeStrArr1NOAA18[i], longitudeStrArr1NOAA18[i]]);
      latlngsArr1NOAA18.push(arrFree);
    } else if (longitudeStrArr1NOAA18[i - 5] < 0 && longitudeStrArr1NOAA18[i] < 0) {
      arrFree[0] = ([latitudeStrArr1NOAA18[i - 5], longitudeStrArr1NOAA18[i - 5]]);
      arrFree[1] = ([latitudeStrArr1NOAA18[i], longitudeStrArr1NOAA18[i]]);
      latlngsArr1NOAA18.push(arrFree);

    }


  }

  var mymap2 = L.map('mapindex2', {
    worldCopyJump: true,
    inertia: false,
  }).setView([startlat1NOAA18, startlngs1NOAA18], 2);
  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Department of Computer Engineering,<a href="http://www.src.ku.ac.th/"> Kasetsart University Sriracha Campus </a>',
    minZoom: 2,
    maxZoom: 5,
    /*zoomSnap: 0.25,*/
    id: 'mapbox.streets',
    // subdomains:['mt0','mt1','mt2','mt3'],
    accessToken: 'your.mapbox.access.token'
  }).addTo(mymap2);

  L.polyline(latlngsArr1NOAA18, {
    color: 'red',
    weight: 2, //ขนาดของเส้น
    opacity: .50, //ความโปร่งแสง

  }).addTo(mymap2);
  var WorldWarp = [
    [85, -180],
    [85, 232],
    [-85, 232],
    [-85, -180]
  ];
  mymap2.setMaxBounds(WorldWarp);
  L.control.scale().addTo(mymap2);
  /* ----------------------------End NOAA18-----------------------------------------------*/

  /* ----------------------------NOAA20-----------------------------------------------*/


  // Sample TLE 
  var nameSatelliteNOAA20 = '<?php echo $tleNOAA20->name ?>';
  var tleLine1NOAA20 = '<?php echo $tleNOAA20->line1 ?>',
    tleLine2NOAA20 = '<?php echo $tleNOAA20->line2 ?>';

  // Initialize a satellite record 
  var longitudeStrArr1NOAA20 = new Array(),
    latitudeStrArr1NOAA20 = new Array(),
    latlngsArr1NOAA20 = new Array(),
    azimuthArr1NOAA20 = new Array(),
    elevationArr1NOAA20 = new Array(),
    timeArr1NOAA20 = new Array();
  startlat1NOAA20 = -99,
    startlngs1NOAA20 = -99;
  var SatelliteIcon1NOAA20 = L.layerGroup();
  var satrecNOAA20 = satellite.twoline2satrec(tleLine1NOAA20, tleLine2NOAA20);


  for (var i = -60 * 10; i < 2 * 60 * 60; i += 5) {
    var dateNOAA20 = new Date();

    dateNOAA20.setSeconds(dateNOAA20.getSeconds() + i);

    timeArr1NOAA20[i] = dateNOAA20;
    var positionAndVelocityNOAA20 = satellite.propagate(satrecNOAA20, dateNOAA20);


    var positionEciNOAA20 = positionAndVelocityNOAA20.position,
      velocityEciNOAA20 = positionAndVelocityNOAA20.velocity;

    // Set the Observer at 122.03 West by 36.96 North, in RADIANS 
    var observerGdNOAA20 = {
      longitude: 100.92974 * (Math.PI / 180),
      latitude: 13.10219 * (Math.PI / 180),
      height: 10
    };
    var gmstNOAA20 = satellite.gstimeFromDate(dateNOAA20);

    // You can get ECF, Geodetic, Look Angles, and Doppler Factor. 
    var positionEcfNOAA20 = satellite.eciToEcf(positionEciNOAA20, gmstNOAA20),
      observerEcfNOAA20 = satellite.geodeticToEcf(observerGdNOAA20),
      positionGdNOAA20 = satellite.eciToGeodetic(positionEciNOAA20, gmstNOAA20),
      lookAnglesNOAA20 = satellite.ecfToLookAngles(observerGdNOAA20, positionEcfNOAA20);


    // The coordinates are all stored in key-value pairs. 
    // ECI and ECF are accessed by `x`, `y`, `z` properties. 
    var satelliteXNOAA20 = positionEciNOAA20.x,
      satelliteYNOAA20 = positionEciNOAA20.y,
      satelliteZNOAA20 = positionEciNOAA20.z;

    // Look Angles may be accessed by `azimuth`, `elevation`, `range_sat` properties. 
    var azimuthNOAA20 = lookAnglesNOAA20.azimuth,
      elevationNOAA20 = lookAnglesNOAA20.elevation,
      rangeSatNOAA20 = lookAnglesNOAA20.rangeSat;

    // Geodetic coords are accessed via `longitude`, `latitude`, `height`. 
    var longitudeNOAA20 = positionGdNOAA20.longitude,
      latitudeNOAA20 = positionGdNOAA20.latitude,
      heightNOAA20 = positionGdNOAA20.height;

    //  Convert the RADIANS to DEGREES for pretty printing (appends "N", "S", "E", "W", etc). 
    var longitudeStrNOAA20 = satellite.degreesLong(longitudeNOAA20),
      latitudeStrNOAA20 = satellite.degreesLat(latitudeNOAA20);
    longitudeStrArr1NOAA20[i] = longitudeStrNOAA20;
    latitudeStrArr1NOAA20[i] = latitudeStrNOAA20;
    azimuthArr1NOAA20[i] = azimuthNOAA20;
    elevationArr1NOAA20[i] = elevationNOAA20;
    if (startlat1NOAA20 == -99 && startlngs1NOAA20 == -99) {
      startlat1NOAA20 = latitudeStrNOAA20;
      startlngs1NOAA20 = longitudeStrNOAA20;
    }
  }

  for (var i = -60 * 10; i < 2 * 60 * 60; i += 5) {
    arrFree = new Array(2);
    if (longitudeStrArr1NOAA20[i - 5] > 0 && longitudeStrArr1NOAA20[i] > 0) {

      arrFree[0] = ([latitudeStrArr1NOAA20[i - 5], longitudeStrArr1NOAA20[i - 5]]);
      arrFree[1] = ([latitudeStrArr1NOAA20[i], longitudeStrArr1NOAA20[i]]);
      latlngsArr1NOAA20.push(arrFree);
    } else if (longitudeStrArr1NOAA20[i - 5] < 0 && longitudeStrArr1NOAA20[i] < 0) {
      arrFree[0] = ([latitudeStrArr1NOAA20[i - 5], longitudeStrArr1NOAA20[i - 5]]);
      arrFree[1] = ([latitudeStrArr1NOAA20[i], longitudeStrArr1NOAA20[i]]);
      latlngsArr1NOAA20.push(arrFree);

    }


  }
  var mymap3 = L.map('mapindex3', {
    worldCopyJump: true,
    inertia: false,
  }).setView([50, 50], 2);
  L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
    attribution: 'Department of Computer Engineering,<a href="http://www.src.ku.ac.th/"> Kasetsart University Sriracha Campus </a>',
    minZoom: 2,
    maxZoom: 5,
    /*zoomSnap: 0.25,*/
    id: 'mapbox.streets',
    // subdomains:['mt0','mt1','mt2','mt3'],
    accessToken: 'your.mapbox.access.token'
  }).addTo(mymap3);
  var WorldWarp = [
    [85, -180],
    [85, 232],
    [-85, 232],
    [-85, -180]
  ];
  mymap3.setMaxBounds(WorldWarp);
  L.control.scale().addTo(mymap3);

  L.polyline(latlngsArr1NOAA20, {
    color: 'red',
    weight: 2, //ขนาดของเส้น
    opacity: .50, //ความโปร่งแสง

  }).addTo(mymap3);

  /* ----------------------------End NOAA20-----------------------------------------------*/


  /*------------------------------update updateSatelliteNOAA15-----------------------*/
  function updateSatelliteNOAA15() {
    var date = new Date();
    var positionAndVelocity = satellite.propagate(satrecNOAA15, date);


    var positionEci = positionAndVelocity.position,
      velocityEci = positionAndVelocity.velocity;

    // Set the Observer at 122.03 West by 36.96 North, in RADIANS 
    var observerGd = {
      longitude: 100.92974 * (Math.PI / 180),
      latitude: 13.10219 * (Math.PI / 180),
      height: 10
    };
    var gmst = satellite.gstimeFromDate(date);

    // You can get ECF, Geodetic, Look Angles, and Doppler Factor. 
    var positionEcf = satellite.eciToEcf(positionEci, gmst),
      observerEcf = satellite.geodeticToEcf(observerGd),
      positionGd = satellite.eciToGeodetic(positionEci, gmst),
      lookAngles = satellite.ecfToLookAngles(observerGd, positionEcf);


    // The coordinates are all stored in key-value pairs. 
    // ECI and ECF are accessed by `x`, `y`, `z` properties. 
    var satelliteX = positionEci.x,
      satelliteY = positionEci.y,
      satelliteZ = positionEci.z;

    // Look Angles may be accessed by `azimuth`, `elevation`, `range_sat` properties. 
    var azimuth = lookAngles.azimuth,
      elevation = lookAngles.elevation,
      rangeSat = lookAngles.rangeSat;

    // Geodetic coords are accessed via `longitude`, `latitude`, `height`. 
    var longitude = positionGd.longitude,
      latitude = positionGd.latitude,
      height = positionGd.height;

    //  Convert the RADIANS to DEGREES for pretty printing (appends "N", "S", "E", "W", etc). 
    var longitudeStr = satellite.degreesLong(longitude),
      latitudeStr = satellite.degreesLat(latitude);

    var Icon = L.icon({
      iconUrl: imgIcon,


      iconSize: [50, 50], // size of the icon

      /* iconAnchor:   [0, 0], // point of the icon which will correspond to marker's location*/

      popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
    });

    L.marker([latitudeStr, longitudeStr], {
      icon: Icon
    }).addTo(SatelliteIcon1NOAA15);

    info1.update = function () {
      this._div.innerHTML = '<h4>Satellite : ' + nameSatelliteNOAA15 + '</h4>LAT : ' + latitudeStr.toFixed(2) +
        '<br>LNG : ' + longitudeStr.toFixed(2) + '';
    };

    info1.addTo(mymap1);
  }
  // control that shows state info on hover
  var info1 = L.control();
  info1.onAdd = function (mymap1) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
  };
  SatelliteIcon1NOAA15.addTo(mymap1);
  // console.log(SatelliteIcon1NOAA15);
  /*---------------*/
  /*update checktime*/
  setInterval(function () {
    // console.log(SatelliteIcon1NOAA15);
    // console.log(SatelliteIcon1NOAA15);
    for (i in SatelliteIcon1NOAA15._layers) {
      mymap1.removeLayer(SatelliteIcon1NOAA15._layers[i]);
    }

  }, 1000);

  /*------------------------------End update updateSatelliteNOAA15-----------------------*/



  /*------------------------------update updateSatelliteNOAA18-----------------------*/

  /*update updateSatelliteNOAA18*/
  function updateSatelliteNOAA18() {
    var date = new Date();
    var positionAndVelocity = satellite.propagate(satrecNOAA18, date);


    var positionEci = positionAndVelocity.position,
      velocityEci = positionAndVelocity.velocity;

    // Set the Observer at 122.03 West by 36.96 North, in RADIANS 
    var observerGd = {
      longitude: 100.92974 * (Math.PI / 180),
      latitude: 13.10219 * (Math.PI / 180),
      height: 10
    };
    var gmst = satellite.gstimeFromDate(date);

    // You can get ECF, Geodetic, Look Angles, and Doppler Factor. 
    var positionEcf = satellite.eciToEcf(positionEci, gmst),
      observerEcf = satellite.geodeticToEcf(observerGd),
      positionGd = satellite.eciToGeodetic(positionEci, gmst),
      lookAngles = satellite.ecfToLookAngles(observerGd, positionEcf);


    // The coordinates are all stored in key-value pairs. 
    // ECI and ECF are accessed by `x`, `y`, `z` properties. 
    var satelliteX = positionEci.x,
      satelliteY = positionEci.y,
      satelliteZ = positionEci.z;

    // Look Angles may be accessed by `azimuth`, `elevation`, `range_sat` properties. 
    var azimuth = lookAngles.azimuth,
      elevation = lookAngles.elevation,
      rangeSat = lookAngles.rangeSat;

    // Geodetic coords are accessed via `longitude`, `latitude`, `height`. 
    var longitude = positionGd.longitude,
      latitude = positionGd.latitude,
      height = positionGd.height;

    //  Convert the RADIANS to DEGREES for pretty printing (appends "N", "S", "E", "W", etc). 
    var longitudeStr = satellite.degreesLong(longitude),
      latitudeStr = satellite.degreesLat(latitude);

    var Icon = L.icon({
      iconUrl: imgIcon,


      iconSize: [50, 50], // size of the icon

      /* iconAnchor:   [0, 0], // point of the icon which will correspond to marker's location*/

      popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
    });

    L.marker([latitudeStr, longitudeStr], {
      icon: Icon
    }).addTo(SatelliteIcon1NOAA18);

    info2.update = function () {
      this._div.innerHTML = '<h4>Satellite : ' + nameSatelliteNOAA18 + '</h4>LAT : ' + latitudeStr.toFixed(2) +
        '<br>LNG : ' + longitudeStr.toFixed(2) + '';
    };

    info2.addTo(mymap2);
  }
  // control that shows state info on hover
  var info2 = L.control();
  info2.onAdd = function (mymap2) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
  };
  SatelliteIcon1NOAA18.addTo(mymap2);
  // console.log(SatelliteIcon1NOAA18);
  /*---------------*/
  /*update checktime*/
  setInterval(function () {
    // console.log(SatelliteIcon1NOAA18);
    // console.log(SatelliteIcon1NOAA18);
    for (i in SatelliteIcon1NOAA18._layers) {
      mymap2.removeLayer(SatelliteIcon1NOAA18._layers[i]);
    }

  }, 1000);

  /*------------------------------End update updateSatelliteNOAA18-----------------------*/

  /*------------------------------update updateSatelliteNOAA20-----------------------*/

  /*update updateSatelliteNOAA20*/
  function updateSatelliteNOAA20() {
    var date = new Date();
    var positionAndVelocity = satellite.propagate(satrecNOAA20, date);


    var positionEci = positionAndVelocity.position,
      velocityEci = positionAndVelocity.velocity;

    // Set the Observer at 122.03 West by 36.96 North, in RADIANS 
    var observerGd = {
      longitude: 100.92974 * (Math.PI / 180),
      latitude: 13.10219 * (Math.PI / 180),
      height: 10
    };
    var gmst = satellite.gstimeFromDate(date);

    // You can get ECF, Geodetic, Look Angles, and Doppler Factor. 
    var positionEcf = satellite.eciToEcf(positionEci, gmst),
      observerEcf = satellite.geodeticToEcf(observerGd),
      positionGd = satellite.eciToGeodetic(positionEci, gmst),
      lookAngles = satellite.ecfToLookAngles(observerGd, positionEcf);


    // The coordinates are all stored in key-value pairs. 
    // ECI and ECF are accessed by `x`, `y`, `z` properties. 
    var satelliteX = positionEci.x,
      satelliteY = positionEci.y,
      satelliteZ = positionEci.z;

    // Look Angles may be accessed by `azimuth`, `elevation`, `range_sat` properties. 
    var azimuth = lookAngles.azimuth,
      elevation = lookAngles.elevation,
      rangeSat = lookAngles.rangeSat;

    // Geodetic coords are accessed via `longitude`, `latitude`, `height`. 
    var longitude = positionGd.longitude,
      latitude = positionGd.latitude,
      height = positionGd.height;

    //  Convert the RADIANS to DEGREES for pretty printing (appends "N", "S", "E", "W", etc). 
    var longitudeStr = satellite.degreesLong(longitude),
      latitudeStr = satellite.degreesLat(latitude);

    var Icon = L.icon({
      iconUrl: imgIcon,


      iconSize: [50, 50], // size of the icon

      /* iconAnchor:   [0, 0], // point of the icon which will correspond to marker's location*/

      popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
    });

    L.marker([latitudeStr, longitudeStr], {
      icon: Icon
    }).addTo(SatelliteIcon1NOAA20);

    info3.update = function () {
      this._div.innerHTML = '<h4>Satellite : ' + nameSatelliteNOAA20 + '</h4>LAT : ' + latitudeStr.toFixed(2) +
        '<br>LNG : ' + longitudeStr.toFixed(2) + '';
    };

    info3.addTo(mymap3);
  }
  // control that shows state info on hover
  var info3 = L.control();
  info3.onAdd = function (mymap3) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
  };
  SatelliteIcon1NOAA20.addTo(mymap3);
  // console.log(SatelliteIcon1NOAA20);
  /*---------------*/
  /*update checktime*/
  setInterval(function () {
    // console.log(SatelliteIcon1NOAA20);
    // console.log(SatelliteIcon1NOAA20);
    for (i in SatelliteIcon1NOAA20._layers) {
      mymap3.removeLayer(SatelliteIcon1NOAA20._layers[i]);
    }

  }, 1000);

  /*------------------------------update updateSatelliteNOAA18-----------------------*/


  setInterval(function () {
    updateSatelliteNOAA15();
    updateSatelliteNOAA18();
    updateSatelliteNOAA20();

  }, 1000);
</script>


@stop