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
                            @foreach($cate_infos as $cate_info)
                            <a href="{{ route('sitem','ca_id='.$cate_info->sca_id) }}">
                              <li class="swiper-slide">{{ $cate_info->sca_name_kr }}</li>
                            </a>
                            @endforeach
                            </ul>
                                <div class="swiper-button-next"></div>
                        </div>
                    </div>


                    <div class="scrollmenu sub_sol">
                        <div class="swiper submenu_sol">
                            <ul class="swiper-wrapper submenu_innr">
                              <a href="{{ route('sitem','ca_id=all') }}">
                              <li class="swiper-slide"><span class="active">전체</span></li> <!-- class="active" 클릭시 class 활성-->
                              </a>
                              @foreach($sub_cate_infos as $sub_cate_info)
                              <a href="{{ route('sitem','ca_id='.$sub_cate_info->sca_id) }}">
                              <li class="swiper-slide"><span>{{ $sub_cate_info->sca_name_kr }}</span></li>
                              </a>
                              @endforeach

                            </ul>
                                <div class="swiper-button-next01"></div>
                        </div>
                    </div>


                    <div class="filter_bg block">
                        <ul class="filter_innner">
                        @php
                            $class_chk1 = 'fil_off';
                            $mark_chk1 = '⦁';
                            $class_chk2 = 'fil_off';
                            $mark_chk2 = '⦁';
                            $class_chk3 = 'fil_off';
                            $mark_chk3 = '⦁';
                            $class_chk4 = 'fil_off';
                            $mark_chk4 = '⦁';
                            $class_chk5 = 'fil_off';
                            $mark_chk5 = '⦁';
                            switch ($orderby_type) {
                                case 'recent':
                                    $class_chk1 = 'fil_on';
                                    $mark_chk1 = '✔';
                                    break;
                                case 'sale':
                                    $class_chk2 = 'fil_on';
                                    $mark_chk2 = '✔';
                                    break;
                                case 'high_price':
                                    $class_chk3 = 'fil_on';
                                    $mark_chk3 = '✔';
                                    break;
                                case 'low_price':
                                    $class_chk4 = 'fil_on';
                                    $mark_chk4 = '✔';
                                    break;
                                case 'review':
                                    $class_chk5 = 'fil_on';
                                    $mark_chk5 = '✔';
                                    break;
                                default:
                                    $class_chk1 = 'fil_on';
                                    $mark_chk1 = '⦁';
                                }
                        @endphp
                            <li class="{{ $class_chk1 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&orderby_type=recent') }}'"><span>{{ $mark_chk1 }}</span> 등록순(최신순)</li> <!-- class="fil_on" 활성-->
                            <li class="{{ $class_chk2 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&orderby_type=sale') }}'"><span>{{ $mark_chk2 }}</span>판매량순</li><!-- class="fil_off" 비활성-->
                            <li class="{{ $class_chk3 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&orderby_type=high_price') }}'"><span>{{ $mark_chk3 }}</span>높은가격순</li>
                            <li class="{{ $class_chk4 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&orderby_type=low_price') }}'"><span>{{ $mark_chk4 }}</span>낮은가격순</li>
                            <li class="{{ $class_chk5 }}" onclick="location.href='{{ route('sitem','ca_id='.$ca_id.'&orderby_type=review') }}'"><span>{{ $mark_chk5 }}</span>후기숫자순</li>
                        </ul>
                    </div>

                    <div class="filter_sel none">
                        <select class="filter_innner">
                            <option>등록순(최신순)</option> <!-- class="fil_on" 활성-->
                            <option>판매량순</option><!-- class="fil_off" 비활성-->
                            <option>높은가격순</option>
                            <option>낮은가격순</option>
                            <option>후기숫자순</option>
                        </select>
                    </div>


                    <div class="goods_list">
                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
                                    <span class="left">
                                        <p>리뷰 200</p>
                                    </span>
                                    <span class="right">
                                        <p>응원하기</p>
                                        <span class="wishlist"></span><!-- <span class="wishlist_on"></span> 활성-->
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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


                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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


                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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

                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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

                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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


                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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


                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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


                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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

                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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


                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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


                        <div class="goods">

                            <div class="goods_img">
                                <img src="../../recources/imgs/img-01.png" alt="">
                            </div>

                            <div class="new-icon">
                                <p>NEW</p>
                            </div>

                            <div class="goods_title">

                                <h3>[SOAPURI]MINT SHAMPOOBAR10EA(1SET)</h3>

                                <span class="goods_left">
                                    <p class="price">7,000원</p>
                                    <p class="sale-price">10,000원</p>
                                </span>

                                <span class="goods_right">
                                    <p>30%</p>
                                </span>

                                <div class="goods_review project_1">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">4.10/5.00</p>
                                </div>

                                <div class="goods_bottom">
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


                   <!-- 페이징 시작 -->
                <div class="paging">
                    <a href="#">이전</a>
                    <div>1 / 20</div>
                    <a href="#">다음</a>
                </div>
                <!-- 페이징 끝 -->

            </div><!-- 리스트 끝 -->

        </div>
        <!-- 쇼핑카테고리 끝  -->



    </div>
    <!-- 메인 컨테이너 끝 -->





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




@endsection
