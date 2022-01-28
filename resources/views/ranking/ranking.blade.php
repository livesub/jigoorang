@extends('layouts.head')

@section('content')




    <!-- 메인 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('ranking_list') }}">지구를 구하는 랭킹</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area">
            <h2>지구랭</h2>
            <div class="text_02 wt-nm">
                지구를 구하는 랭킹<br>
                친환경 제품을 먼저 사용해 본 ‘친환경 선배’들의 경험을 공유합니다.
            </div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 쇼핑카테고리 시작  -->
        <div class="eval">

            <div class="board">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    @if(count($rank_cate_infos) > 0)
                    <div class="ctg_big">
                        @php
                            $num = 0;
                        @endphp
                        @foreach($rank_cate_infos as $rank_cate_info)
                            @php

                                if($rank_cate_info->sca_img == "") $sca_img = asset("img/no_img.jpg");
                                else{
                                    $sca_img_cut = explode("@@", $rank_cate_info->sca_img);
                                    $sca_img = "/data/shopcate/".$sca_img_cut[1];
                                }
                            @endphp
                            <div class="box_menu">
                                <a href="{{ route('ranking_view', 'sca_id='.$rank_cate_info->sca_id.'&sub_cate='.$num) }}">
                                    <img src="{{ $sca_img }}" alt="">
                                    <span>{{ stripslashes($rank_cate_info->sca_name_kr) }}</span>
                                </a>
                            </div>
                            @php
                                $num++;
                            @endphp
                        @endforeach

                    </div>
                    @else
                    <div class="list-none">
                        <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                        <br><br>
                        <p>등록된 랭킹이 없습니다</p>
                    </div>
                    @endif

                </div>
                <!-- 리스트 끝 -->
            </div>

        </div>
        <!-- 쇼핑카테고리 끝  -->



    </div>
    <!-- 메인 컨테이너 끝 -->



@endsection
