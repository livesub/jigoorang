@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>리뷰 관리</h4></td>
    </tr>
</table>

<table border=1>
<form name="" id="" method="get" action="">
@php
$seach_1_exp_selected = '';
$seach_1_shop_selected = '';
$seach_1_blind_selected = '';
$seach_3_id_selected = '';
$seach_3_name_selected = '';

if($seach_1 == 'exp') $seach_1_exp_selected = 'selected';
else if($seach_1 == 'shop') $seach_1_shop_selected = 'selected';
else if($seach_1 == 'blind') $seach_1_blind_selected = 'selected';

if($seach_3 == 'user_id') $seach_3_id_selected = 'selected';
else if($seach_3 == 'user_name') $seach_3_name_selected = 'selected';
@endphp

    <tr>
        <td>
            <select name="seach_1" id="seach_1" onchange="seach_1_change();">
                <option value="">전체</option>
                <option value="exp" {{ $seach_1_exp_selected }}>체험단리뷰</option>
                <option value="shop" {{ $seach_1_shop_selected }}>구매리뷰</option>
                <option value="blind" {{ $seach_1_blind_selected }}>블라인드</option>
            </select>
        </td>

        <td id="block_1" style="display:none">
            <select name="seach_2" id="seach_2">
                <option value="">전체</option>
                @foreach($exp_selects as $exp_select)
                    @php
                        $seach_2_selected = '';
                        if($exp_select->id == $seach_2) $seach_2_selected = 'selected';
                    @endphp
                <option value="{{ $exp_select->id }}" {{ $seach_2_selected }}>{{ stripslashes($exp_select->title) }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="seach_3" id="seach_3">
                <option value='user_id' {{ $seach_3_id_selected }}>아이디</option>
                <option value='user_name' {{ $seach_3_name_selected }}>이름</option>
            </select>
        </td>
        <td><input type="text" name="search_name" id="search_name" value="{{ $search_name }}"><button type="">검색</button></td>
    </tr>
</form>
</table>

<table border="">
    <tr>
        <td>번호</td>
        <td>아이디</td>
        <td>이름</td>
        <td>체험단명</td>
        <td>상품명</td>
        <td>블라인드처리</td>
        <td>수정</td>
    </tr>
    @foreach($review_save_rows as $review_save_row)
        @php
        $review_img_tmp = '';
        $review_img_cnt = false;
        $score_tmp = '';
        $dip_name = '';
        $tmp = '';
        $kk = 0;
        $review_img_disp = array();

        $exp_info = DB::table('exp_list')->select('title')->where('id', $review_save_row->exp_id)->first(); //체험단명 찾기

        if(is_null($exp_info)){
            $title_ment = '';
        }else{
            $title_ment = stripslashes($exp_info->title);
        }

        $item_info = DB::table('shopitems')->select('item_name')->where('item_code', $review_save_row->item_code)->first(); //상품명 찾기
        $rating_item_info = DB::table('rating_item')->where('sca_id', $review_save_row->sca_id)->first();

        //rating 있는 지 파악
        for($i = 1; $i <= 5; $i++){
            $tmp = "item_name".$i;
            $score_tmp = "score".$i;

            $dip_name .= $rating_item_info->$tmp." ".number_format($review_save_row->$score_tmp, 2)." 점 / ";
        }
        $dip_name = substr($dip_name, 0, -2);

        //리뷰 첨부 이미지 구하기
        $review_save_imgs = DB::table('review_save_imgs')->where('rs_id', $review_save_row->id);
        $review_save_imgs_cnt = $review_save_imgs->count();
        $review_save_imgs_infos = array();
        if($review_save_imgs_cnt > 0) $review_save_imgs_infos = $review_save_imgs->get();

        if($review_save_row->review_blind == "Y") $blind_ment = '블라인드 해제';
        else $blind_ment = '블라인드 처리';
        @endphp

    <tr>
        <td>{{ $virtual_num--; }}</td>
        <td>{{ $review_save_row->user_id }}</td>
        <td>{{ $review_save_row->user_name }}</td>
        <td>{{ $title_ment }}</td>
        <td>{{ $item_info->item_name }}</td>
        <td><button type="button" onclick="review_blind('{{ $review_save_row->id }}', '{{ $review_save_row->review_blind }}')">{{ $blind_ment }}</button></td>
        <td><button type="button" onclick="review_modi('{{ $review_save_row->id }}')">수정</button></td>
    </tr>
    <tr>
        <td colspan=5>{{ $review_save_row->review_content }}</td>
    </tr>
    <tr>
        <td colspan=5>{{ $dip_name }}</td>
    </tr>


        @if($review_save_imgs_cnt > 0)
    <tr>
        <td colspan=5>
            <table>
                <tr>
            @foreach($review_save_imgs_infos as $review_save_imgs_info)
                @php
                    $review_img_cut = '';
                    $review_img_disp = '';
                    $review_img_cut = explode("@@",$review_save_imgs_info->review_img);
                    $review_img_disp = "/data/review/".$review_img_cut[2];
                @endphp
                    <td><img src="{{ $review_img_disp }}"></td>
            @endforeach
                </tr>
            </table>
        </td>
    </tr>
        @endif
    @endforeach
    <tr>
        <td>{!! $pnPage !!}</td>
    </tr>
</table>

<script>
@if($seach_1 == 'exp')
$("#block_1").show();
@endif
    function seach_1_change()
    {
        if($("#seach_1").val() == "exp")
        {
            $("#block_1").show();
        }else{
            $("#block_1").hide();
        }
    }
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    function review_blind(num, type){
        if(type == 'Y') var ment = '해제';
        else var ment = '처리';

        if (confirm("블라인드(blind) "+ment+" 하시겠습니까?") == true){    //확인
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type : "post",
                url : "{{ route('adm.review.review_blind') }}",
                data : {
                    'num' : num,
                },
                dataType : 'text',
                success : function(result){
//alert(result);
//return false;
                    if(result == 'blind_ok'){
                        alert('블라인드(blind) 처리 되었습니다.');
                        location.reload();
                    }

                    if(result == 'blind_no'){
                        alert('블라인드(blind) 해제 처리 되었습니다.');
                        location.reload();
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }else{   //취소
            return false;
        }
    }
</script>

<script>
    function review_modi(num){
        location.href = "{{ route('adm.review.review_modi')?num="+num+" }}";
    }
</script>




@endsection
