@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/button.js') }}"></script> <!-- 배송지 입력버튼 js -->
<script src="{{ asset('/design/js/modal-back02.js') }}"></script>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('/js/zip.js') }}"></script>

<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>










            <!-- 서브 컨테이너 시작 -->
            <div class="sub-container">

                <!-- 위치 시작 -->
                <div class="location">
                    <ul>
                        <li>
                            <a href="/">홈</a>
                        </li>
                        <li>
                            <a href="">주문하기</a>
                        </li>
                    </ul>
                </div>
                <!-- 위치 끝 -->

                <!-- 타이틀 시작 -->
                <div class="title_area list">
                    <h2>주문 하기</h2>
                    <div class="line_14-100"></div>
                </div>
                <!-- 타이틀 끝 -->

                <!-- 주문 배송내역 시작 -->
                <div class="eval">

                    <div class="board mypage_list">
                        <!-- 리스트 시작 -->
                        <div class="board_wrap">

                            <div class="list ev_rul inner od">
                                <div class="sub_title">
                                    <h4>주문상품 정보</h4>
                                </div>
                                @php
                                    $hap_sendcost = 0;
                                    $tot_price = 0;
                                    $goods = "";
                                    $goods_count = -1;
                                    $tot_point = 0;
                                @endphp
                                @foreach($cart_infos as $cart_info)
                                    @php
                                        $i = 0;
                                        //$sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where item_code = '{$cart_info->item_code}' and od_id = '$s_cart_id' ");
                                        $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where sct_select = 1 and id='$cart_info->id' and od_id = '$s_cart_id' ");

                                        if (!$goods)
                                        {
                                            $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $cart_info->item_name);
                                            $goods_item_code = $cart_info->item_code;
                                        }

                                        $goods_count++;

                                        $image = $CustomUtils->get_item_image($cart_info->item_code, 3);

                                        //제조사
                                        if($cart_info->item_manufacture == "") $item_manufacture = "";
                                        else $item_manufacture = "[".$cart_info->item_manufacture."]";

                                        //제목
                                        $item_name = $item_manufacture.stripslashes($cart_info->item_name);

                                        //옵션 처리
                                        //$item_options = $CustomUtils->new_print_item_options($cart_info->id, $cart_info->item_code, $s_cart_id);
                                        $item_options = DB::table('shopcarts')->select('sct_option', 'sct_qty', 'sio_price')->where([['id', $cart_info->id], ['item_code', $cart_info->item_code], ['od_id',$s_cart_id]])->first();

                                        if ($goods_count == 0) $goods;
                                        $point      = $sum[0]->point;
                                        $sell_price = $sum[0]->price;

                                        // 배송비
                                        $sendcost = $CustomUtils->new_get_item_sendcost($cart_info->id, $sum[0]->price, $sum[0]->qty, $s_cart_id);
                                    @endphp
                                <div class="pr_body pd-00">
                                    <div class="pr-t pd-00">
                                        <div class="pr_img">
                                            <img src="{{ asset($image) }}" alt="">
                                        </div>
                                        <div class="pr_name pdl-20">
                                            <ul>
                                                <a href="">
                                                    <li>
                                                        <h4 class="mt-10">{{ $item_name }}</h4>
                                                    </li>
                                                </a>
                                                <li>
                                                @if($item_options->sio_price > 0)
                                                {{ $item_options->sct_option }}
                                                @endif
                                                </li>
                                                <li class="price_pd">{{ $CustomUtils->display_price($cart_info->item_price) }} {{ number_format($cart_info->sct_qty) }}개</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                    @php
                                        $i++;
                                        $tot_sell_price += $sell_price;
                                        $hap_sendcost += $sendcost;
                                        $tot_point      += $point;  //각 상품의 포인트 합
                                    @endphp
                                @endforeach

                                @php
                                    if($goods_count > 0){
                                        $goods = $goods.' 외 '.$goods_count.'건';
                                    }else{
                                        $goods = $goods;
                                    }

                                    //무료 배송비 정책에 따른 기본 배송비 추가,삭제
                                    if($tot_sell_price >= $de_send_cost_free){
                                        $hap_sendcost = $hap_sendcost;
                                    }else{
                                        $hap_sendcost = $hap_sendcost + $de_send_cost;
                                    }
                                    //총결제금액 = 상품 총금액 + 배송비
                                    $tot_price = $tot_sell_price + $hap_sendcost;
                                @endphp


                                <div class="pdt-20">
                                    <div class="oder">

                                        <ul>
                                            <li>상품금액</li>
                                            <li class="cr_06">{{ $CustomUtils->display_price($tot_sell_price) }}</li>
                                        </ul>

                                        <ul>
                                            <li>배송비</li>
                                            <li class="cr_06">{{ $CustomUtils->display_price($hap_sendcost) }}</li>
                                        </ul>

                                        <ul>
                                            <li class="cr_06 bold">총 결제 금액</li>
                                            <li class="cr_07 bold">{{ $CustomUtils->display_price($tot_price) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="list ev_rul inner od sol-g-t">
                                <div class="sub_title">
                                    <h4>주문자 정보</h4>
                                </div>
                                <div class="pr_body pd-00">
                                    <div class="pr_name m-00">

                                        <ul class="oder_name col">
                                            <li>수령인</li>
                                            <li>{{ Auth::user()->user_name }}</li>
                                        </ul>

                                        <ul class="oder_name col">
                                            <li>연락처</li>
                                            <li>{{ Auth::user()->user_phone }}</li>
                                        </ul>

                                        <ul class="oder_name col">
                                            <li>이메일</li>
                                            <li>{{ Auth::user()->user_id }}</li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="list ev_rul inner od sol-g-t">
                                <div class="information information_01">
                                    <div class="information-inner-title">
                                        <h4>배송지</h4>
                                        @if(empty($address))
                                        <button type="button" onclick='addressopenmodal_001()'>배송지 입력 + </button>
                                        @else
                                        <button type="button" id="btn" onclick='addressopenmodal_001(); baesongji();'>배송지 설정 / 변경</button>
                                        @endif
                                        <!-- 배송지 입력버튼 -->
                                        <!-- <button id="btn" onclick='changeBtnName()'>배송지 설정 / 변경</button> -->
                                        <!-- 클릭햇을때 배송지 입력버튼 -->
                                    </div>
                                    @if(empty($address))
                                    <div class="information-inner-title-btn" id="hide">
                                        등록된 배송지가 없습니다.<br>
                                        <span>'배송지 입력'</span>
                                        버튼을 눌러 배송지를 추가해 주세요.
                                    </div>
                                    @else
                                    <div class="information-inner-01">
                                        <ul class="information-name">
                                            <li>수령인</li>
                                            <li id="ad_name">{{ $address->ad_name}}</li>
                                        </ul>
                                        <ul class="information-phon">
                                            <li>휴대폰</li>
                                            <li id="ad_hp"> {{ $address->ad_hp }}</li>
                                        </ul>
                                        <ul class="information-address od">
                                            <li>주소</li>
                                            <li>
                                                <div id="ad_addr">{{ $address->ad_zip1 }}){{ $address->ad_addr1 }}</div>
                                                <div id="ad_addr6">{{ $address->ad_addr2 }}{{ $address->ad_addr3 }}</div>

                                                <!-- div 추가 -->
                                            </li>
                                        </ul>
                                        <ul class="information-input">
                                            <li>
                                                배송메모</li>
                                            <input type="text" name="od_memo" id="od_memo" placeholder="배송시 남길 메세지를 입력해 주세요">
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>

<form name="orderform" id="orderform" method="post" action="{{ route('orderpayment') }}" autocomplete="off">
{!! csrf_field() !!}
<!-- 배송지 관련 -->
<input type="hidden" id="od_b_name" name="ad_name">
<input type="hidden" id="od_b_hp" name="ad_hp">
<input type="hidden" id="od_b_zip" name="ad_zip1" value="{{ $user_zip }}">
<input type="hidden" id="od_b_addr1" name="ad_addr1">
<input type="hidden" id="od_b_addr2" name="ad_addr2">
<input type="hidden" id="od_b_addr3" name="ad_addr3">
<input type="hidden" id="od_b_addr_jibeon" name="ad_jibeon">

<input type="hidden" name="order_id" id="order_id" value="{{ $order_id }}"> <!-- 주문번호 -->
<input type="hidden" name="od_id" id="od_id" value="{{ $s_cart_id }}"> <!-- 장바구니번호 -->
<input type="hidden" name="de_send_cost" id="de_send_cost" value="{{ $de_send_cost }}"> <!-- 기본배송비 -->
<input type="hidden" name="de_send_cost_free" id="de_send_cost_free" value="{{ $de_send_cost_free }}"> <!-- 기본배송비 무료정책 -->
<input type="hidden" name="od_send_cost" id="od_send_cost" value="{{ $hap_sendcost }}">  <!-- 각 상품 배송비 -->
<input type="hidden" name="od_send_cost2" id="od_send_cost2" value="0"> <!-- 추가배송비 -->
<input type="hidden" name="od_price" id="od_price" value="{{ $tot_sell_price }}">  <!-- 주문금액 -->
<input type="hidden" name="org_od_price" id="org_od_price" value="{{ $tot_sell_price }}"> <!-- original 주문금액 -->
<input type="hidden" name="od_goods_name" id="od_goods_name" value="{{ $goods }}">  <!-- 상품명 -->
<input type="hidden" name="cart_count" id="cart_count" value="{{ $cart_count }}">  <!-- 장바구니 상품 개수 -->
<input type="hidden" name="tot_price" id="tot_price" value="{{ $tot_price }}">  <!-- 주문서에 담긴 총 금액(상품가격+배송비(무료정책포함), 산간배송비 비포함) -->

<input type="hidden" name="method" id="method" value="card">
<input type="hidden" name="pg" id="pg" value="html5_inicis">
<input type="hidden" name="user_point" id="user_point" value="{{ Auth::user()->user_point }}">
<input type="hidden" name="imp_uid" id="imp_uid">
<input type="hidden" name="apply_num" id="apply_num">   <!-- 카드 승인 번호 -->
<input type="hidden" name="paid_amount" id="paid_amount">   <!-- 카드사에서 전달 받는 값(총 결제 금액) -->
<input type="hidden" name="imp_merchant_uid" id="imp_merchant_uid">   <!-- 주문번호 -->
<input type="hidden" name="pg_provider" id="pg_provider">   <!-- 결제승인/시도된 PG사 -->

<input type="hidden" name="imp_card_name" id="imp_card_name">   <!-- 카드사에서 전달 받는 값(카드사명칭)) -->
<input type="hidden" name="imp_card_quota" id="imp_card_quota">   <!-- 카드사에서 전달 받는 값(할부개월수)) -->
<input type="hidden" name="imp_card_number" id="imp_card_number">   <!-- 카드사에서 전달 받는 값(카드번호) -->

                            <div class="list ev_rul inner od sol-g-t">
                                <div class="sub_title">
                                    <h4>포인트 정보</h4>
                                </div>
                                <div class="pr_body pd-00">
                                    <div class="pt_name m-00">

                                        <ul class="oder_name wt-00 mb-20">
                                            <li>보유포인트</li>
                                            <li>{{ number_format(Auth::user()->user_point) }}P</li>
                                        </ul>
                                        @if(Auth::user()->user_point > 0)
                                        <ul class="oder_point">
                                            <li>사용포인트</li>
                                            <li>
                                            <div class="oder_point_box">
                                              <input type="text" name="od_temp_point" value="0" id="od_temp_point" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');all_point_use(false);">
                                              <span>P</span>

                                              <button type="button" class="btn-10-p" onclick="all_point_use(true);">전액 사용</button>
                                            </div>
                                            </li>
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="pdt-20">
                                    <div class="oder">
                                        <ul class="cr_06">
                                            <li class="bold">최종 결제 금액</li>
                                        </ul>
                                        <ul>
                                            <li>상품금액</li>
                                            <li class="cr_06">{{ $CustomUtils->display_price($tot_sell_price) }}</li>
                                        </ul>
                                        <ul>
                                          <li>배송비</li>
                                          <li class="cr_06">{{ $CustomUtils->display_price($hap_sendcost) }}</li>
                                        </ul>
                                        <ul>
                                          <li class="icon_od"><span class="ml-20">도서산간 추가비용</span></li>
                                          <li class="cr_06" id="od_send_cost3">0원</li>
                                        </ul>
                                        <ul>
                                          <li>포인트 할인</li>
                                          <li class="cr_06" id="use_point">0P</li>
                                        </ul>
                                        <ul>
                                          <li class="cr_06 bold">총 결제 금액</li>
                                          <li class="cr_07 bold" id="last_tot_price"></li>
                                        </ul>
                                        (최소 결제 금액은 1,000원 입니다.)
                                    </div>
                                </div>
                            </div>

                            <div class="list ev_rul inner od sol-tb">
                                <div class="sub_title">
                                    <h4>결제 수단</h4>
                                </div>
                                <div class="pr_body pd-00">
                                    <div class="pr_name m-00">
                                        <ul class="radio pdb-10">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_1" checked="checked" onclick="pay_type('html5_inicis','card');">
                                                <label for="rd_1">신용카드</label>
                                            </li>
                                        </ul>

                                        <ul class="radio pdb-10">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_2" onclick="pay_type('html5_inicis','phone');">
                                                <label for="rd_2">핸드폰 결제</label>
                                            </li>
                                        </ul>

                                        <ul class="radio pdb-10">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_3" onclick="pay_type('naverpay','naverpay');">
                                                <label for="rd_3">네이버 페이</label>
                                            </li>
                                        </ul>

                                        <ul class="radio pdb-10">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_4" onclick="pay_type('kakaopay','kakaopay');">
                                                <label for="rd_4">카카오페이</label>
                                            </li>
                                        </ul>

                                        <ul class="radio">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_5" onclick="pay_type('html5_inicis','trans');">
                                                <label for="rd_5">실시간 계좌 이체</label>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="pd-40 terms sol-tb sol-bb">
                              <div class="hide_con">
                                위 상품의 구매 조건을 확인하였으며, 서비스 약관 및 결제 진행에 동의합니다.
                                <img src="{{ asset('/design/recources/icons/icon-od-arr@3x.png') }}" alt="">
                              </div>

                              <div class="hide_cot mt-20">
                                <ul>
                                  <li class="icon_od"><span class="ml-20 cr_04">이용약관</span></li>
                                  <li class="cr_04 line ml-10" onclick="detilopenmodal_001()">보기</li>
                                </ul>
                                <ul class="mt-10 ">
                                  <li class="icon_od"><span class="ml-20 cr_04">개인정보처리방침</span></li>
                                  <li class="cr_04 line ml-10" onclick="detil2openmodal_001()">보기</li>
                                </ul>
                              </div>
                            </div>

                            <div class="list_img_btn_area">
                              <button type="button" onclick="forderform_check();">결제하기</button>
                            </div>
                        </form>
                        </div>
                        <!-- 리스트 끝 -->

                    </div>

                </div>
                <!-- 주문 배송 내역 끝 -->

            </div>
            <!-- 서브 컨테이너 끝 -->

    <!-- 배송지 모달 (주소) // 등록된 배송지가 없습니다. -->
    <form name="forderform" id="forderform">
    {!! csrf_field() !!}
    <div class="modal modal_002 fade" id="disp_baesongi"></div>
    </form>
    <!-- 배송지 모달 (주소) // 등록된 배송지가 없습니다. 끝 -->



<script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<script>
    function baesongji(){
        if($.trim($("#od_memo").val()) != ""){
            setCookie("order_01", $("#od_memo").val(), "1"); //변수, 변수값, 저장기
        }else{
            setCookie("order_01", "", "1");
        }

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
    function last_price(tot_price, od_send_cost2, use_point){
//alert("tot_price====> "+tot_price);
//alert("od_send_cost2====> "+od_send_cost2);
//alert("use_point====> "+use_point);
        var last_tot_price = (tot_price + od_send_cost2) - use_point;
        $("#last_tot_price").text(numberWithCommas(last_tot_price) + '원');
    }
</script>

<script>
    function all_point_use(type){
        var user_point = parseInt($("#user_point").val());
        var od_temp_point = parseInt($("#od_temp_point").val());  //직접입력
        var tot_price = parseInt($("#tot_price").val());
        var od_send_cost2 = parseInt($("#od_send_cost2").val());    //도서 산간 배송비
        var tot_price_tmp = (tot_price + od_send_cost2) - 1000;   //카드 결제 최하 금액이 1000원 까지라 1000원 은 무조건 카드 결제 해야함
        $("#use_point").text(0);

        if(user_point <= 0){
            alert('사용할 포인트가 부족 합니다');
            return false;
        }

        if(type == true){
            if(tot_price_tmp < user_point){
                $("#od_temp_point").val(tot_price_tmp);
                $("#use_point").text(numberWithCommas(tot_price_tmp * -1) + 'P');
                last_price(tot_price, od_send_cost2, tot_price_tmp);
                return false;
            }else{
                $("#od_temp_point").val(user_point);
                $("#use_point").text(numberWithCommas(user_point * -1) + 'P');
                last_price(tot_price, od_send_cost2, user_point);
                return false;
            }
        }else{
            if(tot_price_tmp < od_temp_point){
                $("#od_temp_point").val(tot_price_tmp);
                $("#use_point").text(numberWithCommas(tot_price_tmp * -1) + 'P');
                last_price(tot_price, od_send_cost2, tot_price_tmp);
                return false;
            }else{
                if(user_point < od_temp_point){
                    $("#od_temp_point").val(user_point);
                    $("#use_point").text(numberWithCommas(user_point * -1) + 'P');
                    last_price(tot_price, od_send_cost2, user_point);
                    return false;
                }
            }
        }

        if(isNaN(od_temp_point)){
            $("#use_point").text(0 + 'P');
            od_temp_point = 0;
        }else{
            if(od_temp_point == 0){
                $("#use_point").text(numberWithCommas(od_temp_point) + 'P');
            }else{
                $("#use_point").text(numberWithCommas(od_temp_point * -1) + 'P');
            }
        }

        last_price(tot_price, od_send_cost2, od_temp_point);
    }
</script>


<script>
    @if(!empty($address))
    add_baesong_price($("#od_b_zip").val());
    @endif
    function add_baesong_price(code){
        //산간지역 배송비 계산
        $("#od_temp_point").val(0);
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_ordersendcost') }}',
//            cache: false,
            async: false,
            data : {
                zipcode : code
            },
            dataType : 'text',
            success : function(data){
                if(data != "no_sendcost"){
                    const result = jQuery.parseJSON(data);
                    $("input[name=od_send_cost2]").val(result.sc_price);
                    $("#od_send_cost3").text(numberWithCommas(String(result.sc_price))+'원');

                    all_point_use(false);
                    //calculate_order_price();
                }else{
                    var ori_ct_tot_price = $("#ori_ct_tot_price").val();
                    //$("input[name=od_send_cost2]").val(ori_ct_tot_price);
                    $("input[name=od_send_cost2]").val(0);
                    $("#od_send_cost3").text(0+'원');
                    //$("#print_price").text(numberWithCommas(String(ori_ct_tot_price))+'원');

                    all_point_use(false);
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    function calculate_sendcost(){
        //히든 값으로 가져온 값을 해당 태그에 html이나 text로 넣어준다.
        $('#ad_name').text($("#od_b_name").val());
        $('#ad_hp').text($("#od_b_hp").val());
        let $ad_addrs = $("#od_b_zip").val()+") "+$("#od_b_addr1").val()+" ";
        let $ad_addrs6 =$("#od_b_addr2").val() +$("#od_b_addr3").val() ; //상세주소 참조메모
        //let $ad_addrs7 = $("#od_b_addr3").val();
        $('#ad_addr').text($ad_addrs);
        $('#ad_addr6').text($ad_addrs6);
        //$('#ad_addr7').text($ad_addrs7);

        add_baesong_price($("#od_b_zip").val());

        //창닫기
        //lay_close();
        addressinputclose();
        document.querySelector('.modal.modal_002').classList.remove('in');
        //보여주던 부분을 숨기고 display none 값들을 보여준다.
        //$("#show_address").show();
        //$("#none_address").hide();
    }
</script>

<script>
    loading_read_order();
    function loading_read_order(){
        $("#od_memo").val(getCookie("order_01"));
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

        @if(empty($address))
            alert("등록된 배송지가 없습니다");
            return false;
        @endif
/*
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

        if($.trim($("#od_b_hp").val()) == ""){
            alert('받으시는 분 휴대폰번호를 입력하십시오.');
            $("#od_b_hp").focus();
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
*/
        var od_temp_point = parseInt($("#od_temp_point").val());
        if(isNaN(od_temp_point)){
            od_temp_point = 0;
        }
        var od_price = parseInt($("#od_price").val());
        var de_send_cost = parseInt($("#de_send_cost").val());
        var de_send_cost_free = parseInt($("#de_send_cost_free").val());
        var send_cost = parseInt($("#od_send_cost").val());
        var send_cost2 = parseInt($("#od_send_cost2").val());
        var user_point = parseInt($("#user_point").val());

//alert("od_price====> "+od_price);
//alert("de_send_cost====> "+de_send_cost);
//alert("de_send_cost_free====> "+de_send_cost_free);
//alert("send_cost====> "+send_cost);
//alert("send_cost2====> "+send_cost2);
//alert("user_point====> "+user_point);
//return false;
        //var total_price = (od_price + send_cost + send_cost2) - od_temp_point;
        var total_price = (od_price + send_cost + send_cost2);
/*
        //포인트가 배송비에도 사용 가능 하기에 총금액을 구함(주문금액 + 기본 배송비 + 각 상품 배송비 + 추가 배송비)
        //배송비 무료 정책 추가
        if(od_price >= de_send_cost_free){
            var total_price = od_price + send_cost + send_cost2;
        }else{
            var total_price = od_price + de_send_cost + send_cost + send_cost2;
        }
*/
//alert("total_price=====> "+total_price);
//alert(total_price);
//alert("od_temp_point===> "+od_temp_point);
//return false;
/*
        @if(Auth::user()->user_point > 0)
        od_temp_point = parseInt($("#od_temp_point").val());
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

            //최소 결제 금액(1000원)
            var min_price = total_price - od_temp_point;

            if(min_price < 1000){
                alert("최소 결제 금액은 1,000원 입니다.");
                $("#od_temp_point").focus();
                return false;
            }
        }
        @endif
*/
        //결제 수단 선택
        if($("#pg").val() == "" || $("#method").val() == ""){
            alert('결제 수단을 선택 하세요.');
            return false;
        }

        //결제전 검증 수단으로 temp 테이블에 저장
        //order_temp(total_price);

//$("#forderform").submit();  //테스트로 함


/*
//confirm_url 테스트 ajax 나주엥 지워야 함@@@
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
return false;
            },
            error: function(result){
                console.log(result);
            },
        });

return false;

alert("pg====> "+$("#pg").val());
alert("method====> "+$("#method").val());
alert("total_price====> "+total_price);
alert("od_temp_point====> "+od_temp_point);
return false;
*/
        //결제 모듈 호출
        requestPay($("#pg").val(), $("#method").val(), total_price, od_temp_point);
    }
</script>


<script>
    function requestPay(pg, method, price, point=0) {
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
            confirm_url : '{{ route('ajax_ordercomfirm') }}', //실제 서버에서 동작 함 나중에 바꿔 줘야함
        }, function (rsp) { // callback
            if (rsp.success) {
                $("#imp_uid").val(rsp.imp_uid); //카드사에서 전달 받는 값(아임포트 코드)
                $("#apply_num").val(rsp.apply_num); //카드사에서 전달 받는 값(카드 승인번호)
                $("#paid_amount").val(rsp.paid_amount); //카드사에서 전달 받는 값(총 결제 금액)
                $("#imp_merchant_uid").val(rsp.merchant_uid); //카드사에서 다시 전달 받은 주문번호
                $("#imp_provider").val(rsp.pg_provider); //카드사에서 전달 받는 값(결제승인/시도된 PG사)
                $("#imp_card_name").val(rsp.card_name); //카드사에서 전달 받는 값(카드사명칭))
                $("#imp_card_quota").val(rsp.card_quota); //카드사에서 전달 받는 값(할부개월수))
                $("#imp_card_number").val(rsp.card_number); //카드사에서 전달 받는 값(카드번호)
//alert("성공");
                $("#forderform").submit();
            } else {
                // 결제 실패 시 로직,
                alert("결제에 실패하였습니다.\n내용: " +  rsp.error_msg);
                location.reload();
            }
        });
    }
</script>



<script>
    //결제전 검증 수단으로 temp 테이블에 저장
    function order_temp(total_price){
/*
alert("total_price===> " + total_price);
alert("주문금액 ===> " + $("#od_price").val());
alert("기본배송비 ===> " + $("#de_send_cost").val());
alert("무료정책 ===> " + $("#de_send_cost_free").val());
alert("각상품배송비 ===> " + $("#od_send_cost").val());
alert("산간배송비 ===> " + $("#od_send_cost2").val());
alert("사용포인트 ===> " + $("#od_temp_point").val());
alert("우편번호 ===> " + $("#od_b_zip").val());

return false;
*/
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : '{{ route('ajax_ordertemp') }}',
            method: "POST",
            data: {
                'order_id'          : '{{ $order_id }}',
                'od_id'             : '{{ $s_cart_id }}',
                'od_cart_price'     : $("#od_price").val(),
                'de_send_cost'      : $("#de_send_cost").val(), //기본 배송비
                'de_send_cost_free' : $("#de_send_cost_free").val(), //기본 배송비 무료정책
                'od_send_cost'      : $("#od_send_cost").val(), //각 상품 배송비
                'od_send_cost2'     : $("#od_send_cost2").val(),
                'od_receipt_price'  : total_price,
                'od_temp_point'     : $("#od_temp_point").val(),
                'od_b_zip'          : $("#od_b_zip").val(),
                'tot_item_point'    : '{{ $tot_point }}',
            },
            success : function(data){
alert(data);
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>










@endsection
