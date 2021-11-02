@extends('layouts.shophead')

@section('content')

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('/js/zip.js') }}"></script>

<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>


<table border=1>
    <tr>
        <td><h4>주문서 작성</h4></td>
    </tr>
</table>


<form name="forderform" id="forderform" method="post" action="{{ route('orderpayment') }}" autocomplete="off">
{!! csrf_field() !!}
<table border=1>
    <tr>
        <th scope="col">상품명</th>
        <th scope="col">총수량</th>
        <th scope="col">판매가</th>
        <th scope="col">소계</th>
        <th scope="col">배송비</th>
    </tr>
    @php
        $tot_point = 0;
        $tot_sell_price = 0;

        $goods = "";
        $goods_count = -1;

        $good_info = '';
        $it_send_cost = 0;
        $it_cp_count = 0;
    @endphp
    @foreach($cart_infos as $cart_info)
        @php
            $i = 0;
            $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where item_code = '{$cart_info->item_code}' and od_id = '$s_cart_id' ");

            if (!$goods)
            {
                //$goods = addslashes($row[it_name]);
                //$goods = get_text($row[it_name]);
                $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $cart_info->item_name);
                $goods_item_code = $cart_info->item_code;
            }

            $goods_count++;
            $image = $CustomUtils->get_item_image($cart_info->item_code, 3);
            $item_name = '<b>' . stripslashes($cart_info->item_name) . '</b>';
            $item_options = $CustomUtils->print_item_options($cart_info->item_code, $s_cart_id);
            if($item_options) {
                $item_name .= '<div class="sod_opt">'.$item_options.'</div>';
            }

            if ($goods_count) $goods .= ' 외 '.$goods_count.'건';

            $point      = $sum[0]->point;
            $sell_price = $sum[0]->price;

            // 배송비
            $sendcost = $CustomUtils->get_item_sendcost($cart_info->item_code, $sum[0]->price, $sum[0]->qty, $s_cart_id);

            if($sendcost == 0) $ct_send_cost = '무료';
            else $ct_send_cost = number_format($sendcost).'원';
        @endphp
            <tr>
                <td>
                    <table>
                        <tr>
                            <td><img src="{{ asset($image) }}"></td>
                            <td>
                                <table>
                                    <input type="hidden" name="item_code[{{ $i }}]" value="{{ $cart_info->item_code }}">
                                    <input type="hidden" name="item_name[{{ $i }}]" value="{{ $cart_info->item_name }}">
                                    <input type="hidden" name="it_price[{{ $i }}]" value="{{ $sell_price }}">
                                    <input type="hidden" name="cp_id[{{ $i }}]" value="">
                                    <input type="hidden" name="cp_price[{{ $i }}]" value="0">

                                    {!! $item_name !!}
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>

                <td>
                    {{ number_format($sum[0]->qty) }}
                </td>
                <td>
                    {{ number_format($cart_info->sct_price) }}
                </td>
                <td>
                    {{ number_format($sell_price) }}
                </td>
                <td>
                    {{ $ct_send_cost }}
                </td>

            </tr>
        @php
            $i++;
            $tot_point      += $point;  //각 상품의 포인트 합
            $tot_sell_price += $sell_price;
        @endphp
    @endforeach

    @php
        // 배송비 계산
        $send_cost = $CustomUtils->get_sendcost($s_cart_id);
        $tot_price = $tot_sell_price + $de_send_cost + $send_cost; // 총계 = 주문상품금액합계 + 기본 배송비 + 배송비
    @endphp
</table>



<table border=1>
<input type="hidden" name="order_id" id="order_id" value="{{ $order_id }}"> <!-- 주문번호 -->
<input type="hidden" name="od_id" id="od_id" value="{{ $s_cart_id }}"> <!-- 장바구니번호 -->
<input type="hidden" name="de_send_cost" id="de_send_cost" value="{{ $de_send_cost }}"> <!-- 기본배송비 -->
<input type="hidden" name="od_send_cost" id="od_send_cost" value="{{ $send_cost }}">  <!-- 각 상품 배송비 -->
<input type="hidden" name="od_send_cost2" id="od_send_cost2" value="0"> <!-- 추가배송비 -->
<input type="hidden" name="od_price" id="od_price" value="{{ $tot_sell_price }}">  <!-- 주문금액 -->
<input type="hidden" name="org_od_price" id="org_od_price" value="{{ $tot_sell_price }}"> <!-- original 주문금액 -->
<input type="hidden" name="od_goods_name" id="od_goods_name" value="{{ $goods }}">  <!-- 상품명 -->
<input type="hidden" name="cart_count" id="cart_count" value="{{ $cart_count }}">  <!-- 장바구니 상품 개수 -->

<input type="hidden" name="method" id="method">
<input type="hidden" name="pg" id="pg">
<input type="hidden" name="user_point" id="user_point" value="{{ Auth::user()->user_point }}">
<input type="hidden" name="imp_uid" id="imp_uid">
<input type="hidden" name="apply_num" id="apply_num">   <!-- 카드 승인 번호 -->
<input type="hidden" name="paid_amount" id="paid_amount">   <!-- 카드사에서 전달 받는 값(총 결제 금액) -->

    <tr>
        <td>
            <table border=1>
                <!-- 받으시는 분 입력 시작  -->
                <tr>
                    <td><h2>받으시는 분</h2></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="disp_baesongi"></div>
                    </td>
                </tr>

                <tr>
                    <td>배송지선택</td>
                    <td>{!! $addr_list !!}</td>
                </tr>

                @if(Auth::user())
                <tr>
                    <th scope="row"><label for="ad_subject">배송지명</label></th>
                    <td>
                        <input type="text" name="ad_subject" id="ad_subject" class="frm_input" maxlength="20">
                        <input type="checkbox" name="ad_default" id="ad_default" value="1">
                        <label for="ad_default">기본배송지로 설정</label>
                    </td>
                </tr>
                @endif

                <tr>
                    <th scope="row"><label for="od_b_name">이름<strong class="sound_only"> 필수</strong></label></th>
                    <td><input type="text" name="od_b_name" id="od_b_name" value="{{ $user_name }}" required class="frm_input required" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_b_tel">전화번호<strong class="sound_only"> 필수</strong></label></th>
                    <td><input type="text" name="od_b_tel" id="od_b_tel" value="{{ $user_tel }}" required class="frm_input required" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_b_hp">핸드폰</label></th>
                    <td><input type="text" name="od_b_hp" value="{{ $user_phone }}" id="od_b_hp" class="frm_input" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row">주소</th>
                    <td id="sod_frm_addr">
                        <label for="od_b_zip" class="sound_only">우편번호<strong class="sound_only"> 필수</strong></label>
                        <input type="text" name="od_b_zip" id="od_b_zip" value="{{ $user_zip }}" readonly required class="frm_input required" size="8" maxlength="6" placeholder="우편번호">
                        <button type="button" class="btn_address" onclick="win_zip('wrap_b','od_b_zip', 'od_b_addr1', 'od_b_addr2', 'od_b_addr3', 'od_b_addr_jibeon', 'btnFoldWrap_b');">주소 검색</button>
<div id="wrap_b" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
    <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap_b" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" alt="접기 버튼">
</div>
                        <br>
                        <input type="text" name="od_b_addr1" id="od_b_addr1" value="{{ $user_addr1 }}" readonly required class="frm_input frm_address required" size="60" placeholder="기본주소">
                        <label for="od_b_addr1" class="sound_only">기본주소<strong> 필수</strong></label><br>
                        <input type="text" name="od_b_addr2" id="od_b_addr2" value="{{ $user_addr2 }}" class="frm_input frm_address" size="60" placeholder="상세주소">
                        <label for="od_b_addr2" class="sound_only">상세주소</label>
                        <br>
                        <input type="text" name="od_b_addr3" id="od_b_addr3" value="{{ $user_addr3 }}" readonly="readonly" class="frm_input frm_address" size="60" placeholder="참고항목">
                        <label for="od_b_addr3" class="sound_only">참고항목</label><br>
                        <input type="hidden" name="od_b_addr_jibeon" id="od_b_addr_jibeon" value="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_memo">전하실말씀</label></th>
                    <td><textarea name="od_memo" id="od_memo"></textarea></td>
                </tr>
                <!-- 받으시는 분 입력 끝 -->
            </table>
        </td>
        <td>
            <table border=1>
                <tr>
                    <td>주문</td>
                    <td>기본 배송비 + 상품별 배송비</td>
                </tr>
                <tr>
                    <td>{{ number_format($tot_sell_price) }}원</td>
                    <td>{{ number_format($de_send_cost) }}원 + {{ number_format($send_cost) }}원</td>
                </tr>
                <tr>
                    <td>총계</td>
                    <td colspan="2" >
                        <input type="hidden" id="ori_ct_tot_price" value="{{ $tot_price }}">
                        <span id="ct_tot_price">{{ number_format($tot_price) }}원</span>
                    </td>
                </tr>
                <tr>
                    <td>추가배송비</td>
                    <td><strong id="od_send_cost3">0</strong>원<br>(지역에 따라 추가되는 도선료 등의 배송비입니다.)</td>
                </tr>
                <tr>
                    <td>총 주문금액</td>
                    <td><strong id="print_price">{{ number_format($tot_price) }}</strong>원</td>
                </tr>


                @if(Auth::user()->user_point > 0)
                <tr>
                    <td>사용가능적립금</td>
                    <td><input type="text" name="od_temp_point" value="{{ Auth::user()->user_point }}" id="od_temp_point" size="7" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 점</td>
                </tr>
                @endif


                <tr>
                    <td>결제수단</td>
                    <td>
                        <table border=1>
                            <tr>
                                <td><button type="button" onclick="pay_type('html5_inicis','card');">신용카드</button></td>
                                <td><button type="button" onclick="pay_type('html5_inicis','phone');">휴개폰결제</button></td>
                                <td><button type="button" onclick="pay_type('html5_inicis','trans');">실시간계좌이체</button></td>
                                <td><button type="button" onclick="pay_type('kakaopay','card');">카카오페이</button></td>
                                <td><button type="button" onclick="pay_type('naverpay','card');">네이버페이</button></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><button type="button" onclick="forderform_check();">주문하기</button></td>
                </tr>
            </table>
        </td>
    </tr>
</form>
</table>

<script>
    function baesongji(){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji') }}',
            data : {
            },
            dataType : 'text',
            success : function(result){
                if(result == "no_mem"){
                    alert("회원이시라면 회원로그인 후 이용해 주십시오.");
                    return false;
                }

                $("#disp_baesongi").html(result);
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    var zipcode = "";

    $("#od_b_addr2").focus(function() {
        var zip = $("#od_b_zip").val().replace(/[^0-9]/g, "");
        if(zip == "")
            return false;

        var code = String(zip);

        if(zipcode == code)
            return false;

        zipcode = code;
        calculate_sendcost(code);
    });

    function calculate_sendcost(code)
    {
        //산간지역 배송비 계산
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_ordersendcost') }}',
            data : {
                zipcode : code
            },
            dataType : 'text',
            success : function(data){
                if(data != "no_sendcost"){
                    const result = jQuery.parseJSON(data);
//alert(result.sc_price);
//return false;

                    $("input[name=od_send_cost2]").val(result.sc_price);
                    $("#od_send_cost3").text(numberWithCommas(String(result.sc_price)));

                    calculate_order_price();
                }else{
                    var ori_ct_tot_price = $("#ori_ct_tot_price").val();
                    //$("input[name=od_send_cost2]").val(ori_ct_tot_price);
                    $("input[name=od_send_cost2]").val(0);
                    $("#od_send_cost3").text(0);
                    $("#print_price").text(numberWithCommas(String(ori_ct_tot_price)));
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }

</script>

<script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<script>
    function calculate_order_price()
    {
        var de_send_cost = parseInt($("input[name=de_send_cost]").val());
        var sell_price = parseInt($("input[name=od_price]").val());
        var send_cost = parseInt($("input[name=od_send_cost]").val());
        var send_cost2 = parseInt($("input[name=od_send_cost2]").val());
        var tot_price = sell_price + de_send_cost + send_cost + send_cost2; //주문금액 + 기본 배송비 + 각상품 배송비 + 추가 배송비
        //$("input[name=good_mny]").val(tot_price);
        $("#print_price").text(numberWithCommas(String(tot_price)));
    }
</script>

<script>
    function pay_type(pg, method){
        $("#pg").val(pg);
        $("#method").val(method);
    }
</script>

<script>
    function order_stock_check(){
        var result = "";
        var msg = "";
        $.ajax({
            type: "GET",
            url: "{{ route('ajax_orderstock') }}",
            cache: false,
            async: false,
            success: function(data) {
//alert("js에서===> "+data);
//return false;
                var json = JSON.parse(data);
//alert("js에서===> "+json.message);
//return false;
                if(json.message == "no_cart"){
                    msg = "장바구니가 비어 있습니다.\n\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.";
                    alert(msg);
                    location.href = "{{ route('cartlist') }}";
                }

                if(json.message == "variance_chk"){
                    msg = "장바구니 금액에 변동사항이 있습니다.\n장바구니를 다시 확인해 주세요.";
                    alert(msg);
                    location.href = "{{ route('cartlist') }}";
                }

                if(json.message == "soldout"){
                    msg = json.item_option + " 상품이 " + json.txt + " 되었습니다.\n\n장바구니에서 해당 상품을 삭제후 다시 주문해 주세요.";
                    alert(msg);
                    location.href = "{{ route('cartlist') }}";
                }

                if(json.message == "qty_lack"){
                    msg = json.item_option + " 의 재고수량이 부족합니다.\n\n현재 재고수량 : " + json.txt + " 개";
                    alert(msg);
                    location.href = "{{ route('cartlist') }}";
                }
            }
        });

        return result;
    }

    function forderform_check(){
        // 재고체크
        var stock_msg = order_stock_check();

        if(stock_msg != "") {
            alert(stock_msg);
            return false;
        }

        errmsg = "";
        errfld = "";
        var deffld = "";

        if($.trim($("#ad_subject").val()) == ""){
            alert('배송지명을 입력 하세요.');
            $("#ad_subject").focus();
            return false;
        }

        if($.trim($("#od_b_name").val()) == ""){
            alert('받으시는 분 이름을 입력하십시오.');
            $("#od_b_name").focus();
            return false;
        }

        if($.trim($("#od_b_tel").val()) == ""){
            alert('받으시는 분 전화번호를 입력하십시오.');
            $("#od_b_tel").focus();
            return false;
        }

        if($.trim($("#od_b_zip").val()) == ""){
            alert('주소검색을 이용하여 받으시는 분 주소를 입력하십시오.');
            $("#od_b_zip").focus();
            return false;
        }

        if($.trim($("#od_b_addr1").val()) == ""){
            alert('주소검색을 이용하여 받으시는 분 주소를 입력하십시오.');
            $("#od_b_addr1").focus();
            return false;
        }

        if($.trim($("#od_b_addr2").val()) == ""){
            alert('받으시는 분의 상세주소를 입력하십시오.');
            $("#od_b_addr2").focus();
            return false;
        }

        @if(Auth::user()->user_point > 0)
        var od_price = parseInt($("#od_price").val());
        var de_send_cost = parseInt($("#de_send_cost").val());
        var send_cost = parseInt($("#od_send_cost").val());
        var send_cost2 = parseInt($("#od_send_cost2").val());
        var od_temp_point = parseInt($("#od_temp_point").val());
        var user_point = parseInt($("#user_point").val());

        //배송비에도 사용 가능 하기에 총금액을 구함(주문금액 + 기본 배송비 + 각 상품 배송비 + 추가 배송비)
        var total_price = od_price + de_send_cost + send_cost + send_cost2;

        if($.trim($("#od_temp_point").val() != "")){    //적립금 사용
            //총결제액 보다 많이 사용 할수 없음
            if(total_price < od_temp_point){
                alert("주문금액 보다 많이 적립금을 결제할 수 없습니다.");
                $("#od_temp_point").focus();
                return false;
            }

            //보유 포인트 보다 많이 쓸수 없음
            if(user_point < od_temp_point){
                alert("보유 적립금 보다 많이 결제할 수 없습니다.");
                $("#od_temp_point").val(user_point);
                $("#od_temp_point").focus();
                return false;
            }
        }
        @endif

        //결제 수단 선택
        if($("#pg").val() == "" || $("#method").val() == ""){
            alert('결제 수단을 선택 하세요.');
            return false;
        }

        //결제전 검증 수단으로 temp 테이블에 저장
        order_temp(total_price);

$("#forderform").submit();  //테스트로 함


/*
confirm_url 테스트 ajax 나주엥 지워야 함@@@
                var kk = total_price - od_temp_point;

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : '{{ route('ajax_ordercomfirm') }}',
            type: "post",
            contentType : "application/json",
            data: {
                        'imp_uid' : 'aa',
                        'amount' : kk,
                        'merchant_uid' : '{{ $order_id }}',
            },
            success : function(result){
alert(result.reason);
//alert(result.reason);
                //var data = JSON.parse(result);
//alert(result.reason);
//return false;
            },
            error: function(result){
                console.log(result);
            },
        });

return false;
*/


        //결제 모듈 호출
        requestPay($("#pg").val(), $("#method").val(), total_price, od_temp_point);
    }
</script>

<script>
    function requestPay(pg, method, price, point) {
        var tot_pay = price - point;
        var merchant_uid = "{{ $order_id }}";

        var IMP = window.IMP; // 생략 가능
        IMP.init("imp62273646"); // 예: imp00000000
      // IMP.request_pay(param, callback) 결제창 호출
        IMP.request_pay({ // param
            pg: pg,
            pay_method: method,
            merchant_uid: merchant_uid,
            name: "{{ $goods }}",
            amount: tot_pay,
            buyer_email: "{{ Auth::user()->user_id }}",
            buyer_name: "{{ Auth::user()->user_name }}",
            buyer_tel: "{{ Auth::user()->user_tel }}",
            buyer_addr: "{{ Auth::user()->user_addr1 }}",
            buyer_postcode: "{{ Auth::user()->user_zip }}",
            //confirm_url : 'http://localhost:8000/shop/ordercomfirm', //실제 서버에서 동작 함 나중에 바꿔 줘야함
        }, function (rsp) { // callback
            if (rsp.success) {
                $("#imp_uid").val(rsp.imp_uid); //카드사에서 전달 받는 값(아임포트 코드)
                $("#apply_num").val(rsp.apply_num); //카드사에서 전달 받는 값(카드 승인번호)
                $("#paid_amount").val(rsp.paid_amount); //카드사에서 전달 받는 값(총 결제 금액)
aledrt("성공");
//                $("#forderform").submit();  //테스트로 함

/*
예제
                var msg = '결제가 완료되었습니다.';
                msg += '고유ID : ' + rsp.imp_uid;
                msg += '상점 거래ID : ' + rsp.merchant_uid;
                msg += '결제 금액 : ' + rsp.paid_amount;
                msg += '카드 승인번호 : ' + rsp.apply_num;
*/
            } else {
                // 결제 실패 시 로직,
                alert("결제에 실패하였습니다.\n내용: " +  rsp.error_msg);
                location.reload();
            }
        });
    }
</script>

<!-- 환불 처리 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    function cancelPay(merchant_uid, tot_pay) {

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : '{{ route('ajax_orderpaycancel') }}',
            type : 'post',
            contentType : "application/json",
            data    : JSON.stringify({
                "merchant_uid" : merchant_uid, // 예: ORD20180131-0000011
                "cancel_request_amount" : tot_pay, // 환불금액
                "reason" : "상품 변동", // 환불사유
                "refund_holder" : "{{ Auth::user()->user_name }}", // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank" : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(예: KG이니시스의 경우 신한은행은 88번)
                "refund_account" : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            dataType : "text",
        }).done(function(result) { // 환불 성공시 로직
alert("aasd==> "+result);
            alert("환불 성공");
        }).fail(function(error) { // 환불 실패시 로직
            alert("환불 실패");
        });
    }

</script>

<script>
    //결제전 검증 수단으로 temp 테이블에 저장
    function order_temp(total_price){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : '{{ route('ajax_ordertemp') }}',
            method: "POST",
            data: {
                'order_id'          : '{{ $order_id }}',
                'od_id'             : '{{ $s_cart_id }}',
                'od_cart_price'     : $("#od_price").val(),
                'de_send_cost'      : $("#de_send_cost").val(), //기본 배송비
                'od_send_cost'      : $("#od_send_cost").val(), //각 상품 배송비
                'od_send_cost2'     : $("#od_send_cost2").val(),
                'od_receipt_price'  : total_price,
                'od_temp_point'     : $("#od_temp_point").val(),
                'od_b_zip'          : $("#od_b_zip").val(),
                'tot_item_point'    : '{{ $tot_point }}',
            },
            success : function(data){
//alert(data);
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>




@endsection
