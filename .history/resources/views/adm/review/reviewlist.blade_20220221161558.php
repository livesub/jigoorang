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

            <form>

                <!-- 검색창 시작 -->
                <div class="box_search">
                    <ul>
                        <li>상품 선택</li>
                        <li>
                        @php
                            $search_selectboxs = DB::table('shopcategorys')->where('sca_display', 'Y')->orderby('sca_id','ASC')->orderby('sca_rank','ASC')->get();
                        @endphp
                            <select name="ca_id" id="ca_id" onchange="select_item(this)">
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
                            <label>
                                <input type="radio" id="" name="rev" checked="checked">전체
                            </label>
                            <label>
                                <input type="radio" id="" name="rev" >구매 리뷰
                            </label>
                            <label>
                                <input type="radio" id="" name="rev" >체험단 리뷰
                            </label>
                        </li>
                        <li>노출여부</li>
                        <li>
                            <label>
                                <input type="radio" id="" name="show" checked="checked">전체
                            </label>
                            <label>
                                <input type="radio" id="" name="show" >노출 리뷰
                            </label>
                            <label>
                                <input type="radio" id="" name="show" >블라인드 리뷰
                            </label>
                        </li>
                        <li>작성자</li>
                        <li>
                            <select>
                                <option>이름</option>
                                <option>아이디</option>
                            </select>
                            <input type="text" name="" placeholder="">
                        </li>
                    </ul>
                    <button type="button" onclick="">검색</button>
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
                            <col style="width: 40px;">
                            <col style="width: 60px;">
                            <col style="width: 130px;">
                            <col style="width: 80px;">
                            <col style="width: 250px;">
                            <col style="width: 220px;">
                            <col style="width: auto;">
                            <col style="width: 210px;">
                            <col style="width: 90px;">
                            <col style="width: 70px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="mg00" id=""></th>
                                <th>번호</th>
                                <th>아이디</th>
                                <th>이름</th>
                                <th>상품명/체험단명</th>
                                <th>정량 평가</th>
                                <th>리뷰</th>
                                <th>포토리뷰</th>
                                <th>작성일자</th>
                                <th>상태</th>
                            </tr>
                        </thead>
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2">
                                    <input type="checkbox" class="mg00" id="">
                                </td>
                                <td rowspan="2">99999</td>
                                <td rowspan="2">g9r@gmail.com</td>
                                <td rowspan="2">김치맨</td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td rowspan="2" class="score">
                                    <ul>
                                        <li>
                                            향은 어떠한가 말을해 보거라
                                            <span>5.00</span>
                                        </li>
                                        <li>
                                            맛
                                            <span>4.50</span>
                                        </li>
                                        <li>
                                            컬러
                                            <span>4.00</span>
                                        </li>
                                        <li>
                                            풍미
                                            <span>3.00</span>
                                        </li>
                                        <li>
                                            총평
                                            <span>4.00</span>
                                        </li>
                                    </ul>
                                </td>
                                <td rowspan="2" class="usertxt">이 상품 아주 마음에 들어요. 가볍고 향도좋고 효과도 아주 맘에 듭니다. 번창하세요.</td>
                                <td rowspan="2" class="thumb_rev">
                                    <ul>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                    </ul>
                                </td>
                                <td rowspan="2">2022-01-01<br>13:13:13</td>
                                <td rowspan="2">노출</td>
                            </tr>
                            <tr>
                                <td class="title">2022 새해 호랑이 잡기 체험단 진행. 새해복많이받으세요</td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2">
                                    <input type="checkbox" class="mg00" id="">
                                </td>
                                <td rowspan="2">99998</td>
                                <td rowspan="2">g9r@gmail.com</td>
                                <td rowspan="2">김치맨</td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td rowspan="2" class="score">
                                    <ul>
                                        <li>
                                            향은 어떠한가 말을해 보거라
                                            <span>5.00</span>
                                        </li>
                                        <li>
                                            맛
                                            <span>4.50</span>
                                        </li>
                                        <li>
                                            컬러
                                            <span>4.00</span>
                                        </li>
                                        <li>
                                            풍미
                                            <span>3.00</span>
                                        </li>
                                        <li>
                                            총평
                                            <span>4.00</span>
                                        </li>
                                    </ul>
                                </td>
                                <td rowspan="2" class="usertxt">이 상품 아주 마음에 들어요. 가볍고 향도좋고 효과도 아주 맘에 듭니다. 번창하세요.</td>
                                <td rowspan="2" class="thumb_rev">
                                    <ul>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                        <li onclick="openmodal_003()"><img src="../../img/img_main.png"></li>
                                    </ul>
                                </td>
                                <td rowspan="2">2022-01-01<br>13:13:13</td>
                                <td rowspan="2">블라인드</td>
                            </tr>
                            <tr>
                                <td class="title">2022 새해 호랑이 잡기 체험단 진행. 새해복많이받으세요</td>
                            </tr>
                        </tbody>
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
                        <img src="../../img/img_main.png">
                    </div>
                </div>
            </div>
            <!-- 모달 끝 -->

        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
    function select_item(cate){
        if(cate.value == "") {
            $("#s_cate").css('display', 'none');
        }else{
            $.ajax({
                type : 'get',
                url : '{{ route('adm.review.ajax_item') }}',
                data : {
                    'cate' : cate.value,
                },
                dataType : 'text',
                success : function(result){
alert(result);
                    $("#s_cate").html(result);
                    $("#s_cate").show();
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




@endsection
