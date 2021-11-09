@extends('layouts.head')

@section('content')
    비밀번호 변경 뷰입니다.<br>
    확인해주세요
    <form form name="chagePw" id="changePw" method='POST' action='{{ route('resetPw') }}' role='form' class='form__auth' onsubmit="return check_submit()">
        {!! csrf_field() !!}
        <div class='form-group'>
        <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='@lang('validation.change_pw.common')'>
        </div>
        @error('user_pw')
            <span class='invalid-feedback' role='alert'>
                <strong>{{ $message }}</strong>
            </span>
        @enderror


        <div class='form-group'>
        <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='form-control @error('user_pw_confirmation') is-invalid @enderror' placeholder='@lang('validation.change_pw.confirmed')'>
        </div>
        @error('user_pw_confirmation')
            <span class='invalid-feedback' role='alert'>
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="hidden" value="{{ $code }}" id="code" name="code">
        <input type="hidden" value="{{ url()->full() }}" id="url_code" name="url_code">
        <!-- <button type="button">url 파라미터 시간 측정</button> -->
        <button type="submit">변경하기</button>
    </form>
    
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
        console.log($result_params.expires);
        $int_time = parseInt($result_params.expires);
        //$time_1 = date('y-m-d-H-i-s', $int_time);
        //$time_1 = date('Y-m-d H:i:s', $int_time);
        var myDate = new Date($int_time * 1000)
        console.log(myDate);
        console.log("Date: "+myDate.getDate()+
          "/"+(myDate.getMonth()+1)+
          "/"+myDate.getFullYear()+
          " "+myDate.getHours()+
          ":"+myDate.getMinutes()+
          ":"+myDate.getSeconds());
        //현재 시간 구하기
        var current_time = new Date();

        console.log("현재 시간 : "+current_time);
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
                    alert('값이 없습니다.');
                    return false;
                }

                if(regPw.test(user_pw) !== true){

                    alert('비밀번호 형식이 맞지 않습니다.');

                    return false;
                }

                if(user_pw != user_pw_confirmation){
                    alert('두 비밀번호가 일치하지 않습니다.');

                    return false;
                }

                return true;
            }
        }
    </script>
@endsection