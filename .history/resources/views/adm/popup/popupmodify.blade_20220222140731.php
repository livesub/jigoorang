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

<!-- smarteditor2 사용
<script type="text/javascript" src="{{ asset('/smarteditor2/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
smarteditor2 사용 -->



        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>팝업 수정</h2>
                <div class="button_box">
                    <button type="button" onclick="pop_create()">수정<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cont">

            <form name="pop_create_form" id="pop_create_form" method="post" action="{{ route('adm.pop.createsave') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="box_cont">
                    <div class="row">
                        <div class="col">제목(필수)</div>
                        <div class="col">
                            <p>20자 이내로 입력하세요</p>
                            <input type="text" name="pop_subject" id="pop_subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">이미지(필수)</div>
                        <div class="col">
                            <div class="file_att">
                                <p class="t_mint">이미지 사이즈 360*180(720*360)</p>
                                <div class="btn_file">
                                    <label>
                                        파일첨부
                                        <input type="file" name="pop_img" id="pop_img" accept="image/*" onchange="file_name('pop_img')">
                                    </label>
                                    <span id="pop_img_name"></span>
                                    <!-- 선택된 파일이 없습니다. -->
                                </div>
<!--
                                <div class="file">
                                    <label>
                                        <input type="checkbox" id="">수정, 삭제, 새로등록시 체크
                                    </label>
                                </div>
-->
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">경로</div>
                        <div class="col">
                            <input class="wd500" type="text" name="pop_url" id="pop_url">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">타겟</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" name="pop_target" id="pop_target_no" value="N" checked> 현재
                                </label>
                                <label>
                                    <input type="radio" name="pop_target" id="pop_target_yes" value="Y"> 새창
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">출력여부</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" name="pop_display" id="pop_display_yes" value="Y" checked> 출력
                                </label>
                                <label>
                                    <input type="radio" name="pop_display" id="pop_display_no" value="N"> 미출력
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->


<script>
    //두개짜리 제어 연결된거 만들어주는 함수
    datePickerSet($("#pop_start_time"), $("#pop_end_time"), true); //다중은 시작하는 달력 먼저, 끝달력 2번째

    function datePickerSet(sDate, eDate, flag) {
        if (!isValidStr(sDate) && !isValidStr(eDate) && sDate.length > 0 && eDate.length > 0) {
            var sDay = sDate.val();
            var eDay = eDate.val();

            if (flag && !isValidStr(sDay) && !isValidStr(eDay)) { //처음 입력 날짜 설정, update...
                var sdp = sDate.datepicker().data("datepicker");
                sdp.selectDate(new Date(sDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요

                var edp = eDate.datepicker().data("datepicker");
                edp.selectDate(new Date(eDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요
            }

            //시작일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(eDay)) {
                sDate.datepicker({
                    maxDate: new Date(eDay.replace(/-/g, "/"))
                });
            }
            sDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });

            //종료일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(sDay)) {
                eDate.datepicker({
                    minDate: new Date(sDay.replace(/-/g, "/"))
                });
            }
            eDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });
        }

        function isValidStr(str) {
            if (str == null || str == undefined || str == "")
                return true;
            else
                return false;
        }
    }
</script>


<script type="text/javascript">
/*
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "pop_content",
        sSkinURI: "{{ asset('/smarteditor2/SmartEditor2Skin.html') }}",
        fCreator: "createSEditor2",
        htParams : {
            bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
        }, //boolean
    });
*/
</script>


<script>
    function pop_create(elClickedObj){
//        oEditors.getById["pop_content"].exec("UPDATE_CONTENTS_FIELD", []);
//        var pop_content = $("#pop_content").val();

        if($.trim($("#pop_subject").val()) == ""){
            alert("제목을 입력 하세요.");
            $("#pop_subject").focus();
            return false;
        }

        if($("#pop_img").val() == ""){
            alert("팝업이미지를 첨부 하세요.");
            $("#pop_img").focus();
            return false;
        }
/*
        if( pop_content == ""  || pop_content == null || pop_content == '&nbsp;' || pop_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["pop_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            $("#pop_create_form").submit();
        } catch(e) {}
*/
        $("#pop_create_form").submit();
    }
</script>


<script>
    function file_name(id_val){
        flies = document.getElementById(id_val);

        fileList = "";
        for(i = 0; i < flies.files.length; i++){
            fileList += flies.files[i].name;
        }
        flies_name = document.getElementById(id_val+'_name');
        flies_name.innerHTML = fileList;
    }
</script>





@endsection
