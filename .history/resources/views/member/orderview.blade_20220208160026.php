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
                                <div class="bg_02 mt-20"></div>

                                <div class="btn_2ea pdt-30">
                                    <button class="btn-30-sol">주문 취소</button>
                                    <button class="btn-30-sol">교환/반품</button>
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
                    <a href="#">이전</a>
                    <div>1 / 20</div>
                    <a href="#">다음</a>
                </div>
                <!-- 페이징 끝 -->
            </div>

        </div>
        <!-- 주문 배송 내역 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->






@endsection
