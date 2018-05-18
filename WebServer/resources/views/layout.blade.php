  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="stylesheet" type="text/css" href="/css/mystyles.css">
    <link rel="stylesheet" href="/css/leaflet/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="/css/L.Control.MousePosition.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.13/semantic.min.css">
    <link rel="stylesheet" href="/semantic-ui-calendar/dist/calendar.css" />
    <link rel="stylesheet" type="text/css" href="/pace-1.0.2/themes/blue/pace-theme-loading-bar.css">
    
    <script type="text/javascript" src="/pace-1.0.2/pace.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/semantic-ui-calendar/dist/calendar.js"></script>
    <script src="/css/leaflet/leaflet.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/satellite.js/1.3.0/satellite.min.js"></script>
    <script type="text/javascript" src="/satellite-js-master/dist/satellite.min.js"></script>
    <script src="/satellite-js-master/dist/satellite.js"></script>
    <script src="/satellite-js-master/sgp4_verification/lib/angular/angular.js"> </script>
    <script type="text/javascript" src="/css/L.Control.MousePosition.js"></script>
    <script type="text/javascript" src="/Semantic/semantic.min.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript" src="/js/date.js"></script>
    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script src="https://cdn.rawgit.com/hayeswise/Leaflet.PointInPolygon/v1.0.0/wise-leaflet-pip.js"></script>

    <link rel="stylesheet" type="text/css" href="/Aitthi-semanticUiAlert/Semantic-UI-Alert.css">
    <script type="text/javascript" src="/Aitthi-semanticUiAlert/Semantic-UI-Alert.js"></script>
    
    <link rel="shortcut icon" href="{{ asset('photo/logo.png') }}">
    <title>Monitoring and Antenna Control Web Application</title>
  </head>
  <body>
    <div class="ui grid">
      <div class="computer tablet only row">
        <div class="ui inverted menu main-nav">
          @if(Auth::check())

          <a href="{{ route('Project.dashboard') }}" >
            <div class="navbar-header">
              <img src="{{ asset('photo/gistdalogoMain.png') }}" class="photologo">
            </div>
          </a>
          @else
          <a href="{{ route('Project.index') }}" >
            <div class="navbar-header">
              <img src="{{ asset('photo/gistdalogoMain.png') }}" class="photologo">
            </div>
          </a>
          @endif
          <div class="right menu">

            <div class="ui pointing dropdown link item " style="z-index: 600 !important;">
              <i class="large send icon"></i>ดาวเทียม<i class="dropdown icon"></i>
              <div class="menu">
                <a class="item" href="{{ route('Project.checksatellite') }}">
                  <i class="calendar alternate outline icon"></i>ตรวจสอบการเข้าถึงของดาวเทียม
                </a>
                <a class="item" href="{{ route('Project.position') }}">
                  <i class="rocket icon"></i>ตำแหน่งดาวเทียม
                </a> 


              </div>
            </div>

            <div class="ui pointing dropdown link item " style="z-index: 600 !important;">
              <i class="large inverted archive icon"></i>คลังข้อมูล<i class="dropdown icon"></i>
              <div class="menu">
                <a class="item" href="{{ route('Project.PhotoGallery') }}"><i class="photo icon"></i>คลังรูปภาพ</a>
                <a class="item" href="{{ route('Project.SoundArchive') }}"><i class="signal icon"></i>คลังเสียง</a>
                @if(Auth::check())
                
                <a class="item" href="{{ route('Project.logCollection') }}"><i class="list layout icon"></i>ประวัติการรับสัญาณ</a>
                <a class="item" href="{{ route('Project.listphoto') }}"><i class="file image outline icon"></i>จัดการรูปภาพ</a>
                <a class="item" href="{{ route('Project.listsound') }}"><i class="file audio outline icon"></i>จัดการเสียง</a>
                @endif
              </div>
            </div>
            @if(Auth::check())
            
            <div class="ui pointing dropdown link item " style="z-index: 600 !important;">
              <i class="large settings icon"></i>จัดการระบบ<i class="dropdown icon" ></i>
              <div class="menu">

                <a class="item" href="{{ route('Project.control') }}">
                  <i class="large rss icon"></i>ตั้งค่าเสาอากาศล่วงหน้า
                </a>
                <a class="item" href="{{ route('Project.tle') }}">
                  <i class="large rocket icon"></i>จัดการดาวเทียม (TLE)
                </a>
                <a class="item" href="{{ route('Project.member') }}">
                  <i class="large users icon"></i>สมาชิก
                </a>


              </div>
            </div>
            
            @endif



            @if(Auth::check())

            <div class="ui pointing dropdown link item " style="z-index: 600 !important;">
              <i class="large inverted blue user circle outline icon"></i>{{ Auth::user()->name }}<i class="dropdown icon"></i>
              <div class="menu">

                <a class="item editProfilelogin" data-id="{{ Auth::user()->id }}" data-name="{{ Auth::user()->name }}"  data-email="{{ Auth::user()->email }}"  data-phonenumber="{{ Auth::user()->PhoneNumber }}"><i class="edit icon"></i>แก้ไขข้อมูลส่วนตัว</a>
                <a class="item" id="editpassword"><i class="settings icon"></i>เปลี่ยนPassword</a>
                <a class="item" href="GuideManual.pdf" download><i class="warning sign icon"></i>คู่มือแนะนำการใช้เว็ปไซต์</a>
                <a class="item" href="{{ route('Project.logout') }}"><i class="sign out icon"></i>ออกจากระบบ</a>
              </div>
            </div>


            @endif
            @if(Auth::check()==false)
            <a class="item" href="{{ route('Project.login') }}">
              <i class="large sign in icon"></i>login
            </a>
            @endif
          </div>


        </div>
      </div>

      <div class="mobile only row">
        <div class="ui fixed inverted menu navbar menu-nav" style="position: fixed; z-index: 3000 !important" >
         @if(Auth::check())

         <a href="{{ route('Project.dashboard') }}" >
          <div class="navbar-header">
            <img src="{{ asset('photo/gistdalogoMain.png') }}" class="photologo">
          </div>
        </a>
        @else
        <a href="{{ route('Project.index') }}" >
          <div class="navbar-header">
            <img src="{{ asset('photo/gistdalogoMain.png') }}" class="photologo">
          </div>
        </a>
        @endif
        <div class="right menu open ">
          <a  class="menu item" id="menubar">
            <i class="sidebar large icon" ></i>
          </a>
        </div>
      </div>

      <div class="ui bottom attached segment pushable">
        <div class="ui inverted labeled  vertical sidebar menu">
          <a href="{{ route('Project.dashboard') }}" >
            <div class="navbar-header">
              <center><img src="{{ asset('photo/gistdalogoMain.png') }}" class="photologo2"></center>
            </div>
          </a>
          
          <div class="ui item ">
            <div class="text " id="hideShowSatellite"><i class="large send icon"></i>ดาวเทียม</div>
            <div class="menu">
              <div id="hideSatellite" >
                <a class="item" href="{{ route('Project.checksatellite') }}">
                  <i class="calendar alternate outline icon"></i>ตรวจสอบการเข้าถึงของดาวเทียม
                </a>
                <a class="item" href="{{ route('Project.position') }}">
                  <i class="rocket icon"></i>ตำแหน่งดาวเทียม
                </a>

              </div>
            </div>

          </div>
          
          <div class="ui item ">
            <div class="text " id="hideShowphoto"><i class="large archive icon"></i>คลังข้อมูล</div>
            <div class="menu">
              <div id="hidePhoto" >
                <a class="item" href="{{ route('Project.PhotoGallery') }}">
                  <i class="photo icon"></i>คลังรูปภาพ
                </a>
                <a class="item" href="{{ route('Project.SoundArchive') }}">
                  <i class="signal icon"></i>คลังเสียง
                </a>
                @if(Auth::check())
                
                <a class="item" href="{{ route('Project.logCollection') }}">
                  <i class="list layout icon"></i>ประวัติการรับสัญาณ
                </a>
                
                @endif
              </div>
            </div>

          </div>
          @if(Auth::check())

          <div class="ui item">
            <div class="text" id="hideShowSetting"><i class="large settings icon"></i>จัดการระบบ
            </div>
            <div class="menu">
              <div id="hideSetting">
                <a class="item" href="{{ route('Project.control') }}">
                  <i class="large rss icon"></i>ตั้งค่าเสาอากาศล่วงหน้า
                </a>
                <a class="item" href="{{ route('Project.tle') }}">
                  <i class="large rocket icon"></i>TLE
                </a>
                <a class="item" href="{{ route('Project.member') }}">
                  <i class="large users icon"></i>สมาชิก
                </a>
                

              </div>
            </div>

          </div>
          @endif

          @if(Auth::check())
          <div class="ui item">
           <div class="text" id="hideShowProfile"><i class="large address card outline icon"></i>{{ Auth::user()->name }}</div>


           <div class="menu">
            <div id="hideProfile">
              <a class="item editProfilelogin" data-id="{{ Auth::user()->id }}" data-name="{{ Auth::user()->name }}"  data-email="{{ Auth::user()->email }}"  data-phonenumber="{{ Auth::user()->PhoneNumber }}"><i class="edit icon"></i>แก้ไขข้อมูลส่วนตัว</a>
              <a class="item" id="editpassword"><i class="settings icon"></i>เปลี่ยนPassword</a>
              <a class="item" href="/admin/guideadmin.pdf" download='guideadmin.pdf'><i class="warning sign icon"></i>คู่มือแนะนำการใช้เว็ปไซต์</a>
              <a class="item" href="{{ route('Project.logout') }}"><i class="sign out icon"></i>ออกจากระบบ</a>
            </div>
          </div>

        </div>
        <br>
          <br>
          <br>
        @endif
        @if(Auth::check()==false)
        <a class="ui item" href="{{ route('Project.login') }}">
          <div class="text "> <i class="large sign in icon"></i>login
          </div>
        </a>

        @endif
      </div>


    </div>
    <br><br>

  </div>

  @if(Auth::check())
  <div class="ui modal" id="editmodal">
    <i class="close icon"></i>
    <div class="header">
      แก้ไขรหัสผ่าน
    </div>

    <div class="content">
      <div class="ui form">
        <div class="inline fields container">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" id="iduser" value="{{ Auth::user()->id }}">
          <div class="two wide field">
            <label>รหัสผ่านเดิม&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="password" id="passwordold">
          </div>
        </div>
        <div class="inline fields container">
          <input type="hidden" id="iduser" value="{{ Auth::user()->id }}">
          <div class="two wide field">
            <label>รหัสผ่านใหม่&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="password" id="passwordedit">
          </div>
        </div>
        <div class="inline fields container">
          <div class="two wide field">
            <label>ยืนยันรหัสผ่าน&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="password"  id="passwordedit2">
          </div>
        </div>
      </div>
    </div>

    <div class="actions">
      <div class="ui black deny button" >
        ยกเลิก
      </div>
      <div class="ui positive right labeled icon button" id="confirmpassword">
        บันทึก
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>

  <div class="ui basic modal" id="message-pass-modal" >
    <i class="close icon"></i>
    <div class="ui icon header">
      <i class="checkmark box icon"></i>
      เปลี่ยนรหัสผ่านสำเร็จ
    </div>
    <div class="content">
      <center>
        <p>โปรดเข้าสู่ระบบด้วยรหัสผ่านใหม่ในครั้งต่อไป</p>
      </center>
    </div>
  </div>
  <div class="ui basic modal" id="editProfilefinish" >
    <i class="close icon"></i>
    <div class="ui icon header">
      <i class="checkmark box icon"></i>
      แก้ไขข้อมูลสำเร็จ
    </div>

  </div>
  <div class="ui modal" id="editProfilelogin">
    <i class="close icon"></i>
    <div class="header">
      แก้ไขข้อมูลส่วนตัว   
      
    </div>
    <div class="content">
      <div class="ui form" >
        <div class="inline fields container">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" id="iduserlogin" value="" >
          <div class="two wide field">
            <label>ชื่อ-นามสกุล&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="text"  id="nameuserlogin" required>
          </div>
        </div>
        <div class="inline fields container">
          <div class="two wide field">
            <label>Email&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="email"  id="emaillogin" required>
          </div>
        </div>
        <div class="inline fields container">
          <div class="two wide field">
            <label>เบอร์โทรศัพท์&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="text"  id="phonenumber" maxlength="15" required>
          </div>
        </div>

      </div>
    </div>

    <div class="actions">
      <div class="ui black deny button" >
        ยกเลิก
      </div>
      <div class="ui positive right labeled icon button" id="editsubmitlogin">
        บันทึก
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>

  @endif

  @yield('content')
</div>
<script type="text/javascript">
  $(document).on('click', '#hideShowphoto', function() {
    $("#hidePhoto").toggle('fast');

  });
  $(document).on('click', '#hideShowSatellite', function() {
    $("#hideSatellite").toggle('fast');

  });
  $(document).on('click', '#hideShowSetting', function() {
    $("#hideSetting").toggle('fast');

  });
  $(document).on('click', '#hideShowProfile', function() {
    $("#hideProfile").toggle('fast');

  });
  $(document).on('click', '#menubar', function() {

    $('.ui.labeled.sidebar')
    .sidebar('setting', {transition: 'overlay'})
    .sidebar('toggle');

  });

  $(document).ready(function(){


    $(document).on('click', '.editProfilelogin', function() {

      $('#iduserlogin').val($(this).data('id'));
      $('#nameuserlogin').val($(this).data('name'));
      $('#emaillogin').val($(this).data('email'));
      $('#phonenumber').val($(this).data('phonenumber'));
      $('#editProfilelogin').modal('show');
    });
    $('.actions').on('click', '#editsubmitlogin', function() {
      if ( $('#emaillogin').val() == '' ) {

        $.uiAlert({
            textHead: "email ไม่ถูกต้อง", // header
            text: ' กรุณาระบุ email ให้ถูกต้อง', // Text
            bgcolor: '#DB2828', // background-color
            textcolor: '#fff', // color
            position: 'top-center',// position . top And bottom ||  left / center / right
            icon: 'remove circle', // icon in semantic-UI
            time: 3, // time
          })
        return false;
      }
      if( $('#nameuserlogin').val() == '' ){
        $.uiAlert({
            textHead: "ชื่อ-นามสกุล ไม่ถูกต้อง", // header
            text: ' กรุณาระบุ ชื่อ-นามสกุล', // Text
            bgcolor: '#DB2828', // background-color
            textcolor: '#fff', // color
            position: 'top-center',// position . top And bottom ||  left / center / right
            icon: 'remove circle', // icon in semantic-UI
            time: 3, // time
          })
        return false;

      } 
      if( $('#phonenumber').val() == '' ){
        $.uiAlert({
              textHead: "เบอร์โทรศัพท์ไม่ถูกต้อง", // header
              text: ' กรุณาระบุเบอร์โทรศัพท์ให้ถูกต้อง', // Text
              bgcolor: '#DB2828', // background-color
              textcolor: '#fff', // color
              position: 'top-center',// position . top And bottom ||  left / center / right
              icon: 'remove circle', // icon in semantic-UI
              time: 3, // time
            })
        return false;

      }
     $.ajax({
      type: 'post',
      url: '/submitEditProfile',
      data: {
        '_token': $('input[name=_token]').val(),
        'id': $('#iduserlogin').val(),
        'name' : $('#nameuserlogin').val(),
        'PhoneNumber' : $('#phonenumber').val(),
        'email' : $('#emaillogin').val()
      },
      success: function(data) {
        $('#editProfilefinish').modal({
          onHide: function(){
            location.reload();

          },
          onShow: function(){
            console.log('shown');
          }

        }).modal('show');
      },
      error: function(){
        alert('มีemailนี้ในระบบ แล้ว กรุณาใช้email อื่น');
      }

    })

   });

    $(document).on('click', '#editpassword', function() {
      $('#editmodal').modal('show');
    });

    $('.actions').on('click', '#confirmpassword', function() {
      if($('#passwordedit').val()!=$('#passwordedit2').val()){
  
         $.uiAlert({
            textHead: "รหัสผ่านไม่ถูกต้อง", // header
            text: ' กรุณาระบุรหัสผ่านให้เหมือนกันทั้ง2ช่อง', // Text
            bgcolor: '#DB2828', // background-color
            textcolor: '#fff', // color
            position: 'top-center',// position . top And bottom ||  left / center / right
            icon: 'remove circle', // icon in semantic-UI
            time: 3, // time
          })
        return false;
      }else{
        $.ajax({
          type: 'post',
          url: '/settingPassword',
          data: {
            '_token': $('input[name=_token]').val(),
            'id': $('#iduser').val(),
            'password' : $('#passwordedit').val(),
            'passwordold' : $('#passwordold').val()

          },
          success: function(data) {
            console.log(data)
            $('#message-pass-modal').modal('show');
          },
          error: function(){
           
            $.uiAlert({
            textHead: "รหัสผ่านเก่าไม่ถูกต้อง", // header
            text: ' กรุณาระบุรหัสผ่านเก่าให้ถูกต้อง', // Text
            bgcolor: '#DB2828', // background-color
            textcolor: '#fff', // color
            position: 'top-center',// position . top And bottom ||  left / center / right
            icon: 'remove circle', // icon in semantic-UI
            time: 3, // time
          })
          $('#editmodal').modal('show');
          }
        })
      }
    });

  });
  
</script>


</body>

</html>
