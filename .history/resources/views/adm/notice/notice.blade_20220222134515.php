@extends('layouts.admhead')

@section('content')



        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>지구록 관리</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='{{ route('adm.notice_write') }}'">글작성</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cont">

            <form>
                <!-- 보드 시작 -->
                <div class="board">
                    <table class="jgr_table">
                        <colgroup>
                            <col style="width: 60px;">
                            <col style="width: 100px;">
                            <col style="width: 280px;">
                            <col style="width: auto;">
                            <col style="width: 90px;">
                            <col style="width: 90px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>이미지</th>
                                <th>제목</th>
                                <th>설명글</th>
                                <th colspan="2">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($notices as $notice)
                        @php
                            $n_img = "";
                            $n_img_cut = explode("@@", $notice->n_img);
                            if($n_img_cut[2] == ""){
                                $n_img = asset("img/no_img.jpg");
                            }else{
                                $n_img = asset('/data/notice/'.$n_img_cut[2]);
                            }
                        @endphp
                            <tr>
                                <td>{{ $virtual_num-- }}</td>
                                <td class="thumb">
                                    <img src="{{ $n_img }}">
                                </td>
                                <td class="title">
                                    <div>
                                        {{ stripslashes($notice->n_subject) }}
                                    </div>
                                </td>
                                <td class="usertxt">
                                    {{ stripslashes($notice->n_explain) }}
                                </td>
                                <td>
                                    <button type="button" class="btn-sm-ln" onclick="noti_modi('{{ $notice->id }}')">수정</button>
                                </td>
                                <td>
                                    <button type="button" class="btn-sm-ln" onclick="noti_del('{{ $notice->id }}')">삭제</button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <!-- 페이지네이션 시작 -->
                    <div class="paging_box">
                        <div class="paging">
                            {!! $pnPage !!}
                        </div>
                    </div>
                    <!-- 페이지네이션 끝 -->
                </div>
                <!-- 보드 끝 -->
            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->



<form name="noti_form" id="noti_form" action="{{ route('adm.notice_modify') }}" method="POST">
{!! csrf_field() !!}
    <input type="hidden" name="num" id="num" value="">
    <input type="hidden" name="page" id="page" value="{{ $page }}">
</form>

<script>
    function noti_modi(num){
        $("#num").val(num);
        $("#noti_form").submit();
    }

    function noti_del(num){
        if (confirm("선택된 게시글을 삭제합니다.") == true){
            $("#num").val(num);
            $("#noti_form").attr("action", "{{ route('adm.notice_write_del') }}");
            $("#noti_form").submit();
        }else{
            return false;
        }
    }
</script>


@endsection

