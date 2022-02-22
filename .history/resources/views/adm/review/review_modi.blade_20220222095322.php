@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>리뷰 수정</h2>
                <div class="button_box">
                    <button type="button" onclick="review_modi_save()">수정<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area review">

            <form>

                <div class="box_cont">
                    <div class="row">
                        <div class="col">카테고리 선택</div>
                        <div class="col">
                            <div class="cate_sel">
                                <select>
                                    <option>욕실</option>
                                </select>
                                <select>
                                    <option>선택하세요</option>
                                    <option>└ 치약</option>
                                    <option>└ 샴푸바</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목1</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" name="" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목2</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" name="" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목3</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" name="" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목4</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" name="" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목5</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" name="" placeholder="">
                        </div>
                    </div>
                </div>

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
    function review_modi_save(){
        if (confirm("리뷰를 수정 하시겠습니까?") == true){    //확인
            $("#review_form").submit();
        }else{   //취소
            return false;
        }
    }
</script>


@endsection
