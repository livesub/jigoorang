@extends('layouts.admhead')

@section('content')


<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('/datepicker/dist/css/datepicker.min.css') }}">
<script src="{{ asset('/datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/datepicker/dist/js/i18n/datepicker.ko.js') }}"></script>
<!--
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .double div {
        float: left;
    }
</style>
-->
<!-- datepicker -->



<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smarteditor2 사용 -->

    <form method="post" action="{{ route('adm_exp_view_save') }}" enctype='multipart/form-data' onsubmit="return check_submit()">
        {!! csrf_field() !!}
        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>평가단 등록</h2>
                <div class="button_box">
                    <button type="submit">등록<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area expr">
                <div class="box_cont">
                    <div class="row">
                        <div class="col">제목</div>
                        <div class="col">
                            <input class="wd800" type="text" id="exp_title" name="exp_title" value="{{ old('exp_title') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품 설정</div>
                        <div class="col">
                            <div class="select_item">
                                <div class="btn_slc" onclick="openmodal_002()">상품선택</div>
                                <div class="selected_prod">선택한 상품명 : 자연풍 친환경 칫솔</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">평가단 인원</div>
                        <div class="col">
                            <input type="text" id="exp_limit_personnel" name="exp_limit_personnel" value="{{ old('exp_limit_personnel') }}" min="0" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 명
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">모집기간</div>
                        <div class="col">
                            <div class="date">
                                <input type="text" id="exp_date_start" name="exp_date_start" value="{{ old('exp_date_start') }}"> ~ <input type="date" id="exp_date_end" name="exp_date_end" value="{{ old('exp_date_end') }}"> ~
                                <input type="number" name="" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">평가가능기간</div>
                        <div class="col">
                            <div class="date">
                                <input type="number" name="" placeholder=""> ~
                                <input type="number" name="" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">선정자 발표일</div>
                        <div class="col">
                            <div class="date">
                                <input type="number" name="" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">목록 이미지</div>
                        <div class="col">
                            <div class="file_att">
                                <p class="t_mint">이미지 사이즈 360*180(720*360)</p>
                                <div class="btn_file">
                                    <label>
                                        파일선택
                                        <input type="file" id="" accept="image/*">
                                    </label>
                                    asdfasdf.png
                                    <!-- 선택된 파일이 없습니다. -->
                                </div>
                                <div class="file">
                                    <label>
                                        <input type="checkbox" id="">수정, 삭제, 새로등록시 체크
                                    </label>
                                </div>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품상세정보</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <!-- 스마트에디터영역 -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- 모달 시작-->
            <div class="modal_002 modal fade">
                <div class="modal-background" onclick="closemodal_002()"></div>
                <div class="modal-dialog">
                    <div class="top_close" onclick="closemodal_002()"></div>
                    <div class="modal_area">
                        <div>
                            <select>
                                <option>전체</option>
                                <option>욕실</option>
                                <option>└ 페이셜 클렌징바</option>
                            </select>
                            <select>
                                <option>상품명</option>
                                <option>상품코드</option>
                            </select>
                            <input type="text" name="" placeholder="">
                            <button type="button" class="btn-ln blk-ln" onclick="">검색</button>
                        </div>

                        <!-- 보드 시작 -->
                        <div class="board">
                            <table>
                                <colgroup>
                                    <col style="width: 40px;">
                                    <col style="width: 60px;">
                                    <col style="width: 180px;">
                                    <col style="width: 180px;">
                                    <col style="width: auto;">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>번호</th>
                                        <th>분류</th>
                                        <th>상품코드</th>
                                        <th>상품명</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
                                        <td class="prod_name">
                                            <div>
                                                <div>
                                                    <img src="../../img/img_prod_01.png">
                                                </div>
                                                <div>
                                                    [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫 환경칫솔친환경칫솔친환
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
                                        <td class="prod_name">
                                            <div>
                                                <div>
                                                    <img src="../../img/img_prod_01.png">
                                                </div>
                                                <div>
                                                    [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
                                        <td class="prod_name">
                                            <div>
                                                <div>
                                                    <img src="../../img/img_prod_01.png">
                                                </div>
                                                <div>
                                                    [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
                                        <td class="prod_name">
                                            <div>
                                                <div>
                                                    <img src="../../img/img_prod_01.png">
                                                </div>
                                                <div>
                                                    [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
                                        <td class="prod_name">
                                            <div>
                                                <div>
                                                    <img src="../../img/img_prod_01.png">
                                                </div>
                                                <div>
                                                    [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- 페이지네이션 시작 -->
                            <div class="paging_box">
                                <div class="paging">
                                    <a class="wide">처음</a>
                                    <a class="wide">이전</a>
                                    <a class="on">1</a>
                                    <a>2</a>
                                    <a>3</a>
                                    <a>4</a>
                                    <a>5</a>
                                    <a>6</a>
                                    <a>7</a>
                                    <a>8</a>
                                    <a>9</a>
                                    <a>10</a>
                                    <a class="wide">다음</a>
                                    <a class="wide">마지막</a>
                                </div>
                            </div>
                            <!-- 페이지네이션 끝 -->

                        </div>
                        <!-- 보드 끝 -->
                    </div>
                </div>
            </div>
            <!-- 모달 끝 -->

        </div>
        <!-- 컨텐츠 영역 끝 -->


<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "exp_content",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {
            bUseToolbar : true,             // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,     // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,         // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            bSkipXssFilter : true,      // client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : aAdditionalFontSet,     // 추가 글꼴 목록
        }, //boolean
    });

    //보내기전 예외처리
    function check_submit(){
        var exp_title = $('#exp_title').val(); //제목
        var exp_item_code = $('#exp_item_code').val(); //상품 선택
        var exp_item_name = $('#exp_item_name').val(); //상품 선택
        var exp_limit_personnel = $('#exp_limit_personnel').val(); //체험단 인원
        var exp_date_start = $('#exp_date_start').val(); //모집기간 시작일
        var exp_date_end = $('#exp_date_end').val(); //모집기간 종료일
        var exp_review_start = $('#exp_review_start').val(); // 평가 가능 기간 시작일
        var exp_review_end = $('#exp_review_end').val(); //평가 가능 기간 종료일
        var exp_release_date = $('#exp_release_date').val(); //당첨자 발표일
        var exp_main_image = $('#exp_main_image').val(); //메인 이미지
        oEditors.getById["exp_content"].exec("UPDATE_CONTENTS_FIELD", []);
        var exp_content = $('#exp_content').val(); //체험단 설명


        if(exp_title == "" || exp_title == null){
            alert('제목을 입력 하세요.');
            return false;
        }

        if(exp_item_code == "" || exp_item_code == null){
            alert('상품을 선택해주세요');
            return false;
        }

        if(exp_item_name == "" || exp_item_name == null){
            alert('상품을 선택해주세요');
            return false;
        }

        if(exp_limit_personnel == "" || exp_limit_personnel == null || exp_limit_personnel == 0 || exp_limit_personnel == "0"){
            alert('인원을 입력 하세요.');
            return false;
        }

        if(exp_date_start == "" || exp_date_start == null){
            alert('모집기간 시작일을 선택해주세요');
            return false;
        }

        if(exp_date_end == "" || exp_date_end == null){
            alert('모집기간 종료일을 선택해주세요');
            return false;
        }

        if(exp_date_end < exp_date_start){
            alert('모집기간 종료일이 시작일보다 작습니다!');
            return false;
        }

        if(exp_review_start == "" || exp_review_start == null){
            alert('평가기간 시작일을 선택해주세요');
            return false;
        }

        if(exp_review_end == "" || exp_review_end == null){
            alert('평가기간 종료일을 선택해주세요');
            return false;
        }

        if(exp_review_end < exp_review_start){
            alert('평가기간 종료일이 시작일보다 작습니다!');
            return false;
        }

        if(exp_release_date == "" || exp_release_date == null){
            alert('당첨자 발표일을 선택해주세요');
            return false;
        }

        if(exp_main_image == "" || exp_main_image == null){
            alert('메인 이미지를 선택해주세요');
            return false;
        }

        if(exp_content == ""  || exp_content == null || exp_content == '&nbsp;' || exp_content == '<p>&nbsp;</p>'){
            alert('상세내용을 입력해주세요');
            return false;
        }



        return true;
    }

    //팝업 띄우기 함수
    function open_pop(){
        window.open("{{ route('adm_exp_popup_for_search_item') }}",'cp','width=600, height=600, scrollbars=yes');
    }
</script>

<script>
    function openModal(){
        document.querySelector('body').classList.add('modal-open')
    }
    function closeModal() {
        document.querySelector('body').classList.remove('modal-open')
    }
    function openmodal_001() {
        openModal();
        document.querySelector('.modal.modal_001').classList.add('in');
    }
    function closemodal_001(){
        closeModal();
        document.querySelector('.modal.modal_001').classList.remove('in');
    }
    function openmodal_002() {
        openModal();
        document.querySelector('.modal.modal_002').classList.add('in');
    }
    function closemodal_002(){
        closeModal();
        document.querySelector('.modal.modal_002').classList.remove('in');
    }
    function openmodal_003() {
        openModal();
        document.querySelector('.modal.modal_003').classList.add('in');
    }
    function closemodal_003(){
        closeModal();
        document.querySelector('.modal.modal_003').classList.remove('in');
    }
</script>

<script>
   $(function() {
       //input을 datepicker로 선언
       $("#exp_date_start").datepicker({
           language: 'ko',
           autoClose: true,
       });
   });
</script>

@endsection