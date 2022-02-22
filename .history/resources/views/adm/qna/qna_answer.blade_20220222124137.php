@extends('layouts.admhead')

@section('content')




        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>1:1 문의 상세</h2>
                <div class="button_box">
                    <button type="button" onclick="qna_answer_submit();">등록<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area qna">

            <form name="qna_answer_form" id="qna_answer_form" action="{{ route('adm.qna_answer_save') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="id" id="id" value="{{ $qna_info->id }}">
            <input type="hidden" name="page" id="page" value="{{ $page }}">
            <input type="hidden" name="keyword" id="keyword" value="{{ $keyword }}">

                <!-- 문의 내역 시작 -->
                <div class="qna_view">
                    <div class="top_title">
                        <ul class="dvs">
                            <li>{{ $qna_info->qna_cate }}<span></span></li>
                            @if($qna_info->qna_answer != null)
                            <li class="t_mint">답변완료</li>
                            @else
                            <li class="t_mint acc">답변대기</li>
                            @endif
                        </ul>
                        <div class="title">
                            배송이 시작된지 3일 지났는데 언제 옵니까?
                        </div>
                        <ul class="user">
                            <li>2021-12-12 12:12:13</li>
                            <li>지구룡</li>
                            <li>ji9ryong@gmail.com</li>
                            <li>01054549898</li>
                        </ul>
                    </div>
                    <div class="contents">
                        <div class="ord_num">
                            <div>주문번호</div>
                            <div><a href="../../page/order/order_detail.html">202112311854162154</a></div>
                        </div>
                        <div class="user_txt">
                            배송이 시작된지 3일이나 지났어요? 언제 오나요?<br>
                            오다가 UFO한테 납치당했나요?<br>
                            답변부탁합니다.
                        </div>
                    </div>
                    <div class="write_asw">
                        <h4>답변쓰기</h4>
                        <div class="memo">
                            <textarea></textarea>
                        </div>
                        <div class="date">
                            2021-12-12 15:31:12
                        </div>
                    </div>
                </div>
                <!-- 문의 내역 끝 -->

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->


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
