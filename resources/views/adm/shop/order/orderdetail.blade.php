@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>주문 상세 처리</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>현재 주문상태 : {{ $order_info->od_status }}</td>
        <td>주문일시 : {{ substr($order_info->od_receipt_time, 0, 16) }} ({{ $CustomUtils->get_yoil($order_info->od_receipt_time) }})</td>
        <td>결제금액 : {{ number_format(((int)$order_info->od_cart_price + (int)$order_info->de_send_cost + (int)$order_info->od_send_cost + (int)$order_info->od_send_cost2) - (int)$order_info->od_receipt_point) }}</strong>원</td>
    </tr>
</table>

<table border=1>
    <form name="orderdetailform" id="orderdetailform" method="post" action="{{ route('orderprocess') }}">
    {!! csrf_field() !!}
    <input type="hidden" name="order_id" value="{{ $order_info->order_id }}">
    <input type="hidden" name="user_id" value="{{ $order_info->user_id }}">
    <input type="hidden" name="od_email" value="{{ $order_info->user_id }}">
    <input type="hidden" name="page_move" value="{!! $page_move !!}">
    <input type="hidden" name="pg_cancel" value="0">
    <input type="hidden" name="sct_status" id="sct_status">
        <tr>
            <th scope="col">상품명</th>
            <th scope="col">
                <input type="checkbox" id="sit_select_all" class="category-1">
                <!-- <input type="checkbox" id="sit_select_all"  onclick="selectAll(this)"> -->
            </th>
            <th scope="col">옵션항목</th>
            <th scope="col">상태</th>
            <th scope="col">수량</th>
            <th scope="col">판매가</th>
            <th scope="col">소계</th>
            <th scope="col">포인트</th>
        </tr>

        @php
            $i = 0;
            $chk_cnt = 0;
            $chk_box = 0;
            $chk_box2 = 0;
        @endphp

        @foreach($carts as $cart)
            @php
                $image = $CustomUtils->get_item_image($cart->item_code, 3);
                $opts = DB::table('shopcarts')->where([['od_id', $order_info->order_id],['item_code', $cart->item_code]])->orderBy('sio_type')->orderBy('id')->get();
                $rowspan = count($opts);
                $k = 0;
            @endphp

            @foreach($opts as $opt)
                @php
                    if($opt->sio_type) $opt_price = $opt->sio_price;
                    else $opt_price = $opt->sct_price + $opt->sio_price;
                    // 소계
                    $ct_price['stotal'] = $opt_price * $opt->sct_qty;
                    $ct_point['stotal'] = $opt->sct_point * $opt->sct_qty;
                    $ct_baesong['baesong'] = $opt->sct_point * $opt->sct_qty;
                @endphp
        <tr>

                @if($k == 0)
            <td rowspan="{{ $rowspan }}"><img src="{{ asset($image) }}"> {{ stripslashes($cart->item_name) }}</td>
            <td rowspan="{{ $rowspan }}">
                <input type="checkbox" id="sit_sel_{{ $i }}" name="it_sel[]" value="{{ $cart->item_code }}" class="category-1-{{ $chk_box }}">
                <input type="hidden" name="item_code[]" value="{{ $cart->item_code }}">
            </td>
                @endif

            <td>
                <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}" class="category-1-{{ $chk_box }}-{{ sprintf('%02d',$chk_box2) }}">
                <input type="hidden" name="ct_id[{{ $chk_cnt }}]" value="{{ $cart->id }}">
                {{ $opt->sct_option }}
            </td>
            <td>{{ $opt->sct_status }}</td>
            <td>
                <input type="text" name="sct_qty[{{ $chk_cnt }}]" id="sct_qty_{{ $chk_cnt }}" value="{{ $opt->sct_qty }}" size="5">

            </td>
            <td>{{ number_format($opt_price) }}</td>
            <td>{{ number_format($ct_price['stotal']) }}</td>
            <td>{{ number_format($ct_point['stotal']) }} 점</td>
        </tr>
                @php
                    $i++;
                    $chk_cnt++;
                    $k++;
                    $chk_box2++;
                @endphp
            @endforeach
            @php
                $chk_box++;
                $chk_box2 = 0;
            @endphp
        @endforeach
</table>

<table border=1>
    <tr>
        <td>
            <input type="hidden" name="chk_cnt" id="chk_cnt" value="{{ $chk_cnt }}">
            <strong>주문 및 장바구니 상태 변경</strong>
            <button type="button" onclick="status_change('준비')">준비</button>
            <button type="button" onclick="status_change('배송')">배송</button>
            <button type="button" onclick="status_change('완료')">배송완료</button>
            <button type="button" onclick="status_change('취소')">취소</button>
            <button type="button" onclick="status_change('반품')">반품</button>
        </td>
    </tr>
</form>
</table>



<script>
    $("[class^='category-']").on('change', function()
    {
        $this_checkbox = $(this);
        var class_name = $this_checkbox.attr('class');
        var checked = $('[class="'+class_name+'"]').is(":checked");

        $("[class^='"+class_name+"']").prop('checked', checked );   // 하위요소 전부 체크or해제
        checkbox_checked(class_name, checked);
    });

    function checkbox_checked(class_name, checked )
    {
        if( class_name.indexOf('-') == -1) return;

        var parent_class_name = class_name.substr(0, class_name.lastIndexOf('-') );
        var friend_class = class_name.substr(0, (class_name.lastIndexOf('-') + 1) );

        if( checked )//체크일경우
        {
            var i=0;
            //var node = $('input:checkbox:regex(class,'+ friend_class + '[0-9]$)');
            var node = $("[class^='"+friend_class+"']");

            if( node.length == node.filter(":checked").length )
                $('.' + parent_class_name ).prop('checked', true );
        }
        else //해제일경우
        {
            $("[class^='"+class_name+"']").each( function(index, item)
            {
                var parent_class_name = class_name.substr(0, class_name.lastIndexOf('-') );//상위단원 class가져오기
                child_checked = $(this).is(':checked');
                if( !child_checked && parent_class_name != 'category')//하위단원을 체크 해제했을경우 상위단원 체크 해제 부분
                {
                    $('.'+parent_class_name).prop('checked', child_checked );
                    return false;
                }
            });
        }
        checkbox_checked(parent_class_name, checked )
    }
</script>
































<script>
/*
function selectAll(selectAll)  {
    const checkboxes
        = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = selectAll.checked
    })
}
*/
</script>


<script>
/*
$(function() {
    $("#sit_select_all").click(function() {
    const checkboxes
        = document.getElementsByName('animal');

    checkboxes.forEach((checkbox) => {
        checkbox.checked = selectAll.checked;
    })

    });

    // 전체 옵션선택
    $("#sit_select_all").click(function() {
        if($(this).is(":checked")) {
            $("input[name='it_sel[]']").attr("checked", true);
            $("input[name^=ct_chk]").attr("checked", true);
        } else {
            $("input[name='it_sel[]']").attr("checked", false);
            $("input[name^=ct_chk]").attr("checked", false);
        }
    });

    // 상품의 옵션선택
    $("input[name='it_sel[]']").click(function() {
        var cls = $(this).attr("id").replace("sit_", "sct_");
        var $chk = $("input[name^=ct_chk]."+cls);
        if($(this).is(":checked"))
        {
            $chk.attr("checked", true);
        }else{
            $chk.attr("checked", false);
        }
    });
*/
/*
    // 개인결제추가
    $("#personalpay_add").on("click", function() {
        var href = this.href;
        window.open(href, "personalpaywin", "left=100, top=100, width=700, height=560, scrollbars=yes");
        return false;
    });

    // 부분취소창
    $("#orderpartcancel").on("click", function() {
        var href = this.href;
        window.open(href, "partcancelwin", "left=100, top=100, width=600, height=350, scrollbars=yes");
        return false;
    });

});
*/
</script>



<script>
    function status_change(status){
        var msg = '';
        if(status == "취소"){
            msg = status + '시 자동 환불 처리 되어 복구 할수 없습니다.';
        }else{
            msg = status + '상태를 선택하셨습니다.';
        }

        var check = false;
        for (i=0; i<$("#chk_cnt").val(); i++) {
            if($('#ct_chk_'+i).is(':checked') == true){
                check = true;
            }
        }

        if (check == false) {
            alert("처리할 자료를 하나 이상 선택해 주십시오.");
            return false;
        }

        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?")) {
            //return true;
            $("#sct_status").val(status);
            $("#orderdetailform").submit();
        } else {
            return false;
        }

/*
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    type: 'post',
                    url: '{{ route('shop.cate.ajax_select') }}',
                    dataType: 'text',
                    data: {
                        'ca_id'   : $('#caa_id').val(),
                        'length'  : $('#caa_id').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);


                    },error: function(result) {
                        console.log(result);
                    }
                });
*/






    }
</script>



@endsection
