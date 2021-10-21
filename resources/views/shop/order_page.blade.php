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


<form name="forderform" id="forderform" method="post" action="" autocomplete="off">
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

        $goods = $goods_it_id = "";
        $goods_count = -1;

        $good_info = '';
        $it_send_cost = 0;
        $it_cp_count = 0;

        $comm_tax_mny = 0; // 과세금액
        $comm_vat_mny = 0; // 부가세
        $comm_free_mny = 0; // 면세금액
        $tot_tax_mny = 0;
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
            $tot_point      += $point;
            $tot_sell_price += $sell_price;
        @endphp
    @endforeach

    @php
        // 배송비 계산
        $send_cost = $CustomUtils->get_sendcost($s_cart_id);
        $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
    @endphp
</table>



<table border=1>
<input type="hidden" name="od_price" id="od_price" value="{{ $tot_sell_price }}">
<input type="hidden" name="org_od_price" id="org_od_price" value="{{ $tot_sell_price }}">
<input type="hidden" name="od_send_cost" id="od_send_cost" value="{{ $send_cost }}">
<input type="hidden" name="od_send_cost2" id="od_send_cost2" value="0">
<input type="hidden" name="od_goods_name" id="od_goods_name" value="{{ $goods }}">
<input type="hidden" name="pay_type" id="pay_type">
<input type="hidden" name="user_point" id="user_point" value="{{ Auth::user()->user_point }}">

@php
/* pg 사 연결
        // 결제대행사별 코드 include (결제대행사 정보 필드)
        require_once(G5_SHOP_PATH.'/'.$default['de_pg_service'].'/orderform.2.php');

        if($is_kakaopay_use) {
            require_once(G5_SHOP_PATH.'/kakaopay/orderform.2.php');
        }
*/
@endphp
    <tr>
        <td>
            <table border=1>
                <!-- 주문하시는 분 입력
                <tr>
                    <td><h2>주문하시는 분</h2></td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_name">이름<strong class="sound_only"> 필수</strong></label></th>
                    <td><input type="text" name="od_name" value="{{ $user_name }}" id="od_name" required class="frm_input required" maxlength="20"></td>
                </tr>

                @if(!Auth::user())
                <tr>
                    <th scope="row"><label for="od_pwd">비밀번호</label></th>
                    <td>
                        <span class="frm_info">영,숫자 3~20자 (주문서 조회시 필요)</span>
                        <input type="password" name="od_pwd" id="od_pwd" required class="frm_input required" maxlength="20">
                    </td>
                </tr>
                @endif
                <tr>
                    <th scope="row"><label for="od_tel">전화번호<strong class="sound_only"> 필수</strong></label></th>
                    <td><input type="text" name="od_tel" value="{{ $user_tel }}" id="od_tel" required class="frm_input required" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="od_hp">핸드폰</label></th>
                    <td><input type="text" name="od_hp" value="{{ $user_phone }}" id="od_hp" class="frm_input" maxlength="20"></td>
                </tr>
                <tr>
                    <th scope="row">주소</th>
                    <td>
                        <label for="od_zip" class="sound_only">우편번호<strong class="sound_only"> 필수</strong></label>
                        <input type="text" name="od_zip" value="{{ $user_zip }}" id="od_zip" required class="frm_input required" size="8" maxlength="6" placeholder="우편번호">
                        <button type="button" class="btn_address" onclick="win_zip('wrap','od_zip', 'od_addr1', 'od_addr2', 'od_addr3', 'od_addr_jibeon','btnFoldWrap');">주소 검색</button>
<div id="wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
    <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" alt="접기 버튼">
</div>
                        <br>
                        <input type="text" name="od_addr1" value="{{ $user_addr1 }}" id="od_addr1" required class="frm_input frm_address required" size="60" placeholder="기본주소">
                        <label for="od_addr1" class="sound_only">기본주소<strong class="sound_only"> 필수</strong></label><br>
                        <input type="text" name="od_addr2" value="{{ $user_addr2 }}" id="od_addr2" class="frm_input frm_address" size="60" placeholder="상세주소">
                        <label for="od_addr2" class="sound_only">상세주소</label>
                        <br>
                        <input type="text" name="od_addr3" value="{{ $user_addr3 }}" id="od_addr3" class="frm_input frm_address" size="60" readonly="readonly" placeholder="참고항목">
                        <label for="od_addr3" class="sound_only">참고항목</label><br>
                        <input type="hidden" name="od_addr_jibeon" id="od_addr_jibeon" value="{{ $user_addr_jibeon }}">
                    </td>
                </tr>
                주문하시는 분 입력 끝 -->

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
                        <!--
                        <input type="checkbox" name="ad_default" id="ad_default" value="1">
                        <label for="ad_default">기본배송지로 설정</label>
                        -->
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
                    <td>배송비</td>
                </tr>
                <tr>
                    <td>{{ number_format($tot_sell_price) }}원</td>
                    <td>{{ number_format($send_cost) }}원</td>
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
                                @if($setting_info->company_bank_use == 1 && $setting_info->company_bank_account)
                                <td><button type="button" onclick="bank();">무통장</button></td>
                                @endif
                                <td><button type="button" onclick="requestPay();">카드(아임포트)</button></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr id="disp_bank" style="display:none">
                    <td colspan=2>
                        <div  id="show_bank"></div>
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
/*
    $("input[name=ad_sel_addr]").on("click", function() {
        $("#od_b_name").val($("#od_name").val());
        $("#od_b_tel").val($("#od_tel").val());
        $("#od_b_hp").val($("#od_hp").val());
        $("#od_b_zip").val($("#od_zip").val());
        $("#od_b_addr1").val($("#od_addr1").val());
        $("#od_b_addr2").val($("#od_addr2").val());
        $("#od_b_addr3").val($("#od_addr3").val());
        $("#od_b_addr_jibeon").val($("#od_addr_jibeon").val());
        $("#ad_subject").val($("#ad_subject").val());
    });
*/
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
        var form_var = $("#forderform").serialize();

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
        var sell_price = parseInt($("input[name=od_price]").val());
        var send_cost = parseInt($("input[name=od_send_cost]").val());
        var send_cost2 = parseInt($("input[name=od_send_cost2]").val());
        var tot_price = sell_price + send_cost + send_cost2;

        //$("input[name=good_mny]").val(tot_price);
        $("#print_price").text(numberWithCommas(String(tot_price)));
    }
</script>

<script>
    function bank(){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_orderbank') }}',
            data : {
            },
            dataType : 'text',
            success : function(result){
                $("#disp_bank").show();
                $("#show_bank").html(result);
                $("[name=od_deposit_name]").val('{{ Auth::user()->user_name }}');
                $("#pay_type").val("bank");
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    var IMP = window.IMP; // 생략 가능
    IMP.init("imp00000000"); // 예: imp00000000

    function requestPay() {
      // IMP.request_pay(param, callback) 결제창 호출
        IMP.request_pay({ // param
            pg: "html5_inicis",
            pay_method: "card",
            merchant_uid: "ORD20180131-0000011",
            name: "노르웨이 회전 의자",
            amount: 64900,
            buyer_email: "gildong@gmail.com",
            buyer_name: "홍길동",
            buyer_tel: "010-4242-4242",
            buyer_addr: "서울특별시 강남구 신사동",
            buyer_postcode: "01181"
        }, function (rsp) { // callback
            if (rsp.success) {
                alert('성공');
                // 결제 성공 시 로직,
            } else {
                alert('실패');
                // 결제 실패 시 로직,
            }
        });
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
                }

                if(json.message == "variance_chk"){
                    msg = "장바구니 금액에 변동사항이 있습니다.\n장바구니를 다시 확인해 주세요.";
                }

                if(json.message == "soldout"){
                    msg = json.item_option + " 상품이 " + json.txt + " 되었습니다.\n\n장바구니에서 해당 상품을 삭제후 다시 주문해 주세요.";
                }

                if(json.message == "qty_lack"){
                    msg = json.item_option + " 의 재고수량이 부족합니다.\n\n현재 재고수량 : " + json.txt + " 개";
                }

                result = msg;
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
        var send_cost = parseInt($("#od_send_cost").val());
        var send_cost2 = parseInt($("#od_send_cost2").val());
        var od_temp_point = parseInt($("#od_temp_point").val());
        var user_point = parseInt($("#user_point").val());

        //배송비에도 사용 가능 하기에 총금액을 구함(주문금액 + 기본 배송비 + 추가 배송비)
        var total_price = od_price + send_cost + send_cost2;

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

        if($("#pay_type").val() == ""){
            alert('결제 수단을 선택 하세요.');
            return false;
        }else{
            switch ($("#pay_type").val()) {
                case 'bank':
                    if($("#od_bank_account").val() == ""){
                        alert("계좌번호를 선택하세요.");
                        $("#od_bank_account").focus();
                        return false;
                    }

                    if($.trim($("#od_deposit_name").val()) == ""){
                        alert("입금자명을 입력하세요.");
                        $("#od_deposit_name").focus();
                        return false;
                    }
                break;
            }
        }

    }
</script>



@endsection
