@extends('layouts.admhead')

@section('content')
<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smarteditor2 사용 -->
체험단 신청 뷰입니다.
<table border=1 width="900px;">
    <form method="post" action="" enctype='multipart/form-data'>
        {!! csrf_field() !!}
        <tr>
            <td>제목</td>
            <td><input type="text" id="exp_title" name="exp_title" value="{{ old('exp_title') }}"></td>
        </tr>
        <tr>
            <td>상품 설정</td>
            <td>
                <button type="button">상품 검색</button>
                <input type="hidden" id="exp_item_code" name="exp_item_code" value="{{ old('exp_item_code') }}">
            </td>
        </tr>
        <tr>
            <td>체험단 인원</td>
            <td><input type="number" id="exp_limit_personnel" name="exp_limit_personnel" value="{{ old('exp_limit_personnel') }}"></td>
        </tr>
        <tr>
            <td>모집기간</td>
            <td><input type="date" id="exp_date_start" name="exp_date_start" value="{{ old('exp_date_start') }}"> ~ <input type="date" id="exp_date_end" name="exp_date_end" value="{{ old('exp_date_end') }}"></td>
        </tr>
        <tr>
            <td>평가 가능 기간</td>
            <td><input type="date" id="exp_review_start" name="exp_review_start" value="{{ old('exp_review_start') }}"> ~ <input type="date" id="exp_review_end" name="exp_review_end" value="{{ old('exp_review_end') }}"></td>
        </tr>
        <tr>
            <td>당첨자 발표일</td>
            <td><input type="date" id="exp_release_date" name="exp_release_date" value="{{ old('exp_release_date') }}"></td>
        </tr>
        <tr>
            <td>메인 이미지</td>
            <td><input type="file" id="exp_main_image" name="exp_main_image"></td>
        </tr>
        <tr>
            <td>상품내용</td>
            <td>
                <textarea type="text" name="exp_content" id="exp_content" style="width:100%">{{ old('exp_content') }}</textarea>
            </td>
        </tr>
        <tr>
            <td><button type="submit">등록</button></td>
        </tr>
    </form>
</table>


<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "exp_content",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {fOnBeforeUnload : function(){}} // 이페이지 나오기 alert 삭제
    });
</script>
@endsection