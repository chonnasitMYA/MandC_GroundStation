@extends('layout') @section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
<div class="sixteen wide column">
	<div class="ui segment">

		<div class="ui grey inverted segment">
			<h2>ประวัติการเคลื่อนที่เสาอากาศ</h2>
		</div>
		<br>

		<form action="{{ route('Project.findControl') }}" method="post" class="ui form segment">
			<h4 class="ui dividing header">วันเวลาที่ต้องการค้นหา</h4>
			<div class="three fields">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="inline fields">
					<label>เวลาเริ่มต้น</label>
					<div class="ui calendar" id="Startcalendar" style="width: 80% ;margin-left:5px">
						<div class="ui left icon input" style="width: 90%">
							<input type="text" name="StartDate" id="StartDate" value="<?php echo date('d/m/Y'); ?>">
							<i class="calendar icon"></i>
						</div>
					</div>
				</div>
				<div class="inline fields">
					<label>เวลาสิ้นสุด</label>
					<div class="ui calendar" id="Endcalendar" style="width: 80% ;margin-left:5px">
						<div class="ui left icon input" style="width: 90%">
							<input type="text" name="EndDate" id="EndDate" value="<?php echo date('d/m/Y'); ?>">
							<i class="calendar icon"></i>
						</div>
					</div>
				</div>
				<div class="inline fields">
					<button class="ui black button" style="width:100%">ค้นหา</button>
				</div>

			</div>
		</form>


		<table class="ui celled table" id="example">


			<thead>
				<th style="width: 12.5%">
					<center>Date</center>
				</th>
				<th style="width: 12.5%">
					<center>Satellite</center>
				</th>
				<th style="width: 12.5%">
					<center>เวลาที่รับ</center>
				</th>
				<th style="width: 12.5%">
					<center>เวลาสิ้นสุด</center>
				</th>
				<th style="width: 12.5%">
					<center>การเคลื่อนที่เสาอากาศ</center>
				</th>
				<th style="width: 10%">
					<center>Start
						<br> Azimuth</center>
				</th>
				<th style="width: 10%">
					<center>Start
						<br> Elevation</center>
				</th>
				<th style="width: 17.5%">
					<center>รายละเอียด</center>
				</th>



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

							echo $dataspilt[1].' '.$dataspilt[2];
							?>
						</center>
					</td>
					<td>
						<center>
							<?php 
							$dataspilt = explode(" ", $Data->timestop);
							echo $dataspilt[1].' '.$dataspilt[2];
							?>
						</center>
					</td>
					<td>
						<center>
							@if($Data->status=='N')
							<i class=" red huge calendar times outline icon"></i>
							@else
							<i class=" green huge calendar check outline icon"></i>
							@endif
						</center>
						<td>
							<center>
								{{$Data->control[0]['azimuth']}}
							</center>
						</td>
						<td>
							<center>
								{{$Data->control[0]['elevation']}}
							</center>
						</td>
						<td>
							<center>
								<form action="{{ route('Project.schedulecontrol') }}" method='post'>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="id" value="{{ $Data->_id }}">
									<button class='ui green button' style="width: 70%" type='submit'>ดูรายระเอียด</button>
								</form>
							</center>
						</td>

				</tr>
				@endforeach
			</tbody>
		</table>

	</div>
	<br>


</div>
<script type="text/javascript">
	$('#example').DataTable();
</script>
<script type="text/javascript" src="/js/date.js"></script>


@stop