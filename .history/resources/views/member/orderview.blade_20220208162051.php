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
                                    <li><button type="button">전체주문취소</button></li>
                                    <li><a href=""><span>자세히 보기</span></a></li>
                                </ul>
                            </div>
                        </div>

                        @php
                            $carts = DB::table('shopcarts')->where([['user_id',Auth::user()->user_id],['od_id', $order->order_id]])->get();
                        @endphp

                        @foreach($carts as $cart)
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
                                    <span class="cr_02">상품 준비중</span>

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

<!--
                    <div class="list ev_rul bd-02">

                        <div class="list ev_rul inner">
                            <div class="date">2020.11.14 </div>
                            <div class="num">주문번호 <span class="ml-30">20211201345-00001</span></div>

                            <div class="btn_re point01">
                                <ul class="re_li">
                                    <li><button>전체주문취소</button></li>
                                    <li><a href=""><span>자세히 보기</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="pr_body">

                            <div class="pr-t">
                                <div class="pr_img">
                                    <img src="../../recources/imgs/sample_img.png" alt="">
                                </div>

                                <div class="pr_name">
                                    <span class="cr_02">상품 준비중</span>

                                    <ul>
                                        <a href=""><li><h4 class="mt-10">[대나무숲] 요즘 인싸들만 쓴다는 아이템 000칫솔</h4></li></a>
                                        <li>소형 / 파랑</li>
                                        <li class="price_pd">6000원 1개</li>
                                    </ul>

                                </div>
                            </div>

                            <div class="bg_02 pdt-20"></div>

                            <div class="btn_2ea pdt-30">
                                <button class="btn-30-sol">주문 취소</button>
                                <button class="btn-30-sol">교환/반품</button>
                            </div>
                        </div>
                    </div>
-->

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






@endsection
