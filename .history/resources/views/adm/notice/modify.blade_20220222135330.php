@extends('layouts.admhead')

@section('content')



<!-- smarteditor2 사용 -->
<script type="text/javascript" src="{{ asset('/smarteditor2/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
<!-- smarteditor2 사용 -->

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>지구록 수정</h2>
                <div class="button_box">
                    <button type="button" onclick="submitContents();">수정<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cont">

            <form name="n_create_form" id="n_create_form" method="post" action="{{ route('adm.notice_modify_save') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="num" id="num" value="{{ $notice_info->id }}">
                <input type="hidden" name="page" id="page" value="{{ $page }}">

                <div class="box_cont">

                    <div class="row">
                        <div class="col">제목(필수)</div>
                        <div class="col">
                            <p>50자 이내로 입력하세요</p>
                            <input class="wd800" type="text" name="n_subject" id="n_subject" value="{{ stripslashes($notice_info->n_subject) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">설명글</div>
                        <div class="col">
                            <p>80자 이내로 입력하세요</p>
                            <input class="wd800" type="text" name="n_explain" id="n_explain" value="{{ stripslashes($notice_info->n_explain) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">목록 이미지</div>
                        <div class="col">
                            <div class="file_att">
                                <p class="t_mint">이미지 사이즈 360*180(720*360)</p>
                                <div class="btn_file">
                                    <label>
                                        파일첨부
                                        <input type="file" name="n_img" id="n_img" accept="image/*" onchange="file_name('n_img')">
                                    </label>
                                    <span id="n_img_name"></span>
                                    <p>{{ $notice_info->n_img_name }}</p>
                                </div>

                                <div class="file">
                                    <label>
                                        <input type="checkbox" name="file_chk1" id="file_chk1" value='1'>수정, 삭제, 새로등록시 체크
                                    </label>
                                </div>

                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상세 내용(필수)</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="n_content" id="n_content" style="width:100%">{{ $notice_info->n_content }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->




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
/*
        if($("#n_img").val() == ""){
            alert("목록 이미지를 등록해 주세요");
            $("#n_img").focus();
            return false;
        }
*/
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

