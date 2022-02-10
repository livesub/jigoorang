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
                                    $item_give_point = 0;
                                @endphp
                                @foreach($cart_infos as $cart_info)
                                    @php
                                        $i = 0;
                                        //$sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where item_code = '{$cart_info->item_code}' and od_id = '$s_cart_id' ");
                                        $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where sct_select = 1 and id='$cart_info->id' and od_id = '$s_cart_id' ");
dd($sum);
                                        if (!$goods)
                                        {
                                            $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $cart_info->item_name);
                                            $goods_item_code = $cart_info->item_code;
                                        }

                                        $goods_count++;

                                        $image = $CustomUtils->get_item_image($cart_info->item_code, 3);
                                        if($image == "") $image = asset("img/no_img.jpg");

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
                                        $sell_price = $sum[0]->price

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
                                                    <li class="pr_tt">
                                                        {{ $item_name }}
                                                    </li>
                                                </a>
                                                <li>
                                                @if($item_options->sio_price > 0)
                                                {{ $item_options->sct_option }}
                                                @endif
                                                </li>
                                                <li class="price_pd">{{ $CustomUtils->display_price(($cart_info->item_price + $item_options->sio_price)) }} {{ number_format($cart_info->sct_qty) }}개</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                    @php
                                        $i++;
                                        $tot_sell_price += $sell_price;
                                        $hap_sendcost   += $sendcost;   //각 상품 배송비 합
                                        $tot_point      += $point;  //각 상품의 포인트 합

                                        //적립금 제공 여부에 따른 적립금 금액(220207 추가)
                                        if($cart_info->item_give_point == 'N'){
                                            //상품 금액에 적립금을 제공 하지 않는 상품 가격을 빼기 위해
                                            $item_give_point = $item_give_point + $sell_price;
                                        }
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
                                        $tot_sendcost = $hap_sendcost;
                                    }else{
                                        $tot_sendcost = $hap_sendcost + $de_send_cost;
                                    }

                                    //총결제금액 = 상품 총금액 + 배송비
                                    $tot_price = $tot_sell_price + $tot_sendcost;
                                @endphp


                                <div class="pdt-20">
                                    <div class="oder">

                                        <ul>
                                            <li>상품금액</li>
                                            <li class="cr_06">{{ $CustomUtils->display_price($tot_sell_price) }}</li>
                                        </ul>

                                        <ul>
                                            <li>배송비</li>
                                            <li class="cr_06">{{ $CustomUtils->display_price($tot_sendcost) }}</li>
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
<input type="hidden" name="od_b_name" id="od_b_name" value="{{ $user_name }}">
<input type="hidden" name="od_b_hp" id="od_b_hp" value="{{ $user_phone }}">
<input type="hidden" name="od_b_zip" id="od_b_zip"  value="{{ $user_zip }}">
<input type="hidden" name="od_b_addr1" id="od_b_addr1" value="{{ $user_addr1 }}">
<input type="hidden" name="od_b_addr2" id="od_b_addr2" value="{{ $user_addr2 }}">
<input type="hidden" name="od_b_addr3" id="od_b_addr3" value="{{ $user_addr3 }}">
<input type="hidden" name="od_b_addr_jibeon" id="od_b_addr_jibeon" value="{{ $user_addr_jibeon }}">


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
<input type="hidden" name="user_point" id="user_point" value="{{ $CustomUtils->get_point_sum(Auth::user()->user_id) }}">
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
                                            <li>{{ number_format($CustomUtils->get_point_sum(Auth::user()->user_id)) }}P</li>
                                        </ul>
                                        @if($CustomUtils->get_point_sum(Auth::user()->user_id) > 0)
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
                                          <li class="cr_06">{{ $CustomUtils->display_price($tot_sendcost) }}</li>
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
                                        <p>(최소 결제 금액은 1,000원 입니다.)</p>
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



<!-- 상세 모달 (상세보기) -->
<div class="modal_001 modal fade">
    <div class="modal-background" onclick="detilclosemodal_001()"></div>
    <div class="modal-dialog">
        <div class="modal-dialog-title">
            <h4>이용약관</h4>
            <div class="btn-close" onclick="detilclosemodal_001()"></div>
        </div>
        <div class="modal-dialog-contents">
            <div class="modal-dialog-contents-title">
                    <p class="mb-20">제1조(목적)</p>

                    <p>이 약관은 지구랭 회사(전자상거래 사업자)가 운영하는 지구랭 사이버 몰(이하 “몰”이라 한다)에서 제공하는 인터넷 관련 서비스(이하 “서비스”라 한다)를 이용함에 있어 사이버 몰과 이용자의 권리․의무 및 책임사항을 규정함을 목적으로 합니다.<br>
                    ※「PC통신, 무선 등을 이용하는 전자상거래에 대해서도 그 성질에 반하지 않는 한 이 약관을준용합니다.」<br>
                    </p>
                    <br>
                    <div class="solid"></div>
                    <br>
                    <p class="mb-20">제2조(정의)</p>

                    <p>
                    ① “몰”이란 지구랭 회사가 재화 또는 용역(이하 “재화 등”이라 함)을 이용자에게 제공하기 위하여 컴퓨터 등 정보통신설비를 이용하여 재화 등을 거래할 수 있도록 설정한 가상의 영업장을 말하며, 아울러 사이버몰을 운영하는 사업자의 의미로도 사용합니다.<br><br>

                    ② “이용자”란 “몰”에 접속하여 이 약관에 따라 “몰”이 제공하는 서비스를 받는 회원 및 비회원을 말합니다.<br><br>

                    ③ ‘회원’이라 함은 “몰”에 회원등록을 한 자로서, 계속적으로 “몰”이 제공하는 서비스를 이용할 수 있는 자를 말합니다.<br><br>

                    ④ ‘비회원’이라 함은 회원에 가입하지 않고 “몰”이 제공하는 서비스를 이용하는 자를 말합니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>


                    <p class="mb-20">제3조(약관 등의 명시와 설명 및 개정)</p>

                    <p>
                    “몰”은 이 약관의 내용과 상호 및 대표자 성명, 영업소 소재지 주소(소비자의 불만을 처리할 수 있는 곳의 주소를 포함), 전화번호•모사전송번호•전자우편주소, 사업자등록번호, 통신판매업 신고번호, 개인정보 관리책임자등을 이용자가 쉽게 알 수 있도록 “몰”의 초기 서비스화면(전면)에 게시합니다.
                    <br>다만, 약관의 내용은 이용자가 연결화면을 통하여 볼 수 있도록 할 수 있습니다.<br><br>

                    “몰”은 이용자가 약관에 동의하기에 앞서 약관에 정하여져 있는 내용 중 청약철회•배송책임•환불조건 등과 같은 중요한 내용을 이용자가 이해할 수 있도록 별도의 연결화면 또는 팝업화면 등을  제공하여 이용자의 확인을 구하여야 합니다.<br><br>

                    ③ “몰”은 「전자상거래 등에서의 소비자보호에 관한 법률」, 「약관의 규제에 관한 법률」, 「전자문서 및 전자거래기본법」, 「전자금융거래법」, 「전자서명법」, 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」, 「방문판매 등에 관한 법률」, 「소비자기본법」 등 관련 법을 위배하지 않는 범위에서 이 약관을 개정할 수 있습니다.<br><br>

                    ④ “몰”이 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 몰의 초기화면에 그 적용일자 7일 이전부터 적용일자 전일까지 공지합니다. 다만, 이용자에게 불리하게 약관내용을 변경하는 경우에는 최소한 30일 이상의 사전 유예기간을 두고 공지합니다. 이 경우 "몰” 은 개정 전 내용과 개정 후 내용을 명확하게 비교하여 이용자가 알기 쉽도록 표시합니다.<br> <br>

                    ⑤ “몰”이 약관을 개정할 경우에는 그 개정약관은 그 적용일자 이후에 체결되는 계약에만 적용되고 그 이전에 이미 체결된 계약에 대해서는 개정 전의 약관조항이 그대로 적용됩니다. 다만 이미 계약을 체결한 이용자가 개정약관 조항의 적용을 받기를 원하는 뜻을 제3항에 의한 개정약관의 공지기간 내에 “몰”에 송신하여 “몰”의 동의를 받은 경우에는 개정약관 조항이 적용됩니다.<br><br>

                    ⑥ 이 약관에서 정하지 아니한 사항과 이 약관의 해석에 관하여는 전자상거래 등에서의<br>
                    소비자보호에 관한 법률, 약관의 규제 등에 관한 법률, 공정거래위원회가 정하는 전자상거래 등에서의 소비자 보호지침 및 관계법령 또는 상관례에 따릅니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제4조(서비스의 제공 및 변경)</p>

                    <p>
                    ① “몰”은 다음과 같은 업무를 수행합니다.<br>

                    1. 재화 또는 용역에 대한 정보 제공 및 구매계약의 체결<br>
                    2. 구매계약이 체결된 재화 또는 용역의 배송<br>
                    3. 기타 “몰”이 정하는 업무<br><br>

                    ② “몰”은 재화 또는 용역의 품절 또는 기술적 사양의 변경 등의 경우에는 장차 체결되는 계약에 의해 제공할 재화 또는 용역의 내용을 변경할 수 있습니다.<br><br>
                    이 경우에는 변경된 재화 또는 용역의 내용 및 제공일자를 명시하여 현재의 재화 또는 용역의 내용을 게시한 곳에 즉시 공지합니다.<br><br>

                    ③ “몰”이 제공하기로 이용자와 계약을 체결한 서비스의 내용을 재화등의 품절 또는 기술적 사양의 변경 등의 사유로 변경할 경우에는 그 사유를 이용자에게 통지 가능한 주소로 즉시 통지합니다.<br><br>

                    ④ 전항의 경우 “몰”은 이로 인하여 이용자가 입은 손해를 배상합니다.<br>
                    다만, “몰”이 고의 또는 과실이 없음을 입증하는 경우에는 그러하지 아니합니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제5조(서비스의 중단)</p>

                    <p>
                    ① “몰”은 컴퓨터 등 정보통신설비의 보수점검•교체, 고장 및 오작동, 통신의 두절 등의 사유가 발생한 경우에는 서비스의 제공을 일시적으로 중단할 수 있습니다.<br><br>

                    ② “몰”은 제1항의 사유로 서비스의 제공이 일시적으로 중단됨으로 인하여 이용자 또는 제3자가 입은 손해에 대하여 배상합니다. 단, “몰”이 고의 또는 과실이 없음을 입증하는 경우에는 그러하지 아니합니다.<br><br>

                    ③ 사업종목의 전환, 사업의 포기, 업체 간의 통합 등의 이유로 서비스를 제공할 수 없게 되는 경우에는 “몰”은 제8조에 정한 방법으로 이용자에게 통지하고 당초 “몰”에서 제시한 조건에 따라 소비자에게 보상합니다.<br><br>
                    다만, “몰”이 보상기준 등을 고지하지 아니한 경우에는 이용자들의 마일리지 또는 적립금 등을 “몰”에서 통용되는 통화가치에 상응하는 현물 또는 현금으로 이용자에게 지급합니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제6조(회원가입)</p>

                    <p>① 이용자는 “몰”이 정한 가입 양식에 따라 회원정보를 기입한 후 이 약관에 동의한다는 의사표시를 함으로서 회원가입을 신청합니다.<br><br>

                    ② “몰”은 제1항과 같이 회원으로 가입할 것을 신청한 이용자 중 다음 각 호에 해당하지 않는 한 회원으로 등록합니다.<br><br>

                    1. 가입신청자가 이 약관 제7조 제3항에 의하여 이전에 회원자격을 상실한 적이 있는 경우, 다만 제7조 제3항에 의한 회원자격 상실 후 3년이 경과한 자로서 “몰”의 회원재가입 승낙을 얻은 경우에는 예외로 합니다.<br>
                    2. 등록 내용에 허위, 기재누락, 오기가 있는 경우<br>
                    3. 기타 회원으로 등록하는 것이 “몰”의 기술상 현저히 지장이 있다고 판단되는 경우<br><br>

                    ③ 회원가입계약의 성립 시기는 “몰”의 승낙이 회원에게 도달한 시점으로 합니다.<br><br>

                    ④ 회원은 회원가입 시 등록한 사항에 변경이 있는 경우, 상당한 기간 이내에 “몰”에 대하여 회원정보 수정 등의 방법으로 그 변경사항을 알려야 합니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제7조(회원 탈퇴, 자격 상실 및 서비스 이용 제한 등)</p>

                    <p>

                    ① 회원은 “몰”에 언제든지 탈퇴를 요청할 수 있으며 “몰”은 즉시 회원탈퇴를 처리합니다.<br>

                    ② 회원이 다음 각 호의 사유에 해당하는 경우, “몰”은 회원자격을 제한 및 정지시키거나 기간을 정하여 특정 서비스 이용을 중지시킬 수 있습니다.<br><br>

                    1. 가입 신청 시에 허위 내용을 등록한 경우<br>
                    2. “몰”을 이용하여 구입한 재화 등의 대금, 기타 “몰”이용에 관련하여 회원이 부담하는 채무를 기일에 지급하지 않는 경우<br>
                    3. 다른 사람의 “몰” 이용을 방해하거나 그 정보를 도용하는 등 전자상거래 질서를 위협하는 경우<br>
                    4. “몰”을 이용하여 법령 또는 이 약관이 금지하거나 공서양속에 반하는 행위를 하는 경우<br>
                    5. “몰”, 기타 제3자의 인격권 또는 지적재산권을 침해하거나 업무를 방해하는 행위<br>
                    6. 다른 회원에 대한 개인정보를 그 동의 없이 수집, 저장, 공개하는 행위<br>
                    7. 특정 제품의 광고성 리뷰 글을 지속적으로 게재하거나, 악의적인 평가를 지속하는 등“몰”의 업무를 방해하는 경우<br><br>

                    ③ “몰”이 회원 자격 및 특정 서비스 이용을 제한․정지 시킨 후, 동일한 행위가 2회 이상 반복되거나 30일 이내에 그 사유가 시정되지 아니하는 경우 “몰”은 회원자격을 상실시킬 수 있습니다.<br><br>

                    ④ “몰”이 회원자격을 상실시키는 경우에는 회원등록을 말소합니다. 이 경우 회원에게 이를 통지하고, 회원등록 말소 전에 최소한 30일 이상의 기간을 정하여 소명할 기회를 부여합니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제8조(회원에 대한 통지)</p>

                    <p>① “몰”이 회원에 대한 통지를 하는 경우, 회원이 “몰”과 미리 약정하여 지정한 전자우편 주소나 휴대폰 문자로 할 수 있습니다.<br>

                    ② “몰”은 불특정다수 회원에 대한 통지의 경우 1주일 이상 “몰” 게시판에 게시함으로서 개별 통지에 갈음할 수 있습니다. 다만, 회원 본인의 거래와 관련하여 중대한 영향을 미치는 사항에 대하여는 개별통지를 합니다.<br></p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20"> 제9조(구매신청 및 개인정보 제공 동의 등) </p>

                    <p>① “몰”이용자는 “몰”상에서 다음 또는 이와 유사한 방법에 의하여 구매를 신청하며, “몰”은 이용자가 구매신청을 함에 있어서 다음의 각 내용을 알기 쉽게 제공하여야 합니다.<br> <br>

                    1. 재화 등의 검색 및 선택<br>
                    2. 받는 사람의 성명, 주소, 전화번호, 전자우편주소(또는 이동전화번호) 등의 입력<br>
                    3. 약관내용, 청약철회권이 제한되는 서비스, 배송료•설치비 등의 비용부담과 관련한 내용<br>
                    에 대한 확인
                    4. 이 약관에 동의하고 위 3.호의 사항을 확인하거나 거부하는 표시 (예: 마우스 클릭)<br>
                    5. 재화등의 구매신청 및 이에 관한 확인 또는 “몰”의 확인에 대한 동의<br>
                    6. 결제방법의 선택<br><br>

                    ② “몰”이 제3자에게 구매자 개인정보를 제공할 필요가 있는 경우<br>
                    1) 개인정보를 제공받는 자, <br>
                    2)개인정보를 제공받는 자의 개인정보 이용목적,<br>
                    3) 제공하는 개인정보의 항목, <br>
                    4) 개인정보를 제공받는 자의 개인정보 보유 및 이용기간을 구매자에게 알리고 동의를 받아야 합니다. (동의를 받은 사항이 변경되는 경우에도 같습니다.)<br><br>

                    ③ “몰”이 제3자에게 구매자의 개인정보를 취급할 수 있도록 업무를 위탁하는 경우에는 <br>
                    1) 개인정보 취급위탁을 받는 자, <br>
                    2) 개인정보 취급위탁을 하는 업무의 내용을 구매자에게 알리고 동의를 받아야 합니다. (동의를 받은 사항이 변경되는 경우에도 같습니다.) <br>
                    다만, 서비스제공에 관한 계약이행을 위해 필요하고 구매자의 편의증진과 관련된 경우에는 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」에서 정하고 있는 방법으로 개인정보 취급방침을 통해 알림으로써 고지절차와 동의절차를 거치지 않아도 됩니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제10조(계약의 성립)</p>

                    <p>
                    ① “몰”은 제9조와 같은 구매신청에 대하여 다음 각 호에 해당하면 승낙하지 않을 수 있습니다. 다만, 미성년자와 계약을 체결하는 경우에는 법정대리인의 동의를 얻지 못하면 미성년자 본인 또는 법정대리인이 계약을 취소할 수 있다는 내용을 고지하여야 합니다.<br>

                    1. 신청 내용에 허위, 기재누락, 오기가 있는 경우<br>
                    2. 미성년자가 담배, 주류 등 청소년보호법에서 금지하는 재화 및 용역을 구매하는 경우<br>
                    3. 기타 구매신청에 승낙하는 것이 “몰” 기술상 현저히 지장이 있다고 판단하는 경우<br><br>

                    ② “몰”의 승낙이 제12조 제1항의 수신확인통지형태로 이용자에게 도달한 시점에 계약이 성립한 것으로 봅니다.<br>

                    ③ “몰”의 승낙의 의사표시에는 이용자의 구매 신청에 대한 확인 및 판매가능 여부, 구매신청의 정정 취소 등에 관한 정보 등을 포함하여야 합니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제11조(지급방법)</p>
                    <p>“몰”에서 구매한 재화 또는 용역에 대한 대금지급방법은 다음 각 호의 방법 중 가용한 방법으로 할 수 있습니다. <br>
                        단, “몰”은 이용자의 지급방법에 대하여 재화 등의 대금에 어떠한 명목의 수수료도 추가하여 징수할 수 없습니다.<br><br>

                    1. 폰뱅킹, 인터넷뱅킹, 메일 뱅킹 등의 각종 계좌이체 <br>
                    2. 선불카드, 직불카드, 신용카드 등의 각종 카드 결제<br>
                    3. 온라인무통장입금<br>
                    4. 전자화폐에 의한 결제<br>
                    5. 수령 시 대금지급<br>
                    6. 마일리지 등 “몰”이 지급한 포인트에 의한 결제<br>
                    7. “몰”과 계약을 맺었거나 “몰”이 인정한 상품권에 의한 결제 <br>
                    8. 기타 전자적 지급 방법에 의한 대금 지급 등</p>
                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제12조(수신확인통지•구매신청 변경 및 취소)</p>

                    <p>
                    ① “몰”은 이용자의 구매신청이 있는 경우 이용자에게 수신확인통지를 합니다.<br><br>

                    ② 수신확인통지를 받은 이용자는 의사표시의 불일치 등이 있는 경우에는 수신확인통지를받은 후 즉시 구매신청 변경 및 취소를 요청할 수 있고 “몰”은 배송 전에 이용자의 요청이 있는 경우에는 지체 없이 그 요청에 따라 처리하여야 합니다.<br>
                    다만 이미 대금을 지불한 경우에는 제15조의 청약철회 등에 관한 규정에 따릅니다.</p>
                    </p>
                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제13조(재화 등의 공급)</p>

                    <p>
                    ① “몰”은 이용자와 재화 등의 공급시기에 관하여 별도의 약정이 없는 이상, 이용자가 청약을 한 날부터 7일 이내에 재화 등을 배송할 수 있도록 주문제작, 포장 등 기타의 필요한 조치를 취합니다.<br>
                    다만, “몰”이 이미 재화 등의 대금의 전부 또는 일부를 받은 경우에는 대금의 전부 또는 일부를 받은 날부터 3영업일 이내에 조치를 취합니다. <br>
                    이때 “몰”은 이용자가 재화 등의 공급 절차 및 진행 사항을 확인할 수 있도록 적절한 조치를 합니다.<br><br>

                    ② “몰”은 이용자가 구매한 재화에 대해 배송수단, 수단별 배송비용 부담자, 수단별 배송기간 등을 명시합니다.<br>
                    만약 “몰”이 약정 배송기간을 초과한 경우에는 그로 인한 이용자의 손해를 배상하여야 합니다.<br>
                    다만 “몰”이 고의•과실이 없음을 입증한 경우에는 그러하지 아니합니다.</p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제14조(환급)</p>
                    <p>“몰”은 이용자가 구매신청한 재화 등이 품절 등의 사유로 인도 또는 제공을 할 수 없을 때에는 지체 없이 그 사유를 이용자에게 통지하고 사전에 재화 등의 대금을 받은 경우에는 대금을 받은 날부터 3영업일 이내에 환급하거나 환급에 필요한 조치를 취합니다.<br>
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제15조(청약철회 등)</p>
                    <p>
                    ① “몰”과 재화등의 구매에 관한 계약을 체결한 이용자는 「전자상거래 등에서의 소비자보호에 관한 법률」 제13조 제2항에 따른 계약내용에 관한 서면을 받은 날(그 서면을 받은 때보다 재화 등의 공급이 늦게 이루어진 경우에는 재화 등을 공급받거나 재화 등의 공급이 시작된 날을 말합니다)부터 7일 이내에는 청약의 철회를 할 수 있습니다.<br>
                    다만, 청약철회에 관하여 「전자상거래 등에서의 소비자보호에 관한 법률」에 달리 정함이 있는 경우에는 동 법 규정에 따릅니다. <br>

                    ② 이용자는 재화 등을 배송 받은 경우 다음 각 호의 1에 해당하는 경우에는 반품 및 교환을 할 수 없습니다.<br><br>

                    1. 이용자에게 책임 있는 사유로 재화 등이 멸실 또는 훼손된 경우(다만, 재화 등의 내용을확인하기 위하여 포장 등을 훼손한 경우에는 청약철회를 할 수 있습니다)<br>
                    2. 이용자의 사용 또는 일부 소비에 의하여 재화 등의 가치가 현저히 감소한 경우<br>
                    3. 시간의 경과에 의하여 재판매가 곤란할 정도로 재화등의 가치가 현저히 감소한 경우<br>
                    4. 같은 성능을 지닌 재화 등으로 복제가 가능한 경우 그 원본인 재화 등의 포장을 훼손한 경우<br><br>

                    ③ 제2항 제2호 내지 제4호의 경우에 “몰”이 사전에 청약철회 등이 제한되는 사실을 소비자가 쉽게 알 수 있는 곳에 명기하거나 시용상품을 제공하는 등의 조치를 하지 않았다면 이용자의 청약철회 등이 제한되지 않습니다.<br>

                    ④ 이용자는 제1항 및 제2항의 규정에 불구하고 재화 등의 내용이 표시·광고 내용과 다르거나 계약내용과 다르게 이행된 때에는 당해 재화 등을 공급받은 날부터 3월 이내, 그 사실을 안 날 또는 알 수 있었던 날부터 30일 이내에 청약철회 등을 할 수 있습니다.<br>
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>


                    <p class="mb-20">제16조(청약철회 등의 효과)</p>
                    <p>
                    ① “몰”은 이용자로부터 재화 등을 반환받은 경우 3영업일 이내에 이미 지급받은 재화 등의 대금을 환급합니다. 이 경우 “몰”이 이용자에게 재화등의 환급을 지연한때에는 그 지연기간에 대하여 「전자상거래 등에서의 소비자보호에 관한 법률 시행령」제21조의2에서 정하는 지연이자율을 곱하여 산정한 지연이자를 지급합니다.<br><br>

                    ② “몰”은 위 대금을 환급함에 있어서 이용자가 신용카드 또는 전자화폐 등의 결제수단으로 재화 등의 대금을 지급한 때에는 지체 없이 당해 결제수단을 제공한 사업자로 하여금 재화 등의 대금의 청구를 정지 또는 취소하도록 요청합니다.<br><br>

                    ③ 청약철회 등의 경우 공급받은 재화 등의 반환에 필요한 비용은 이용자가 부담합니다. “몰”은 이용자에게 청약철회 등을 이유로 위약금 또는 손해배상을 청구하지 않습니다. 다만 재화 등의 내용이 표시·광고 내용과 다르거나 계약내용과 다르게 이행되어 청약철회 등을 하는 경우 재화 등의 반환에 필요한 비용은 “몰”이 부담합니다.<br><br>

                    ④ 교환 또는 반환 신청을 한 날로부터 14일이 지날때까지 이미 수령한 상품을 “몰”에 반환하지 아니하거나 전화,전자우편 등으로 연락되지 아니하는 경우 해당 회원의 교환 또는 반품 신청은 효력을 상실합니다.<br><br>

                    ⑤ 이용자가 재화 등을 제공받을 때 발송비를 부담한 경우에 “몰”은 청약철회 시 그 비용을 누가 부담하는지를 이용자가 알기 쉽도록 명확하게 표시합니다.<br>
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제17조(개인정보보호)</p>
                    <p>
                    ① “몰”은 이용자의 개인정보 수집시 서비스제공을 위하여 필요한 범위에서 최소한의 개인정보를 수집합니다.<br><br>

                    ② “몰”은 회원가입시 구매계약이행에 필요한 정보를 미리 수집하지 않습니다.<br>
                    다만, 관련 법령상 의무이행을 위하여 구매계약 이전에 본인확인이 필요한 경우로서 최소한의 특정 개인정보를 수집하는 경우에는 그러하지 아니합니다.<br><br>

                    ③ “몰”은 이용자의 개인정보를 수집·이용하는 때에는 당해 이용자에게 그 목적을 고지하고 동의를 받습니다. <br><br>

                    ④ “몰”은 수집된 개인정보를 목적외의 용도로 이용할 수 없으며, 새로운 이용목적이 발생한 경우 또는 제3자에게 제공하는 경우에는 이용·제공 단계에서 당해 이용자에게 그 목적을 고지하고 동의를 받습니다. 다만, 관련 법령에 달리 정함이 있는 경우에는 예외로 합니다.<br><br>

                    ⑤ “몰”이 제2항과 제3항에 의해 이용자의 동의를 받아야 하는 경우에는 개인정보관리 책임자의 신원(소속, 성명 및 전화번호, 기타 연락처), 정보의 수집목적 및 이용목적, 제3자에 대한 정보제공 관련사항(제공받은자, 제공목적 및 제공할 정보의 내용) 등 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」 제22조제2항이 규정한 사항을 미리 명시하거나 고지해야 하며 이용자는 언제든지 이 동의를 철회할 수 있습니다.<br><br>

                    ⑥ 이용자는 언제든지 “몰”이 가지고 있는 자신의 개인정보에 대해 열람 및 오류정정을 요구할 수 있으며 “몰”은 이에 대해 지체 없이 필요한 조치를 취할 의무를 집니다. 이용자가 오류의 정정을 요구한 경우에는 “몰”은 그 오류를 정정할 때까지 당해 개인정보를 이용하지 않습니다.<br><br>

                    ⑦ “몰”은 개인정보 보호를 위하여 이용자의 개인정보를 취급하는 자를 최소한으로 제한하여야 하며 신용카드, 은행계좌 등을 포함한 이용자의 개인정보의 분실, 도난, 유출, 동의 없는 제3자 제공, 변조 등으로 인한 이용자의 손해에 대하여 모든 책임을 집니다.<br><br>

                    ⑧ “몰” 또는 그로부터 개인정보를 제공받은 제3자는 개인정보의 수집목적 또는 제공받은 목적을 달성한 때에는 당해 개인정보를 지체 없이 파기합니다.<br><br>

                    ⑨ “몰”은 개인정보의 수집·이용·제공에 관한 동의란을 미리 선택한 것으로 설정해두지 않습니다. <br>
                    또한 개인정보의 수집·이용·제공에 관한 이용자의 동의거절시 제한되는 서비스를 구체적으로 명시하고, 필수수집항목이 아닌 개인정보의 수집·이용·제공에 관한 이용자의 동의 거절을 이유로 회원가입 등 서비스 제공을 제한하거나 거절하지 않습니다.
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제18조(“몰”의 의무)</p>
                    <p>
                    ① “몰”은 법령과 이 약관이 금지하거나 공서양속에 반하는 행위를 하지 않으며 이 약관이 정하는 바에 따라 지속적이고, 안정적으로 재화•용역을 제공하는데 최선을 다하여야 합니다.<br><br>

                    ② “몰”은 이용자가 안전하게 인터넷 서비스를 이용할 수 있도록 이용자의 개인정보(신용정보 포함)보호를 위한 보안 시스템을 갖추어야 합니다.<br><br>

                    ③ “몰”이 상품이나 용역에 대하여 「표시•광고의 공정화에 관한 법률」 제3조 소정의 부당한 표시•광고행위를 함으로써 이용자가 손해를 입은 때에는 이를 배상할 책임을 집니다.<br><br>

                    ④ “몰”은 이용자가 원하지 않는 영리목적의 광고성 전자우편을 발송하지 않습니다.
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제19조(회원의 ID 및 비밀번호에 대한 의무)</p>
                    <p>
                    ① 제17조의 경우를 제외한 ID와 비밀번호에 관한 관리책임은 회원에게 있습니다.<br>

                    ② 회원은 자신의 ID 및 비밀번호를 제3자에게 이용하게 해서는 안됩니다.<br>

                    ③ 회원이 자신의 ID 및 비밀번호를 도난당하거나 제3자가 사용하고 있음을 인지한 경우에는 바로 “몰”에 통보하고 “몰”의 안내가 있는 경우에는 그에 따라야 합니다.
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>


                    <p class="mb-20">제20조(이용자의 의무) 이용자는 다음 행위를 하여서는 안 됩니다.</p>
                    <p>
                    1. 신청 또는 변경시 허위 내용의 등록<br>
                    2. 타인의 정보 도용<br>
                    3. “몰”에 게시된 정보의 변경<br>
                    4. “몰”이 정한 정보 이외의 정보(컴퓨터 프로그램 등) 등의 송신 또는 게시<br>
                    5. “몰” 기타 제3자의 저작권 등 지적재산권에 대한 침해<br>
                    6. “몰” 기타 제3자의 명예를 손상시키거나 업무를 방해하는 행위<br>
                    7. 외설 또는 폭력적인 메시지, 화상, 음성, 기타 공서양속에 반하는 정보를 몰에 공개 또는 게시하는 행위
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>

                    <p class="mb-20">제21조(연결“몰”과 피연결“몰” 간의 관계)</p>
                    <p>
                    ① 상위 “몰”과 하위 “몰”이 하이퍼링크(예: 하이퍼링크의 대상에는 문자, 그림 및 동화상 등이 포함됨)방식 등으로 연결된 경우, 전자를 연결 “몰”(웹 사이트)이라고 하고 후자를 피연결 “몰”(웹사이트)이라고 합니다.<br><br>
                    ② 연결“몰”은 피연결“몰”이 독자적으로 제공하는 재화 등에 의하여 이용자와 행하는 거래에 대해서 보증 책임을 지지 않는다는 뜻을 연결“몰”의 초기화면 또는 연결되는 시점의 팝업화면으로 명시한 경우에는 그 거래에 대한 보증 책임을 지지 않습니다.
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>


                    <p class="mb-20">제22조(저작권의 귀속 및 이용제한)</p>
                    <p>
                    ①“몰”이 작성한 저작물에 대한 저작권 기타 지적재산권은 “몰”에 귀속합니다.<br><br>

                    ② 이용자는 “몰”을 이용함으로써 얻은 정보 중 “몰”에게 지적재산권이 귀속된 정보를 “몰”의 사전 승낙 없이 복제, 송신, 출판, 배포, 방송 기타 방법에 의하여 영리목적으로 이용하거나 제3자에게 이용하게 하여서는 안됩니다.<br><br>

                    ③ “몰”은 약정에 따라 이용자에게 귀속된 저작권을 사용하는 경우 당해 이용자에게 통보하여야 합니다.
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>


                    <p class="mb-20">제23조(분쟁해결)</p>
                    <p>
                    ① “몰”은 이용자가 제기하는 정당한 의견이나 불만을 반영하고 그 피해를 보상처리하기 위하여 피해보상처리기구를 설치․운영합니다.<br><br>

                    ② “몰”은 이용자로부터 제출되는 불만사항 및 의견은 우선적으로 그 사항을 처리합니다. 다만, 신속한 처리가 곤란한 경우에는 이용자에게 그 사유와 처리일정을 즉시 통보해 드립니다.<br><br>

                    ③ “몰”과 이용자 간에 발생한 전자상거래 분쟁과 관련하여 이용자의 피해구제신청이 있는 경우에는 공정거래위원회 또는 시·도지사가 의뢰하는 분쟁조정기관의 조정에 따를 수 있습니다.
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>


                    <p class="mb-20">제24조(재판권 및 준거법)</p>
                    <p>
                    ① “몰”과 이용자 간에 발생한 전자상거래 분쟁에 관한 소송은 제소 당시의 이용자의 주소에 의하고, 주소가 없는 경우에는 거소를 관할하는 지방법원의 전속관할로 합니다.<br>
                    다만, 제소 당시 이용자의 주소 또는 거소가 분명하지 않거나 외국 거주자의 경우에는 민사소송법상의 관할법원에 제기합니다.<br><br>

                    ② “몰”과 이용자 간에 제기된 전자상거래 소송에는 한국법을 적용합니다.
                    </p>

                    <br>
                    <div class="solid"></div>
                    <br>


                    <p>
                    부칙<br>

                    이 약관은 사이트 개설일 부터 시행합니다.
                    </p>
                      <br>

                    <br>

                    </div>
                    <div class="modal-dialog btn normal" onclick="detilclosemodal_001()">
                        닫기
                    </div>
                </div>
            </div>
        </div>
        <!-- 상세 모달 끝 -->




<!-- 상세 모달 (상세보기) -->
<div class="modal_001_1 modal fade">
  <div class="modal-background" onclick="detil2closemodal_001()"></div>
  <div class="modal-dialog">
      <div class="modal-dialog-title">
          <h4>개인정보처리방침</h4>
          <div class="btn-close" onclick="detil2closemodal_001()"></div>
      </div>
      <div class="modal-dialog-contents">
          <div class="modal-dialog-contents-title">
                  < 지구랭 > ('jigoorang.com'이하 '지구랭')은 「개인정보 보호법」 제30조에 따라 정보주체의 개인정보를 보호하고 이와 관련한 고충을 신속하고 원활하게 처리할 수 있도록 하기 위하여 다음과 같이 개인정보 처리방침을 수립·공개합니다.<br>

                  <br>

                  <p class="mb-20">제1조 개인정보의 수집항목 및 이용 목적</p>

                  <p>
                      지구랭은 다음의 목적을 위하여 개인정보를 처리합니다.<br>
                      처리하고 있는 개인정보는 다음의 목적 이외의 용도로는 이용되지 않으며 이용 목적이 변경되는 경우에는 「개인정보 보호법」 제18조에 따라 별도의 동의를 받는 등 필요한 조치를 이행할 예정입니다.
                      <br>
                      수집하는 개인정보 항목과 수집 및 이용목적은 다음과 같습니다.<br>

                      <br>
                      1. 일반 회원 정보
                      - 수집 시기 : 가입시
                      - 수집 항목 : 이름, 이메일 주소, 비밀번호, 핸드폰번호, 생년월일, 성별
                      - 이용 목적: 회원 가입의사 확인, 회원제 서비스 제공에 따른 본인 식별·인증, 회원자격 유지·관리, 서비스 부정이용 방지, 각종 고지·통지, 고충처리, 새로운 서비스 및 신상품이나 이벤트 정보 등의 안내
                      <br><br>
                      2. 제품 평가단 정보
                      - 수집 시기 : 제품 평가단 신청시
                      - 수집 항목 : ① 신청자의 이름, 핸드폰 번호, 이메일 주소<br>
                      ② 배송 수령인의 이름, 핸드폰 번호, 주소
                      - 이용목적: 평가단 응모접수 관리, 물품 발송 및 수령 확인, 평가단 진행을 위한 고지 및 문의 응대, (필요시)제세공과금 납부관련 안내, 평가 리뷰 작성시 선정된 평가단 식별·인증
                      <br><br>
                      3. 주문정보
                      - 수집 시기 : 주문시
                      - 수집 항목 : ① 주문자의 정보(이름, 이메일 주소, 비밀번호, 핸드폰번호)<br>
                      ②수취자의 정보(이름, 주소, 휴대폰 번호)  ③결제 승인정보<br>
                      - 이용목적: 주문 상품의 결제 및 배송

                  </p>

                  <br>

                  <p class="mb-20">제2조 개인정보의 처리 및 보유 기간</p>

                  <p>
                      ① 이용자가 쇼핑몰 회원으로서 지구랭에서 제공하는 서비스를 이용하는 동안 지구랭은 이용자들의 개인정보를 계속적으로 보유하며 서비스 제공 등을 위해 이용합니다.<br>
                      고객의 개인정보는 회원탈퇴 등 수집목적 또는 제공받은 목적이 달성되면 파기하는 것을 원칙으로 합니다. <br>
                      단, 『전자상거래 등에서의 소비자보호에 관한 법률』 등 관련법령의 규정에 의하여 다음과 같이 거래 관련 권리 의무 관계의 확인 등을 일정기간 보유하여야 할 필요가 있을 경우에는 그 기간동안 보유합니다.
                      <br><br>
                      가. 『전자상거래 등에서의 소바자보호에 관한 법률』 제6조
                      - 계약 또는 청약 철회 등에 관한 기록: 5년
                      - 대금결제 및 재화 등의 공급에 관한 기록: 5년
                      - 소비자의 불만 또는 분쟁처리에 관한 기록: 3년
                      <br><br>
                      나. 『통신비밀보호법』 제15조의 2
                      - 방문(로그)에 관한 기록: 1년
                      <br>
                      다. 기타 관련 법령 등
                  </p>

                  <br>

                  <p class="mb-20">제3조(개인정보의 제3자 제공)</p>

                  <p>
                      ①지구랭은 고객의 개인정보를 “제1조 개인정보의 수집항목 및 이용목적”에서 고지한 범위를 넘어 이용하거나 타인 또는 타기업, 기관에 제공하지 않습니다. <br><br>
                      다만 정보주체의 동의, 법률의 특별한 규정 등 「개인정보 보호법」 제17조 및 제18조에 해당하는 경우에만 개인정보를 제3자에게 제공합니다.<br><br>
                      ②제품 구매 후기 및 제품 평가단의 사용 평가 • 후기 등은 통계작성 및 시장조사 등을 위하여 협력사(판매사)에 특정 개인을 식별할 수 없는 형태로 제공할 수 있습니다.
                  </p>

                  <br>

                  <p class="mb-20">제4조(개인정보처리 위탁)</p>

                  <p>
                      ① 지구랭은 원활한 개인정보 업무처리를 위하여 다음과 같이 개인정보 처리업무를 위탁하고 있습니다.<br><br>

                      - 주문 상품의 배송:  우체국<br>
                      - 결제 및 에스크로 서비스:  ㈜아임포트<br>
                      - 평가단 운영을 위한 물품 배송, 수령 확인 및 평가단 관련 안내와 응대 등 : 투비위어드<br>
                      - 본인확인, 아이핀 서비스:  ㈜알리는사람들<br><br>

                      ② 지구랭은 위탁계약 체결시 「개인정보 보호법」 제26조에 따라 위탁업무 수행목적 외 개인정보 처리금지, 기술적·관리적 보호조치, 재위탁 제한, 수탁자에 대한 관리·감독, 손해배상 등 책임에 관한 사항을 계약서 등 문서에 명시하고, 수탁자가 개인정보를 안전하게 처리하는지를 감독하고 있습니다.
                      <br><br>
                      ③ 위탁업무의 내용이나 수탁자가 변경될 경우에는 지체없이 본 개인정보 처리방침을 통하여 공개하도록 하겠습니다.

                  </p>

                  <br>

                  <p class="mb-20">제5조(정보주체와 법정대리인의 권리·의무 및 그 행사방법)</p>

                  <p>
                      ① 정보주체는 지구랭에 대해 언제든지 개인정보 열람·정정·삭제·처리정지 요구 등의 권리를 행사할 수 있습니다.<br><br>

                      ② 제1항에 따른 권리 행사는 지구랭에 대해 「개인정보 보호법」 시행령 제41조 제1항에 따라 서면, 전자우편, 모사전송(FAX) 등을 통하여 하실 수 있으며 지구랭은 이에 대해 지체 없이 조치하겠습니다.<br><br>

                      ③ 제1항에 따른 권리 행사는 정보주체의 법정대리인이나 위임을 받은 자 등 대리인을 통하여 하실 수 있습니다. 이 경우 “개인정보 처리 방법에 관한 고시(제2020-7호)” 별지 제11호 서식에 따른 위임장을 제출하셔야 합니다.<br><br>

                      ④ 개인정보 열람 및 처리정지 요구는 「개인정보 보호법」 제35조 제4항, 제37조 제2항에 의하여 정보주체의 권리가 제한될 수 있습니다.<br><br>

                      ⑤ 개인정보의 정정 및 삭제 요구는 다른 법령에서 그 개인정보가 수집 대상으로 명시되어 있는 경우에는 그 삭제를 요구할 수 없습니다.<br><br>

                      ⑥ 지구랭은 정보주체 권리에 따른 열람의 요구, 정정·삭제의 요구, 처리정지의 요구 시 열람 등 요구를 한 자가 본인이거나 정당한 대리인인지를 확인합니다.
                  </p>

                  <br>

                  <p class="mb-20">제6조(개인정보의 파기)</p>

                  <p>

                      ① 지구랭은 개인정보 보유기간의 경과, 처리목적 달성 등 개인정보가 불필요하게 되었을 때에는 지체없이 해당 개인정보를 파기합니다.<br><br>

                      ② 정보주체로부터 동의 받은 개인정보 보유기간이 경과하거나 처리목적이 달성되었음에도 불구하고 다른 법령에 따라 개인정보를 계속 보존하여야 하는 경우에는, 해당 개인정보를 별도의 데이터베이스(DB)로 옮기거나 보관장소를 달리하여 보존합니다.<br><br>

                      ③ 개인정보 파기의 절차 및 방법은 다음과 같습니다.<br><br>
                      1. 파기절차
                      지구랭은 파기 사유가 발생한 개인정보를 선정하고, 지구랭의 개인정보 보호책임자의 승인을 받아 개인정보를 파기합니다.<br><br>

                      2. 파기방법
                      전자적 파일 형태의 정보는 기록을 재생할 수 없는 기술적 방법을 사용합니다. 종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통하여 파기합니다.

                  </p>

                  <br>

                  <p class="mb-20">제7조(개인정보의 안전성 확보 조치)</p>

                  <p>
                      지구랭은 개인정보의 안전성 확보를 위해 다음과 같은 조치를 취하고 있습니다.  <br><br>

                      1. 해킹 등에 대비한 기술적 대책
                      지구랭은 해킹이나 컴퓨터 바이러스 등에 의한 개인정보 유출 및 훼손을 막기 위하여 보안프로그램을 설치하고 주기적인 갱신·점검을 하며 외부로부터 접근이 통제된 구역에 시스템을 설치하고 기술적/물리적으로 감시 및 차단하고 있습니다.
                      <br><br>
                      2. 개인정보의 암호화
                      이용자의 개인정보는 비밀번호는 암호화되어 저장 및 관리되고 있어, 본인만이 알 수 있으며 중요한 데이터는 파일 및 전송 데이터를 암호화하거나 파일 잠금 기능을 사용하는 등의 별도 보안기능을 사용하고 있습니다.
                  </p>

                  <br>

              <p class="mb-20">제8조(14세 미만 아동의 개인정보보호)</p>

                  <p>
                      지구랭은 법정대리인의 동의가 필요한 만 14세 미만 아동의 회원가입은 받고 있지 않습니다.
                      명의도용이나 시스템 악용 등으로 만 14세 미만의 아동이 사이트에 가입하거나 개인정보를 제공하게 될 경우 법정대리인이 모든 권리를 행사할 수 있습니다
                  </p>

                  <br>

                  <p class="mb-20">제9조(개인정보 자동 수집 장치의 설치•운영 및 거부에 관한 사항)</p>

                  <p>
                      ① 지구랭은 이용자에게 개별적인 맞춤서비스를 제공하기 위해 이용정보를 저장하고 수시로 불러오는 ‘쿠키(cookie)’를 사용합니다.<br><br>
                      ② 쿠키는 웹사이트를 운영하는데 이용되는 서버(http)가 이용자의 컴퓨터 브라우저에게 보내는 소량의 정보이며 이용자들의 PC 컴퓨터내의 하드디스크에 저장되기도 합니다.<br><br>
                      가. 쿠키의 사용 목적 : 이용자가 방문한 각 서비스와 웹 사이트들에 대한 방문 및 이용형태, 인기 검색어, 보안접속 여부, 등을 파악하여 이용자에게 최적화된 정보 제공을 위해 사용됩니다.<br><br>
                      나. 쿠키의 설치•운영 및 거부 : 웹브라우저 상단의 도구>인터넷 옵션>개인정보 메뉴의 옵션 설정을 통해 쿠키 저장을 거부 할 수 있습니다.<br><br>
                      다. 쿠키 저장을 거부할 경우 맞춤형 서비스 이용에 어려움이 발생할 수 있습니다.
                  </p>

                  <br>

                  <p class="mb-20">제10조 (개인정보 보호책임자)</p>
                  <p>
                      ① 지구랭 은(는) 개인정보 처리에 관한 업무를 총괄해서 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보 보호책임자를 지정하고 있습니다.<br><br>

                      ▶ 개인정보 보호책임자<br>
                      담당자 : 지구랭<br>
                      연락처 : jigoorang_hehe@naver.com<br><br>

                      ② 정보 주체께서는 지구랭의 서비스(또는 사업)을 이용하시면서 발생한 모든 개인정보 보호 관련 문의, 불만처리, 피해구제 등에 관한 사항을 개인정보 보호책임자 및 담당부서로 문의하실 수 있습니다.<br>
                      지구랭은 정보주체의 문의에 대해 지체 없이 답변 및 처리해드릴 것입니다.
                  </p>

                  <br>

                  <p class="mb-20">제11조(개인정보 열람청구)</p>
                  <p> 정보주체는 ｢개인정보 보호법｣ 제35조에 따른 개인정보의 열람 청구를 아래의 담당자에 할 수 있습니다. 지구랭은 정보주체의 개인정보 열람청구가 신속하게 처리되도록 노력하겠습니다.<br><br>

                      ▶ 개인정보 열람청구 접수·처리 담당자<br>
                      담당자 : 지구랭<br>
                      연락처 : jigoorang_hehe@naver.com
                  </p>

                  <br>

                  <p class="mb-20">제12조(권익침해 구제방법)</p>

                  <p>
                      정보주체는 개인정보침해로 인한 구제를 받기 위하여 개인정보분쟁조정위원회, 한국인터넷진흥원 개인정보침해신고센터 등에 분쟁해결이나 상담 등을 신청할 수 있습니다.<br>
                      이 밖에 기타 개인정보침해의 신고, 상담에 대하여는 아래의 기관에 문의하시기 바랍니다.<br><br>

                      1. 개인정보분쟁조정위원회 : (국번없이) 1833-6972 (www.kopico.go.kr)<br>
                      2. 개인정보침해신고센터 : (국번없이) 118 (privacy.kisa.or.kr)<br>
                      3. 대검찰청 : (국번없이) 1301 (www.spo.go.kr)<br>
                      4. 경찰청 : (국번없이) 182 (ecrm.cyber.go.kr)<br><br>

                      「개인정보보호법」제35조(개인정보의 열람), 제36조(개인정보의 정정·삭제), 제37조(개인정보의 처리정지 등)의 규정에 의한 요구에 대 하여 공공기관의 장이 행한 처분 또는 부작위로 인하여 권리 또는 이익의 침해를 받은 자는 행정심판법이 정하는 바에 따라 행정심판을 청구할 수 있습니다.<br><br>

                      ※ 행정심판에 대해 자세한 사항은 중앙행정심판위원회(www.simpan.go.kr) 홈페이지를 참고하시기 바랍니다.<br>
                  </p>

                  <br>

                  <p class="mb-20">제13조(개인정보 처리방침 변경)</p>

                  <p>
                      이 개인정보처리방침은 <사이트 개설일>부터 적용됩니다
                  </p>

                  <br>

                  </div>
                  <div class="modal-dialog btn normal" onclick="detil2closemodal_001()">
                      닫기
                  </div>
              </div>
          </div>
      </div>
      <!-- 상세 모달 끝 -->

<script>
document.orderform.addEventListener("keydown", evt => {
    if ((evt.keyCode || evt.which) === 13) {
        evt.preventDefault();
    }
});
</script>


<script>
    //하단 약관동의 이벤트
    let more_arr = document.getElementsByClassName("hide_con");
    let i;

    for (i = 0; i < more_arr.length; i++) {
        more_arr[i].addEventListener("click", function() {

        let cot = this.nextElementSibling;
        if (cot.style.display === "block") {
            cot.style.display = "none";
        } else {
            cot.style.display = "block";
        }
        });
    }
</script>


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

                }else{
                    var ori_ct_tot_price = $("#ori_ct_tot_price").val();
                    //$("input[name=od_send_cost2]").val(ori_ct_tot_price);
                    $("input[name=od_send_cost2]").val(0);
                    $("#od_send_cost3").text(0+'원');

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

        $('#ad_addr').text($ad_addrs);
        $('#ad_addr6').text($ad_addrs6);

        add_baesong_price($("#od_b_zip").val());

        //창닫기
        addressinputclose();
        document.querySelector('.modal.modal_002').classList.remove('in');
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
                var json = JSON.parse(data);
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

        if(od_price >= de_send_cost_free){  //무료 배송 정책애 따라 기본 배송비를 계산 한다
            var total_price = (od_price + send_cost + send_cost2);
        }else{
            var total_price = (od_price + de_send_cost + send_cost + send_cost2);
        }

        //결제 수단 선택
        if($("#pg").val() == "" || $("#method").val() == ""){
            alert('결제 수단을 선택 하세요.');
            return false;
        }

        //결제전 검증 수단으로 temp 테이블에 저장
        order_temp(total_price);

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
            //confirm_url : '{{ route('ajax_ordercomfirm') }}', //실제 서버에서 동작 함 나중에 바꿔 줘야함
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

                setCookie("order_01", "", "1");

                $("#orderform").submit();
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
                'item_give_point'   : '{{ $item_give_point }}',
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
