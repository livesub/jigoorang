@extends('layouts.head')

@section('content')


    <table>
        <tr>
            <td>지구랭 서비스 약관 동의</td>
        </tr>
        <tr>
            <td><input type="checkbox" name="age_chk" id="age_chk">만 14세 이상입니다(필수)</td>
        </tr>
        <tr>
            <td><input type="checkbox" name="terms_chk" id="terms_chk">약관동의(필수)</td>
        </tr>
        <tr>
            <td>약관 블라 블라...</td>
        </tr>
        <tr>
            <td><input type="checkbox" name="policy_chk" id="policy_chk">개인정보 처리방침(필수)</td>
        </tr>
        <tr>
            <td>개인정보 처리방침 블라 블라...</td>
        </tr>
        <tr>
            <td><input type="checkbox" name="promotion_chk" id="promotion_chk">프로모션 등등 기타 동의</td>
        </tr>
        <tr>
            <td>프로모션 등등 기타 동의 블라 블라...</td>
        </tr>

        <tr>
            <td><input type="checkbox" name="all_chk" id="all_chk" onclick="all_chk()">전체동의</td>
        </tr>
        <tr>
            <td>위 약관을 모두  확인하였으며 모든 내용에 동의 합니다</td>
        </tr>
        <tr>
            <td><button type="button" onclick="onNext()">다음</button></td>
        </tr>
    </table>


<script>
    function all_chk(){
        if($("input:checkbox[name=all_chk]").is(":checked") == true){
            $("input:checkbox[id='age_chk']").prop("checked", true);
            $("input:checkbox[id='terms_chk']").prop("checked", true);
            $("input:checkbox[id='policy_chk']").prop("checked", true);
            $("input:checkbox[id='promotion_chk']").prop("checked", true);
        }else{
            $("input:checkbox[id='age_chk']").prop("checked", false);
            $("input:checkbox[id='terms_chk']").prop("checked", false);
            $("input:checkbox[id='policy_chk']").prop("checked", false);
            $("input:checkbox[id='promotion_chk']").prop("checked", false);
        }
    }
</script>

<script>
    function onNext(){
        if($("input:checkbox[name=age_chk]").is(":checked") == false){
            alert("필수항목 동의 후 회원가입이 가능합니다");
            $("#age_chk").focus();
            return false;
        }

        if($("input:checkbox[name=terms_chk]").is(":checked") == false){
            alert("필수항목 동의 후 회원가입이 가능합니다");
            $("#terms_chk").focus();
            return false;
        }

        if($("input:checkbox[name=terms_chk]").is(":checked") == false){
            alert("필수항목 동의 후 회원가입이 가능합니다");
            $("#terms_chk").focus();
            return false;
        }

        if($("input:checkbox[name=policy_chk]").is(":checked") == false){
            alert("필수항목 동의 후 회원가입이 가능합니다");
            $("#policy_chk").focus();
            return false;
        }

        var check_promotion = $("#promotion_chk").prop("checked");
        if(check_promotion == true){
            location.href="{{ route('join.create', 'Y') }}"
        }else{
            location.href="{{ route('join.create', 'N') }}"
        }
    }
</script>


@endsection