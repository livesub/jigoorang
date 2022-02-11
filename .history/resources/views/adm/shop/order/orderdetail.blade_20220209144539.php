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
        <td>
        @php
            $disp_price = ((int)$order_info->od_receipt_price - (int)$order_info->od_receipt_point) - (int)$order_info->od_cancel_price;
            if($disp_price < 0) $disp_price = 0;
        @endphp
        결제금액 : {{ $disp_price }}</strong>원
        </td>
    </tr>
    <tr>
        <td><button type="button" onclick="items_cancel('상품취소')">취소</button></td>
    </tr>
</table>

<table border=1>
    <form name="orderdetailform" id="orderdetailform" method="post" action="">
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
                <input type="checkbox" id="sit_select_all" name="all_chkbox" value="Y" class="category-1">
                <!-- <input type="checkbox" id="sit_select_all"  onclick="selectAll(this)"> -->
            </th>
            <th scope="col">옵션항목</th>
            <th scope="col">상태</th>
            <th scope="col">수량</th>
            <th scope="col">판매가</th>
            <th scope="col">소계</th>
            <th scope="col">적립포인트</th>
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
            </td>
                @endif

            <td>
                @if($opt->sct_status == '취소')
                <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}" class="category-1-{{ $chk_box }}-{{ sprintf('%02d',$chk_box2) }}" checked disabled="disabled">
                @else
                <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}" class="category-1-{{ $chk_box }}-{{ sprintf('%02d',$chk_box2) }}">
                @endif
                <input type="hidden" name="ct_id[{{ $chk_cnt }}]" value="{{ $opt->id }}">
                {{ $opt->sct_option }}
            </td>
            <td>{{ $opt->sct_status }}</td>
            <td>
                <input type="text" name="sct_qty[{{ $chk_cnt }}]" id="sct_qty_{{ $chk_cnt }}" value="{{ $opt->sct_qty }}" size="5" onKeyup="this.value=this.value.replace(/[^1-9]/g,'');">
            </td>
            <td>{{ number_format($opt_price) }}</td>
            <td>{{ number_format($ct_price['stotal']) }}</td>
            <td>{{ number_format($ct_point['stotal']) }} P</td>
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
<!--
            <button type="button" onclick="status_change('입금')">입금</button>
            <button type="button" onclick="status_change('준비')">준비</button>
            <button type="button" onclick="status_change('배송')">배송</button>
            <button type="button" onclick="status_change('완료')">배송완료</button>

            <button type="button" onclick="status_change('부분취소')">부분취소</button>
-->
            <button type="button" onclick="return_item()">교환</button>
        </td>
    </tr>
</form>
</table>

<table border=1>
    <tr>
        <td>주문 수량변경 및 주문 전체취소 처리 내역</td>
    </tr>
    <tr>
        <td>{!! nl2br($order_info->od_mod_history) !!}</td>
    </tr>
</table>



<table border=1>
    <tr>
        <td>주문결제 내역</td>
    </tr>
    <tr>
        <td>
            <table border=1>
                <tr>
                    <td>주문번호</td>
                    <td>결제방식</td>
                    <td>주문총액</td>
                    <td>배송비</td>
                    <td>포인트결제</td>
                    <td>실결제금액</td>
                    <td>주문취소/반품금액</td>
                </tr>
                <tr>
                @php
                    if($order_info->de_send_cost_free == 0) $send_cost = $order_info->send_cost + $order_info->od_send_cost + $order_info->od_send_cost2;
                    else $send_cost = $order_info->od_send_cost + $order_info->od_send_cost2;
                @endphp
                    <td>{{ $order_info->order_id }}</td>
                    <td>{{ $order_info->od_settle_case }}</td>
                    <td>{{ number_format($order_info->od_receipt_price) }}</td>
                    <td>{{ number_format($send_cost) }}</td>
                    <td>{{ number_format($order_info->od_receipt_point) }}</td>
                    <td>{{ number_format($order_info->real_card_price) }}</td>
                    <td>주문취소/반품금액</td>
                </tr>
            </table>
        </td>
    </tr>
</table>



<table border=1>
    <tr>
        <td>메모</td>
    </tr>
    <tr>
        <td>
            <textarea name="od_shop_memo" id="od_shop_memo">{{ $order_info->od_shop_memo }}</textarea>
            <button type="button" onclick="shop_memo();">저장</button>
        </td>
    </tr>
</table>


<table border=1>
    <tr>
        <td>주문자 정보</td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>이름</td>
                    <td>{{ $mem_info->user_name }}</td>
                </tr>
                <tr>
                    <td>전화번호</td>
                    <td>{{ $mem_info->user_phone }}</td>
                </tr>
                <tr>
                    <td>아이디(이메일)</td>
                    <td>{{ $mem_info->user_id }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('/js/zip.js') }}"></script>


<table border=1>
    <form name="addrform" id="addrform" method="post" action="">
    {!! csrf_field() !!}
    <input type="hidden" name="num" value="{{ $order_info->id }}">
    <input type="hidden" name="order_id" value="{{ $order_info->order_id }}">

@php
    $ad_name_readonly = "";
    $ad_name_readonly = "";
    $ad_hp_readonly = "";
    $ad_button = "";
    $ad_addr2_readonly = "";
    $ad_addr3_readonly = "";
    $od_memo_readonly = "";
    $chang_button_readonly = "";

    if(trim($order_info->od_invoice) != "" || $order_info->od_status == "상품취소"){
        $ad_name_readonly = "readonly";
        $ad_hp_readonly = "readonly";
        $ad_button = "disabled";
        $ad_addr2_readonly = "readonly";
        $ad_addr3_readonly = "readonly";
        $od_memo_readonly = "readonly";
        $chang_button_readonly = "disabled";
    }
@endphp
    <tr>
        <td>이름</td>
        <td><input type="text" name="ad_name" id="ad_name" value="{{ stripslashes($order_info->ad_name) }}" {{ $ad_name_readonly }}></td>
    </tr>
    <tr>
        <td>전화번호</td>
        <td><input type="text" name="ad_hp" id="ad_hp" value="{{ $order_info->ad_hp }}" {{ $ad_hp_readonly }}></td>
    </tr>
    <tr>
        <td>우편번호</td>
        <td>
            <input type="text" name="ad_zip1" id="ad_zip1" value="{{ $order_info->ad_zip1 }}" readonly> <button type="button" class="btn_address adress_input03_btn" onclick="win_zip('wrap_order','ad_zip1', 'ad_addr1', 'ad_addr2', 'ad_addr3', 'ad_jibeon', 'btnFoldWrap_c');" {{ $ad_button }}>우편번호 찾기</button>

            <div id="wrap_order" class="adress_pop" style="height:100px;"><!-- 다음 우편번호 찾기  -->
                <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap_c" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" alt="접기 버튼">
            </div>
        </td>
    </tr>
    <tr>
        <td>주소</td>
        <td>
            <input type="text" name="ad_addr1" id="ad_addr1" required size="60" placeholder="기본주소" readonly value="{{ $order_info->ad_addr1 }}">
            <input type="text" name="ad_addr2" id="ad_addr2" size="60" placeholder="상세주소" value="{{ $order_info->ad_addr2 }}" {{ $ad_addr2_readonly }}>
            <input type="text" name="ad_addr3" id="ad_addr3" readonly="readonly" size="60" placeholder="참고항목" value="{{ $order_info->ad_addr3 }}" {{ $ad_addr3_readonly }}>
            <input type="hidden" name="ad_jibeon" id="ad_jibeon" value="{{ $order_info->ad_jibeon }}">
        </td>
    </tr>
    <tr>
        <td>배송메모</td>
        <td><input type="text" name="od_memo" id="od_memo" value="{{ stripslashes($order_info->od_memo) }}" {{ $od_memo_readonly }}></td>
    </tr>
    <tr>
        <td><button type="button" onclick="addr_change();" {{ $chang_button_readonly }}>변경</button></td>
    </tr>
</form>
</table>


<script>
    function items_cancel(status){
        var msg = '상품취소 시 자동 환불 처리 되어 복구 할수 없습니다.';

        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?")) {
            new_pay_cancel('{{ $order_info->imp_uid }}', '{{ $order_info->order_id }}', '{{ $order_info->real_card_price }}');
        }
    }
</script>



<script>
    function shop_memo(){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_shop_memo') }}',
            data : {
                id : {{ $order_info->id }},
                order_id : {{ $order_info->order_id }},
                od_shop_memo : $("#od_shop_memo").val(),
            },
            dataType : 'text',
            success : function(result){
                if(result == "error"){
                    alert("잘못된 경로 입니다.");
                    return false;
                }

                if(result == "ok"){
                    location.reload();
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    function addr_change(){
        var form_var = $("#addrform").serialize();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_addr_change') }}',
            data : form_var,
            dataType : 'text',
            success : function(result){
                if(result == "error"){
                    alert("잘못된 경로 입니다.");
                    return false;
                }

                if(result == "ok"){
                    location.reload();
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>


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
    function status_change(status){
        var msg = '';
        if(status == "상품취소" || status == "부분취소"){
            msg = status + '시 자동 환불 처리 되어 복구 할수 없습니다.';
        }else{
            msg = status + '상태를 선택하셨습니다.';
        }

        var check = false;
        for (i=0; i<$("#chk_cnt").val(); i++) {
            if($('#ct_chk_'+i).is(':checked') == true){
                check = true;
            }

            if($("#sct_qty_"+i).val() == ""){
                alert("수량을 입력 하세요.");
                $("#sct_qty_"+i).focus();
                return false;
            }
        }

        if (check == false) {
            alert("처리할 자료를 하나 이상 선택해 주십시오.");
            return false;
        }

        switch (status) {
            case '부분취소':
                var route_link = '{{ route('ajax_orderqtyprocess') }}';
                break;
            case '상품취소':
                var route_link = '{{ route('ajax_orderitemprocess') }}';
                break;
        }

        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?")) {
            //return true;
            $("#sct_status").val(status);
            //$("#orderdetailform").submit();

            var form_var = $("#orderdetailform").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: 'post',
                url: route_link,
                dataType: 'text',
                data: form_var,
                success: function(result) {
//alert(result);
//return false;
                    var data = JSON.parse(result);
//alert(data.amount);
//return false;
                    if(data.message == 'no_number'){
                        alert('수량을 입력 하세요.');
                        return false;
                    }

                    if(data.message == 'all_cancel'){
                        alert("처리할 자료를 하나 이상 선택해 주십시오.");
                        //alert('전체 주문 취소 상태 입니다.');
                        //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
                        return false;
                    }

                    if(data.message == 'no_order'){
                        alert('해당 주문번호로 주문서가 존재하지 않습니다.');
                        location.href = "{!! route('orderlist', $page_move) !!}"
                        return false;
                    }

                    if(data.message == 'qty_big'){
                        alert('주문 수량 보다 크게 입력 할수 없습니다.');
                        location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
                        return false;
                    }

                    if(data.message == 'no_qty'){
                        alert("처리할 수량을 변경해 주십시오.");
                        return false;
                    }

                    if(data.message == 'no_cancel'){
                        alert('무료 기본 배송비 이하 상품입니다.\n전체 취소를 선택 하세요.');
                        return false;
                    }

                    if(data.message == 'pay_cancel'){
                        pay_cancel('{{ $order_info->imp_uid }}', '{{ $order_info->order_id }}', data.amount, data.custom_data, status);
                    }

                },error: function(result) {
                    console.log(result);
                }
            });
        } else {
            return false;
        }

    }
</script>

<!-- 환불 처리 -->
<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    function pay_cancel(imp_uid, order_id, amount, custom_data, status){
        switch (status) {
            case '부분취소':
                var route_link = '{{ route('ajax_admorderqtypaycancel') }}';
                break;
            case '상품취소':
                var route_link = '{{ route('ajax_admorderitempaycancel') }}';
                break;
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : route_link,
            type : 'post',
            contentType : "application/json",
            data    : JSON.stringify({
                "imp_uid"               : imp_uid,
                "merchant_uid"          : order_id, // 예: ORD20180131-0000011
                "cancel_request_amount" : amount, // 환불금액
                //"reason"                : "부분환불", // 환불사유
                "reason"                : "주문취소", // 환불사유
                "custom_data"           : custom_data,  //필요 데이터
                "refund_holder"         : "{{ $order_info->od_deposit_name }}", // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank"           : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(예: KG이니시스의 경우 신한은행은 88번)
                "refund_account"        : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            dataType : "text",
        }).done(function(result) { // 환불 성공시 로직
//alert(result);
//return false;

            if(result == 'no_cancel'){
                alert('무료 기본 배송비 이하 상품입니다.\n전체 취소를 선택 하세요.');
                return false;
            }

            if(result == "exception"){
                alert("취소된 상품이 있어 전체 처리 할수 없습니다.");
                location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

            if(result == "ok"){
                alert("취소 처리 되었습니다.");
                location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

            if(result == "error"){
                alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-1");
                //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

        }).fail(function(error) { // 환불 실패시 로직
            alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-2");
            //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
        });
    }
</script>

<script>
    function new_pay_cancel(imp_uid, order_id, amount){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : '{{ route('ajax_itemspaycancel') }}',
            type : 'post',
            contentType : "application/json",
            data    : JSON.stringify({
                "imp_uid"               : imp_uid,
                "merchant_uid"          : order_id, // 예: ORD20180131-0000011
                "cancel_request_amount" : amount, // 환불금액
                "reason"                : "환불", // 환불사유
                "custom_data"           : '',  //필요 데이터
                "refund_holder"         : "{{ $order_info->od_deposit_name }}", // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank"           : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(예: KG이니시스의 경우 신한은행은 88번)
                "refund_account"        : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            dataType : "text",
        }).done(function(result) { // 환불 성공시 로직
//alert(result);
//return false;
            if(result == "ok"){
                alert("취소 처리 되었습니다.");
                location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

            if(result == "error"){
                alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-1");
                //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

        }).fail(function(error) { // 환불 실패시 로직
            alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-2");
            //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
        });
    }
</script>










@endsection
