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
                            <li class="is_on">
                                <a href="{{ route('mypage.review_possible_list') }}" class="btn_list">작성 가능 리뷰</a>
                            </li>
                            <li>
                                <a href="{{ route('mypage.review_my_list') }}" class="btn_list">내가 쓴 리뷰</a>
                            </li>
                        </ul>

                        <div class="cont_area">
                            <div id="tab1" class="cont cont_wrap">
                                
                                <form name="exp_form" id="exp_form" method="get" action="{{ route('mypage.review_possible_expwrite') }}">
                                <input type="hidden" name="exp_id" id="exp_id">
                                <input type="hidden" name="exp_app_id" id="exp_app_id">
                                <input type="hidden" name="item_id" id="item_id">
                                <input type="hidden" name="sca_id" id="sca_id">
                                <input type="hidden" id="po_page">
                                    <div class="cot_list my_list" id="review_possible_list">
                                        <h4 class="mt-20 mb-20">평가단 선정</h4>
                                    </div>
                                    <div class="cot_list" id="po_more">
                                        <button class="btn-full-sd" type="button" id="addBtn" onclick="po_moreList();">작성가능 리뷰 더보기</button>
                                    </div>
                                </form>

                                    <div class="line_15 bk"></div>
                                    <form name="shop_form" id="shop_form" method="get" action="{{ route('mypage.review_possible_shopwrite') }}">
                                    <input type="hidden" name="cart_id" id="cart_id">
                                    <input type="hidden" name="order_id" id="order_id">
                                    <input type="hidden" name="item_code" id="item_code">
                                    <input type="hidden" id="shop_page">
                                    <div class="cot_list" id="review_my_list">
                                        <h4 class="mt-20 mb-20">쇼핑</h4>
                                    </div>
                                    <div class="cot_list" id="shop_more">
                                        <button class="btn-full-sd" type="button" id="addBtn2" onclick="shop_moreList();">작성가능 리뷰 더보기</button>
                                    </div>
                                    </form>
                                    <div class="notie">삭제된 리뷰일 경우 확인이 불가합니다.</div>
                            </div><!-- tab1 끝 -->


                        </div>
                    </div>
                <!-- 고객센터 끝  -->

                </div>
            </div>
        </div>
    </div>
    <!-- 서브 컨테이너 끝 -->


<script>
    var today = new Date();
    var year = today.getFullYear();
    var month = ('0' + (today.getMonth() + 1)).slice(-2);
    var day = ('0' + today.getDate()).slice(-2);
    var todayString = year + '-' + month  + '-' + day;

    function exp_review(exp_id, exp_app_id, item_id, sca_id, review_start){
        if(todayString < review_start){
            alert("평가 가능 시작일은 " + review_start + "입니다.");
            return false;
        }else{
            $("#exp_id").val(exp_id);
            $("#exp_app_id").val(exp_app_id);
            $("#item_id").val(item_id);
            $("#sca_id").val(sca_id);
            $("#exp_form").submit();
        }
    }

    function cart_review(cart_id, order_id, item_code, order_pay_date){
        var dat = new Date(order_pay_date);
        const year1 = dat.getFullYear();
        const month1 = dat.getMonth();
        const day1 = dat.getDate() + 2; //2일 후 부터 작성 가능
        const day2 = dat.getDate() + 30; //30일 이내

        const new_2day = new Date(year1, month1, day1);
        const new_30day = new Date(year1, month1, day2);

        var date_2day = new_2day.getFullYear() + '-' + ("0" + (new_2day.getMonth() + 1)).slice(-2) + '-' + ("0" + new_2day.getDate()).slice(-2);
        var date_30day = new_30day.getFullYear() + '-' + ("0" + (new_30day.getMonth() + 1)).slice(-2) + '-' + ("0" + new_30day.getDate()).slice(-2);

        if(todayString > date_30day){
            alert("평가 가능 기간은 " + date_30day + "까지 입니다.");
            return false;
        }else if(todayString < date_2day){
            alert("평가 가능 기간은 " + date_2day + "입니다.");
            return false;
        }else{
            $("#cart_id").val(cart_id);
            $("#order_id").val(order_id);
            $("#item_code").val(item_code);
            $("#shop_form").submit();
        }
    }
</script>


<script>
    po_moreList(); //함수 호출

    function po_moreList() {
        var page = $("#po_page").val();
		if(page == '') page = 1;
        else page++;

		$.ajax({
			type		: "get",
			url			: "{{ route('mypage.ajax_review_possible_list') }}",
			data		: {
                'page'  : page,
			},
			success: function(html){
                //console.log(html);
                $("#review_possible_list").append(html);
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
			url			: "{{ route('mypage.ajax_review_shop_list') }}",
			data		: {
                'page'  : page,
			},
			success: function(html){
                //console.log(html);
                $("#review_my_list").append(html);
                return;
			}
		});
    }
</script>

@endsection
