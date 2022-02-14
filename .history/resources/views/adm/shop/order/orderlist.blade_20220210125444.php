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

@php
    use App\Http\Controllers\adm\shop\order\OrderController;
    $od_status_type = new OrderController();
    echo $od_status_type->deposit_function($data);
@endphp





@endsection
