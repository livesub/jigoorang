@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>주문 상세 처리</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>현재 주문상태 : {{ $order_info->od_status }}</td>
        <td>주문일시 : {{ substr($order_info->od_receipt_time, 0, 16) }} ({{ $CustomUtils->get_yoil($order_info->od_receipt_time) }})</td>
        <td>결제금액 : {{ number_format(((int)$order_info->od_cart_price + (int)$order_info->de_send_cost + (int)$order_info->od_send_cost + (int)$order_info->od_send_cost2) - (int)$order_info->od_receipt_point) }}</strong>원</td>
    </tr>
</table>
<table border=1>
    <form name="frmorderform" method="post" action="">
    {!! csrf_field() !!}
    <input type="hidden" name="od_id" value="{{ $order_info->order_id }}">
    <input type="hidden" name="mb_id" value="{{ $order_info->user_id }}">
    <input type="hidden" name="od_email" value="{{ $order_info->user_id }}">
    <input type="hidden" name="page_move" value="{!! $page_move !!}">
    <input type="hidden" name="pg_cancel" value="0">
        <tr>
            <th scope="col">상품명</th>
            <th scope="col">
                <input type="checkbox" id="sit_select_all">
            </th>
            <th scope="col">옵션항목</th>
            <th scope="col">상태</th>
            <th scope="col">수량</th>
            <th scope="col">판매가</th>
            <th scope="col">소계</th>
            <th scope="col">포인트</th>
        </tr>

        @php
            $i = 0;
            $chk_cnt = 0;
        @endphp

        @foreach($carts as $cart)
            @php
            $image = $CustomUtils->get_item_image($cart->item_code, 3);
            $opts = DB::table('shopcarts')->where([['od_id', $order_info->order_id],['item_code', $cart->item_code]])->orderBy('sio_type')->orderBy('id')->get();
            $rowspan = count($opts);
            $k = 0;
            @endphp

            @foreach($opts as $opt)
                @php
                    if($opt->sio_type) $opt_price = $opt->sio_price;
                    else $opt_price = $opt->sct_price + $opt->sio_price;
                    // 소계
                    $ct_price['stotal'] = $opt_price * $opt->sct_qty;
                    $ct_point['stotal'] = $opt->sct_point * $opt->sct_qty;
                    $ct_baesong['baesong'] = $opt->sct_point * $opt->sct_qty;
                @endphp
        <tr>

                @if($k == 0)
            <td rowspan="{{ $rowspan }}"><img src="{{ asset($image) }}"> {{ stripslashes($cart->item_name) }}</td>
            <td rowspan="{{ $rowspan }}">
                <input type="checkbox" id="sit_sel_{{ $i }}" name="it_sel[]">
            </td>
                @endif

            <td>
                <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}">
                <input type="hidden" name="ct_id[{{ $chk_cnt }}]" value="{{ $cart->id }}">
                {{ $opt->sct_option }}
            </td>
            <td>{{ $opt->sct_status }}</td>
            <td>
                {{ $opt->sct_qty }}
            </td>
            <td>{{ number_format($opt_price) }}</td>
            <td>{{ number_format($ct_price['stotal']) }}</td>
            <td>{{ number_format($ct_point['stotal']) }} 점</td>
        </tr>
                @php
                $i++;
                $chk_cnt++;
                $k++;
                @endphp
            @endforeach
        @endforeach
</table>

<table border=1>
    <tr>
        <td>
            <input type="hidden" name="chk_cnt" value="{{ $chk_cnt }}">
            <strong>주문 및 장바구니 상태 변경</strong>
            <button type="button" onclick="status_change('준비')">준비</button>
            <button type="button" onclick="status_change('배송')">배송</button>
            <button type="button" onclick="status_change('완료')">배송완료</button>
            <button type="button" onclick="status_change('취소')">취소</button>
            <button type="button" onclick="status_change('반품')">반품</button>
        </td>
    </tr>
</form>
</table>



<script>
    function status_change(status){
alert(status);
    }
</script>



@endsection
