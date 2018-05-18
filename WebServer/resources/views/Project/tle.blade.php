@extends('layout')
@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
<div class="sixteen wide  column">
	<div class="ui segment">
		<div class="ui grey inverted segment">
			<h2>ดาวเทียมที่ติดต่อสื่อสาร</h2>
			
		</div>
		@if (session('status2'))


		<center>
			<h2 style="color: red">{{ session('status2') }}</h2>
		</center>

		@endif
		
		<table class="ui celled table " id="example">
			<thead>
				<th class="center aligned four wide" >ชื่อดาวเทียม</th>
				<th class="center aligned four wide" >วันที่อัพเดทขอมูล</th>
				<th class="center aligned two wide" >อัพเดทข้อมูล</th>
				<th class="center aligned two wide" >ลบข้อมูล</th>
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
					<td class="center aligned">
						<form action="{{ route('Project.deleteTle') }}"  method='post'>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="id" value="{{ $Item->_id }}">
							<button class="ui red button ">ลบ</button>
						</form>

					</td>
				</tr>
				@endforeach
				
			</tbody>
		</table>

	</div>
	<br>
	<div class="ui segment">
		<div class="ui grey inverted segment">
			<h2>เพิ่มดาวเทียม</h2>
		</div>
		@if (session('status'))


		<center>
			<h2 style="color: red">{{ session('status') }}</h2>
		</center>

		@endif
		<br>
		<form action="{{ route('Project.addTLE') }}" method="post" enctype="multipart/form-data">
			<div class="ui form">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="ui labeled input " style="width:  100%;">
					<div class="ui label " style="width: 10%;">
					<center>ชื่อดาวเทียม &nbsp;&nbsp;:</center>
					</div>
					<input type="text"  style="width: 90%;" name="name" required oninvalid="this.setCustomValidity('โปรดระบุชื่อดาวเทียม')" oninput="setCustomValidity('')">
				</div>
				<br>
				<br>
				<div class="ui labeled input " style="width:100%;">
					<div class="ui label" style="width:10%;">
					<center>Line 1:</center>
					</div>
					<input type="text" style="width:90%;" placeholder="1 33591U 09005A   17318.89666673 +.00000092 +00000-0 +75275-4 0  9997" name="line1" required oninvalid="this.setCustomValidity('โปรดระบุ Line 1:')" oninput="setCustomValidity('')">
				</div>
				<br>
				<br>
				<div class="ui labeled input " style="width: 100%;">
					<div class="ui label" style="width:10%;">
					<center>Line 2:</center>
					</div>
					<input type="text" style="width:90%;" name="line2" placeholder="2 33591 099.1135 288.0102 0013457 205.4152 154.6359 14.12228622451666" required="" oninvalid="this.setCustomValidity('โปรดระบุ Line 2:')" oninput="setCustomValidity('')">
				</div>
				<br>
				<br>

				<center><button class="ui green button" type="submit" style="width: 200px">Submit</button></center>
			</div>
		</form>
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

	<script type="text/javascript">
		$('#example').DataTable();
		
		$(document).on('click', '.btTLE', function() {

			$('#id').val($(this).data('id'));
			$('#name').val($(this).data('name'));
			$('#line1').val($(this).data('line1'));
			$('#line2').val($(this).data('line2'));


			$('#updateTLEmodal').modal('show');
		});   
		$('.actions').on('click', '.updateTLE', function() {
			if( (($('#line1').val()).length)!=69 || (($('#line2').val()).length)!=69  ){
				alert("กรุณากรอกข้อมูลให้ถูกต้อง");
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



	</script>

	@stop