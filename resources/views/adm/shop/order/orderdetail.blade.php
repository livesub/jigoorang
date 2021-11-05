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
            <th scope="col">쿠폰</th>
            <th scope="col">포인트</th>
            <th scope="col">배송비</th>
            <th scope="col">포인트반영</th>
            <th scope="col">재고반영</th>
        </tr>

        @php
            $i = 0;
            $chk_cnt = 0;
        @endphp

        @foreach($carts as $cart)
            @php
            $image = $CustomUtils->get_item_image($cart->item_code, 3);
            $opts = DB::table('shopcarts')->select('id', 'od_id', 'item_code', 'item_name')->where([['od_id', $order_info->order_id],['item_code', $cart->item_code]])->orderBy('sio_type')->orderBy('id')->get();
dd($opts);
/*
            // 상품의 옵션정보
            $sql = " select ct_id, it_id, ct_price, ct_point, ct_qty, ct_option, ct_status, cp_price, ct_stock_use, ct_point_use, ct_send_cost, io_type, io_price
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '{$od['od_id']}'
                          and it_id = '{$row['it_id']}'
                        order by io_type asc, ct_id asc ";
            $res = sql_query($sql);
            $rowspan = sql_num_rows($res);
*/
            @endphp
        <tr>
            <td><img src="{{ asset($image) }}"> {{ stripslashes($cart->item_name) }}</td>
            <td>
                <input type="checkbox" id="sit_sel_{{ $i }}" name="it_sel[]">
            </td>
            <td>
                <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}">
                <input type="hidden" name="ct_id[{{ $chk_cnt }}]" value="{{ $cart->id }}">
                <?php echo get_text($opt['ct_option']); ?>
            </td>
        </tr>
            @php
            $i++;
            $chk_cnt++;
            @endphp
        @endforeach
</table>







@endsection
