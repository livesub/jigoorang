@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/tabar.js') }}"></script>
<script src="{{ asset('/design/js/star.js') }}"></script>

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.review_my_list') }}">제품 평가 및 리뷰</a></li>
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

                            <input type="hidden" id="po_page">
                            <input type="hidden" id="shop_page">

                            <div class="cot_list my_list" id="review_my_exp_list">
                                <h4 class="mt-20 mb-20">평가단 선정</h4>
                            </div>

                            <div class="cot_list" id="po_more">
                                <button class="btn-full-sd" type="button" id="addBtn" onclick="po_moreList();">내가 쓴 리뷰 더보기</button>
                            </div>

                            <div class="line_15 bk"></div>


                            <div class="cot_list" id="review_my_shop_list">
                                <h4 class="mt-20 mb-20">쇼핑</h4>
                            </div>

                            <div class="cot_list" id="shop_more">
                                <button class="btn-full-sd" type="button" id="addBtn2" onclick="shop_moreList();">내가 쓴 리뷰 더보기</button>
                            </div>

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
