@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>쇼핑몰 환경 설정</h4></td>
    </tr>
</table>


<form name="set_form" id="set_form" method="post" action="{{ route('shop.setting.savesetting') }}">
{!! csrf_field() !!}
<input type="hidden" name="id" id="id" value="{{ $id }}">
<input type="hidden" name="company_use_point" value="1">
<input type="hidden" name="company_bank_use" value="0">

<table border=1>
    <tr>
        <td colspan="2"><b>사업자 정보</b></td>
    </tr>

    <tr>
        <td><b>회사명</b></td>
        <td><input type="text" name="company_name" value="{{ $company_name }}" id="company_name" size="30"></td>
        <td><b>사업자 등록번호</b></td>
        <td><input type="text" name="company_saupja_no"  value="{{ $company_saupja_no }}" id="company_saupja_no" size="30"></td>
    </tr>
    <tr>
        <td><b>대표자명</b></td>
        <td><input type="text" name="company_owner" value="{{ $company_owner }}" id="company_owner" size="30"></td>
        <td><b>대표전화번호</b></td>
        <td><input type="text" name="company_tel" value="{{ $company_tel }}" id="company_tel" size="30"></td>
    </tr>
    <tr>
        <td><b>팩스번호</b></td>
        <td><input type="text" name="company_fax" value="{{ $company_fax }}" id="company_fax" size="30"></td>
        <td><b>통신판매업 신고 번호</b></td>
        <td><input type="text" name="company_tongsin_no" value="{{ $company_tongsin_no }}" id="company_tongsin_no" size="30"></td>
    </tr>
    <tr>
        <td><b>부가통신 사업자번호</b></td>
        <td><input type="text" name="company_buga_no" value="{{ $company_buga_no }}" id="company_buga_no" size="30"></td>
        <td><b>사업장 우편번호</b></td>
        <td><input type="text" name="company_zip" value="{{ $company_zip }}" id="company_zip" size="5"></td>
    </tr>
    <tr>
        <td><b>사업장 주소</b></td>
        <td><input type="text" name="company_addr" value="{{ $company_addr }}" id="company_addr" size="30"></td>
        <td><b>정보관리책임자명</b></td>
        <td><input type="text" name="company_info_name" value="{{ $company_info_name }}" id="company_info_name" size="30"></td>
    </tr>
    <tr>
        <td><b>정보책임자이메일</b></td>
        <td><input type="text" name="company_info_email" value="{{ $company_info_email }}" id="company_info_email" size="30"></td>
    </tr>
</table>



<table border=1>
    <tr>
        <td><b>회원가입시 적립금</b></td>
        <td>
            <input type="text" name="member_reg_point" value="{{ $member_reg_point }}" id="member_reg_point" class="frm_input" size="10"> 원
        </td>
    </tr>
</table>


<table border=1>
    <tr>
        <td><b>기본배송비</b></td>
        <td>
            <input type="text" name="de_send_cost" value="{{ $de_send_cost }}" id="de_send_cost" class="frm_input" size="10"> 원
        </td>
    </tr>
</table>

<table border=1>
    <tr>
        <td><b>배송비 무료 정책</b></td>
        <td>
            주문 금액 <input type="text" name="de_send_cost_free" value="{{ $de_send_cost_free }}" id="de_send_cost_free" class="frm_input" size="10"> 원 이상시 기본 배송비 무료
        </td>
    </tr>
</table>

<table border=1>
    <tr>
        <td><b>텍스트 리뷰 포인트</b></td>
        <td>
            <input type="text" name="text_point" value="{{ $text_point }}" id="text_point" class="frm_input" size="10"> pt
        </td>
    </tr>
    <tr>
        <td><b>포토 리뷰 포인트</b></td>
        <td>
            <input type="text" name="photo_point" value="{{ $photo_point }}" id="photo_point" class="frm_input" size="10"> pt
        </td>
    </tr>
</table>

<table border=1>
    <tr>
        <td><b>기획전1 변경</b></td>
        <td>
            <input type="text" name="de_ment_change" value="{{ $de_ment_change }}" id="de_ment_change">
        </td>
    </tr>
    <tr>
        <td><b>기획전2 변경</b></td>
        <td>
            <input type="text" name="de_ment_change2" value="{{ $de_ment_change2 }}" id="de_ment_change2">
        </td>
    </tr>
</table>

@if(Auth::user()->user_level < 3)
<table border=1>
    <tr>
        <td colspan="2"><b>이미지 리사이징 설정</b></td>
    </tr>
    <tr>
        <td>WIDTH</td>
        <td>
            <input type="text" name="shop_img_width" value="{{ $shop_img_width }}" id="shop_img_width" size="30">
            <br>(리사이징될 파일 넓이 - '%%'구분자사용)<br>예) 500%%300%%100
        </td>
    </tr>
    <tr>
        <td>HEIGHT</td>
        <td>
            <input type="text" name="shop_img_height" value="{{ $shop_img_height }}" id="shop_img_height" size="30">
            <br>(리사이징될 파일 높이 - '%%'구분자사용)<br>예) 500%%300%%100
        </td>
    </tr>
</table>
@endif

<table>
    <tr>
        <td><button type="button" onclick="set_save();">저장</button></td>
    </tr>
</table>
</form>


<script>
    function set_save(){
        if($("#shop_img_width").val() == ""){
            alert("리사이징될 파일 넓이를 입력 하세요.");
            $("#shop_img_width").focus();
            return false;
        }

        if($("#shop_img_height").val() == ""){
            alert("리사이징될 파일 높이를 입력 하세요.");
            $("#shop_img_height").focus();
            return false;
        }

        $('#set_form').submit();
    }
</script>



@endsection
