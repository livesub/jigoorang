@extends('layouts.head')

@section('content')


  <form name="flogin" id="flogin" method='POST' action='{{ route('login.store') }}' role='form' class='form__auth' onsubmit="return submit_check()">
    {!! csrf_field() !!}
    <input type="hidden" name="url" id="url" value="{{ $url }}">

    <div class='page-header'>
      <h4>
        {{ $title_login }}
      </h4>
    </div>


    <div class='form-group'>
      @if(isset($_COOKIE['id_remember']) && $_COOKIE['id_remember'] != "")
        <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value="{{ $_COOKIE['id_remember'] }}" placeholder='{{ $user_id }}' autofocus>
      @else
        <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value="{{ old('user_id') }}" placeholder='{{ $user_id }}' autofocus>
      @endif
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
      <div class='checkbox'>
        <label>
          <input type='checkbox' name='remember' value='{{ old('remember', 1) }}' checked>
          {{ $remember }}
          <span class='text-danger'>
            {{ $remember_help }}
          </span>
        </label>
      </div>
    </div>

    <div class='form-group'>
      <div class='checkbox'>
        <label for="id_remember">
          @if(isset($_COOKIE['id_remember']))
            <input type='checkbox' name='id_remember' value="{{ old('id_remember', 1) }}" checked>
          @else
            <input type='checkbox' name='id_remember' value="{{ old('id_remember', 1) }}">
          @endif
          <span class='text-danger'>
              아이디 기억하기
          </span>
        </label>
      </div>
    </div>

    <div class='form-group'>
      <button class='btn btn-primary btn-lg btn-block' type='submit'>
        {{ $submit_login }}
      </button>
    </div>

    <div>
      <p class='text-center'>
        <!-- {!! trans($ask_registration, ['url' => route('join.create','url='.urlencode($url))]) !!} -->
      </p>

      <p class='text-center'>
        <!-- {!! trans($ask_forgot, ['url' => route('pwchange.index')]) !!} -->
      </p>

      <p class='text-center'>
        <a href="{{ route('findIdPwView')}}">@lang('auth.findIdPw')</a>
      </p>

    </div>

    <div>
      <!-- <p class='text-center'>
        <button type="button" onclick="location.href='{{ route('social.login','google') }}'">구글 로그인</button>
      </p> -->

      <p class='text-center'>
        <button type="button" onclick="location.href='{{ route('social.login','kakao') }}'">카카오 로그인</button>
      </p>

      <p class='text-center'>
        <button type="button" onclick="location.href='{{ route('social.login','naver') }}'">네이버 로그인</button>
      </p>

      <!-- <p class='text-center'>
        <button type="button" onclick="location.href='{{ route('social.login','facebook') }}'">페이스북 로그인</button>
      </p> -->
    </div>
</form>
<table>
  <tr><td>지구랭이 처음이신가요? <a href="{{ route('join.create_agree') }}">회원가입하기</a></td></tr>
</table>
<!-- 쇼핑몰 비회원 처리 -->
    @if (preg_match("/orderform/", $url))
  <form name="login_order_form" id="login_order_form" method='get' action='{{ route('orderform') }}'>
    <section id="mb_login_notmb">
        <h2>비회원 구매</h2>
        <p>비회원으로 주문하시는 경우 포인트는 지급하지 않습니다.</p>

        <div id="guest_privacy">
            약관 우짜구....
        </div>

		<div class="chk_box">
			<input type="checkbox" id="agree" value="1" class="selec_chk">
        	<label for="agree"><span></span> 개인정보수집에 대한 내용을 읽었으며 이에 동의합니다.</label>
		</div>

        <div class="btn_confirm">
            <a href="javascript:guest_submit(document.login_order_form);" class="btn_submit">비회원으로 구매하기</a>
        </div>

        <script>
        function guest_submit(f)
        {
            if (document.getElementById('agree')) {
                if (!document.getElementById('agree').checked) {
                    alert("개인정보수집에 대한 내용을 읽고 이에 동의하셔야 합니다.");
                    return;
                }
            }

            //f.url.value = "{{ $url }}";
            f.action = "{{ route('orderform') }}";
            f.submit();
        }
        </script>
    </section>
</form>
    @endif
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
      alert('아이디(이메일주소)를 입력 하세요.');
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
      alert('비밀번호 형식이 아닙니다. 다시 입력해 주세요');
      return false;
    }

    return true;
  }
  </script>


@endsection