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
            <form>
                <h3 class="line">{{ $categorys_info->sca_name_kr }} {{ $title_ment }}분류 수정</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">분류코드</div>
                        <div class="col">1010</div>
                    </div>
                    <div class="row">
                        <div class="col">카테고리명</div>
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
                        <div class="col">출력순서</div>
                        <div class="col">
                            <p>*숫자만 입력하세요. 숫자가 낮을수록 먼저 출력 됩니다.</p>
                            <input type="number" name="" placeholder="">
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






























@endsection
