@extends('layouts.head')

@section('content')



<table border="1">
    <tr>
        <td>회원탈퇴</td>
    </tr>
</table>

<table border="1">
<form name="withdraw_form" id="withdraw_form" method="post" action="{{ route('mypage.withdraw') }}">
{!! csrf_field() !!}
    <tr>
        <td>그동안 지구랭을 이용해주셔서 감사합니다. 탈퇴 이유를 작성해주시면 더나은 서비스로 보답하겠습니다.</td>
    </tr>
    <tr>
        <td><input type="radio" name="withdraw_type" id="withdraw_type1" value="방문 빈도가 낮아요" onclick="withdraw_type_chk(1)">방문 빈도가 낮아요</td>
    </tr>
    <tr>
        <td><input type="radio" name="withdraw_type" id="withdraw_type2" value="개인 정보가 걱정돼요" onclick="withdraw_type_chk(2)">개인 정보가 걱정돼요</td>
    </tr>
    <tr>
        <td><input type="radio" name="withdraw_type" id="withdraw_type3" value="고객응대가 불만이에요(상담, 문의 등)" onclick="withdraw_type_chk(3)">고객응대가 불만이에요(상담, 문의 등)</td>
    </tr>
    <tr>
        <td><input type="radio" name="withdraw_type" id="withdraw_type4" value="배송, 교환, 환불, 반품이 불만이에요" onclick="withdraw_type_chk(4)">배송, 교환, 환불, 반품이 불만이에요</td>
    </tr>
    <tr>
        <td><input type="radio" name="withdraw_type" id="withdraw_type5" value="상품이 부족해요" onclick="withdraw_type_chk(5)">상품이 부족해요</td>
    </tr>
    <tr>
        <td><input type="radio" name="withdraw_type" id="withdraw_type6" value="컨텐츠가 불만이에요" onclick="withdraw_type_chk(6)">컨텐츠가 불만이에요</td>
    </tr>
    <tr>
        <td><input type="radio" name="withdraw_type" id="withdraw_type7" value="UI/UX가 불편해요" onclick="withdraw_type_chk(7)">UI/UX가 불편해요</td>
    </tr>
    <tr>
        <td><input type="radio" name="withdraw_type" id="withdraw_type8" value="기타(직접입력)" onclick="withdraw_type_chk(8)">기타(직접입력)</td>
    </tr>
    <tr id="withdraw_con" style="display:none">
        <td><textarea name="withdraw_content" id="withdraw_content" maxlength="500"></textarea></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>탈퇴전 유의사항을 확인해주세요</td>
    </tr>
    <tr>
        <td>1. 블라!~~</td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" name="withdraw_chk" id="withdraw_chk" value="ok">위 내용을 확인했고 동의 합니다.
        </td>
    </tr>
    <tr>
        <td><button type="button" onclick="withdraw_action()">탈퇴</button></td>
    </tr>
</table>


<script>
    function withdraw_type_chk(num){
        if(num == 8){
            $("#withdraw_con").show();
        }else{
            $("#withdraw_con").hide();
        }
    }

    function withdraw_action(){
        if($('input:radio[name=withdraw_type]').is(':checked') == false){
            alert("탈퇴 사유를 선택 하세요.");
            return false;
        }

        if($('input[name=withdraw_type]:checked').val() == "기타(직접입력)"){
            if($.trim($("#withdraw_content").val()) == ""){
                alert("사유를 작성해 주세요.");
                $("#withdraw_content").focus();
                return false;
            }
        }

        if($('input:checkbox[name=withdraw_chk]').is(':checked') == false){
            alert("탈퇴전 유의사항을 동의해주세요 ");
            $("#withdraw_chk").focus();
            return false;
        }

        $("#withdraw_form").submit();
    }
</script>




@endsection