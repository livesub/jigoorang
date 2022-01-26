@extends('layouts.head')

@section('content')


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>검색결과</h2>
        </div>
        <!-- 타이틀 끝 -->

        <div class="serch_data">
            <span class="cr_02 bold">'{{ $search_w }}'</span> 검색결과
        </div>

        <!-- 고객센터 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="tab_menu">
                        <ul class="list_tab">
                            <li class="is_on">
                                <a href="{{ route('search', 'search_w='.$search_w) }}" class="btn_list">전체 ({{ number_format($total_cnt) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_shop', 'search_w='.$search_w) }}" class="btn_list">쇼핑 ({{ number_format($item_cnt) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_notice', 'search_w='.$search_w) }}" class="btn_list">소식 ({{ number_format(count($notice_infos)) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_exp', 'search_w='.$search_w) }}" class="btn_list">평가단 ({{ number_format(count($exp_infos)) }})</a>
                            </li>
                        </ul>

                        <div class="cont_area">
                            <div id="tab1" class="cont pd-00">
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
                                            }
                                    @endphp
                                        <li class="{{ $class_chk1 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=recent') }}'"><span>{{ $mark_chk1 }}</span> 등록순(최신순)</li> <!-- class="fil_on" 활성-->
                                        <li class="{{ $class_chk2 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=sale') }}'"><span>{{ $mark_chk2 }}</span>판매량순</li><!-- class="fil_off" 비활성-->
                                        <li class="{{ $class_chk3 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=high_price') }}'"><span>{{ $mark_chk3 }}</span>높은가격순</li>
                                        <li class="{{ $class_chk4 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=low_price') }}'"><span>{{ $mark_chk4 }}</span>낮은가격순</li>
                                        <li class="{{ $class_chk5 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=review') }}'"><span>{{ $mark_chk5 }}</span>후기숫자순</li>
                                    </ul>
                                </div>

                                <div class="filter_sel none">
                                    <select class="filter_innner" onchange="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=') }}'+this.value">
                                        <option value="recent" {{ $selected_chk1 }}>등록순(최신순)</option>
                                        <option value="sale" {{ $selected_chk2 }}>판매량순</option>
                                        <option value="high_price" {{ $selected_chk3 }}>높은가격순</option>
                                        <option value="low_price" {{ $selected_chk4 }}>낮은가격순</option>
                                        <option value="review" {{ $selected_chk5 }}>후기숫자순</option>
                                    </select>
                                </div>



                            <div id="tab2" class="cont pd-00">


                                <div class="filter_bg block">
                                    <ul class="filter_innner">
                                        <li class="fil_on" onclick=""><span>✔</span> 등록순(최신순)</li>
                                        <!-- class="fil_on" 활성-->
                                        <li class="fil_off" onclick=""><span>⦁</span>판매량순</li>
                                        <!-- class="fil_off" 비활성-->
                                        <li class="fil_off" onclick=""><span>⦁</span>높은가격순</li>
                                        <li class="fil_off" onclick=""><span>⦁</span>낮은가격순</li>
                                        <li class="fil_off" onclick=""><span>⦁</span>후기숫자순</li>
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
                                                    <span class="wishlist"></span>
                                                    <!-- <span class="wishlist_on"></span> 활성-->
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

                                <!-- 페이징 시작 -->
                                <div class="paging">
                                    <a href="#">이전</a>
                                    <div>1 / 20</div>
                                    <a href="#">다음</a>
                                </div>
                                <!-- 페이징 끝 -->

                            </div>


                            <div id="tab3" class="cont pd-00 mt-30">

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_01.png" >
                                    </div>

                                    <div class="ev_rul">

                                        <div class="title_bord">
                                            북금곰도 마음 돌리게 한 친환경 꿀단지를 소개 합니다. 꼭
                                            써보세요.</div>
                                        <div class="sub_tt mt-10">지구랭은 랭킹을 산정하는 친환경 브랜드 몰입니다. 랭킹을 산정하는 친환경 브랜드를 소개 합니다.</div>
                                        <div class="date">2020.11.14 </div>

                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_01.png" >
                                    </div>

                                    <div class="ev_rul">

                                        <div class="title_bord">
                                            북금곰도 마음 돌리게 한 친환경 꿀단지를 소개 합니다. 꼭
                                            써보세요.</div>
                                        <div class="sub_tt mt-10">지구랭은 랭킹을 산정하는 친환경 브랜드 몰입니다. 랭킹을 산정하는 친환경 브랜드를 소개 합니다.</div>
                                        <div class="date">2020.11.14 </div>

                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_01.png" >
                                    </div>

                                    <div class="ev_rul">

                                        <div class="title_bord">
                                            북금곰도 마음 돌리게 한 친환경 꿀단지를 소개 합니다. 꼭
                                            써보세요.</div>
                                        <div class="sub_tt mt-10">지구랭은 랭킹을 산정하는 친환경 브랜드 몰입니다. 랭킹을 산정하는 친환경 브랜드를 소개 합니다.</div>
                                        <div class="date">2020.11.14 </div>

                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_01.png" >
                                    </div>

                                    <div class="ev_rul">

                                        <div class="title_bord">
                                            북금곰도 마음 돌리게 한 친환경 꿀단지를 소개 합니다. 꼭
                                            써보세요.</div>
                                        <div class="sub_tt mt-10">지구랭은 랭킹을 산정하는 친환경 브랜드 몰입니다. 랭킹을 산정하는 친환경 브랜드를 소개 합니다.</div>
                                        <div class="date">2020.11.14 </div>

                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_01.png" >
                                    </div>

                                    <div class="ev_rul">

                                        <div class="title_bord">
                                            북금곰도 마음 돌리게 한 친환경 꿀단지를 소개 합니다. 꼭
                                            써보세요.</div>
                                        <div class="sub_tt mt-10">지구랭은 랭킹을 산정하는 친환경 브랜드 몰입니다. 랭킹을 산정하는 친환경 브랜드를 소개 합니다.</div>
                                        <div class="date">2020.11.14 </div>

                                    </div>
                                </div>

                                <!-- 페이징 시작 -->
                                <div class="paging">
                                    <a href="#">이전</a>
                                    <div>1 / 20</div>
                                    <a href="#">다음</a>
                                </div>
                                <!-- 페이징 끝 -->


                            </div>


                            <div id="tab4" class="cont pd-00 mt-30">


                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_02.png" >
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            북금곰도 친환경 꿀단지
                                        </div>
                                        <dl>
                                            <dt>평가단 모집인원</dt>
                                            <dd>100명</dd>
                                            <dt>모집기간</dt>
                                            <dd>2021.01.01 ~ 2021.10~31</dd>
                                            <dt>평가 가능기간</dt>
                                            <dd>2021.11.01 ~ 2021.11~30</dd>
                                        </dl>
                                    </div>
                                    <div class="btn_area">
                                        <a href="../../page/evaluation/evaluation_list_view.html"><button>자세히 보기</button></a>
                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_02.png" >
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            북금곰도 친환경 꿀단지
                                        </div>
                                        <dl>
                                            <dt>평가단 모집인원</dt>
                                            <dd>100명</dd>
                                            <dt>모집기간</dt>
                                            <dd>2021.01.01 ~ 2021.10~31</dd>
                                            <dt>평가 가능기간</dt>
                                            <dd>2021.11.01 ~ 2021.11~30</dd>
                                        </dl>
                                    </div>
                                    <div class="btn_area">
                                        <a href="../../page/evaluation/evaluation_list_view.html"><button>자세히 보기</button></a>
                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_02.png" >
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            북금곰도 친환경 꿀단지
                                        </div>
                                        <dl>
                                            <dt>평가단 모집인원</dt>
                                            <dd>100명</dd>
                                            <dt>모집기간</dt>
                                            <dd>2021.01.01 ~ 2021.10~31</dd>
                                            <dt>평가 가능기간</dt>
                                            <dd>2021.11.01 ~ 2021.11~30</dd>
                                        </dl>
                                    </div>
                                    <div class="btn_area">
                                        <a href="../../page/evaluation/evaluation_list_view.html"><button>자세히 보기</button></a>
                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_02.png" >
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            북금곰도 친환경 꿀단지
                                        </div>
                                        <dl>
                                            <dt>평가단 모집인원</dt>
                                            <dd>100명</dd>
                                            <dt>모집기간</dt>
                                            <dd>2021.01.01 ~ 2021.10~31</dd>
                                            <dt>평가 가능기간</dt>
                                            <dd>2021.11.01 ~ 2021.11~30</dd>
                                        </dl>
                                    </div>
                                    <div class="btn_area">
                                        <a href="../../page/evaluation/evaluation_list_view.html"><button>자세히 보기</button></a>
                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_02.png" >
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            북금곰도 친환경 꿀단지
                                        </div>
                                        <dl>
                                            <dt>평가단 모집인원</dt>
                                            <dd>100명</dd>
                                            <dt>모집기간</dt>
                                            <dd>2021.01.01 ~ 2021.10~31</dd>
                                            <dt>평가 가능기간</dt>
                                            <dd>2021.11.01 ~ 2021.11~30</dd>
                                        </dl>
                                    </div>
                                    <div class="btn_area">
                                        <a href="../../page/evaluation/evaluation_list_view.html"><button>자세히 보기</button></a>
                                    </div>
                                </div>

                                <div class="list">
                                    <div class="thumb">
                                        <img src="../../recources/imgs/thumb_eval_02.png" >
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            북금곰도 친환경 꿀단지
                                        </div>
                                        <dl>
                                            <dt>평가단 모집인원</dt>
                                            <dd>100명</dd>
                                            <dt>모집기간</dt>
                                            <dd>2021.01.01 ~ 2021.10~31</dd>
                                            <dt>평가 가능기간</dt>
                                            <dd>2021.11.01 ~ 2021.11~30</dd>
                                        </dl>
                                    </div>
                                    <div class="btn_area">
                                        <a href="../../page/evaluation/evaluation_list_view.html"><button>자세히 보기</button></a>
                                    </div>
                                </div>

                                <!-- 페이징 시작 -->
                                <div class="paging">
                                    <a href="#">이전</a>
                                    <div>1 / 20</div>
                                    <a href="#">다음</a>
                                </div>
                                <!-- 페이징 끝 -->


                            </div>

                        </div>
                    </div>
                </div>
                <!-- 고객센터 끝  -->

           </div>
       </div>
   </div>
  <!-- 서브 컨테이너 끝 -->


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


<script src="{{ asset('/design/js/sidenav.js') }}"></script>
<script src="{{ asset('/design/js/modal.js') }}"></script>


@endsection


