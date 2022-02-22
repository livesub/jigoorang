@extends('layouts.admhead')

@section('content')



        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>메인 {{ $title_ment }} 배너 수정</h2>
                <div class="button_box">
                    <button type="button" onclick="b_save();">수정</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cont">

            <form name="b_form" id="b_form" method="post" action="{{ route('adm.banner.modifysave') }}" enctype='multipart/form-data'>
                {!! csrf_field() !!}
                <input type="hidden" name="type" id="type" value="{{ $type }}">
                <input type="hidden" name="page" id="page" value="{{ $page }}">
                <input type="hidden" name="num" id="num" value="{{ $banner_info->id }}">

                <div class="box_cont">
                    <div class="row">
                        <div class="col">제목</div>
                        <div class="col">
                            <input type="text" name="b_name" id="b_name" value="{{ stripslashes($banner_info->b_name) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">출력여부</div>
                        <div class="col">
                            <div class="prt">
                            @php
                                if($banner_info->b_display == 'Y')
                                {
                                    $b_display_yes_chk = 'checked';
                                    $b_display_no_chk = '';
                                }else{
                                    $b_display_yes_chk = '';
                                    $b_display_no_chk = 'checked';
                                }
                            @endphp
                                <label>
                                    <input type="radio" name="b_display" id="b_display_yes" value="Y" {{ $b_display_yes_chk }}>출력
                                </label>
                                <label>
                                    <input type="radio" name="b_display" id="b_display_no" value="N" {{ $b_display_no_chk }}> 미출력
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">배너경로</div>
                        <div class="col">
                            <div class="input_link">
                                <input type="text" name="b_link" id="b_link" value="{{ stripslashes($banner_info->b_link) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">타겟</div>
                        <div class="col">
                            <div class="prt">
                            @php
                                if($banner_info->b_target == 'N'){
                                    $b_target_no_chk = "checked";
                                    $b_target_yes_chk = "";
                                }else{
                                    $b_target_no_chk = "";
                                    $b_target_yes_chk = "checked";
                                }
                            @endphp
                                <label>
                                    <input type="radio" name="b_target" id="b_target_no" value="N" {{ $b_target_no_chk }}> 현재창
                                </label>
                                <label>
                                    <input type="radio" name="b_target" id="b_target_yes" value="Y" {{ $b_target_yes_chk }}> 새창
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">PC 이미지</div>
                        <div class="col">
                            <div class="file_att">
                                <p class="t_mint">이미지 사이즈 1920*550</p>
                                <div class="btn_file">
                                    <label>
                                        파일첨부
                                        <input type="file" name="b_pc_img" id="b_pc_img" accept="image/*" onchange="file_name('b_pc_img')">
                                    </label>
                                    <span id="b_pc_img_name"></span>
                                    <p>{{ $banner_info->b_pc_ori_img }}</p>
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
                        <div class="col">모바일 이미지</div>
                        <div class="col">
                            <div class="file_att">
                                <p class="t_mint">이미지 사이즈 360*420(720*840)</p>
                                <div class="btn_file">
                                    <label>
                                        파일첨부
                                        <input type="file" name="b_mobile_img" id="b_mobile_img" accept="image/*" onchange="file_name('b_mobile_img')">
                                    </label>
                                    <span id="b_mobile_img_name"></span>
                                    <p>{{ $banner_info->b_mobile_ori_img }}</p>
                                </div>
                                <div class="file">
                                    <label>
                                        <input type="checkbox" id="">수정, 삭제, 새로등록시 체크
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
    function b_save(){
        if($.trim($("#b_name").val()) == ""){
            alert("제목을 입력 하세요.");
            $("#b_name").focus();
            return false;
        }

        if($("#b_pc_img").val() == ""){
            alert("pc 이미지를 등록 하세요.");
            $("#b_pc_img").focus();
            return false;
        }

        if($("#b_mobile_img").val() == ""){
            alert("mobile 이미지를 등록 하세요.");
            $("#b_mobile_img").focus();
            return false;
        }

        $("#b_form").submit();
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
