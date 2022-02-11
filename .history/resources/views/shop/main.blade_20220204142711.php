@extends('layouts.head')

@section('content')


    <!-- 메인 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('shop.index') }}">지구를 구하는 쇼핑</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area">
            <h2>지구쇼</h2>
            <div class="text_02 wt-nm">
                지구를 구하는 쇼핑<br>
                지구를 구하는 다양한 제품들을 지금 바로 만나보세요
            </div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 쇼핑카테고리 시작  -->
        <div class="eval">

            <div class="board">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="ctg_big">
                        @php
                            $cate = 0;
                        @endphp
                        @foreach($cate_infos as $cate_info)
                            @php
                                if($cate_info->sca_img == ""){
                                    $disp_img = asset("img/no_img.jpg");
                                }else{
                                    $disp_img_tmp = explode("@@", $cate_info->sca_img);
                                    $disp_img_cut = $disp_img_tmp[1];
                                    $disp_img = "/data/shopcate/".$disp_img_cut;
                                }
                            @endphp
                        <div class="box_menu">
                            <a href="{{ route('sitem','ca_id='.$cate_info->sca_id) }}">
                                <img src="{{ $disp_img }}" alt="">
                                <span>{{ $cate_info->sca_name_kr }}</span>
                            </a>
                        </div>
                        @endforeach

                    </div>
                </div>
                <!-- 리스트 끝 -->
            </div>

        </div>
        <!-- 쇼핑카테고리 끝  -->



    </div>
    <!-- 메인 컨테이너 끝 -->


@endsection
