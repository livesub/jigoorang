@extends('layouts.admhead')

@section('content')


<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('/datepicker/dist/css/datepicker.min.css') }}">
<script src="{{ asset('/datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/datepicker/dist/js/i18n/datepicker.ko.js') }}"></script>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .double div {
        float: left;
    }
</style>
<!-- datepicker -->


<table>
    <tr>
        <td><h4>주문 관리</h4></td>
    </tr>
</table>



<table border=1>
    <tr>
        <td><a href="{{ route('orderlist', 'od_status=입금') }}">결제완료({{ $orders_cnt1 }})</a></td>
        <td><a href="{{ route('orderlist', 'od_status=준비') }}">주문확인({{ $orders_cnt2 }})</a></td>
        <td><a href="{{ route('orderlist', 'od_status=배송') }}">발송({{ $orders_cnt3 }})</a></td>
        <td><a href="{{ route('orderlist', 'od_status=완료') }}">배송완료({{ $orders_cnt4 }})</a></td>
        <td><a href="{{ route('orderlist', 'od_status=교환') }}">교환반품({{ $orders_cnt5 }})</a></td>
        <td><a href="{{ route('orderlist', 'od_status=상품취소') }}">주문취소({{ $orders_cnt6 }})</a></td>
    </tr>
</table>


<form name="frmorderlist">
<table border=1>
    <tr>
        <td>
        @php
            $order_id_chk = '';
            $user_id_chk = '';
            $od_b_name_chk = '';
            $od_b_tel_chk = '';
            $od_b_hp_chk = '';
            $od_deposit_name_chk = '';
            $od_invoice_chk = '';

            if($sel_field == 'order_id') $order_id_chk = 'selected';
            else if($sel_field == 'user_id') $user_id_chk = 'selected';
            else if($sel_field == 'od_b_name') $od_b_name_chk = 'selected';
            else if($sel_field == 'od_b_tel') $od_b_tel_chk = 'selected';
            else if($sel_field == 'od_b_hp') $od_b_hp_chk = 'selected';
            else if($sel_field == 'od_deposit_name') $od_deposit_name_chk = 'selected';
            else if($sel_field == 'od_invoice') $od_invoice_chk = 'selected';

            //정렬 관련
            $sort_selected1 = "";
            $sort_selected2 = "";
            if($order_sort == "" || $order_sort == "desc") $sort_selected1 = "selected";
            else $sort_selected2 = "selected";
        @endphp
            <select name="sel_field" id="sel_field">
                <option value="order_id" {{ $order_id_chk }}>주문번호</option>
                <option value="user_id" {{ $user_id_chk }}>회원 ID</option>
                <option value="od_b_name" {{ $od_b_name_chk }}>받는분</option>
                <option value="od_b_tel" {{ $od_b_tel_chk }}>받는분전화</option>
                <option value="od_b_hp" {{ $od_b_hp_chk }}>받는분핸드폰</option>
                <option value="od_deposit_name" {{ $od_deposit_name_chk }}>입금자</option>
                <option value="od_invoice" {{ $od_invoice_chk }}>운송장번호</option>
            </select>
        </td>
        <td>
            <input type="text" name="search" value="{{ $search }}" id="search">
            <!-- <input type="submit" value="검색" class="btn_submit"> -->
        </td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>주문일자</td>
        <td>
            <input type="text" id="fr_date"  name="fr_date" value="{{ $fr_date }}" class="frm_input" size="10" maxlength="10"> ~
            <input type="text" id="to_date"  name="to_date" value="{{ $to_date }}" class="frm_input" size="10" maxlength="10">
            <button type="button" onclick="javascript:set_date('오늘');">오늘</button>
            <button type="button" onclick="javascript:set_date('어제');">어제</button>
            <button type="button" onclick="javascript:set_date('이번주');">이번주</button>
            <button type="button" onclick="javascript:set_date('이번달');">이번달</button>
            <button type="button" onclick="javascript:set_date('지난주');">지난주</button>
            <button type="button" onclick="javascript:set_date('지난달');">지난달</button>
            <button type="button" onclick="javascript:set_date('전체');">전체</button>
            <input type="submit" value="검색" class="btn_submit">
        </td>
    </tr>

</table>
</form>

@php
//    use App\Http\Controllers\adm\shop\order\OrderController;
    //$od_status_type = new OrderController();

    //if($od_status == "" || $od_status == "입금"){
    //    echo $od_status_type->deposit_function($data);
    //}

@endphp


<table border="1">
    <tr>
        @if($od_status == "입금")
        <td><button type="button" onclick="order_cancel();">주문취소</button></td>
        <td><button type="button" onclick="order_check('주문확인');">주문확인</button></td>
        @elseif($od_status == "준비")
        <td><button type="button" onclick="order_check('결제완료');">결제완료</button></td>
        <td><button type="button" onclick="order_send_check();">발송</button></td>
        @elseif($od_status == "배송")
        <td><button type="button" onclick="order_return();">주문확인</button></td>
        @endif

        <td><button type="button">엑셀다운로드</button></td>
        <td>
            <select name="order_sort" id="order_sort" onchange="order_sort();">
                <option value="desc" {{ $sort_selected1 }}>주문일순(최신순)</option>
                <option value="asc" {{ $sort_selected2 }}>주문일순(역)순)</option>
            </select>
            </td>
    </tr>
</table>

<form name="order_check_from" id="order_check_from" method="post" action="">
{!! csrf_field() !!}
<input type="hidden" name="check_type" id="check_type">
<table border=1>
    <tr>
        <td><input type="checkbox" name="ct_all" id="ct_all" value="1"></td>
        <td>주문일</td>
        <td>주문번호</td>
        <td>운송장번호</td>
        <td>상품명</td>
        <td>주문건</td>
        <td>주문상태</td>
        <td>
            <table border=1>
                <tr>
                    <td>교환</td>
                </tr>
                <tr>
                    <td>요청건</td>
                    <td>완료건</td>
                </tr>
            </table>
        </td>
        <td>주문자</td>
        <td>주문합계</td>
        <td>실결제금액</td>
        <td>취소금액</td>
    </tr>

    @foreach($orders as $order)
        @php
            $cart_infos = DB::table('shopcarts')->where('od_id', $order->order_id)->get();
            $etc_qty = "";
            $return_story_num = 0;
            $return_process_num = 0;
            $i = 0;
            foreach($cart_infos as $cart_info){
                $item_info = DB::table('shopitems')->where('item_code', $cart_info->item_code)->first();
                if($i == 0){
                    $image = $CustomUtils->get_item_image($cart_info->item_code, 3);
                    if($image == "") $image = asset("img/no_img.jpg");

                    if($item_info->item_manufacture == "") $item_manufacture = "";
                    else $item_manufacture = "[".$item_info->item_manufacture."]";
                    //제목
                    $item_name = $item_manufacture.stripslashes($item_info->item_name);
                }

                //교환 요청건
                if($cart_info->return_story != ""){
                    $return_story_num++;
                }

                //교환 완료건
                if($cart_info->return_process == "Y" || $cart_info->return_process == "T"){
                    $return_process_num++;
                }
                $i++;
            }

            if($i > 0) $etc_qty = "외".($i-1)."건";

            switch($order->od_status) {
                case "입금":
                    $ment = "결제완료";
                break;
                case "준비":
                    $ment = "주문확인";
                break;
                case "배송":
                    $ment = "발송";
                break;
                case "완료":
                    $ment = "배송완료";
                break;
                case "교환":
                    $ment = "교환";
                break;
                case "상품취소":
                    $ment = "주문취소";
                break;
            }
        @endphp

    <tr>
        <td><input type="checkbox" name="ct_chk[]" id="ct_chk" value="{{ $order->order_id }}"></td>
        <td>{{ $order->created_at }}({{ $CustomUtils->get_yoil($order->created_at) }})</td>
        <td><a href="{{ route('orderdetail','order_id='.$order->order_id.$page_move) }}">{{ $order->order_id }}</a></td>
        <td>
            @if($od_status == "입금" || $od_status == "배송")
            {{ $order->od_invoice }}
            @elseif($od_status == "준비")
            <input type="text" name="od_invoice[{{ $order->order_id }}]" id="od_invoice_{{ $order->order_id }}">
            @endif
        </td>
        <td>
            <table>
                <tr>
                    <td><img src="{{ $image }}" style="width:50px;height:50px;"></td>
                    <td>{{ $item_name }} {{ $etc_qty }}</td>
                </tr>
            </table>
        </td>
        <td>{{ $order->od_cart_count }}</td>
        <td>{{ $ment }}</td>
        <td>
            <table border=1>
                <tr>
                    <td>{{ $return_story_num }}</td>
                    <td>{{ $return_process_num }}</td>
                </tr>
            </table>
        </td>
        <td>{{ $order->od_deposit_name }}</td>
        <td>{{ number_format($order->od_receipt_price) }}</td>
        <td>{{ number_format($order->real_card_price) }}</td>
        <td>{{ number_format($order->od_cancel_price) }}</td>
    </tr>
    <tr>
        <td></td>
        <td>배송지정보 </td>
        <td colspan=10>
            이름 : {{ $order->ad_name }} 연락처 : {{ $order->ad_hp }}
            주소 : {{ $order->ad_zip1 }}){{ $order->ad_addr1 }} {{ $order->ad_addr2  }} {{ $order->ad_addr3 }}<br>
            배송메세지 : {{ stripslashes($order->od_memo) }}
        </td>
    </tr>
    @endforeach
</table>
</form>


<table border="1">
    <tr>
        @if($od_status == "입금")
        <td><button type="button" onclick="order_cancel();">주문취소</button></td>
        <td><button type="button" onclick="order_check('주문확인');">주문확인</button></td>
        @elseif($od_status == "준비")
        <td><button type="button" onclick="order_check('결제완료');">결제완료</button></td>
        <td><button type="button" onclick="order_send_check();">발송</button></td>
        @endif
    </tr>
</table>


<table>
    <tr>
        <td>{!! $pnPage !!}</td>
    </tr>
</table>






<script>
    //두개짜리 제어 연결된거 만들어주는 함수
    datePickerSet($("#fr_date"), $("#to_date"), true); //다중은 시작하는 달력 먼저, 끝달력 2번째

    function datePickerSet(sDate, eDate, flag) {
        if (!isValidStr(sDate) && !isValidStr(eDate) && sDate.length > 0 && eDate.length > 0) {
            var sDay = sDate.val();
            var eDay = eDate.val();

            if (flag && !isValidStr(sDay) && !isValidStr(eDay)) { //처음 입력 날짜 설정, update...
                var sdp = sDate.datepicker().data("datepicker");
                sdp.selectDate(new Date(sDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요

                var edp = eDate.datepicker().data("datepicker");
                edp.selectDate(new Date(eDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요
            }

            //시작일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(eDay)) {
                sDate.datepicker({
                    maxDate: new Date(eDay.replace(/-/g, "/"))
                });
            }
            sDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });

            //종료일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(sDay)) {
                eDate.datepicker({
                    minDate: new Date(sDay.replace(/-/g, "/"))
                });
            }
            eDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });
        }

        function isValidStr(str) {
            if (str == null || str == undefined || str == "")
                return true;
            else
                return false;
        }
    }

    function set_date(today)
    {
        @php
        $now_date = date('Y-m-d', time());
        $date_term = date('w', time());
        $week_term = $date_term + 7;
        $last_term = strtotime(date('Y-m-01', time()));
        @endphp

        if (today == "오늘") {
            $("#fr_date").val("{{ $now_date }}");
            $("#to_date").val("{{ $now_date }}");
        } else if (today == "어제") {
            $("#fr_date").val("{{ date('Y-m-d', time() - 86400) }}");
            $("#to_date").val("{{ date('Y-m-d', time() - 86400) }}");
        } else if (today == "이번주") {
            $("#fr_date").val("{{ date('Y-m-d', strtotime('-'.$date_term.' days', time())) }}");
            $("#to_date").val("{{ date('Y-m-d', time()) }}");
        } else if (today == "이번달") {
            $("#fr_date").val("{{ date('Y-m-01', time()) }}");
            $("#to_date").val("{{ date('Y-m-d', time()) }}");
        } else if (today == "지난주") {
            $("#fr_date").val("{{ date('Y-m-d', strtotime('-'.$week_term.' days', time())) }}");
            $("#to_date").val("{{ date('Y-m-d', strtotime('-'.($week_term - 6).' days', time())) }}");
        } else if (today == "지난달") {
            $("#fr_date").val("{{ date('Y-m-01', strtotime('-1 Month', $last_term)) }}");
            $("#to_date").val("{{ date('Y-m-t', strtotime('-1 Month', $last_term)) }}");
        } else if (today == "전체") {
            $("#fr_date").val("");
            $("#to_date").val("");
        }
    }
</script>

<script>
    $(function() {
        $("input[name=ct_all]").click(function() {
            if($("#ct_all").is(":checked")) $("input[name^=ct_chk]").prop("checked", true);
            else $("input[name^=ct_chk]").prop("checked", false);
        });
    });
</script>

<script>
    function order_sort(){
        var order_sort = $("#order_sort option:selected").val();
        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+order_sort;
    }
</script>

<script>
    function order_check(check_type){
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert(check_type + "할 주문건을 하나이상 선택해 주십시오.");
            return false;
        }

        var ment_change = "";
        if(check_type == "주문확인") ment_change = "준비";
        else if(check_type == "결제완료") ment_change = "입금";

        if (confirm("선택된 주문건을 "+ check_type +" 단계로 변경합니다.") == true){    //확인
            $("#check_type").val(check_type);
            var form_var = $("#order_check_from").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('ajax_order_check') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
//alert(result);
//return false;
                    if(result == "ok"){
                        alert(check_type + " 처리 되었습니다");
                        location.href = "{{ route('orderlist') }}?od_status="+ment_change+"{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }
    }
</script>


<script>
    function order_cancel(){
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("주문취소할 주문건을 하나이상 선택해 주십시오.");
            return false;
        }

        var msg = '주문취소 시 자동 환불 처리 되어 복구 할수 없습니다.';
        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?") == true){    //확인
            var form_var = $("#order_check_from").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('ajax_order_cancel') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
                    if(result == "ok"){
                        alert("주문취소 처리 되었습니다.");
                        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
                    }

                    if(result == "error"){
                        alert("주문취소가 실패 하였습니다. 관리자에게 문의 하세요.-1");
                        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }
    }
</script>

<script>
    function order_send_check(){
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("발송처리할 주문건을 하나이상 선택해 주십시오.");
            return false;
        }

        var check = true;
        $("input[name^=ct_chk]:checked").each(function(){
            var order_id = $(this).val();
            if($.trim($("#od_invoice_"+order_id).val()) == ""){
                alert("송장 번호를 입력 하세요");
                $("#od_invoice_"+order_id).focus();
                check = false;
                return false;
            }
        });

        if(check == true){
            if (confirm("선택된 주문건을 발송 단계로 변경합니다.") == true){    //확인
                    var form_var = $("#order_check_from").serialize();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    type : 'post',
                    url : '{{ route('ajax_order_send') }}',
                    data : form_var,
                    dataType : 'text',
                    success : function(result){
    //alert(result);
    //return false;
                        if(result == "ok"){
                            alert("발송 처리 되었습니다");
                            location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
                        }
                    },
                    error: function(result){
                        console.log(result);
                    },
                });
            }
        }
    }
</script>

<script>
    function order_return(){
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("주문확인할 주문건을 하나이상 선택해 주십시오.");
            return false;
        }

        if (confirm("선택된 주문건을 주문확인 단계로 변경합니다.") == true){    //확인
            var form_var = $("#order_check_from").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('ajax_order_return') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
//alert(result);
//return false;
                    if(result == "ok"){
                        alert("주문확인 처리 되었습니다");
                        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }
    }
</script>




@endsection
