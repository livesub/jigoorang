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
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 쇼핑카테고리 시작  -->
        <div class="eval">

            <div class="board">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="scrollmenu">
                        <div class="swiper submenu">
                            <ul class="swiper-wrapper submenu_h">
                                @php
                                    $cate_num = 0;
                                @endphp
                                @foreach($cate_infos as $cate_info)
                                    @php
                                        $ca_id_class = '';
                                        if($ca_id == $cate_info->sca_id) $ca_id_class = "bct_active";
                                    @endphp
                                <a href="{{ route('sitem','ca_id='.$cate_info->sca_id.'&cate='.$cate_num) }}" class="swiper-slide">
                                <li class="sub_cate {{ $ca_id_class }}">{{ $cate_info->sca_name_kr }}</li>
                                <!-- class="bct_active" 메뉴활성 -->
                                </a>
                                    @php
                                        $cate_num++;
                                    @endphp
                                @endforeach
                            </ul>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                        </div>
                    </div>

                    <script>
                            if($(".sub_cate").hasClass("bct_active") === true) {
                                $(this).removeclass('sol_g_l')

                                } else {

                                    $(this).addclass('sol_g_l')
                                    // class가 존재하지않음 
                                }

                        </script>
                    </script>


                    <div class="scrollmenu sub_sol">
                        <div class="swiper submenu_sol">
                            <ul class="swiper-wrapper submenu_innr">
                              <li class="swiper-slide">
                              <a href="{{ route('sitem','ca_id='.$ca_id.'&cate='.$cate.'&sub_ca_id=all&sub_cate=0') }}">
                              @php
                                $class_all = '';
                                if($sub_ca_id == 'all' || $sub_ca_id == "")
                                $class_all = ' class="active" ';
                                $sub_cate_num = 1;
                              @endphp
                              <span {!! $class_all !!}>전체</span> <!-- class="active" 클릭시 class 활성-->
                              </a></li>

                              @foreach($sub_cate_infos as $sub_cate_info)
                                @php
                                    $class_chk = '';
                                    if($sub_ca_id == $sub_cate_info->sca_id) $class_chk = ' class="active" ';
                                @endphp
                              <li id="sd_{{ $sub_cate_info->id }}" class="swiper-slide">
                              <a href="{{ route('sitem','ca_id='.$ca_id.'&cate='.$cate.'&sub_ca_id='.$sub_cate_info->sca_id.'&sub_cate='.$sub_cate_num) }}">
                              <span {!! $class_chk !!}>{{ $sub_cate_info->sca_name_kr }}</span></a></li>
                                @php
                                    $sub_cate_num++;
                                @endphp
                              @endforeach

                            </ul>
                                <div class="swiper-button-prev01"></div>
                                <div class="swiper-button-next01"></div>
                        </div>
                    </div>

                    <div class="filter_bg block">
                        <ul class="filter_innner">
                        @php
                            $class_chk1 = 'fil_off';
                            $mark_chk1 = '⦁';
                            $selected_chk1 = '';
                            $class_chk2 = 'fil_off';
                            $mark_chk2 = '⦁';
                            $selected_chk2 = '';
                            $class_chk3 = 'fil_off';
                            $mark_chk3 = '⦁';
                            $selected_chk3 = '';
                            $class_chk4 = 'fil_off';
                            $mark_chk4 = '⦁';
                            $selected_chk4 = '';
                            $class_chk5 = 'fil_off';
                            $mark_chk5 = '⦁';
                            $selected_chk5 = '';

                            switch ($orderby_type) {
                                case 'recent':
                                    $class_chk1 = 'fil_on';
                                    $mark_chk1 = '✔';
                                    $selected_chk1 = 'selected';
                                    break;
                                case 'sale':
                                    $class_chk2 = 'fil_on';
                                    $mark_chk2 = '✔';
                                    $selected_chk2 = 'selected';
                                    break;
                                case 'high_price':
                                    $class_chk3 = 'fil_on';
                                    $mark_chk3 = '✔';
                                    $selected_chk3 = 'selected';
                                    break;
                                case 'low_price':
                                    $class_chk4 = 'fil_on';
                                    $mark_chk4 = '✔';
                                    $selected_chk4 = 'selected';
                                    break;
                                case 'review':
                                    $class_chk5 = 'fil_on';
                                    $mark_chk5 = '✔';
                                    $selected_chk5 = 'selected';
                                    break;
                                default:
                                    $class_chk1 = 'fil_on';
                                    $mark_chk1 = '✔';
                                    $selected_chk1 = 'selected';
                                    break;
                                }
                        @endphp
                            <li class="{{ $class_chk1 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&cate='.$cate.'&sub_ca_id='.$sub_ca_id.'&sub_cate='.$sub_cate.'&orderby_type=recent') }}'"><span>{{ $mark_chk1 }}</span> 등록순(최신순)</li> <!-- class="fil_on" 활성-->
                            <li class="{{ $class_chk2 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&cate='.$cate.'&sub_ca_id='.$sub_ca_id.'&sub_cate='.$sub_cate.'&orderby_type=sale') }}'"><span>{{ $mark_chk2 }}</span>판매량순</li><!-- class="fil_off" 비활성-->
                            <li class="{{ $class_chk3 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&cate='.$cate.'&sub_ca_id='.$sub_ca_id.'&sub_cate='.$sub_cate.'&orderby_type=high_price') }}'"><span>{{ $mark_chk3 }}</span>높은가격순</li>
                            <li class="{{ $class_chk4 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&cate='.$cate.'&sub_ca_id='.$sub_ca_id.'&sub_cate='.$sub_cate.'&orderby_type=low_price') }}'"><span>{{ $mark_chk4 }}</span>낮은가격순</li>
                            <li class="{{ $class_chk5 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&cate='.$cate.'&sub_ca_id='.$sub_ca_id.'&sub_cate='.$sub_cate.'&orderby_type=review') }}'"><span>{{ $mark_chk5 }}</span>후기많은순</li>
                        </ul>
                    </div>

                    <div class="filter_sel none">
                        <select class="filter_innner" onchange="location.href='{{ route('sitem','ca_id='.$ca_id.'&cate='.$cate.'&sub_ca_id='.$sub_ca_id.'&orderby_type=') }}'+this.value">
                            <option value="recent" {{ $selected_chk1 }}>등록순(최신순)</option>
                            <option value="sale" {{ $selected_chk2 }}>판매량순</option>
                            <option value="high_price" {{ $selected_chk3 }}>높은가격순</option>
                            <option value="low_price" {{ $selected_chk4 }}>낮은가격순</option>
                            <option value="review" {{ $selected_chk5 }}>후기숫자순</option>
                        </select>
                    </div>


                    @if($total_record > 0)
                    <div class="goods_list">

                        @foreach($item_infos as $item_info)
                            @php
                                if($item_info->item_img1 == "") {
                                    $item_img_disp = asset("img/no_img.jpg");
                                }else{
                                    $item_img_cut = explode("@@",$item_info->item_img1);

                                    if(count($item_img_cut) == 1) $item_img = $item_img_cut[0];
                                    else $item_img = $item_img_cut[2];

                                    $item_img_disp = "/data/shopitem/".$item_img;
                                }

                                //$dip_score = number_format($item_info->item_average, 2);
                                $dip_score = number_format($item_info->avg_score5, 2);

                                //응원하기 부분
                                if(Auth::user() != ""){
                                    $wish_chk = DB::table('wishs')->where([['user_id', Auth::user()->user_id], ['item_code', $item_info->item_code]])->count();
                                    $wish_class = "wishlist";
                                    if($wish_chk > 0) $wish_class = "wishlist_on";
                                }else{
                                    $wish_class = "wishlist";
                                }

                            @endphp
                        <div class="goods">

                            <div class="goods_img">
                                <a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}">
                                <img src="{{ $item_img_disp }}" alt="">
                                </a>
                            </div>

                            @if($item_info->item_type1 != 0)
                                {!! $CustomUtils->item_icon($item_info) !!}
                            @else
                                <div class="icon_none">
                                <p></p>
                                </div>
                            @endif

                            <div class="goods_title">
                                @php
                                    if($item_info->item_manufacture == "") $item_manufacture = "";
                                    else $item_manufacture = "[".$item_info->item_manufacture."]";
                                @endphp
                                <a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}"><h3>{{ $item_manufacture }} {{ stripslashes($item_info->item_name) }}</h3></a>

                                <span class="goods_left">
                                    <p class="price">{{ $CustomUtils->display_price($item_info->item_price, $item_info->item_tel_inq) }}</p>
                                    @if($item_info->item_cust_price != 0)
                                        @if($item_info->item_cust_price == $item_info->item_price)
                                            <p class="sale-price"></p>
                                        @else
                                            <p class="sale-price ml-10">{{ $CustomUtils->display_price($item_info->item_cust_price) }}</p>
                                        @endif
                                    @else
                                    <p class="sale-price"></p>
                                    @endif
                                </span>

                                <span class="goods_right">
                                @if($item_info->item_cust_price != 0)
                                    @php
                                        //시중가격 값이 있을때 할인율 계산
                                        $discount = (int)$item_info->item_cust_price - (int)$item_info->item_price; //할인액
                                        $discount_rate = ($discount / (int)$item_info->item_cust_price) * 100;  //할인율
                                        $disp_discount_rate = round($discount_rate);    //반올림1
                                    @endphp
                                    @if($disp_discount_rate != 0)
                                    <p>{{ $disp_discount_rate }}%</p>
                                    @else
                                    <p class="pct_list"></p>
                                    @endif
                                @else
                                    <p class="pct_list"></p>
                                @endif
                                </span>

                                <div class="goods_review" id="project_{{ $item_info->id }}">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">{{ $dip_score }}/5.00</p>
                                </div>

                                <script>
                                    star({{ $dip_score }},{{ $item_info->id }});
                                </script>

                                <div class="goods_bottom">
                                    <span class="left">
                                        <a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}#section1"><p>리뷰 {{ $item_info->review_cnt }}</p></a>
                                    </span>

                                    <span class="right">
                                        <p>응원하기</p>
                                        <span class="sns_wish {{ $wish_class }}" id="wish_css_{{ $item_info->item_code }}" onclick="item_wish('{{ $item_info->item_code }}', {{ Auth::user() }});"></span><!-- <span class="wishlist_on"></span> 활성-->
                                    </span>
                                </div>
                            </div>

                        </div>
                        @endforeach

                    </div>

                    @else
                    <div class="list-none">
                        <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                        <br><br>
                        <p>아직 등록된 제품이 없습니다.<br>
                            추천하고 싶은 제품이 있다면 언제든 지구랭에 알려주세요<br>
                            [고객센터 > 1:1문의]</p>
                    </div>
                    <div class="btn_area">
                        <a href="{{ route('customer_center') }}">
                            <button class="btn-20-bg">1:1 문의</button>
                        </a>
                    </div>
                    @endif

                </div>

                @if($total_record > 0)
                   <!-- 페이징 시작 -->
                <div class="paging">
                    {!! $pnPage !!}
                </div>
                <!-- 페이징 끝 -->
                @endif

            </div><!-- 리스트 끝 -->

        </div>
        <!-- 쇼핑카테고리 끝  -->



    </div>
    <!-- 메인 컨테이너 끝 -->


<input type="hidden" id="sub_cate" value="{{ $sub_cate }}">

<script src="{{ asset('/design/js/sub_menu.js') }}"></script>

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
                        $("#wish_css_"+item_code).addClass('wishlist_on');
                    }

                    if(result == "del"){
                        $("#wish_css_"+item_code).removeClass('wishlist_on');
                        $("#wish_css_"+item_code).addClass('wishlist');
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

<script>
    window.onload=function sub_slide() { //대 카테고리
        swiper3.slideTo('{{ $cate }}');
    }

    sub_m_slide('{{ $sub_cate }}'); // 서브 카테고리
</script>


@endsection
