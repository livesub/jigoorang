@extends('layouts.admhead')

@section('content')

<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('/datepicker/dist/css/datepicker.min.css') }}">
<script src="{{ asset('/datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/datepicker/dist/js/i18n/datepicker.ko.js') }}"></script>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .double div {
        float: left;
    }
</style>
<!-- datepicker -->


        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>평가단 리스트</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='{{ route('adm_exp_view_create') }}'">평가단 등록</button>
<!--
                    <button type="button" class="gray" onclick="location.href='#'">선택 삭제</button>
-->
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area expr">
            <!-- 검색창 시작 -->
                <div class="box_search">
                <form method="get">
                    <ul>
                        <li>모집시작일</li>
                        <li>
                            <input class="aln_left" type="text" name="exp_date_start" id="exp_date_start" value="{{ $exp_date_start }}">
                            <button type="button" class="btn-sm ddd-ln" onclick="">초기화</button>
                        </li>
                        <li>분류</li>
                        <li>
                        @php
                            $search_selectboxs = DB::table('shopcategorys')->where('sca_display', 'Y')->orderby('sca_id','ASC')->orderby('sca_rank','ASC')->get();
                        @endphp
                            <select name="ca_id" id="ca_id">
                                <option value="">전체</option>
                                @foreach($search_selectboxs as $search_selectbox)
                                    @php
                                        $len = strlen($search_selectbox->sca_id) / 2 - 1;
                                        $nbsp = '';
                                        for ($i=0; $i<$len; $i++) $nbsp .= '└ ';
                                        if($search_selectbox->sca_id === $ca_id) $cate_selected = "selected";
                                        else $cate_selected = "";
                                    @endphp
                                    <option value="{{ $search_selectbox->sca_id }}" {{ $cate_selected }}>{!! $nbsp !!}{{ $search_selectbox->sca_name_kr }}</option>
                                @endforeach
                            </select>
                            <input class="wd250" type="text" name="keyword" id="keyword" value="{{ $keyword }}">
                        </li>
                    </ul>
                    <button type="submit">검색</button>
                </form>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">
                    <table>
                        <colgroup>
<!--
                            <col style="width: 40px;">
-->
                            <col style="width: 50px;">
                            <col style="width: 100px;">
                            <col style="width: auto;">
                            <col style="width: 150px;">
                            <col style="width: 195px;">
                            <col style="width: 50px;">
                            <col style="width: 50px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 50px;">
                            <col style="width: 90px;">
                            <col style="width: 90px;">
                        </colgroup>
                        <thead>
                            <tr>
<!--
                                <th><input type="checkbox" class="mg00" id=""></th>
-->
                                <th>번호</th>
                                <th>이미지</th>
                                <th>제목</th>
                                <th>분류</th>
                                <th>상품</th>
                                <th>모집</th>
                                <th>신청</th>
                                <th>모집기간</th>
                                <th>평가가능기간</th>
                                <th>발표일</th>
                                <th>진행</th>
                                <th colspan="2">관리</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach($expAllLists as $expAllList)
                            @php
                            //이미지 처리
                            if($expAllList->main_image_name == "") {
                                $main_image_name_disp = asset("img/no_img.jpg");
                            }else{
                                $main_image_name_cut = explode("@@",$expAllList->main_image_name);
                                $main_image_name_disp = "/data/exp_list/".$main_image_name_cut[2];
                            }

                            $exp_app_cnt = DB::table('exp_application_list')->where('exp_id', $expAllList->id)->count();

                            $cut_hap = "";
                            $ca_name_hap = "";
                            for($i = 0; $i < 10; $i += 2)
                            {
                                $sign = "";
                                $ca_id_len = strlen($expAllList->sca_id) - 2;
                                $tmp_cut = substr($expAllList->sca_id, $i, 2);
                                if($tmp_cut != ""){
                                    $cut_hap = $cut_hap.$tmp_cut;
                                    $item_ca_name = DB::table('shopcategorys')->select('sca_name_kr')->where('sca_id',$cut_hap)->first();

                                    if($ca_id_len > $i){
                                        $sign = " > ";
                                    }

                                    if($item_ca_name->sca_name_kr != ""){
                                        $ca_name_hap .= $item_ca_name->sca_name_kr.$sign;
                                    }
                                }
                            }

                            $image = $CustomUtils->get_item_image($expAllList->item_code, 3);
                            if($image == "") $image = asset("img/no_img.jpg");

                            if($expAllList->item_manufacture == "") $item_manufacture = "";
                            else $item_manufacture = "[".$expAllList->->item_manufacture."] ";
                            //제목
                            $item_name = $item_manufacture.stripslashes($item_info->item_name);
                            @endphp
                            <tr>
<!--
                                <td><input type="checkbox" class="mg00" id=""></td>
-->
                                <td>{{ $virtual_num }}</td>
                                <td class="thumb"><img src="{{ $main_image_name_disp }}"></td>
                                <td class="title">
                                    {{ stripslashes($expAllList->title) }}
                                </td>
                                <td class="cate_name">
                                    <div>{{ $ca_name_hap }}
                                    </div>
                                </td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="{{ $image }}">
                                        </div>
                                        <div>
                                            {{ $item_name }}
                                        </div>
                                    </div>
                                </td>
                                <td>500</td>
                                <td>1,500</td>
                                <td>2021-11-01~<br>2021-11-31</td>
                                <td>2021-12-01~<br>2021-12-31</td>
                                <td>2022-01-01</td>
                                <td>진행</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/experience/experience_rgst.html'">수정</button></td>
                                <td><button type="button" class="btn-sm-ln" onclick="">삭제</button></td>
                            </tr>
                            @php
                                $virtual_num--;
                            @endphp
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

<script>
   $(function() {
       //input을 datepicker로 선언
       $("#exp_date_start").datepicker({
           language: 'ko',
           autoClose: true,
       });
   });
</script>


<script>
    function exp_modi(num){
        var url = "{{ route('adm_exp_view_restore', ':num') }}";
        url = url.replace(':num', num);
        location.href = url;
    }

    function exp_del(num){
        if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            var url = "{{ route('adm_exp_view_delete', ':num') }}";
            url = url.replace(':num', num);
            location.href = url;
        }else{   //취소
            return false;
        }
    }
</script>


@endsection