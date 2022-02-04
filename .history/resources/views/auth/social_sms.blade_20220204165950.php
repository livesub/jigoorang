@extends('layouts.head')

@section('content')



<!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('join.create_agree') }}">회원가입</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area_01">
            <h2>회원가입</h2>
        </div>
        <!-- 타이틀 끝 -->

        <!-- sns 회원가입 시작  -->
            <div class="join">

                <!-- sns 회원가입 컨텐츠 시작 -->
                <div class="join_wrap">
                  <div class="text_04">
                    <h2>휴대폰 인증</h2>
                  </div>
                  <div class="line_14-100"></div>
                    <form action="{{ route('social_save_member') }}" method='POST' role='form' class='join_form' onsubmit="return sms_certification()">
                    {!! csrf_field() !!}
                    <input name='user_id' id='user_id' type='hidden' class="@error('user_id') is-invalid @enderror" value="{{ $create_result['user_id'] }}" >
                    <input name='user_pw' id='user_pw' type='hidden' class="@error('user_pw') is-invalid @enderror" value="{{ $create_result['password'] }}" >
                    <input name='user_birth' id='user_birth' type='hidden' class="@error('user_birth') is-invalid @enderror" value="{{ $create_result['user_birth'] }}">
                    <input name='user_provider' id='user_provider' type='hidden' class="@error('user_provider') is-invalid @enderror" value="{{ $create_result['user_platform_type'] }}">

                    <input name="cookie1" id="cookie1" type="hidden" value="">
                    <input name="cookie2" id="cookie2" type="hidden" value="">
                    <input name="cookie3" id="cookie3" type="hidden" value="">
                    <input name="cookie4" id="cookie4" type="hidden" value="">
                    <input name="checked_ctf" id="checked_ctf" type="hidden" value="">
                    <input name='user_gender' id='user_gender' type='hidden' class="@error('user_gender') is-invalid @enderror" value="{{ $create_result['user_gender'] }}">
                    <div class="join_input_box_01">

                        @if($create_result['user_name'] == "")
                        <input name='user_name' id='user_name' type='text' class="@error('user_name') is-invalid @enderror" value="{{ $create_result['user_name'] }}"  placeholder="이름을 입력하세요.">
                        @else
                        <input name='user_name' id='user_name' type='hidden' value="{{ $create_result['user_name'] }}">
                        @endif

                        <input name='user_phone' id='user_phone' type='text' class="@error('user_phone') is-invalid @enderror" value="{{ old('user_phone') }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"  placeholder="휴대전화 번호를 '-' 없이 입력하세요.">
                        @error('user_phone')
                            <span role='alert'>{{ $message }}</span>
                        @enderror
                        <button type="button" onclick="send_sms()" id="sms_send" class="btn-20">인증번호받기</button>
                        <input name='phone_certificate' id='phone_certificate' type='text' class="@error('phone_certificate') is-invalid @enderror" value='' placeholder="@lang('auth.certification_number')" placeholder="인증번호를 입력하세요">
                        <button type="button" onclick="check_ctf_number()" id="check_ctf" class="btn-20">인증 확인</button>
                        <span id="countdown"></span>
                    </div>
                    <button type="submit" class="btn-full">가입하기</button>
                    </form>
                </div>


        </div>

    </div>
    <!-- sns 회원가입 끝 -->
</div>
<!-- sns 회원가입 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->







@section('script')
<script	src="https://cdnjs.cloudflare.com/ajax/libs/js-sha256/0.9.0/sha256.min.js"></script>
<script>
    var time = 300; //제한시간 설정
    var timer = 0;  //타이머 관한 기초값 0으로 설정
    var return_time = time; //다시 시작 시 시간
</script>
<script	src="{{ mix('js/timer.js') }}"></script>
<script>
  //핸드폰 번호 정규식
  var regPhone = /^01([0|1|6|7|8|9])([0-9]{3,4})([0-9]{4})$/;
  //이름 정규식
  var regName = /^[가-힣a-zA-Z]{2,50}$/;
  var sms_certification_value = "";
  var sk = "!q33q@";
  var provider = document.getElementById('user_provider').value;
  //암호화
  var sk1 = sha256('social_certification_'+provider);
  //var test1234 = sha256('num');
  var sk2 = sha256('social_num_'+provider);
  var sk3 = "";
  var sk4 = "";
  if(provider == "kakao"){
    sk3 = sha256('social_certification_naver');
    sk4 = sha256('social_num_naver');
  }else if(provider == "naver"){
    sk3 = sha256('social_certification_kakao');
    sk4 = sha256('social_num_kakao');
  }
  var cookie_value1 = "";
  var cookie_value2 = "";
  window.onload = function() { // window.addEventListener('load', (event) => {와 동일합니다.

    var decrypted1 = CryptoJS.AES.decrypt(getCookie(sk1), sk);
    var certification = decrypted1.toString(CryptoJS.enc.Utf8);
    var decrypted2 = CryptoJS.AES.decrypt(getCookie(sk2), sk);
    var num = decrypted2.toString(CryptoJS.enc.Utf8);
    // var num = getCookie('social_num');
    // var certification = getCookie('social_certification');
    if((num != "" && num != undefined) && (certification != "" && certification != undefined)){
      // $("#user_phone").val(num);
      // $("#user_phone" ).prop('readonly', true);
      // $("#sms_send" ).prop('disabled', true);
    }
  };
  function send_sms(){
    var user_phone = $('#user_phone').val();
    if(user_phone == "" || user_phone == null){
      alert("{{ __('auth.empty_phone_number') }}111111");
      return false;
    }else if(regPhone.test(user_phone) !== true) {
      alert("{{ __('auth.failed_phone_reg') }}");
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
          time = return_time;
          start_timer('countdown', 1);
          alert("{{ __('auth.success_sms_send') }}");
          //console.log(result[0]);
          // setCookie(sk1.toString(), CryptoJS.AES.encrypt(result[0].rand_num, sk), 1);
          // setCookie(sk2.toString(), CryptoJS.AES.encrypt(user_phone, sk), 1);
          //쿠키를 굽기전에 암호화해 정보 숨기기
          cookie_value1 = CryptoJS.AES.encrypt(result[0].rand_num, sk);
          cookie_value2 = CryptoJS.AES.encrypt(user_phone, sk)
          setCookie(sk1.toString(), cookie_value1, 1);
          setCookie(sk2.toString(), cookie_value2, 1);
          //복호화
          var decrypted1 = CryptoJS.AES.decrypt(getCookie(sk1), sk);
          var text1 = decrypted1.toString(CryptoJS.enc.Utf8);
          var decrypted2 = CryptoJS.AES.decrypt(getCookie(sk2), sk);
          var text2 = decrypted2.toString(CryptoJS.enc.Utf8);
          //console.log("test==> "+text1);
          //console.log(text2);
          // setCookie('social_certification', result[0].rand_num, 1);
          // setCookie('social_num', user_phone, 1);
          // console.log(getCookie('social_certification'));
          // console.log(getCookie('social_num'));
          $("#user_phone" ).prop('readonly', true);
          $("#sms_send" ).prop('disabled', true);
        }else if(result[0] == '2'){
          alert("{{ __('auth.already_reg_number') }}");
        }else{
          alert("{{ __('auth.failed_send_sms') }}");
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
    var auth = $("#phone_certificate").val();
    var cookie_certification = CryptoJS.AES.decrypt(getCookie(sk1), sk).toString(CryptoJS.enc.Utf8);
    var cookie_num = CryptoJS.AES.decrypt(getCookie(sk2), sk).toString(CryptoJS.enc.Utf8);

    var user_name = $("#user_name").val();
    var user_phone = $("#user_phone").val();
    var checked_ctf = $('#checked_ctf').val();
    //var phone_certificate = $("#phone_certificate").val();

    //before to submit validate
    //name 길이 10자 제한
    if(user_name == null || user_name == "" || user_name.length > 10 || regName.test(user_name) !== true){
      alert('이름을 입력 해주세요.');
      $("#user_name").focus();
      return false;
    }

    if(auth == null || auth == ""){
      alert('휴대폰 번호를 인증 받으세요.');
      $("#user_phone").focus();
      return false;
    }else{
      if(user_name == ""){
        $("#user_name").focus();
        $("#user_name").show();
      }
    }

    //phone
    if(user_phone == null || user_phone == "" || regPhone.test(user_phone) !== true || user_phone.length > 11){
      alert("{{ __('auth.phone_check') }}");
      $("#user_phone").focus();
      return false;
    }

    //phone_certificate
    if(auth == null || auth == ""){
      alert("{{ __('auth.phone_check') }}");
      return false;
    }else if(auth != cookie_certification){
      alert("{{ __('auth.faild_certification_number') }}");
      return false;
    }

    //checked_ctf
    if(checked_ctf == null || checked_ctf == "" || checked_ctf != '1'){
      alert('인증 확인 필요합니다.');
      return false;
    }

    //submit true or false
    if(auth == ""){
      alert('인증번호를 확인(입력)해주세요');
      return false;
    }else if(cookie_certification == "" || cookie_num == ""){
      alert('인증번호를 받아 주세요');
      //인증 후에도 시간초과로 없을 경우 다시 받게 초기화 시키기
      //태그 설정 해제
      $("#user_phone" ).prop('readonly', false);
      $("#sms_send" ).prop('disabled', false);
      return false;
    }else if(user_phone != cookie_num){
      alert('인증받은 번호를 입력해주세요');
      return false;
    }else if(auth != "" && cookie_certification != "" && auth == cookie_certification && user_phone != "" && user_phone == cookie_num){

      //$("#phone_certificate_confirmation").val(cookie_certification);
      //$("#cookie1").val(sk1);
      //$("#cookie2").val(sk2);
      return true;

    }else{
        alert("{{ __('auth.faild_certification_number') }}");
        return false;
    }
    // alert('들어옴?');
    // return false;
  //   var phone = $('#user_phone').val();
  //   var name = $("#user_name").val();
  //   var value = $('#phone_certificate').val();
  //   var sms_certification_value = CryptoJS.AES.decrypt(getCookie(sk1), sk).toString(CryptoJS.enc.Utf8);
  //   //var sms_certification_value = getCookie('social_certification');

  //   if((value != "" && sms_certification != "") && (value == sms_certification_value && phone != "") && name != "" && name != null){

  //       //alert('인증번호가 일치 합니다!')
  //       // $("#cookie1").val(sk1);
  //       // $("#cookie2").val(sk2);
  //       // $("#cookie3").val(sk3);
  //       // $("#cookie4").val(sk4);
  //       return true;
  //   }else if(phone == "" || name == ""){

  //       alert("{{ __('auth.insert_all_info') }}");

  //       return false;

  //   }else if(regPhone.test(phone) !== true) {

  //     alert("{{ __('auth.failed_phone_reg') }}");

  //     return false;

  //   }else{

  //       alert("{{ __('auth.faild_cerfitication_number') }}");

  //       return false;
  //   }
  }

  //인증 제한 시간 지난 후에 로직 정의
  function return_to_sms(){
    $("#user_phone" ).prop('readonly', false);
    //태그 설정 해제
    $("#sms_send" ).prop('disabled', false);
    //console.log('{{ request()->getHost() }}');
    //쿠키 삭제를 위한 도메인 과 path를 가져와서 보내준다.(즉 인증 관련 정보 삭제)
    deleteCookie(sk1, '{{ request()->getHost() }}', '/');
    deleteCookie(sk2, '{{ request()->getHost() }}', '/');
    deleteCookie(sk3, '{{ request()->getHost() }}', '/');
    deleteCookie(sk4, '{{ request()->getHost() }}', '/');
  }

  //인증 확인 버튼 관련 함수
  function check_ctf_number(){
    //인증확인 시 저장 값과 확인 후 같을 경우 막기
    var phone_certificate = $("#phone_certificate").val();
    var phone_number = $("#user_phone").val();
    var cookie_certification = CryptoJS.AES.decrypt(getCookie(sk1), sk).toString(CryptoJS.enc.Utf8);
    var number_certification = CryptoJS.AES.decrypt(getCookie(sk2), sk).toString(CryptoJS.enc.Utf8);

    if(phone_number == ""){
      alert('번호를 먼저 입력해주세요');
      return false;
    }

    if(phone_certificate == "" && cookie_certification == ""){
      alert('인증 번호를 확인(입력)해주세요');
      return false;
    }

    if(phone_number != number_certification){
      alert('잘못된 번호 입니다. \n인정을 받은 번호를 입력해주세요');
      return false;
    }

    if(phone_certificate == cookie_certification){
      alert('인증이 완료되었습니다.');
      $("#phone_certificate" ).prop('readonly', true);
      $("#check_ctf" ).prop('disabled', true);
      $('#checked_ctf').val('1');
      time_stop('countdown');
      //쿠키값 늘려주기
      setCookie(sk1.toString(), cookie_value1, 10);
      setCookie(sk2.toString(), cookie_value2, 10);
    }else{
      alert('잘못된 인증번호 입니다.');
      return false;
    }
  }

  //새로고침이나 페이지 이동시 쿠키 삭제
  window.addEventListener('beforeunload', (event) => {
      // 명세에 따라 preventDefault는 호출해야하며, 기본 동작을 방지합니다.
      //event.preventDefault();
      // 대표적으로 Chrome에서는 returnValue 설정이 필요합니다.
      //event.returnValue = '';
      //쿠키 삭제를 위한 도메인 과 path를 가져와서 보내준다.(즉 인증 관련 정보 삭제)
      deleteCookie(sk1, '{{ request()->getHost() }}', '/');
      deleteCookie(sk2, '{{ request()->getHost() }}', '/');
      deleteCookie(sk3, '{{ request()->getHost() }}', '/');
      deleteCookie(sk4, '{{ request()->getHost() }}', '/');
  });
</script>


@endsection