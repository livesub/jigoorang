@extends('layouts.head')

@section('content')
    신청 폼입니다. 
    <br>
    이름 : {{ auth()->user()->user_name }}
    <br>
    핸드폰 : {{ auth()->user()->user_phone }}
    <br>
    이메일 : {{ auth()->user()->user_id }}
    <br>
    하고싶은 말 (선택) <input type="text" id="form_text" name="form_text" placeholder="하고 싶은 말을 입력하세요">
    <hr>
    <h2>배송지</h2>
    <table border=1>
                <!-- 받으시는 분 입력 시작  -->
                <tr>
                    <td><h2>받으시는 분</h2></td>
                    <button onclick="baesongji()">배송지확인</button>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="disp_baesongi"></div>
                    </td>
                </tr>
    </table>
    <script>
    function baesongji(){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji') }}',
            data : {
            },
            dataType : 'text',
            success : function(result){
                if(result == "no_mem"){
                    alert("회원이시라면 회원로그인 후 이용해 주십시오.");
                    return false;
                }

                $("#disp_baesongi").html(result);
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>
@endsection