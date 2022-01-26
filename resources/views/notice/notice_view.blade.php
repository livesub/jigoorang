@extends('layouts.head')

@section('content')



    <!-- 메인 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('notice') }}">지구를 구하는 기록</a></li>
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

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="list_view">
                        <div class="body bd_tt">
                        <div>
                           <div class="title_bd">{{ stripslashes($notice_info->n_subject) }}</div>
                            <div class="date cr_04 mt-10 mb-20">{{ $notice_info->created_at }}</div>
                        </div>

                            <div class="url_btn">
                                <button class="btn-bg-80">url 복사</button>
                            </div>

                        </div>
                <!-- 리스트 끝 -->
                <div class="list_contents">
                    <div class="list_img">
                        <img src="../../recources/imgs/sample_dt.png" alt="">
                    </div>
                    <div class="list_img_text">
                    <p>{!! $notice_info->n_content !!}
                    </p>
                    </div>
                </div>
            </div>



                <div class="btn_page"><!-- 페이지네이션 시작  -->
                    <button onclick="location.href='{{ route('notice', $link) }}'">목록</button>
                      <span>
                        @if($pre_cnt > 0)
                        <button onclick="location.href='{{ route('notice_view', $pre_link) }}'">이전</button>
                        @endif

                        @if($next_cnt > 0)
                        <button onclick="location.href='{{ route('notice_view', $next_link) }}'">다음</button>
                        @endif

                      </span>
                  </div><!-- 페이지네이션 끝  -->

            </div>
        </div>
    </div> <!-- 게시판 끝  -->




</div><!-- 메인 컨테이너 끝 -->







@endsection


