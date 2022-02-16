@extends('layouts.admhead')

@section('content')


        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>회원 포인트 정보</h2>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area member">

            <form name="pointform" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="num" value="{{ $num }}">
                <div class="box_cont">
                    <div class="row">
                        <div class="col">아이디(이메일)</div>
                        <div class="col">
                            {{ $members->user_id }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">이름</div>
                        <div class="col">
                            {{ $members->user_name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">보유 포인트</div>
                        <div class="col">
                            {{ $members->user_point }}P
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">포인트 지급</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" id="give_point_chk1" name="give_point_chk" value="1" checked="checked" > 지급
                                </label>
                                <label>
                                    <input type="radio" id="give_point_chk2" name="give_point_chk" value="2"> 회수
                                </label>
                                <div>
                                    <input class="mr05" type="number" name="give_point" id="give_point" placeholder=""> P
                                    <button type="button" class="btn blk-ln ht34" onclick="give_point_submit();">확인</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 포인트 내역 시작 -->
                    <div class="tap_menu mt50">
                        <div class="tap_head">
                            <button type="button" class="acc" onclick="location.href='../../page/member/point_save.html'">포인트 누적</button>
                            <button type="button" onclick="location.href='../../page/member/point_spend.html'">포인트 사용</button>
                        </div>
                        <div class="tap_body">

                            @foreach($shoppoint_rows as $shoppoint_row)
                                @php
                                    if($shoppoint_row->po_point < 0){
                                        $disp_class = "acc";
                                    }else{
                                        $point_type = "+";
                                        $disp_class = "";
                                    }
                                @endphp
                            <div class="list">
                                <div class="p_history">
                                    {{ $shoppoint_row->po_content }}
                                    <span class="{{ $disp_class }}">{{ $point_type }}{{ number_format($shoppoint_row->po_point) }}P</span>
                                </div>
                                {{ substr($shoppoint_row->created_at, 0, 10) }}
                            </div>
                            @endforeach

                        </div>
                    </div>
                    <!-- 포인트 내역 끝 -->

                    <!-- 페이지네이션 시작 -->
                    <div class="paging_box">
                        <div class="paging">
                            <a class="wide">처음</a>
                            <a class="wide">이전</a>
                            <a class="on">1</a>
                            <a>2</a>
                            <a>3</a>
                            <a>4</a>
                            <a>5</a>
                            <a>6</a>
                            <a>7</a>
                            <a>8</a>
                            <a>9</a>
                            <a>10</a>
                            <a class="wide">다음</a>
                            <a class="wide">마지막</a>
                        </div>
                    </div>
                    <!-- 페이지네이션 끝 -->
                </div>

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->


<script>
    function give_point_submit(){
        var chk = $(':radio[name="give_point_chk"]:checked').val();

        if(chk == 1) var ment = "지급";
        else if(chk == 2) var ment = "회수";

        if($.trim($("#give_point").val()) == "" || $.trim($("#give_point").val()) == "0"){
            alert(ment + " 할 포인트를 입력하세요");
            $("#give_point").focus();
            return false;
        }

        if (confirm("포인트를 "+ ment +" 하시겠습니까?") == true){    //확인
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('adm.member.ajax_member_point_save') }}',
                data : {
                    'num'   : {{ $num }},
                    'give_point'    : $.trim($("#give_point").val()),
                    'give_point_chk': chk,
                },
                dataType : 'text',
                success : function(result){
    //alert(result);
    //return false;
                    if(result == "ok"){
                        alert(ment + " 처리 되었습니다");
                        location.reload();
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }else{
            return false;
        }
    }
</script>




@endsection
