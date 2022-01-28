@extends('layouts.admhead')

@section('content')

<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>

<table>
    <tr>
        <td><h4>이메일 내용 추가</h4></td>
    </tr>
</table>

<table border=1 width="800">
<form name="emailForm" id="emailForm" action="{{ route('adm.admemail.createsave') }}" method="POST" enctype='multipart/form-data'>
{!! csrf_field() !!}
    <tr>
        <td>이메일 제목</td>
        <td><input type="text" name="email_subject" id="email_subject" value="{{ old('email_subject') }}"></td>
    </tr>

    <tr>
        <td>이메일 내용</td>
        <td>
            <textarea name="email_content" id="email_content" style="width:100%;height:220px;">{{ old('email_content') }}</textarea>
<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "email_content",
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
        </td>
    </tr>

    @for($i = 1; $i <= 2; $i++)
    <tr>
        <td>첨부파일{{ $i }}</td>
        <td><input type="file" name="email_file{{ $i }}" id="email_file{{ $i }}"></td>
    </tr>
    @endfor


    <tr>
        <td colspan="10"><button type="button" onclick="add_email()">메일 내용 저장</button></td>
    </tr>
</form>
</table>




<script>
    function add_email(elClickedObj) {
        oEditors.getById["email_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("email_content").value를 이용해서 처리하면 됩니다.
        var email_content = $("#email_content").val();

        if($.trim($("#email_subject").val()) == ""){
            alert("제목을 입력하세요.");
            $("#email_subject").focus();
            return;
        }

        if( email_content == ""  || email_content == null || email_content == '&nbsp;' || email_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["email_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}

        $("#emailForm").submit();
    }
</script>







@endsection
