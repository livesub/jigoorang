@extends('layouts.admhead')

@section('content')
<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smarteditor2 사용 -->
체험단 신청 뷰입니다.
<table border=1 width="900px;">
    <form method="post" action="{{ route('adm_exp_view_save') }}" enctype='multipart/form-data' onsubmit="return check_submit()">
        {!! csrf_field() !!}
        <tr>
            <td>제목</td>
            <td>
                <input type="text" id="exp_title" name="exp_title" value="{{ old('exp_title') }}">
                @error('exp_title')
                    <span class='invalid-feedback' role='alert'>
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </td>

        </tr>
        <tr>
            <td>상품 설정</td>
            <td>
                <button type="button" onclick="open_pop()">상품 검색</button>
                <h5>선택하신 상품명 : <span id="exp_item_show_name"></span></h5>
                <input type="hidden" id="exp_item_code" name="exp_item_code" value="{{ old('exp_item_code') }}">
                <input type="hidden" id="exp_item_name" name="exp_item_name" value="{{ old('exp_item_name') }}">
                @error('exp_item_code')
                <span class='invalid-feedback' role='alert'>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </td>
        </tr>
        <tr>
            <td>체험단 인원</td>
            <td><input type="text" id="exp_limit_personnel" name="exp_limit_personnel" value="{{ old('exp_limit_personnel') }}" min="0" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"></td>
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
            <td>
                <input type="file" id="exp_main_image" name="exp_main_image">
                @error('exp_main_image')
                    <strong><p>{{ $message }}</p></strong>
                @enderror
            </td>
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
@endsection