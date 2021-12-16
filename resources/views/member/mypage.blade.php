@extends('layouts.head')

@section('content')

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area">
            <h2>마이페이지</h2>
            <div class="text_02 wt-nm mypagetitle">
            <span class="mypagetitle_left">
               <p>안녕하세요</p>
               <h3>{{ Auth::user()->user_name }}님</h3>
            </span>
            <a href="{{ route('member_info_index') }}">
               <button class="btn-bg-mint">회원정보 수정</button>
            </a>
            </div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 마이페이지시작  -->

            <div class="mypage">
                <!-- 마이페이지 컨텐츠 시작 -->
                <div class="mypage_wrap">
                    <div class="title">
                        <h3>나의 쇼핑정보</h3>
                </div>
                    <div class="mypage_inner_01">
                        <div class="mypage_innerbox_01">
                            <div class="mypage_box">
                            <a href="">
                                <div class="mypage_box_img01"></div>
                                <span>주문 배송내역</span>
                            </a>
                            </div>


                            <div class="mypage_box">
                                <a href="">
                                    <div class="mypage_box_img02"> </div>
                                    <span>취소/교환/반품 신청안내</span>
                                </a>
                            </div>
                        </div>

                    <div class="mypage_innerbox_02">
                        <div class="mypage_box solid">
                            <a href="">
                                <div class="mypage_box_img03"></div>
                                <span>제품 평가 및 리뷰</span>
                            </a>
                        </div>


                        <div class="mypage_box solid">
                            <a href="">
                                <div class="mypage_box_img04"></div>
                                <span>응원한 상품</span>
                            </a>
                        </div>
                    </div>

                </div>

            <div class="mypage_inner_02">

                <div class="mypage_content_01">
                    <div class="title box_2">
                        <h3>나의 계정설정</h3>
                    </div>

                    <a href="">
                        <div class="mypage_box_02">
                           포인트현황
                           <div class="point">{{ number_format(Auth::user()->user_point) }}P</div>
                        </div>
                    </a>
                </div>
                <div class="mypage_content_01">
                    <div class="title box_2">
                        <h3>나의 배송지</h3>
                    </div>


                    <a href="">
                        <div class="mypage_box_02 solid">
                            배송지 관리
                        </div>
                    </a>
                </div>
                </div>


                <div class="mypage_inner_02">
                    <div class="mypage_content_01">
                        <div class="title box_2">
                            <h3>나의 평가단</h3>
                        </div>

                        <a href="{{ route('mypage.exp_app_list') }}">
                            <div class="mypage_box_02">
                                평가단 신청 결과 확인
                            </div>
                        </a>
                    </div>
                    <div class="mypage_content_01">
                        <div class="title box_2">
                            <h3>나의 문의 내역</h3>
                        </div>
                        <a href="{{ route('mypage.qna_list') }}">
                            <div class="mypage_box_02 solid">
                                1:1 문의 내역/답변
                            </div>
                        </a>
                    </div>
                </div>


            </div> <!-- 마이페이지 컨텐츠 끝 -->

    </div> <!-- 마이페이지 끝  -->
</div><!-- 서브 컨테이너 끝 -->



@endsection
