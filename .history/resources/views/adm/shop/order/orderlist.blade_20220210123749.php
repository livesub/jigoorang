@extends('layouts.admhead')

@section('content')


<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('/datepicker/dist/css/datepicker.min.css') }}">
<script src="{{ asset('/datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/datepicker/dist/js/i18n/datepicker.ko.js') }}"></script>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .double div {
        float: left;
    }
</style>
<!-- datepicker -->


<table>
    <tr>
        <td><h4>주문 관리</h4></td>
    </tr>
</table>


<form name="frmorderlist">
<table border=1>
    <tr>
        <td><a href="{{ route('orderlist', 'od_status=입금') }}">결제완료(1)</a></td>
        <td><a href="{{ route('orderlist', 'order_type=준비') }}">주문확인(2)</a></td>
        <td><a href="{{ route('orderlist', 'order_type=배송') }}">발송(2)</a></td>
        <td><a href="{{ route('orderlist', 'order_type=완료') }}">배송완료(2)</a></td>
        <td><a href="{{ route('orderlist', 'order_type=aa') }}">교환반품(2)</a></td>
        <td><a href="{{ route('orderlist', 'order_type=취소') }}">주문취소(2)</a></td>
    </tr>
</table>


<form name="frmorderetc">
<table border=1>
    <tr>
        <td>
        @php
            $order_id_chk = '';
            $user_id_chk = '';
            $od_b_name_chk = '';
            $od_b_tel_chk = '';
            $od_b_hp_chk = '';
            $od_deposit_name_chk = '';
            $od_invoice_chk = '';

            if($sel_field == 'order_id') $order_id_chk = 'selected';
            else if($sel_field == 'user_id') $user_id_chk = 'selected';
            else if($sel_field == 'od_b_name') $od_b_name_chk = 'selected';
            else if($sel_field == 'od_b_tel') $od_b_tel_chk = 'selected';
            else if($sel_field == 'od_b_hp') $od_b_hp_chk = 'selected';
            else if($sel_field == 'od_deposit_name') $od_deposit_name_chk = 'selected';
            else if($sel_field == 'od_invoice') $od_invoice_chk = 'selected';
        @endphp
            <select name="sel_field" id="sel_field">
                <option value="order_id" {{ $order_id_chk }}>주문번호</option>
                <option value="user_id" {{ $user_id_chk }}>회원 ID</option>
                <option value="od_b_name" {{ $od_b_name_chk }}>받는분</option>
                <option value="od_b_tel" {{ $od_b_tel_chk }}>받는분전화</option>
                <option value="od_b_hp" {{ $od_b_hp_chk }}>받는분핸드폰</option>
                <option value="od_deposit_name" {{ $od_deposit_name_chk }}>입금자</option>
                <option value="od_invoice" {{ $od_invoice_chk }}>운송장번호</option>
            </select>
        </td>
        <td>
            <input type="text" name="search" value="{{ $search }}" id="search">
            <!-- <input type="submit" value="검색" class="btn_submit"> -->
        </td>
    </tr>
</table>

<table border=1>

<!--
    <tr>
        <td>주문상태</td>
        <td>
            @php
                $od_status1 = '';
                $od_status2 = '';
                $od_status3 = '';
                $od_status4 = '';
                $od_status5 = '';
                $od_status6 = '';
                $od_status7 = '';
                $od_status8 = '';
                $od_status9 = '';

                if($od_status == '') $od_status1 = 'checked';
                else if($od_status == '주문') $od_status2 = 'checked';
                else if($od_status == '입금') $od_status3 = 'checked';
                else if($od_status == '준비') $od_status4 = 'checked';
                else if($od_status == '배송') $od_status5 = 'checked';
                else if($od_status == '완료') $od_status6 = 'checked';
                else if($od_status == '부분취소') $od_status8 = 'checked';
                else if($od_status == '상품취소') $od_status9 = 'checked';
            @endphp
            <input type="radio" name="od_status" value="" id="od_status_all" {{ $od_status1 }}>
            <label for="od_status_all">전체</label>
            <input type="radio" name="od_status" value="주문" id="od_status_odr" {{ $od_status2 }}>
            <label for="od_status_odr">주문</label>
            <input type="radio" name="od_status" value="입금" id="od_status_income" {{ $od_status3 }}>
            <label for="od_status_income">입금</label>
            <input type="radio" name="od_status" value="준비" id="od_status_rdy" {{ $od_status4 }}>
            <label for="od_status_rdy">준비</label>
            <input type="radio" name="od_status" value="배송" id="od_status_dvr" {{ $od_status5 }}>
            <label for="od_status_dvr">배송</label>
            <input type="radio" name="od_status" value="완료" id="od_status_done" {{ $od_status6 }}>
            <label for="od_status_done">완료</label>
            <input type="radio" name="od_status" value="부분취소" id="od_status_pcancel" {{ $od_status8 }}>
            <label for="od_status_pcancel">부분취소</label>
            <input type="radio" name="od_status" value="상품취소" id="od_status_pcancel" {{ $od_status9 }}>
            <label for="od_status_pcancel">상품취소</label>
        </td>
    </tr>

    <tr>
        <td>기타선택</td>
        <td>
            @php
                $od_refund_price_chk = '';
                $od_receipt_point_chk = '';

                if($od_refund_price == 'Y') $od_refund_price_chk = 'checked';
                if($od_receipt_point == 'Y') $od_receipt_point_chk = 'checked';
            @endphp
            <label for="od_misu02">반품,품절</label>
            <input type="checkbox" name="od_refund_price" value="Y" id="od_misu03" {{ $od_refund_price_chk }}>
            <label for="od_misu03">환불</label>
            <input type="checkbox" name="od_receipt_point" value="Y" id="od_misu04" {{ $od_receipt_point_chk }}>
            <label for="od_misu04">포인트주문</label>
        </td>
    </tr>
-->
    <tr>
        <td>주문일자</td>
        <td>
            <input type="text" id="fr_date"  name="fr_date" value="{{ $fr_date }}" class="frm_input" size="10" maxlength="10"> ~
            <input type="text" id="to_date"  name="to_date" value="{{ $to_date }}" class="frm_input" size="10" maxlength="10">
            <button type="button" onclick="javascript:set_date('오늘');">오늘</button>
            <button type="button" onclick="javascript:set_date('어제');">어제</button>
            <button type="button" onclick="javascript:set_date('이번주');">이번주</button>
            <button type="button" onclick="javascript:set_date('이번달');">이번달</button>
            <button type="button" onclick="javascript:set_date('지난주');">지난주</button>
            <button type="button" onclick="javascript:set_date('지난달');">지난달</button>
            <button type="button" onclick="javascript:set_date('전체');">전체</button>
            <input type="submit" value="검색" class="btn_submit">
        </td>
    </tr>

</table>
</form>






@endsection
