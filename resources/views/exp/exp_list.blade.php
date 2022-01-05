@extends('layouts.head')

@section('content')



    <!-- 메인 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('exp.list') }}">정직한 평가단</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        @if(count($expAllLists) > 0)
        <!-- 타이틀 시작 -->
        <div class="title_area">
            <h2>정직한 평가단 모집</h2>
            <div class="text_02 wt-nm">
                지구랭은 친환경 제품의 사용 경험을 모으고 나눕니다.<br>
                지금 ‘정직한 평가단’을 신청하셔서, 여러분의 정직한 평가와 후기를 공유해주세요.
            </div>
            <div class="title_img">
            <img src="{{ asset('/design/recources/bg/img_sub_pc01@3x.png') }}" alt="" class="block">
            <img src="{{ asset('/design/recources/bg/img_sub_mo01@3x.jpg') }}" alt="" class="none">
            </div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 게시판 시작  -->
        <div class="eval">

            <div class="board">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                @foreach($expAllLists as $expAllList)
                    @php
                    //이미지 처리
                    if($expAllList->main_image_name == "") {
                        $main_image_name_disp = asset("img/no_img.jpg");
                    }else{
                        $main_image_name_cut = explode("@@",$expAllList->main_image_name);
                        $main_image_name_disp = "/data/exp_list/".$main_image_name_cut[1];
                    }
                    @endphp
                    <div class="list">
                        <div class="thumb">
                            <img src="{{ $main_image_name_disp }}">
                        </div>
                        <div class="body">
                            <div class="title">
                                {{ stripslashes($expAllList->title) }}
                            </div>
                            <dl>
                                <dt>모집인원</dt>
                                <dd>{{ $expAllList->exp_limit_personnel }}명</dd>
                                <dt>모집기간</dt>
                                <dd>{{ $expAllList->exp_date_start }} ~ {{ $expAllList->exp_date_end }}</dd>
                                <dt>평가 가능기간</dt>
                                <dd>{{ $expAllList->exp_review_start }} ~ {{ $expAllList->exp_review_end }}</dd>
                            </dl>
                        </div>
                        <div class="btn_area">
                            <a href="{{ route('exp.list.detail', $expAllList -> id) }}"><button>자세히 보기</button></a>
                        </div>
                    </div>
                    @endforeach

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

        @else
        <!-- data 가 없을때 -->
        <!-- 타이틀 시작 -->
        <div class="title_area">
            <h2>정직한 평가단 모집</h2>
            <div class="text_02 wt-nm">
                지구랭은 친환경 제품의 사용 경험을 모으고 나눕니다.<br>
                지금 ‘정직한 평가단’을 신청하셔서, 여러분의 정직한 평가와 후기를 공유해주세요.
            </div>
            <div class="title_img">
            <img src="{{ asset('/design/recources/bg/img_sub_pc01@3x.png') }}" alt="" class="block">
            <img src="{{ asset('/design/recources/bg/img_sub_mo01@3x.png') }}" alt="" class="none">
            </div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 게시판 시작  -->
        <div class="eval">

            <div class="board">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                        <div class="list-none">
                            <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                            <br><br>
                            <p>지금은 평가단 모집이 없습니다.</p>
                        </div>
                </div>
                <!-- 리스트 끝 -->
            </div>

        </div>
        <!-- 게시판 끝  -->

        @endif


    </div>
    <!-- 메인 컨테이너 끝 -->


@endsection