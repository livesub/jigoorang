@extends('layouts.admhead')

@section('content')





    <!-- 컨테이너 시작 / 대쉬보드 -->
    <div class="container">

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>대쉬보드</h2>
            </div>
        </div>

        <!-- 컨텐츠 영역 -->
        <div class="contents_area dashboard">

            <!-- 주문현황 -->
            <h3>주문 현황</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>신규주문(결제완료)</div>
                        <div><a href="./page/order/order_01.html">20건</a></div>
                    </li>
                    <li>
                        <div>주문확인</div>
                        <div><a href="./page/order/order_02.html">30건</a></div>
                    </li>
                    <li>
                        <div>발송</div>
                        <div><a href="./page/order/order_03.html">200건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 교환 -->
            <h3>교환</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>교환 요청</div>
                        <div><a href="./page/order/order_05.html">3건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 1:1 문의 -->
            <h3>1:1 문의</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>미처리 문의건</div>
                        <div><a href="./page/qna/qna.html">2건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 평가/리뷰 현황 -->
            <h3>평가/리뷰 현황</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>누적 평가 리뷰</div>
                        <div><a href="./page/review/review.html">200건</a></div>
                    </li>
                    <li>
                        <div>신규리뷰 (2022-01-05)</div>
                        <div><a href="./page/review/review.html">15건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 회원 현황 -->
            <h3>회원 현황</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>총회원수</div>
                        <div><a href="./page/member/member.html">23,123명</a></div>
                    </li>
                    <li>
                        <div>신규가입</div>
                        <div><a href="./page/member/member.html">24명</a></div>
                    </li>
                    <li>
                        <div>탈퇴</div>
                        <div><a href="./page/member/member.html">38명</a></div>
                    </li>
                </ul>
            </div>

        </div>
        <!-- 컨텐츠 영역 끝 -->

    </div>
    <!-- 컨테이너 끝 -->






@endsection
