@extends('layouts.head')

@section('content')

<script src="{{ asset('/js/shop_js/shop.js') }}"></script>
<script src="{{ asset('/js/shop_js/shop_override.js') }}"></script>

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('cartlist') }}">장바구니</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>장바구니</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 고객센터 시작  -->
        <div class="eval">
<form name="frmcartlist" id="sod_bsk_list" method="post" action="{{ route('ajax_cart_register') }}">
{!! csrf_field() !!}
<input type="hidden" name="ajax_option_url" id="ajax_option_url" value="{{ route('ajax_option_change') }}">
<input type="hidden" id="cart_type" value="new_cart">
            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="cart_list">

                        <div class="chek">
                            <label for="">
                                <input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked">
                                  <span>전체선택(2/2)</span>
                            </label>
                            <button class="btn-bg-mint">선택삭제</button>
                        </div>


                        <div class="cart_tt">
                            <ul>
                                <li>상품정보</li>
                                <li>상품정보</li>
                                <li>상품금액</li>
                            </ul>
                        </div>


                        <div class="cot_list">
                            @php
                                $i = 0;
                            @endphp
                            @foreach($cart_infos as $cart_info)
                                @php
                                    $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where item_code = '{$cart_info->item_code}' and od_id = '$s_cart_id' ");

                                    if ($num == 0) { // 계속쇼핑
                                        $continue_ca_id = $cart_info->sca_id;
                                    }

                                    //이미지
                                    $image_url = $CustomUtils->get_item_image($cart_info->item_code, 3);

                                    //제조사
                                    if($cart_info->item_manufacture == "") $item_manufacture = "";
                                    else $item_manufacture = "[".$cart_info->item_manufacture."]";

                                    //제목
                                    $item_name = $item_manufacture.stripslashes($cart_info->item_name);

                                    //옵션 처리
                                    //$item_options = $CustomUtils->new_print_item_options($cart_info->id, $cart_info->item_code, $s_cart_id);
                                    $item_options = DB::table('shopcarts')->select('sct_option', 'sct_qty', 'sio_price')->where([['id', $cart_info->id], ['item_code', $cart_info->item_code], ['od_id',$s_cart_id]])->first();

                                    if(!$cart_info->sio_id) $it_stock_qty = $CustomUtils->get_item_stock_qty($cart_info->item_code);
                                    else $it_stock_qty = $CustomUtils->get_option_stock_qty($cart_info->item_code, $cart_info->sio_id, $cart_info->sio_type);
/*
                                    if($item_options->sio_price > 0) {
                                        //$str .= '<tr><td>옵션 : '.$item_option->sct_option.' '.$item_option->sct_qty.'개 ('.$price_plus.$this->display_price($item_option->sio_price).')</td></tr>'.PHP_EOL;
                                        $sct_option = $item_option->sct_option;
                                        $sct_qty = $item_option->sct_qty;
                                    }else{
                                        $str .= '<tr><td>'.$item_option->sct_option.' '.$item_option->sct_qty.'개'.'</td></tr>'.PHP_EOL;
                                    }
*/
/*
                                    if($item_options) {
                                        //$mod_options = '<tr><td><div class="sod_option_btn"><button type="button" class="mod_options">선택사항수정</button></div></td></tr>';
                                        //$item_name .= '<div class="sod_opt">'.$item_options.'</div>';
                                    }
*/
                                    // 배송비
                                    $sendcost = $CustomUtils->get_item_sendcost($cart_info->item_code, $sum[0]->price, $sum[0]->qty, $s_cart_id);

                                    if($sendcost == 0) $ct_send_cost = '무료';
                                    else $ct_send_cost = number_format($sendcost).'원';

                                    $point      = $sum[0]->point;
                                    $sell_price = $sum[0]->price;
                                    $tmp_sendcost = $sendcost;

                                @endphp
                            <div class="cot_body">
                                <div class="cart">
                                    <div class="cart_inner">
                                        <ul class="cart_list_img">
                                            <li><input type="checkbox" name="ct_chk[{{ $num }}]" value="1" id="ct_chk_{{ $num }}" checked="checked"></li>
                                            <li><a href="{{ route('sitemdetail','item_code='.$cart_info->item_code) }}"><img src="{{ asset($image_url) }}"></a></li>
                                        </ul>

                                        <ul class="cart_list_tt">
                                           <h5><a href="{{ route('sitemdetail','item_code='.$cart_info->item_code) }}">{!! $item_name !!}</a></h5>
                                           <ul class="c_s_tt">
                                                <li class="price cr_07">30%</li>
                                                <li class="price">6,000원</li>
                                                <li class="sale-price">6,000원</li>
                                            </ul>
                                        </ul>

                                    </div>

                                    <div class="cart_inner_01">
                                        <ul class="cart_list_op">
                                            <li>
                                            @if($item_options->sio_price > 0)
                                            {{ $item_options->sct_option }}
                                            @endif
                                            </li>
                                            <li>
                                                <button type="button" onclick="new_sel_option('{{ $cart_info->id }}', '+')">+</button>
                                                    <input type="text" name="ct_qty[{{ $cart_info->id }}][]" value="{{ $item_options->sct_qty }}" id="ct_qty_{{ $i }}" size="5" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                <button type="button">-</button>
                                            </li>
                                        </ul>

                                        <ul class="cart_list_pr block">
                                        <input type="hidden" name="sio_type[{{ $cart_info->id }}][]" value="{{ $cart_info->sio_type }}">
                                        <input type="hidden" name="sio_id[{{ $cart_info->id }}][]" value="{{ $cart_info->sio_id }}">
                                        <input type="hidden" name="sio_value[{{ $cart_info->id }}][]" value="{{ $cart_info->sct_option }}">
                                        <input type="hidden" class="sio_price_{{ $cart_info->id }}" value="{{ $cart_info->sio_price }}">
                                        <input type="hidden" class="sio_stock_{{ $cart_info->id }}" value="{{ $it_stock_qty }}">
                                        <input type="hidden" id="item_price_{{ $cart_info->id }}" value="{{ $cart_info->item_price }}">
                                            <li class="">7,000원</li>
                                            <li><button class="btn-sd">구매하기</button></li>
                                            <li><span>삭제</span></li>
                                        </ul>

                                        <ul class="cart_list_pr_m none">
                                            <li class="">7,000원</li>

                                            <li>
                                                <button class="btn-50">삭제</button>
                                                <button class="btn-50">구매하기</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                            @endforeach























                        </div>


                        <div class="ct_tot">
                            <ul>
                                <li>총 상품금액</li>
                                <li>18,000</li>
                            </ul>
                            <ul>
                                <li>할인예정금액</li>
                                <li>-6,000</li>
                            </ul>
                            <ul>
                                <li>배송비</li>
                                <li>2,500</li>
                            </ul>
                            <ul class="ct_tot_p">
                                <li>총 결제 금액</li>
                                <li>14,500</li>
                            </ul>
                        </div>


                        <div class="list_sol_bk"></div>


                        <div class="ct_btn">
                            <button class="btn-50">쇼핑 계속하기</button>
                            <button class="btn-50-bg">전체 구매하기</button>
                        </div>

                    </div>

                </div>
                <!-- 고객센터 끝  -->
</form>
            </div>
        </div>
    </div>
    <!-- 서브 컨테이너 끝 -->



















<table border=1>
    <tr>
        <td><h4>장바구니</h4></td>
    </tr>
</table>

<form name="frmcartlist" id="sod_bsk_list" method="post" action="{{ route('ajax_cart_register') }}">
{!! csrf_field() !!}
<input type="hidden" name="ajax_option_url" id="ajax_option_url" value="{{ route('ajax_option_change') }}">
<table border=1>
    <tr>
        <td><input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked"></td>
        <td>상품명</td>
        <td>총수량</td>
        <td>판매가</td>
        <td>상품별배송비</td>
        <td>주문금액</td>
    </tr>

    @php
        $tot_point = 0;
        $tot_sell_price = 0;
        $send_cost = 0;
        $tot_send_cost = 0;
    @endphp

    @foreach($cart_infos as $cart_info)
        @php
            $sum = DB::select("select SUM(IF(sio_type = 1, (sio_price * sct_qty), ((sct_price + sio_price) * sct_qty))) as price, SUM(sct_point * sct_qty) as point, SUM(sct_qty) as qty from shopcarts where item_code = '{$cart_info->item_code}' and od_id = '$s_cart_id' ");

            if ($num == 0) { // 계속쇼핑
                $continue_ca_id = $cart_info->sca_id;
            }

            //이미지
            $image_url = $CustomUtils->get_item_image($cart_info->item_code, 3);

            //제목
            $item_name = stripslashes($cart_info->item_name);

            //옵션 처리
            $item_options = $CustomUtils->print_item_options($cart_info->item_code, $s_cart_id);

            if($item_options) {
                $mod_options = '<tr><td><div class="sod_option_btn"><button type="button" class="mod_options">선택사항수정</button></div></td></tr>';
                $item_name .= '<div class="sod_opt">'.$item_options.'</div>';
            }

            // 배송비
            $sendcost = $CustomUtils->get_item_sendcost($cart_info->item_code, $sum[0]->price, $sum[0]->qty, $s_cart_id);

            if($sendcost == 0) $ct_send_cost = '무료';
            else $ct_send_cost = number_format($sendcost).'원';

            $point      = $sum[0]->point;
            $sell_price = $sum[0]->price;
            $tmp_sendcost = $sendcost;

        @endphp
    <tr>
        <td><input type="checkbox" name="ct_chk[{{ $num }}]" value="1" id="ct_chk_{{ $num }}" checked="checked"></td>
        <td>
            <table border=1>
                <tr>
                    <td><a href="{{ route('sitemdetail','item_code='.$cart_info->item_code) }}"><img src="{{ asset($image_url) }}"></a></td>
                    <td>
                        <table>
                            <tr>
                                <td>
                    <input type="hidden" name="item_code[{{ $num }}]" id="item_code{{ $num }}" value="{{ $cart_info->item_code }}">
                    <input type="hidden" name="item_name[{{ $num }}]" id="item_name{{ $num }}" value="{{ $cart_info->item_name }}">
                                    <a href="{{ route('sitemdetail','item_code='.$cart_info->item_code) }}">{!! $item_name !!}</a>
                                    {!! $mod_options !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td>{{ number_format($sum[0]->qty) }}</td>
        <td>{{ number_format($cart_info->sct_price) }}</td>
        <td>{{ $ct_send_cost }}</td>
        <td><span id="sell_price_{{ $num }}" class="total_prc">{{ number_format($sell_price) }}</span></td>
    </tr>
        @php
            $num++;
            $tot_point      += $point;
            $tot_sell_price += $sell_price;
            $tot_send_cost  += $tmp_sendcost;
        @endphp

    @endforeach

    @php

        if ($num == 0) {
            echo '<tr><td colspan="7" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
        } else {
            // 배송비 계산
            $send_cost = $CustomUtils->get_sendcost($s_cart_id, 0);
        }
    @endphp
</table>

@if($num > 0)
<table border=1>
    <tr>
        <button type="button" onclick="return form_check('seldelete');">선택삭제</button>
        <button type="button" onclick="return form_check('alldelete');">비우기</button>
    </tr>
</table>
@endif

@php
    //배송비 무료 정책
    if($tot_sell_price >= $de_send_cost_free){
        $tot_price = $tot_sell_price + $tot_send_cost; // 총계 = 주문상품금액합계 + 상품별배송비
        $free_type = '주문금액 '.number_format($de_send_cost_free).' 원 이상 기본 배송비 무료';
    }else{
        $tot_price = $tot_sell_price + $de_send_cost + $tot_send_cost; // 총계 = 주문상품금액합계 + 기본배송비 + 상품별배송비
        $free_type = number_format($de_send_cost).' 원';
    }
@endphp

@if ($tot_price > 0 || $tot_send_cost > 0 || $de_send_cost > 0)
<table border=1>
    <tr>
        <td>주문금액</td>
        <td><strong>{{ number_format($tot_sell_price) }} </strong> 원</td>
        @if($de_send_cost > 0)
        <td>기본배송비</td>
        <td><strong>{{ $free_type  }}</strong></td>
        @endif

        @if($tot_send_cost > 0)
        <td>상품별배송비</td>
        <td><strong>{{ number_format($tot_send_cost)  }}</strong> 원</td>
        @endif

        <td>총계 가격</td>
        <td><strong>{{ number_format($tot_price) }}</strong> 원</td>
    </tr>
</table>
@endif


<table>
    <tr>
        <td>
@if($num == 0)
            <a href="{{ route('index') }}" class="btn01">쇼핑 계속하기</a>
@else
            <table>
                <tr>
                    <td>
                        <input type="hidden" name="url" value="./orderform.php">
                        <input type="hidden" name="records" value="{{ $num }}">
                        <input type="hidden" name="act" id="act" value="">
                        <a href="{{ route('sitem','ca_id='.$continue_ca_id) }}">쇼핑 계속하기</a>
                        <button type="button" onclick="return form_check('buy');" class="btn_submit">주문하기</button>
                    </td>
                </tr>
            </table>
@endif

        </td>
    </tr>
</table>
</form>


<script>
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        //var item_code = $(this).closest("tr").find("input[name^=item_code]").val();
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));
        var item_code = $("#item_code"+close_btn_idx).val();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_choice_option_modify') }}',
            data : {
                item_code : item_code,
            },
            dataType : 'text',
            success : function(result){
//alert(result);
                if(result == "no_item"){
                    alert("상품이 없습니다.");
                }

                if(result == "no_cart"){
                    alert("장바구니에 상품이 없습니다.");
                }

                $("#mod_option_frm").remove();
                $this.after("<div id=\"mod_option_frm\"></div><div class=\"mod_option_bg\"></div>");
                $("#mod_option_frm").html(result);
                price_calculate();
            },
            error: function(result){
                console.log(result);
            },
        });
    });

    // 모두선택
    $("input[name=ct_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=ct_chk]").attr("checked", true);
        else
            $("input[name^=ct_chk]").attr("checked", false);
    });

    // 옵션수정 닫기
    $(document).on("click", "#mod_option_close", function() {
        $("#mod_option_frm, .mod_option_bg").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });

});

function fsubmit_check(f) {
    if($("input[name^=ct_chk]:checked").length < 1) {
        alert("구매하실 상품을 하나이상 선택해 주십시오.");
        return false;
    }

    return true;
}

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if (act == "buy")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("주문하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        $("#act").val(act);
        var form_var = $("form[name=frmcartlist]").serialize() ;
        $.ajax({
            type : 'post',
            url : '{{ route('ajax_cart_register') }}',
            data : form_var,
            dataType : 'text',
            success : function(result){
//alert(result);
//return false;
                var json = JSON.parse(result);
//alert(json.message);

                if(json.message == "discontinued"){
                    alert(json.option + " 상품은 판매 중단 되었습니다.");
                    return false;
                }

                if(json.message == "no_item"){
                    alert("주문하실 상품을 하나이상 선택해 주십시오.");
                    return false;
                }

                if(json.message == "no_qty"){
                    alert(json.option + " 의 재고수량이 부족합니다.\n\n현재 재고수량 : " + json.sum_qty + " 개");
                    return false;
                }

                if(json.message == "mem_order"){  //회원 주문
                    location.href = "{{ route('orderform') }}";
                }

                if(json.message == "no_mem_order"){  //비회원 주문
                    location.href = "{{ route('login.index','url='.urlencode(route('orderform'))) }}";
                }

//return false;
            },
            error: function(result){
                var json = JSON.parse(result);
                console.log(json.result);
            },
        });


//        f.act.value = act;
//        f.submit();
    }
    else if (act == "alldelete")
    {
        if (confirm("정말 비우시겠습니까?") == true){    //확인
            $("#act").val(act);

            var form_var = $("form[name=frmcartlist]").serialize() ;
            $.ajax({
                type : 'post',
                url : '{{ route('ajax_cart_register') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
//alert(result);
                    var json = JSON.parse(result);

                    if(json.message == "cart_page"){
                        location.href = "{{ route('cartlist') }}";
                    }
                },
                error: function(result){
                    var json = JSON.parse(result);
                    console.log(json.result);
                },
            });
        }
        //f.submit();
    }
    else if (act == "seldelete")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("삭제하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            $("#act").val(act);

            var form_var = $("form[name=frmcartlist]").serialize() ;
            $.ajax({
                type : 'post',
                url : '{{ route('ajax_cart_register') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
                    var json = JSON.parse(result);
    //alert(result);
    //return false;
                    if(json.message == "no_cnt"){
                        alert("삭제하실 상품을 하나이상 선택해 주십시오.");
                        return false;
                    }

                    if(json.message == "cart_page"){
                        location.href = "{{ route('cartlist') }}";
                    }
                },
                error: function(result){
                    var json = JSON.parse(result);
                    console.log(json.result);
                },
            });
        }else{
            return false;
        }
    }
}
</script>



@endsection
