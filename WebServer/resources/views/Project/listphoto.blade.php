@extends('layout') @section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
<div class="sixteen wide computer sixteen wide tablet sixteen wide mobile column">
	<div class="ui segment">
		<div class="ui clearing grey inverted segment">
			@if(Auth::check()) @if(Auth::user()->type=='admin' )
			<div class="ui right floated  inverted grey button AddPhoto" style="padding: .5em 1.5em .5em;">อัพโหลดรูปภาพ</div>
			@endif @endif
			<div class="ui left">
				<h2>คลังข้อมูลรูปภาพ</h2>
			</div>


		</div>
		<br>

		<form action="{{ route('Project.listfindPhoto') }}" method="post" class="ui form segment">

			<h4 class="ui dividing header">ค้นหารูปภาพ</h4>

			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="two fields">
				<div class="inline fields ">

					<label>Satellite&nbsp;Name&nbsp;:</label>
					<div class="ui selection dropdown myDropdown selectSatellite" style="width: 100% ">
						<input type="hidden" name="SatelliteName" value="All">
						<i class="dropdown icon"></i>
						<div class="default text">All</div>
						<div class="menu" ">
							@foreach($listTLE as $Item)
							<div class="item " data-value="{{$Item->name}}">{{$Item->name}}</div>
						@endforeach
						<div class="item" data-value="All">All</div>
					</div>
					<div class="Other"></div>
				</div>


			</div>
			<div class="inline fields ">
				<label style="margin-left: 10px">ช่วงเวลา&nbsp;</label>
				<div class="ui selection dropdown selectDurations" style="width: 80%">
					<input type="hidden" name="Durations" value="All">
					<i class="dropdown icon"></i>
					<div class="default text">All</div>
					<div class="menu">
						<div class="item" data-value="All">ทั้งหมด</div>
						<div class="item" data-value="Durations">เวลาเริ่มต้น - เวลาสิ้นสุด</div>
					</div>
					<div class="Other"></div>
				</div>
			</div>


	</div>


	<div class="three fields">
		<div class="inline fields" style="margin-left:10px;">
			<label>เวลาเริ่มต้น</label>
			<div class="ui calendar" id="Startcalendar" style="width: 80% ;margin-left:5px">
				<div class="ui left icon input" style="width: 80%">
					<input type="text" name="StartDate" id="StartDate" value="<?php echo date('d/m/Y'); ?>">
					<i class="calendar icon"></i>
				</div>
			</div>
		</div>
		<div class="inline fields" style="margin-left:10px;">
			<label>เวลาสิ้นสุด</label>
			<div class="ui calendar" id="Endcalendar" style="width: 80% ;margin-left:5px">
				<div class="ui left icon input" style="width: 80%">
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
	<script type="text/javascript">
		$('.selectSatellite').dropdown('set selected', '{{$data[0]}}');
		$('.selectDurations').dropdown('set selected', '{{$data[1]}}');
	</script>


	<table class="ui celled table" id="example">


		<thead>
			<th>
				<center>Satellite</center>
			</th>
			<th>
				<center>Date Acquired</center>
			</th>
			<th>
				<center>Time Acquired</center>
			</th>
			<th>
				<center>รายละเอียด</center>
			</th>

			<th>
				<center>ลบรูปภาพ</center>
			</th>



		</thead>
		<tbody>
			@foreach($listPhoto as $Data)
			<tr>

				<td>
					<center>{{$Data->SatelliteName}}</center>
				</td>
				<td>
					<center>
						{{$Data->DateAcquired}}
					</center>
				</td>
				<td>
					<center>
						{{$Data->TimeAcquired}}
					</center>
				</td>
				<td>
					<center>
						<button class='ui green button ShowPhoto' id="photopath" data-PathValue="{{ $Data->path }}" style="width: 70%" type='submit'>ดูรูปภาพ</button>
					</center>
				</td>
				<td>
					<center>
						<form action="{{ route('Project.deletephoto') }}" method='post'>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $Data->id }}">
							<button class='ui red button' style="width: 70%" type='submit'>ลบ</button>
						</form>
					</center>
				</td>

			</tr>
			@endforeach
		</tbody>
	</table>

</div>

</div>





<div class="ui basic modal " id="ShowPhoto" style="z-index: 250 !important;">
	<i class="close icon"></i>


	<center>
		<img class="image" id='fullImage' style="width: 70% ;height: auto">
	</center>




</div>

<div class="ui modal" id="AddPhoto" style="z-index: 250 !important;">
	<i class="close icon"></i>
	<div class="header">
		เพิ่มรูปภาพ
	</div>
	<div class="content">
		<form action="{{ route('Project.AddPhoto')}}" class="ui form" method="post" enctype="multipart/form-data">

			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="inline fields container">
				<div class="sixteen wide field">

					<label>Satellite&nbsp;Name&nbsp;:</label>
					<div class="ui selection dropdown myDropdown" style="width: 100%">
						<input type="hidden" id="SatelliteNameAdd" name="SatelliteName" value="-">
						<i class="dropdown icon"></i>
						<div class="default text">SatelliteName</div>
						<div class="menu">
							@foreach($listTLE as $Item)
							<div class="item" data-value="{{$Item->name}}">{{$Item->name}}</div>

							@endforeach

						</div>
						<div class="Other"></div>
					</div>
				</div>
			</div>
			<div class="inline fields container">
				<div class="sixteen wide field">
					<label>Enhancement&nbsp;:&nbsp;&nbsp;</label>
					<input type="text" name="Enhancement">
				</div>
			</div>
			<div class="inline fields container">
				<div class="sixteen wide field">
					<label>Date&nbsp;Acquired&nbsp;:</label>
					<div class="ui calendar" name="DateAcquired" id="DateAcquired" style="width: 100%">
						<div class="ui left icon input">
							<input type="text" name="DateAcquired" value="<?php echo date('d/m/Y'); ?>">
							<i class="calendar icon"></i>
						</div>
					</div>

				</div>
			</div>
			<div class="inline fields container">
				<div class="sixteen wide field">
					<label>Time&nbsp;Acquired&nbsp;:</label>
					<input type="time" name="TimeAcquired" value="00:00">
				</div>
			</div>
			<div class="inline fields container">
				<div class="sixteen wide field">
					<label> รูปภาพ </label>
					<input type="file" name="photo" id="photo" value="" accept="image/*">
				</div>
			</div>


			<center>
				<div class="actions">
					<div class="ui black deny button">
						ยกเลิก
					</div>
					<button class="ui positive right labeled icon button" id="SubmitAddPhoto" type="submit">
						บันทึก
						<i class="checkmark icon"></i>
					</button>


				</div>
			</center>
		</form>
	</div>
</div>

<script type="text/javascript" src="/js/date.js"></script>
<script type="text/javascript">
	$('#example').DataTable();

	$(document).on('click', '.AddPhoto', function () {

		$('#AddPhoto').modal({
			onShow: function () {
				$('#DateAcquired').calendar({
					type: 'date',
					monthFirst: false,
					formatter: {
						date: function (date, settings) {
							if (!date) return '';
							var day = ("0" + date.getDate()).slice(-2);
							var month = ("0" + (date.getMonth() + 1)).slice(-2);
							var year = date.getFullYear();
							return day + '/' + month + '/' + year;
						}
					}
				});
			},
			onApprove: function () {
				return false; //block the modal here
			}

		}).modal('show');
	});
	$(document).on('click', '.ShowPhoto', function () {
		console.log('sss');
		var path = ($(this).data('pathvalue'));


		$("#fullImage").attr("src", path);
		$('#ShowPhoto').modal('show');
	});


	$('.actions').on('click', '#SubmitAddPhoto', function () {


		console.log($('#SatelliteNameAdd').val());
		if ($('#SatelliteNameAdd').val() == '-') {

			$.uiAlert({
				textHead: "ชื่อดาวเทียม ไม่ถูกต้อง", // header
				text: '', // Text
				bgcolor: '#DB2828', // background-color
				textcolor: '#fff', // color
				position: 'top-center', // position . top And bottom ||  left / center / right
				icon: 'remove circle', // icon in semantic-UI
				time: 3, // time
			})
			return false;
		}
		if (document.getElementById("photo").files.length == 0) {
			$.uiAlert({
				textHead: "โปรดเลือกรูปภาพ", // header
				text: '', // Text
				bgcolor: '#DB2828', // background-color
				textcolor: '#fff', // color
				position: 'top-center', // position . top And bottom ||  left / center / right
				icon: 'remove circle', // icon in semantic-UI
				time: 3, // time
			})
			return false;
		}
	});
</script>
@stop
