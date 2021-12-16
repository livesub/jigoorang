@extends('layouts.head')

@section('content')


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ ../../page/mypage/mypage_evaluation_list.html }}">1:1 문의 내역 / 답변</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>고객센터</h2>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 평가단 신청 결과 확인 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                      <div class="tab_menu">
                        <ul class="list_tab">
                          <li class="is_on">
                            <a href="#tab1" class="btn_list">1:1문의</a>
                          </li>
                          <li>
                            <a href="#tab2" class="btn_list">입점/제휴 문의</a>
                          </li>
                        </ul>

                        <div class="cont_area">
                          <div id="tab1" class="cont">
                            <h4>문의</h4>
                            <ul class="tab-01">
                                <li>
                                <p>문의 / 카테고리</p>
                                    <select>
                                        <option value="">선택해주세요</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </li>
                              </ul>
                              <ul class="tab-02">
                                <li>
                                    <p>글제목</p>
                                    <input type="text" name="" id="" placeholder="제목을 입력하세요(50자 이내)">
                                </li>
                              </ul>
                              <ul class="tab-03">
                                <li>
                                    <p>주문번호</p>
                                    <span>
                                    <input type="text" name="" id="">
                                    <button class="btn-10">구매상품 선택</button>
                                  </span>
                                </li>
                              </ul>
                              <ul class="tab-04">
                                <li>
                                    <p>문의글</p>
                                    <textarea placeholder="내용을 입력해 주세요"></textarea>
                                </li>
                            </ul>
                            <div class="btn_area_50">
                             <button class="btn-50-full">등록</button>
                            </div>
                          </div>
                          <div id="tab2" class="cont con_02">
                            <p>지구랭과의 제휴/입점 문의는<br>
                              <span>jigoorang_hehe@naver.com</span> 으로 메일 주시면 감사드리겠습니다.<br>
                              (메일 내용에 담당자분 성함과 연락처를 꼭 기입해 주세요)</p>
                          </div>
                        </div>
                      </div>
                </div>
                <!-- 평가단 신청 결과 확인 끝  -->

            </div>
        </div>
    </div>
    <!-- 서브 컨테이너 끝 -->


























<table border=1>
    <tr>
        <td>1:1 문의 쓰기</td>
   </tr>
</table>


<table border=1>
<form name="qna_form" id="qna_form" method="post" action="{{ route('mypage.qna_write_save') }}">
{!! csrf_field() !!}
    <tr>
        <td>문의 카테고리 선택 </td>
        <td>
            <select name="qna_cate" id="qna_cate">
                <option value="">선택하세요</option>
                <option value="상품 관련">상품 관련</option>
                <option value="배송 관련">배송 관련</option>
                <option value="주문/결제 관련">주문/결제 관련</option>
                <option value="취소/교환/반품 관련">취소/교환/반품 관련</option>
                <option value="포인트 관련">포인트 관련</option>
                <option value="기타 문의">기타 문의</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>제목</td>
        <td><input type="text" name="qna_subject" id="qna_subject"></td>
    </tr>
    <tr>
        <td>내용</td>
        <td><textarea name="qna_content" id="qna_content"></textarea></td>
    </tr>
    <tr>
        <td><button type="button" onclick="qna_form_submit();">등록</button></td>
    </tr>
</form>
</table>



<script>
    function qna_form_submit(){
        if($("#qna_cate option:selected").val() == ""){
            alert("문의 카테고리를 선택 하세요.");
            $("#qna_cate").focus();
            return false;
        }

        if($.trim($("#qna_subject").val()) == ""){
            alert("문의 제목을 입력 하세요.");
            $("#qna_subject").focus();
            return false;
        }

        if($.trim($("#qna_content").val()) == ""){
            alert("문의 내용을 입력 하세요.");
            $("#qna_content").focus();
            return false;
        }

        $("#qna_form").submit();
    }
</script>




@endsection
