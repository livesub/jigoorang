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
                            {{ stripslashes($qna_info->qna_subject) }}
                        </div>
                        <ul class="user">
                            <li>{{ $qna_info->created_at }}</li>
                            <li>{{ $qna_info->user_name }}</li>
                            <li>{{ $qna_info->user_id }}</li>
                            <li>{{ $user_info->user_phone }}</li>
                        </ul>
                    </div>
                    <div class="contents">
                        @if($qna_info->order_id != 0)
                        <div class="ord_num">
                            <div>주문번호</div>
                            <div><a href="{{ route('orderdetail','order_id='.$qna_info->order_id) }}">{{ $qna_info->order_id }}</a></div>
                        </div>
                        @endif
                        <div class="user_txt">
                            {{ htmlspecialchars(nl2br($qna_info->qna_content)) }}
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
