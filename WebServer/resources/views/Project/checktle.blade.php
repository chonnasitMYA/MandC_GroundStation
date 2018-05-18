<?php
// $url = "https://www.celestrak.com/NORAD/elements/noaa.txt";
// $ch = curl_init();
// $timeout = 5;
// curl_setopt($ch,CURLOPT_URL,$url);
// curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
// curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
// $data = curl_exec($ch);
// curl_close($ch);
// echo $data;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.celestrak.com/NORAD/elements/noaa.txt");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// $output is the requested page's source code
$output = curl_exec($ch);
curl_close($ch);
echo $output;
?>