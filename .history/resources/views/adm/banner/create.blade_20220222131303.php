@extends('layouts.admhead')

@section('content')



        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>메인 {{ $title_ment }} 배너 등록</h2>
                <div class="button_box">
                    <button type="button" onclick="b_save();">등록</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cont">

            <form>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">제목</div>
                        <div class="col">
                            <input type="text" name="" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">출력여부</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" id="" name="print" checked="checked" > 출력
                                </label>
                                <label>
                                    <input type="radio" id="" name="print" > 미출력
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">배너경로</div>
                        <div class="col">
                            <div class="input_link">
                                <input type="text" name="" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">타겟</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" id="" name="target" checked="checked" > 현재창
                                </label>
                                <label>
                                    <input type="radio" id="" name="target" > 새창
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
                                        <input type="file" id="" accept="image/*">
                                    </label>
                                    asdfasdf.png
                                    <!-- 선택된 파일이 없습니다. -->
                                </div>
                                <div class="file">
                                    <label>
                                        <input type="checkbox" id="">수정, 삭제, 새로등록시 체크
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
                                        <input type="file" id="" accept="image/*">
                                    </label>
                                    asdfasdf.png
                                    <!-- 선택된 파일이 없습니다. -->
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




@endsection
