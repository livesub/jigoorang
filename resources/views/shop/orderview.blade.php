@extends('layouts.shophead')

@section('content')


<table border="1">
    <tr>
        <td><h4>주문 상품 리스트</h4></td>
    </tr>
</table>

<table border=1>
<form name="orderform" id="orderform" method="post" action="" autocomplete="off">
{!! csrf_field() !!}
@foreach($orders as $order)
    @php
        $carts = DB::table('shopcarts')->where([['user_id',Auth::user()->user_id],['od_id', $order->order_id]])->get();
    @endphp
    <tr>
        <td><b>주문번호 : {{ $order->order_id }}</b></td>
    </tr>

    @foreach($carts as $cart)
        @php
            $items = DB::table('shopitems')->where('item_code', $cart->item_code)->first();
            $image = $CustomUtils->get_item_image($items->item_code, 3);
            $item_name = '<b>' . stripslashes($items->item_name) . '</b>';
            $item_options = $CustomUtils->print_item_options($items->item_code, $order->order_id);
            if($item_options) {
                $item_name .= '<div class="sod_opt">'.$item_options.'</div>';
            }
        @endphp

    <tr>
        <td>
            <table border=1>
                <tr>
                    <td><img src="{{ asset($image) }}"></td>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    {!! $item_name !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>{{ $cart->sct_qty }}개</td>
                    <td>{{ $cart->sct_price + $cart->sio_price }}</td>
                    <td><button type="button" onclick="pay_cancel('{{ $order->imp_uid }}', '{{ $order->order_id }}', '868')">취소</button></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><br><br><br></td>
    </tr>
    @endforeach
@endforeach
</table>


<!-- 환불 처리 -->
<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    function pay_cancel(imp_uid, order_id, amount){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : '{{ route('ajax_orderpaycancel') }}',
            type : 'post',
            contentType : "application/json",
            data    : JSON.stringify({
                "imp_uid"               : imp_uid,
                "merchant_uid"          : order_id, // 예: ORD20180131-0000011
                "cancel_request_amount" : amount, // 환불금액
                "reason"                : "부분 환불", // 환불사유
                "refund_holder"         : "{{ Auth::user()->user_name }}", // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank"           : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(예: KG이니시스의 경우 신한은행은 88번)
                "refund_account"        : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            dataType : "text",
        }).done(function(result) { // 환불 성공시 로직
//alert(result);
//return false;
/*
            if(result == "end"){
                alert("전체 금액이 환불 되었습니다.");
                location.href = "{{ route('orderview') }}";
            }
*/
            if(result == "ok"){
                alert("취소 처리 되었습니다.");
                location.href = "{{ route('orderview') }}";
            }

            if(result == "error"){
                alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.");
                location.href = "{{ route('orderview') }}";
            }
        }).fail(function(error) { // 환불 실패시 로직
            alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.");
            location.href = "{{ route('orderview') }}";
        });
    }
</script>







@endsection
