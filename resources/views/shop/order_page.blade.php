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
                                /*
                                        $goods_count++;
                                */
                                        $image = $CustomUtils->get_item_image($cart_info->item_code, 3);

                                        //제조사
                                        if($cart_info->item_manufacture == "") $item_manufacture = "";
                                        else $item_manufacture = "[".$cart_info->item_manufacture."]";

                                        //제목
                                        $item_name = $item_manufacture.stripslashes($cart_info->item_name);

                                        //옵션 처리
                                        //$item_options = $CustomUtils->new_print_item_options($cart_info->id, $cart_info->item_code, $s_cart_id);
                                        $item_options = DB::table('shopcarts')->select('sct_option', 'sct_qty', 'sio_price')->where([['id', $cart_info->id], ['item_code', $cart_info->item_code], ['od_id',$s_cart_id]])->first();

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
                                    @endphp
                                @endforeach

                                @php
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

<form name="forderform" id="forderform" method="post" action="{{ route('orderpayment') }}" autocomplete="off">
{!! csrf_field() !!}
<!-- 배송지 관련 -->
<input type="hidden" id="od_b_name" name="ad_name">
<input type="hidden" id="od_b_hp" name="ad_hp">
<input type="hidden" id="od_b_zip" name="ad_zip1">
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

<input type="hidden" name="method" id="method">
<input type="hidden" name="pg" id="pg">
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

                            <div class="list ev_rul inner od sol-g-t">
                                <div class="sub_title">
                                    <h4>포인트 정보</h4>
                                </div>
                                <div class="pr_body pd-00">
                                    <div class="pt_name m-00">

                                        <ul class="oder_name wt-00 mb-20">
                                            <li>보유포인트</li>
                                            <li>6,000P</li>
                                        </ul>

                                        <ul class="oder_point">
                                            <li>사용포인트</li>
                                            <li>
                                            <div class="oder_point_box">
                                              <input type="number" name="" id="" >
                                              <span>P</span>
                                              <button class="btn-10-p">전액 사용</button>
                                            </div>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                                <div class="pdt-20">
                                    <div class="oder">
                                        <ul class="cr_06">
                                            <li class="bold">최종 결제 금액</li>
                                        </ul>
                                        <ul>
                                            <li>상품금액</li>
                                            <li class="cr_06">6,000원</li>
                                        </ul>
                                        <ul>
                                          <li>배송비</li>
                                          <li class="cr_06">2,500원</li>
                                        </ul>
                                        <ul>
                                          <li class="icon_od"><span class="ml-20">도서산간 추가비용</span></li>
                                          <li class="cr_06">0원</li>
                                        </ul>
                                        <ul>
                                          <li>포인트 할인</li>
                                          <li class="cr_06">-1,000P</li>
                                        </ul>
                                        <ul>
                                          <li class="cr_06 bold">총 결제 금액</li>
                                          <li class="cr_07 bold">7,500원</li>
                                        </ul>
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
                                                <input type="radio" name="cp_item" id="rd_1" checked="checked">
                                                <label for="rd_1">신용카드</label>
                                            </li>
                                        </ul>

                                        <ul class="radio pdb-10">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_2">
                                                <label for="rd_2">핸드폰 결제</label>
                                            </li>
                                        </ul>

                                        <ul class="radio pdb-10">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_3">
                                                <label for="rd_3">네이버 페이</label>
                                            </li>
                                        </ul>

                                        <ul class="radio pdb-10">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_4">
                                                <label for="rd_4">카카오페이</label>
                                            </li>
                                        </ul>

                                        <ul class="radio">
                                            <li>
                                                <input type="radio" name="cp_item" id="rd_5">
                                                <label for="rd_5">실시간 계좌 이체</label>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="pd-40 terms sol-tb sol-bb">
                              <div class="hide_con">
                                위 상품의 구매 조건을 확인하였으며, 서비스 약관 및 결제 진행에 동의합니다.
                                <img src="../../recources/icons/icon-od-arr@3x.png" alt="">
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
                              <a href="#"><button>결제하기</button></a>
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
    function baesongji(){
        setCookie("order_01", $("#od_memo").val(), "1") //변수, 변수값, 저장기
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji') }}',
            data : {
            },
            dataType : 'text',
            success : function(result){
//alert(result);
//return false;
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





@endsection
