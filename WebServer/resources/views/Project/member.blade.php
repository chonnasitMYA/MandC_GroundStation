@extends('layout') @section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.semanticui.min.css">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>

<div class="sixteen wide computer sixteen wide tablet sixteen wide mobile column">
  <div class="ui segment">
    <div class="ui clearing grey inverted segment">
      @if(Auth::check()) @if(Auth::user()->status=='superadmin' )
      <a class="ui right floated  inverted grey button" style="padding: .5em 1.5em .5em;" href="{{ route('Project.register') }}">เพิ่มผู้ดูแลระบบ</a>
      @endif @endif
      <div class="ui left">
        <h2>สมาชิกในระบบ</h2>
      </div>


    </div>

    <br>
    <table class="ui celled table " id="example">
      <thead>
        <tr>
          <th>
            <center>#</center>
          </th>
          <th>
            <center>ชื่อ-นามสกุล</center>
          </th>
          <th>
            <center>Username</center>
          </th>
          <th>
            <center>E-mail</center>
          </th>
          <th>
            <center>เบอร์โทรศัพท์</center>
          </th>
          @if( ( Auth::user()->status=='superadmin' ) )
          <th style="width: 20%;">
            <center>รายละเอียด</center>
          </th>
          <th>
            <center>ลบ</center>
          </th>
          @endif
        </tr>
      </thead>
      <tbody>
        <?php $count=1 ?> @foreach($listuser as $user)
        <tr>
          <td>
            <center> {{$count}}
              <center>
          </td>
          <td>
            <center> {{$user->name}}
              <center>
          </td>
          <td>
            <center> {{$user->username}}
              <center>
          </td>
          <td>
            <center> {{$user->email }}
              <center>
          </td>
          <td>
            <center> {{$user->PhoneNumber}}
              <center>
          </td>
          @if( ( Auth::user()->status=='superadmin' ) )
          <td>
            <center>
              <div class="ui buttons" style="font-size: 10px !important; ">
                <button class="ui green button editProfile" data-id="{{$user->id}}" data-name="{{$user->name}}" data-phonenumber="{{$user->PhoneNumber}}"
                  data-email="{{$user->email}}" style="font-size: 12px !important;">แก้ไขข้อมูล</button>
                <div class="or"></div>
                <button class="ui yellow button editClick" data-id="{{$user->id}}" data-name="{{$user->name}}" data-phonenumber="{{$user->PhoneNumber}}"
                  data-email="{{$user->email}}" style="font-size: 12px !important;">เปลี่ยนPassword</button>
              </div>
              <center>
          </td>
          <td>
            <center>
              <form action="{{ route('Project.deleteuser') }}" method='post'>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $user->id }}">
                <button class='ui red button' style="width: 70%" type='submit'>ลบ</button>
              </form>
              <center>
          </td>
          @endif

        </tr>
        <?php $count++ ?> @endforeach


      </tbody>
    </table>


    <div class="ui negative message">
      <p>หากต้องการเพิ่มผู้ดูแลระบบกรุณาติดตอบสอบถามหัวหน้า</p>
    </div>
  </div>

  <br>
  <br>
  <div class="ui modal" id="editProfile">
    <i class="close icon"></i>
    <div class="header">
      แก้ไขข้อมูล
    </div>
    <div class="content">
      <div class="ui form">
        <div class="inline fields container">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" id="iduserEdit" value="">
          <div class="two wide field">
            <label>ชื่อ-นามสกุล&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="text" id="name" required>
          </div>
        </div>
        <div class="inline fields container">
          <div class="two wide field">
            <label>Email&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="email" id="email" required>
          </div>
        </div>
        <div class="inline fields container">
          <div class="two wide field">
            <label>เบอร์โทรศัพท์&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="text" id="PhoneNumber" maxlength="15" required>
          </div>
        </div>

      </div>
    </div>
    <div class="actions">
      <div class="ui black deny button">
        ยกเลิก
      </div>

      <div class="ui positive right labeled icon button" id="confirm">
        บันทึก
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>

  <div class="ui modal" id="editPasswordUser">
    <i class="close icon"></i>
    <div class="header">
      แก้ไขรหัสผ่าน
      <div class="nameUser"></div>
    </div>
    <div class="content">
      <div class="ui form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="iduserPassword" value="">
        <div class="inline fields container">
          <div class="two wide field">
            <label>รหัสผ่านใหม่&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="password" id="passwordNew">
          </div>
        </div>
        <div class="inline fields container">
          <div class="two wide field">
            <label>ยืนยันรหัสผ่าน&nbsp;&nbsp;:</label>
          </div>
          <div class="fourteen wide field">
            <input type="password" id="passwordAgain">
          </div>
        </div>

      </div>
    </div>
    <div class="actions">
      <div class="ui black deny button">
        ยกเลิก
      </div>

      <div class="ui positive right labeled icon button" id="testSubmit">
        บันทึก
        <i class="checkmark icon"></i>
      </div>
    </div>
  </div>

</div>


</div>
<div class="ui basic modal" id="finishPasswordedit">
  <i class="close icon"></i>
  <div class="ui icon header">
    <i class="checkmark box icon"></i>
    เปลี่ยนรหัสผ่าน user สำเร็จ
  </div>

</div>
<div class="ui basic modal" id="finisheditProfile">
  <i class="close icon"></i>
  <div class="ui icon header">
    <i class="checkmark box icon"></i>
    แก้ไขข้อมูล user สำเร็จ
  </div>

</div>
<script type="text/javascript">
  $('#example').DataTable();
  $(document).on('click', '.editProfile', function () {


    $('#iduserEdit').val($(this).data('id'));
    $('#name').val($(this).data('name'));
    $('#email').val($(this).data('email'));
    $('#PhoneNumber').val($(this).data('phonenumber'));
    $('#editProfile').modal('show');
  });

  $('.actions').on('click', '#confirm', function () {

    if ($('#email').val() == '') {

      $.uiAlert({
        textHead: "email ไม่ถูกต้อง", // header
        text: ' กรุณาระบุ email ให้ถูกต้อง', // Text
        bgcolor: '#DB2828', // background-color
        textcolor: '#fff', // color
        position: 'top-center', // position . top And bottom ||  left / center / right
        icon: 'remove circle', // icon in semantic-UI
        time: 3, // time
      })
      return false;
    }
    if ($('#name').val() == '') {
      $.uiAlert({
        textHead: "ชื่อ-นามสกุล ไม่ถูกต้อง", // header
        text: ' กรุณาระบุ ชื่อ-นามสกุล', // Text
        bgcolor: '#DB2828', // background-color
        textcolor: '#fff', // color
        position: 'top-center', // position . top And bottom ||  left / center / right
        icon: 'remove circle', // icon in semantic-UI
        time: 3, // time
      })
      return false;

    }
    if ($('#PhoneNumber').val() == '') {
      $.uiAlert({
        textHead: "เบอร์โทรศัพท์ไม่ถูกต้อง", // header
        text: ' กรุณาระบุเบอร์โทรศัพท์ให้ถูกต้อง', // Text
        bgcolor: '#DB2828', // background-color
        textcolor: '#fff', // color
        position: 'top-center', // position . top And bottom ||  left / center / right
        icon: 'remove circle', // icon in semantic-UI
        time: 3, // time
      })
      return false;

    }

    $.ajax({
      type: 'post',
      url: '/editProfile',
      data: {
        '_token': $('input[name=_token]').val(),
        'id': $('#iduserEdit').val(),
        'name': $('#name').val(),
        'email': $('#email').val(),
        'PhoneNumber': $('#PhoneNumber').val()

      },
      success: function (data) {
        $('#finisheditProfile').modal({
          onHide: function () {
            location.reload();

          },
          onShow: function () {
            console.log('shown');
          }

        }).modal('show');


      }
    })

  });
  $(document).on('click', '.editClick', function () {
    $('#iduserPassword').val($(this).data('id'));
    $('#editPasswordUser').modal('show');
  });

  $('.actions').on('click', '#testSubmit', function () {
    if (($('#passwordNew').val() != $('#passwordAgain').val()) || ($('#passwordNew').val() == '') || ($(
        '#passwordAgain').val() == '')) {
      $.uiAlert({
        textHead: "รหัสผ่านไม่ถูกต้อง", // header
        text: ' กรุณาระบุรหัสผ่านให้เหมือนกันทั้ง2ช่อง', // Text
        bgcolor: '#DB2828', // background-color
        textcolor: '#fff', // color
        position: 'top-center', // position . top And bottom ||  left / center / right
        icon: 'remove circle', // icon in semantic-UI
        time: 3, // time
      })
      return false;
    } else {
      $.ajax({
        type: 'post',
        url: '/editPasswordUser',
        data: {
          '_token': $('input[name=_token]').val(),
          'password': $('#passwordNew').val(),
          'id': $('#iduserPassword').val(),


        },
        success: function (data) {
          $('#finishPasswordedit').modal({
            onHide: function () {
              location.reload();

            },
            onShow: function () {
              console.log('shown');
            }

          }).modal('show');


        }
      })
    }

  });
</script>
@stop
