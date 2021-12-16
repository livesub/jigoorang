@extends('layouts.head')

@section('content')



    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.qna_list') }}">1:1 문의 내역 / 답변</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>1:1 문의 내역 답변</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 1:1문의 내역 리스트 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="list view">
                        <div class="body">
                            <div class="title03">
                                <h4>{{ $qna_info->qna_cate }}</h4>
                                {{ stripslashes($qna_info->qna_subject) }}
                            </div>
                            <dl>
                                <dd>{{ $qna_info->created_at }}</dd>
                            </dl>
                        </div>

                        @if($qna_info->qna_answer == "")
                        <div class="title_sub point01"><!-- class="point01" (비활성) -->
                           <a href="javascript:void(0);" style="cursor:default;">답변대기</a>
                        </div>
                            @else
                        <div class="title_sub point02"> <!-- class="point02" (답변완료일때 활성) -->
                            <a href="javascript:void(0);" style="cursor:default;">답변완료</a>
                        </div>
                        @endif
                    </div>
                    <div class="list view">
                        <div class="body view">
                        <!--
                            <div class="ordernumber"><p>주문번호 000000000000</p></div>
                        -->
                            <div class="view_text">
                                {{ $qna_info->qna_content }}
                            </div>
                        </div>
                    </div>


                    @if($qna_info->qna_answer != "")
                    <div class="list view">
                        <div class="body view">
                           <div class="view_icon"><h4>관리자 답변</h4></div>
                            <div class="view_text_02">
                                {{ $qna_info->qna_answer }}
                            <p class="day">{{ $qna_info->updated_at }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
                <!-- 1:1문의 내역 리스트 끝  -->

                <div class="btn_page">
                  <button onclick="location.href='{{ route('mypage.qna_list', $link) }}'">목록</button>
                    <span>
                        @if($pre_cnt > 0)
                        <button onclick="location.href='{{ route('mypage.qna_view', $pre_link) }}'">이전</button>
                        @endif

                        @if($next_cnt > 0)
                        <button onclick="location.href='{{ route('mypage.qna_view', $next_link) }}'">다음</button>
                        @endif
                    </span>
                </div>

            </div>
        </div>
    </div>
    <!-- 서브 컨테이너 끝 -->








@endsection
