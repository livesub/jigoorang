@extends('layouts.head')

@section('content')

<script src="{{ asset('/js/shop_js/shop.js') }}"></script>
<script src="{{ asset('/js/shop_js/shop_override.js') }}"></script>


            <!-- 메인 컨테이너 시작 -->
            <div class="sub-container">

                <!-- 위치 시작 -->
                <div class="location">
                    <ul>
                        <li>
                            <a href="/">홈</a>
                        </li>
                        <li>
                            <a href="{{ route('shop.index') }}">지구를 구하는 쇼핑</a>
                        </li>

                        @for($i = 0; $i < count($disp_sca_id); $i++)
                        <li>
                            <a href="{{ route('sitem', 'ca_id='.$disp_sca_id[$i]) }}">{{ $disp_cate_name[$i] }}</a>
                        </li>
                        @endfor

                    </ul>
                </div>
                <!-- 위치 끝 -->

                <!-- 타이틀 시작 -->
                <div class="title_area">
                    <!-- <div class="line_14-100"></div> -->
                </div>
                <!-- 타이틀 끝 -->

                <!-- 쇼핑카테고리 시작 -->
                <div class="eval">

                    <div class="board">
                        <!-- 리스트 시작 -->
                        <div class="board_wrap">
                            <div class="shop_goods">

                                <div class="shop_goods_dt_l">
                                    <div class="dt_som">  <!-- 썸네일 슬라이드 -->
                                        <div class="swiper som">
                                            <div class="swiper-wrapper">

                                                <!-- 슬라이드 -->
                                                @if(count($big_img_disp) > 0)
                                                    @for($k = 0; $k < count($big_img_disp); $k++)
                                                  <div class="swiper-slide">
                                                    <img src="{{ $big_img_disp[$k] }}" alt="" />
                                                  </div>
                                                    @endfor
                                                @else
                                                  <div class="swiper-slide">
                                                    <img src="{{ asset("img/no_img.jpg") }}" alt="" style="width:600px;"/>
                                                  </div>
                                                @endif

                                            </div>
                                            <!-- 스위퍼 페이지 네이션 -->
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>

                                    <div class="dt_sub_som">

                                        <div thumbsSlider="som" class="swiper som_b">
                                            <div class="swiper-wrapper">
                                              @for($m = 0; $m < count($small_img_disp); $m++)
                                              <div class="swiper-slide">
                                                <img src="{{ $small_img_disp[$m] }}" alt="" />
                                              </div>
                                              @endfor
                                            </div>
                                          </div>
                                          <!-- <div class="swiper-button-next"></div>
                                          <div class="swiper-button-prev"></div> -->
                                    </div>
                                </div>

<form name="fitem" id="fitem" method="post" action="{{ route('ajax_cart_register') }}">
{!! csrf_field() !!}
<input type="hidden" name="item_code[]" value="{{ $item_info->item_code }}">
<input type="hidden" name="ajax_option_url" id="ajax_option_url" value="{{ route('ajax_option_change') }}">
<input type="hidden" name="sw_direct" id="sw_direct">
<input type="hidden" name="url" id="url">

                                <div class="shop_goods_dt_r">
                                    @if($item_info->item_type1 != 0)
                                    <div class="hot-icon">
                                        <p>{!! $CustomUtils->item_icon($item_info) !!}</p>
                                    </div>
                                    @endif
                                    <div class="dt_tt">
                                        @php
                                            if($item_info->item_manufacture == "") $item_manufacture = "";
                                            else $item_manufacture = "[".$item_info->item_manufacture."]";
                                        @endphp
                                        <h3>{{ $item_manufacture }}{{ stripslashes($item_info->item_name) }}</h3>
                                        <div class="line_14-100-r"></div>
                                        <div class="dt_sub_tt">
                                            <p>{{ $item_info->item_basic }}</p>
                                        </div>
                                    </div>

                                    <div class="dt_pr">
                                        <ul class="dt_pr_tt">
                                            <li><h5>{{ $CustomUtils->display_price($item_info->item_price) }}</h5></li>
                                            @if($item_info->item_cust_price > 0)
                                                @if($disp_discount_rate != 0)
                                            <li><span>{{ $disp_discount_rate }}%할인</span></li>
                                                @endif
                                            @endif
                                            <input type="hidden" id="item_price" value="{{ $item_info->item_price }}">
                                        </ul>
                                        @if($item_info->item_cust_price > 0)
                                        <ul class="dt_pr_st">
                                            <li>정가 &nbsp;&nbsp;&nbsp; </li>
                                            <li>{{ $CustomUtils->display_price($item_info->item_cust_price) }}</li>
                                        </ul>
                                        @endif

                                        @if($item_info->item_point != "0")
                                        <ul class="dt_pr_st">
                                            <li>적립금</li>
                                            <li onclick="" class="dt_not tooltip">{{ $item_info->item_point }}%
                                                <span class="tooltiptext">
                                                    <!-- <div class="del"></div> -->
                                                    최종 적립 금액은 할인, 적립금 사용액, 배송료를 제외한 금액을 기준으로 적립되며 옵션 가격, 수량에 따라 달라질 수 있습니다
                                                </span>
                                            </li>
                                        </ul>
                                        @endif

                                        <ul class="dt_pr_st">
                                            <li>배송비</li>
                                            <li>{{ number_format($de_send_cost) }}원(도서산간일 경우 추가 배송비 발생)</li>
                                        </ul>
                                    </div>

                                    @if($option_item)
                                    <div class="dt_sel">
                                    {!! $option_item !!}
                                    </div>
                                    @endif

                                    <section id="sit_sel_option">
                                    @if(!$option_item)
                                    <div class="dt_pr_op">
                                        <ul class="dt_pr_op_nm">
                                            <li class="sit_opt_list">
                                                <input type="hidden" name="sio_type[{{ $item_info->item_code }}][]" value="0">
                                                <input type="hidden" name="sio_id[{{ $item_info->item_code }}][]" value="">
                                                <input type="hidden" name="sio_value[{{ $item_info->item_code }}][]" value="{{ $item_info->item_name }}">
                                                <input type="hidden" class="sio_price" value="0">
                                                <input type="hidden" class="sio_stock" value="{{ $item_info->item_stock_qty}}">
                                                <button type="button">-</button>
                                                    <input type="text" name="ct_qty[{{ $item_info->item_code }}][]" value="1" id="ct_qty_11" size="5" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                <button type="button">+</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <script>
                                        $(function() {
                                            price_calculate();
                                        });
                                    </script>
                                    @endif
                                    </section>


                                    <div class="dt_tta">
                                        <ul class="dt_total">
                                            <li><h4>총 상품금액</h4></li>
                                            <li class="cr_02" id="sit_tot_price"></li>
                                        </ul>
                                        <ul class="dt_dev">
                                            <li>배송비</li>
                                            <li>
                                                <span>{{ number_format($de_send_cost) }}원</span>
                                                @if($item_info->item_sc_price > 0)
                                                <p>(추가배송비 {{ $sc_method_disp }})</p>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="dt_btn_4ea">
                                        @if($is_orderable == false)
                                        <button type="button" class="btn_200_bg_g">품절</button>
                                        @else
                                        <button type="button" onclick="fitem_submit('cart');" class="btn_200_sol">장바구니</button>
                                        <button type="button" onclick="fitem_submit('buy');" class="btn_200_bg">바로구매</button>
                                        @endif

                                        @php
                                            //응원하기 부분
                                            $wish_chk = DB::table('wishs')->where([['user_id', Auth::user()->user_id], ['item_code', $item_info->item_code]])->count();
                                            $wish_class = "sns_wish";
                                            if($wish_chk > 0) $wish_class = "wishlist_on";
                                        @endphp
                                        <!-- id 바꾸지 마세요 -->
                                        <button type="button" id="wish_css_{{ $item_info->item_code }}" onclick="item_wish('{{ $item_info->item_code }}');" class="sns {{ $wish_class }}">응원하기</span><!-- wishlist_on -->
                                        <button class="sns sns_share">공유</button>
                                    </div>
                                </div>
                            </div>
</form>

                        <div class="shop_goods_ct">

                            <div class="shop_goods_dt_b">

                                <ul class="dt_sec_mn">
                                    <li data-link="#section1" class="dt_on">평가리뷰보기 ({{ $review_cnt }})</li>
                                    <li data-link="#section2">지구랭 체크</li>
                                    <li data-link="#section3">제품상세소개</li>
                                    <li data-link="#section4">상품문의</li>
                                </ul>

                                <div class="dt_con">

                                    <div class="dt_cot">
                                        <div id="section1" class="dt_hide"></div>

                                        <!-- 타이틀 시작 -->
                                         <div class="title_area">
                                            <h2>평가 리뷰</h2>
                                            <div class="line_14-100"></div>
                                        </div>
                                        <!-- 타이틀 끝 -->

                                        <div class="set1">

                                            <p class="set_tt">정량평가(20)</p>
                                                <div class="list-none dt_no">
                                                    <img src="../../recources/imgs/combined-shape@3x.png" alt="">
                                                    <br><br>
                                                    <p>평가를 기다리고 있어요</p>
                                                </div>

                                            <div class="dt_con_1">




                                                <div class="dt_star">

                                                    <div class="cot_rating_01" id="project_1">
                                                        <p>맛에대한 평가를 부탁을 한다오</p>
                                                        <div class="inline">
                                                            <div class="stars-outer">
                                                                <div class="stars-inner"></div>
                                                            </div>
                                                            <span class="number"></span>
                                                        </div>
                                                    </div>
                                                    <div class="cot_rating_01" id="project_1">
                                                        <p>사용후 만족도</p>
                                                        <div class="inline">
                                                            <div class="stars-outer">
                                                                <div class="stars-inner"></div>
                                                            </div>
                                                            <span class="number">4.10 (20)</span>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="dt_star">

                                                    <div class="cot_rating_01" id="project_1">
                                                        <p>사용후 만족도</p>
                                                        <div class="inline">
                                                            <div class="stars-outer">
                                                                <div class="stars-inner"></div>
                                                            </div>
                                                            <span class="number">4.10 (20)</span>
                                                        </div>
                                                    </div>
                                                    <div class="cot_rating_01" id="project_1">
                                                        <p>사용후 만족도44444</p>
                                                        <div class="inline">
                                                            <div class="stars-outer">
                                                                <div class="stars-inner"></div>
                                                            </div>
                                                            <span class="number">4.10 (20)</span>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="sol block"></div>
                                                <div class="sol-b none"></div>

                                                <div class="dt_star">

                                                    <div class="cot_rating_02" id="project_1">

                                                        <p>사용후 만족도</p>
                                                        <div class="inline">
                                                            <div class="stars-outer">
                                                                <div class="stars-inner"></div>
                                                            </div>
                                                            <p class="number">4.10 (20)</p>
                                                        </div>
                                                    </div>

                                                </div>







                                            </div>

                                            <div class="dt_con_2">
                                                <p class="set_tt">리뷰보기(20)</p>
                                                    <div class="list-none dt_no">
                                                        <img src="../../recources/imgs/combined-shape.png" alt="">
                                                        <br><br>
                                                        <p>평가를 기다리고 있어요</p>
                                                    </div>

                                                    <div class="cot_list">
                                                        <div class="cot_body">

                                                          <div class="cot_review mt-20 mb-20">
                                                              <div class="cot_id_day mb-20">
                                                                  <p class="cot_id">jig*****</p>
                                                                  <p class="cot_day">2021-10-10</p>
                                                              </div>
                                                              <div class="cot_box">
                                                                  <div class="cot_rating">
                                                                    <div class="cot_rating_02">
                                                                        <span>
                                                                          <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                          <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                    </div>
                                                                    <div class="cot_rating_01" id="project_1">
                                                                        <span>사용후 종합 만족도</span>
                                                                        <div class="inline">
                                                                            <div class="stars-outer">
                                                                                <div class="stars-inner"></div>
                                                                            </div>
                                                                            <p class="number">1.00</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                              </div>

                                                              <div class="cot_review_text">
                                                                    <p>포장도 깔끔하고 배송도 빠르고 제품도 맘에 들어요.<br>
                                                                    향이 너무 좋습니다.
                                                                    </p>

                                                                <div class="cot_more">
                                                                    <p>더보기</p>
                                                                    <span class="arr_bt"></span>
                                                                </div>

                                                                <div id="toggle" class="toggle">
                                                                    <p>지난번에 써보고 좋아서 다시 한번 주문했어요. <br>
                                                                    사람들이 추천하는 이유가 있는듯 합니다.<br>
                                                                    </p>

                                                                    <div class="cot_photo">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="" onclick="addressopenmodal_001()">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </div>


                                                        </div>
                                                    </div>
                                                    <div class="cot_list">

                                                        <div class="cot_body">

                                                          <div class="cot_review mt-20 mb-20">
                                                              <div class="cot_id_day mb-20">
                                                                  <p class="cot_id">jig*****</p>
                                                                  <p class="cot_day">2021-10-10</p>
                                                              </div>
                                                              <div class="cot_box">
                                                                  <div class="cot_rating">
                                                                    <div class="cot_rating_02">
                                                                        <span>
                                                                          <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                          <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                    </div>
                                                                    <div class="cot_rating_01" id="project_1">
                                                                        <span>사용후 만족도</span>

                                                                        <div class="inline">
                                                                            <div class="stars-outer">
                                                                                <div class="stars-inner"></div>
                                                                            </div>
                                                                            <p class="number"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                              </div>

                                                              <div class="cot_review_text">
                                                                    <p>포장도 깔끔하고 배송도 빠르고 제품도 맘에 들어요.<br>
                                                                    향이 너무 좋습니다.
                                                                    </p>

                                                                <div class="cot_more" onclick="toggle()">
                                                                    <p>더보기</p>
                                                                    <span class="arr_bt"></span>
                                                                </div>

                                                                <div id="toggle" class="toggle">
                                                                    <p>지난번에 써보고 좋아서 다시 한번 주문했어요. <br>
                                                                    사람들이 추천하는 이유가 있는듯 합니다.<br>
                                                                    </p>

                                                                    <div class="cot_photo">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </div>

                                                        </div>
                                                    </div>

                                                    <div class="cot_list">

                                                        <div class="cot_body">

                                                          <div class="cot_review mt-20 mb-20">
                                                              <div class="cot_id_day mb-20">
                                                                  <p class="cot_id">jig*****</p>
                                                                  <p class="cot_day">2021-10-10</p>
                                                              </div>
                                                              <div class="cot_box">
                                                                  <div class="cot_rating">
                                                                    <div class="cot_rating_02">
                                                                        <span>
                                                                          <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                          <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                        <span>
                                                                            <p class="text">맛에대한 평가를 부탁을한다오</p>
                                                                            <p class="bold">3.50</p>
                                                                        </span>
                                                                    </div>
                                                                    <div class="cot_rating_01" id="project_1">
                                                                        <span>사용후 만족도</span>

                                                                        <div class="inline">
                                                                            <div class="stars-outer">
                                                                                <div class="stars-inner"></div>
                                                                            </div>
                                                                            <p class="number"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                              </div>

                                                              <div class="cot_review_text">
                                                                    <p>포장도 깔끔하고 배송도 빠르고 제품도 맘에 들어요.<br>
                                                                    향이 너무 좋습니다.
                                                                    </p>

                                                                <div class="cot_more" onclick="toggle()">
                                                                    <p>더보기</p>
                                                                    <span class="arr_bt"></span>
                                                                </div>

                                                                <div id="toggle" class="toggle">
                                                                    <p>지난번에 써보고 좋아서 다시 한번 주문했어요. <br>
                                                                    사람들이 추천하는 이유가 있는듯 합니다.<br>
                                                                    </p>

                                                                    <div class="cot_photo">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </div>

                                                        </div>
                                                    </div>

                                                    <button class="btn-full-sd">리뷰 더보기</button>

                                                </div>
                                            </div>
                                        </div>




                                    <div class="dt_cot">

                                        <div id="section2" class="dt_hide"></div>

                                        <!-- 타이틀 시작 -->
                                        <div class="title_area">
                                            <h2>지구랭 체크</h2>
                                            <div class="line_14-100"></div>
                                        </div>
                                        <!-- 타이틀 끝 -->

                                        <div class="set1">

                                            <div class="dt_s_con">
                                                <p class="set_tt">진성분</p>
                                                <div class="dt_s_con_tt">
                                                    밀가루, 배추, 단백질, 색소, 딸기, 포도, 나트륨, 나무, 풀, 잡초, 밀가루, 배추, 단백질, 색소, 딸기, 포도, 나트륨, 나무, 풀, 잡초,밀가루, 배추, 단백질, 색소, 딸기, 포도, 나트륨, 나무, 풀, 잡초
                                                    색소, 딸기, 포도, 나트륨, 나무, 풀, 잡초, 밀가루, 배추, 단백질, 색소, 딸기, 포도, 나트륨, 나무, 풀, 잡초,밀가루, 배추, 단백질, 색소, 딸기, 포도, 나트륨, 나무, 풀, 잡초
                                                </div>
                                                <div class="dt_img"><img src="../../recources/imgs/list_img2.jpg" alt=""></div>
                                            </div>

                                            <div class="dt_s_con">
                                                <p class="set_tt">제품포장</p>
                                                <div class="dt_s_con_tt">
                                                    아주깔끔한 포장
                                                    걱정마시길
                                                </div>
                                            </div>

                                            <div class="dt_s_con">
                                                <p class="set_tt">분리 배출 방법</p>
                                                <div class="dt_s_con_tt">
                                                    분리배출 잘해 주세요<br>
                                                    부탁
                                                </div>
                                                <div class="dt_img"><img src="../../recources/imgs/list_img2.jpg" alt=""></div>
                                            </div>
                                            <div class="dt_s_con">
                                                <p class="set_tt">사회적 가치</p>
                                                <div class="dt_s_con_tt">
                                                    사회적가치를 창출하는 지구랭 상품<br>
                                                    안쓰면 서운함
                                                </div>
                                                <div class="dt_img"><img src="../../recources/imgs/list_img2.jpg" alt=""></div>
                                            </div>

                                        </div>

                                    </div>


                                    <div class="dt_cot">

                                        <div id="section3" class="dt_hide"></div>

                                         <!-- 타이틀 시작 -->
                                         <div class="title_area">
                                            <h2>제품 상세 보기</h2>
                                            <div class="line_14-100"></div>
                                        </div>
                                        <!-- 타이틀 끝 -->

                                        <div class="set1">
                                            <div class="dt_img"><img src="../../recources/imgs/list_img.jpg" alt=""></div>
                                        </div>

                                    </div>


                                    <div class="dt_cot">

                                        <div id="section4"class="dt_hide"></div>

                                         <!-- 타이틀 시작 -->
                                         <div class="title_area">
                                            <h2>상품 문의</h2>
                                            <div class="line_14-100"></div>
                                        </div>
                                        <!-- 타이틀 끝 -->

                                        <div class="set1">
                                            <button class="btn-full-sd">1:1 문의 페이지 이동</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        </div>
                    </div>
                    <!-- 리스트 끝 -->

                </div>
                <!-- 쇼핑카테고리 끝 -->

            </div>
            <!-- 메인 컨테이너 끝 -->

<script>
    // 스와이프 이벤트 (썸네일)
    var swiper = new Swiper(".som_b", {
        loop: true,
        spaceBetween: 5,
        slidesPerView: {{ $img_cnt }},   //상품등록 이미지 갯수
        freeMode: true,
        watchSlidesProgress: true,
        navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        },
    });
    var swiper2 = new Swiper(".som", {
        loop: true,
        spaceBetween: 0,
        navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        },

        pagination: {
            el: ".swiper-pagination",
        },

        thumbs: {
        swiper: swiper,
        },
    });
</script>

<script>
    //탭 슬라이드 메뉴
    let scroll_btn = document.querySelectorAll('.dt_sec_mn li');

    function clickMenuHandler() {
        for (let i = 0; i < scroll_btn.length; i++){
            scroll_btn[i].classList.remove('dt_on');
        }
        this.classList.add('dt_on');
    }

    for (let i = 0; i < scroll_btn.length; i++){
        scroll_btn[i].addEventListener('click', clickMenuHandler);
    }


    document.querySelector('.dt_sec_mn').addEventListener('click',e=>{
        if(e.target.nodeName === 'LI'){
            let id_value = e.target.dataset.link;
            document.querySelector(id_value).scrollIntoView({behavior : 'smooth'});
        }
    });
</script>

<script>
    // 바로구매, 장바구니 폼 전송
    function fitem_submit(type)
    {
        if (type == "cart") {   //장바구니
            $("#sw_direct").val(0);
        } else { // 바로구매
            $("#sw_direct").val(1);
        }

        if($(".sit_opt_list").length < 1) {
            alert("상품의 선택옵션을 선택해 주십시오.");
            return false;
        }

        var val, io_type, result = true;
        var sum_qty = 0;
        var $el_type = $("input[name^=sio_type]");

        $("input[name^=ct_qty]").each(function(index) {
            val = $(this).val();

            if(val.length < 1) {
                alert("수량을 입력해 주십시오.");
                result = false;
                return false;
            }

            if(val.replace(/[0-9]/g, "").length > 0) {
                alert("수량은 숫자로 입력해 주십시오.");
                result = false;
                return false;
            }

            if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
                alert("수량은 1이상 입력해 주십시오.");
                result = false;
                return false;
            }

            sio_type = $el_type.eq(index).val();

            if(sio_type == "0") sum_qty += parseInt(val);
        });

        if(!result) {
            return false;
        }

        var form_var = $("form[name=fitem]").serialize() ;

        $.ajax({
            type : 'post',
            url : '{{ route('ajax_cart_register') }}',
            data : form_var,
            dataType : 'text',
            success : function(result){
//alert(result);
//return false;
                var json = JSON.parse(result);
//alert(json.message);
//return false;
                if(json.message == "no_carts"){
                    alert("장바구니에 담을 상품을 선택하여 주십시오.");
                    return false;
                }

                if(json.message == "no_option"){
                    alert("상품의 선택옵션을 선택해 주십시오.");
                    return false;
                }

                if(json.message == "no_cnt"){
                    alert("수량은 1 이상 입력해 주십시오.");
                    return false;
                }

                if(json.message == "no_items"){
                    alert("상품정보가 존재하지 않습니다.");
                    return false;
                }

                if(json.message == "negative_price"){
                    alert("구매금액이 음수인 상품은 구매할 수 없습니다.");
                    return false;
                }

                if(json.message == "no_qty"){
                    alert(json.option + " 의 재고수량이 부족합니다.\n\n현재 재고수량 : " + json.sum_qty + " 개 이며\n\n이미 장바구니에 담겨 있습니다. ");
                    return false;
                }

                if(json.message == "no_qty2"){
                    alert(json.option + " 의 재고수량이 부족합니다.\n\n현재 재고수량 : " + json.sum_qty + " 개 이며\n\n이미 장바구니에 담겨 있습니다. ");
                    return false;
                }

                if(json.message == "yes_mem"){
                    location.href = "{{ route('orderform','sw_direct=1') }}";
                }

                if(json.message == "no_mem"){
                    //goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/orderform.php?sw_direct=$sw_direct"));
                    location.href = "";
                }

                if(json.message == "cart_page"){
                    location.href = "{{ route('cartlist') }}";
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    // wish 상품보관
    function item_wish(item_code)
    {
        $.ajax({
            type: 'get',
            url: '{{ route('ajax_wish') }}',
            dataType: 'text',
            data: {
                'item_code' : item_code,
            },
            success: function(result) {
alert(result);
return false;
                if(result == "ok"){
                    $("#wish_css_"+item_code).css("background-color", "#0000");
                }

                if(result == "del"){
                    $("#wish_css_"+item_code).css("background-color", "none");
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
</script>



@endsection
