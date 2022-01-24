@extends('layouts.head')

@section('content')


           <!-- 메인 컨테이너 시작 -->
           <div class="main-container">

            <!-- 상단 비주얼 영역 시작 -->
            <div class="visual">
                <div class="test">
                    <!-- Swiper -->
                    <div class="swiper mainSwiper">
                        <div class="swiper-wrapper">
                            @foreach($topbanner_infos as $topbanner_info)
                                @php
                                    //이미지 처리
                                    if($topbanner_info->b_pc_img == "") {
                                        $b_pc_img_disp = asset("img/no_img.jpg");
                                    }else{
                                        $b_pc_img_cut = explode("@@",$topbanner_info->b_pc_img);
                                        $b_pc_img_disp = "/data/banner/".$b_pc_img_cut[0];
                                    }

                                    $target = '';
                                    if($topbanner_info->b_target == 'N') $target = '_self';
                                    else $target = '_blank';

                                    if($topbanner_info->b_mobile_img == "") {
                                        $b_mobile_img_disp = asset("img/no_img.jpg");
                                    }else{
                                        $b_mobile_img_cut = explode("@@",$topbanner_info->b_mobile_img);
                                        $b_mobile_img_disp = "/data/banner/".$b_mobile_img_cut[0];
                                    }

                                    if($CustomUtils->is_mobile()) {
                                    $top_img = $b_pc_img_disp;
                                    // 모바일에서 작동
                                    } else {
                                    $top_img = $b_mobile_img_disp;
                                    // pc에서 작동
                                    }
                                @endphp
                            <div class="swiper-slide">
                                <a href="{{ $topbanner_info->b_link }}" target="{{ $target }}"><img src="{{ $b_pc_img_disp }}" alt="" class="pc"></a>
                                <a href="{{ $topbanner_info->b_link }}" target="{{ $target }}"><img src="{{ $b_mobile_img_disp }}" alt="" class="mo"></a>
                            </div>
                            @endforeach

                        </div>

                        <!-- <div class="swiper-button-next"></div> <div
                        class="swiper-button-prev"></div> -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
            <!-- 상단 비주얼 영역 끝 -->

            <!-- 리스트_01 -->
            <div class="mbox_1280">
                <h2>먼저 써 본 사람들의 추천랭킹</h2>
                <div class="slide_btn_1">
                    <div class="swiper-button-next-1"></div>
                    <div class="swiper-button-prev-1"></div>
                </div>
                <div class="title_w">
                    <div class="text_02">
                        친환경 제품을 먼저 사용해 본 ‘친환경 선배’들의 경험을 공유합니다. 궁금한 제품군을 선택해 보세요.
                    </div>
                </div>

                <div class="swiper bastSwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="sub-img">
                                <img src="./recources/imgs/img-01.png" class="slide-best" alt="">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="sub-img">
                                <img src="./recources/imgs/img-01.png" class="slide-best" alt="">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="sub-img">
                                <img src="./recources/imgs/img-01.png" class="slide-best" alt="">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="sub-img">
                                <img src="./recources/imgs/img-01.png" class="slide-best" alt="">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="sub-img">
                                <img src="./recources/imgs/img-01.png" class="slide-best" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="sub-img">
                                <img src="./recources/imgs/img-01.png" class="slide-best" alt="">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="sub-img">
                                <img src="./recources/imgs/img-01.png" class="slide-best" alt="">
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="sub-img">
                                <img src="./recources/imgs/img-01.png" class="slide-best" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- 리스트_02 -->
            <div class="mbox_100 bg_00">
                <div class="content">
                    <div class="inner">
                        <div class="title">
                            <h2>지구랭 기획전 #1</h2>
                            <div class="slide_btn_2">
                                <div class="swiper-button-next-2"></div>
                                <div class="swiper-button-prev-2"></div>
                            </div>
                            <div class="line_14"></div>
                        </div>
                    </div>

                    <div class="sale">
                        <div class="swiper saleSwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">

                                    <div class="sub-img-3">
                                        <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>

                                        <div class="new-icon">
                                            <p>NEW</p>
                                        </div>

                                        <div class="main-project-title">
                                            <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                            <span class="main-project-left">
                                                <p class="price">7,000원</p>
                                                <p class="sale-price">10,000원</p>
                                            </span>
                                            <span class="main-project-right">
                                                <p>30%</p>
                                            </span>
                                            <div class="project project_1">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">5.00</p>
                                            </div>
                                            <div class="main-project-bottom">
                                                <span class="left">
                                                    <p>리뷰 200</p>
                                                </span>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="wishlist"></span>
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="sub-img-3">
                                        <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>
                                        <div class="hot-icon">
                                            <p>HOT</p>
                                        </div>
                                        <div class="main-project-title">
                                            <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                            <span class="main-project-left">
                                                <p class="price">7,000원</p>
                                                <p class="sale-price">10,000원</p>
                                            </span>
                                            <span class="main-project-right">
                                                <p>30%</p>
                                            </span>
                                            <div class="project project_2">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">5.00</p>
                                            </div>
                                            <div class="main-project-bottom">
                                                <span class="left">
                                                    <p>리뷰 200</p>
                                                </span>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="wishlist"></span>
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="sub-img-3">
                                        <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>
                                        <div class="hot-icon">
                                            <p>HOT</p>
                                        </div>
                                        <div class="main-project-title">
                                            <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                            <span class="main-project-left">
                                                <p class="price">7,000원</p>
                                                <p class="sale-price">10,000원</p>
                                            </span>
                                            <span class="main-project-right">
                                                <p>30%</p>
                                            </span>
                                            <div class="project project_2">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">5.00</p>
                                            </div>
                                            <div class="main-project-bottom">
                                                <span class="left">
                                                    <p>리뷰 200</p>
                                                </span>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="wishlist"></span>
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="sub-img-3">
                                        <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>
                                        <div class="hot-icon">
                                            <p>HOT</p>
                                        </div>
                                        <div class="main-project-title">
                                            <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                            <span class="main-project-left">
                                                <p class="price">7,000원</p>
                                                <p class="sale-price">10,000원</p>
                                            </span>
                                            <span class="main-project-right">
                                                <p>30%</p>
                                            </span>
                                            <div class="project project_2">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">5.00</p>
                                            </div>
                                            <div class="main-project-bottom">
                                                <span class="left">
                                                    <p>리뷰 200</p>
                                                </span>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="wishlist"></span>
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="sub-img-3">
                                        <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>
                                        <div class="hot-icon">
                                            <p>HOT</p>
                                        </div>
                                        <div class="main-project-title">
                                            <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                            <span class="main-project-left">
                                                <p class="price">7,000원</p>
                                                <p class="sale-price">10,000원</p>
                                            </span>
                                            <span class="main-project-right">
                                                <p>30%</p>
                                            </span>
                                            <div class="project project_2">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">5.00</p>
                                            </div>
                                            <div class="main-project-bottom">
                                                <span class="left">
                                                    <p>리뷰 200</p>
                                                </span>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="wishlist"></span>
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="sub-img-3">
                                        <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>
                                        <div class="hot-icon">
                                            <p>HOT</p>
                                        </div>
                                        <div class="main-project-title">
                                            <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                            <span class="main-project-left">
                                                <p class="price">7,000원</p>
                                                <p class="sale-price">10,000원</p>
                                            </span>
                                            <span class="main-project-right">
                                                <p>30%</p>
                                            </span>
                                            <div class="project project_2">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">5.00</p>
                                            </div>
                                            <div class="main-project-bottom">
                                                <span class="left">
                                                    <p>리뷰 200</p>
                                                </span>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="wishlist"></span>
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 리스트_03 -->
            <div class="mbox_100 bg_01">
                <div class="inner">
                    <div class="main">
                        <div class="title">
                            <h2>지구랭 기획전 #2</h2>
                            <div class="slide_btn_3">
                                <div class="swiper-button-next-3"></div>
                                <div class="swiper-button-prev-3"></div>
                            </div>
                            <div class="line_14"></div>
                        </div>
                    </div>
                </div>

                <div class="sale">
                    <div class="swiper saleSwiper2">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="sub-img-3">
                                    <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>

                                    <div class="new-icon">
                                        <p>NEW</p>
                                    </div>

                                    <div class="main-project-title">
                                        <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                        <span class="main-project-left">
                                            <p class="price">7,000원</p>
                                            <p class="sale-price">10,000원</p>
                                        </span>
                                        <span class="main-project-right">
                                            <p>30%</p>
                                        </span>
                                        <div class="project project_1">
                                            <div class="stars-outer">
                                                <div class="stars-inner"></div>
                                            </div>
                                            <p class="number">5.00</p>
                                        </div>
                                        <div class="main-project-bottom">
                                            <span class="left">
                                                <p>리뷰 200</p>
                                            </span>
                                            <span class="right">
                                                <p>응원하기</p>
                                                <span class="wishlist"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="sub-img-3">
                                        <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>

                                        <div class="new-icon">
                                            <p>NEW</p>
                                        </div>

                                        <div class="main-project-title">
                                            <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                            <span class="main-project-left">
                                                <p class="price">7,000원</p>
                                                <p class="sale-price">10,000원</p>
                                            </span>
                                            <span class="main-project-right">
                                                <p>30%</p>
                                            </span>
                                            <div class="project project_1">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">5.00</p>
                                            </div>
                                            <div class="main-project-bottom">
                                                <span class="left">
                                                    <p>리뷰 200</p>
                                                </span>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="wishlist"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

            <!-- 리스트_04 시작 -->
            <div class="mbox_1280">
                <h2>New Arrivals</h2>
                <div class="slide_btn_4">
                    <div class="swiper-button-next-4"></div>
                    <div class="swiper-button-prev-4"></div>
                </div>
                <div class="line_14 bk"></div>

                <div class="sale">
                    <div class="swiper saleSwiper3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">

                                <div class="sub-img-3">
                                    <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>

                                    <div class="new-icon">
                                        <p>NEW</p>
                                    </div>

                                    <div class="main-project-title">
                                        <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                        <span class="main-project-left">
                                            <p class="price">7,000원</p>
                                            <p class="sale-price">10,000원</p>
                                        </span>
                                        <span class="main-project-right">
                                            <p>30%</p>
                                        </span>
                                        <div class="project project_1">
                                            <div class="stars-outer">
                                                <div class="stars-inner"></div>
                                            </div>
                                            <p class="number">5.00</p>
                                        </div>
                                        <div class="main-project-bottom">
                                            <span class="left">
                                                <p>리뷰 200</p>
                                            </span>
                                            <span class="right">
                                                <p>응원하기</p>
                                                <span class="wishlist"></span>
                                            </span>
                                        </div>
                                    </span>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="sub-img-3">
                                    <img src="./recources/imgs/img-01.png" class="slide-sale" alt=""></div>
                                    <div class="hot-icon">
                                        <p>HOT</p>
                                    </div>
                                    <div class="main-project-title">
                                        <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>
                                        <span class="main-project-left">
                                            <p class="price">7,000원</p>
                                            <p class="sale-price">10,000원</p>
                                        </span>
                                        <span class="main-project-right">
                                            <p>30%</p>
                                        </span>
                                        <div class="project project_2">
                                            <div class="stars-outer">
                                                <div class="stars-inner"></div>
                                            </div>
                                            <p class="number">5.00</p>
                                        </div>
                                        <div class="main-project-bottom">
                                            <span class="left">
                                                <p>리뷰 200</p>
                                            </span>
                                            <span class="right">
                                                <p>응원하기</p>
                                                <span class="wishlist"></span>
                                            </span>
                                        </div>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <!-- 리스트_04 끝 -->
            <!-- 하단 배너 시작 -->
            <div class="mbox_1280">
                <h2>친환경 메이커 소개</h2>

                <!-- 하단 배너 끝 -->
                <div class="sub_banner">
                    <!-- Swiper -->
                    <div class="swiper Swiper3">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <img src="./recources/imgs/img-ban-01@3x.png" alt="" class="pc">
                                <img src="./recources/bg/img-ban-01-m@3x.png" alt="" class="mo">
                            </div>

                            <div class="swiper-slide">
                                <img src="./recources/imgs/img-ban-01@3x.png" alt="" class="pc">
                                <img src="./recources/bg/img-ban-01-m@3x.png" alt="" class="mo">
                            </div>

                            <div class="swiper-slide">
                                <img src="./recources/imgs/img-ban-01@3x.png" alt="" class="pc">
                                <img src="./recources/bg/img-ban-01-m@3x.png" alt="" class="mo">
                            </div>

                            <div class="swiper-slide">
                                <img src="./recources/imgs/img-ban-01@3x.png" alt="" class="pc">
                                <img src="./recources/bg/img-ban-01-m@3x.png" alt="" class="mo">
                            </div>

                            <div class="swiper-slide">
                                <img src="./recources/imgs/img-ban-01@3x.png" alt="" class="pc">
                                <img src="./recources/bg/img-ban-01-m@3x.png" alt="" class="mo">
                            </div>

                            <div class="swiper-slide">
                                <img src="./recources/imgs/img-ban-01@3x.png" alt="" class="pc">
                                <img src="./recources/bg/img-ban-01-m@3x.png" alt="" class="mo">
                            </div>

                            <div class="swiper-slide">
                                <img src="./recources/imgs/img-ban-01@3x.png" alt="" class="pc">
                                <img src="./recources/bg/img-ban-01-m@3x.png" alt="" class="mo">
                            </div>

                            </div>
                            <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- 메인 컨테이너 끝 -->



<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('/design/js/swiper.js') }}"></script>
<!-- <script src="./js/star.js"></script> -->
<script src="{{ asset('/design/js/serach.js') }}"></script>
<script src="{{ asset('/design/js/serch_modal.js') }}"></script>
<script src="{{ asset('/design/js/sidenav.js') }}"></script>
<script src="{{ asset('/design/js/notie_pop.js') }}"></script>


@endsection
