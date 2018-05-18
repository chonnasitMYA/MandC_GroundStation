@extends('layout')

@section('content')


<div class="sixteen wide computer sixteen wide tablet sixteen wide mobile column ">
	<div class="ui two column centered grid ">
		<div class=" ui segment column">
			<div class="ui form ">  
				<center>
					@if (session('status'))
					<center>
						<h4 style="color: red">{{ session('status') }}</h4>
					</center>
					@endif
				</center>
				<div class="ui red inverted segment">
					<center>
						<h3> <i class="lock icon"></i> เข้าสู่ระบบ</h3>
					</center>
				</div>

				<br>
				<form action="{{ route('Project.login') }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="field required">
						<label>Username</label>
						<div class="ui left icon input">
							<i class="user icon"></i>
							<!-- <input type="text" name="username" placeholder="username" > -->
							<input type="text" name="username" placeholder="username"  required="" oninvalid="this.setCustomValidity('โปรดใส่ Username')" oninput="setCustomValidity('')">
						</div>
					</div>

					<div class="field required " >
						<label>Password</label>
						<div class="ui left icon input">
							<i class="lock icon"></i>
							<!-- <input type="password" name="password" placeholder="Password" > -->
							<input type="password" name="password" placeholder="Password" required="" oninvalid="this.setCustomValidity('โปรดใส่ Password')" oninput="setCustomValidity('')">
						</div>
					</div>

					<center>
						<h4 style="color: red"></h4>
					</center>
					<div class="ui negative message">
						<li>เฉพาะเจ้าหน้าที่เท่านั้น</li>
						<li>กรุณาตรวจสอบข้อมูลให้ถูกต้อง</li>
						<li>หากลืมรหัสผ่านกรุณาติดต่อผู้ดูแลระบบ</li>



					</div>  
					<center>
						<button class="ui black button item " type="submit" style="width: 50%"><i class="sign in icon"></i>เข้าสู่ระบบ</button>

					</center>
				</form>


			</div>


		</div>
	</div>

</div>


<script type="text/javascript">

	$(document).on('click', '.test', function() {
		$('.ui.labeled.icon.sidebar').sidebar('toggle');
		
	});
</script>

@stop 