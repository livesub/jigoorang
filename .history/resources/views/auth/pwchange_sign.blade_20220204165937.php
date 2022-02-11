@extends('layouts.head')

@section('content')


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="">비밀번호 재설정</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area_01">
            <h2>비밀번호 재설정</h2>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 비밀번호 재설정 시작  -->
            <div class="pw_reset">

                <!-- 비밀번호 재설정 컨텐츠 시작 -->
                <div class="pw_reset_wrap">
                  <div class="text_04">
                    <h2>새 비밀번호 입력</h2>
                    <div class="text_02 wt-nm">
                        비밀번호 재설정은 5분 이내에 재설정해 주세요. <br>
                        5분 후 재설정 시 다시 재설정 링크를 받으셔야 합니다.
                  </div>
                  </div>
                  <div class="line_14-100"></div>


                    <form form name="chagePw" id="changePw" method='POST' action='{{ route('resetPw') }}' role='form' class='form__auth' onsubmit="return check_submit()">
                    {!! csrf_field() !!}
                    <input name='user_pw' id='user_pw' type='password' class='@error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder="비밀번호 입력(영문,숫자,특문조합 8~20자(%$?^()제외)">
                    @error('user_pw')
                        <span role='alert'>{{ $message }}</span>
                    @enderror

                    <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='@error('user_pw_confirmation') is-invalid @enderror' placeholder="위 비밀번호를 다시 입력해 주세요">
                    @error('user_pw_confirmation')
                        <span role='alert'>{{ $message }}</span>
                    @enderror

                    <input type="hidden" value="{{ $code }}" id="code" name="code">
                    <input type="hidden" value="{{ url()->full() }}" id="url_code" name="url_code">
                    <!-- <button type="button">url 파라미터 시간 측정</button> -->

                    <button type="submit" class="btn-full-login">변경</button>
                    </form>
                </div>

                </div>
                <!-- 비밀번호 재설정 컨텐츠 끝 -->
            </div>

        <!-- 비밀번호 재설정 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->
@endsection

@section('script')
    <script>
        //비밀번호 정규식
        var regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,20}$/;

        function get_query(){
            var url = document.location.href;
            var qs = url.substring(url.indexOf('?') + 1).split('&');
            for(var i = 0, result = {}; i < qs.length; i++){
                qs[i] = qs[i].split('=');
                result[qs[i][0]] = decodeURIComponent(qs[i][1]);
            }
            return result;
        }

        $result_params = get_query(location.search);
        //console.log($result_params.expires);
        $int_time = parseInt($result_params.expires);
        //$time_1 = date('y-m-d-H-i-s', $int_time);
        //$time_1 = date('Y-m-d H:i:s', $int_time);
        var myDate = new Date($int_time * 1000)
        //console.log(myDate);
        //console.log("Date: "+myDate.getDate()+
        //  "/"+(myDate.getMonth()+1)+
        //  "/"+myDate.getFullYear()+
        //  " "+myDate.getHours()+
        //  ":"+myDate.getMinutes()+
        //  ":"+myDate.getSeconds());
        //현재 시간 구하기
        var current_time = new Date();

        //console.log("현재 시간 : "+current_time);
        //제한 시간이 지날 경우의 예외처리 추가
        function check_submit(){
            var current_time = new Date();
            var user_pw = $('#user_pw').val();
            var user_pw_confirmation = $('#user_pw_confirmation').val();

            if(current_time > myDate){
                //시간 경과 시 return false
                alert('재설정 제한시간이 5분이 지나서 \n다시 링크를 받아서 변경 진행해 주세요');
                return location.href="{{ route('failed_time_limit') }}";
            }else{
                //시간이 안지났으면 유효성 검사
                if(user_pw == "" || user_pw == null){
                    alert('비밀번호를 입력해 주세요.');
                    $("#user_pw").focus();
                    return false;
                }

                if(regPw.test(user_pw) !== true){
                    alert('비밀번호 형식이 잘못되었습니다.');
                    $("#user_pw").focus();
                    return false;
                }

                if(user_pw != user_pw_confirmation){
                    alert('위의 비밀번호와 동일한 비밀번호를 입력하세요.');
                    $("#user_pw_confirmation").focus();
                    return false;
                }

                return true;
            }
        }
    </script>
@endsection