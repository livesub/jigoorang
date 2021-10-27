@extends('layouts.head')

@section('content')
  
  <form action='{{ route('join.store') }}' method='POST' role='form' class='form__auth' onsubmit="return check_submit()">
    {!! csrf_field() !!}
    <input type="hidden" name="url" id="url" value="{{ $url }}">

    <div class='page-header'>
      <h4>
      {{ $title_join }}
      </h4>
    </div>


    <div class='form-group'>
      <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value='{{ old('user_id') }}' placeholder='{{ $user_id }}'>
    </div>
    @error('user_id')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class='form-group'>
      <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'>
    </div>
    @error('user_pw')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror


    <div class='form-group'>
      <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='form-control @error('user_pw_confirmation') is-invalid @enderror' placeholder='{{ $user_pw_confirmation }}'>
    </div>
    @error('user_pw_confirmation')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class='form-group'>
      <input name='user_name' id='user_name' type='text' class='form-control @error('user_name') is-invalid @enderror' value='{{ old('user_name') }}' placeholder='{{ $user_name }}'>
    </div>
    @error('user_name')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class='form-group'>
      <input name='user_birth' id='user_birth' type='date' class='form-control @error('user_birth') is-invalid @enderror' value='{{ old('user_birth') }}'>
    </div>
    @error('user_birth')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <div class='form-group'>
      <input type="hidden" id="old_user_gender" value="{{ old('user_gender') }}">
      <label><input name='user_gender' id='user_gender_m' type='radio' class='form-control @error('user_gender') is-invalid @enderror' value='M'>남성</label>
      <label><input name='user_gender' id='user_gender_w' type='radio' class='form-control @error('user_gender') is-invalid @enderror' value='W'>여성</label>
    </div>
    @error('user_gender')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class='form-group'>
      <input name='user_phone' id='user_phone' type='text' class='form-control @error('user_phone') is-invalid @enderror' value='{{ old('user_phone') }}' placeholder='{{ $user_phone }}'>
    </div>
    @error('user_phone')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <button type="button" onclick="send_sms()" id="sms_send">인증번호 받기</button>

    <div class='form-group'>
      <input name='phone_certificate' id='phone_certificate' type='text' class='form-control @error('phone_certificate') is-invalid @enderror' value='' placeholder="@lang('auth.certification_number')">
    </div>
    @error('phone_certificate')
        <span class='invalid-feedback' role='alert'>
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    

    <div class='form-group'>
      <input name='phone_certificate_confirmation' id='phone_certificate_confirmation' type='hidden' class='form-control @error('user_pw_confirmation') is-invalid @enderror' value="{{ old('phone_certificate') }}">
    </div>
  
    <div class='form-group' style='margin-top: 2em;'>
      <button class='btn btn-primary btn-lg btn-block' type='submit'>
        {{ $submit_join }}
      </button>
    </div>
  </form>

  <script>
    
  //var value = "";
  window.onload = function() { // window.addEventListener('load', (event) => {와 동일합니다.
    
    var num = getCookie('num');
    var certification = getCookie('certification');
    var user_gender = $("#old_user_gender").val();
    if((num != "" && num != undefined) && (certification != "" && certification != undefined)){
      $("#user_phone").val(num);
      $("#user_phone" ).prop('readonly', true);
      $("#sms_send" ).prop('disabled', true);
    }

    if(user_gender == 'M'){
      $("#user_gender_m" ).prop('checked', true);
    }else if(user_gender == 'W'){
      $("#user_gender_w" ).prop('checked', true);
    }
  };
  
  function send_sms(){
    var user_phone = $('#user_phone').val();

    if(user_phone == "" || user_phone == null){

      alert("휴대폰 번호가 비어있습니다. \n확인해주세요");

      return false;
    }

    // $.ajax({
    //   //아래 headers에 반드시 token을 추가해줘야 한다.!!!!! 
    //   headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')},
    //   type: 'get',
    //   url: '{{ route('test_certification') }}',
    //   dataType: 'json',
    //   data: { user_phone : user_phone },
    //   success: function(result) {
    //     if(result[0].result_code == "1" ){
    //       alert('인증문자발송완료 확인 필요합니다.');
    //       console.log(result[0]);
    //     }else{
    //       alert('인증문자전송실패. \n다시시도해주세요');
    //       console.log(result[0]);
    //     }
    //     $('#phone_certificate_confirmation').val(result[0].rand_num);
    //     console.log($('#phone_certificate_confirmation').val());
    //   },
    //   error: function(request,status,error) {
    //     console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
    //   }
    // });

    $.ajax({
      //아래 headers에 반드시 token을 추가해줘야 한다.!!!!! 
      headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')},
      type: 'post',
      url: '{{ route('auth_certification') }}',
      dataType: 'json',
      data: { user_phone : user_phone },
      success: function(result) {
        if(result[0].result_code == "1"){
          alert('인증문자발송완료 확인 필요합니다.');
          console.log(result[0]);
          setCookie('certification', result[0].rand_num, 1);
          setCookie('num', user_phone, 1);
          console.log(getCookie('certification'));
          console.log(getCookie('num'));
          $("#user_phone" ).prop('readonly', true);
          $("#sms_send" ).prop('disabled', true);
        }else if(result[0] == '2'){
          alert('이미 등록된 번호입니다. \n아이디 / 비밀번호 찾기를 이용해주세요');
        }else{
          alert('인증문자전송실패. \n다시시도해주세요');
          console.log(result[0]);
        }
      },
      error: function(request,status,error) {
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      }
    });

  }
  function check_submit(){
    var auth = $("phone_certificate").val();
    var cookie_certification = getCookie('certification');
    
    if(auth == cokie_certification){
      $("phone_certificate_confirmation").val(cookie_certification);
      return true;
    }else{
      alert('인증번호가 틀립니다.');
      return false;
    }
  }
  
</script>
@endsection

