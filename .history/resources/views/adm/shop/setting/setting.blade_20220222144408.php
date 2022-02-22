@extends('layouts.admhead')

@section('content')


        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>설정</h2>
                <div class="button_box">
                    <button type="button" onclick="set_save();">저장</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area setting">

            <form>

                <h3 class="line">사업자 정보</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">회사명</div>
                        <div class="col">
                            <input type="text" name="company_name" value="{{ $company_name }}" id="company_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">대표자명</div>
                        <div class="col">
                            <input type="text" name="company_owner" value="{{ $company_owner }}" id="company_owner">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">사업자 등록번호</div>
                        <div class="col">
                            <input type="text" name="company_saupja_no"  value="{{ $company_saupja_no }}" id="company_saupja_no">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">통신판매업 신고번호</div>
                        <div class="col">
                            <input type="text" name="company_tongsin_no" value="{{ $company_tongsin_no }}" id="company_tongsin_no">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정보관리 책임자명</div>
                        <div class="col">
                            <input type="text" name="company_info_name" value="{{ $company_info_name }}" id="company_info_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">사업장 우편번호</div>
                        <div class="col">
                            <input type="text" name="company_zip" value="{{ $company_zip }}" id="company_zip">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">사업장주소</div>
                        <div class="col">
                            <input class="wd500" type="text" name="company_addr" value="{{ $company_addr }}" id="company_addr">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">이메일</div>
                        <div class="col">
                            <input class="wd500" type="text" name="" placeholder="" value="jigoorang_hehe@naver.com/로그인 문의 : jigoorang_mei@naver.com">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">부가통신 사업자번호(미사용)</div>
                        <div class="col">
                            <input type="text" name="" placeholder="" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">대표전화번호(미사용)</div>
                        <div class="col">
                            <input type="text" name="" placeholder="" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">팩스번호(미사용)</div>
                        <div class="col">
                            <input type="text" name="" placeholder="" value="">
                        </div>
                    </div>
                </div>

                <h3 class="line">쇼핑설정</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">회원가입 적립금</div>
                        <div class="col">
                            <input type="number" name="" placeholder="" value="3,000"> P
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품 구매 적립금</div>
                        <div class="col">
                            <div class="price">
                                <p>0일 경우 적립금이 제공되지 않습니다</p>
                                <input type="number" name="" placeholder=""> %
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">기본 배송비</div>
                        <div class="col">
                            <input type="number" name="" placeholder="" value="3,000"> 원
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">배송비 무료정책</div>
                        <div class="col">
                            <p>입력한 금액 이상 주문시  기본 배송비 무료</p>
                            <input type="number" name="" placeholder=""> 원
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">리뷰작성 지급 포인트</div>
                        <div class="col">
                            <input type="number" name="" placeholder="" value="200"> P
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">포토리뷰작성 지급 포인트</div>
                        <div class="col">
                            <input type="number" name="" placeholder="" value="200"> P
                        </div>
                    </div>
                </div>

                <h3 class="line">메인 진열 타이틀 변경</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">기획전 1</div>
                        <div class="col">
                            <p>15자 이내</p>
                            <input type="text" name="" placeholder="" value="연말 할인 기획전">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">기획전 2</div>
                        <div class="col">
                            <p>15자 이내</p>
                            <input type="text" name="" placeholder="" value="연말 할인 기획전2">
                        </div>
                    </div>
                </div>

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->


<script>
    function set_save(){
        if($("#shop_img_width").val() == ""){
            alert("리사이징될 파일 넓이를 입력 하세요.");
            $("#shop_img_width").focus();
            return false;
        }

        if($("#shop_img_height").val() == ""){
            alert("리사이징될 파일 높이를 입력 하세요.");
            $("#shop_img_height").focus();
            return false;
        }

        $('#set_form').submit();
    }
</script>



@endsection
