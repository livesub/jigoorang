@extends('layouts.head')

@section('content')

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
                            placeholder="* 참여 이유를 자세히 적어 주시면 선정 확률이 높아집니다.&#13;&#10;
                            (최소 30자 이상, 최대 300자 이내)
                            * 필수기입사항&#13;&#10;
                            유사 제품의 사용경험 여부&#13;&#10;
                            SNS 계정, 블로그 주소 (보유 시)
                          &#13;&#10;* 참여 이유를 자세히 기입해 주세요. 선정 확률이 높아집니다&#13;&#10;* 과거에 비슷한 제품을 사용해 본 경험이 있으신가요? &#13;&#10;*있다면 어떤 제품을 사용해 본 적이 있는지 제품명을 포함하여 적어주세요"></textarea>
                        </ul>
                        <span id="textLengthCheck" class="textLengthCheck"></span>
                    </div>


                    <div class="information information_01">
                        <div class="information-inner-title">
                            <h4>배송지</h4>
                            @if(empty($address))
                            <button type="button" id="btn" onclick="addressopenmodal_001('')">배송지 입력 + </button>    <!-- 배송지 입력버튼 -->
                            @else
                            <button type="button" onclick="addressopenmodal_001(); baesongji();">배송지 설정 / 변경</button> <!-- 클릭햇을때 배송지 입력버튼 -->
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
                                <li id="ad_name"> {{ $address->ad_name}}</li>
                            </ul>
                            <ul class="information-phon">
                                <li> 휴대폰</li>
                                <li id="ad_hp"> {{ $address->ad_hp }}</li>
                            </ul>
                            <ul class="information-address">
                                <li> 주소</li>
                                <li class="block-add">
                                <p id="ad_addr">
                                {{ $address->ad_zip1 }})
                                {{ $address->ad_addr1 }}</p>
                                <span id="ad_addr6">{{ $address->ad_addr2 }}</span>

                                <span id="ad_addr7">{{ $address->ad_addr3 }}</span>
                                </li>

                            </ul>

                            <ul class="information-input">
                                <li>배송메모</li>
                                <input type="hidden" id="ad_jibeon_view" name="ad_jibeon_view" value="{{ $address->ad_jibeon }}">
                                <input type="text" id="ship_memo" name="ship_memo" placeholder="배송시 남길 메세지를 입력해 주세요">
                            </ul>
                          </div>
                        @endif
                    </div>


                        <div class="information information_02">
                            <h4>평가단 참여 동의</h4>
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
                        <button type="submit">평가단 신청</button>
                    </div>
                </div>
                <!-- 신청서 작성 끝 -->
            </div>
        </form>
        </div>
        <!-- 신청서 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->

    <!-- 배송지 모달 (주소) // 등록된 배송지가 없습니다. -->
    <form name="forderform" id="forderform">
    {!! csrf_field() !!}
    <div class="modal modal_002 fade" id="disp_baesongi"></div>
    </form>
    <!-- 배송지 모달 (주소) // 등록된 배송지가 없습니다. 끝 -->


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



<script>
	$('#form_text').on('keyup', function() {
		var content = $(this).val();
        //var srtlength = getTextLength(content);
        var srtlength = content.length;

        $("#textLengthCheck").html("(" + srtlength + " 자 / 최대 300자)"); //실시간 글자수 카운팅

		if (srtlength > 300) {
			alert("최대 300자까지 입력 가능합니다.");
			$(this).val(content.substring(0, 300));
            $('#textLengthCheck').html("(300 자 / 최대 300자)");
		}
	});

    function getTextLength(str) {
        var len = 0;

        for (var i = 0; i < str.length; i++) {
            if (escape(str.charAt(i)).length == 6) {
                len++;
            }
            len++;
        }
        return len;
    }
</script>

<script>
    loading_read();
    function loading_read(){
        $("#form_text").val(getCookie("Ck_01"));
        //var srtlength = getTextLength($("#form_text").val());
        var srtlength = $("#form_text").val().length;
        $("#textLengthCheck").html("(" + srtlength + " 자 / 최대 300자)"); //실시간 글자수 카운팅
    }
</script>

<script>

    function baesongji(){
        setCookie("Ck_01", $("#form_text").val(), "1") //변수, 변수값, 저장기
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

    //보내기 전 예외처리
    function check_submit(){
        let form_text = $('#form_text').val();
        let od_b_name = $("#od_b_name").val();
        let od_b_hp = $("#od_b_hp").val();
        let od_b_zip = $("#od_b_zip").val();
        let od_b_addr1 = $("#od_b_addr1").val();
        let od_b_addr2 = $("#od_b_addr2").val();
        let od_b_addr3 = $("#od_b_addr3").val();
        let od_b_addr_jibeon = $("#od_b_addr_jibeon").val();
        var srtlength2 = getTextLength($("#form_text").val());

        //주소가 없을 경우 예외처리 하나라도 없을 경우 나오게
        if((od_b_name == null || od_b_name == "") || (od_b_hp == null || od_b_hp == "") || (od_b_zip == null || od_b_zip == "")
        || (od_b_addr1 == null || od_b_addr1 == "") || (od_b_addr2 == null || od_b_addr2 == "")){
            alert('배송지가 입력되지 않았습니다.');
            return false;
        }

        if(form_text == null || form_text == ""){
            alert('참여이유를 작성해 주세요.');
            $('#form_text').focus();
            return false;
        }

        if(form_text.length < 30 || form_text.length > 300){
            alert('평가단 참여이유를 30자 이상~ 300자 이내로 작성해 주세요.');
            $('#form_text').focus();
            return false;
        }

/*
        if($.trim($("#ship_memo").val()) == ""){
            alert('배송 메모를 입력 하세요.');
            $('#ship_memo').focus();
            return false;
        }
*/
        if(!$('#promotion_agree').is(":checked")){
            alert('약관에 동의 후 평가단 신청이 가능합니다.');
            return false;
        }

        //참여이유 및 배송메모 값 옮기기
        $("#reason_memo").val(form_text);
        $("#shipping_memo").val($("#ship_memo").val());

        setCookie("Ck_01", "", "") //저장 될때 쿠키 값날림
        return true;
    }
</script>





<script src="{{ asset('/design/js/modal-back02.js') }}"></script>

@endsection