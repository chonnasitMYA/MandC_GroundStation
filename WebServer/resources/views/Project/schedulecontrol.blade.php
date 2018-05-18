@extends('layout') @section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
<div class="sixteen wide column">
	<div class="ui segment">

		<div class="ui grey inverted segment">
			<h2>เวลาการขับเคลื่อนเสาอากาศ : {{ $listdata->namesatellite }} </h2>
		</div>
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

				@foreach( ($listdata->control) as $data)
				<tr>
					<td>
						<center>
							<?php 
							$dataspilt = explode(" ", $data['time']);
							$dataspilt2 = explode("/", $dataspilt[0]);
							echo $dataspilt2[1].'/'.$dataspilt2[0].'/'.$dataspilt2[2];
							?>

						</center>
					</td>
					<td>
						<center>
							<?php 
							$dataspilt = explode(" ", $data['time']);
							echo $dataspilt[1].' '.$dataspilt[2];
							?>

						</center>
					</td>
					<td>
						<center>
							{{$data['azimuth']}}

						</center>
					</td>
					<td>
						<center>
							{{$data['elevation']}}

						</center>
					</td>

				</tr>
				@endforeach

			</tbody>

		</table>

	</div>

</div>

<script type="text/javascript" src="/js/date.js"></script>


<script type="text/javascript">
	$('#example').DataTable();
</script>

@stop