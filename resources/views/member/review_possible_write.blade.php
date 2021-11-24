@extends('layouts.head')

@section('content')


<div class='page-header'>
      <h4>
            마이페이지
      </h4>
</div>

<table>
<form name="review_form" id="review_form" method="post" action="{{ route('mypage.review_possible_save') }}" enctype='multipart/form-data'>
{!! csrf_field() !!}
<input type="hidden" name="content_length" id="content_length">
<input type="hidden" name="order_id" id="order_id" value="{{ $order_id }}">
<input type="hidden" name="item_code" id="item_code" value="{{ $item_code }}">
<input type="hidden" name="temporary_yn" id="temporary_yn">
<input type="hidden" name="average" id="average">
<input type="hidden" name="cart_id" id="cart_id" value="{{ $cart_id }}">

    <tr>
        <td>정량평가(필수)</td>
    </tr>
    <tr>
        <td>
            <table border=1>
                @for($i = 1; $i <= 5; $i++)
                @php
                    $tmp = "item_name".$i;
                    $dip_name = $rating_item_info->$tmp;
                @endphp
                <tr>
                    <td>{{ $rating_item_info->$tmp }}</td>
                    <td>
                        <input type="radio" name="score{{ $i }}" value="1">1점
                        <input type="radio" name="score{{ $i }}" value="1.5">1.5점
                        <input type="radio" name="score{{ $i }}" value="2">2점
                        <input type="radio" name="score{{ $i }}" value="2.5">2.5점
                        <input type="radio" name="score{{ $i }}" value="3">3점
                        <input type="radio" name="score{{ $i }}" value="3.5">3.5점
                        <input type="radio" name="score{{ $i }}" value="4">4점
                        <input type="radio" name="score{{ $i }}" value="4.5">4.5점
                        <input type="radio" name="score{{ $i }}" value="5">5점
                    </td>
                </tr>
                @endfor
            </table>
        </td>
    <tr>
    <tr>
        <td>
            <textarea name="review_content" id="review_content"></textarea>
        </td>
    </tr>
    <tr>
        <td>포토리뷰(선택)</td>
    </tr>
    @for($m = 1; $m <= 5; $m++)
    <tr>
        <td>
            <input type="file" name="review_img{{ $m }}" id="review_img{{ $m }}">
            @error('review_img'.$m)
                <strong>{{ $message }}</strong>
            @enderror
        </td>
    </tr>
    @endfor
</form>
</table>

<table border=1>
    <tr>
        <td><button name="button">취소</button></td>
        <td><button name="button" onclick="review_save('y');">임시저장</button></td>
        <td><button name="button" onclick="review_save('n');">등록</button></td>
    </tr>
</table>

<script>
    function review_save(review_type){
        var hap = 0;
        for(var k = 1; k <= 5; k++)
        {
            var obj_name = "score" + k;
            var chk = $(":radio[name="+obj_name+"]:checked");
            if(chk.length == 0) {
                alert("정량평가를 입력하세요.");
                $('[name="'+ obj_name + '"]').focus();
                return false;
            }

            hap = hap + parseFloat(chk.val());
        }
        var average = hap / 5;

        if($.trim($("#review_content").val()) == ""){
            alert("리뷰를 작성하세요\n(최소20자 이상)");
            $("#review_content").focus();
            return false;
        }

        if($("#content_length").val() < 20){
            alert("리뷰를 작성하세요\n(최소20자 이상)");
            $("#review_content").focus();
            return false;
        }

        $("#temporary_yn").val(review_type);
        $("#average").val(average);
        $("#review_form").submit();
    }
</script>

<script>
    $('#review_content').on('keyup', function() {
        var content = $(this).val();
        var srtlength = getTextLength(content);
        $("#content_length").val(srtlength);
    });

    function getTextLength(str) {
        var len = 0;

        for (var i = 0; i < str.length; i++) {
            if (escape(str.charAt(i)).length == 6) {
                len++;
            }
            len++;
        }
        return len;
    }
</script>





@endsection
