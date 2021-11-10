@extends('layouts.shophead')

@section('content')

<script src="{{ asset('/js/shop_js/shop.js') }}"></script>
<script src="{{ asset('/js/shop_js/shop_override.js') }}"></script>

<table border="1">
    @if($is_orderable == false)
    <tr>
        <td>본상품은 품절 되었습니다.</td>
    </tr>
    @endif

    <tr>
        <td>
            <table border=1>
                <tr>
                    <td colspan="10">
                        <table>
                            <tr>
                                <td><img src="{{ $big_img_disp }}" id="big_img"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    @php
                        $m = 1;
                    @endphp

                    @if(count($small_img_disp) > 0)
                        @for($k = 0; $k < count($small_img_disp); $k++)
                    <td><img src="{{ $small_img_disp[$k] }}" onMouseover="ajax_big_img_change('{{ $item_info->item_code }}','{{ $small_item_img[$k] }}');"></td>
                            @if($m % 5 == 0)
                                </tr>
                                <tr>
                            @endif
                            @php
                                $m++;
                            @endphp
                        @endfor
                    @endif

                </tr>
            </table>
        </td>
        <td>


<form name="fitem" id="fitem" method="post" action="{{ route('ajax_cart_register') }}">
{!! csrf_field() !!}
<input type="hidden" name="item_code[]" value="{{ $item_info->item_code }}">
<input type="hidden" name="ajax_option_url" id="ajax_option_url" value="{{ route('ajax_option_change') }}">
<input type="hidden" name="sw_direct" id="sw_direct">
<input type="hidden" name="url" id="url">

            <table border=1 class="renewal_itemform">
                <tr>
                    <td colspan="2"><b>{{ stripslashes($item_info->item_name) }}</b></td>
                </tr>

                @if($item_info->item_basic != "")
                <tr>
                    <td colspan="2">{{ $item_info->item_basic }}</td>
                </tr>
                @endif

                @if($item_info->item_use != 1)
                <!-- 판매 가능이 아닐때 -->
                <tr>
                    <td>판매가격</td>
                    <td>판매중지</td>
                </tr>

                @elseif($item_info->item_tel_inq == 1)
                <!-- 전화문의일 경우 -->
                <tr>
                    <td>판매가격</td>
                    <td>전화문의</td>
                </tr>
                @else
                <!-- 전화문의가 아닐 경우 -->
                    @php
                        $discount = 0;
                        $discount_rate = 0;
                        $disp_discount_rate = 0;
                    @endphp

                    @if($item_info->item_cust_price != "0")
                        @php
                            if($item_info->item_cust_price > 0){
                                //시중가격 값이 있을때 할인율 계산
                                $discount = (int)$item_info->item_cust_price - (int)$item_info->item_price; //할인액
                                $discount_rate = ($discount / (int)$item_info->item_cust_price) * 100;  //할인율
                                $disp_discount_rate = round($discount_rate);    //반올림
                            }
                            //시중 가격이 0이 아니거나 시중가격과 판매가격이 다를때 시중가격표시
                        @endphp
                        @if($item_info->item_cust_price > 0 || $item_info->item_cust_price != $item_info->item_price)
                <tr>
                    <td>시중가격</td>
                    <td>{{ $CustomUtils->display_price($item_info->item_cust_price) }}</td>
                </tr>
                        @endif
                    @endif

                <tr>
                    <td>판매가격</td>
                    <td>
	                    <strong>{{ $CustomUtils->display_price($item_info->item_price) }}</strong>
                        @if($disp_discount_rate != 0)
                        ({{ $disp_discount_rate }}% 할인)
                        @endif
	                    <input type="hidden" id="item_price" value="{{ $item_info->item_price }}">
                    </td>
                </tr>
                @endif

                @if($item_info->item_manufacture != "")
                <tr>
                    <td>제조사</td>
                    <td>{{ $item_info->item_manufacture }}</td>
                </tr>
                @endif

                @if($item_info->item_point != "0")
                <tr>
                    <td>적립금</td>
                    <td>{{ $item_info->item_point }}%</td>
                </tr>
                @endif

                @if($item_info->item_origin != "")
                <tr>
                    <td>원산지</td>
                    <td>{{ $item_info->item_origin }}</td>
                </tr>
                @endif

                @if($item_info->item_brand != "")
                <tr>
                    <td>브랜드</td>
                    <td>{{ $item_info->item_brand }}</td>
                </tr>
                @endif

                @if($item_info->item_model != "")
                <tr>
                    <td>모델</td>
                    <td>{{ $item_info->item_model }}</td>
                </tr>
                @endif

                @if($de_send_cost > 0)
                <tr>
                    <td>기본배송비</td>
                    <td>{{ number_format($de_send_cost) }} 원</td>
                </tr>
                @endif
                <tr>
                    <td>상품별배송비</td>
                    <td>{!! $sc_method_disp !!}</td>
                </tr>

                @if($is_orderable)
                <tr>
                    <td colspan=2>
                        <table border=1 style="width:100%">
                            @if($option_item)

                            <tr>
                                <td>선택옵션</td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="sit_option">
                                        <tr>
                                            <td>
                                                {!! $option_item !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endif

                            @if($supply_item)
                            <tr>
                                <td>추가옵션</td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="sit_option">
                                        <tr>
                                            <td>
                                                {!! $supply_item !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endif

                            <tr>
                                <td>
                                    <!-- 선택된 옵션 시작 { -->
                                    <section id="sit_sel_option">
                                        @if(!$option_item)
                                        <!-- 선택 옵션이 없을때 처리 -->
                                        <ul id="sit_opt_added">
                                            <li class="sit_opt_list">
                                                <input type="hidden" name="sio_type[{{ $item_info->item_code }}][]" value="0">
                                                <input type="hidden" name="sio_id[{{ $item_info->item_code }}][]" value="">
                                                <input type="hidden" name="sio_value[{{ $item_info->item_code }}][]" value="{{ $item_info->item_name }}">
                                                <input type="hidden" class="sio_price" value="0">
                                                <input type="hidden" class="sio_stock" value="{{ $item_info->item_stock_qty}}">
                                                <div class="opt_name">
                                                    <span class="item_opt_subj">{{ $item_info->item_name }}</span>
                                                </div>
                                                <div class="opt_count">
                                                    <label for="ct_qty_11" class="sound_only">수량</label>
                                                    <button type="button" class="sit_qty_minus"><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">감소</span></button>
                                                    <input type="text" name="ct_qty[{{ $item_info->item_code }}][]" value="1" id="ct_qty_11" class="num_input" size="5" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                                    <button type="button" class="sit_qty_plus"><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">증가</span></button>
                                                    <span class="sit_opt_prc"></span>
                                                </div>
                                            </li>
                                        </ul>

                                        <script>
                                            $(function() {
                                                price_calculate();
                                            });
                                        </script>
                                        @endif

                                    </section>
                                    <!-- } 선택된 옵션 끝 -->

                                    <!-- 총 구매액 -->
                                    <div id="sit_tot_price"></div>

                                </td>
                            </tr>

                            @if(Auth::user())
                                @if($item_info->item_del == 'N')
                            <tr>
                                <td>
                                    <button type="button" onclick="fitem_submit('cart');">장바구니</button>
                                    <button type="button" onclick="fitem_submit('buy');">바로구매</button>
                                    <span onclick="item_wish('{{ $item_info->item_code }}');">위시리스트(하트)</span>
                                    <span>쇼셜 링크 작업 해야함</span>
                                </td>
                            </tr>
                                @endif
                            @endif

                        </table>
                    </td>
                </tr>
                @endif

            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table border=1>
                <tr>
                    <td>상품정보</td>
                </tr>
                <tr>
                    <td>{!! $item_info->item_content !!}</td>
                </tr>
            </table>
        </td>
    </tr>
</form>
</table>



<script>
    function ajax_big_img_change(item_code, item_img){
        $.ajax({
            type: 'get',
            url: '{{ route('ajax_big_img_change') }}',
            dataType: 'text',
            data: {
                'item_code' : item_code,
                'item_img'  : item_img,
            },
            success: function(result) {
                $("#big_img").attr("src", result);
            },error: function(result) {
                console.log(result);
            }
        });
    }
</script>


<script>
    // 바로구매, 장바구니 폼 전송
    function fitem_submit(type)
    {
        if (type == "cart") {   //장바구니
            $("#sw_direct").val(0);
        } else { // 바로구매
            $("#sw_direct").val(1);
        }

        if($(".sit_opt_list").length < 1) {
            alert("상품의 선택옵션을 선택해 주십시오.");
            return false;
        }

        var val, io_type, result = true;
        var sum_qty = 0;
        var $el_type = $("input[name^=sio_type]");

        $("input[name^=ct_qty]").each(function(index) {
            val = $(this).val();

            if(val.length < 1) {
                alert("수량을 입력해 주십시오.");
                result = false;
                return false;
            }

            if(val.replace(/[0-9]/g, "").length > 0) {
                alert("수량은 숫자로 입력해 주십시오.");
                result = false;
                return false;
            }

            if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
                alert("수량은 1이상 입력해 주십시오.");
                result = false;
                return false;
            }

            sio_type = $el_type.eq(index).val();

            if(sio_type == "0") sum_qty += parseInt(val);
        });

        if(!result) {
            return false;
        }

        var form_var = $("form[name=fitem]").serialize() ;

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
//return false;
                if(json.message == "no_carts"){
                    alert("장바구니에 담을 상품을 선택하여 주십시오.");
                    return false;
                }

                if(json.message == "no_option"){
                    alert("상품의 선택옵션을 선택해 주십시오.");
                    return false;
                }

                if(json.message == "no_cnt"){
                    alert("수량은 1 이상 입력해 주십시오.");
                    return false;
                }

                if(json.message == "no_items"){
                    alert("상품정보가 존재하지 않습니다.");
                    return false;
                }

                if(json.message == "negative_price"){
                    alert("구매금액이 음수인 상품은 구매할 수 없습니다.");
                    return false;
                }

                if(json.message == "no_qty"){
                    alert(json.option + " 의 재고수량이 부족합니다.\n\n현재 재고수량 : " + json.sum_qty + " 개 이며\n\n이미 장바구니에 담겨 있습니다. ");
                    return false;
                }

                if(json.message == "no_qty2"){
                    alert(json.option + " 의 재고수량이 부족합니다.\n\n현재 재고수량 : " + json.sum_qty + " 개 이며\n\n이미 장바구니에 담겨 있습니다. ");
                    return false;
                }

                if(json.message == "yes_mem"){
                    location.href = "{{ route('orderform','sw_direct=1') }}";
                }

                if(json.message == "no_mem"){
                    //goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/orderform.php?sw_direct=$sw_direct"));
                    location.href = "";
                }

                if(json.message == "cart_page"){
                    location.href = "{{ route('cartlist') }}";
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    // wish 상품보관
    function item_wish(item_code)
    {
        $.ajax({
            type: 'get',
            url: '{{ route('ajax_wish') }}',
            dataType: 'text',
            data: {
                'item_code' : item_code,
            },
            success: function(result) {
//alert(result);
//return false;
                if(result == "no_item"){
                    alert('해당 상품이 존재 하지 않습니다.');
                    return false;
                }
            },error: function(result) {
                console.log(result);
            }
        });
    }
</script>



@endsection
