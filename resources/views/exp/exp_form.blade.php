@extends('layouts.head')

@section('content')
<script src="{{ asset('/design/js/modal.js') }}"></script>
<script src="{{ asset('/design/js/button.js') }}"></script> <!-- 배송지 입력버튼 js -->

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('exp.list') }}">정직한 평가단</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area">
            <h2>평가단 신청하기</h2>
            <div class="text_02 wt-nm">
                정직한 평가단에 참여해 여러분의 사용 평가와 후기를 들려주세요. <br>
                한 분 한 분의 평가가 모이면, 믿을 수 있는 친환경 제품이 <br>
                더 많은 고객을 만날 수 있는 든든한 힘이 됩니다.
            </div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 신청서 시작  -->
        <div class="eval">
        <form action="{{ route('exp.list.form_create') }}" method="post" onsubmit="return check_submit()">
        {!! csrf_field() !!}
        <input type="hidden" id="exp_id" name="exp_id" value="{{ $id }}">
        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->user_id }}">
        <input type="hidden" id="sca_id" name="sca_id" value="{{ $result->sca_id }}">
        <input type="hidden" id="item_id" name="item_id" value="{{ $result->item_id }}">
        <input type="hidden" id="user_name" name="user_name" value="{{ auth()->user()->user_name }}">
        @if(empty($address))
            <input type="hidden" id="od_b_name" name="ad_name">
            <input type="hidden" id="od_b_hp" name="ad_hp">
            <input type="hidden" id="od_b_zip" name="ad_zip1">
            <input type="hidden" id="od_b_addr1" name="ad_addr1">
            <input type="hidden" id="od_b_addr2" name="ad_addr2">
            <input type="hidden" id="od_b_addr3" name="ad_addr3">
            <input type="hidden" id="od_b_addr_jibeon" name="ad_jibeon">
        @else
            <input type="hidden" id="od_b_name" name="ad_name" value="{{ $address->ad_name }}">
            <input type="hidden" id="od_b_hp" name="ad_hp" value="{{ $address->ad_hp }}">
            <input type="hidden" id="od_b_zip" name="ad_zip1" value="{{ $address->ad_zip1 }}">
            <input type="hidden" id="od_b_addr1" name="ad_addr1" value="{{ $address->ad_addr1 }}">
            <input type="hidden" id="od_b_addr2" name="ad_addr2" value="{{ $address->ad_addr2 }}">
            <input type="hidden" id="od_b_addr3" name="ad_addr3" value="{{ $address->ad_addr3 }}">
            <input type="hidden" id="od_b_addr_jibeon" name="ad_jibeon" value="{{ $address->ad_jibeon }}">
        @endif
        <input type="hidden" id="shipping_memo" name="shipping_memo">
        <input type="hidden" id="reason_memo" name="reason_memo">

            <div class="board">
                <!-- 신청서 작성 시작 -->
                <div class="board_wrap">
                    <div class="information">
                        <h4>참여자 정보</h4>
                        <ul class="information-name">
                            <li> 이름</li>
                            <li> {{ auth()->user()->user_name }}</li>
                        </ul>
                        <ul class="information-phon">
                            <li> 휴대폰</li>
                            <li> {{ auth()->user()->user_phone }}</li>
                            <a href="{{ route('member_info_index') }}"><button type="button">변경</button></a>
                        </ul>
                        <ul class="information-email">
                            <li> 이메일</li>
                            <li> {{ auth()->user()->user_id }}</li>
                        </ul>
                        <ul class="information-input">
                            <li> 평가단 참여이유 <br>
                                <span>(필수입력)</span>
                            </li>
                            <!-- <input type="text"
                            placeholder="* 최대 300자까지 입력 가능합니다 &#13;&#10;
                            * 참여 이유를 자세히 기입해 주세요. 선정 확률이 높아집니다&#13;&#10;
                            * 과거에 비슷한 제품을 사용해 본 경험이 있으신가요? &#13;&#10;
                               있다면 어떤 제품을 사용해 본 적이 있는지 제품명을 포함하여 적어주세요"
                            /> -->
                            <textarea id="form_text" name="form_text" cols="100%"
                            placeholder="* 최대 300자까지 입력 가능합니다 &#13;&#10;* 참여 이유를 자세히 기입해 주세요. 선정 확률이 높아집니다&#13;&#10;* 과거에 비슷한 제품을 사용해 본 경험이 있으신가요? &#13;&#10;*있다면 어떤 제품을 사용해 본 적이 있는지 제품명을 포함하여 적어주세요"></textarea>
                            <span id="textLengthCheck"></span>
                        </ul>
                    </div>


                    <div class="information information_01">
                        <div class="information-inner-title">
                            <h4>배송지</h4>
                            @if(empty($address))
                            <button type="button" id="btn" onclick='addressopenmodal_001()'>배송지 입력 + </button>    <!-- 배송지 입력버튼 -->
                            @else
                            <button type="button" onclick="addressopenmodal_001()">배송지 설정 / 변경</button> <!-- 클릭햇을때 배송지 입력버튼 -->
                            @endif

                        </div>

                        @if(empty($address))
                        <div class="information-inner-title-btn" id="hide">
                                등록된 배송지가 없습니다.<br>
                                <span>'배송지 입력'</span> 버튼을 눌러 배송지를 추가해 주세요.
                        </div>
                        @else

                        <div class="information-inner-01">
                            <ul class="information-name">
                                <li> 수령인</li>
                                <li> 지구룡</li>
                            </ul>
                            <ul class="information-phon">
                                <li> 휴대폰</li>
                                <li> 010-1354-1235</li>
                            </ul>
                            <ul class="information-address">
                                <li> 주소</li>
                                <li> 13458) 경기도 지구시 지구길(지구동, 지구아파트)
                                   <br> 1001동 101호</li>
                            </ul>
                            <ul class="information-input">
                                <li> 배송메모 <br>
                                    <span>(필수입력)</span>
                                </li>
                                <input type="text" name="" id="" placeholder="배송시 남길 메세지를 입력해 주세요">
                            </ul>
                          </div>
                        @endif
                    </div>


                        <div class="information information_02">
                            <h4>참여자 정보</h4>
                            <div class="information-inner-checkbox">
                                <input type="checkbox" id="promotion_agree" name="promotion_agree" value="y">

                                <label for="checkbox">개인정보 제3자 제공 동의 <span>(필수)</span></label>
                                    <p onclick="detilopenmodal_001()">상세보기</p>
                            </div>
                            <div class="information-inner-subtitle">
                                <h4>안내사항</h4>
                                <ul class="inner-subtitle">
                                    <li>평가단 선정 결과 안내는 [마이페이지] 내 [나의 평가단]에서 확인할 수 있습니다</li>
                                    <li>평가단 선정자 발표 및 배송 일정은 부득이한 사유로 변동될 수 있습니다</li>
                                    <li>평가단 신청 완료 후 배송지 변경이 절대 불가능합니다</li>
                                    <li>평가 제품은 신청시 등록하신 주소로 발송되며, 부정확한 정보 기입으로 발생한 배송 문제에 대해서는 재발송이 불가합니다</li>
                                    <li>평가단으로 선정되었으나 리뷰를 미작성할 경우 향후 평가단 선정 과정에서 불이익을 받을 수 있습니다 </li>
                                    <li>평가단 제품은 재판매 불가하며, 적발시 해당 평가로 인해 제공된 포인트는 삭감됩니다.  또한, 지구랭 서비스 이용에 제한을 받거나,<br> 이후 평가단 선정에 불이익을 받을 수 있습니다</li>
                                    <li>평가 진행시, 답변이 불성실하거나 악의적인 리뷰가 있다고 판단될 경우 해당 평가 답변은 사전 통보 없이  삭제될 수 있으며, 향후 지구랭 서비스 이용에 제한을 받거나 이후 평가단 선정에 불이익을 받을 수 있습니다</li>
                                    <li>평가단 신청하는 경우 위 안내 사항에 인지하고 동의하는 것으로 간주합니다</li>

                                </ul>
                            </div>
                       </div>
                       <div class="list_img_btn_area">
                        <button>평가단 신청</button>
                    </div>
                </div>
                <!-- 신청서 작성 끝 -->
            </div>
        </form>
        </div>
        <!-- 신청서 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->




      <!-- 상세 모달 -->
      <div class="modal_001 modal fade">
        <div class="modal-background" onclick="detilclosemodal_001()"></div>
        <div class="modal-dialog">
            <div class="modal-dialog-title">
                <h4>개인정보 제3자 제공 동의</h4>
                <div class="btn-close" onclick="detilclosemodal_001()">
                </div>
            </div>
            <div class="modal-dialog-contents">
                <div class="modal-dialog-contents-title">
                <ul class="modal-dialog-contents-text">
                    <h4>개인정보보호법에 의거하여 다음과 같이 개인정보 수집 및 이용목적을 알려드립니다</h4>
                    <li>제공업체 : 투비위어드</li>
                    <li>제공목적 : 평가단 응모접수 관리, 물품 발송 및 수령 확인,  평가단 진행을 위한 고지 및 문의 응대,  제세공과금 납부관련 안내(필요시),  평가 리뷰 작성시 선정된 평가단 식별·인증</li>
                    <li>제공정보 : 신청자의 이름, 핸드폰 번호, 이메일 주소, 배송 수령인의 이름, 핸드폰 번호, 주소 </li>
                    <li>제공기간: 이벤트 종료 후 30일 이내 파기</li>
                </ul>
                <br>
                <div class="solid"></div>
                <br>
                <ul class="modal-dialog-contents-text-01">
                    <li>제공업체 : 평가단이 평가 진행한 제품의 제조사</li>
                    <li>제공목적 : 시장조사, 통계작성, 소비자 사용 후기를 통한 품질 업그레이드 연구 등</li>
                    <li>제공정보 : 특정 개인을 식별할 수 없는 형태로 제공</li>
                    <h4>개인정보 수집 및 이용 동의와 관련한 위 사항에 대하여 원하지 않는 경우 동의를 거부할 수 있으며, 동의하지 않는 경우는 서비스 이용에 제한이 있을 수 있습니다</h4>
                </ul>
                </div>
                <div class="modal-dialog btn normal" onclick="detilclosemodal_001()">
                    닫기
                </div>
        </div>
        </div>
    </div>

    <!-- 배송지 모달 (주소) // 등록된 배송지가 없습니다. -->
    <div class="modal_002 modal fade" id="disp_baesongi"></div>
    <!-- 배송지 모달 (주소) // 등록된 배송지가 없습니다. 끝 -->

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




@endsection