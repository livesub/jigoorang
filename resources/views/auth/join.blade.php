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

        <!-- 회원가입 시작  -->
            <div class="join">

                <!-- 회원가입 컨텐츠 시작 -->
                <div class="join_wrap">
                  <div class="text_04">
                    <h2>정보입력</h2>
                  </div>
                  <div class="line_14 bk"></div>
                  <form action='{{ route('join.store') }}' method='POST' role='form' class='join_form' onsubmit="return check_submit()">
                  {!! csrf_field() !!}

                <div class="join_input_box_01">
                  <input name='user_phone' id='user_phone' type='text' class='@error('user_phone') is-invalid @enderror' value='{{ old('user_phone') }}' placeholder="휴대전화 번호를 '-' 없이 입력하세요." onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                  <button type="button" onclick="send_sms()" id="sms_send" class="btn-20">인증번호받기</button>
                  <!-- <button type="button" class="btn-20-active">인증번호받기</button> -->
                  <input name='phone_certificate' id='phone_certificate' type='text' class='@error('phone_certificate') is-invalid @enderror' value='' placeholder="인증번호를 입력하세요">
                  <button type="button" onclick="check_ctf_number()" id="check_ctf" class="btn-20">인증번호확인</button>
                  <span id="countdown"></span>

                  <div class="solid"></div>
                </div>

                <div class="join_input_box_02">
                  <input name='user_id' id='user_id' type='email' class='@error('user_id') is-invalid @enderror ' value='{{ old('user_id') }}' placeholder="아이디로 사용 할 이메일 주소를 입력해 주세요">

                  @error('user_id')
                      <span role='alert'>{{ $message }}</span>
                  @enderror

                  <input name='user_pw' id='user_pw' type='password' class='@error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder="비밀번호를 입력해 주세요(영문, 숫자, 특수문자 조합 8~20자(%$?^()제외)">

                  @error('user_pw')
                      <span role='alert'>{{ $message }}</span>
                  @enderror

                  <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='@error('user_pw_confirmation') is-invalid @enderror' placeholder="비밀번호를 다시 입력해 주세요(영문, 숫자, 특수문자 조합 8~20자(%$?^()제외)">

                  @error('user_pw_confirmation')
                      <span role='alert'>{{ $message }}</span>
                  @enderror
                </div>

                <div class="join_input_box_03">
                  <input name='user_name' id='user_name' type='text' class='@error('user_name') is-invalid @enderror' value='{{ old('user_name') }}' placeholder="이름을 입력하세요(10자 이내)">

                  @error('user_name')
                      <span role='alert'>{{ $message }}</span>
                  @enderror

                  <input name='user_birth' id='user_birth' type='text' class='@error('user_birth') is-invalid @enderror' value='{{ old('user_birth') }}' onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="생년월일을 입력하세요. 예)820724">

                  @error('user_birth')
                      <span role='alert'>{{ $message }}</span>
                  @enderror


                    <div class="join_btn_box">
                        <input type="hidden" id="old_user_gender" value="{{ old('user_gender') }}">
                        <label class="box-radio-input">
                            <input type="radio" name="user_gender" value="M" id="user_gender_m" class='@error('user_gender') is-invalid @enderror'>
                            <span>남</span>
                        </label>
                        <label class="box-radio-input">
                            <input type="radio" name="user_gender" value="W" id="user_gender_w" class='@error('user_gender') is-invalid @enderror'>
                            <span>여</span>
                        </label>
                    </div>

                </div>

                <input name='phone_certificate_confirmation' id='phone_certificate_confirmation' type='hidden' class='@error('user_pw_confirmation') is-invalid @enderror' value="{{ old('phone_certificate') }}">
                <input name="cookie1" id="cookie1" type="hidden" value="">
                <input name="cookie2" id="cookie2" type="hidden" value="">
                <input name="address" id="address" type="hidden" value="{{ route('auth_certification') }}">
                <input name="checked_ctf" id="checked_ctf" type="hidden" value="">
                <input name="promotion_agree" id="promotion_agree" type="hidden" value="{{ $agree }}">

                    <button type="submit" class="btn-full">가입하기</button>
                  </div>
                  </form>

                </div>

                </div>
                <!-- 회원가입 끝 -->
            </div>

        <!-- 회원가입 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->




  <!-- 쿠키값 암호화를 위한 스크립트 추가 -->
  <script	src="https://cdnjs.cloudflare.com/ajax/libs/js-sha256/0.9.0/sha256.min.js"></script>
  <script>
    var time = 300; //제한시간 설정 (초단위)
    var timer = 0;  //타이머 관한 기초값 0으로 설정
    var return_time = time; //다시 시작 시 시간
  </script>
  <!-- 실질적인 타이머 함수들 정의 -->
  <script	src="{{ mix('js/timer.js') }}"></script>
  <script>
    //핸드폰 번호 정규식
    var regPhone = /^01([0|1|6|7|8|9])([0-9]{3,4})([0-9]{4})$/;
    //이메일 정규식
    var regEmail = /^([\w\.\_\-])*[a-zA-Z0-9]+([\w\.\_\-])*([a-zA-Z0-9])+([\w\.\_\-])+@([a-zA-Z0-9]+\.)+[a-zA-Z0-9]{2,8}$/;
    //비밀번호 정규식
    var regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@!*#&])[A-Za-z\d@!*#&]{8,20}$/;
    //var regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,20}$/;
    //생년월일 정규식
    var regBirth = /([0-9]{2}(0[1-9]|1[0-2])(0[1-9]|[1,2][0-9]|3[0,1]))/;
    //이름 정규식
    var regName = /^[가-힣a-zA-Z]{2,50}$/;

    var address = $('#address').val();

    //암호화를 쓰기 위한 secret 코드 선언
    var sk = "!q2q@";
    //암호화
    var sk1 = sha256('certification');
    //var test1234 = sha256('num');
    var sk2 = sha256('num');
    var cookie_value1 = "";
    var cookie_value2 = "";
  //var value = "";
  window.onload = function() { // window.addEventListener('load', (event) => {와 동일합니다.
    // var decrypted1 = CryptoJS.AES.decrypt(getCookie(sk1), sk);
    // var certification = decrypted1.toString(CryptoJS.enc.Utf8);
    // var decrypted2 = CryptoJS.AES.decrypt(getCookie(sk2), sk);
    // var num = decrypted2.toString(CryptoJS.enc.Utf8);


    // console.log(certification);
    // console.log(num);

    var user_gender = $("#old_user_gender").val();
    // if((num != "" && num != undefined) && (certification != "" && certification != undefined)){
    //   $("#user_phone").val(num);
    //   $("#user_phone" ).prop('readonly', true);
    //   $("#sms_send" ).prop('disabled', true);
    // }

    if(user_gender == 'M'){
      $("#user_gender_m" ).prop('checked', true);
    }else if(user_gender == 'W'){
      $("#user_gender_w" ).prop('checked', true);
    }
  };

  //인증번호 보내기
  function send_sms(){
    var user_phone = $('#user_phone').val();

    if(user_phone == "" || user_phone == null){
      alert("{{ __('auth.empty_phone_number') }}");
      return false;
    }else if(regPhone.test(user_phone) !== true) {
      alert("{{ __('auth.failed_phone_reg') }}");
      return false;
    }

    $.ajax({
      //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
      headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')},
      type: 'post',
      url: address,
      dataType: 'json',
      data: { user_phone : user_phone },
      success: function(result) {
        if(result[0].result_code == "1"){
          //시작할때마다 그 시간으로 초기화
          time = return_time;
          start_timer('countdown', 1);
          // document.getElementById("countdown").innerHTML = $result_timer+"내에 입력해주세요";
          //console.log(time);
          alert("{{ __('auth.success_sms_send') }}");
          //console.log(result[0]);
          //쿠키를 굽기전에 암호화해 정보 숨기기 (숨길 값, 시크릿 코드)
          cookie_value1 = CryptoJS.AES.encrypt(result[0].rand_num, sk);
          cookie_value2 = CryptoJS.AES.encrypt(user_phone, sk)
          setCookie(sk1.toString(), cookie_value1, 1);
          setCookie(sk2.toString(), cookie_value2, 1);
          //복호화 (복호화할 값, 시크릿 코드)
          var decrypted1 = CryptoJS.AES.decrypt(getCookie(sk1), sk);
          var text1 = decrypted1.toString(CryptoJS.enc.Utf8);
          var decrypted2 = CryptoJS.AES.decrypt(getCookie(sk2), sk);
          var text2 = decrypted2.toString(CryptoJS.enc.Utf8);
          //콘솔로 확인하는 부분
          //console.log(text1);
          //console.log(text2);
          //그에 따른 태그 설정값 변경
          $("#user_phone" ).prop('readonly', true);
          $("#sms_send" ).prop('disabled', true);
          $("#phone_certificate" ).prop('readonly', false);
          $("#check_ctf" ).prop('disabled', false);
        }else if(result[0] == '2'){
          alert("{{ __('auth.already_reg_number') }}");
        }else{
          alert("{{ __('auth.failed_send_sms') }}");
          //console.log(result[0]);
        }
      },
      error: function(request,status,error) {
        //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      }
    });

  }
  //값 보내기
  function check_submit(){
    var auth = $("#phone_certificate").val();
    var cookie_certification = CryptoJS.AES.decrypt(getCookie(sk1), sk).toString(CryptoJS.enc.Utf8);
    var cookie_num = CryptoJS.AES.decrypt(getCookie(sk2), sk).toString(CryptoJS.enc.Utf8);
    var user_id = $('#user_id').val();
    var user_pw = $("#user_pw").val();
    var user_pw_con = $("#user_pw_confirmation").val();
    var user_name = $("#user_name").val();
    var user_birth = $("#user_birth").val();
    var user_phone = $("#user_phone").val();
    var user_gender = $('input[name=user_gender]:checked').val();
    var checked_ctf = $('#checked_ctf').val();
    //var phone_certificate = $("#phone_certificate").val();

    if(user_id == null || user_id == "" || regEmail.test(user_id) !== true){
      alert('아이디로 사용 할 이메일 주소를 입력해 주세요');
      $('#user_id').focus();
      return false;
    }

    //pw
    if(user_pw == null || user_pw == "" || regPw.test(user_pw) != true){
      alert('비밀번호를 입력해 주세요(영문, 숫자, 특수문자 조합 8~20자(%$?^()제외)');
      $("#user_pw").focus();
      return false;
    }

    //pw_con
    if(user_pw_con == null || user_pw_con == "" || regPw.test(user_pw_con) !== true || user_pw != user_pw_con){
      alert('비밀번호를 다시 입력해 주세요(영문, 숫자, 특수문자 조합 8~20자(%$?^()제외)');
      $("#user_pw_confirmation").focus();
      return false;
    }

    //name 길이 10자 제한
    if(user_name == null || user_name == "" || user_name.length > 10 || regName.test(user_name) !== true){
      alert('이름을 확인(입력)해 주세요');
      $("#user_name").focus();
      return false;
    }

    //birth
    if(user_birth == null || user_birth == "" || regBirth.test(user_birth) !== true || user_birth.length > 6){
      alert('생년월일을 확인(입력)해주세요');
      $("#user_birth").focus();
      return false;
    }else if(get_age_check() != true){
      alert('가입 연령이 맞지 않습니다.');
      $("#user_birth").focus();
      return false;
    }

    //gender
    if(user_gender == null || user_gender == ""){
      alert("성별을 확인(입력)해 주세요");
      $("#old_user_gender").focus();
      return false;
    }

    //phone
    if(user_phone == null || user_phone == "" || regPhone.test(user_phone) !== true || user_phone.length > 11){
      alert("휴대폰 번호를 확인(입력)해 주세요");
      $("#user_phone").focus();
      return false;
    }

    //phone_certificate
    if(auth == null || auth == ""){
      alert("{{ __('auth.phone_check') }}");
      $("#user_phone").focus();
      return false;
    }else if(auth != cookie_certification){
      alert("{{ __('auth.faild_certification_number') }}");
      $("#phone_certificate").focus();
      return false;
    }

    //checked_ctf
    if(checked_ctf == null || checked_ctf == "" || checked_ctf != '1'){
      alert('인증 확인 필요합니다.');
      $('#checked_ctf').focus();
      return false;
    }

    //submit true or false
    if(auth == ""){
      alert('인증번호를 입력해주세요');
      $("#phone_certificate").focus();
      return false;
    }else if(cookie_certification == "" || cookie_num == ""){
      alert('인증번호를 받아 주세요');
      $("#phone_certificate").focus();
      //인증 후에도 시간초과로 없을 경우 다시 받게 초기화 시키기
      //태그 설정 해제
      $("#user_phone" ).prop('readonly', false);
      $("#sms_send" ).prop('disabled', false);
      $("#user_phone" ).prop('readonly', false);
      $("#sms_send" ).prop('disabled', false);

      return false;

    }else if(user_phone != cookie_num){
      alert('인증받은 번호를 입력해주세요');
      $("#phone_certificate").focus();
      return false;

    }else if(auth != "" && cookie_certification != "" && auth == cookie_certification && user_phone != "" && user_phone == cookie_num){

      var result = email_check(); //값을 얻기 위해서 동기식으로 진행
      //console.log(result);
      if(result == "true"){
        $("#phone_certificate_confirmation").val(cookie_certification);
        //$("#cookie1").val(sk1);
        //$("#cookie2").val(sk2);
        return true;
      }else{
        alert('중복된 이메일 입니다.');
        $("#user_id").focus();
        return false;
      }

    }else{
        alert("{{ __('auth.faild_certification_number') }}");
        $("#phone_certificate").focus();
        return false;
    }
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
    $('#checked_ctf').val('');
  }

  //이메일 중복확인 관련 ajax 함수
  function email_check(){
    var user_id = $("#user_id").val();
    var check_result = "";
    if(regEmail.test(user_id) !== true || user_id == ""){
      alert("{{ __('auth.id_check')}}");
      return false;
    }else{
      //ajax구현
      $.ajax({
        //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
        headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')},
        type: 'post',
        url: "{{ route('check_email') }}",
        dataType: 'json',
        data: { user_id : user_id },
        async : false, //submit에서 값이 필요하기 때문에 동기식으로 전환
        success: function(result) {
          if(result[0] == "true"){
            //console.log("성공 : 사용가능 이메일"+result);
            check_result = "true";

          }else{
            //console.log("실패 : 중복된 이메일"+result);
            //return "false";
            check_result = "false";

          }
        },
        error: function(request,status,error) {
          //console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
      });
    }
    return check_result;
  }

  //인증 확인 버튼 관련 함수
  function check_ctf_number(){
    //인증확인 시 저장 값과 확인 후 같을 경우 막기
    var phone_certificate = $("#phone_certificate").val();
    var phone_number = $("#user_phone").val();
    var cookie_certification = CryptoJS.AES.decrypt(getCookie(sk1), sk).toString(CryptoJS.enc.Utf8);
    var number_certification = CryptoJS.AES.decrypt(getCookie(sk2), sk).toString(CryptoJS.enc.Utf8);

    if(phone_number == ""){
      alert('휴대전화번호를 먼저 입력해주세요');
      $("#user_phone").focus();
      return false;
    }

    if(phone_certificate == "" && cookie_certification == ""){
      alert('인증 번호를 입력 해주세요');
      $("#phone_certificate").focus();
      return false;
    }

    if(phone_number != number_certification){
      alert('잘못된 번호 입니다. \n인증을 받은 번호를 입력해주세요');
      $("#phone_certificate").focus();
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
      $("#phone_certificate").focus();
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
  });

  //만나이 체크
  function get_age_check(){
    var r_age = "";
    var user_birth = $("#user_birth").val();
    if(user_birth == ""){
      alert('잘못된 생년월일 입니다.');
      $("#user_birth").focus();
      return false;
    }
    age = get_age(user_birth);
    //console.log("만 나이 : "+age);

    if(age < 14){
      //alert('만 14세 미만 입니다. \n확인해주세요');
      return false;
    }else{
      return true;
    }
  }
</script>













@endsection

