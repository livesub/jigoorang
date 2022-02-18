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
                <h2>주문 관리</h2>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area order">

            <form>

                <!-- 주문 단계 탭버튼 시작 -->
                <div class="order_step">
                @php
                    $class1 = "";
                    $class2 = "";
                    $class3 = "";
                    $class4 = "";
                    $class5 = "";
                    $class6 = "";

                    switch($od_status) {
                        case "입금":
                            $class1 = "acc";
                        break;
                        case "준비":
                            $class2 = "acc";
                        break;
                        case "배송":
                            $class3 = "acc";
                        break;
                        case "완료":
                            $class4 = "acc";
                        break;
                        case "교환":
                            $class5 = "acc";
                        break;
                        case "상품취소":
                            $class6 = "acc";
                        break;
                        case "":
                            $class1 = "acc";
                        break;
                    }
                @endphp
                    <ul>
                        <li>
                            <button type="button" class="{{ $class1 }}" onclick="location.href='{{ route('orderlist', 'od_status=입금') }}'">결제완료 ({{ $orders_cnt1 }})</button>
                        </li>
                        <li>
                            <button  type="button" class="{{ $class2 }}" onclick="location.href='{{ route('orderlist', 'od_status=준비') }}'">주문확인 ({{ $orders_cnt2 }})</button>
                        </li>
                        <li>
                            <button type="button" class="{{ $class3 }}" onclick="location.href='{{ route('orderlist', 'od_status=배송') }}'">발송 ({{ $orders_cnt3 }})</button>
                        </li>
                        <li>
                            <button type="button" class="{{ $class4 }}" onclick="location.href='{{ route('orderlist', 'od_status=완료') }}'">배송완료 ({{ $orders_cnt4 }})</button>
                        </li>
                        <li>
                            <button type="button" class="{{ $class5 }}" onclick="location.href='{{ route('orderlist', 'od_status=교환') }}'">교환 ({{ $orders_cnt5 }})</button>
                        </li>
                        <li>
                            <button type="button" class="{{ $class6 }}" onclick="location.href='{{ route('orderlist', 'od_status=상품취소') }}'">주문취소 ({{ $orders_cnt6 }})</button>
                        </li>
                    </ul>
                </div>
                <!-- 주문 단계 탭버튼 끝 -->

                <!-- 검색창 시작 -->
                <div class="box_search">
                    <form name="frmorderlist">
                    <input type="hidden" name="od_status" value="{{ $od_status }}">
                    @php
                        $order_id_chk = '';
                        $user_id_chk = '';
                        $od_b_name_chk = '';
                        $od_b_tel_chk = '';
                        $od_b_hp_chk = '';
                        $od_deposit_name_chk = '';
                        $od_invoice_chk = '';

                        if($sel_field == 'order_id') $order_id_chk = 'selected';
                        else if($sel_field == 'user_id') $user_id_chk = 'selected';
                        else if($sel_field == 'od_b_name') $od_b_name_chk = 'selected';
                        else if($sel_field == 'od_b_tel') $od_b_tel_chk = 'selected';
                        else if($sel_field == 'od_b_hp') $od_b_hp_chk = 'selected';
                        else if($sel_field == 'od_deposit_name') $od_deposit_name_chk = 'selected';
                        else if($sel_field == 'od_invoice') $od_invoice_chk = 'selected';

                        //정렬 관련
                        $sort_selected1 = "";
                        $sort_selected2 = "";
                        if($order_sort == "" || $order_sort == "desc") $sort_selected1 = "selected";
                        else $sort_selected2 = "selected";
                    @endphp
                    <ul>
                        <li>검색어</li>
                        <li>
                            <select name="sel_field" id="sel_field">
                                <option value="order_id" {{ $order_id_chk }}>주문번호</option>
                                <option value="user_id" {{ $user_id_chk }}>회원 ID</option>
                                <option value="od_deposit_name" {{ $od_deposit_name_chk }}>주문자명</option>
                                <option value="od_b_name" {{ $od_b_name_chk }}>받는사람명</option>
                                <option value="od_b_hp" {{ $od_b_hp_chk }}>받는분 연락처</option>
                                <option value="od_invoice" {{ $od_invoice_chk }}>운송장번호</option>
                            </select>
                            <input class="wd250" type="text" name="search" value="{{ $search }}" id="search">
                        </li>
                        <li>주문일자</li>
                        <li>
                            <input class="aln_left" type="text" id="fr_date"  name="fr_date" value="{{ $fr_date }}"><span>~</span>
                            <input class="aln_left" type="text" id="to_date"  name="to_date" value="{{ $to_date }}">
                            <button type="button" class="btn-sm ddd-ln" onclick="">오늘</button>
                            <button type="button" class="btn-sm ddd-ln" onclick="">어제</button>
                            <button type="button" class="btn-sm ddd-ln" onclick="">이번주</button>
                            <button type="button" class="btn-sm ddd-ln" onclick="">이번달</button>
                            <button type="button" class="btn-sm ddd-ln" onclick="">지난달</button>
                            <button type="button" class="btn-sm ddd-ln" onclick="">1개월</button>
                            <button type="button" class="btn-sm ddd-ln acc" onclick="">전체</button>
                        </li>
                    </ul>
                    <button type="button" onclick="">검색</button>
                    </form>
                </div>
                <!-- 검색창 끝-->

                <div class="search_rst">
                    검색결과 : <b>2</b>건
                    <div>주문합계 : 배송비 포함 / 실결제 금액 : 주문합계 - 포인트</div>
                </div>

                <!-- 보드 시작 -->
                <div class="board">
                    <!-- 상단 버튼영역 시작 -->
                    <div class="btn_area">
                        <div>
                            <button type="button" class="btn-ln ddd-ln" onclick="">주문취소</button>
                            <!-- <button type="button" class="btn-ln ddd-ln" onclick="">결제완료</button> -->
                            <button type="button" class="btn-ln ddd-ln" onclick="">주문확인</button>
                            <!-- <button type="button" class="btn-ln ddd-ln" onclick="">발송</button> -->
                        </div>
                        <div class="right">
                            <button type="button" class="btn-ln" onclick="">엑셀다운로드</button>
                            <select>
                                <option>주문일순(최신순)</option>
                                <option>주문일순(역순)</option>
                            </select>
                        </div>
                    </div>
                    <!-- 상단 버튼영역 끝 -->

                    <!-- 주문리스트 시작 -->
                    <table class="ord_table">
                        <colgroup>
                            <col style="width: 40px;">
                            <col style="width: 100px;">
                            <col style="width: 150px;">
                            <col style="width: 180px;">
                            <col style="width: auto;">
                            <col style="width: 50px;">
                            <col style="width: 70px;">
                            <col style="width: 45px;">
                            <col style="width: 45px;">
                            <col style="width: 190px;">
                            <col style="width: 70px;">
                            <col style="width: 70px;">
                            <col style="width: 70px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th rowspan="2"><input type="checkbox" class="mg00" id=""></th>
                                <th rowspan="2">주문일</th>
                                <th rowspan="2">주문번호</th>
                                <th rowspan="2">운송장번호</th>
                                <th rowspan="2">상품명</th>
                                <th rowspan="2">주문건</th>
                                <th rowspan="2">주문상태</th>
                                <th colspan="2">교환</th>
                                <th rowspan="2">주문자</th>
                                <th rowspan="2">주문합계</th>
                                <th rowspan="2">실결제 <br>금액</th>
                                <th rowspan="2">취소금액</th>
                            </tr>
                            <tr>
                                <th>요청</th>
                                <th>완료</th>
                            </tr>
                        </thead>
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>2021-12-31<br>12:18:12 (월)</td>
                                <td class="order_num">
                                    <a href="../../page/order/order_detail.html">20211231121812001</a>
                                </td>
                                <td class="tracking">

                                </td>
                                <td class="prod_name2">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            <div>[대나무샵]친환경칫솔경칫솔칫솔칫솔칫솔칫솔칫솔칫솔</div>
                                            <div>사이즈:M / 컬러:파랑</div>
                                            <div>외2건</div>
                                        </div>
                                    </div>
                                </td>
                                <td>3</td>
                                <td>결제완료</td>
                                <td><a href="../../page/order/order_detail.html">0</a></td>
                                <td><a href="../../page/order/order_detail.html">0</a></td>
                                <td class="buyer">
                                    <a href="../../page/member/member_detail.html">
                                        <div>지구령</div>
                                        <div>jigoorang12345@gmail.com</div>
                                        <div>01012351235</div>
                                    </a>
                                </td>
                                <td>12,500</td>
                                <td>10,000</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td colspan="12" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>2021-12-31<br>12:18:12 (월)</td>
                                <td class="order_num">
                                    <a href="../../page/order/order_detail.html">20211231121812001</a>
                                </td>
                                <td class="tracking">

                                </td>
                                <td class="prod_name2">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            <div>[대나무샵]친환경칫솔경칫솔칫솔칫솔칫솔칫솔칫솔칫솔 12312asfasfasdfasdfadsf3123123123123123123*******</div>
                                            <div>사이즈:M / 컬러:파랑</div>
                                            <div>외2건</div>
                                        </div>
                                    </div>
                                </td>
                                <td>3</td>
                                <td>결제완료</td>
                                <td><a href="../../page/order/order_detail.html">0</a></td>
                                <td><a href="../../page/order/order_detail.html">0</a></td>
                                <td class="buyer">
                                    <a href="../../page/member/member_detail.html">
                                        <div>지구령</div>
                                        <div>jigoorang12345@gmail.com</div>
                                        <div>01012351235</div>
                                    </a>
                                </td>
                                <td>12,500</td>
                                <td>10,000</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td colspan="12" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>2021-12-31<br>12:18:12 (월)</td>
                                <td class="order_num">
                                    <a href="../../page/order/order_detail.html">20211231121812001</a>
                                </td>
                                <td class="tracking">

                                </td>
                                <td class="prod_name2">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            <div>[대나무샵]친환경칫솔경칫솔칫솔칫솔칫솔칫솔칫솔칫솔</div>
                                            <div>사이즈:M / 컬러:파랑</div>
                                            <div>외2건</div>
                                        </div>
                                    </div>
                                </td>
                                <td>3</td>
                                <td>결제완료</td>
                                <td><a href="../../page/order/order_detail.html">0</a></td>
                                <td><a href="../../page/order/order_detail.html">0</a></td>
                                <td class="buyer">
                                    <a href="../../page/member/member_detail.html">
                                        <div>지구령</div>
                                        <div>jigoorang12345@gmail.com</div>
                                        <div>01012351235</div>
                                    </a>
                                </td>
                                <td>12,500</td>
                                <td>10,000</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td colspan="12" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>2021-12-31<br>12:18:12 (월)</td>
                                <td class="order_num">
                                    <a href="../../page/order/order_detail.html">20211231121812001</a>
                                </td>
                                <td class="tracking">

                                </td>
                                <td class="prod_name2">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            <div>[대나무샵]친환경칫솔경칫솔칫솔칫솔칫솔칫솔칫솔칫솔</div>
                                            <div>사이즈:M / 컬러:파랑</div>
                                            <div>외2건</div>
                                        </div>
                                    </div>
                                </td>
                                <td>3</td>
                                <td>결제완료</td>
                                <td><a href="../../page/order/order_detail.html">0</a></td>
                                <td><a href="../../page/order/order_detail.html">0</a></td>
                                <td class="buyer">
                                    <a href="../../page/member/member_detail.html">
                                        <div>지구령</div>
                                        <div>jigoorang12345@gmail.com</div>
                                        <div>01012351235</div>
                                    </a>
                                </td>
                                <td>12,500</td>
                                <td>10,000</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td colspan="12" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                    </table>
                    <!-- 주문리스트 끝 -->


                    <!-- 하단 버튼영역 시작 -->
                    <div class="btn_area">
                        <div>
                            <button type="button" class="btn-ln ddd-ln" onclick="">주문취소</button>
                            <!-- <button type="button" class="btn-ln ddd-ln" onclick="">결제완료</button> -->
                            <button type="button" class="btn-ln ddd-ln" onclick="">주문확인</button>
                            <!-- <button type="button" class="btn-ln ddd-ln" onclick="">발송</button> -->
                        </div>
                    </div>
                    <!-- 하단 버튼영역 끝 -->

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
    //두개짜리 제어 연결된거 만들어주는 함수
    datePickerSet($("#fr_date"), $("#to_date"), true); //다중은 시작하는 달력 먼저, 끝달력 2번째

    function datePickerSet(sDate, eDate, flag) {
        if (!isValidStr(sDate) && !isValidStr(eDate) && sDate.length > 0 && eDate.length > 0) {
            var sDay = sDate.val();
            var eDay = eDate.val();

            if (flag && !isValidStr(sDay) && !isValidStr(eDay)) { //처음 입력 날짜 설정, update...
                var sdp = sDate.datepicker().data("datepicker");
                sdp.selectDate(new Date(sDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요

                var edp = eDate.datepicker().data("datepicker");
                edp.selectDate(new Date(eDay.replace(/-/g, "/")));  //익스에서는 그냥 new Date하면 -을 인식못함 replace필요
            }

            //시작일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(eDay)) {
                sDate.datepicker({
                    maxDate: new Date(eDay.replace(/-/g, "/"))
                });
            }
            sDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });

            //종료일자 세팅하기 날짜가 없는경우엔 제한을 걸지 않음
            if (!isValidStr(sDay)) {
                eDate.datepicker({
                    minDate: new Date(sDay.replace(/-/g, "/"))
                });
            }
            eDate.datepicker({
                language: 'ko',
                autoClose: true,
                onSelect: function () {
                    datePickerSet(sDate, eDate);
                }
            });
        }

        function isValidStr(str) {
            if (str == null || str == undefined || str == "")
                return true;
            else
                return false;
        }
    }

    function set_date(today)
    {
        @php
        $now_date = date('Y-m-d', time());
        $date_term = date('w', time());
        $week_term = $date_term + 7;
        $last_term = strtotime(date('Y-m-01', time()));
        @endphp

        if (today == "오늘") {
            $("#fr_date").val("{{ $now_date }}");
            $("#to_date").val("{{ $now_date }}");
        } else if (today == "어제") {
            $("#fr_date").val("{{ date('Y-m-d', time() - 86400) }}");
            $("#to_date").val("{{ date('Y-m-d', time() - 86400) }}");
        } else if (today == "이번주") {
            $("#fr_date").val("{{ date('Y-m-d', strtotime('-'.$date_term.' days', time())) }}");
            $("#to_date").val("{{ date('Y-m-d', time()) }}");
        } else if (today == "이번달") {
            $("#fr_date").val("{{ date('Y-m-01', time()) }}");
            $("#to_date").val("{{ date('Y-m-d', time()) }}");
        } else if (today == "지난주") {
            $("#fr_date").val("{{ date('Y-m-d', strtotime('-'.$week_term.' days', time())) }}");
            $("#to_date").val("{{ date('Y-m-d', strtotime('-'.($week_term - 6).' days', time())) }}");
        } else if (today == "지난달") {
            $("#fr_date").val("{{ date('Y-m-01', strtotime('-1 Month', $last_term)) }}");
            $("#to_date").val("{{ date('Y-m-t', strtotime('-1 Month', $last_term)) }}");
        } else if (today == "전체") {
            $("#fr_date").val("");
            $("#to_date").val("");
        }
    }
</script>

<script>
    $(function() {
        $("input[name=ct_all]").click(function() {
            if($("#ct_all").is(":checked")) $("input[name^=ct_chk]").prop("checked", true);
            else $("input[name^=ct_chk]").prop("checked", false);
        });
    });
</script>

<script>
    function order_sort(){
        var order_sort = $("#order_sort option:selected").val();
        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+order_sort+"&return_proc={{ $return_proc }}";
    }
</script>

<script>
    function order_check(check_type){
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert(check_type + "할 주문건을 하나이상 선택해 주십시오.");
            return false;
        }

        if (confirm("선택된 주문건을 "+ check_type +" 단계로 변경합니다.") == true){    //확인
            $("#check_type").val(check_type);
            var form_var = $("#order_check_from").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('ajax_order_check') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
//alert(result);
//return false;
                    if(result == "ok"){
                        alert(check_type + " 처리 되었습니다");
                        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
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
    function order_cancel(){
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("주문취소할 주문건을 하나이상 선택해 주십시오.");
            return false;
        }

        var msg = '주문취소 시 자동 환불 처리 되어 복구 할수 없습니다.';
        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?") == true){    //확인
            var form_var = $("#order_check_from").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('ajax_order_cancel') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
                    if(result == "ok"){
                        alert("주문취소 처리 되었습니다.");
                        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
                    }

                    if(result == "error"){
                        alert("주문취소가 실패 하였습니다. 관리자에게 문의 하세요.-1");
                        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
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
    function order_send_check(){
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("발송처리할 주문건을 하나이상 선택해 주십시오.");
            return false;
        }

        var check = true;
        $("input[name^=ct_chk]:checked").each(function(){
            var order_id = $(this).val();
            if($.trim($("#od_invoice_"+order_id).val()) == ""){
                alert("송장 번호를 입력 하세요");
                $("#od_invoice_"+order_id).focus();
                check = false;
                return false;
            }
        });

        if(check == true){
            if (confirm("선택된 주문건을 발송 단계로 변경합니다.") == true){    //확인
                    var form_var = $("#order_check_from").serialize();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    type : 'post',
                    url : '{{ route('ajax_order_send') }}',
                    data : form_var,
                    dataType : 'text',
                    success : function(result){
    //alert(result);
    //return false;
                        if(result == "ok"){
                            alert("발송 처리 되었습니다");
                            location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
                        }
                    },
                    error: function(result){
                        console.log(result);
                    },
                });
            }
        }
    }
</script>

<script>
    function order_return(){
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("주문확인할 주문건을 하나이상 선택해 주십시오.");
            return false;
        }

        if (confirm("선택된 주문건을 주문확인 단계로 변경합니다.") == true){    //확인
            var form_var = $("#order_check_from").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('ajax_order_return') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
//alert(result);
//return false;
                    if(result == "ok"){
                        alert("주문확인 처리 되었습니다");
                        location.href = "{{ route('orderlist') }}?{!! $sort_page_move !!}"+"&order_sort="+"{{ $order_sort }}";
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
    function excel_down(){
        location.href = "{{ route('order_excel',) }}?{!! $sort_page_move !!}&order_sort={{ $order_sort }}&return_proc={{ $return_proc }}";
    }
</script>


@endsection
