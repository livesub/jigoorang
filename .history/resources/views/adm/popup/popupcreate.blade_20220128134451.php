@extends('layouts.admhead')

@section('content')

<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('/datepicker/dist/css/datepicker.min.css') }}">
<script src="{{ asset('/datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/datepicker/dist/js/i18n/datepicker.ko.js') }}"></script>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .double div {
        float: left;
    }
</style>
<!-- datepicker -->

<!-- smarteditor2 사용
<script type="text/javascript" src="{{ asset('/smarteditor2/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
smarteditor2 사용 -->

<table>
    <tr>
        <td><h4>팝업 관리 등록</h4></td>
    </tr>
</table>

<table border=1>
<form name="pop_create_form" id="pop_create_form" method="post" action="{{ route('adm.pop.createsave') }}" enctype="multipart/form-data">
{!! csrf_field() !!}
<!--
    <tr>
        <td>시간</td>
        <td><input type="text" name="pop_disable_hours" id="pop_disable_hours" size="3" value="24">시간
        <br>※고객이 다시 보지 않음을 선택할 시 몇 시간동안 팝업레이어를 보여주지 않을지 설정합니다.</td>
    </tr>
-->
    <tr>
        <td>팝업 제목</td>
        <td><input type="text" name="pop_subject" id="pop_subject"></td>
    </tr>
    <tr>
        <td>팝업이미지(필수)</td>
        <td><input type="file" name="pop_img" id="pop_img"></td>
    </tr>
    <tr>
        <td>경로</td>
        <td>
            <input type="text" name="pop_url" id="pop_url">
        </td>
    </tr>

    <tr>
        <td>타겟</td>
        <td>
            <input type="radio" name="pop_target" id="pop_target_no" value="N" checked>현재창
            <input type="radio" name="pop_target" id="pop_target_yes" value="Y">새창
        </td>
    </tr>


    <tr>
        <td>출력 유무</td>
        <td>
            <input type="radio" name="pop_display" id="pop_display_yes" value="Y" checked>출력
            <input type="radio" name="pop_display" id="pop_display_no" value="N">출력안함
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <button type="button" onclick="pop_create()">저장</button>
        </td>
    </tr>
</form>
</table>


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






@endsection
