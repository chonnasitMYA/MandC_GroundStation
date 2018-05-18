@extends('layout')
@section('content')
<div class="sixteen wide column">
	<div class="ui grey inverted segment">
		<h2>Dashboard</h2>
	</div>
	


</div>

<div class="eight wide computer eight wide tablet sixteen wide mobile column">
	<div class=" ui segment">
		<div class="ui grey inverted segment">
			<h2>ตารางเวลาการควบคุมเสาอากาศ</h2>
		</div>
		<table class="ui celled table">


			<thead>
				<th><center>Date</center></th>
				<th><center>Satellite</center></th>
				<th><center>Start Time</center></th>
				<th><center>End time </center></th>
				<th><center>Start<br> Azimuth</center></th>
				<th><center>Start<br> Elevation</center></th>

			</thead>
			<tbody>
				@foreach($listControl as $Data)
				<tr>
					<td> 
						<center>
							<?php 
							$dataspilt = explode(" ", $Data->timestart);
							echo $dataspilt[0];
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
							echo ' '.$dataspilt[2];
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


				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<br>
	<br>
	<div class="ui segment" style="height: ">
		<div class="ui grey inverted segment">
			<h2>ประวัติการสั่งการเคลื่อนที่เสาอากาศ/h2>

		</div>
		<div id="highcharts" style=" height: 100%; width: 100%; margin: 0 auto"></div>
	</div>
	
</div>
<div class="eight wide computer eight wide tablet sixteen wide mobile column">
	<div class=" ui segment">
		<div class="ui grey inverted segment">
			<h2>เช็คเวลาการเคลื่อนที่เสาอากาศ</h2>
		</div>
		<div class="ui form">
			<div class="two fields">
				<div class="field" style="display: inline-block;">
					<label>เวลาเริ่มต้น</label>

					<div class="ui calendar" id="Startcalendar">
						<div class="ui left icon input">
							<input type="text" name="StartDate" id="StartDate" onchange="onChangeDateStart()" value="<?php echo date('d/m/Y'); ?>">
							<i class="calendar icon"></i>
						</div>
					</div>
				</div>
				<div class="field" style="display: inline-block; margin-left: 5px">
					<label>เวลาสิ้นสุด</label> 
					<div class="ui calendar" id="Endcalendar">
						<div class="ui left icon input">
							<input type="text" name="EndDate" id="EndDate" onchange="onChangeDateEnd()" value="<?php echo date('d/m/Y'); ?>">
							<i class="calendar icon"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="two fields">
				<div class="field" style="display: inline-block;">
					<label>ดาวเทียม</label>


					<div class="ui selection dropdown testonchange" style="z-index:10 !important">
						<i class="dropdown icon"></i>
						<div class="default text" id="selectSatellite">ดาวเทียม</div>
						<div class="menu">
							@foreach($listTLE as $Item)
							<div class="item" data-line1="{{ $Item->line1 }}" data-line2="{{ $Item->line2 }}" data-_id="{{ $Item->_id }}">{{ $Item->name }}</div>

							@endforeach
						</div>
					</div>
				</div>
				<div class="field" >

					<label><center>คำนวณ  </center></label> 
					<button class="ui red button SubmitCal" style="width: 100%">Submit</button>
					
				</div>

			</div>
		</div>
		<table class="ui celled table ">
			<thead>
				<tr>
					<th>Date</th>
					<th>Start Time</th>
					<th>Start<br> Azimuth</th>
					<th>End <br>Azimuth</th>
					<th>Maximum<br> Elevation</th>
					<th>End time</th>
				</tr></thead>
				<tbody id="tableshow">
				</tbody>

			</table>

		</div>
		<br>
		
		<br>
		<div class="ui segment">
			<div class="ui grey inverted segment ">
				<h2>TLE</h2>
			</div>

			<table class="ui celled table" >


				<thead>
					<th>ชื่อดาวเทียม</th>
					<th>วันที่อัพเดทขอมูล</th>
					<th>อัพเดทข้อมูล</th>
				</thead>
				<tbody>
					@foreach($listTLE as $Item)
					<tr>
						<td class="center aligned">{{ $Item->name }}</td>
						<td class="center aligned">
							<?php 
							$date = date_create($Item->updated_at);
							echo date_format($date, 'd/m/Y H:i:s');
							?>
						</td>
						<td class="center aligned"> 
							<button class="ui yellow button btTLE" data-id="{{$Item->_id }}" data-name="{{ $Item->name }}"  data-line1="{{ $Item->line1 }}" data-line2="{{ $Item->line2 }}">อัพเดท TLE</button>
						</td>
					</tr>
					@endforeach



				</tbody>


			</table>


		</div>
	</div>
	<div class="ui modal" id="updateTLEmodal">
		<i class="close icon"></i>
		<div class="header">
			อัพเดท TLE   
			<div class="nameUser"></div>
		</div>
		<div class="content">
			<form>
				<div class="ui form" >

					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" id="id" >
					<div class="inline fields">
						<div class="two wide field">
							<label>ชื่อดาวเทียม&nbsp;&nbsp;:</label>
						</div>
						<div class="fourteen wide field">
							<input type="text" id="name">
						</div>
					</div>
					<div class="inline fields">
						<div class="two wide field">
							<label>Line1&nbsp;&nbsp;:</label>
						</div>
						<div class="fourteen wide field">
							<input id="line1" type="text" placeholder="1 33591U 09005A   17318.89666673 +.00000092 +00000-0 +75275-4 0  9997" required>

						</div>
					</div>
					<div class="inline fields">
						<div class="two wide field">
							<label>Line2&nbsp;&nbsp;:</label>
						</div>
						<div class="fourteen wide field">

							<input id="line2" type="text" placeholder="2 33591 099.1135 288.0102 0013457 205.4152 154.6359 14.12228622451666" required>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="actions">
			<div class="ui black deny button" >
				ยกเลิก
			</div>
			<div class="ui positive right labeled icon button updateTLE">
				บันทึก
				<i class="checkmark icon"></i>
			</div>
		</div>
	</div>
	<div class="ui basic modal" id="messageEditTLE" >
		<i class="close icon"></i>
		<div class="ui icon header">
			<i class="checkmark box icon"></i>
			อัพเดท TLE สำเร็จ
		</div>
		
	</div>
	<script type="text/javascript" src="/js/date.js"></script>
	<script type="text/javascript" src="/js/dashboard.js"></script>
	<script type="text/javascript">
		// Highcharts.chart('highcharts', {
		// 	chart: {
		// 		plotBackgroundColor: null,
		// 		plotBorderWidth: null,
		// 		plotShadow: false,
		// 		type: 'pie'
		// 	},
		// 	title: {
		// 		text: 'ประวัติการรับสัญญาณ ประจำปี {{$year}}'
		// 	},
		// 	tooltip: {
		// 		pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		// 	},
		// 	plotOptions: {
		// 		pie: {
		// 			allowPointSelect: true,
		// 			cursor: 'pointer',
		// 			dataLabels: {
		// 				enabled: true,
		// 				format: '<b>{point.name}</b>: {point.percentage:.1f} %',
		// 				style: {
		// 					color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		// 				}
		// 			}
		// 		}
		// 	},
		// 	series: [{
		// 		name: 'เปอร์เซ็นการรับ',
		// 		colorByPoint: true,
		// 		data: [{
		// 			name: 'มกราคม',
		// 			y:  {{ $month[0]}}
		// 		}, {
		// 			name: 'กุมภาพันธ์',
		// 			y:  {{ $month[1]}}
		// 		}, {
		// 			name: 'มีนาคม',
		// 			y:  {{ $month[2]}}
		// 		}, {
		// 			name: 'เมษายน',
		// 			y:  {{ $month[3]}}
		// 		}, {
		// 			name: 'พฤษภาคม',
		// 			y:  {{ $month[4]}}
		// 		}, {
		// 			name: 'มิถุนายน',
		// 			y:  {{ $month[5]}}
		// 		}, {
		// 			name: 'กรกฎาคม',
		// 			y:  {{ $month[6]}}
		// 		}, {
		// 			name: 'สิงหาคม',
		// 			y:  {{ $month[7]}}
		// 		}, {
		// 			name: 'กันยายน',
		// 			y: {{ $month[8]}}
		// 		}, {
		// 			name: 'ตุลาคม',
		// 			y:  {{ $month[9]}}
		// 		}, {
		// 			name: 'พฤศจิกายน',
		// 			y:  {{ $month[10]}}
		// 		}, {
		// 			name: 'ธันวาคม',
		// 			y:  {{ $month[11]}}
		// 		}]
		// 	}]
		// });
Highcharts.chart('highcharts', {

    title: {
        text: 'ประวัติการรับสัญญาณ ประจำปี {{$year}}'
    },

    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },

    series: [{
        type: 'pie',
        allowPointSelect: true,
        keys: ['name', 'y', 'selected', 'sliced'],
        data: [
            ['Jan', {{ $month[0]}}, false],
            ['Feb', {{ $month[1]}}, false],
            ['Mar', {{ $month[2]}}, false],
            ['Apr', {{ $month[3]}}, false],
            ['May', {{ $month[4]}}, false],
            ['Jun', {{ $month[5]}}, false],
            ['Jul', {{ $month[6]}}, false],
            ['Aug', {{ $month[7]}}, false],
            ['Sep', {{ $month[8]}}, false],
            ['oct', {{ $month[9]}}, false],
            ['Nov', {{ $month[10]}}, false],
            ['Dec', {{ $month[11]}}, false]
        ],
        showInLegend: true
    }]
});
	</script>



	@stop