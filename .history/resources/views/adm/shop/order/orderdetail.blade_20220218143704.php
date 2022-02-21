@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>주문 상세처리</h2>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area order">
        @php
            switch($order_info->od_status) {
                case "입금":
                    $ment = "결제완료";
                break;
                case "준비":
                    $ment = "주문확인";
                break;
                case "배송":
                    $ment = "발송";
                break;
                case "완료":
                    $ment = "배송완료";
                break;
                case "교환":
                    $ment = "교환";
                break;
                case "상품취소":
                    $ment = "주문취소";
                break;
            }
        @endphp

            <form>

                <!-- 주문상품 목록 시작 -->
                <h3 class="line">주문상품 목록</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">주문상태</div>
                        <div class="col"><b>{{ $ment }}</b></div>
                    </div>
                    <div class="row">
                        <div class="col">주문일시</div>
                        <div class="col">{{ substr($order_info->od_receipt_time, 0, 16) }} ({{ $CustomUtils->get_yoil($order_info->od_receipt_time) }})</div>
                    </div>
                    <div class="row">
                        <div class="col">결제금액</div>
                        <div class="col">{{ number_format($order_info->real_card_price) }}원</div>
                    </div>
                    <div class="row">
                        <div class="col">송장번호</div>
                        <div class="col">{{ $order_info->od_invoice }} ({{ substr($order_info->od_invoice_date, 0, 16) }} ({{ $CustomUtils->get_yoil($order_info->od_invoice_date) }}))</div>
                    </div>
                    <div class="row">
                        <div class="col">교환 요청 및 처리</div>
                        <div class="col"><b class="t_red">{{ $return_process_cnt }}  / {{ $return_story_cnt }} (건)</b></div>
                    </div>
                    @if($order_info->od_status != "상품취소")
                    <div class="row">
                        <div class="col">주문 취소</div>
                        <div class="col"><a class="t_gry line" onclick="items_cancel('상품취소')">취소하기</a></div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col100">
                            <!-- 교환 상세 내역 시작 -->
                            <table class="ord_detail_table1">
                                <colgroup>
                                    <col style="width: 80px;">
                                    <col style="width: auto;">
                                    <col style="width: 40px;">
                                    <col style="width: 240px;">
                                    <col style="width: 80px;">
                                    <col style="width: 80px;">
                                    <col style="width: 150px;">
                                    <col style="width: 120px;">
                                    <col style="width: 120px;">
                                    <col style="width: 120px;">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>교환</th>
                                        <th>상품명</th>
                                        <th><input type="checkbox" class="mg00 category-1" id="sit_select_all" name="all_chkbox" value="Y"></th>
                                        <th>옵션</th>
                                        <th>주문수량</th>
                                        <th>구매수량</th>
                                        <th>교환 수량 입력</th>
                                        <th>판매가</th>
                                        <th>소개</th>
                                        <th>포인트 적립</th>
                                    </tr>
                                </thead>

                                @php
                                    $i = 0;
                                    $chk_cnt = 0;
                                    $chk_box = 0;
                                    $chk_box2 = 0;
                                @endphp
                                <!-- 리스트 시작 -->
                                @foreach($carts as $cart)
                                @php
                                    $image = $CustomUtils->get_item_image($cart->item_code, 3);
                                    if($image == "") $image = asset("img/no_img.jpg");

                                    $opts = DB::table('shopcarts')->where([['od_id', $order_info->order_id],['item_code', $cart->item_code]])->orderBy('sio_type')->orderBy('id')->get();
                                    $rowspan = count($opts);
                                    $k = 0;

                                    //제조사
                                    $item = DB::table('shopitems')->where('item_code', $cart->item_code)->first();
                                    if($item->item_manufacture == "") $item_manufacture = "";
                                    else $item_manufacture = "[".$item->item_manufacture."] ";
                                @endphp

                                @foreach($opts as $opt)
                                    @php
                                        if($opt->sio_type) $opt_price = $opt->sio_price;
                                        else $opt_price = $opt->sct_price + $opt->sio_price;
                                        // 소계
                                        $ct_price['stotal'] = $opt_price * $opt->sct_qty;
                                        $ct_point['stotal'] = $opt->sct_point * $opt->sct_qty;
                                        $ct_baesong['baesong'] = $opt->sct_point * $opt->sct_qty;

                                        $return_ment = "";
                                        $return_story = "";
                                        if($opt->return_story != ""){
                                            $return_story = "요청";
                                            if($opt->return_process == "N"){
                                                $return_ment = '미완료';
                                            }else{
                                                $return_ment = "완료";
                                            }
                                        }
                                    @endphp

                                <tbody>
                                    <tr>
                                        <td class="cs">
                                            <div onclick="openmodal_001()">{{ $return_story }}</div>
                                            <div class="acc">{{ $return_ment }}</div>
                                        </td>

                                        @if($k == 0)
                                        <td class="prod_name" rowspan="{{ $rowspan }}">
                                            <div>
                                                <div>
                                                    <img src="{{ asset($image) }}">
                                                </div>
                                                <div>
                                                    {{ $item_manufacture }}{{ stripslashes(mb_substr($cart->item_name, 0, 20, 'utf-8')) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td rowspan="{{ $rowspan }}">
                                            <input type="checkbox" id="sit_sel_{{ $i }}" name="it_sel[]" value="{{ $cart->item_code }}" class="mg00 category-1-{{ $chk_box }}">
                                        </td>
                                        @endif
<!--
                                        <td class="prd_option">
                                            @if($opt->sct_status == '취소')
                                            <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}" class="mg00 category-1-{{ $chk_box }}-{{ sprintf('%02d',$chk_box2) }}" checked disabled="disabled">
                                            @else
                                            <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}" class="mg00 category-1-{{ $chk_box }}-{{ sprintf('%02d',$chk_box2) }}">
                                            @endif
                                            <input type="hidden" name="ct_id[{{ $chk_cnt }}]" value="{{ $opt->id }}">
                                            <label>
                                            {{ mb_substr($opt->sct_option, 0, 20, 'utf-8') }}
                                            </label>
                                        </td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td class="change_num">
                                            <input type="number" name="" placeholder="">
                                        </td>
                                        <td>10,000</td>
                                        <td>0</td>
                                        <td>0P</td>
-->
                                    </tr>
<!--
                                    <tr>
                                        <td class="cs">
                                            <div onclick="openPrivacyPolicyModal()">요청</div>
                                            <div class="acc">완료</div>
                                        </td>
                                        <td class="prd_option">
                                            <input type="checkbox" class="mg00" id="">
                                            <label>
                                                사이즈 : M<br>
                                                컬러 : 빨강
                                            </label>
                                        </td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td class="change_num">
                                            <input type="number" name="" placeholder="">
                                        </td>
                                        <td>10,000</td>
                                        <td>0</td>
                                        <td>0P</td>
                                    </tr>
-->
                                </tbody>
                                        @php
                                            $i++;
                                            $chk_cnt++;
                                            $k++;
                                            $chk_box2++;
                                        @endphp
                                    @endforeach
                                    @php
                                        $chk_box++;
                                        $chk_box2 = 0;
                                    @endphp
                                @endforeach

                                <!-- 리스트 끝 -->
                                <!-- 리스트 시작
                                <tbody>
                                    <tr>
                                        <td class="cs">
                                            <div onclick="openmodal_001()">요청</div>
                                            <div class="acc">완료</div>
                                        </td>
                                        <td class="prod_name" rowspan="2">
                                            <div>
                                                <div>
                                                    <img src="../../img/img_prod_01.png">
                                                </div>
                                                <div>
                                                    [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                                    친환경칫솔친환경칫솔친환경칫
                                                </div>
                                            </div>
                                        </td>
                                        <td rowspan="2">
                                            <input type="checkbox" class="mg00" id="">
                                        </td>
                                        <td class="prd_option">
                                            <input type="checkbox" class="mg00" id="">
                                            <label>
                                                사이즈 : M<br>
                                                컬러 : 빨강
                                            </label>
                                        </td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td class="change_num">
                                            <input type="number" name="" placeholder="">
                                        </td>
                                        <td>10,000</td>
                                        <td>0</td>
                                        <td>0P</td>
                                    </tr>
                                    <tr>
                                        <td class="cs">
                                            <div onclick="openPrivacyPolicyModal()">요청</div>
                                            <div class="acc">완료</div>
                                        </td>
                                        <td class="prd_option">
                                            <input type="checkbox" class="mg00" id="">
                                            <label>
                                                사이즈 : M<br>
                                                컬러 : 빨강
                                            </label>
                                        </td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td class="change_num">
                                            <input type="number" name="" placeholder="">
                                        </td>
                                        <td>10,000</td>
                                        <td>0</td>
                                        <td>0P</td>
                                    </tr>
                                </tbody>
                                리스트 끝
                                리스트 시작
                                <tbody>
                                    <tr>
                                        <td class="cs">
                                            <div onclick="openmodal_001()">요청</div>
                                            <div>미완료</div>
                                        </td>
                                        <td class="prod_name">
                                            <div>
                                                <div>
                                                    <img src="../../img/img_prod_01.png">
                                                </div>
                                                <div>
                                                    [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                                    친환경칫솔친환경칫솔친환경칫
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td class="prd_option">
                                            <input type="checkbox" class="mg00" id="">
                                            <label>
                                                사이즈 : M<br>
                                                컬러 : 빨강
                                            </label>
                                        </td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td class="change_num">
                                            <input type="number" name="" placeholder="">
                                        </td>
                                        <td>10,000</td>
                                        <td>0</td>
                                        <td>0P</td>
                                    </tr>
                                </tbody>
                                리스트 끝 -->
                            </table>
                            <!-- 교환 상세내역 끝 -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">교환 처리</div>
                        <div class="col">
                            <div class="file_att">
                                <p class="t_mint">선택한 상품의 입력된 수량을 교환건으로 처리 합니다.</p>
                                <div class="btn_file">
                                    <button type="button" class="btn-ln blk-ln mr05" onclick="">교환</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 주문상품 목록 끝 -->

                <!-- 주문 처리 상세 내역 시작 -->
                <h3 class="line">주문 처리 상세 내역</h3>
                <div class="box_cont">
                    <table class="ord_detail_table2">
                        <colgroup>
                            <col style="width: 200px;">
                            <col style="width: auto;">
                            <col style="width: 150px;">
                            <col style="width: 150px;">
                            <col style="width: 150px;">
                            <col style="width: 330px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>날짜/시간</th>
                                <th>상품명</th>
                                <th>변경 내역</th>
                                <th>변경 수량</th>
                                <th>구매 수량</th>
                                <th>변경자</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2021-12-31 12:18:12 (월)</td>
                                <td class="prod_name">
                                    <div>
                                        [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                    </div>
                                    <div>
                                        사이즈 : M / 컬러 : 빨강
                                    </div>
                                </td>
                                <td>교환</td>
                                <td>1</td>
                                <td>0</td>
                                <td class="buyer">
                                    <a href="../../page/member/member_detail.html">
                                        <div>지구랭</div>
                                        <div>jigoorang12345@gmail.com</div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2021-12-31 12:18:12 (월)</td>
                                <td class="prod_name">
                                    <div>
                                        [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                    </div>
                                    <div>
                                        사이즈 : M / 컬러 : 빨강
                                    </div>
                                </td>
                                <td>교환</td>
                                <td>1</td>
                                <td>0</td>
                                <td class="buyer">
                                    <a href="../../page/member/member_detail.html">
                                        <div>김치맨</div>
                                        <div>jigoorang12345@gmail.com</div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2021-12-31 12:18:12 (월)</td>
                                <td class="prod_name">
                                    <div>
                                       전체
                                    </div>
                                </td>
                                <td>교환</td>
                                <td>1</td>
                                <td>0</td>
                                <td class="buyer">
                                    <a href="../../page/member/member_detail.html">
                                        <div>김치맨</div>
                                        <div>jigoorang12345@gmail.com</div>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- 주문 처리 상세 내역 끝-->


                <!-- 주문결제 내역 시작 -->
                <h3 class="line">주문 결제 내역</h3>
                <div class="box_cont">
                    <table class="ord_detail_table3">
                        <colgroup>
                            <col style="width: auto;">
                            <col style="width: auto;">
                            <col style="width: 150px;">
                            <col style="width: 150px;">
                            <col style="width: 150px;">
                            <col style="width: 150px;">
                            <col style="width: 150px;">
                            <col style="width: 150px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>주문번호</th>
                                <th>결제 방법</th>
                                <th>결제자</th>
                                <th>주문 총액</th>
                                <th>배송비</th>
                                <th>포인트 결제</th>
                                <th>실결제 금액</th>
                                <th>주문취소 금액</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>202112151321542154</td>
                                <td>신용카드</td>
                                <td>김치맨</td>
                                <td>20,000</td>
                                <td>2,500</td>
                                <td>1,000P</td>
                                <td>21,500</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- 주문결제 내역 끝 -->

                <!-- 메모 시작 -->
                <h3 class="line">메모</h3>
                <div class="box_cont">
                    <div class="memo">
                        <textarea></textarea>
                        <button type="button" class="btn_memo blk-ln" onclick="">저장</button>
                    </div>
                </div>
                <!-- 메모 끝 -->

                <!-- 주문자정보 시작 -->
                <h3 class="line">주문자 정보</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">주문상태</div>
                        <div class="col"><b>배송완료</b></div>
                    </div>
                    <div class="row">
                        <div class="col">전화번호</div>
                        <div class="col">01012351234</div>
                    </div>
                    <div class="row">
                        <div class="col">아이디(이메일)</div>
                        <div class="col">abc@gmail.com</div>
                    </div>
                </div>
                <!-- 주문자정보 끝 -->

                <!-- 배송지정보 시작 -->
                <h3 class="line">배송지 정보</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">이름</div>
                        <div class="col">
                            <input type="text" name="" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">전화번호</div>
                        <div class="col">
                            <input class="aln_left" type="number" name="" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">우편번호</div>
                        <div class="col">
                            <div class="post_num">
                                <div>
                                    <input type="number" name="" placeholder="">
                                    <button type="button" class="btn ddd-ln" onclick="">우편번호검색</button>
                                </div>
                                <div>
                                    <input type="text" name="" placeholder="">
                                </div>
                                <div>
                                    <input type="text" name="" placeholder="">
                                </div>
                                <div>
                                    <input type="text" name="" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col">
                            <button type="button" class="btn blk-ln" onclick="">변경</button>
                            <!-- <button type="button" class="btn ddd-ln">변경</button> 버튼 비활성화시 -->
                        </div>
                    </div>
                </div>
                <!-- 배송지정보 끝 -->

            </form>

            <!-- 모달 시작-->
            <div class="modal_001 modal fade">
                <div class="modal-background" onclick="closemodal_001()"></div>
                <div class="modal-dialog">
                    <div class="top_close" onclick="closemodal_001()"></div>
                    <div class="modal_area">
                        <h3 class="line">교환 요청</h3>
                        <div class="box_cont">
                            <div class="row">
                                <div class="col">작성일자</div>
                                <div class="col">
                                    2021-12-21 15:15:15(월)
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">처리일자</div>
                                <div class="col">
                                    2021-12-21 15:15:15(월)
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">사유</div>
                                <div class="col">
                                    파손 및 불량
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">상세사유</div>
                                <div class="col">
                                    <p>
                                    개봉하니 제품이 다 망가져서 왔어요. 그냥 반품 처리 할게요. 당장 오늘 필요했던거라 교환할 시간이 없네요빠른처리 부탁드립니다.
                                    개봉하니 제품이 다 망가져서 왔어요. 그냥 반품 처리 할게요. 당장 오늘 필요했던거라 교환할 시간이 없네요빠른처리 부탁드립니다.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">상태</div>
                                <div class="col">
                                    미처리
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">처리</div>
                                <div class="col">
                                    <select>
                                        <option>미처리</option>
                                        <option>교환</option>
                                        <option>교환 불가</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">현재수량</div>
                                <div class="col">
                                    3
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">교환 수량 입력</div>
                                <div class="col">
                                    <input type="number" name="" placeholder=""> 개
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn wd-100" onclick="closemodal_001()">확인</button>
                        <!-- 버튼 비활성화시 사용 <button type="button" class="btn wd-100 ddd">확인</button> -->
                    </div>
                </div>
            </div>
            <!-- 모달 끝 -->

        </div>
        <!-- 컨텐츠 영역 끝 -->




















<table>
    <tr>
        <td><h4>주문 상세 처리</h4></td>
    </tr>
</table>

<table border=1>
    @php
        switch($order_info->od_status) {
            case "입금":
                $ment = "결제완료";
            break;
            case "준비":
                $ment = "주문확인";
            break;
            case "배송":
                $ment = "발송";
            break;
            case "완료":
                $ment = "배송완료";
            break;
            case "교환":
                $ment = "교환";
            break;
            case "상품취소":
                $ment = "주문취소";
            break;
        }

    @endphp
    <tr>
        <td>현재 주문상태 : {{ $ment }}</td>
        <td>주문일시 : {{ substr($order_info->od_receipt_time, 0, 16) }} ({{ $CustomUtils->get_yoil($order_info->od_receipt_time) }})</td>
        <td>교환요청및 처리 : {{ $return_process_cnt }} / {{ $return_story_cnt }}(건)</td>
        <td>결제금액 : {{ number_format($order_info->real_card_price) }}</strong>원</td>
        <td>송장번호 : {{ $order_info->od_invoice }}</td>
    </tr>
    @if($order_info->od_status != "상품취소")
    <tr>
        <td><button type="button" onclick="items_cancel('상품취소')">취소</button></td>
    </tr>
    @endif
</table>

<table border=1>
    <form name="orderdetailform" id="orderdetailform" method="post" action="">
    {!! csrf_field() !!}
    <input type="hidden" name="order_id" value="{{ $order_info->order_id }}">
    <input type="hidden" name="user_id" value="{{ $order_info->user_id }}">
    <input type="hidden" name="od_email" value="{{ $order_info->user_id }}">
    <input type="hidden" name="page_move" value="{!! $page_move !!}">
    <input type="hidden" name="pg_cancel" value="0">
    <input type="hidden" name="sct_status" id="sct_status">
        <tr>
            <th scope="col">교환</th>
            <th scope="col">상품명</th>
            <th scope="col">
                <input type="checkbox" id="sit_select_all" name="all_chkbox" value="Y" class="category-1">
                <!-- <input type="checkbox" id="sit_select_all"  onclick="selectAll(this)"> -->
            </th>
            <th scope="col">옵션항목</th>
            <th scope="col">주문수량</th>
            <th scope="col">교환수량</th>
            <th scope="col">판매가</th>
            <th scope="col">소계</th>
        </tr>

        @php
            $i = 0;
            $chk_cnt = 0;
            $chk_box = 0;
            $chk_box2 = 0;
        @endphp

        @foreach($carts as $cart)
            @php
                $image = $CustomUtils->get_item_image($cart->item_code, 3);
                if($image == "") $image = asset("img/no_img.jpg");

                $opts = DB::table('shopcarts')->where([['od_id', $order_info->order_id],['item_code', $cart->item_code]])->orderBy('sio_type')->orderBy('id')->get();
                $rowspan = count($opts);
                $k = 0;
            @endphp

            @foreach($opts as $opt)
                @php
                    if($opt->sio_type) $opt_price = $opt->sio_price;
                    else $opt_price = $opt->sct_price + $opt->sio_price;
                    // 소계
                    $ct_price['stotal'] = $opt_price * $opt->sct_qty;
                    $ct_point['stotal'] = $opt->sct_point * $opt->sct_qty;
                    $ct_baesong['baesong'] = $opt->sct_point * $opt->sct_qty;

                    $return_ment = "";
                    $return_story = "";
                    if($opt->return_story != ""){
                        $return_story = "요청";
                        if($opt->return_process == "N"){
                            $return_ment = '미완료';
                        }else{
                            $return_ment = "완료";
                        }
                    }
                @endphp
        <tr>
            <td>
                <span onclick="window.open('{{ route('return_popup','order_id='.$order_info->order_id.'&cart_num='.$cart->id) }}', 'PopupWin', 'width=500,height=600');">{{ $return_story }}</span><br>
                <span>{{ $return_ment }}</span>

            </td>

                @if($k == 0)
            <td rowspan="{{ $rowspan }}"><img src="{{ asset($image) }}" style="width:100px;height:100px;"> {{ stripslashes(mb_substr($cart->item_name, 0, 20, 'utf-8')) }}</td>
            <td rowspan="{{ $rowspan }}">
                <input type="checkbox" id="sit_sel_{{ $i }}" name="it_sel[]" value="{{ $cart->item_code }}" class="category-1-{{ $chk_box }}">
            </td>
                @endif

            <td>
                @if($opt->sct_status == '취소')
                <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}" class="category-1-{{ $chk_box }}-{{ sprintf('%02d',$chk_box2) }}" checked disabled="disabled">
                @else
                <input type="checkbox" name="ct_chk[{{ $chk_cnt }}]" id="ct_chk_{{ $chk_cnt }}" value="{{ $chk_cnt }}" class="category-1-{{ $chk_box }}-{{ sprintf('%02d',$chk_box2) }}">
                @endif
                <input type="hidden" name="ct_id[{{ $chk_cnt }}]" value="{{ $opt->id }}">
                {{ mb_substr($opt->sct_option, 0, 20, 'utf-8') }}
            </td>
            <td>{{ $cart->sct_qty_cancel }}</td>
            <td>
                <input type="text" name="sct_qty[{{ $chk_cnt }}]" id="sct_qty_{{ $chk_cnt }}" value="" size="5" onKeyup="this.value=this.value.replace(/[^1-9]/g,'');">
            </td>
            <td>{{ number_format($opt_price) }}</td>
            <td>{{ number_format($ct_price['stotal']) }}</td>
        </tr>
                @php
                    $i++;
                    $chk_cnt++;
                    $k++;
                    $chk_box2++;
                @endphp
            @endforeach
            @php
                $chk_box++;
                $chk_box2 = 0;
            @endphp
        @endforeach
</table>

<table border=1>
    <tr>
        <td>
            <input type="hidden" name="chk_cnt" id="chk_cnt" value="{{ $chk_cnt }}">
            <strong>주문 및 장바구니 상태 변경</strong>
<!--
            <button type="button" onclick="status_change('입금')">입금</button>
            <button type="button" onclick="status_change('준비')">준비</button>
            <button type="button" onclick="status_change('배송')">배송</button>
            <button type="button" onclick="status_change('완료')">배송완료</button>

            <button type="button" onclick="status_change('부분취소')">부분취소</button>
-->
            <button type="button" onclick="return_item()">교환</button>
        </td>
    </tr>
</form>
</table>

<table border=1>
    <tr>
        <td>주문 수량변경 및 주문 전체취소 처리 내역</td>
    </tr>
</table>

<table class="ord_detail_table2" border=1>
    <colgroup>
        <col style="width: 200px;">
        <col style="width: auto;">
        <col style="width: 150px;">
        <col style="width: 150px;">
        <col style="width: 150px;">
        <col style="width: 330px;">
    </colgroup>
    <thead>
        <tr>
            <th>날짜/시간</th>
            <th>상품명</th>
            <th>변경 내역</th>
            <th>변경 수량</th>
            <th>구매 수량</th>
            <th>변경자</th>
        </tr>
    </thead>
    <tbody>
        {!! $order_info->od_mod_history !!}
    </tbody>
</table>
<!--
<table border=1>
    <tr>
        <td>주문 수량변경 및 주문 전체취소 처리 내역</td>
    </tr>
    <tr>
        <td>{!! nl2br($order_info->od_mod_history) !!}</td>
    </tr>
</table>
-->


<table border=1>
    <tr>
        <td>주문결제 내역</td>
    </tr>
    <tr>
        <td>
            <table border=1>
                <tr>
                    <td>주문번호</td>
                    <td>결제방식</td>
                    <td>주문총액</td>
                    <td>배송비</td>
                    <td>포인트결제</td>
                    <td>실결제금액</td>
                    <td>주문취소금액</td>
                </tr>
                <tr>
                @php
                    if($order_info->de_send_cost_free == 0) $send_cost = $order_info->od_send_cost + $order_info->od_send_cost + $order_info->od_send_cost2;
                    else $send_cost = $order_info->od_send_cost + $order_info->od_send_cost2;
                @endphp
                    <td>{{ $order_info->order_id }}</td>
                    <td>{{ $order_info->od_settle_case }}</td>
                    <td>{{ number_format($order_info->od_receipt_price) }}</td>
                    <td>{{ number_format($send_cost) }}</td>
                    <td>{{ number_format($order_info->od_receipt_point) }}</td>
                    <td>{{ number_format($order_info->real_card_price) }}</td>
                    <td>{{ number_format($order_info->od_cancel_price) }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>



<table border=1>
    <tr>
        <td>메모</td>
    </tr>
    <tr>
        <td>
            <textarea name="od_shop_memo" id="od_shop_memo">{{ $order_info->od_shop_memo }}</textarea>
            <button type="button" onclick="shop_memo();">저장</button>
        </td>
    </tr>
</table>


<table border=1>
    <tr>
        <td>주문자 정보</td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>이름</td>
                    <td>{{ $mem_info->user_name }}</td>
                </tr>
                <tr>
                    <td>전화번호</td>
                    <td>{{ $mem_info->user_phone }}</td>
                </tr>
                <tr>
                    <td>아이디(이메일)</td>
                    <td>{{ $mem_info->user_id }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('/js/zip.js') }}"></script>


<table border=1>
    <form name="addrform" id="addrform" method="post" action="">
    {!! csrf_field() !!}
    <input type="hidden" name="num" value="{{ $order_info->id }}">
    <input type="hidden" name="order_id" value="{{ $order_info->order_id }}">

@php
    $ad_name_readonly = "";
    $ad_name_readonly = "";
    $ad_hp_readonly = "";
    $ad_button = "";
    $ad_addr2_readonly = "";
    $ad_addr3_readonly = "";
    $od_memo_readonly = "";
    $chang_button_readonly = "";

    if(trim($order_info->od_invoice) != "" || $order_info->od_status == "상품취소"){
        $ad_name_readonly = "readonly";
        $ad_hp_readonly = "readonly";
        $ad_button = "disabled";
        $ad_addr2_readonly = "readonly";
        $ad_addr3_readonly = "readonly";
        $od_memo_readonly = "readonly";
        $chang_button_readonly = "disabled";
    }
@endphp
    <tr>
        <td>이름</td>
        <td><input type="text" name="ad_name" id="ad_name" value="{{ stripslashes($order_info->ad_name) }}" {{ $ad_name_readonly }}></td>
    </tr>
    <tr>
        <td>전화번호</td>
        <td><input type="text" name="ad_hp" id="ad_hp" value="{{ $order_info->ad_hp }}" {{ $ad_hp_readonly }}></td>
    </tr>
    <tr>
        <td>우편번호</td>
        <td>
            <input type="text" name="ad_zip1" id="ad_zip1" value="{{ $order_info->ad_zip1 }}" readonly> <button type="button" class="btn_address adress_input03_btn" onclick="win_zip('wrap_order','ad_zip1', 'ad_addr1', 'ad_addr2', 'ad_addr3', 'ad_jibeon', 'btnFoldWrap_c');" {{ $ad_button }}>우편번호 찾기</button>

            <div id="wrap_order" class="adress_pop" style="height:100px;"><!-- 다음 우편번호 찾기  -->
                <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap_c" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" alt="접기 버튼">
            </div>
        </td>
    </tr>
    <tr>
        <td>주소</td>
        <td>
            <input type="text" name="ad_addr1" id="ad_addr1" required size="60" placeholder="기본주소" readonly value="{{ $order_info->ad_addr1 }}">
            <input type="text" name="ad_addr2" id="ad_addr2" size="60" placeholder="상세주소" value="{{ $order_info->ad_addr2 }}" {{ $ad_addr2_readonly }}>
            <input type="text" name="ad_addr3" id="ad_addr3" readonly="readonly" size="60" placeholder="참고항목" value="{{ $order_info->ad_addr3 }}" {{ $ad_addr3_readonly }}>
            <input type="hidden" name="ad_jibeon" id="ad_jibeon" value="{{ $order_info->ad_jibeon }}">
        </td>
    </tr>
    <tr>
        <td>배송메모</td>
        <td><input type="text" name="od_memo" id="od_memo" value="{{ stripslashes($order_info->od_memo) }}" {{ $od_memo_readonly }}></td>
    </tr>
    <tr>
        <td><button type="button" onclick="addr_change();" {{ $chang_button_readonly }}>변경</button></td>
    </tr>
</form>
</table>
















<script>
    function items_cancel(status){
        var msg = '상품취소 시 자동 환불 처리 되어 복구 할수 없습니다.';

        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?")) {
            new_pay_cancel('{{ $order_info->imp_uid }}', '{{ $order_info->order_id }}', '{{ $order_info->real_card_price }}');
        }
    }
</script>



<script>
    function shop_memo(){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_shop_memo') }}',
            data : {
                id : {{ $order_info->id }},
                order_id : {{ $order_info->order_id }},
                od_shop_memo : $("#od_shop_memo").val(),
            },
            dataType : 'text',
            success : function(result){
                if(result == "error"){
                    alert("잘못된 경로 입니다.");
                    return false;
                }

                if(result == "ok"){
                    location.reload();
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    function addr_change(){
        var form_var = $("#addrform").serialize();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_addr_change') }}',
            data : form_var,
            dataType : 'text',
            success : function(result){
                if(result == "error"){
                    alert("잘못된 경로 입니다.");
                    return false;
                }

                if(result == "ok"){
                    location.reload();
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>


<script>
    $("[class^='category-']").on('change', function()
    {
        $this_checkbox = $(this);
        var class_name = $this_checkbox.attr('class');
        var checked = $('[class="'+class_name+'"]').is(":checked");

        $("[class^='"+class_name+"']").prop('checked', checked );   // 하위요소 전부 체크or해제
        checkbox_checked(class_name, checked);
    });

    function checkbox_checked(class_name, checked )
    {
        if( class_name.indexOf('-') == -1) return;

        var parent_class_name = class_name.substr(0, class_name.lastIndexOf('-') );
        var friend_class = class_name.substr(0, (class_name.lastIndexOf('-') + 1) );

        if( checked )//체크일경우
        {
            var i=0;
            //var node = $('input:checkbox:regex(class,'+ friend_class + '[0-9]$)');
            var node = $("[class^='"+friend_class+"']");

            if( node.length == node.filter(":checked").length )
                $('.' + parent_class_name ).prop('checked', true );
        }
        else //해제일경우
        {
            $("[class^='"+class_name+"']").each( function(index, item)
            {
                var parent_class_name = class_name.substr(0, class_name.lastIndexOf('-') );//상위단원 class가져오기
                child_checked = $(this).is(':checked');
                if( !child_checked && parent_class_name != 'category')//하위단원을 체크 해제했을경우 상위단원 체크 해제 부분
                {
                    $('.'+parent_class_name).prop('checked', child_checked );
                    return false;
                }
            });
        }
        checkbox_checked(parent_class_name, checked )
    }
</script>

<script>
    function status_change(status){
        var msg = '';
        if(status == "상품취소" || status == "부분취소"){
            msg = status + '시 자동 환불 처리 되어 복구 할수 없습니다.';
        }else{
            msg = status + '상태를 선택하셨습니다.';
        }

        var check = false;
        for (i=0; i<$("#chk_cnt").val(); i++) {
            if($('#ct_chk_'+i).is(':checked') == true){
                check = true;
            }

            if($("#sct_qty_"+i).val() == ""){
                alert("수량을 입력 하세요.");
                $("#sct_qty_"+i).focus();
                return false;
            }
        }

        if (check == false) {
            alert("처리할 자료를 하나 이상 선택해 주십시오.");
            return false;
        }

        switch (status) {
            case '부분취소':
                var route_link = '{{ route('ajax_orderqtyprocess') }}';
                break;
            case '상품취소':
                var route_link = '{{ route('ajax_orderitemprocess') }}';
                break;
        }

        if (confirm(msg + "\n선택하신대로 처리하시겠습니까?")) {
            //return true;
            $("#sct_status").val(status);
            //$("#orderdetailform").submit();

            var form_var = $("#orderdetailform").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: 'post',
                url: route_link,
                dataType: 'text',
                data: form_var,
                success: function(result) {
//alert(result);
//return false;
                    var data = JSON.parse(result);
//alert(data.amount);
//return false;
                    if(data.message == 'no_number'){
                        alert('수량을 입력 하세요.');
                        return false;
                    }

                    if(data.message == 'all_cancel'){
                        alert("처리할 자료를 하나 이상 선택해 주십시오.");
                        //alert('전체 주문 취소 상태 입니다.');
                        //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
                        return false;
                    }

                    if(data.message == 'no_order'){
                        alert('해당 주문번호로 주문서가 존재하지 않습니다.');
                        location.href = "{!! route('orderlist', $page_move) !!}"
                        return false;
                    }

                    if(data.message == 'qty_big'){
                        alert('주문 수량 보다 크게 입력 할수 없습니다.');
                        location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
                        return false;
                    }

                    if(data.message == 'no_qty'){
                        alert("처리할 수량을 변경해 주십시오.");
                        return false;
                    }

                    if(data.message == 'no_cancel'){
                        alert('무료 기본 배송비 이하 상품입니다.\n전체 취소를 선택 하세요.');
                        return false;
                    }

                    if(data.message == 'pay_cancel'){
                        pay_cancel('{{ $order_info->imp_uid }}', '{{ $order_info->order_id }}', data.amount, data.custom_data, status);
                    }

                },error: function(result) {
                    console.log(result);
                }
            });
        } else {
            return false;
        }
    }
</script>

<!-- 환불 처리 -->
<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    function pay_cancel(imp_uid, order_id, amount, custom_data, status){
        switch (status) {
            case '부분취소':
                var route_link = '{{ route('ajax_admorderqtypaycancel') }}';
                break;
            case '상품취소':
                var route_link = '{{ route('ajax_admorderitempaycancel') }}';
                break;
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : route_link,
            type : 'post',
            contentType : "application/json",
            data    : JSON.stringify({
                "imp_uid"               : imp_uid,
                "merchant_uid"          : order_id, // 예: ORD20180131-0000011
                "cancel_request_amount" : amount, // 환불금액
                //"reason"                : "부분환불", // 환불사유
                "reason"                : "주문취소", // 환불사유
                "custom_data"           : custom_data,  //필요 데이터
                "refund_holder"         : "{{ $order_info->od_deposit_name }}", // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank"           : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(예: KG이니시스의 경우 신한은행은 88번)
                "refund_account"        : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            dataType : "text",
        }).done(function(result) { // 환불 성공시 로직
//alert(result);
//return false;

            if(result == 'no_cancel'){
                alert('무료 기본 배송비 이하 상품입니다.\n전체 취소를 선택 하세요.');
                return false;
            }

            if(result == "exception"){
                alert("취소된 상품이 있어 전체 처리 할수 없습니다.");
                location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

            if(result == "ok"){
                alert("취소 처리 되었습니다.");
                location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

            if(result == "error"){
                alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-1");
                //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

        }).fail(function(error) { // 환불 실패시 로직
            alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-2");
            //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
        });
    }
</script>

<script>
    function new_pay_cancel(imp_uid, order_id, amount){
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : '{{ route('ajax_itemspaycancel') }}',
            type : 'post',
            contentType : "application/json",
            data    : JSON.stringify({
                "imp_uid"               : imp_uid,
                "merchant_uid"          : order_id, // 예: ORD20180131-0000011
                "cancel_request_amount" : amount, // 환불금액
                "reason"                : "환불", // 환불사유
                "custom_data"           : '',  //필요 데이터
                "refund_holder"         : "{{ $order_info->od_deposit_name }}", // [가상계좌 환불시 필수입력] 환불 수령계좌 예금주
                "refund_bank"           : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 은행코드(예: KG이니시스의 경우 신한은행은 88번)
                "refund_account"        : "", // [가상계좌 환불시 필수입력] 환불 수령계좌 번호
            }),
            dataType : "text",
        }).done(function(result) { // 환불 성공시 로직
//alert(result);
//return false;
            if(result == "ok"){
                alert("주문취소 처리 되었습니다.");
                location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

            if(result == "error"){
                alert("주문취소가 실패 하였습니다. 관리자에게 문의 하세요.-1");
                //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
            }

        }).fail(function(error) { // 환불 실패시 로직
            alert("주문 상품 취소가 실패 하였습니다. 관리자에게 문의 하세요.-2");
            //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
        });
    }
</script>

<script>
    function return_item(){
        var msg = '';
        msg = '교환 상태를 선택하셨습니다.';

        var check = false;
        for (i=0; i<$("#chk_cnt").val(); i++) {
            if($('#ct_chk_'+i).is(':checked') == true){

                if($("#sct_qty_"+i).val() == ""){
                    alert("수량을 입력 하세요.");
                    $("#sct_qty_"+i).focus();
                    return false;
                }

                check = true;
            }
        }

        if (check == false) {
            alert("처리할 자료를 하나 이상 선택해 주십시오.");
            return false;
        }

        var route_link = '{{ route('ajax_return_process') }}';
        if (confirm(msg + "\n\n선택하신대로 처리하시겠습니까?")) {
            $("#sct_status").val(status);
            var form_var = $("#orderdetailform").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: 'post',
                url: route_link,
                dataType: 'text',
                data: form_var,
                success: function(result) {
//alert(result);
//return false;
                    if(result == 'big_qty'){
                        alert("주문 수량 보다 교환 수량이 클수 없습니다\n수량을 확인 하세요");
                        return false;
                    }

                    if(result == 'all_cancel'){
                        alert("처리할 자료를 하나 이상 선택해 주십시오.");
                        //alert('전체 주문 취소 상태 입니다.');
                        //location.href = "{!! route('orderdetail', 'order_id='.$order_info->order_id.'&'.$page_move) !!}";
                        return false;
                    }

                    if(result == 'no_order'){
                        alert('해당 주문번호로 주문서가 존재하지 않습니다.');
                        location.href = "{!! route('orderlist', $page_move) !!}"
                        return false;
                    }

                    if(result == 'ok'){
                        alert('교환 처리 되었습니다');
                        location.reload();
                        return false;
                    }

                },error: function(result) {
                    console.log(result);
                }
            });
        } else {
            return false;
        }
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
        document.querySelector('.modal.modal_001').classList.add('in');
    }
    function closemodal_002(){
        closeModal();
        document.querySelector('.modal.modal_001').classList.remove('in');
    }
    function openmodal_003() {
        openModal();
        document.querySelector('.modal.modal_003').classList.add('in');
    }
    function closemodal_003(){
        closeModal();
        document.querySelector('.modal.modal_003').classList.remove('in');
    }
</script>



@endsection
