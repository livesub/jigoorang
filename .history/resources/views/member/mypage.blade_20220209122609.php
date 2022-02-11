@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/button.js') }}"></script> <!-- 배송지 입력버튼 js -->

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area">
            <h2>마이페이지</h2>
            <div class="text_02 wt-nm mypagetitle">
            <span class="mypagetitle_left">
               <p>안녕하세요</p>
               <h3>{{ Auth::user()->user_name }}님</h3>
            </span>
            <a href="{{ route('member_info_index') }}">
               <button class="btn-bg-mint">회원정보 수정</button>
            </a>
            </div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 마이페이지시작  -->

            <div class="mypage">
                <!-- 마이페이지 컨텐츠 시작 -->
                <div class="mypage_wrap">
                    <div class="title">
                        <h3>나의 쇼핑정보</h3>
                </div>
                    <div class="mypage_inner_01">
                        <div class="mypage_innerbox_01">
                            <div class="mypage_box">
                            <a href="{{ route('mypage.orderview') }}">
                                <div class="mypage_box_img01"></div>
                                <span>주문 배송내역</span>
                            </a>
                            </div>


                            <div class="mypage_box">
                                <a href="{{ route('mypage.cancel_return_info') }}">
                                    <div class="mypage_box_img02"> </div>
                                    <span>취소/교환/반품 신청안내</span>
                                </a>
                            </div>
                        </div>

                    <div class="mypage_innerbox_02">
                        <div class="mypage_box solid">
                            <a href="{{ route('mypage.review_possible_list') }}">
                                <div class="mypage_box_img03"></div>
                                <span>제품 평가 및 리뷰</span>
                            </a>
                        </div>


                        <div class="mypage_box solid sol">
                            <a href="{{ route('mypage.wish_list') }}">
                                <div class="mypage_box_img04"></div>
                                <span>응원한 상품</span>
                            </a>
                        </div>
                    </div>

                </div>

            <div class="mypage_inner_02">

                <div class="mypage_content_01">
                    <div class="title box_2">
                        <h3>나의 계정설정</h3>
                    </div>

                    <a href="{{ route('mypage.user_point_list') }}">
                        <div class="mypage_box_02">
                           포인트현황
                           <div class="point">{{ number_format($CustomUtils->get_point_sum(Auth::user()->user_id)) }}P</div>
                        </div>
                    </a>
                </div>
                <div class="mypage_content_01">
                    <div class="title box_2">
                        <h3>나의 배송지</h3>
                    </div>

                    <div class="mypage_box_02 solid" style="cursor:pointer" onclick="addressopenmodal_001('mypage'); baesongji();">
                        배송지 관리
                    </div>

                </div>
                </div>


                <div class="mypage_inner_02">
                    <div class="mypage_content_01">
                        <div class="title box_2">
                            <h3>나의 평가단</h3>
                        </div>

                        <a href="{{ route('mypage.exp_app_list') }}">
                            <div class="mypage_box_02">
                                평가단 신청 결과 확인
                            </div>
                        </a>
                    </div>
                    <div class="mypage_content_01">
                        <div class="title box_2">
                            <h3>나의 문의 내역</h3>
                        </div>
                        <a href="{{ route('mypage.qna_list') }}">
                            <div class="mypage_box_02 solid">
                                1:1 문의 내역/답변
                            </div>
                        </a>
                    </div>
                </div>


            </div> <!-- 마이페이지 컨텐츠 끝 -->

    </div> <!-- 마이페이지 끝  -->
</div><!-- 서브 컨테이너 끝 -->



<!-- 배송지 모달 (주소) // 등록된 배송지가 없습니다. -->
<form name="forderform" id="forderform">
{!! csrf_field() !!}
<div class="modal modal_002 fade" id="disp_baesongi"></div>
</form>
<!-- 배송지 모달 (주소) // 등록된 배송지가 없습니다. 끝 -->

<script>
    function baesongji(){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji') }}',
            data : {
                b_addr : 'mypage',
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

    function calculate_sendcost(){
        //히든 값으로 가져온 값을 해당 태그에 html이나 text로 넣어준다.
        $('#ad_name').text($("#od_b_name").val());
        $('#ad_hp').text($("#od_b_hp").val());
        let $ad_addrs = $("#od_b_zip").val()+") "+$("#od_b_addr1").val()+" "+ $("#od_b_addr2").val();
        let $ad_addrs7 = $("#od_b_addr2").val()+" "+$("#od_b_addr3").val();
        $('#ad_addr').text($ad_addrs);
        $('#ad_addr7').text($ad_addrs7);

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

        if(form_text.length < 30 || form_text.length >= 300){
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

        return true;
    }
</script>



<script src="{{ asset('/design/js/modal-back02.js') }}"></script>


@endsection
