@extends('layouts.head')

@section('content')



    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="/">비밀번호 재설정</a></li>
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
                    <h2>비밀번호 재설정 기간 만료</h2>
                    <div class="text_02 wt-nm">
                      비밀번호 변경 페이지 기간이 만료되었습니다.<br>
                      다시 비밀번호 링크 발송을 진행해 주세요<br>
                      링크 발송 후 5분 이내에 접속하시기 바랍니다.
                  </div>
                  </div>
                  <div class="line_14-100"></div>

                  <div class="pw-timeout">
                    <a href="javascript:page_move()"><button type="button" class="btn-full">아이디/비번 찾기 페이지 이동</button></a>
                  </div>
                </div>

                </div>
                <!-- 비밀번호 재설정 컨텐츠 끝 -->
            </div>

        <!-- 비밀번호 재설정 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->


 <script>
     function page_move(){
        location.href="{{ route('findIdPwView') }}";
     }
 </script>
@endsection