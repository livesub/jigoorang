@extends('layouts.head')

@section('content')

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.orderview') }}">주문 배송내역</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>주문 배송내역</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 주문 배송내역 시작  -->
        <div class="eval">
<form name="orderviewform" id="orderviewform" method="post" action="{{ route('mypage.return_sign_up') }}">
{!! csrf_field() !!}
<input type="hidden" name="order_id" id="order_id">
<input type="hidden" name="cart_num" id="cart_num">
            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                @if(count($orders) > 0)
                    @foreach($orders as $order)
                    <div class="list ev_rul bd-02">
                        <div class="list ev_rul oder_view">
                            <div class="date">{{ substr($order->created_at, 0, 10) }} </div>
                            <div class="num">주문번호 <span class="ml-30">{{ $order->order_id }}</span></div>

                            <div class="btn_re point01">
                                <ul class="re_li t-00">
                                    <li>
                                        @if($order->od_status == "입금")

                                        <button type="button" onclick="items_cancel('{{ $order->imp_uid }}', '{{ $order->order_id }}', '{{ $order->real_card_price }}', '{{ $order->od_deposit_name }}')">전체주문취소</button>
                                        @endif
                                    </li>
                                    <li><a href="{{ route('mypage.orderview_detail', 'order_id='.$order->order_id.'&page='.$page) }}"><span>자세히 보기</span></a></li>
                                </ul>
                            </div>
                        </div>

                        @php
                            $carts = DB::table('shopcarts')->where([['user_id',Auth::user()->user_id],['od_id', $order->order_id]])->get();
                        @endphp

                        @foreach($carts as $cart)
                        @php
                            switch($cart->sct_status) {
                                case "입금":
                                    $ment = "결제완료";
                                break;
                                case "준비":
                                    $ment = "상품준비중";
                                break;
                                case "배송":
                                    $ment = "배송중";
                                break;
                                case "완료":
                                    $ment = "구매완료";
                                break;
                                case "교환":
                                    $ment = "교환요청";
                                break;
                                case "상품취소":
                                    $ment = "주문취소";
                                break;
                            }

                            $image = $CustomUtils->get_item_image($cart->item_code, 3);
                            if($image == "") $image = asset("img/no_img.jpg");

                            //제조사
                            $item = DB::table('shopitems')->where('item_code', $cart->item_code)->first();
                            if($item->item_manufacture == "") $item_manufacture = "";
                            else $item_manufacture = "[".$item->item_manufacture."]";

                            //제목
                            $item_name = $item_manufacture.stripslashes($cart->item_name);

                            if(strpos($cart->sct_option, " / ") !== false) {
                                $item_options = $cart->sct_option;
                            } else {
                                $item_options = "";
                            }

                            //교환버튼 출력 시점(결제완료후 9일 지나면 send_complete_chk 자동 완료, 이후 21일이 지나면 안나오게 총 30일)
                            if($order->send_complete_chk == "Y"){
                                $timestamp = strtotime("Now");
var_dump("FFFFFFFFFFFF=====> ".$timestamp);


//$today_time = strtotime($today);
//$expire_time = strtotime($expire);
//                                $now_date =
                            }
                        @endphp
                        <div class="pr_body od_v">
                            <div class="pr-t">
                                <div class="pr_img">
                                    <img src="{{ $image }}" alt="">
                                </div>

                                <div class="pr_name">
                                    <span class="cr_02">{{ $ment }}</span>

                                    <ul>
                                        <a href="{{ route('mypage.orderview_detail', 'order_id='.$order->order_id.'&page='.$page) }}"><li><h4 class="mt-10">{{ $item_name }}</h4></li></a>
                                        <li>
                                        {{ $item_options }}
                                        </li>
                                        <li class="price_pd">{{ number_format($cart->sct_price + $cart->sio_price) }}원 X {{ number_format($cart->sct_qty_cancel) }}개</li>
                                    </ul>

                                </div>
                            </div>

                            @if($order->od_status == "배송" || $order->od_status == "완료")
                            <div class="bg_02 mt-20"></div>

                            <div class="btn_2ea pdt-30">
                                @if($cart->return_story == "")






                                <button type="button" class="btn-30-sol" onclick="return_item('{{ $order->order_id }}', '{{ $cart->id }}');">교환</button>
                                @else
                                    @if($cart->return_process == "N")
                                <button type="button" class="btn-30-sol trd">교환요청중</button>
                                    @elseif($cart->return_process == "T")
                                <button type="button" class="btn-30-sol">교환불가</button>
                                    @else
                                <button type="button" class="btn-30-sol">교환완료</button>
                                    @endif
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                <!-- 리스트 끝 -->

                <!-- 페이징 시작 -->
                <div class="paging">
                    {!! $pnPage !!}
                </div>
                <!-- 페이징 끝 -->
                @else
                <div class="list-none">
                    <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                    <br><br>
                    <p>주문 배송내역이 없습니다</p>
                </div>
                @endif


            </div>

        </div>
        </form>
        <!-- 주문 배송 내역 끝  -->
    </div>
    <!-- 서브 컨테이너 끝 -->
</div>
<script>
    function items_cancel(imp_uid, order_id, real_card_price, od_deposit_name){
        var msg = '상품취소 시 자동 환불 처리 되어 복구 할수 없습니다.';

        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?")) {
            new_pay_cancel(imp_uid, order_id, real_card_price, od_deposit_name);
        }
    }
</script>

<!-- 환불 처리 -->
<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>


<script>
    function new_pay_cancel(imp_uid, order_id, amount, od_deposit_name){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            //url : '{{ route('mypage.ajax_itemspaycancel') }}',
            url : '{{ route('ajax_itemspaycancel') }}',
            type : 'post',
            contentType : "application/json",
            data    : JSON.stringify({
                "imp_uid"               : imp_uid,
                "merchant_uid"          : order_id, // 예: ORD20180131-0000011
                "cancel_request_amount" : amount, // 환불금액
                "reason"                : "주문취소", // 환불사유
                "custom_data"           : '',  //필요 데이터
                "refund_holder"         : od_deposit_name, // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank"           : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(예: KG이니시스의 경우 신한은행은 88번)
                "refund_account"        : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            dataType : "text",
        }).done(function(result) { // 환불 성공시 로직
//alert(result);
//return false;
            if(result == "ok"){
                alert("취소 처리 되었습니다.");
                location.reload();
            }

            if(result == "error"){
                alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-1");
            }

        }).fail(function(error) { // 환불 실패시 로직
            alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-2");
        });
    }
</script>

<script>
    function return_item(order_id, cart_num){
        $("#order_id").val(order_id);
        $("#cart_num").val(cart_num);
        $("#orderviewform").submit();
    }
</script>




@endsection
