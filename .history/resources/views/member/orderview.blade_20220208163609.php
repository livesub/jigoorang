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

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                    @foreach($orders as $order)
                    <div class="list ev_rul bd-02">
                        <div class="list ev_rul inner">
                            <div class="date">{{ substr($order->created_at, 0, 10) }} </div>
                            <div class="num">주문번호 <span class="ml-30">{{ $order->order_id }}</span></div>

                            <div class="btn_re point01">
                                <ul class="re_li">
                                    <li>
                                        @if($order->od_status == "입금")
                                        <button type="button" onclick="items_cancel('상품취소')">전체주문취소</button>
                                        @endif
                                    </li>
                                    <li><a href=""><span>자세히 보기</span></a></li>
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
                        @endphp
                            @php
                                $image = $CustomUtils->get_item_image($cart->item_code, 3);
                                if($image == "") $image = asset("img/no_img.jpg");

                                //제조사
                                $item = DB::table('shopitems')->where('item_code', $cart->item_code)->first();
                                if($item->item_manufacture == "") $item_manufacture = "";
                                else $item_manufacture = "[".$item->item_manufacture."]";

                                //제목
                                $item_name = $item_manufacture.stripslashes($cart->item_name);

                                $item_options = $CustomUtils->print_item_options($cart->item_code, $order->order_id);
                            @endphp
                        <div class="pr_body">
                            <div class="pr-t">
                                <div class="pr_img">
                                    <img src="{{ $image }}" alt="">
                                </div>

                                <div class="pr_name">
                                    <span class="cr_02">{{ $ment }}</span>

                                    <ul>
                                        <a href=""><li><h4 class="mt-10">{{ $item_name }}</h4></li></a>
                                        <li>
                                        @if($item_options)
                                        {{ $cart->sct_option }}
                                        @endif
                                        </li>
                                        <li class="price_pd">{{ number_format($cart->sct_price + $cart->sio_price) }}원 {{ number_format($cart->sct_qty) }}개</li>
                                    </ul>

                                </div>
                            </div>
                                <div class="bg_02 mt-20"></div>

                                <div class="btn_2ea pdt-30">
                                    <button class="btn-30-sol">교환/반품</button>
                                </div>

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
            </div>

        </div>
        <!-- 주문 배송 내역 끝  -->
    </div>
    <!-- 서브 컨테이너 끝 -->

<script>
    function items_cancel(status){
        var msg = '상품취소 시 자동 환불 처리 되어 복구 할수 없습니다.';

        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?")) {
            new_pay_cancel('{{ $order->imp_uid }}', '{{ $order->order_id }}', '{{ $order->real_card_price }}');
        }
    }
</script>





@endsection
