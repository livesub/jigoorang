@extends('layouts.head')

@section('content')


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.review_possible_list') }}">제품 평가 및 리뷰</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>제품 평가 및 리뷰</h2>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 고객센터 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="tab_menu">
                        <ul class="list_tab">
                            <li>
                                <a href="{{ route('mypage.review_possible_list') }}" class="btn_list">작성 가능 리뷰</a>
                            </li>
                            <li class="is_on">
                                <a href="{{ route('mypage.review_my_list') }}" class="btn_list">내가 쓴 리뷰</a>
                            </li>
                        </ul>

                        <div class="cont_area">
                            <!-- tab2 시작 -->
                            <div class="cont cont_wrap">
                              <div class="notie">삭제된 리뷰일 경우 확인이 불가합니다.</div>
                              <div class="fleter">
                            @php
                                $disp_one_month = 'off';
                                $disp_three_month = 'off';
                                $disp_six_month = 'off';
                                $disp_one_year = 'off';
                                $disp_three_year = 'off';
                                $disp_all = 'off';

                                switch($date_type)
                                {
                                    case 'one_month':
                                        $disp_one_month = 'on';
                                        break;

                                    case 'three_month':
                                        $disp_three_month = 'on';
                                        break;

                                    case 'six_month':
                                        $disp_six_month = 'on';
                                        break;

                                    case 'one_year':
                                        $disp_one_year = 'on';
                                        break;

                                    case 'three_year':
                                        $disp_three_year = 'on';
                                        break;

                                    case 'all':
                                        $disp_all = 'on';
                                        break;

                                    default:
                                        $disp_one_month = 'on';
                                        break;
                                }

                            @endphp
                                <button class="{{ $disp_one_month }}" onclick="location.href='{{ route('mypage.review_my_list', 'date_type=one_month') }}'">1개월내</button><!-- 활성일때 class="on"-->
                                <button class="{{ $disp_three_month }}" onclick="location.href='{{ route('mypage.review_my_list', 'date_type=three_month') }}'">3개월내</button><!-- 비활성일때 class="off"-->
                                <button class="{{ $disp_six_month }}" onclick="location.href='{{ route('mypage.review_my_list', 'date_type=six_month') }}'">6개월내</button>
                                <button class="{{ $disp_one_year }}" onclick="location.href='{{ route('mypage.review_my_list', 'date_type=one_year') }}'">1년내</button>
                                <button class="{{ $disp_three_year }}" onclick="location.href='{{ route('mypage.review_my_list', 'date_type=three_year') }}'">3년내</button>
                                <button class="{{ $disp_all }}" onclick="location.href='{{ route('mypage.review_my_list', 'date_type=all') }}'">전체</button>
                              </div>

                              <div class="cot_list">
                                <h4 class="mt-20 mb-20">평가단 선정</h4>


                                <div class="cot_body">
                                    <p class="cr_04 mb-20">2021.10.11</p>
                                    <img src="../../recources/imgs/sample_img.png" alt="">
                                    <div class="info tab">
                                        <div class="rm_v">삭제된리뷰</div>
                                        <p>2021 가을 맞이 대나무 칫솔  평가단</p>
                                        <p>40,00명 대모집</p>
                                    </div>

                                  <div class="cot_review mt-20 mb-20">
                                      <div class="cot_id_day mb-20">
                                          <p class="cot_id">jig*****</p>
                                          <p class="cot_day">2021-10-10</p>
                                      </div>
                                      <div class="cot_box">
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
                                            <div class="stars-outer">
                                                <div class="stars-inner"></div>
                                            </div>
                                            <p class="number"></p>
                                        </div>
                                      </div>

                                      <div class="cot_review_text">
                                            <p>포장도 깔끔하고 배송도 빠르고 제품도 맘에 들어요.<br>
                                            향이 너무 좋습니다. <br>
                                            지난번에 써보고 좋아서 다시 한번 주문했어요. <br>
                                            사람들이 추천하는 이유가 있는듯 합니다.<br>
                                            </p>
                                      </div>

                                        <div class="cot_more">
                                            <p>더보기</p>
                                            <span class="arr_bt"></span>
                                        </div>

                                        <div class="cot_photo">
                                            <img src="../../recources/imgs/sample_img.png" alt="">
                                            <img src="../../recources/imgs/sample_img.png" alt="">
                                            <img src="../../recources/imgs/sample_img.png" alt="">
                                            <img src="../../recources/imgs/sample_img.png" alt="">
                                            <img src="../../recources/imgs/sample_img.png" alt="">
                                        </div>

                                  </div>


                                </div>

                                <div class="cot_body">
                                    <p class="cr_04 mb-20">2021.10.11</p>
                                    <img src="../../recources/imgs/sample_img.png" alt="">
                                    <div class="info">
                                        <p>2021 가을 맞이 대나무 칫솔  평가단</p>
                                        <p>40,00명 대모집</p>
                                    </div>
                                    <div class="cot_review mt-20 mb-20">
                                        <div class="cot_id_day mb-20">
                                            <p class="cot_id">jig*****</p>
                                            <p class="cot_day">2021-10-10</p>
                                        </div>
                                        <div class="cot_box">

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

                                            <div class="cot_rating_01">
                                                <span>사용후 만족도</span>
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number"></p>
                                            </div>
                                        </div>

                                        <div class="cot_review_text">
                                              <p>포장도 깔끔하고 배송도 빠르고 제품도 맘에 들어요.<br>
                                              향이 너무 좋습니다. <br>
                                              지난번에 써보고 좋아서 다시 한번 주문했어요. <br>
                                              사람들이 추천하는 이유가 있는듯 합니다.<br>
                                              </p>
                                        </div>

                                          <div class="cot_more">
                                              <p>더보기</p>
                                              <span class="arr_bt"></span>
                                          </div>

                                          <div class="cot_photo">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                          </div>

                                    </div>
                                </div>

                                <button class="btn-full-sd">내가 쓴 리뷰 더보기</button>
                            </div>

                                <div class="line_15 bk"></div>

                            <div class="cot_list">
                                <h4 class="mt-20 mb-20">쇼핑</h4>

                                <div class="cot_body">
                                    <p class="cr_04 mb-20">2021.10.11</p>
                                    <img src="../../recources/imgs/sample_img.png" alt="">
                                    <div class="info">
                                        <p>2021 가을 맞이 대나무 칫솔  평가단</p>
                                        <p>40,00명 대모집</p>
                                    </div>

                                    <div class="cot_review mt-20 mb-20">
                                        <div class="cot_id_day mb-20">
                                            <p class="cot_id">jig*****</p>
                                            <p class="cot_day">2021-10-10</p>
                                        </div>
                                        <div class="cot_box">

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

                                            <div class="cot_rating_01">
                                                <span>사용후 만족도</span>
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number"></p>
                                            </div>

                                        </div>

                                        <div class="cot_review_text">
                                              <p>포장도 깔끔하고 배송도 빠르고 제품도 맘에 들어요.<br>
                                              향이 너무 좋습니다. <br>
                                              지난번에 써보고 좋아서 다시 한번 주문했어요. <br>
                                              사람들이 추천하는 이유가 있는듯 합니다.<br>
                                              </p>
                                        </div>

                                          <div class="cot_more">
                                              <p>더보기</p>
                                              <span class="arr_bt"></span>
                                          </div>

                                          <div class="cot_photo">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                          </div>

                                    </div>
                                </div>
                                <div class="cot_body">
                                    <p class="cr_04 mb-20">2021.10.11</p>
                                    <img src="../../recources/imgs/sample_img.png" alt="">
                                    <div class="info">
                                        <p>2021 가을 맞이 대나무 칫솔  평가단</p>
                                        <p>40,00명 대모집</p>
                                    </div>
                                    <div class="cot_review mt-20 mb-20">
                                        <div class="cot_id_day mb-20">
                                            <p class="cot_id">jig*****</p>
                                            <p class="cot_day">2021-10-10</p>
                                        </div>
                                        <div class="cot_box">

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

                                            <div class="cot_rating_01">
                                                <span>사용후 만족도</span>
                                                  <div class="stars-outer">
                                                      <div class="stars-inner"></div>
                                                  </div>
                                                  <p class="number"></p>
                                            </div>

                                        </div>

                                        <div class="cot_review_text">
                                              <p>포장도 깔끔하고 배송도 빠르고 제품도 맘에 들어요.<br>
                                              향이 너무 좋습니다. <br>
                                              지난번에 써보고 좋아서 다시 한번 주문했어요. <br>
                                              사람들이 추천하는 이유가 있는듯 합니다.<br>
                                              </p>
                                        </div>

                                          <div class="cot_more">
                                              <p>더보기</p>
                                              <span class="arr_bt"></span>
                                          </div>

                                          <div class="cot_photo">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                              <img src="../../recources/imgs/sample_img.png" alt="">
                                          </div>

                                    </div>
                                </div>
                                <button class="btn-full-sd">내가 쓴 리뷰 더보기</button>
                            </div>

                            </div>
                        </div>
                    </div>
                <!-- 고객센터 끝  -->

                </div>
            </div>
        </div>
    </div>
    <!-- 서브 컨테이너 끝 -->


























<!--
<div class='page-header'>
      <h4>
            마이페이지
      </h4>
</div>

<table border=1>
    <tr>
        <td><span onclick="location.href='{{ route('mypage.review_possible_list') }}'">작성가능리뷰</a></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list') }}'">내가쓴리뷰</span></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=one_month') }}'">1개월내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=three_month') }}'">3개월내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=six_month') }}'">6개월내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=one_year') }}'">1년내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=three_year') }}'">3년내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=all') }}'">전체</span></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>[평가단선정]</td>
    </tr>
</table>

<input type="hidden" id="po_page">
<input type="hidden" id="shop_page">

<div id="review_my_exp_list"></div>
<table>
    <tr id="po_more">
        <td><button type="button" id="addBtn" onclick="po_moreList();"><span>더보기</span></button></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>[쇼핑]</td>
    </tr>
</table>

<div id="review_my_shop_list"></div>
<table>
    <tr id="shop_more">
        <td><button type="button" id="addBtn2" onclick="shop_moreList();"><span>더보기</span></button></td>
    </tr>
</table>
-->

<script>
    po_moreList(); //함수 호출

    function po_moreList() {
        var page = $("#po_page").val();
		if(page == '') page = 1;
        else page++;

		$.ajax({
			type		: "get",
			url			: "{{ route('mypage.ajax_review_my_exp_list') }}",
			data		: {
                'page'      : page,
                'date_type' : '{{ $date_type }}',
			},
			success: function(html){
                //console.log(html);
                $("#review_my_exp_list").append(html);
                return;
			}
		});
    }
</script>

<script>
    shop_moreList(); //함수 호출

    function shop_moreList() {
        var page = $("#shop_page").val();

		if(page == '') page = 1;
        else page++;

		$.ajax({
			type		: "get",
			url			: "{{ route('mypage.ajax_review_my_shop_list') }}",
			data		: {
                'page'  : page,
                'date_type' : '{{ $date_type }}',
			},
			success: function(html){
//                console.log(html);
                $("#review_my_shop_list").append(html);
                return;
			}
		});
    }
</script>






@endsection
