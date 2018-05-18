@extends('layout')

@section('content')

<div class="eight wide computer eight wide tablet sixteen wide mobile column  ">
	<div class="ui segment" >
		
			<div  class="" id="mapid" >
			</div>
	<div class="ui negative message">
          <li>ดาวเทียมบางดวงเป็นดาวเทียมที่เคลื่อนที่ช้าหรือดาวเทียมค้างฟ้า</li>
          <li>ท่านสามารถเลื่อนหาตำแหน่งดาวเทียมได้บนแผนที่</li>
		  <li>วงกลมสีแดงคือมุมที่เริ่มรับสัญญาณ</li>
        </div> 
	</div>

</div>

<div class="eight wide computer eight wide tablet sixteen wide mobile column " >
	<div class="ui segment" style="height: 100%">
		<div class="fields box1">
			<div class="ui form">
				<div class="two fields">
					<div class="field" style="display: inline-block;">
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
					<div class="field" style="display: inline-block;">
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
				<table class="ui celled table ">
					<thead>
						<tr>
							<th>Date<br></th>
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

			</div>

		</div>
	</div>
	
	<script type="text/javascript" src="/js/date.js"></script>
	<script type="text/javascript" src="/js/checksatellite.js"></script>
		@stop
