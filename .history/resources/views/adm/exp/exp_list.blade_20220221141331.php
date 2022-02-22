@extends('layouts.admhead')

@section('content')

<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('/datepicker/dist/css/datepicker.min.css') }}">
<script src="{{ asset('/datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/datepicker/dist/js/i18n/datepicker.ko.js') }}"></script>
<!--
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .double div {
        float: left;
    }
</style>
-->
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
                <form method="get" id="exp_form">
                    <ul>
                        <li>모집시작일</li>
                        <li>
                            <input class="aln_left" type="text" name="exp_date_start" id="exp_date_start" value="{{ $exp_date_start }}">
                            <button type="button" class="btn-sm ddd-ln" onclick="resetBtn();">초기화</button>
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
                                else $item_manufacture = "[".$expAllList->item_manufacture."] ";
                                //제목
                                $item_name = $item_manufacture.stripslashes($expAllList->item_name);

                                $now_date = date("Y-m-d");
                                if($now_date <= $expAllList->exp_date_end){
                                    $ment = "진행";
                                }else{
                                    $ment = "종료";
                                }
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
                                <td>{{ number_format($expAllList->exp_limit_personnel) }}</td>
                                <td>{{ number_format($exp_app_cnt) }}</td>
                                <td>{{ $expAllList->exp_date_start }}~<br>{{ $expAllList->exp_date_end }}</td>
                                <td>{{ $expAllList->exp_review_start }}~<br>{{ $expAllList->exp_review_end }}</td>
                                <td>{{ $expAllList->exp_release_date }}</td>
                                <td>{{ $ment }}</td>
                                <td><button type="button" class="btn-sm-ln"  onclick="exp_modi({{ $expAllList->id }});">수정</button></td>
                                <td>
                                @if($exp_app_cnt == 0)
                                <!-- 신청자가 없을때 삭제 가능 -->
                                <button type="button" class="btn-sm-ln" onclick="exp_del({{ $expAllList->id }});">삭제</button>
                                @endif
                                </td>
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
                        {!! $pnPage !!}
                        </div>
                    </div>
                    <!-- 페이지네이션 끝 -->

                </div>
                <!-- 보드 끝 -->
        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
	function resetBtn(){
        location.href = "{{ route('adm_exp_index') }}";
	}
</script>

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
alert(num);
return false;
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