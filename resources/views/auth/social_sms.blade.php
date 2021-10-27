@extends('layouts.head')

@section('content')
    소셜로그인 핸드폰 인증 뷰입니다.
    <form action="{{ route('social_save_member') }}" method='POST' role='form' class='form__auth' onsubmit="return sms_certification()">
        {!! csrf_field() !!}

        <div class='form-group'>
        <input name='user_id' id='user_id' type='hidden' class='form-control @error('user_id') is-invalid @enderror' value="{{ $create_result['user_id'] }}" >
        </div>


        <div class='form-group'>
        <input name='user_pw' id='user_pw' type='hidden' class='form-control @error('user_pw') is-invalid @enderror' value="{{ $create_result['password'] }}" >
        </div>
        
        <div class='form-group'>
        <input name='user_name' id='user_name' type='hidden' class='form-control @error('user_name') is-invalid @enderror' value="{{ $create_result['user_name'] }}" >
        </div>
        

        <div class='form-group'>
        <input name='user_birth' id='user_birth' type='hidden' class='form-control @error('user_birth') is-invalid @enderror' value="{{ $create_result['user_birth'] }}">
        </div>

        <div class='form-group'>
        <input name='user_provider' id='user_provider' type='hidden' class='form-control @error('user_provider') is-invalid @enderror' value="{{ $create_result['user_platform_type'] }}">
        </div>
        
        <div class='form-group'>
        <input name='user_gender' id='user_gender' type='hidden' class='form-control @error('user_gender') is-invalid @enderror' value="{{ $create_result['user_gender'] }}">
        </div>

        <div class='form-group'>
        <input name='user_phone' id='user_phone' type='text' class='form-control @error('user_phone') is-invalid @enderror' value='{{ old('user_phone') }}'>
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
        

        <!-- <div class='form-group'>
        <input name='phone_certificate_confirmation' id='phone_certificate_confirmation' type='hidden' class='form-control @error('user_pw_confirmation') is-invalid @enderror' value="{{ old('phone_certificate') }}">
        </div> -->
        <button type="submit">회원가입</button>
    </form>
    
@endsection

<script>
  var sms_certification_value = "";

  window.onload = function() { // window.addEventListener('load', (event) => {와 동일합니다.
    
    var num = getCookie('social_num');
    var certification = getCookie('social_certification');
    if((num != "" && num != undefined) && (certification != "" && certification != undefined)){
      $("#user_phone").val(num);
      $("#user_phone" ).prop('readonly', true);
      $("#sms_send" ).prop('disabled', true);
    }
  };
  function send_sms(){
    var user_phone = $('#user_phone').val();

    if(user_phone == "" || user_phone == null){

      alert("휴대폰 번호가 비어있습니다. \n확인해주세요");

      return false;
    }

    $.ajax({
      //아래 headers에 반드시 token을 추가해줘야 한다.!!!!! 
      headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')},
      type: 'post',
      url: '{{ route('auth_certification') }}',
      dataType: 'json',
      data: { user_phone : user_phone },
      success: function(result) {
        if(result[0].result_code == "1" ){
          alert('인증문자발송완료 확인 필요합니다.');
          //console.log(result[0]);
          setCookie('social_certification', result[0].rand_num, 1);
          setCookie('social_num', user_phone, 1);
          // console.log(getCookie('social_certification'));
          // console.log(getCookie('social_num'));
          $("#user_phone" ).prop('readonly', true);
          $("#sms_send" ).prop('disabled', true);
        }else if(result[0] == '2'){
          alert('이미 등록된 번호입니다. \n아이디 / 비밀번호 찾기를 이용해주세요');
        }else{
          alert('인증문자전송실패. \n다시시도해주세요');
          console.log(result[0]);
        }
        //console.log(sms_certification_value);
      },
      error: function(request,status,error) {
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      }
    });

  }
  function sms_certification(){
    // alert('들어옴?');
    // return false;
    var phone = $('#user_phone').val();
    var value = $('#phone_certificate').val();
    var sms_certification_value = getCookie('social_certification');
    
    if((value != "" && sms_certification != "") && (value == sms_certification_value && phone != "")){

        //alert('인증번호가 일치 합니다!')

        return true;
    }else if(phone == ""){

        alert("휴대폰 번호가 비어있습니다. \n확인해주세요");

        return false;

    }else{

        alert('인증번호가 일치하지 않습니다.');

        return false;
    }
  }
</script>