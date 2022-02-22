@extends('layouts.admhead')

@section('content')


        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>팝업 관리</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='{{ route('adm.pop.create') }}'">팝업등록</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cont">


                <!-- 보드 시작 -->
                <div class="board">
                    <table class="pop_table2">
                        <colgroup>
                            <col style="width: 60px;">
                            <col style="width: 60px;">
                            <col style="width: auto;">
                            <col style="width: 290px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 160px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>이미지</th>
                                <th>제목</th>
                                <th>경로</th>
                                <th>타겟</th>
                                <th>출력여부</th>
                                <th>등록일</th>
                                <th colspan="2">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pop_infos as $pop_info)
                            @php
                                if($pop_info->pop_display == "Y") $pop_display = "출력";
                                else $pop_display = "비출력";

                                //이미지 구하기
                                $pop_img = explode("@@", $pop_info->pop_img);

                                //타겟
                                if($pop_info->pop_target == "Y") $target_ment = "새창";
                                else $target_ment = "현재";
                            @endphp
                            <tr>
                                <td>10</td>
                                <td class="thumb">
                                    <img src="../../img/img_prod_01.png">
                                </td>
                                <td class="title">
                                    <div>
                                        친환경 메이커 지구랭을 소개합니다
                                    </div>
                                </td>
                                <td class="link">
                                    <div>
                                        https://www.naver.com
                                    </div>
                                </td>
                                <td>현재창</td>
                                <td>출력</td>
                                <td>2022-01-01 13:13:13</td>
                                <td>
                                    <button type="button" class="btn-sm-ln" onclick="location.href='../../page/contents/pop_rgst.html'">수정</button>
                                </td>
                                <td>
                                    <button type="button" class="btn-sm-ln" onclick="">삭제</button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

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
                <!-- 보드 끝 -->
        </div>
        <!-- 컨텐츠 영역 끝 -->

<form name="pop_form" id="pop_form" action="{{ route('adm.pop.modify') }}" method="POST">
{!! csrf_field() !!}
    <input type="hidden" name="num" id="num" value="">
    <input type="hidden" name="page" id="page" value="{{ $page }}">
</form>

<script>
    function pop_modi(num){
        $("#num").val(num);
        $("#pop_form").submit();
    }

    function pop_del(num){
        if (confirm("팝업을 삭제하시겠습니까?") == true){
            $("#num").val(num);
            $("#pop_form").attr("action", "{{ route('adm.pop.destroy') }}");
            $("#pop_form").submit();
        }else{
            return false;
        }
    }
</script>



@endsection
