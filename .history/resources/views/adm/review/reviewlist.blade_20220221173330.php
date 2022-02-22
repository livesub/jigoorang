@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>리뷰 관리</h2>
                <div class="button_box">
<!--
                    <button type="button" onclick="">노출/블라인드</button>
-->
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area review">

            <!-- 가이드 문구 시작 -->
            <div class="box_guide">
            @php
                $tot_review_cnt = DB::table('review_saves')->where('temporary_yn', 'n')->count(); //체험단명 찾기
                $tot_review_blind_cnt = DB::table('review_saves')->where('review_blind', 'Y')->count(); //체험단명 찾기
            @endphp
                <ul>
                    <li>총리뷰 : {{ number_format($tot_review_cnt) }}건</li>
                    <li>블라인드 : <b>{{ number_format($tot_review_blind_cnt) }}</b>건</li>
                </ul>
            </div>
            <!-- 가이드 문구 끝-->

                <!-- 검색창 시작 -->
                <div class="box_search">
                <form name="search_form" id="search_form" method="get" action="">
                    <ul>
                        <li>상품 선택</li>
                        <li>
                        @php
                            $search_selectboxs = DB::table('shopcategorys')->where('sca_display', 'Y')->orderby('sca_id','ASC')->orderby('sca_rank','ASC')->get();
                        @endphp
                            <select name="ca_id" id="ca_id" onchange="select_item(this.value)">
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

                            <select name="item_code" id="s_cate" style="display:none;">
                            </select>
                        </li>
                        <li>형태</li>
                        <li>
                        @php
                            $radio_checked1 = "";
                            $radio_checked2 = "";
                            $radio_checked3 = "";

                            if($review_type == "all" || $review_type == "") $radio_checked1 = "checked";
                            else if($review_type == "shop") $radio_checked2 = "checked";
                            else if($review_type == "exp") $radio_checked3 = "checked";
                        @endphp
                            <label>
                                <input type="radio" id="review_type1" name="review_type" value="all" {{ $radio_checked1 }}>전체
                            </label>
                            <label>
                                <input type="radio" id="review_type2" name="review_type" value="shop" {{ $radio_checked2 }}>구매 리뷰
                            </label>
                            <label>
                                <input type="radio" id="review_type3" name="review_type" value="exp" {{ $radio_checked3 }}>체험단 리뷰
                            </label>
                        </li>
                        <li>노출여부</li>
                        @php
                            $b_radio_checked1 = "";
                            $b_radio_checked2 = "";
                            $b_radio_checked3 = "";

                            if($review_blind == "all" || $review_blind == "") $b_radio_checked1 = "checked";
                            else if($review_blind == "N") $b_radio_checked2 = "checked";
                            else if($review_blind == "Y") $b_radio_checked3 = "checked";
                        @endphp
                        <li>
                            <label>
                                <input type="radio" id="review_blind1" name="review_blind" value="all" {{ $b_radio_checked1 }}>전체
                            </label>
                            <label>
                                <input type="radio" id="review_blind2" name="review_blind" value="N" {{ $b_radio_checked2 }}>노출 리뷰
                            </label>
                            <label>
                                <input type="radio" id="review_blind2" name="review_blind" value="Y" {{ $b_radio_checked3 }}>블라인드 리뷰
                            </label>
                        </li>
                        <li>작성자</li>
                        <li>
                            <select name="user_info">
                                <option value="user_name">이름</option>
                                <option value="user_id">아이디</option>
                            </select>
                            <input type="text" name="user_keyword">
                        </li>
                    </ul>
                    <button type="submit">검색</button>
                </form>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">
                    <!-- 상단 버튼영역 시작 -->
                    <div class="btn_area">
                        <div class="right">
                            <button type="button" class="btn-ln" onclick="">엑셀다운로드</button>
                        </div>
                    </div>
                    <!-- 상단 버튼영역 끝 -->

                    <!-- 리뷰 리스트 시작 -->
                    <table class="rev_table">
                        <colgroup>
<!--
                            <col style="width: 40px;">
-->
                            <col style="width: 60px;">
                            <col style="width: 130px;">
                            <col style="width: 80px;">
                            <col style="width: 250px;">
                            <col style="width: 220px;">
                            <col style="width: auto;">
                            <col style="width: 210px;">
                            <col style="width: 90px;">
                            <col style="width: 70px;">
                            <col style="width: 70px;">
                            <col style="width: 70px;">
                        </colgroup>
                        <thead>
                            <tr>
<!--
                                <th><input type="checkbox" class="mg00" id=""></th>
-->
                                <th>번호</th>
                                <th>아이디</th>
                                <th>이름</th>
                                <th>상품명/체험단명</th>
                                <th>정량 평가</th>
                                <th>리뷰</th>
                                <th>포토리뷰</th>
                                <th>작성일자</th>
                                <th>상태</th>
                                <th>블라인드처리여부</th>
                                <th>수정</th>
                            </tr>
                        </thead>
                        <!-- 리스트 시작 -->
                        @foreach($review_save_rows as $review_save_row)
                        @php
                            $review_img_tmp = '';
                            $review_img_cnt = false;
                            $score_tmp = '';
                            $dip_name = '';
                            $tmp = '';
                            $kk = 0;
                            $review_img_disp = array();

                            $exp_info = DB::table('exp_list')->select('title')->where('id', $review_save_row->exp_id)->first(); //체험단명 찾기

                            if(is_null($exp_info)){
                                $title_ment = '';
                            }else{
                                $title_ment = stripslashes($exp_info->title);
                            }

                            $item_info = DB::table('shopitems')->where('item_code', $review_save_row->item_code)->first(); //상품명 찾기
                            $rating_item_info = DB::table('rating_item')->where('sca_id', $review_save_row->sca_id)->first();


                            //리뷰 첨부 이미지 구하기
                            $review_save_imgs = DB::table('review_save_imgs')->where('rs_id', $review_save_row->id);
                            $review_save_imgs_cnt = $review_save_imgs->count();

                            $review_save_imgs_infos = array();
                            if($review_save_imgs_cnt > 0) $review_save_imgs_infos = $review_save_imgs->get();

                            if($review_save_row->review_blind == "Y") $blind_ment = '블라인드 해제';
                            else $blind_ment = '블라인드 처리';

                            //이미지 처리
                            if($item_info->item_img1 == "") {
                                $item_img_disp = asset("img/no_img.jpg");
                            }else{
                                $item_img_cut = explode("@@",$item_info->item_img1);
                                $item_img_disp = "/data/shopitem/".$item_img_cut[3];
                            }

                            if($item_info->item_manufacture == "") $item_manufacture = "";
                            else $item_manufacture = "[".$item_info->item_manufacture."] ";
                        @endphp
                        <tbody>
                            <tr>
<!--
                                <td rowspan="2">
                                    <input type="checkbox" class="mg00" id="">
                                </td>
-->
                                <td rowspan="2">{{ $virtual_num }}</td>
                                <td rowspan="2">{{ $review_save_row->user_id }}</td>
                                <td rowspan="2">{{ $review_save_row->user_name }}</td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="{{ $item_img_disp }}">
                                        </div>
                                        <div>
                                            {{ $item_manufacture }}{{ stripslashes($item_info->item_name) }}
                                        </div>
                                    </div>
                                </td>
                                <td rowspan="2" class="score">
                                    <ul>
                                        @for($i = 1; $i <= 5; $i++)
                                        @php
                                            $tmp = "item_name".$i;
                                            $score_tmp = "score".$i;
                                        @endphp
                                        <li>
                                            {{ $rating_item_info->$tmp }}
                                            <span>{{ number_format($review_save_row->$score_tmp, 2) }}</span>
                                        </li>
                                        @endfor

                                    </ul>
                                </td>
                                <td rowspan="2" class="usertxt">{{ $review_save_row->review_content }}</td>
                                <td rowspan="2" class="thumb_rev">
                                    <ul>
                                        @if($review_save_imgs_cnt > 0)
                                            @foreach($review_save_imgs_infos as $review_save_imgs_info)
                                            @php
                                                $review_img_cut = '';
                                                $review_img_disp = '';
                                                $review_img_cut = explode("@@",$review_save_imgs_info->review_img);
                                                $review_img_disp = "/data/review/".$review_img_cut[2];
                                            @endphp
                                        <li onclick="openmodal_003('{{ $review_img_cut[0] }}')"><img src="{{ $review_img_disp }}"></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </td>
                                <td rowspan="2">2022-01-01<br>13:13:13</td>
                                <td rowspan="2">노출</td>
                                <td rowspan="2">블라인드</td>
                                <td rowspan="2">수정</td>
                            </tr>
                            <tr>
                                <td class="title">2022 새해 호랑이 잡기 체험단 진행. 새해복많이받으세요</td>
                            </tr>
                        </tbody>
                        @php
                            $virtual_num--;
                        @endphp
                        @endforeach
                        <!-- 리스트 끝 -->

                    </table>
                    <!-- 리뷰 리스트 끝 -->

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

            <!-- 모달 시작-->
            <div class="modal_003 modal fade">
                <div class="modal-background" onclick="closemodal_003()"></div>
                <div class="modal-dialog">
                    <div class="top_close" onclick="closemodal_003()"></div>
                    <div class="modal_area">
                        <img id="img_url">
                    </div>
                </div>
            </div>
            <!-- 모달 끝 -->

        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
    select_item('{{ $ca_id }}');
    function select_item(ca_id){
        if(ca_id == "") {
            $("#s_cate").hide();
        }else{
            $.ajax({
                type : 'get',
                url : '{{ route('adm.review.ajax_item') }}',
                data : {
                    'ca_id' : ca_id,
                    'item_code' : '{{ $item_code }}',
                },
                dataType : 'text',
                success : function(result){
                    if(result == ""){
                        $("#s_cate").hide();
                    }else{
                        $("#s_cate").html(result);
                        $("#s_cate").show();
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }
    }
</script>



<script>
@if($seach_1 == 'exp')
$("#block_1").show();
@endif
    function seach_1_change()
    {
        if($("#seach_1").val() == "exp")
        {
            $("#block_1").show();
        }else{
            $("#block_1").hide();
        }
    }
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    function review_blind(num, type){
        if(type == 'Y') var ment = '해제';
        else var ment = '처리';

        if (confirm("블라인드(blind) "+ment+" 하시겠습니까?") == true){    //확인
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type : "post",
                url : "{{ route('adm.review.review_blind') }}",
                data : {
                    'num' : num,
                },
                dataType : 'text',
                success : function(result){
//alert(result);
//return false;
                    if(result == 'blind_ok'){
                        alert('블라인드(blind) 처리 되었습니다.');
                        location.reload();
                    }

                    if(result == 'blind_no'){
                        alert('블라인드(blind) 해제 처리 되었습니다.');
                        location.reload();
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }else{   //취소
            return false;
        }
    }
</script>

<script>
    function review_modi(num){
        location.href = "{!! route('adm.review.review_modi', $page_move) !!}&num="+num;
    }
</script>

<script>
    function openModal(){
        document.querySelector('body').classList.add('modal-open')
    }
    function closeModal() {
        document.querySelector('body').classList.remove('modal-open')
    }
    function openmodal_001() {
        openModal();
        document.querySelector('.modal.modal_001').classList.add('in');
    }
    function closemodal_001(){
        closeModal();
        document.querySelector('.modal.modal_001').classList.remove('in');
    }
    function openmodal_002() {
        openModal();
        document.querySelector('.modal.modal_002').classList.add('in');
    }
    function closemodal_002(){
        closeModal();
        document.querySelector('.modal.modal_002').classList.remove('in');
    }
    function openmodal_003(img) {
        openModal();
        document.querySelector('.modal.modal_003').classList.add('in');
        var imgurl = "{{ asset('/data/review/"+img+"') }}";
        $("#img_url").attr("src", imgurl);
    }
    function closemodal_003(){
        closeModal();
        document.querySelector('.modal.modal_003').classList.remove('in');
    }
</script>



@endsection
