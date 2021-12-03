@extends('layouts.head')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    아이디 / 비밀번호 찾기 뷰입니다.<br>
    <lavel for="user_phone_for_id">아이디 찾기</lavel>
    <br>
    <input type="text" min="0" name="user_phone_for_id" id="user_phone_for_id" placeholder="휴대전화 번호를 ‘-’없이 입력하세요." value="" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
    <br>
    <button onclick="find_id()">아이디 전송</button>

    <br><br>
    <lavel for="user_phone_for_pw">비밀번호 찾기</lavel>
    <br>
    <input type="text" min="0" name="user_phone_for_pw" id="user_phone_for_pw" placeholder="휴대전화 번호를 ‘-’없이 입력하세요." value="" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
    <br>
    <button onclick="send_pwChange_link()">비밀번호 재설정 링크 전송</button>
@endsection

<script>
    //아이디 찾기 관련 ajax
    function find_id(){

        var user_phone_for_id = $('#user_phone_for_id').val();

        if(user_phone_for_id != ""){
            $.ajax({
                //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{ route('findId') }}',
                dataType: 'json',
                data: { user_phone : user_phone_for_id },
                success: function(result) {
                    if(result != "" && result != null && result[0].result_code != null && result[0].result_code != "" && result !="kakao" && result != "naver"){
                        //alert('아이디는 '+result+'입니다');

                        alert("{{ __('auth.success_found_phone') }}");
                        //console.log(result[0]);
                    }else if(result != null && result != "" && (result !="kakao" || result != "naver")){
                        alert('고객님은 비밀번호 없이 '+result+'를 이용하여 로그인 가능합니다.')
                    }else{
                        if (confirm("입력하신 전화번호로 가입된 정보가 없습니다.\n회원가입 페이지로 이동합니다.") == true){
                            location.href = "{{ route('join.create_agree') }}";
                        }else{
                            return false;
                        }
                    }
                    $('#user_phone_for_id').val("");
                },
                error: function(request,status,error) {
                        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }else{
            alert('휴대전화 번호를 입력 하세요.');
        }
    }


    //비밀번호 재설정 링크 발송 관련 ajax
    function send_pwChange_link(){

        var user_phone_for_pw = $('#user_phone_for_pw').val();

        if(user_phone_for_pw != ""){
            $.ajax({
                //아래 headers에 반드시 token을 추가해줘야 한다.!!!!!
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{ route('sendPwChangeLinkView') }}',
                dataType: 'json',
                data: { user_phone : user_phone_for_pw },
                success: function(result) {
                    if(result != "" && result != null && result[0].result_code != null && result[0].result_code != "" && result !="kakao" && result != "naver"){
                        //alert('아이디는 '+result+'입니다');
                        alert('재설정 링크가 발송되었습니다.\n문자로 받으신 링크를 통해 비밀번호를 재설정 하세요.');
                        console.log(result);
                    }else if(result != null && result != "" && (result !="kakao" || result != "naver")){
                        alert('고객님은 비밀번호 없이 '+result+'를 이용하여 로그인 가능합니다.')
                    }else{
                        if (confirm("입력하신 전화번호로 가입된 정보가 없습니다.\n회원가입 페이지로 이동합니다.") == true){
                            location.href = "{{ route('join.create_agree') }}";
                        }else{
                            return false;
                        }
                    }
                    $('#user_phone_for_pw').val("");
                },
                error: function(request,status,error) {
                        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                }
            });
        }else{
            alert('휴대전화 번호를 입력 하세요.');
        }
    }
</script>