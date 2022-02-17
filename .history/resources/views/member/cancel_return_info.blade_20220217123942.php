@extends('layouts.head')

@section('content')



    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.cancel_return_info') }}">취소/교환/환불 신청안내</a></li>

            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>취소/교환/환불 신청안내</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 주문 배송내역 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                    <div class="refund_info">
                        <div class="refund_info_tt">
                            <h4>안내사항</h4>
                            <ul class="refund_s_tt">
                                <li>지구랭에서는 상품의 부분취소가 불가합니다.</li>
                                <li>부분 취소를 원할 시 [고객센터] – [1:1문의]를 통해 관리자에게 문의해주세요.</li>
                            </ul>
                        </div>

                        <div class="refund_info_tt">
                            <h4>주문취소 안내</h4>
                            <ul class="refund_s_tt">
                                <li>‘결제완료/상품준비중’인 단계에서는 직접 주문 취소가 가능합니다.</li>
                                <li>직접 주문 취소 방법: [마이페이지] – [주문 배송내역]에서 ‘전체주문취소’ 클릭</li>
                                <li>배송중/배송완료’ 단계에서는 직접 주문 취소가 불가하며, [고객센터] – [1:1문의]를 통해 관리자에게 문의해주세요.</li>
                            </ul>
                        </div>

                        <div class="refund_info_tt">
                            <h4>교환/반품 신청 안내</h4>
                            <ul class="refund_s_tt">
                                <li>‘교환/반품’ 요청 시 [고객센터] – [1:1문의]를 통해 관리자에게 문의해주세요.</li>
                                <li>•	상품 불량/오배송의 경우, 판매자 귀책사유로 지구랭이 왕복택배비를 부담하여 진행합니다. (상품 수령일로부터 30일 이내에 교환/반품을 신청하셔야 하며, 지구랭에서 제품을 확인한 후, 교환/반품이 처리됩니다)</li>
                                <li>[고객센터] – [1:1문의]를 통해 관리자에 문의해주세요</li>
                                <li>배송중’이거나 ‘구매완료’ 단계에서는 주문 취소가 불가능하며 상품 수령 후 교환/반품 신청을 하셔야 합니다</li>
                                <li>제품 구매시 지급되었던 포인트는 취소 시 환수됩니다</li>
                            </ul>
                        </div>
                        <div class="refund_info_tt">
                            <p> [교환/반품 방법] </p>
                            <ul class="refund_s_tt">
                                <li>단순변심 및 주문실수로 인한 교환, 반품의 경우, 상품 수령일로부터 7일 이내에 교환,반품을 접수하셔야 하며 이 경우 왕복 배송비는 고객 부담입니다</li>
                                <li>상품에 하자가 있거나 오배송된 경우, 그 사실을 안 날 또는 알 수 있었던 날부터 30일 이내에 교환,반품이 가능하며 이 경우 배송비는 지구랭에서 부담합니다</li>
                                <li>[고객센터] – [1:1문의]를 통해 관리자에 문의해주세요</li>
                                <li>배송중’이거나 ‘구매완료’ 단계에서는 주문 취소가 불가능하며 상품 수령 후 교환/반품 신청을 하셔야 합니다</li>
                                <li>제품 구매시 지급되었던 포인트는 취소 시 환수됩니다</li>
                            </ul>
                        </div>
                        <div class="refund_info_tt">
                            <p>[교환/반품이 불가능한 경우]</p>
                            <ul class="refund_s_tt">
                                <li>단순변심 및 주문실수로 인한 교환, 반품의 경우, 상품 수령일로부터 7일 이내에 교환,반품을 접수하셔야 하며 이 경우 왕복 배송비는 고객 부담입니다</li>
                                <li>상품에 하자가 있거나 오배송된 경우, 그 사실을 안 날 또는 알 수 있었던 날부터 30일 이내에 교환,반품이 가능하며 이 경우 배송비는 지구랭에서 부담합니다</li>
                                <li>[고객센터] – [1:1문의]를 통해 관리자에 문의해주세요</li>
                                <li>배송중’이거나 ‘구매완료’ 단계에서는 주문 취소가 불가능하며 상품 수령 후 교환/반품 신청을 하셔야 합니다</li>
                                <li>제품 구매시 지급되었던 포인트는 취소 시 환수됩니다</li>
                            </ul>
                        </div>


                        <div class="refund_info_tt">
                            <h4>환불 안내</h4>
                            <ul class="refund_s_tt">
                                <li>단순변심 및 주문실수로 인한 교환, 반품의 경우, 상품 수령일로부터 7일 이내에 교환,반품을 접수하셔야 하며 이 경우 왕복 배송비는 고객 부담입니다</li>
                            </ul>
                        </div>

                      <div class="btn">
                        <a href="{{ route('customer_center') }}"><button class="btn-50-bg">1:1 문의</button></div>
                      </div>

                    </div>



                </div>
                <!-- 리스트 끝 -->


            </div>

        </div>
        <!-- 주문 배송 내역 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->






@endsection
