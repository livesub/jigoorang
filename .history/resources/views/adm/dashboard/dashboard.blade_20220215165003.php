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
                        <div><a href="{{ route('orderlist','od_status=입금') }}">{{ number_format($orders_cnt1) }}건</a></div>
                    </li>
                    <li>
                        <div>주문확인</div>
                        <div><a href="{{ route('orderlist','od_status=준비') }}">{{ number_format($orders_cnt2) }}건</a></div>
                    </li>
                    <li>
                        <div>발송</div>
                        <div><a href="{{ route('orderlist','od_status=배송') }}">{{ number_format($orders_cnt3) }}건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 교환 -->
            <h3>교환</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>교환 요청</div>
                        <div><a href="{{ route('orderlist','od_status=교환') }}">{{ number_format($orders_cnt5) }}건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 1:1 문의 -->
            <h3>1:1 문의</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>미처리 문의건</div>
                        <div><a href="{{ route('adm.qna_list') }}">{{ number_format($qna_cnt) }}건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 평가/리뷰 현황 -->
            <h3>평가/리뷰 현황</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>누적 평가 리뷰</div>
                        <div><a href="{{ route('adm.review.reviewlist') }}">{{ number_format($review_cnt) }}건</a></div>
                    </li>
                    <li>
                        <div>신규리뷰 ({{ $now_date }})</div>
                        <div><a href="{{ route('adm.review.reviewlist') }}">{{ number_format($review_now_cnt) }}건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 회원 현황 -->
            <h3>회원 현황</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>총회원수</div>
                        <div><a href="{{ route('adm.member.index') }}">{{ number_format($members_cnt) }}명</a></div>
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
