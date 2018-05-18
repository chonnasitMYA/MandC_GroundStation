@extends('layout') @section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
<div class="sixteen wide computer sixteen wide tablet sixteen wide mobile column ">
	<div class="ui segment">
		<div class="ui grey inverted segment">
			<div class="ui left">
				<h2>รับสัญญาณจากดาวเทียม {{ $namesatellite }}</h2>
			</div>
		</div>
		<br>
		<div class="ui segment">
			<div id="backhtml"></div>
			<div class="ui accordion">
				<div class='ui' style="display: inline-block; width: 49%">
					<center>
						<form action="{{ route('Project.settimecontrol') }}" method='post'>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="namesatellite" value="{{ $namesatellite }}">
							<input type="hidden" name="timestart" value="{{ $timestart }}">
							<input type="number" id="timestart" name="timestamp" value="{{ $timestamp }}" style="display: none;">
							<input type="hidden" name="status" value="N">
							<input type="hidden" name="control" value="{{ $data }}">
							<button class='ui green button submitData' style="width: 95%" type='submit'>ยืนยันการตั้งค่าเสาอากาศ</button>
						</form>


					</center>
				</div>

				<div class="title" style="display: inline-block;width: 49%">
					<center>
						<button class='ui black button' style="width: 95%" type='submit'>ดูรายละเอียด
							<i class="icon dropdown"></i>
						</button>
					</center>
				</div>

				<div class="content field">
					<table class="ui celled structured table " id="example">
						<thead>
							<tr>
								<th style="width: 25%">
									<center>Date</center>
								</th>
								<th style="width: 25%">
									<center>Time</center>
								</th>
								<th style="width: 25%">
									<center>Azimuth</center>
								</th>
								<th style="width: 25%">
									<center>Elevation</center>
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach($arraylist as $data)
							<tr>
								<td>
									<center>
										{{$data[0]}}

									</center>
								</td>
								<td>
									<center> {{$data[1]}}</center>
								</td>
								<td>
									<center> {{$data[2]}}</center>
								</td>
								<td>
									<center> {{$data[3]}}</center>
								</td>
							</tr>
							@endforeach

						</tbody>

					</table>
				</div>
			</div>

		</div>
	</div>

</div>

<script type="text/javascript">
	$('#example').DataTable();
	$('.ui.accordion')
		.accordion();

	$(document).on('click', '.submitData', function () {

		var timestart = $('#timestart').val();
		var timestartparseInt = parseInt(timestart);
		var datenow = new Date();
		var checktime = datenow.getTime();

		if (timestartparseInt < checktime) {
			$.uiAlert({
				textHead: "ไม่สามารถตั้งค่าได้เนื่องจากเลยเวลามาแล้ว", // header
				text: '', // Text
				bgcolor: '#DB2828', // background-color
				textcolor: '#fff', // color
				position: 'top-center', // position . top And bottom ||  left / center / right
				icon: 'remove circle', // icon in semantic-UI
				time: 3, // time

			})
			$("#removebutton").remove();
			$('#backhtml').append(
				"<div id='removebutton'><center> <form method='get' action='{{ route('Project.control') }}'><button  class='ui red button submit' style='width: 100%' >ย้อนกลับ</button></form></center></div>"
			);


			return false;
		}



	});

	function goBack() {
		window.history.back();
	}
</script>

@stop