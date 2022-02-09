@extends('layouts.head')

@section('content')



    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.orderview') }}">주문 배송내역</a></li>
                <li><a href="{{ route('mypage.orderview_detail', 'order_id='.$order_id.'&page='.$page) }}">주문 배송내역 상세</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>주문 배송내역 상세</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 주문 배송내역 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                        <div class="list ev_rul pd-30">
                            <div class="num cr_04">송장번호 <span class="ml-30 cr_02">{{ $order_info->od_invoice }}</span></div>
                            <div class="date">배송업체 <span class="ml-30 cr_06"><span class="bold">{{ $order_info->od_delivery_company }}</span> <a href = 'tel:{{ $order_info->od_delivery_tel }}'>{{ $order_info->od_delivery_tel }} </a></span></div>

                            <div class="btn_re point01">
                                <ul class="re_li">
                                    <li class="dl-trk"><a href="{{ $order_info->od_delivery_url }}" target="_blank"><span>배송조회</span></a></li>
                                </ul>
                            </div>
                        </div>

                      <div class="list ev_rul inner">
                         <div class="sub_title"><h4>주문자 정보</h4></div>
                            <div class="pr_body pd-00">
                              <div class="pr_name m-00">
                                  <ul class="oder_name">
                                      <li>주문 번호</li>
                                      <li>{{ $order_info->order_id }}</li>
                                  </ul>

                                  <ul class="oder_name">
                                    <li>주문자</li>
                                    <li>{{ $order_info->od_deposit_name }}</li>
                                  </ul>

                                  <ul class="oder_name">
                                    <li>연락처</li>
                                    <li>{{ Auth::user()->user_phone }}</li>
                                  </ul>
                            </div>
                        </div>
                    </div>

                    <div class="list ev_rul inner">
                      <div class="sub_title"><h4>주문 정보</h4></div>

                    @foreach($carts as $cart)
                    @php
                        switch($cart->sct_status) {
                            case "입금":
                                $ment = "결제완료";
                            break;
                            case "준비":
                                $ment = "상품준비중";
                            break;
                            case "배송":
                                $ment = "배송중";
                            break;
                            case "완료":
                                $ment = "구매완료";
                            break;
                            case "교환":
                                $ment = "교환요청";
                            break;
                            case "상품취소":
                                $ment = "주문취소";
                            break;
                        }

                        $image = $CustomUtils->get_item_image($cart->item_code, 3);
                        if($image == "") $image = asset("img/no_img.jpg");

                        //제조사
                        $item = DB::table('shopitems')->where('item_code', $cart->item_code)->first();
                        if($item->item_manufacture == "") $item_manufacture = "";
                        else $item_manufacture = "[".$item->item_manufacture."]";

                        //제목
                        $item_name = $item_manufacture.stripslashes($cart->item_name);

                        $item_options = $CustomUtils->print_item_options($cart->item_code, $order_info->order_id);

                        $pay_cancel_date = "";
                        if($order_info->pay_cancel_date != "") $pay_cancel_date = substr($order_info->pay_cancel_date, 0, 10);
                    @endphp
                      <div class="pr_body pd-00">
                            <div class="pr-t pd-00">
                                <div class="pr_img">
                                    <img src="{{ $image }}" alt="">
                                </div>

                                <div class="pr_name">
                                    <span class="cr_02">{{ $ment }}</span>

                                    <ul>
                                        <a href=""><li><h4 class="mt-10">{{ $item_name }}</h4></li></a>
                                        <li>
                                        @if($item_options)
                                        {{ $cart->sct_option }}
                                        @endif
                                        </li>
                                        <li class="price_pd">{{ number_format($cart->sct_price + $cart->sio_price) }}원 {{ number_format($cart->sct_qty_cancel) }}개</li>
                                    </ul>

                                </div>
                            </div>
                            @if($cart->sct_status == "상품취소")
                            <div class="bg_02 mt-20"></div>
                            <div class="btn_2ea pdt-30">
                                <button type="button" class="btn-30-sol wd-02" onclick="view_cancel('{{ $cart->id }}')">취소(환불)내역보기</button>
                            </div>
                            @endif
                      </div>


                        <div class="pd-20" style="display:none" id="view_cancel_{{ $cart->id }}">
                          <div class="oder">
                            <ul>
                              <li>취소(환불) 형태</li>
                              <li class="cr_06">취소(환불)</li>
                            </ul>
                            <ul>
                              <li>취소(환불) 수량</li>
                              <li class="cr_06">{{ $cart->sct_qty_cancel }} 개</li>
                            </ul>
                            <ul>
                              <li>주문취소(환불)일</li>
                              <li class="cr_06">{{ $pay_cancel_date }}</li>
                            </ul>
                            <ul>
                              <li class="cr_06">총취소(환불)금액</li>
                              <li class="cr_07">{{ number_format($order_info->od_cancel_price) }}원</li>
                            </ul>
                            <ul>
                              <li class="cr_06">포인트 반환</li>
                              <li class="cr_06">{{ number_format($order_info->od_receipt_point) }}P</li>
                            </ul>
                            <ul>
                              <li>주문취소(환불) 방법</li>
                              <li class="cr_06">{{ $order_info->imp_card_name }}</li>
                            </ul>
                          </div>
                      </div>
                    @endforeach
                          <div class="pd-20">
                            <div class="oder">
                              <ul class="cr_06">
                                <li>배송비</li>
                                <li class="bold">{{ number_format($send_cost) }}원</li>
                              </ul>
                              <ul>
                                <li class="ft-12">기본배송비 {{ number_format($de_send_cost) }}원(도서산간 지역 추가 배송비 발생)</li>
                              </ul>
                            </div>
                          </div>
                      </div>

                      <div class="list ev_rul inner">
                        <div class="sub_title"><h4>결제 정보</h4></div>
                           <div class="pr_body pd-00">
                             <div class="pr_name m-00">

                                 <ul class="oder_name wt-00">
                                   <li>결제수단</li>
                                   <li>신용카드</li>
                                 </ul>

                                 <ul class="oder_name wt-00">
                                   <li>총 상품금액</li>
                                   <li>6000원</li>
                                 </ul>

                                 <ul class="oder_name wt-00">
                                  <li>포인트 할인 금액</li>
                                  <li>-0원</li>
                                </ul>

                                <ul class="oder_name wt-00">
                                  <li>배송비</li>
                                  <li>2500원</li>
                                </ul>

                                <ul class="oder_name wt-00">
                                  <li>주문금액</li>
                                  <li>8500원</li>
                                </ul>

                              </div>
                          </div>
                          <div class="pd-20">
                            <div class="oder">
                              <ul class="cr_06">
                                <li class="bold">최종 결제 금액</li>
                                <li class="cr_03 bold">2500원</li>
                              </ul>
                              <ul>
                                <li>결제 방법</li>
                                <li class="cr_06">신용카드</li>
                              </ul>
                              <ul class="txt-r">
                                <li class="ft-12">신한(1234-****-****-****)일시불</li>
                              </ul>
                            </div>
                          </div>
                       </div>

                       <div class="list ev_rul inner">
                        <div class="sub_title"><h4>포인트</h4></div>
                           <div class="pr_body pd-00">
                             <div class="pr_name m-00">

                                 <ul class="oder_name wt-00">
                                   <li>구매 적립 포인트</li>
                                   <li>60P</li>
                                 </ul>

                                 <ul class="oder_name wt-00">
                                   <li>평가 리뷰 포인트</li>
                                   <li>0P</li>
                                 </ul>

                                 <ul class="oder_name wt-00">
                                  <li>포토 리뷰 포인트</li>
                                  <li>0P</li>
                                </ul>

                                <ul class="oder_name wt-00">
                                  <li>현재 보유 포인트</li>
                                  <li>1,060P</li>
                                </ul>

                              </div>
                          </div>
                      </div>

                      <div class="list ev_rul inner">
                        <div class="sub_title"><h4>배송지 정보</h4></div>
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
                                  <li>주소</li>
                                  <li>서울시 은평구 00길17(00동, 00아파트)</li>
                                </ul>

                                <ul class="oder_name col">
                                  <li>지번주소</li>
                                  <li>111동111호</li>
                                </ul>

                                <ul class="oder_name col">
                                  <li>배송메모</li>
                                  <li>조심히 오세요</li>
                                </ul>

                              </div>
                          </div>
                      </div>

                      <div class="btn">
                        <a href=""><button class="btn-50">이전 페이지로 이동</button></div>
                      </div>




                </div>
                <!-- 리스트 끝 -->


            </div>

        </div>
        <!-- 주문 배송 내역 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->


<script>
    function view_cancel(num){
        $("#view_cancel_"+num).show();
    }
</script>





@endsection
