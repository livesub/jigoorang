@extends('layouts.admhead')

@section('content')



<!-- smarteditor2 사용 -->
<script type="text/javascript" src="{{ asset('/smarteditor2/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
<!-- smarteditor2 사용 -->

<table>
    <tr>
        <td>
            <h4>지구록 작성</h4>
        </td>
    </tr>
    <td><button type="button" onclick="submitContents();">등록</button></td>
</table>

<table style="width:700px;">
<form name="n_create_form" id="n_create_form" method="post" action="{{ route('adm.notice_write_save') }}" enctype="multipart/form-data">
{!! csrf_field() !!}
    <tr>
        <td>제목</td>
        <td><input type="text" name="n_subject" id="n_subject"></td>
    </tr>
    <tr>
        <td>설명글</td>
        <td><input type="text" name="n_explain" id="n_explain"></td>
    </tr>
    <tr>
        <td>이미지</td>
        <td><input type="file" name="n_img" id="n_img"></td>
    </tr>
    <tr>
        <td>상세내용</td>
        <td><textarea type="text" name="n_content" id="n_content" style="width:100%"></textarea></td>
    </tr>
</table>




<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "n_content",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {
            bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
        }, //boolean
    });
</script>


<script>
    function submitContents(elClickedObj) {
        oEditors.getById["n_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        var n_content = $("#n_content").val();

        if($.trim($("#n_subject").val()) == ""){
            alert("제목을 올바르게 입력해 주세요");
            $("#n_subject").focus();
            return false;
        }

        if($.trim($("#n_explain").val()) == ""){
            alert("설명글을 올바르게 입력해 주세요");
            $("#n_explain").focus();
            return false;
        }

        if($("#n_img").val() == ""){
            alert("목록 이미지를 등록해 주세요");
            $("#n_img").focus();
            return false;
        }

        if( n_content == ""  || n_content == null || n_content == '&nbsp;' || n_content == '<p>&nbsp;</p>')  {
             alert("상세 내용을 입력해 주세요");
             oEditors.getById["n_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}

        $("#n_create_form").submit();
    }
</script>







@endsection

