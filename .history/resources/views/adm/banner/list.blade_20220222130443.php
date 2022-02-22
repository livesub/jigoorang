@extends('layouts.admhead')

@section('content')






        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>메인 {{ $title_ment }} 배너 리스트</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='{{ route('adm.banner.create', $type) }}'">메인 {{ $title_ment }} 배너 등록</button>
                    <button type="button" class="gray" onclick="choice_del();">선택삭제</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cont">

            <form name="b_list_form" id="b_list_form" method="post" action="{{ route('adm.banner.choice_del') }}">
            {!! csrf_field() !!}
            <input type="hidden" name="type" id="type" value="{{ $type }}">
            <input type="hidden" name="num" id="num">
            <input type="hidden" name="page" id="page" value="{{ $page }}">

                <!-- 보드 시작 -->
                <div class="board">
                    <table class="ban">
                        <colgroup>
                            <col style="width: 40px;">
                            <col style="width: 60px;">
                            <col style="width: auto;">
                            <col style="width: 400px;">
                            <col style="width: 60px;">
                            <col style="width: 170px;">
                            <col style="width: 80px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="mg00" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"></th>
                                <th>번호</th>
                                <th>제목</th>
                                <th>경로</th>
                                <th>타겟</th>
                                <th>PC</th>
                                <th>모바일</th>
                                <th>출력</th>
                                <th>관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($banners as $banner)
                            @php
                                if($banner->b_display == "Y") $b_display_ment = "출력";
                                else $b_display_ment = "비출력";

                                if($banner->b_target == "Y") $b_target_ment = "새창";
                                else $b_target_ment = "현재창";

                                //이미지 처리
                                if($banner->b_pc_img == "") {
                                    $b_pc_img_disp = asset("img/no_img.jpg");
                                }else{
                                    $b_pc_img_cut = explode("@@",$banner->b_pc_img);
                                    $b_pc_img_disp = "/data/banner/".$b_pc_img_cut[2];
                                }

                                if($banner->b_mobile_img == "") {
                                    $b_mobile_img_disp = asset("img/no_img.jpg");
                                }else{
                                    $b_mobile_img_cut = explode("@@",$banner->b_mobile_img);
                                    $b_mobile_img_disp = "/data/banner/".$b_mobile_img_cut[2];
                                }
                            @endphp
                            <tr>
                                <td><input type="checkbox" class="mg00" name="chk_id[]" value="{{ $banner->id }}" id="chk_id_{{ $banner->id }}"></td>
                                <td>{{ $virtual_num-- }}</td>
                                <td class="title">
                                    <div>
                                        2022 완전 좋은 샴푸바 평가단 모집
                                    </div>
                                </td>
                                <td class="link">
                                    <div>https://www.naver.com</div>
                                </td>
                                <td>현재창</td>
                                <td class="bn_pc">
                                    <div><img src="../../img/img_mainvisual.png"></div>
                                </td>
                                <td class="bn_mo">
                                    <div><img src="../../img/img_mainvisual_m.png"></div>
                                </td>
                                <td>출력</td>
                                <td><button class="btn-sm-ln" type="button" onclick="location.href='../../page/contents/banner_top_rgst.html'">수정</button></td>
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
            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
    function all_checked(sw) {
        var f = document.b_list_form;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }
</script>

<script>
    function choice_del(){
        var chk_count = 0;
        var f = document.b_list_form;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("삭제할 배너를 하나 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 배너를 삭제 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>

<script>
    $("#b_list_form").attr("action", "{{ route('adm.banner.choice_del') }}");
    function b_modi(id, page){
        $("#num").val(id);
        $("#page").val(page);

        $("#b_list_form").attr("action", "{{ route('adm.banner.modify') }}");
        $("#b_list_form").submit();
    }

</script>



@endsection
