@extends('layouts.head')

@section('content')



    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.withdraw_page') }}">회원탈퇴</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>회원 탈퇴</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 평가단 신청 결과 확인 시작  -->
        <div class="eval">
        <form name="withdraw_form" id="withdraw_form" method="post" action="{{ route('mypage.withdraw') }}">
        {!! csrf_field() !!}
            <div class="board">
                <!-- 리스트 시작 -->
                <div class="board_wrap secession_content">
                    <div class="list_02">
                        <div class="secession_01">
                            <h4>지구랭 회원 탈퇴 안내</h4>

                            <div class="secession_text_00">
                                고객님, 저희 서비스가 부족하거나 불편해 탈퇴를 고민하게 해드려 죄송합니다.
                                불편하셨던 점이나 불만사항을 알려주시면, 저희가 적극 반영하여 불편이 없도록 조치하겠습니다. <br>
                                <span class="point00">(jigoorang_hehe@naver.com)</span><br><br><br>

                                만약 그럼에도 회원 탈퇴를 원하신다면, 아래 사항을 유의하시기 바랍니다.</div><br>

                            <ul class="secession_text_01">
                                <li> 1. 탈퇴 시 사용하셨던 동일한 아이디, 휴대폰 번호는 재 가입 방지를 위해 90일간 보존된 후 삭제 처리됩니다.  (재가입을 원할 시 탈퇴일로부터 90일 이후 가능합니다) </li>
                                <li> 2. 탈퇴 시 회원 정보의 복구는 불가능하며, 보유하신 포인트도 모두 무효화됩니다.</li>
                                <!--<li> 3. 작성하신 평가 및 리뷰 정보는 탈퇴 후에도 삭제되지 않습니다. 삭제를 원할 시, 반드시 탈퇴 전 직접 삭제하셔야 합니다.</li>--><br>

                                <input type="checkbox" name="withdraw_chk" id="withdraw_chk" value="ok"> <label for="">위 내용을 모두 확인하였으며 모든 내용에 동의합니다.</label>
                            </ul>
                        </div>
                    </div>
                    <div class="list_02">
                        <div class="secession_02">
                            <h4>회원 탈퇴 사유</h4>
                            <p>그동안 지구랭을 이용해 주셔서 감사합니다<br>
                            탈퇴 이유를 작성해 주시면 더 나은 서비스로 보답하겠습니다</p>
                          <ul class="secession_radio_btn">
                            <li><input type="radio" name="withdraw_type" id="withdraw_type1" value="방문 빈도가 낮아요" onclick="withdraw_type_chk(1)"> <label for="withdraw_type1">방문 빈도가 낮아요</label></li>
                            <li><input type="radio" name="withdraw_type" id="withdraw_type2" value="개인 정보가 걱정돼요" onclick="withdraw_type_chk(2)"> <label for="withdraw_type2">개인 정보가 걱정돼요</label></li>
                            <li><input type="radio" name="withdraw_type" id="withdraw_type3" value="고객응대가 불만이에요(상담, 문의 등)" onclick="withdraw_type_chk(3)"> <label for="withdraw_type3">고객응대가 불만이에요(상담, 문의 등)</label></li>
                            <li><input type="radio" name="withdraw_type" id="withdraw_type4" value="배송, 교환, 환불, 반품이 불만이에요" onclick="withdraw_type_chk(4)"> <label for="withdraw_type4">배송, 교환, 환불, 반품이 불만이에요.</label></li>
                            <li><input type="radio" name="withdraw_type" id="withdraw_type5" value="상품이 부족해요" onclick="withdraw_type_chk(5)"> <label for="withdraw_type5">상품이 부족해요</label></li>
                            <li><input type="radio" name="withdraw_type" id="withdraw_type6" value="컨텐츠가 불만이에요" onclick="withdraw_type_chk(6)"> <label for="withdraw_type6">컨텐츠가 불만이에요</label></li>
                            <li><input type="radio" name="withdraw_type" id="withdraw_type7" value="UI/UX가 불편해요" onclick="withdraw_type_chk(7)"> <label for="withdraw_type7">UI/UX가 불편해요</label></li>
                            <li><input type="radio" name="withdraw_type" id="withdraw_type8" value="기타(직접입력)" onclick="withdraw_type_chk(8)"> <label for="withdraw_type8">기타(직접입력)</label></li>
                            <textarea  id="withdraw_con" style="display:none" name="withdraw_content" id="withdraw_content" maxlength="500" placeholder="이유를 작성해 주세요."></textarea>
                          </ul>
                        </div>
                    </div>
                    <div class="secession_btn_area" >
                        <button class="btn-50-full" type="button" onclick="withdraw_action()">확인</button>
                    </div>
                </div>
                <!-- 리스트 끝 -->

            </div>
        </form>
        </div>
        <!-- 평가단 신청 결과 확인 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->



<script>
    function withdraw_type_chk(num){
        if(num == 8){
            $("#withdraw_con").show();
        }else{
            $("#withdraw_con").hide();
        }
    }

    function withdraw_action(){
        if($('input:checkbox[name=withdraw_chk]').is(':checked') == false){
            alert("탈퇴전 유의사항을 동의해주세요 ");
            $("#withdraw_chk").focus();
            return false;
        }

        if($('input:radio[name=withdraw_type]').is(':checked') == false){
            alert("탈퇴 사유를 선택 하세요.");
            return false;
        }

        if($('input[name=withdraw_type]:checked').val() == "기타(직접입력)"){
alert($("#withdraw_content").val());
            if($.trim($("#withdraw_content").val()) == ""){
                alert("사유를 작성해 주세요.");
                $("#withdraw_content").focus();
                return false;
            }
        }
return false;
        if (confirm("정말 탈퇴 하시겠습니까?") == true){    //확인
            $("#withdraw_form").submit();
        }else{   //취소
            return false;
        }
    }
</script>




@endsection