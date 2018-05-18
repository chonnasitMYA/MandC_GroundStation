@extends('layout')

@section('content')
<div class="sixteen wide column">
    
    <div class="ui segment container" >
    <div class="ui grey inverted segment" style="background-color:#607d8b">
      <center><h3>เพิ่มผู้ดูแลระบบ</h3></center>
    </div>
      @if (session('status'))
        
      
              <center>
              <h4 style="color: red">{{ session('status') }}</h4>
            </center>
          
       @endif
      
      <form  action="{{ route('Project.createuser') }}" method="post" class="ui form">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <div class="field required">
          <label>ชื่อ-นามสกุล</label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="ชื่อ-นามสกุล" required>
          
        
        </div>
        <div class="field required">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" >
          <span class="help-block"></span>
        </div>
        <input type="hidden" name="type" value="user"  > 
        <div class="field required">
          <label>Username</label>
          <input type="text" name="username" value="{{ old('username') }}" placeholder="Username"  required>
          
        </div>
        <div class="field required">
          <label>สร้างรหัสผ่าน</label>
          <input type="password" name="password" placeholder="สร้างรหัสผ่าน" required>
          
        </div>
        <div class="field required">
          <label>ยืนยันรหัสผ่าน</label>
          <input type="password" name="password_confirmation" placeholder="ยืนยันรหัสผ่าน" required>
          
        </div>
        <div class="field required">
          <label>เบอร์โทรศัพท์</label>
          <input type="text" name="PhoneNumber" placeholder="080-00000000" maxlength="15" required>
          
        </div>
        <div class="ui negative message">
          <li>กรุณณาตรวจสอบข้อมูลให้ถูกต้อง</li>
          <li>กรุณาใส่ชื่อนามสกุลให้ครบถ้วน</li>
          <li>Username จะถูกใช้ในการเข้าสู่ระบบ</li>
          
        
          
        </div>  

      
        <center>
        <button class="ui green button" type="submit">ยืนยันการสมัคร</button>
        </center>
      </form>
    </div>
  
    </div>
  
    <br>
    <br>

@stop