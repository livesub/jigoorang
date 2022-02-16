@extends('layouts.admhead')

@section('content')


    <!-- 컨테이너 시작 -->
    <div class="container">

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>대분류/소분류 관리</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='{{ route('shop.cate.create') }}'">대분류 등록<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cate">

            <!-- 가이드 문구 시작 -->
            <div class="box_guide">
                <h4>안내사항</h4>
                <p>-대분류/소분류로 등록 가능합니다.</p>
                <p>-카테고리 삭제는 하위 카테고리가 없거나 카테고리 내에 등록된 상품이 없는 경우에 삭제 가능합니다.</p>
                <p>-삭제하려는 카테고리에 상품 등록을 했을 경우는 상품의 카테고리를 변경 후 삭제가 가능합니다.(이미 삭제한 상품이 해당 카테고리에 속해 있는 경우 삭제 불가 합니다.)</p>
            </div>
            <!-- 가이드 문구 끝-->

            <!-- 보드 시작 -->
            <div class="board">
                <table>
                    <colgroup>
                        <col style="width: 80px;">
                        <col style="width: 100px;">
                        <col style="width: auto;">
                        <col style="width: 80px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 120px;">
                        <col style="width: 120px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>분류코드</th>
                            <th>카테고리명</th>
                            <th>이미지</th>
                            <th>뎁스</th>
                            <th>노출여부</th>
                            <th>대분류<br>출력순위</th>
                            <th>소분류<br>출력순위</th>
                            <th>랭킹출력</th>
                            <th colspan="3">관리</th>
                        </tr>
                    </thead>
                    <tbody>


                    @foreach($scate_infos as $scate_info)
                        @php
                            $blank = "";
                            $mark = "";
                            $level = strlen($scate_info->sca_id) / 2 - 1;

                            $x_sca_rank = "";
                            $s_sca_rank = "";
                            if($level == 0) {
                                $level_ment = "대분류";
                                $x_sca_rank = $scate_info->sca_rank;
                            }else{
                                $level_ment = "소분류";
                                $s_sca_rank = $scate_info->sca_rank;
                            }

                            for($i = 0; $i < $level; $i++){
                                $blank .= "&nbsp&nbsp";
                            }

                            if($level != 0){
                                $mark = "└";
                            }

                            if($scate_info->sca_display == "Y"){
                                $tr_bg = "";
                                $disp_ment = "노출";
                            }else{
                                $disp_ment = "비노출";
                                $tr_bg = " bgcolor='red' ";
                            }

                            //랭킹 츌력 여부
                            if($scate_info->sca_rank_dispaly == 'Y') $rank_checked = 'checked';
                            else $rank_checked = '';

                            if($scate_info->sca_img == "") $img = asset("img/no_img.jpg");
                            else{
                                $img_cut = explode("@@", $scate_info->sca_img);
                                $img = asset("/data/shopcate/".$img_cut[2]);
                            }
                        @endphp
                        <tr>
                            <td>{{ $virtual_num-- }}</td>
                            <td class="group">{{ $scate_info->sca_id }}</td>
                            <td class="cate_name">
                                <div>
                                    {!! $blank !!}{{ $mark }} {{ $scate_info->sca_name_kr }}
                                </div>
                            </td>
                            <td class="thumb"><img src="{{ $img }}"></td>
                            <td>{{ $level_ment }}</td>
                            <td>{{ $disp_ment }}</td>
                            <td>{{ $scate_info->sca_rank }}</td>
                            <td></td>
                            <td></td>
                            <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/category_rgst_sm.html'">추가</button></td>
                            <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/category_rgst.html'">수정</button></td>
                            <td></td>
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

    </div>
    <!-- 컨테이너 끝 -->







<table>
    <tr>
        <td><h4>쇼핑몰 분류 관리</h4></td>
    </tr>
    <tr>
        <td>※ 2단계까지 등록 하실수 있습니다.<br>※ 분류 삭제는 하위 카테고리가 없거나, 상품이 없어야 삭제 됩니다.<br>※ 상품과 하위 분류를 먼저 삭제해 주세요.</td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>번호</td>
        <td>분류 코드</td>
        <td>분류 한글명</td>
        <td>분류 영문명</td>
        <td>단계</td>
        <td>출력여부</td>
        <td>출력순위</td>
        <td>랭킹 출력</td>
        <td>추가/수정/삭제</td>
    </tr>

    @foreach($scate_infos as $scate_info)
        @php
            $blank = "";
            $mark = "";
            $level = strlen($scate_info->sca_id) / 2 - 1;
            for($i = 0; $i < $level; $i++){
                $blank .= "&nbsp&nbsp";
            }

            if($level != 0){
                $mark = "└";
            }

            if($scate_info->sca_display == "Y"){
                $tr_bg = "";
                $disp_ment = "출력";
            }
            else{
                $disp_ment = "<font color='red'>비출력</font>";
                $tr_bg = " bgcolor='red' ";
            }

            //랭킹 츌력 여부
            if($scate_info->sca_rank_dispaly == 'Y') $rank_checked = 'checked';
            else $rank_checked = '';
        @endphp

    <tr {{ $tr_bg }}>
        <td>{{ $virtual_num-- }}</td>
        <td>{{ $scate_info->sca_id }}</td>
        <td>{!! $blank !!}{{ $mark }}{{ $scate_info->sca_name_kr }}</td>
        <td>{{ $scate_info->sca_name_en }}</td>
        <td>{{ $level+1 }}단계</td>
        <td>{!! $disp_ment !!}</td>
        <td>{{ $scate_info->sca_rank }}</td>
        <td>
            @if($level+1 == 2)   <!-- 2단계에서만 랭킹 등록 -->
            <input type="checkbox" name="sca_rank_dispaly{{ $scate_info->id }}" id="sca_rank_dispaly{{ $scate_info->id }}" onclick="rank_type('{{ $scate_info->id }}')" {{ $rank_checked }}>
            @endif
        </td>
        <td>
            @if($level+2 < 3)   <!-- 2단계까지 저장 -->
            <button type="button" onclick="cate_type('{{ $scate_info->sca_id }}','add');">추가</button>
            @endif

            <button type="button" onclick="cate_type('{{ $scate_info->sca_id }}','modi');">수정</button>
            @php
                $de_scate_info = DB::table('shopcategorys')->where('sca_id','like',$scate_info->sca_id.'%')->count();   //하위 카테고리 갯수
                $de_item_info = DB::table('shopitems')->where('sca_id','like',$scate_info->sca_id.'%')->count();   //상품 갯수
            @endphp

            @if($de_scate_info == 1 && $de_item_info == 0)
                <button type="button" onclick="cate_del('{{ $scate_info->id }}','{{ $scate_info->sca_id }}');">삭제</button>
        </td>
            @endif
    </tr>
    @endforeach
</table>


<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('shop.cate.create') }}'">1단계 카테고리 등록</button></td>
    </tr>
</table>



<table>
    <tr>
        <td>
           {!! $pnPage !!}
        </td>
    </tr>
</table>


<form name="cate_form" id="cate_form" method="get" action="">
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="sca_id" id="sca_id">
    <input type="hidden" name="page" id="page" value="{{ $page }}">
</form>

<script>
    function cate_type(sca_id, type){
        $("#sca_id").val(sca_id);
        if(type == "add"){
            $("#cate_form").attr("action", "{{ route('shop.cate.cate_add') }}");
        }else if(type == "modi"){
            $("#cate_form").attr("action", "{{ route('shop.cate.cate_modi') }}");
        }

        $("#cate_form").submit();
    }
</script>

<script>
    function cate_del(id,sca_id){
        $("#id").val(id);
        $("#sca_id").val(sca_id);

        if (confirm("상품이 있을 경우 상품 부터 삭제 하세요.\n정말 삭제하시겠습니까?") == true){
            $("#cate_form").attr("action", "{{ route('shop.cate.cate_delete') }}");
            $("#cate_form").submit();
        }else{
            return false;
        }
    }
</script>

<script>
    function rank_type(id){
        var sca_rank_dispaly = '';
        if($('#sca_rank_dispaly'+id).is(':checked') === true)
        {
            sca_rank_dispaly = 'Y';
        }else{
            sca_rank_dispaly = 'N';
        }

        $.ajax({
            type : 'get',
            url : '{{ route('shop.cate.ajax_rank_choice') }}',
            data : {
                'id'                : id,
                'sca_rank_dispaly'  : sca_rank_dispaly,
            },
            dataType : 'text',
            success : function(result){
//alert(result);
            },
            error: function(result){
                console.log(result);
            },
        });

    }
</script>





@endsection
