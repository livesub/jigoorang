@extends('layouts.admhead')

@section('content')




<table border=1>
<form name="qna_answer_form" id="qna_answer_form" action="{{ route('adm.qna_answer_save') }}" method="post">
{!! csrf_field() !!}
<input type="hidden" name="id" id="id" value="{{ $qna_info->id }}">
<input type="hidden" name="page" id="page" value="{{ $page }}">
<input type="hidden" name="keyword" id="keyword" value="{{ $keyword }}">
    <tr>
        <td>문의 카테고리</td>
        <td>{{ $qna_info->qna_cate }}</td>
    </tr>
    <tr>
        <td>글제목</td>
        <td>{{ stripslashes($qna_info->qna_subject) }}</td>
    </tr>
    <tr>
        <td>문의 글</td>
        <td>{{ stripslashes($qna_info->qna_subject) }}</td>
    </tr>
    <tr>
        <td>답변 글</td>
        <td><textarea name="qna_answer" id="qna_answer">{{ $qna_info->qna_answer }}</textarea></td>
    </tr>
    <tr>
        <td><button type="button" onclick="qna_answer_submit();">답변하기</button></td>
    </tr>

</form>
</table>


<script>
    function qna_answer_submit(){
        if($.trim($("#qna_answer").val()) == ""){
            alert("답변을 입력 하세요.");
            $("qna_answer").focus();
            return false;
        }

        $("#qna_answer_form").submit();
    }
</script>







@endsection
