@extends('layouts.head')

@section('content')

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

                                @foreach($cart_infos as $cart_info)
                                    @php
                                        $i = 0;
                                /*
                                        $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where item_code = '{$cart_info->item_code}' and od_id = '$s_cart_id' ");

                                        if (!$goods)
                                        {
                                            $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $cart_info->item_name);
                                            $goods_item_code = $cart_info->item_code;
                                        }

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
                                /*
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
                                */
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
                                @endforeach


                                <div class="pdt-20">
                                    <div class="oder">

                                        <ul>
                                            <li>상품금액</li>
                                            <li class="cr_06">6,000</li>
                                        </ul>

                                        <ul>
                                            <li>배송비</li>
                                            <li class="cr_06">2,500</li>
                                        </ul>

                                        <ul>
                                            <li class="cr_06 bold">총 결제 금액</li>
                                            <li class="cr_07 bold">8,500원</li>
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
                                            <li>지구룡</li>
                                        </ul>

                                        <ul class="oder_name col">
                                            <li>연락처</li>
                                            <li>010-1234-1234</li>
                                        </ul>

                                        <ul class="oder_name col">
                                            <li>이메일</li>
                                            <li>g9ryong@g9ryong.com</li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="list ev_rul inner od sol-g-t">
                                <div class="information information_01">
                                    <div class="information-inner-title">
                                        <h4>배송지</h4>
                                        <button onclick='addressopenmodal_001()'>배송지 입력 +
                                        </button>
                                        <!-- 배송지 입력버튼 -->
                                        <!-- <button id="btn" onclick='changeBtnName()'>배송지 설정 / 변경</button> -->
                                        <!-- 클릭햇을때 배송지 입력버튼 -->
                                    </div>

                                    <div class="information-inner-title-btn" id="hide">
                                        등록된 배송지가 없습니다.<br>
                                        <span>'배송지 입력'</span>
                                        버튼을 눌러 배송지를 추가해 주세요.
                                    </div>

                                    <div class="information-inner-01">
                                        <ul class="information-name">
                                            <li>
                                                수령인</li>
                                            <li>
                                                지구룡</li>
                                        </ul>
                                        <ul class="information-phon">
                                            <li>
                                                휴대폰</li>
                                            <li>
                                                010-1354-1235</li>
                                        </ul>
                                        <ul class="information-address od">
                                            <li>
                                                주소</li>
                                            <li>
                                                <div>13458) 경기도 지구시 지구길(지구동, 지구아파트)</div>
                                                <div>101/101</div>
                                                <!-- div 추가 -->
                                            </li>
                                        </ul>
                                        <ul class="information-input">
                                            <li>
                                                배송메모</li>
                                            <input type="text" name="" id="" placeholder="배송시 남길 메세지를 입력해 주세요"></input>
                                        </ul>
                                    </div>
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
                        </div>
                        <!-- 리스트 끝 -->

                    </div>

                </div>
                <!-- 주문 배송 내역 끝 -->

            </div>
            <!-- 서브 컨테이너 끝 -->












@endsection
