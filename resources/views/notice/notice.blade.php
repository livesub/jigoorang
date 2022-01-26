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
            <h2>지구록</h2>
            <div class="text_02 wt-nm">
                지구를 구하는 기록<br>
                지구를 구하는 다양한 이야기를 지금 바로 만나보세요
            </div>
            <div class="title_img"></div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 게시판 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    @if(count($notice_infos) > 0)
                        @foreach($notice_infos as $notice_info)
                            @php
                                $n_img = explode("@@",$notice_info->n_img);
                            @endphp
                    <div class="list">
                        <div class="thumb">
                            <img src="{{ asset('/data/notice/'.$n_img[1]) }}" >
                        </div>
                        <div class="ev_rul">
                            <div class="title_bord"><a href="{{ route('notice_view','id='.$notice_info->id.'&page='.$page) }}">{{ stripslashes($notice_info->n_subject) }}</a></div>
                            <div class="sub_tt mt-10">{{ stripslashes($notice_info->n_explain) }}</div>
                            <div class="date">{{ substr($notice_info->created_at,0,10) }} </div>
                        </div>
                    </div>
                        @endforeach
                    @else
                    <div class="list-none">
                        <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                        <br><br>
                        <p>등록된 글이 없습니다.</p>
                    </div>
                    @endif

                </div>
                <!-- 리스트 끝 -->

                <!-- 페이징 시작 -->
                <div class="paging">
                    {!! $pnPage !!}
                </div>
                <!-- 페이징 끝 -->
            </div>

        </div>
        <!-- 게시판 끝  -->



    </div>
    <!-- 메인 컨테이너 끝 -->




@endsection


