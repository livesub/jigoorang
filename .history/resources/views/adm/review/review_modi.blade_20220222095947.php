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

            <form name="review_form" id="review_form" method="post" action="{{ route('adm.review.review_modi_save') }}" enctype='multipart/form-data'>
            {!! csrf_field() !!}
            <input type="hidden" name="num" value="{{ $num }}">
            <input type="hidden" name="page_move" value="{!! $page_move !!}">

                <div class="box_cont">
                    <div class="row">
                        <div class="col">아이디</div>
                        <div class="col">
                            {{ $review_save->user_id }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">이름</div>
                        <div class="col">
                            {{ $review_save->user_name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품명</div>
                        <div class="col">
                            {{ $item_name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">체험단명</div>
                        <div class="col">
                            {{ $title_ment }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가</div>
                        <div class="col">
                            <li>qqqqq<input type=text></li>
                            <li>qqqqq</li>
                            <li>qqqqq</li>
                            <li>qqqqq</li>
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
