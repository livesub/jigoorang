@extends('layouts.head')

@section('content')


    <!-- 메인 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('ranking_list') }}">랭킹</a></li>
                <li><a href="{{ route('ranking_view', 'sca_id='.$rank_cate_navi->sca_id.'&sub_cate='.$sub_cate) }}">{{ stripslashes($rank_cate_navi->sca_name_kr) }}</a></li>
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

            <div class="board mypage_list">
                <!-- 랭킹 메뉴 시작 -->
                <div class="board_wrap">

                    <div class="scrollmenu sub_sol">
                        <div class="swiper submenu_sol">
                            <ul class="swiper-wrapper submenu_innr">
                            @php
                                $sub_cate_num = 0;
                            @endphp
                            @foreach($rank_cate_infos as $rank_cate_info)
                                @php
                                    if($rank_cate_info->sca_id == $sca_id) $sca_id_class = "active";
                                    else $sca_id_class = "";
                                @endphp
                              <li class="swiper-slide"><a href="{{ route('ranking_view','sca_id='.$rank_cate_info->sca_id.'&sub_cate='.$sub_cate_num) }}"><span class="{{ $sca_id_class }}">{{ $rank_cate_info->sca_name_kr }}</span></a></li>
                                @php
                                    $sub_cate_num++;
                                @endphp
                            @endforeach
                            </ul>
                                <div class="swiper-button-next01"></div>
                        </div>
                    </div>


                    <div class="filter_bg block">
                        <ul class="filter_innner">
                            @for($rating_num = 5; $rating_num >= 1; $rating_num--)
                                @php
                                    $item_name = 'item_name'.$rating_num;

                                    if($item_name_num == $rating_num){
                                        $class_chk[$rating_num] = 'fil_on';
                                        $mark_chk[$rating_num] = '✔';
                                    }else{
                                        if($item_name_num == ''){
                                            if($rating_num == 5){
                                                $class_chk[$rating_num] = 'fil_on';
                                                $mark_chk[$rating_num] = '✔';
                                            }else{
                                                $class_chk[$rating_num] = 'fil_off';
                                                $mark_chk[$rating_num] = '⦁';
                                            }
                                        }else{
                                            $class_chk[$rating_num] = 'fil_off';
                                            $mark_chk[$rating_num] = '⦁';
                                        }
                                    }
                                @endphp
                            <li class="{{ $class_chk[$rating_num] }}" onclick="location.href='{{ route('ranking_view','sca_id='.$sca_id.'&sub_cate='.$sub_cate_num.'&item_name_num='.$rating_num) }}'"><span>{{ $mark_chk[$rating_num] }}</span>{{ $rating_item_info->$item_name }}</li> <!-- class="fil_on" 활성-->
                            @endfor
                        </ul>
                        <ul class="filter_btn">
                            <a href="{{ route('company') }}">
                                <li>
                                    랭킹은 어떻게<br>
                                    산정될까요?
                                </li>
                            </a>
                        </ul>
                    </div>

                    <div class="rk_filter">
                        <div class="filter_sel none">
                            <select class="filter_innner" onchange="location.href='{{ route('ranking_view','sca_id='.$sca_id.'&sub_cate='.$sub_cate_num.'&item_name_num=') }}'+this.value">
                            @for($rating_num = 5; $rating_num >= 1; $rating_num--)
                                @php
                                    $item_name = 'item_name'.$rating_num;
                                    if($item_name_num == ""){
                                        if($rating_num == 5){
                                            $selected_chk[$rating_num] = "selected";
                                            $class_on[$rating_num] = "fil_on";
                                        }else{
                                            $selected_chk[$rating_num] = "";
                                            $class_on[$rating_num] = "fil_off";
                                        }
                                    }else{
                                        if($item_name_num == $rating_num){
                                            $selected_chk[$rating_num] = "selected";
                                            $class_on[$rating_num] = "fil_on";
                                        }else{
                                            $selected_chk[$rating_num] = "";
                                            $class_on[$rating_num] = "fil_off";
                                        }
                                    }
                                @endphp
                                <option class="{{ $class_on[$rating_num] }}" value="{{ $rating_num }}" {{ $selected_chk[$rating_num] }}>{{ $rating_item_info->$item_name }}</option>
                            @endfor
                            </select>
                        </div>


                        <div class="filter_btn none">
                            <a href="{{ route('company') }}#rink">
                                랭킹은 어떻게<br>
                                산정될까요?
                            </a>
                        </div>

                    </div>

                    <!-- 랭킹 메뉴 끝 -->
                            @if(count($item_infos) > 0)
                                @php

                                    $rk = 1;
                                @endphp
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

                                        //$dip_score = number_format($item_info->$avg_score, 2);
                                        $dip_score = number_format($item_info->$avg_score, 2);

                                        //응원하기 부분
                                        if(Auth::user() != ""){
                                            $wish_chk = DB::table('wishs')->where([['user_id', Auth::user()->user_id], ['item_code', $item_info->item_code]])->count();
                                            $wish_class = "wishlist";
                                            if($wish_chk > 0) $wish_class = "wishlist_on";
                                        }else{
                                            $wish_class = "wishlist";
                                        }
                                    @endphp

                            <div class="list ev_rul pd-00 mt-40">
                                <div class="wsl_lt pd-00">

                                    <div class="block_01">

                                        <div class="rk_num">
                                            @if($page == 1)
                                                @if($rk <= 3)
                                            <div class="rk_{{ $rk }}"></div>
                                                @else
                                                    <div class="rk_h4">{{ $virtual_num }}</div>
                                                @endif
                                            @else
                                            <div class="rk_h4">{{ $virtual_num }}</div>
                                            @endif

                                        </div>
                                        
                                        <div class="pr_img">
                                            <img src="{{ $item_img_disp }}" alt="">
                                        </div>

                                        <div class="pr_title">

                                        @if($item_info->item_type1 != 0)
                                            {!! $CustomUtils->item_icon($item_info) !!}
                                        @else
                                            <div class="icon_none">
                                            <p></p>
                                            </div>
                                        @endif
                                            <ul>
                                                <a href="">
                                                    <li class="mt-20">
                                        @php
                                            if($item_info->item_manufacture == "") $item_manufacture = "";
                                            else $item_manufacture = "[".$item_info->item_manufacture."]";
                                        @endphp
                                                        <a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}"><h4>{{ $item_manufacture }}{{ stripslashes($item_info->item_name) }}</h4></a>
                                                    </li>
                                                </a>
                                            </ul>

                                            <ul class="pdt-10">
                                            @if($item_info->item_cust_price != 0)
                                                @php
                                                    //시중가격 값이 있을때 할인율 계산
                                                    $discount = (int)$item_info->item_cust_price - (int)$item_info->item_price; //할인액
                                                    $discount_rate = ($discount / (int)$item_info->item_cust_price) * 100;  //할인율
                                                    $disp_discount_rate = round($discount_rate);    //반올림
                                                @endphp
                                                @if($disp_discount_rate != 0)
                                                <li class="pct">{{ $disp_discount_rate }}%</li>
                                                @endif
                                            @else
                                                <li class="pct"></li>
                                            @endif
                                                <li>
                                                    <span class="price">{{ $CustomUtils->display_price($item_info->item_price, $item_info->item_tel_inq) }}</span>
                                            @if($item_info->item_cust_price != 0)
                                                    <span class="sale-price">{{ $CustomUtils->display_price($item_info->item_cust_price) }}</span>
                                            @else
                                                    <span class="sale-price"></span>
                                            @endif

                                                </li>
                                            </ul>
                                        </div>

                                    </div>


                                    <div class="block_02 rk_list">

                                        <div class="star" id="project_{{ $item_info->id }}">
                                            <div class="stars-outer">
                                                <div class="stars-inner"></div>
                                            </div>
                                                <p class="number">{{ $dip_score }}/5.00</p>
                                        </div>

                                        <script>
                                            star({{ $dip_score }},{{ $item_info->id }});
                                        </script>

                                        <div class="re_num">
                                            <ul>
                                                <li>리뷰</li>
                                                <li>{{ $item_info->review_cnt }}</li>
                                            </ul>
                                        </div>

                                        <div class="heart">
                                            <p>응원하기</p>
                                            <div class="{{ $wish_class }}" id="wish_css_{{ $item_info->item_code }}" onclick="item_wish('{{ $item_info->item_code }}', {{ Auth::user() }});"></div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                                @php
                                    $virtual_num++;
                                    $rk++;
                                @endphp
                                @endforeach
                </div>


                <!-- 페이징 시작 -->
                    <div class="paging">
                        {!! $pnPage !!}
                    </div>
                <!-- 페이징 끝 -->

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
                </div>
            </div><!-- 리스트 끝 -->
        </div>
        <!-- 쇼핑카테고리 끝  -->
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





<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('/design/js/sub_menu.js') }}"></script>

<script>
//서브 슬라이드 메뉴 버튼 이벤트
let act_btn = document.querySelectorAll(".swiper-wrapper.submenu_innr .swiper-slide span");

function handleClick(event) {

  if (event.target.classList[1] === "active") {
    event.target.classList.remove("active");
  } else {
    for (var i = 0; i < act_btn.length; i++) {
        act_btn[i].classList.remove("active");
    }

    event.target.classList.add("active");
  }
}

function init() {
  for (var i = 0; i < act_btn.length; i++) {
    act_btn[i].addEventListener("click", handleClick);
  }
}

init();

</script>

<script>
    sub_m_slide('{{ $sub_cate }}');
</script>


@endsection
