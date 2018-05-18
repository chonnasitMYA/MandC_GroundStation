@extends('layout') @section('content')
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

		<form action="{{ route('Project.findPhoto') }}" method="post" class="ui form segment">

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
	<br>

	<div class="ui four stackable link cards ">
		@foreach($listPhoto as $Item)
		<div class="card">

			<div class="image ShowPhoto" id="photopath" data-PathValue="{{ $Item->path }}">
				<img src="{{ $Item->path }}" style="  height: 25em; ">
			</div>
			<div class="content">
				<div class="header">{{ $Item->SatelliteName }}</div>

				<div class="description">
					Enhancement : {{ $Item->Enhancement }}
					<br> Date Acquired: {{ $Item->DateAcquired }}
					<br> Time Acquired:{{ $Item->TimeAcquired }}
					<br>
					<a href="{{ $Item->path }}" download>
						<i class="download icon"></i>Download</a>
				</div>
			</div>

		</div>
		@endforeach
	</div>
</div>







<div class="ui basic modal" id="ShowPhoto" style="z-index: 250 !important;">
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