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
<table>
    <tr>
        <td>주문완료(1)</td>
        <td>주문확인(2)</td>
        <td>발송(2)</td>
        <td>배송완료(2)</td>
        <td>교환반품(2)</td>
        <td>주문취소(2)</td>
    </tr>
</table>
<table border=1>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('orderlist') }}'">초기화</button></td>
    </tr>
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
            <input type="text" name="search" value="{{ $search }}" id="search" required class="required frm_input" autocomplete="off">
            <input type="submit" value="검색" class="btn_submit">
        </td>
    </tr>
</form>
</table>

<table border=1>
<form name="frmorderetc">
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
                $od_cancel_price_chk = '';
                $od_refund_price_chk = '';
                $od_receipt_point_chk = '';

                if($od_cancel_price == 'Y') $od_cancel_price_chk = 'checked';
                if($od_refund_price == 'Y') $od_refund_price_chk = 'checked';
                if($od_receipt_point == 'Y') $od_receipt_point_chk = 'checked';
            @endphp
            <input type="checkbox" name="od_cancel_price" value="Y" id="od_misu02" {{ $od_cancel_price_chk }}>
            <label for="od_misu02">반품,품절</label>
            <input type="checkbox" name="od_refund_price" value="Y" id="od_misu03" {{ $od_refund_price_chk }}>
            <label for="od_misu03">환불</label>
            <input type="checkbox" name="od_receipt_point" value="Y" id="od_misu04" {{ $od_receipt_point_chk }}>
            <label for="od_misu04">포인트주문</label>
        </td>
    </tr>

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


<table border=1>
    <tr>
        <td>주문번호</td>
        <td>주문상태</td>
        <td>ID</td>
        <td>이름</td>
        <td>받는분전회번호</td>
        <td>주문상품수</td>
        <td>운송장번호</td>
        <td>주문합계<br>(배송비포함)</td>
        <td>입금합계<br>(주문합계-포인트사용)</td>
        <td>취소금액</td>
        <td>보기</td>
    <tr>

    @foreach($orders as $order)
        @php
        switch($order->od_settle_case) {
            case 'card':
                $settle_case_ment = '카드';
                break;

            case 'phone':
                $settle_case_ment = '휴대폰결제';
                break;

            case 'trans':
                $settle_case_ment = '실시간계좌이체';
                break;

            case 'kakaopay':
                $settle_case_ment = 'KAKAOPAY';
                break;

            case 'naverpay':
                $settle_case_ment = 'NAVERPAY';
                break;

            default:
                $settle_case_ment = '';
                break;
        }

        $receipt_point_ment = '';
        if($order->od_receipt_point > 0) $receipt_point_ment = number_format($order->od_receipt_point).' 사용';

        $deposit_hap = (int)$order->od_receipt_price - (int)$order->od_receipt_point;
        @endphp

    <tr>
        <td>{{ $order->order_id }}</td>
        <td>{{ $order->od_status }}</td>
        <td>{{ $order->user_id }}</td>
        <td>{{ $order->od_deposit_name }}</td>
        <td>{{ $order->ad_hp }}</td>
        <td>{{ $order->od_cart_count }}</td>
        <td>{{ $order->od_invoice }}</td>
        <td>{{ number_format($order->od_receipt_price) }}</td>
        <td>{{ number_format($deposit_hap) }}</td>
        <td>{{ number_format($order->od_cancel_price) }}</td>
        <td><button type="button" onclick="orderview('{{ $order->order_id }}')">보기</button></td>
    <tr>
    @endforeach
</table>



<table>
    <tr>
        <td>{!! $pnPage !!}</td>
    </tr>
</table>


<script>
    //두개짜리 제어 연결된거 만들어주는 함수
    datePickerSet($("#fr_date"), $("#to_date"), true); //다중은 시작하는 달력 먼저, 끝달력 2번째

    function datePickerSet(sDate, eDate, flag) {
        if (!isValidStr(sDate) && !isValidStr(eDate) && sDate.length > 0 && eDate.length > 0) {
            var sDay = sDate.val();
            var eDay = eDate.val();

            if (flag && !isValidStr(sDay) && !isValidStr(eDay)) { //처음 입력 날짜 설정, update...
                var sdp = sDate.datepicker().data("datepicker");
                sdp.selectDate(new Date(sDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요

                var edp = eDate.datepicker().data("datepicker");
                edp.selectDate(new Date(eDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요
            }

            //시작일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(eDay)) {
                sDate.datepicker({
                    maxDate: new Date(eDay.replace(/-/g, "/"))
                });
            }
            sDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });

            //종료일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(sDay)) {
                eDate.datepicker({
                    minDate: new Date(sDay.replace(/-/g, "/"))
                });
            }
            eDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });
        }

        function isValidStr(str) {
            if (str == null || str == undefined || str == "")
                return true;
            else
                return false;
        }
    }

    function set_date(today)
    {
        @php
        $now_date = date('Y-m-d', time());
        $date_term = date('w', time());
        $week_term = $date_term + 7;
        $last_term = strtotime(date('Y-m-01', time()));
        @endphp

        if (today == "오늘") {
            $("#fr_date").val("{{ $now_date }}");
            $("#to_date").val("{{ $now_date }}");
        } else if (today == "어제") {
            $("#fr_date").val("{{ date('Y-m-d', time() - 86400) }}");
            $("#to_date").val("{{ date('Y-m-d', time() - 86400) }}");
        } else if (today == "이번주") {
            $("#fr_date").val("{{ date('Y-m-d', strtotime('-'.$date_term.' days', time())) }}");
            $("#to_date").val("{{ date('Y-m-d', time()) }}");
        } else if (today == "이번달") {
            $("#fr_date").val("{{ date('Y-m-01', time()) }}");
            $("#to_date").val("{{ date('Y-m-d', time()) }}");
        } else if (today == "지난주") {
            $("#fr_date").val("{{ date('Y-m-d', strtotime('-'.$week_term.' days', time())) }}");
            $("#to_date").val("{{ date('Y-m-d', strtotime('-'.($week_term - 6).' days', time())) }}");
        } else if (today == "지난달") {
            $("#fr_date").val("{{ date('Y-m-01', strtotime('-1 Month', $last_term)) }}");
            $("#to_date").val("{{ date('Y-m-t', strtotime('-1 Month', $last_term)) }}");
        } else if (today == "전체") {
            $("#fr_date").val("");
            $("#to_date").val("");
        }
    }
</script>

<script>
    function orderview(order_id){
        location.href = "{{ route('orderdetail') }}?order_id="+order_id+"{!! $page_move !!}";
    }
</script>






@endsection
