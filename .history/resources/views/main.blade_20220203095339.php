@extends('layouts.head')

@section('content')


                <!-- 공지 팝업 -->
            @if($pop_info != "")
                @php
                    $pop_img = explode("@@",$pop_info->pop_img);
                    $target = '';
                    if($pop_info->pop_target == 'N') $target = '_self';
                    else $target = '_blank';
                @endphp
            <div class="n_popup_con" id="popup">
                <div class="n_popup-back"></div>
                <div class="n_popup">
                    <a href="{{ $pop_info->pop_url }}" target="{{ $target }}">
                    <img src="{{ asset('data/popup/'.$pop_img[0]) }}"/>
                    </a>
                    <div class="n_btn">
                        <div class="n_btn_1">
                        <input type="checkbox" name="pop_today" id="pop_today" class="hd_pops_reject">
                        <label for="pop_today">1주일간 보지 않음</label>
                        </div>

                        <div class="n_btn_2" onclick="daycloseWin();">닫기</div>
                    </div>
                </div>
            </div>
            @endif

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
                        @foreach($recommend_ranks as $recommend_rank)
                            @php
                                //이미지 처리
                                if($recommend_rank->sca_img == "") {
                                    $rank_img_disp = asset("img/no_img.jpg");
                                }else{
                                    $rank_img_cut = explode("@@",$recommend_rank->sca_img);
                                    $rank_img_disp = "/data/shopcate/".$rank_img_cut[0];
                                }

                                $one_cate = $str = substr($recommend_rank->sca_id, 0, 2);
                            @endphp

                        <div class="swiper-slide">
                            <div class="sub-img">
                                <a href="{{ route('sitem','ca_id='.$one_cate.'&sub_ca_id='.$recommend_rank->sca_id) }}">
                                <img src="{{ $rank_img_disp }}" class="slide-best" alt="">
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>


            <!-- 리스트_02 -->
            <div class="mbox_100 bg_00">
                <div class="content">
                    <div class="inner">
                        <div class="title">
                            <h2>{{ $special_one_ment }}</h2>
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

                                @foreach($special_ones as $special_one)
                                    @php
                                        if($special_one->item_img1 == "") {
                                            $item_img_disp = asset("img/no_img.jpg");
                                        }else{
                                            $item_img_cut = explode("@@",$special_one->item_img1);

                                            if(count($item_img_cut) == 1) $item_img = $item_img_cut[0];
                                            else $item_img = $item_img_cut[2];

                                            $item_img_disp = "/data/shopitem/".$item_img;
                                        }

                                        //$dip_score = number_format($special_one->item_average, 2);
                                        $dip_score = number_format($special_one->avg_score5, 2);

                                        //응원하기 부분
                                        if(Auth::user() != ""){
                                            $wish_chk = DB::table('wishs')->where([['user_id', Auth::user()->user_id], ['item_code', $special_one->item_code]])->count();
                                            $wish_class = "wishlist";
                                            if($wish_chk > 0) $wish_class = "wishlist_on";
                                        }else{
                                            $wish_class = "wishlist";
                                        }
                                    @endphp

                                <div class="swiper-slide">
                                    <div class="sub-img-3">
                                        <a href="{{ route('sitemdetail') }}?item_code={{ $special_one->item_code }}">
                                        <img src="{{ $item_img_disp }}" class="slide-sale" alt=""></a>
                                    </div>


                                        @if($special_one->item_type1 != 0)
                                            {!! $CustomUtils->item_icon($special_one) !!}
                                        @else
                                            <div class="icon_none">
                                            <p></p>
                                            </div>
                                        @endif

                                        <div class="main-project-title">
                                        @php
                                            if($special_one->item_manufacture == "") $item_manufacture = "";
                                            else $item_manufacture = "[".$special_one->item_manufacture."]";
                                        @endphp
                                            <a href="{{ route('sitemdetail') }}?item_code={{ $special_one->item_code }}"><h3>{{ $item_manufacture }}{{ stripslashes($special_one->item_name) }}</h3></a>
                                            <span class="main-project-left">
                                                <p class="price">{{ $CustomUtils->display_price($special_one->item_price, $special_one->item_tel_inq) }}</p>
                                        @if($special_one->item_cust_price != 0)
                                                <p class="sale-price">{{ $CustomUtils->display_price($special_one->item_cust_price) }}</p>
                                        @else
                                                <p class="sale-price"></p>
                                        @endif
                                            </span>
                                            <span class="main-project-right">
                                        @if($special_one->item_cust_price != 0)
                                            @php
                                                //시중가격 값이 있을때 할인율 계산
                                                $discount = (int)$special_one->item_cust_price - (int)$special_one->item_price; //할인액
                                                $discount_rate = ($discount / (int)$special_one->item_cust_price) * 100;  //할인율
                                                $disp_discount_rate = round($discount_rate);    //반올림
                                            @endphp
                                            @if($disp_discount_rate != 0)
                                                <p>{{ $disp_discount_rate }}%</p>
                                            @endif
                                            @else
                                                <p class="pct_list"></p>
                                            @endif
                                            </span>
                                            <div class="project" id="shop_project_{{ $special_one->id }}">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">{{ $dip_score }}/5.00</p>
                                            </div>

                                            <script>
                                                shop_star({{ $dip_score }},{{ $special_one->id }});
                                            </script>

                                            <div class="main-project-bottom">
                                                 <a href="{{ route('sitemdetail') }}?item_code={{ $special_one->item_code }}#section1">
                                                    <span class="left">
                                                        <p>리뷰 {{ $special_one->review_cnt }}</p>
                                                    </span>
                                                </a>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="wish_class_{{ $special_one->item_code }} {{ $wish_class }}" onclick="item_wish('{{ $special_one->item_code }}', {{ Auth::user() }});"></span>
                                                </span>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                @endforeach

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
                            <h2>{{ $special_two_ment }}</h2>
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

                            @foreach($special_twos as $special_two)
                                @php
                                    if($special_two->item_img1 == "") {
                                        $item_img_disp = asset("img/no_img.jpg");
                                    }else{
                                        $item_img_cut = explode("@@",$special_two->item_img1);

                                        if(count($item_img_cut) == 1) $item_img = $item_img_cut[0];
                                        else $item_img = $item_img_cut[2];

                                        $item_img_disp = "/data/shopitem/".$item_img;
                                    }

                                    //$dip_score = number_format($special_two->item_average, 2);
                                    $dip_score = number_format($special_two->avg_score5, 2);

                                    //응원하기 부분
                                    if(Auth::user() != ""){
                                        $wish_chk = DB::table('wishs')->where([['user_id', Auth::user()->user_id], ['item_code', $special_two->item_code]])->count();
                                        $wish_class = "wishlist";
                                        if($wish_chk > 0) $wish_class = "wishlist_on";
                                    }else{
                                        $wish_class = "wishlist";
                                    }
                                @endphp
                            <div class="swiper-slide">
                                <div class="sub-img-3">
                                    <a href="{{ route('sitemdetail') }}?item_code={{ $special_two->item_code }}">
                                    <img src="{{ $item_img_disp }}" class="slide-sale" alt="">
                                    </a>
                                </div>

                                @if($special_two->item_type1 != 0)
                                    {!! $CustomUtils->item_icon($special_two) !!}
                                @else
                                    <div class="icon_none">
                                    <p></p>
                                    </div>
                                @endif

                                <div class="main-project-title">
                                @php
                                    if($special_two->item_manufacture == "") $item_manufacture = "";
                                    else $item_manufacture = "[".$special_two->item_manufacture."]";
                                @endphp
                                    <a href="{{ route('sitemdetail') }}?item_code={{ $special_two->item_code }}"><h3>{{ $item_manufacture }}{{ stripslashes($special_two->item_name) }}</h3></a>
                                    <span class="main-project-left">
                                        <p class="price">{{ $CustomUtils->display_price($special_two->item_price, $special_two->item_tel_inq) }}</p>
                                        @if($special_two->item_cust_price != 0)
                                        <p class="sale-price">{{ $CustomUtils->display_price($special_two->item_cust_price) }}</p>
                                        @else
                                        <p class="sale-price"></p>
                                        @endif
                                    </span>

                                    <span class="main-project-right">
                                    @if($special_two->item_cust_price != 0)
                                        @php
                                            //시중가격 값이 있을때 할인율 계산
                                            $discount = (int)$special_two->item_cust_price - (int)$special_two->item_price; //할인액
                                            $discount_rate = ($discount / (int)$special_two->item_cust_price) * 100;  //할인율
                                            $disp_discount_rate = round($discount_rate);    //반올림
                                        @endphp
                                   
                                        @if($disp_discount_rate != 0)
                                        <p>{{ $disp_discount_rate }}%</p>
                                        @endif
                                        @else
                                        <p class="pct_list"></p>
                                        @endif
                                    </span>


                                    <div class="project" id="shop_project3_{{ $special_two->id }}">
                                        <div class="stars-outer">
                                            <div class="stars-inner"></div>
                                        </div>
                                        <p class="number">{{ $dip_score }}/5.00</p>
                                    </div>
                                     <script>
                                        shop_star3({{ $dip_score }},{{ $special_two->id }});
                                    </script>

                                    <div class="main-project-bottom">
                                        <a href="{{ route('sitemdetail') }}?item_code={{ $special_two->item_code }}#section1">
                                            <span class="left">
                                                <p>리뷰 {{ $special_two->review_cnt }}</p>
                                            </span>
                                        </a>
                                        <span class="right">
                                            <p>응원하기</p>
                                            <span class="wish_class_{{ $special_two->item_code }} {{ $wish_class }}" onclick="item_wish('{{ $special_two->item_code }}', {{ Auth::user() }});"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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



                            @foreach($new_arrivals as $new_arrival)
                                @php
                                    if($new_arrival->item_img1 == "") {
                                        $item_img_disp = asset("img/no_img.jpg");
                                    }else{
                                        $item_img_cut = explode("@@",$new_arrival->item_img1);

                                        if(count($item_img_cut) == 1) $item_img = $item_img_cut[0];
                                        else $item_img = $item_img_cut[2];

                                        $item_img_disp = "/data/shopitem/".$item_img;
                                    }

                                    //$dip_score = number_format($new_arrival->item_average, 2);
                                    $dip_score = number_format($new_arrival->avg_score5, 2);

                                    //응원하기 부분
                                    if(Auth::user() != ""){
                                        $wish_chk = DB::table('wishs')->where([['user_id', Auth::user()->user_id], ['item_code', $new_arrival->item_code]])->count();
                                        $wish_class = "wishlist";
                                        if($wish_chk > 0) $wish_class = "wishlist_on";
                                    }else{
                                        $wish_class = "wishlist";
                                    }
                                @endphp
                            <div class="swiper-slide">

                                <div class="sub-img-3">
                                <a href="{{ route('sitemdetail') }}?item_code={{ $new_arrival->item_code }}">
                                    <img src="{{ $item_img_disp }}" class="slide-sale" alt="">
                                </a>
                                </div>

                                @if($new_arrival->item_type1 != 0)
                                    {!! $CustomUtils->item_icon($new_arrival) !!}
                                @else
                                <div class="icon_none">
                                <p></p>
                                </div>
                                @endif

                                <div class="main-project-title">
                                @php
                                    if($new_arrival->item_manufacture == "") $item_manufacture = "";
                                    else $item_manufacture = "[".$new_arrival->item_manufacture."]";
                                @endphp
                                    <a href="{{ route('sitemdetail') }}?item_code={{ $new_arrival->item_code }}"><h3>{{ $item_manufacture }}{{ stripslashes($new_arrival->item_name) }}</h3></a>
                                    <span class="main-project-left">
                                        <p class="price">{{ $CustomUtils->display_price($new_arrival->item_price, $new_arrival->item_tel_inq) }}</p>
                                @if($new_arrival->item_cust_price != 0)
                                        <p class="sale-price">{{ $CustomUtils->display_price($new_arrival->item_cust_price) }}</p>
                                @else
                                        <p class="sale-price"></p>
                                @endif
                                    </span>
                                    <span class="main-project-right">
                                @if($new_arrival->item_cust_price != 0)
                                    @php
                                        //시중가격 값이 있을때 할인율 계산
                                        $discount = (int)$new_arrival->item_cust_price - (int)$new_arrival->item_price; //할인액
                                        $discount_rate = ($discount / (int)$new_arrival->item_cust_price) * 100;  //할인율
                                        $disp_discount_rate = round($discount_rate);    //반올림
                                    @endphp
                                    @if($disp_discount_rate != 0)
                                        <p>{{ $disp_discount_rate }}%</p>
                                    @else
                                        <p class="pct_list"></p>
                                @endif
                                    </span>
                                    <div class="project" id="shop_project2_{{ $new_arrival->id }}">
                                        <div class="stars-outer">
                                            <div class="stars-inner"></div>
                                        </div>
                                        <p class="number">{{ $dip_score }}/5.00</p>
                                    </div>
                                    <script>
                                        shop_star2({{ $dip_score }},{{ $new_arrival->id }});
                                    </script>
                                    <div class="main-project-bottom">
                                        <a href="{{ route('sitemdetail') }}?item_code={{ $new_arrival->item_code }}#section1">
                                            <span class="left">
                                                <p>리뷰 {{ $new_arrival->review_cnt }}</p>
                                            </span>
                                        </a>
                                        <span class="right">
                                            <p>응원하기</p>
                                            <span class="wish_class_{{ $new_arrival->item_code }} {{ $wish_class }}" onclick="item_wish('{{ $new_arrival->item_code }}', {{ Auth::user() }});"></span>
                                        </span>
                                    </div>
                                </span>
                            </div>
                        </div>
                            @endforeach

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
                            @foreach($bottombanner_infos as $bottombanner_info)
                                @php
                                    //이미지 처리
                                    if($bottombanner_info->b_pc_img == "") {
                                        $bott_b_pc_img_disp = asset("img/no_img.jpg");
                                    }else{
                                        $bott_b_pc_img_cut = explode("@@",$bottombanner_info->b_pc_img);
                                        $bott_b_pc_img_disp = "/data/banner/".$bott_b_pc_img_cut[0];
                                    }

                                    $target = '';
                                    if($bottombanner_info->b_target == 'N') $bott_target = '_self';
                                    else $bott_target = '_blank';

                                    if($bottombanner_info->b_mobile_img == "") {
                                        $bott_b_mobile_img_disp = asset("img/no_img.jpg");
                                    }else{
                                        $bott_b_mobile_img_cut = explode("@@",$bottombanner_info->b_mobile_img);
                                        $bott_b_mobile_img_disp = "/data/banner/".$bott_b_mobile_img_cut[0];
                                    }
                                @endphp
                            <div class="swiper-slide">
                                <a href="{{ $bottombanner_info->b_link }}" target="{{ $bott_target }}"><img src="{{ $bott_b_pc_img_disp }}" alt="" class="pc"></a>
                                <a href="{{ $bottombanner_info->b_link }}" target="{{ $bott_target }}"><img src="{{ $bott_b_mobile_img_disp }}" alt="" class="mo"></a>
                            </div>
                            @endforeach

                            </div>
                            <div class="swiper-pagination main_pg"></div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- 메인 컨테이너 끝 -->


<script>
    // wish 상품보관
    function item_wish(item_code, auth)
    {
        if(auth == undefined){
            alert('회원만 이용 가능합니다.\n로그인 후 이용해 주세요');
            return false;
        }else{
            $.ajax({
                type: 'get',
                url: '{{ route('ajax_wish') }}',
                dataType: 'text',
                data: {
                    'item_code' : item_code,
                },
                success: function(result) {
    //alert(result);
    //return false;
                    if(result == "ok"){
                        $(".wish_class_" + item_code).removeClass('wishlist');
                        $(".wish_class_" + item_code).addClass('wishlist_on');
                    }

                    if(result == "del"){
                        $(".wish_class_" + item_code).removeClass('wishlist_on');
                        $(".wish_class_" + item_code).addClass('wishlist');
                    }

                    if(result == "no_item"){
                        alert('죄송합니다. 단종된 상품입니다.');
                        return false;
                    }
                },error: function(result) {
                    console.log(result);
                }
            });
        }
    }
</script>



<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('/design/js/swiper.js') }}"></script>
<script src="{{ asset('/design/js/notie_pop.js') }}"></script>


@endsection
