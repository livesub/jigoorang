@extends('layouts.head')

@section('content')
<script src="{{ asset('/design/js/modal.js') }}"></script>

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('member_info_index') }}">회원정보 수정</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>회원정보 수정</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 평가단 신청 결과 확인 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="list">
                        <div class="information user_list">
                            <h4>회원 정보</h4>
                            <ul class="information-email">
                                <li> 아이디 (이메일 주소)</li>
                                <li> {{ auth()->user()->user_id }}</li>
                            </ul>

                            <ul class="information-name">
                                <li> 이름</li>
                                <li> {{ auth()->user()->user_name }}</li>
                            </ul>
                            {!! csrf_field() !!}
                            <input name="checked_ctf" id="checked_ctf" type="hidden" value="">
                            <ul class="information-phon">
                                <li> 휴대폰</li>
                                <li> <span id="phone_number">{{ auth()->user()->user_phone }}</span></li>
                                <button onclick="phoninputopen_001()">변경</button>
                            </ul>
                            <ul class="information-name">
                                <li> 생년월일</li>
                                <li> {{ auth()->user()->user_birth }}</li>
                            </ul>
                            <ul class="information-name">
                                <li> 성별</li>
                                <li>
                            @if(auth()->user()->user_gender == 'M')
                                남
                            @else
                                여
                            @endif
                                </li>
                            </ul>
                            <ul class="information-phon">
                                <li> 비밀번호</li>
                                <li> ********</li>
                                @if( auth()->user()->user_platform_type == "")
                                <button onclick="pwinputopen_001()">변경</button>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="list">
                        <div class="information checkbox">
                            <h4>서비스 약관 동의</h4>
                        <ul class="checkbox_block">
                        <form action="{{ route('member_info_update_member') }}" method="post" onsubmit="return check_submit()">
                        {!! csrf_field() !!}
                            <li>
                            <!--<input type="checkbox" id="age_over" name="age_over" checked disabled>-->
                            <label for="">만 14세 이상입니다. <span>(필수)</span></label>
                            </li>
                            <li>
                            <!--<input type="checkbox" id="terms_agree" name="terms_agree" checked disabled>-->
                            <a href=""><label for="">약관동의 <span>(필수)</span></label></a><!-- 약관동의 페이지 링크 -->
                            </li>
                            <li>
                            <!--<input type="checkbox" id="pro_agree" name="pro_agree" checked disabled>-->
                            <a href=""><label for="">개인정보 보호방침 <span>(필수)</span></label></a><!-- 개인정보 보호 페이지 링크 -->
                            </li>
                        </form>
                        </ul>
                        </div>
                    </div>
                    <a href="javascript:member_withdraw();"><span class="secession">회원탈퇴</span></a>
                </div>
                <!-- 리스트 끝 -->

            </div>

        </div>
        <!-- 평가단 신청 결과 확인 끝  -->
    </div>
    <!-- 서브 컨테이너 끝 -->


<!-- 휴대폰 번호변경  -->
<div class="modal_005 modal fade">
    <div class="modal-background" onclick=""></div>
        <div class="modal-container num">
            <div class="modal-container-title">
                <h4>휴대전화 번호 변경</h4>
                <div class="btn-close" onclick="phoninputclose_001()"></div>
            </div>

            <div class="modal-container-body num">
                <div class="phonnum_input">
                    <input name='user_phone' id='user_phone' type='text' placeholder="휴대전화 번호를 '-' 없이 입력하세요." onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="11">
                    <button onclick="send_sms()">인증번호 받기</button>

                    <input name='phone_certificate' id='phone_certificate' type='text' placeholder="인증번호를 입력하세요">
                    <button onclick="check_ctf_number()"> 인증확인 </button>
                    <p id="countdown"></p>
                </div>
            </div>


        <div class="btn btn_2ea num">
            <button class="modal_btn01" onclick="phoninputclose_001()">
                닫기
            </button>
            <button class="modal_btn02" onclick="change_phone_number()">
                등록
            </button>
        </div>
 </div>
 </div>
<!-- 휴대폰 번호변경 // 끝 -->


<!-- pw변경  -->
<div class="modal_006 modal fade">
    <div class="modal-background" onclick=""></div>
        <div class="modal-container num pw">
            <div class="modal-container-title">
                <h4>비밀번호 변경</h4>
                <div class="btn-close" onclick="pwinputclose_001()"></div>
            </div>
            <div class="modal-container-body num pw">
                <div class="pw_input">
                    <input type="password" id="user_pw" name="user_pw" placeholder="비밀번호 입력 (영문, 숫자, 특수문자 조합 8~20자(% $ ? 제외))">
                    <p id="pw_error"></p>

                    <input type="password" id="user_pw_confirmation" name="user_pw_confirmation" placeholder="비밀번호를 재입력(위와 같은 비밀번호를 입력해 주세요)">
                    <p id="pw_confirmation_error"></p>
                </div>
            </div>

     <div class="btn btn_2ea num">
         <button class="modal_btn01" onclick="pwinputclose_001()">
             취소
         </button>
         <button class="modal_btn02" type="button" onclick="change_pw()">
             확인
         </button>
     </div>
 </div>
 </div>

<!-- pw변경 // 끝 -->


    <script	src="https://cdnjs.cloudflare.com/ajax/libs/js-sha256/0.9.0/sha256.min.js"></script>
    <script>
        var time = 300; //제한시간 설정 (초단위)
        var timer = 0;  //타이머 관한 기초값 0으로 설정
        var return_time = time; //다시 시작 시 시간
    </script>
    <script	src="{{ mix('js/timer.js') }}"></script>
    <script>
        //비밀번호 정규식
        let regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@!*#&])[A-Za-z\d@!*#&]{8,20}$/;
        //핸드폰 번호 정규식
        let regPhone = /^01([0|1|6|7|8|9])([0-9]{3,4})([0-9]{4})$/;
        //var regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,20}$/;
        //암호화를 쓰기 위한 secret 코드 선언
        let sk = "!q2q@";
        //암호화
        let sk1 = sha256('member_ctf');
        //var test1234 = sha256('num');
        let sk2 = sha256('member_num');
        let cookie_value1 = "";
        let cookie_value2 = "";

        function view_phone(){
            $("#modi_phone_view").show();
        }

        function close_phone(){
            //$("#modi_phone_view").hide();
            //취소 시 발급 받은 쿠키 삭제
            deleteCookie(sk1, '{{ request()->getHost() }}', '/');
            deleteCookie(sk2, '{{ request()->getHost() }}', '/');
            $('#checked_ctf').val('');
            $('#user_phone').val('');
            $('#phone_certificate').val('');

            phoninputclose();
            document.querySelector('.modal.modal_005').classList.remove('in');
        }

        function view_pw(){
            $("#user_pw_view").show();
        }

        function close_pw(){
            //$("#user_pw_view").hide();
            $('#user_pw').val('');
            $('#user_pw_confirmation').val('');
            pwinputclose();
            document.querySelector('.modal.modal_006').classList.remove('in');
        }

        //인증번호 보내기 함수
        function send_sms(){
            var user_phone = $('#user_phone').val();

            if(user_phone == "" || user_phone == null){
                alert("휴대전화 번호를 '-' 없이 입력하세요.");
                $("#user_phone").focus();
                return false;

            }else if(regPhone.test(user_phone) !== true) {
                alert("휴대전화 번호를 잘못 입력하셨습니다.");
                $("#user_phone").focus();
                return false;
            }

            $.ajax({
            //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')},
            type: 'post',
            url: "{{ route('auth_certification') }}",
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
                //console.log(text1);
                //console.log(text2);
                //태그 설정
                $("#phone_certificate" ).prop('readonly', false);
                $("#phone_certificate" ).val("");
                }else if(result[0] == '2'){
                    //alert("{{ __('auth.already_reg_number') }}");
                    alert('이미 등록된 휴대전화 번호입니다. \n다른 휴대전화 번호를 이용해주세요');
                    $("#user_phone").focus();
                }else{
                    alert("{{ __('auth.failed_send_sms') }}");
                    console.log(result[0]);
                }
            },
            error: function(request,status,error) {
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
            });

        }

        //비밀번호 변경 함수
        function change_pw(){
            let user_pw = $("#user_pw").val();
            let user_pw_confirmation = $("#user_pw_confirmation").val();

            if(user_pw == null || user_pw == ""){
                $("#pw_error").text("비밀번호를 입력해주세요");
                $("#user_pw").focus();
                return false;
            }

            $("#pw_error").text("");

            if(regPw.test(user_pw) !== true){
                $("#pw_error").text("비밀번호 형식이 잘못되었습니다.");
                $("#user_pw").focus();
                return false;
            }

            $("#pw_error").text("");

            if(user_pw != user_pw_confirmation){
                $("#pw_confirmation_error").text("위의 비밀번호와 동일한 비밀번호를 입력하세요");
                $("#user_pw_confirmation").focus();
                return false;
            }

            $("#pw_confirmation_error").text("");

            //console.log('여기까지 왔는가?');
            $.ajax({
                //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
                headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')},
                type: 'post',
                url: "{{ route('member_info_update_pw') }}",
                dataType: 'json',
                data: { user_pw : user_pw,
                    user_pw_confirmation : user_pw_confirmation
                },
                success: function(result) {
                    if(result[0] == true){
                        //console.log('성공 : '+result[0]);
                        alert('비밀번호를 변경했습니다.');
                        close_pw();
                    }else{
                        //console.log('실패 : '+result[0]);
                        alert('비밀번호변경 실패 \n다시 시도해주세요');
                        close_pw();
                    }
                },
                error: function(request,status,error) {
                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }

        //인증 확인 버튼 관련 함수
        function check_ctf_number(){
            //인증확인 시 저장 값과 확인 후 같을 경우 막기
            var phone_certificate = $("#phone_certificate").val();
            var phone_number = $("#user_phone").val();
            var cookie_certification = CryptoJS.AES.decrypt(getCookie(sk1), sk).toString(CryptoJS.enc.Utf8);
            var number_certification = CryptoJS.AES.decrypt(getCookie(sk2), sk).toString(CryptoJS.enc.Utf8);

            if(phone_number == ""){
                alert("휴대전화 번호를 '-' 없이 입력하세요.");
                $("#user_phone").focus();
                return false;
            }

            if(phone_certificate == "" && cookie_certification == ""){
                alert('인증 번호를 확인(입력)해주세요');
                $("#phone_certificate").focus();
                return false;
            }

            if(phone_number != number_certification){
                alert('잘못된 번호 입니다. \n인증을 받을 휴대전화 번호를 입력해주세요');
                $("#user_phone").focus();
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
        });

        //인증 제한 시간 지난 후에 로직 정의
        function return_to_sms(){
            $("#user_phone" ).prop('readonly', false);
            //태그 설정 해제
            $("#sms_send" ).prop('disabled', false);
            $("#phone_certificate" ).prop('readonly', false);
            $("#phone_certificate" ).val("");
            //console.log('{{ request()->getHost() }}');
            //쿠키 삭제를 위한 도메인 과 path를 가져와서 보내준다.(즉 인증 관련 정보 삭제)
            deleteCookie(sk1, '{{ request()->getHost() }}', '/');
            deleteCookie(sk2, '{{ request()->getHost() }}', '/');
            $('#checked_ctf').val('');
        }

        //휴대폰 변경 변경 관련 함수
        function change_phone_number(){
            //인증확인 시 저장 값과 확인 후 같을 경우 막기
            var phone_certificate = $("#phone_certificate").val();
            var phone_number = $("#user_phone").val();
            var cookie_certification = CryptoJS.AES.decrypt(getCookie(sk1), sk).toString(CryptoJS.enc.Utf8);
            var number_certification = CryptoJS.AES.decrypt(getCookie(sk2), sk).toString(CryptoJS.enc.Utf8);
            let check_ctf = $('#checked_ctf').val();

            if(phone_number == ""){
                alert("휴대전화 번호를 '-' 없이 입력하세요.");
                $("#user_phone").focus();
                return false;
            }

            if(phone_certificate == "" && cookie_certification == ""){
                alert('인증 번호를 확인(입력)해주세요');
                $("#phone_certificate").focus();
                return false;
            }

            if(phone_number != number_certification){
                alert('잘못된 번호 입니다. \n인증을 받을 휴대전화 번호를 입력해주세요');
                $("#user_phone").focus();
                return false;
            }

            if(check_ctf != '1'){
                alert('인증확인이 필요합니다.');
                return false;
            }

            if(phone_certificate == cookie_certification){
                //ajax로 핸드폰 번호 변경하기
                $.ajax({
                    //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
                    headers: {'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')},
                    type: 'post',
                    url: "{{ route('member_info_update_phone_number') }}",
                    dataType: 'json',
                    data: { user_phone : phone_number
                    },
                    success: function(result) {
                        if(result[0] == true){
                            //console.log('성공 : '+result[0]);
                            alert('휴대전화 번호를 변경했습니다.');
                            $("#phone_number").text(phone_number);
                            $("#phone_certificate" ).prop('readonly', false);
                            close_phone();
                        }else{
                            //console.log('실패 : '+result[0]);
                            alert('휴대전화 번호변경에 실패 하였습니다. \n다시 시도해주세요');
                            close_phone();
                        }
                    },
                    error: function(request,status,error) {
                        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    }
                });
            }else{
                alert('잘못된 인증번호 입니다.');
                return false;
            }
        }

        function check_submit(){

            //필수 항목 예외 처리
            if(!$("#age_over").prop("checked")){
                alert('필수 항목을 체크해주세요!');
                return false;
            }

            if(!$("#terms_agree").prop("checked")){
                alert('필수 항목을 체크해주세요!');
                return false;
            }

            if(!$("#pro_agree").prop("checked")){
                alert('필수 항목을 체크해주세요!');
                return false;
            }

            return true;
        }
    </script>

    <script>
        function member_withdraw(){
            location.href="{{ route('mypage.withdraw_page') }}";
        }
    </script>





@endsection