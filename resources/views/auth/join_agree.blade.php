@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/checkbox.js') }}"></script>

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('join.create_agree') }}">회원가입</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area_01">
            <h2>회원가입</h2>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 회원가입 시작  -->
            <div class="join">

                <!-- 회원가입 컨텐츠 시작 -->
                <div class="join_wrap">
                  <div class="text_04">
                    <h2>지구랭 서비스 약관 동의</h2>
                  </div>
                  <div class="line_14 bk"></div>

                  <!-- 약관동의 시작 -->
                  <form name=Join action="{{ route('join.create', 'Y') }}"  onSubmit="return CheckForm(this)" class="join_agree">

                    <div class="agree_01">
                        <input name="check" type="checkbox" value="" id="check1" onclick='checkSelectAll()'/>
                            <label for="약관동의">만 14세 이상입니다. <span class="point">(필수)</span></label>

                            <div class="block">
                                <input name="check" type="checkbox" value="" id="check2" onclick='checkSelectAll()' />
                                <label for="약관동의">약관 동의 <span class="point">(필수)</span></label>
                            </div>

                            <div class="agree_box">
                                제1장 총칙 <br>
                                제1조 (목적) <br>
                                이 약관은 지구랭 (이하 "회사")가 운영하는 지구랭에서 제공하는 전자상거래 관련 서비스(이하 "서비스")를 이용함에 있어 상품 또는
                                용역을 거래하는 자 간의 권리, 의무 등 기타 필요사항, 회원과 회사간의 권리, 의무, 책임사항 및 회원의 서비스 이용절차 등에 관한
                                사항을 규정함을 목적으로 합니다.
                            </div>

                        </div>
                        <div class="agree_01">

                            <input name="check" type="checkbox" value="" id="check3"  onclick='checkSelectAll()'/>
                            <label for="약관동의">개인정보 처리방침 <span class="point">(필수)</span></label>

                            <div class="agree_box">
                            제1장 총칙 <br>
                            제1조 (목적) <br>
                            이 약관은 지구랭 (이하 "회사")가 운영하는 지구랭에서 제공하는 전자상거래 관련 서비스(이하 "서비스")를 이용함에 있어 상품 또는
                            용역을 거래하는 자 간의 권리, 의무 등 기타 필요사항, 회원과 회사간의 권리, 의무, 책임사항 및 회원의 서비스 이용절차 등에 관한
                            사항을 규정함을 목적으로 합니다.
                            </div>

                        </div>

                        <!-- <div class="agree_01">

                            <input name="check" type="checkbox" value="" id="check4" onclick='checkSelectAll()'/>
                            <label for="약관동의">프로모션 수신 동의 (선택)</label>

                            <div class="agree_box">
                            제1장 총칙 <br>
                            제1조 (목적) <br>
                            이 약관은 지구랭 (이하 "회사")가 운영하는 지구랭에서 제공하는 전자상거래 관련 서비스(이하 "서비스")를 이용함에 있어 상품 또는
                            용역을 거래하는 자 간의 권리, 의무 등 기타 필요사항, 회원과 회사간의 권리, 의무, 책임사항 및 회원의 서비스 이용절차 등에 관한
                            사항을 규정함을 목적으로 합니다.
                            </div>

                        </div> -->

                            <input type="checkbox" name="selectall" id="selectall" onclick="selectAll(this)"/>
                            <label for="selectall" class="bold">전체동의</label>

                            <div class="solid"></div>

                        <div class="agree_box_all">
                            <span>위 약관을 모두  확인하였으며 모든 내용에 동의 합니다.</span>

                            <button type="submit" class="btn-full">로그인</button>
                       </div>
                  </form>
                <!-- 약관동의 끝-->
                </div>

                </div>
                <!-- 회원가입 끝 -->
            </div>

        <!-- 회원가입 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->


<script>
/*
    function onNext(){
        if($("input:checkbox[name=age_chk]").is(":checked") == false){
            alert("필수항목 동의 후 회원가입이 가능합니다");
            $("#age_chk").focus();
            return false;
        }

        if($("input:checkbox[name=terms_chk]").is(":checked") == false){
            alert("필수항목 동의 후 회원가입이 가능합니다");
            $("#terms_chk").focus();
            return false;
        }

        if($("input:checkbox[name=terms_chk]").is(":checked") == false){
            alert("필수항목 동의 후 회원가입이 가능합니다");
            $("#terms_chk").focus();
            return false;
        }

        if($("input:checkbox[name=policy_chk]").is(":checked") == false){
            alert("필수항목 동의 후 회원가입이 가능합니다");
            $("#policy_chk").focus();
            return false;
        }

        var check_promotion = $("#promotion_chk").prop("checked");
        if(check_promotion == true){
            location.href="{{ route('join.create', 'Y') }}"
        }else{
            location.href="{{ route('join.create', 'N') }}"
        }
    }
*/
</script>


@endsection