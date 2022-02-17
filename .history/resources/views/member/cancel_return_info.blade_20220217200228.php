@extends('layouts.head')

@section('content')



    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.cancel_return_info') }}">취소/교환/반품 신청안내</a></li>

            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>취소/교환/반품 신청안내</h2>
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
                            <h4>주문취소 안내</h4>
                            <ul class="refund_s_tt">
                                <li>‘결제완료/상품준비중’인 단계에서는 직접 주문 취소가 가능합니다.<br>
                                    -  주문 취소 방법: [마이페이지] – [주문 배송내역]에서 ‘전체주문취소’ 클릭</li>

                                <li>‘배송중/배송완료’ 단계에서는 직접 주문 취소가 불가합니다.<br>
                                    - 취소를 원할 시 [고객센서] – [1:1문의]를 통해 문의해주세요.</li>
                                    
                                <li>지구랭에서는 주문 상품의 부분취소가 불가합니다. 
                                    - 부분 취소를 원할 시 [고객센터] – [1:1문의]를 통해 문의해주세요.
                                </li>
                            </ul>
                        </div>

                        

                        <div class="refund_info_tt">
                            <h4>교환/반품 안내</h4>
                            <ul class="refund_s_tt">
                                <li>‘교환/반품’ 요청 시 [고객센터] – [1:1문의]를 통해 관리자에게 문의해주세요.</li>
                                <li>상품 불량/오배송의 경우, 판매자 귀책사유로 지구랭이 왕복택배비를 부담하여 진행합니다.<br> (상품 수령일로부터 30일 이내에 교환/반품을 신청하셔야 하며, 지구랭에서 제품을 확인한 후, 교환/반품이 처리됩니다)</li>
                                <li>단순변심/주문실수로 인한 구매자의 귀책사유일 경우, 
                                    고객님이 왕복택배비를 부담하셔야 합니다.<br> (상품 수령일로부터 7일 이내에 교환/반품을 신청하셔야 합니다)</li>
                            </ul>
                        </div>
                        <div class="refund_info_tt">
                            <h4> 취소/교환/반품의 포인트 및 대금 환급 안내 </h4>
                            <ul class="refund_s_tt">
                                <li>취소/교환/반품 시, 구매로 지급되었던 포인트는 환수됩니다.</li>
                                <li>취소/교환/반품 시, 결제로 사용한 포인트가 있을 경우 원복됩니다.</li>
                                <li>주문 취소한 대금은 카드사 사정에 따라 환불 접수일로부터 영업일 기준 3~7일 정도 소요됩니다.</li>
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
