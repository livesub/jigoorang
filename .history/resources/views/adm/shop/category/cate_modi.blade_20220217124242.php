@extends('layouts.admhead')

@section('content')



        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>{{ $title_ment }}분류 수정</h2>
                <div class="button_box">
                    <button type="button" onclick="add_cate();">수정</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cate">
            <form name="cate_modi_form" id="cate_modi_form" method="post" action="{{ route('shop.cate.cate_modi_save') }}" enctype='multipart/form-data'>
            {!! csrf_field() !!}
            <input type="hidden" name="id" id="id" value="{{ $categorys_info->id }}">
            <input type="hidden" name="sca_id" id="sca_id" value="{{ $categorys_info->sca_id }}">
            <input type="hidden" name="page" id="page" value="{{ $page }}">

                <h3 class="line">{{ $categorys_info->sca_name_kr }} {{ $title_ment }}분류 수정</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">분류코드</div>
                        <div class="col">{{ $categorys_info->sca_id }}</div>
                    </div>
                    <div class="row">
                        <div class="col">카테고리명</div>
                        <div class="col">
                            <input type="text" name="sca_name_kr" id="sca_name_kr" value="{{ stripslashes($categorys_info->sca_name_kr) }}" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                    @php
                        $disp_yes = "";
                        $disp_no = "";
                        if($categorys_info->sca_display == "Y"){
                            $disp_yes = "checked";
                            $disp_no = "";
                        }else{
                            $disp_yes = "";
                            $disp_no = "checked";
                        }
                    @endphp
                        <div class="col">출력여부</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" name="sca_display" id="sca_display_yes" value="Y" {{ $disp_yes }}> 출력
                                </label>
                                <label>
                                    <input type="radio" name="sca_display" id="sca_display_no" value="N" {{ $disp_no }}> 미출력
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">출력순서</div>
                        <div class="col">
                            <p>*숫자만 입력하세요. 숫자가 낮을수록 먼저 출력 됩니다.</p>
                            <input type="text" name="sca_rank" id="sca_rank" maxlength="3" size="3" value="{{ $categorys_info->sca_rank }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">카테고리 이미지</div>
                        <div class="col">
                            <div class="file_att">
                                <p class="t_mint">이미지 사이즈 230*230(460*460)</p>
                                <div class="btn_file">
                                    <label>
                                        파일선택
                                        <input type="file" name="sca_img" id="sca_img" accept="image/*" onchange="file_name('sca_img')">
                                    </label>
                                    <span id="sca_img_name"></span>
                                    <p><a href="javascript:file_down('{{ $categorys_info->id }}');">{{ $categorys_info->sca_img_ori_file_name }}</a></p>
                                    <!-- 선택된 파일이 없습니다. -->
                                </div>
                                <div class="file">
                                    <label>
                                        <input type="checkbox" name="file_chk" id="file_chk" value='1'>수정, 삭제, 새로등록시 체크
                                    </label>
                                </div>
                           </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
    function add_cate(){
        if($.trim($("#sca_name_kr").val()) == ""){
            alert("카테고리명을 입력 하세요.");
            $("#sca_name_kr").focus();
            return false;
        }

        $("#cate_modi_form").submit();
    }
</script>

<script>
    function file_down(id)
    {
        $("#id").val(id);
        $("#cate_modi_form").attr("action", "{{ route('shop.cate.scate_downloadfile') }}");
        $("#cate_modi_form").submit();
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
