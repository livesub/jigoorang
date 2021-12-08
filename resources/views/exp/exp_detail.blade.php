@extends('layouts.head')

@section('content')



    <!-- 메인 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="../../index.html">홈</a></li>
                <li><a href="../../page/evaluation/evaluation_list.html">정직한 평가단</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area">
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 게시판 시작  -->
        <div class="eval">

            <div class="board">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="list_view">
                        <div class="body">
                           <div class="title">
                                {{ $result -> title }}
                            </div>
                            <dl>
                                <dt>평가단 모집인원</dt>
                                <dd>{{ $result->exp_limit_personnel }}명</dd>
                                <dt>모집기간</dt>
                                <dd>{{ $result->exp_date_start }}  ~ {{ $result->exp_date_end }}</dd>
                                <dt>평가 가능기간</dt>
                                <dd>{{ $result->exp_review_start }} ~ {{ $result->exp_review_end }}</dd>
                                <dt>당첨자 발표일</dt>
                                <dd>{{ $result->exp_release_date }}</dd>
                            </dl>
                        </div>
                        <!-- 리스트 끝 -->
                        <div class="list_contents">
                            <div class="list_img_text list_img">
                                {!! $result->exp_content !!}
                            </div>
                        </div>
                    </div>
                    <div class="list_img_btn_area">
                        <a href="{{ route('exp.list.form', $result->id) }}"><button>평가단 신청하기</button></a>
                    </div>
                </div>
            </div>
        </div> <!-- 게시판 끝  -->




    </div><!-- 메인 컨테이너 끝 --



@endsection