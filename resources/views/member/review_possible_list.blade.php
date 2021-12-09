@extends('layouts.head')

@section('content')


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
    <form name="exp_form" id="exp_form" method="get" action="{{ route('mypage.review_possible_expwrite') }}">
    <input type="hidden" name="exp_id" id="exp_id">
    <input type="hidden" name="exp_app_id" id="exp_app_id">
    <input type="hidden" name="item_id" id="item_id">
    <input type="hidden" name="sca_id" id="sca_id">
    <input type="hidden" id="po_page">

    <tr>
        <td>[평가단선정]</td>
    </tr>
    <tr>
        <td id="review_possible_list">

        </td>
    </tr>
    <tr id="po_more">
        <td><button type="button" id="addBtn" onclick="po_moreList();"><span>더보기</span></button></td>
    </tr>
    </form>
</table>



<table border=1>
<form name="shop_form" id="shop_form" method="get" action="{{ route('mypage.review_possible_shopwrite') }}">
<input type="hidden" name="cart_id" id="cart_id">
<input type="hidden" name="order_id" id="order_id">
<input type="hidden" name="item_code" id="item_code">
<input type="hidden" id="shop_page">
    <tr>
        <td>[쇼핑]</td>
    </tr>
    <tr>
        <td id="review_my_list">
        </td>
    </tr>
    <tr id="shop_more">
        <td><button type="button" id="addBtn2" onclick="shop_moreList();"><span>더보기</span></button></td>
    </tr>
</form>
</table>

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
        var arr = order_pay_date.split('-');
        var dat = new Date(arr[0], arr[1], arr[2]);
        var date_2day = dat.getFullYear() + "-" + ("0" + dat.getMonth()).slice(-2) + "-" + ("0" + (dat.getDate() + 2)).slice(-2);

        if(todayString < date_2day){
            alert("구매 리뷰 작성 가능일은 " + date_2day + "입니다.");
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
		if( page == '' ) page = 1;
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

		if( page == '' ) page = 1;
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
