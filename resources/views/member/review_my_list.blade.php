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


<script>
    po_moreList(); //함수 호출

    function po_moreList() {
        var page = $("#po_page").val();
		if( page == '' ) page = 1;
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

		if( page == '' ) page = 1;
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
