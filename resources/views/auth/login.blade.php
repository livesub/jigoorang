@extends('layouts.head')

@section('content')


    <!-- 메인 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('login.index') }}">로그인</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area_01">
            <h2>로그인</h2>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 로그인 시작  -->
            <div class="login">

                <!-- 로그인 컨텐츠 시작 -->
                <div class="login_wrap">
                  <div class="text_03">
                    <h3>이메일 로그인</h3>
                  </div>

                  <form name="flogin" id="flogin" method='POST' action='{{ route('login.store') }}' role='form' class='form__auth' onsubmit="return submit_check()">
                  {!! csrf_field() !!}

                  @if(isset($_COOKIE['id_remember']) && $_COOKIE['id_remember'] != "")
                    <input name='user_id' id='user_id' type='email' class='@error('user_id') is-invalid @enderror login_input' value="{{ $_COOKIE['id_remember'] }}" placeholder="아이디(이메일 주소)를 입력하세요." autofocus>
                  @else
                    <input name='user_id' id='user_id' type='email' class='@error('user_id') is-invalid @enderror login_input' value="{{ old('user_id') }}" placeholder="아이디(이메일 주소)를 입력하세요." autofocus>
                  @endif

                    <input name='user_pw' id='user_pw' type='password' class='@error('user_pw') is-invalid @enderror login_input' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'>
                    <button type="submit" class="btn-full-login">로그인</button>
                    <div class="checkbox_login">

                  @if(isset($_COOKIE['id_remember']))
                    <input type='checkbox' name='id_remember' value="{{ old('id_remember', 1) }}" checked>
                  @else
                    <input type='checkbox' name='id_remember' value="{{ old('id_remember', 1) }}" checked>
                  @endif

                    <label for="아이디저장">아이디저장</label>
                    <input type='checkbox' name='remember' value='{{ old('remember', 1) }}' checked><label for="로그인 상태 유지">로그인 상태 유지</label>
                    <a href="{{ route('findIdPwView')}}" class="ip_find">아이디 / 비밀번호 찾기</a>
                  </div>
                  </form>

                  <div class="text_02">
                    <h3>SNS 로그인</h3>
                    <div class="sns_login">
                    <a href="{{ route('social.login','kakao') }}"><button type="button" class="btn-full-kakao">카카오 로그인</button></a>
                    <a href="{{ route('social.login','naver') }}"><button type="button" class="btn-full-naver">네이버 로그인</button></a>
                    {{-- <span>지구랭이 처음이신가요?
                    <a href="{{ route('join.create_agree') }}">회원가입하기</a></span> --}}

                    <div class="mt-30"> <span>지구랭이 처음이신가요?<span>
                      <div class="btn_3ea mt-20 flx">
                        <a href="{{ route('social.login','kakao') }}"><button class="btn-30">이메일로<br>회원가입</button></a>
                        <a href="{{ route('social.login','kakao') }}">
                        <button class="btn-30-kakao">카카오로<br>회원가입</button>
                        </a>
                        <a href="{{ route('social.login','kakao') }}">
                        <button class="btn-30-naver">네이버로<br>회원가입</button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>

                </div>
                <!-- 로그인 컨텐츠 끝 -->
            </div>

        <!-- 로그인 끝  -->



    </div>
    <!-- 메인 컨테이너 끝 -->

<script>
  //이메일 정규식
  var regEmail = /^([\w\.\_\-])*[a-zA-Z0-9]+([\w\.\_\-])*([a-zA-Z0-9])+([\w\.\_\-])+@([a-zA-Z0-9]+\.)+[a-zA-Z0-9]{2,8}$/;
    //비밀번호 정규식
  var regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,20}$/;
  //로그인 시 예외처리
  function submit_check(){
    var user_id = $('#user_id').val();
    var user_pw = $('#user_pw').val();

    if(user_id == "" || user_id == null){
      alert('아이디(이메일 주소)를 입력 하세요.');
      return false;
    }

    if(user_pw == "" || user_pw == null){
      alert('비밀번호를 입력 하세요.');
      return false;
    }

    if(regEmail.test(user_id) !== true){
      alert('이메일 형식이 아닙니다. 다시 입력해 주세요');
      return false;
    }

    if(regPw.test(user_pw) !== true){
      alert('비밀번호 형식에 맞게 다시 입력해 주세요\n영문,숫자,특수문자 조합 8~20자 (% $ ? 제외)');
      return false;
    }

    return true;
  }
  </script>


@endsection