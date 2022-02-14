@extends('layouts.admhead')

@section('content')


<!-- smarteditor2 사용 -->
<script type="text/javascript" src="/smarteditor2/js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smarteditor2 사용 -->



<table>
    <tr>
        <td><h4>상품 수정</h4></td>
    </tr>
</table>

<form name="item_form" id="item_form" method="post" action="{{ route('shop.item.modifysave') }}" enctype='multipart/form-data'>
{!! csrf_field() !!}
<input type="hidden" name="id" id="num" value="{{ $item_info->id }}">
<input type="hidden" name="ca_id" id="ca_id">
<input type="hidden" name="length" id="length">
<input type="hidden" name="last_choice_ca_id" id="last_choice_ca_id" value="{{ $item_info->sca_id }}">
<input type="hidden" name="item_code" id="item_code" value="{{ $item_info->item_code }}">
<input type="hidden" name="file_num" id="file_num">
<input type="hidden" name="page" id="page" value="{{ $page }}">
<input type="hidden" name="item_search" id="item_search" value="{{ $item_search }}">
<input type="hidden" name="keyword" id="keyword" value="{{ $keyword }}">
<input type="hidden" name="item_use" id="item_use" value="1">
<input type="hidden" name="item_point" id="item_point" value="{{ $item_point }}">

<table border=1 width="900px;">
    <tr>
        <td colspan=5>
            카테고리 선택
        </td>
    </tr>
    <tr>
        <td >
            <table>
                <tr>
                    <td>
                        <table id="cate1">
                        <tr>
                            <td>
                                <select size="10" name="ca_id" id="caa_id" class="cid" >
                                @foreach($one_step_infos as $one_step_info)
                                    @php
                                        if($one_str_cut == $one_step_info->sca_id) $one_selected = "selected";
                                        else $one_selected = "";
                                    @endphp

                                    <option value="{{ $one_step_info->sca_id }}" {{ $one_selected }}>{{ $one_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                        <tr>
                        </table>
                    </td>

                    <td>
                        <table id="cate2" style="display:block">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 4)
                            <td>
                                <select size="10" name="ca_id" id="caa_id2" class="cid" >
                                @foreach($two_step_infos as $two_step_info)
                                    @php
                                        if($two_str_cut == $two_step_info->sca_id) $two_selected = "selected";
                                        else $two_selected = "";
                                    @endphp

                                    <option value="{{ $two_step_info->sca_id }}" {{ $two_selected  }}>{{ $two_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>

                    <td>
                        <table id="cate3" style="display:block">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 6)
                            <td>
                                <select size="10" name="ca_id" id="caa_id3" class="cid" >
                                @foreach($three_step_infos as $three_step_info)
                                    @php
                                        if($three_str_cut == $three_step_info->sca_id) $three_selected = "selected";
                                        else $three_selected = "";
                                    @endphp

                                    <option value="{{ $three_step_info->sca_id }}" {{ $three_selected }}>{{ $three_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>

                    <td>
                        <table id="cate4" style="display:block">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 8)
                            <td>
                                <select size="10" name="ca_id" id="caa_id4" class="cid" >
                                @foreach($four_step_infos as $four_step_info)
                                    @php
                                        if($four_str_cut == $four_step_info->sca_id) $four_selected = "selected";
                                        else $four_selected = "";
                                    @endphp

                                    <option value="{{ $four_step_info->sca_id }}" {{ $four_selected }}>{{ $four_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>


                    <td>
                        <table id="cate5" style="display:block">
                        <tr>
                            @if($ca_id && strlen($ca_id) >= 10)
                            <td>
                                <select size="10" name="ca_id" id="caa_id5" class="cid" >
                                @foreach($five_step_infos as $five_step_info)
                                    @php
                                        if($five_str_cut == $five_step_info->sca_id) $five_selected = "selected";
                                        else $five_selected = "";
                                    @endphp

                                    <option value="{{ $five_step_info->sca_id }}" {{ $five_selected }}>{{ $five_step_info->sca_name_kr }}</option>
                                @endforeach
                                </select>
                            </td>
                            @endif
                        <tr>
                        </table>
                    </td>

                </tr>
            </table>
        </td>
    </tr>

</table>



<table border=1 style="width:950px">
    <tr>
        <td>상품코드</td>
        <td>{{ $item_info->item_code }}</td>
    </tr>
    <tr>
        <td>상품명</td>
        <td><input type="text" name="item_name" id="item_name" value="{{ stripslashes($item_info->item_name) }}"></td>
    </tr>
    <tr>
        <td>상품소개문구</td>
        <td><input type="text" name="item_basic" id="item_basic" value="{{ $item_info->item_basic }}"></td>
    </tr>
    <tr>
        <td>출력여부</td>
        <td>
        @php
            $disp_yes = "";
            $disp_no = "";
            if($item_info->item_display == "Y"){
                $disp_yes = "checked";
                $disp_no = "";
            }else{
                $disp_yes = "";
                $disp_no = "checked";
            }
        @endphp
            <input type="radio" name="item_display" id="item_display_yes" value="Y" {{ $disp_yes }}>출력
            <input type="radio" name="item_display" id="item_display_no" value="N" {{ $disp_no }}>출력안함
        </td>
    </tr>
    <tr>
        <td>출력순서</td>
        <td><input type="text" name="item_rank" id="item_rank" maxlength="3" size="3" value="{{ $item_info->item_rank }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"><br>※ 숫자만 입력 하세요. 숫자가 높을 수록 먼저 출력 됩니다.</td>
    </tr>

    <tr>
        <td>상품 유형</td>
        <td>
            <span class="frm_info">메인화면에 유형별로 출력할때 사용합니다.<br>이곳에 체크하게되면 상품리스트에서 유형별로 정렬할때 체크된 상품이 가장 먼저 출력됩니다.</span><br>
            @php
                $item_type1_checked = '';
                $item_type2_checked = '';
                $item_type3_checked = '';
                $item_type4_checked = '';

                switch($item_info->item_type1) {
                    case 1:
                        $item_type1_checked = "checked";
                        break;
                    case 2:
                        $item_type2_checked = "checked";
                        break;
                    case 3:
                        $item_type3_checked = "checked";
                        break;
                    case 4:
                        $item_type4_checked = "checked";
                        break;
                    default:
                        break;
                }
            @endphp
            <input type="radio" name="item_type1" value="1"  id="item_type1" {{ $item_type1_checked }}>NEW
            <input type="radio" name="item_type1" value="2"  id="item_type2" {{ $item_type2_checked }}>SALE
            <input type="radio" name="item_type1" value="3"  id="item_type3" {{ $item_type3_checked }}>BIG SALE
            <input type="radio" name="item_type1" value="4"  id="item_type4" {{ $item_type4_checked }}>HOT
            <button type="button" onclick="redio_release()">해제</button>

        </td>
    </tr>

        @php
            $item_special_checked = "";
            $item_special2_checked = '';
            $item_new_arrival_checked = '';

            if($item_info->item_special == 1) $item_special_checked = "checked";
            if($item_info->item_special2 == 1) $item_special2_checked = "checked";
            if($item_info->item_new_arrival == 1) $item_new_arrival_checked = "checked";
        @endphp
    <tr>
        <td>기획전1</td>
        <td>
            <input type="checkbox" name="item_special" value="1" id="item_special" {{ $item_special_checked }}>
        </td>
    </tr>
    <tr>
        <td>기획전2</td>
        <td>
            <input type="checkbox" name="item_special2" value="1" id="item_special2" {{ $item_special2_checked }}>
        </td>
    </tr>
    <tr>
        <td>New Arrival</td>
        <td>
            <input type="checkbox" name="item_new_arrival" value="1" id="item_new_arrival" {{ $item_new_arrival_checked }}>
        </td>
    </tr>
    <tr>
        <td>제조사(브랜드)</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_manufacture" id="item_manufacture" value="{{ $item_info->item_manufacture }}">
        </td>
    </tr>
<!--
    <tr>
        <td>원산지</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_origin" id="item_origin" value="{{ $item_info->item_origin }}">
        </td>
    </tr>

    <tr>
        <td>브랜드</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_brand" id="item_brand" value="{{ $item_info->item_brand }}">
        </td>
    </tr>

    <tr>
        <td>모델</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다. <br>
            <input type="text" name="item_model" id="item_model" value="{{ $item_info->item_model }}">
        </td>
    </tr>

    <tr>
        <td>전화문의</td>
        <td>상품 금액 대신 전화문의로 표시됩니다. <br>
            @php
                if($item_info->item_tel_inq == 1) $item_tel_inq_checked = 'checked';
                else $item_tel_inq_checked = '';
            @endphp
            <input type="checkbox" name="item_tel_inq" value="1" id="item_tel_inq" {{ $item_tel_inq_checked }}> 예
        </td>
    </tr>

    <tr>
        <td>판매가능</td>
        <td>잠시 판매를 중단하거나 재고가 없을 경우에 체크를 해제해 놓으면 출력되지 않으며, 주문도 받지 않습니다. <br>
            @php
                if($item_info->item_use == 1) $item_use_checked = 'checked';
                else $item_use_checked = '';
            @endphp
            <input type="checkbox" name="item_use" value="1" id="item_use" {{ $item_use_checked }}> 예
        </td>
    </tr>
-->
    <tr>
        <td>상품내용</td>
        <td>
            <textarea type="text" name="item_content" id="item_content" style="width:100%">{{ $item_info->item_content }}</textarea>
        </td>
    </tr>

    <tr>
        <td>성분</td>
        <td>
            <textarea type="text" name="item_content2" id="item_content2" style="width:100%">{{ $item_info->item_content2 }}</textarea>
        </td>
    </tr>

    <tr>
        <td>포장</td>
        <td>
            <textarea type="text" name="item_content3" id="item_content3" style="width:100%">{{ $item_info->item_content3 }}</textarea>
        </td>
    </tr>

    <tr>
        <td>분리배출</td>
        <td>
            <textarea type="text" name="item_content4" id="item_content4" style="width:100%">{{ $item_info->item_content4 }}</textarea>
        </td>
    </tr>

    <tr>
        <td>사회적 가치</td>
        <td>
            <textarea type="text" name="item_content5" id="item_content5" style="width:100%">{{ $item_info->item_content5 }}</textarea>
        </td>
    </tr>

    <tr>
        <td>판매가격</td>
        <td><input type="text" name="item_price" id="item_price" value="{{ $item_info->item_price }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">원</td>
    </tr>

    <tr>
        <td>시중가격</td>
        <td>입력하지 않으면 상품상세페이지에 출력하지 않습니다.<br>
            <input type="text" name="item_cust_price" id="item_cust_price" value="{{ $item_info->item_cust_price }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">원
        </td>
    </tr>

    <tr>
        <td>상품품절</td>
        <td>잠시 판매를 중단하거나 재고가 없을 경우에 체크해 놓으면 품절상품으로 표시됩니다.<br>
            @php
                if($item_info->item_soldout == 1) $item_soldout_checked = "checked";
                else $item_soldout_checked = "";
            @endphp
            <input type="checkbox" name="item_soldout" value="1" id="item_soldout" {{ $item_soldout_checked }}> 예
        </td>
    </tr>

    <tr>
        <td>재고수량</td>
        <td>주문관리에서 상품별 상태 변경에 따라 자동으로 재고를 가감합니다. <br>재고는 규격/색상별이 아닌, 상품별로만 관리됩니다.<br>재고수량을 0으로 설정하시면 품절상품으로 표시됩니다.<br>
            <input type="text" name="item_stock_qty" value="{{ $item_info->item_stock_qty }}" id="item_stock_qty" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 개
        </td>
    </tr>

    <tr>
        <td>상품선택옵션</td>
        <td>옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다.<br> 옷을 예로 들어 [옵션1 : 사이즈 , 옵션1 항목 : XXL,XL,L,M,S] , [옵션2 : 색상 , 옵션2 항목 : 빨,파,노]<br><strong>옵션명과 옵션항목에 따옴표(', ")는 입력할 수 없습니다.</strong><br>
            <table border=1>
                <tr>
                    <td>
                        <table>
                        @php
                            $opt_subject = "";
                            $opt_subject = explode(',', $item_info->item_option_subject);

                            if(isset($opt_subject[0])) $opt_subject[0] = $opt_subject[0];
                            else $opt_subject[0] = "";

                            if(isset($opt_subject[1])) $opt_subject[1] = $opt_subject[1];
                            else $opt_subject[1] = "";

                            if(isset($opt_subject[2])) $opt_subject[2] = $opt_subject[2];
                            else $opt_subject[2] = "";
                        @endphp

                            <tr>
                                <td>옵션1
                                    <input type="text" name="opt1_subject" value="{{ $opt_subject[0] }}" id="opt1_subject" size="15">
                                </td>
                                <td>옵션1 항목
                                    <input type="text" name="opt1" value="" id="opt1" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td>옵션2
                                    <input type="text" name="opt2_subject" value="{{ $opt_subject[1] }}" id="opt2_subject" size="15">
                                </td>
                                <td>옵션2 항목
                                    <input type="text" name="opt2" value="" id="opt2" size="50">
                                </td>
                            </tr>
<!--
                            <tr>
                                <td>옵션3
                                    <input type="text" name="opt3_subject" value="{{ $opt_subject[2] }}" id="opt3_subject" size="15">
                                </td>
                                <td>옵션3 항목
                                    <input type="text" name="opt3" value="" id="opt3" size="50">
                                </td>
                            </tr>
-->
                            <tr>
                                <td colspan="2"><button type="button" id="option_table_create">옵션목록생성</button></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr id="sit_option_frm">
                    <!-- 옵션 조합 리스트 나오는 곳 -->
                </tr>

@if($item_info->item_option_subject != "")
<script>
    $.ajax({    //저장된 선택 옵션 가져 오기
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
        url: '{{ route('shop.item.ajax_modi_itemoption') }}',
        type: 'post',
        dataType: 'html',
        data: {
            item_code       : '{{ $item_info->item_code }}',
            opt1_subject    : $.trim($("#opt1_subject").val()),
            opt2_subject    : $.trim($("#opt2_subject").val()),
            opt3_subject    : $.trim($("#opt3_subject").val()),
        },
        success: function(data) {
            $("#sit_option_frm").empty().html(data);
        },error: function(data) {
            console.log(data);
        }
    });
</script>
@endif

<script>
    $(function() {
        //옵션항목설정
        var arr_opt1 = new Array();
        var arr_opt2 = new Array();
        var arr_opt3 = new Array();
        var opt1 = opt2 = opt3 = '';
        var opt_val;

        $(".opt-cell").each(function() {
            opt_val = $(this).text().split(" > ");
            opt1 = opt_val[0];
            opt2 = opt_val[1];
            opt3 = opt_val[2];

            if(opt1 && $.inArray(opt1, arr_opt1) == -1)
                arr_opt1.push(opt1);

            if(opt2 && $.inArray(opt2, arr_opt2) == -1)
                arr_opt2.push(opt2);

            if(opt3 && $.inArray(opt3, arr_opt3) == -1)
                arr_opt3.push(opt3);
        });

        $("input[name=opt1]").val(arr_opt1.join());
        $("input[name=opt2]").val(arr_opt2.join());
        $("input[name=opt3]").val(arr_opt3.join());

        // 옵션목록생성
        $("#option_table_create").click(function() {
            var it_id = $.trim($("input[name=it_id]").val());
            var opt1_subject = $.trim($("#opt1_subject").val());
            var opt2_subject = $.trim($("#opt2_subject").val());
            var opt3_subject = $.trim($("#opt3_subject").val());
            var opt1 = $.trim($("#opt1").val());
            var opt2 = $.trim($("#opt2").val());
            var opt3 = $.trim($("#opt3").val());
            var $option_table = $("#sit_option_frm");

            if(!opt1_subject || !opt1) {
                alert("옵션명과 옵션항목을 입력해 주십시오.");
                return false;
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                url: '{{ route('shop.item.ajax_itemoption') }}',
                type: 'post',
                dataType: 'html',
                data: {
                    opt1_subject    : opt1_subject,
                    opt2_subject    : opt2_subject,
                    opt3_subject    : opt3_subject,
                    opt1            : opt1,
                    opt2            : opt2,
                    opt3            : opt3,
                },
                success: function(data) {
                    if($.trim(data) == 'No'){
                        alert('옵션1과 옵션1 항목을 입력해 주십시오.');
                        return false;
                    }else{
                        $option_table.empty().html(data);
                    }
                },error: function(data) {
                        console.log(data);
                }
            });
        });

        // 모두선택
        $(document).on("click", "input[name=opt_chk_all]", function() {
            if($(this).is(":checked")) {
                $("input[name='opt_chk[]']").attr("checked", true);
            } else {
                $("input[name='opt_chk[]']").attr("checked", false);
            }
        });

        // 선택삭제
        $(document).on("click", "#sel_option_delete", function() {
            var $el = $("input[name='opt_chk[]']:checked");
            if($el.length < 1) {
                alert("삭제하려는 옵션을 하나 이상 선택해 주십시오.");
                return false;
            }

            $el.closest("tr").remove();
        });

        // 일괄적용
        $(document).on("click", "#opt_value_apply", function() {
            if($(".opt_com_chk:checked").length < 1) {
                alert("일괄 수정할 항목을 하나이상 체크해 주십시오.");
                return false;
            }

            var opt_price = $.trim($("#opt_com_price").val());
            var opt_stock = $.trim($("#opt_com_stock").val());
            var opt_noti = $.trim($("#opt_com_noti").val());
            var opt_use = $("#opt_com_use").val();
            var $el = $("input[name='opt_chk[]']:checked");

            // 체크된 옵션이 있으면 체크된 것만 적용
            if($el.length > 0) {
                var $tr;
                $el.each(function() {
                    $tr = $(this).closest("tr");

                    if($("#opt_com_price_chk").is(":checked"))
                        $tr.find("input[name='opt_price[]']").val(opt_price);

                    if($("#opt_com_stock_chk").is(":checked"))
                        $tr.find("input[name='opt_stock_qty[]']").val(opt_stock);

                    if($("#opt_com_noti_chk").is(":checked"))
                        $tr.find("input[name='opt_noti_qty[]']").val(opt_noti);

                    if($("#opt_com_use_chk").is(":checked"))
                        $tr.find("select[name='opt_use[]']").val(opt_use);
                });
            } else {
                if($("#opt_com_price_chk").is(":checked"))
                    $("input[name='opt_price[]']").val(opt_price);

                if($("#opt_com_stock_chk").is(":checked"))
                    $("input[name='opt_stock_qty[]']").val(opt_stock);

                if($("#opt_com_noti_chk").is(":checked"))
                    $("input[name='opt_noti_qty[]']").val(opt_noti);

                if($("#opt_com_use_chk").is(":checked"))
                    $("select[name='opt_use[]']").val(opt_use);
            }
        });
    });
</script>
            </table>
        </td>
    </tr>
<!--
    <tr>
        <td>상품추가옵션</td>
        <td>옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다. <br>스마트폰을 예로 들어 [추가1 : 추가구성상품 , 추가1 항목 : 액정보호필름,케이스,충전기]<br>
        <strong>옵션명과 옵션항목에 따옴표(', ")는 입력할 수 없습니다.</strong><br>
        @php
            $spl_subject = explode(',', $item_info->item_supply_subject);
            $spl_count = count($spl_subject);
        @endphp

            <table border=1>
                <tr id="sit_supply_frm">
                    <td>
                        <table>

                        @for($i = 0; $i < $spl_count; $i++)
                            <tr>
                                <td>추가{{ $i+1 }}
                                    <input type="text" name="spl_subject[]" id="spl_subject_{{ $i+1 }}" value="{{ $spl_subject[$i] }}" size="15">
                                </td>
                                <td>추가{{ $i+1 }} 항목
                                    <input type="text" name="spl[]" id="spl_item_{{ $i+1 }}" value="" size="40">
                                </td>

                                @if($i > 0)
                                <td>
                                    <button type="button" id="del_supply_row">삭제</button>
                                </td>
                                @endif
                            </tr>
                        @endfor

                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><button type="button" id="add_supply_row">옵션추가</button></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="button" id="supply_table_create">옵션목록생성</button></td>
                </tr>

                <tr id="sit_option_addfrm">
                    추가 옵션 조합 리스트 나오는 곳
                </tr>

@if($item_info->item_supply_subject != "")
<script>
    $.ajax({    //저장된 추가 옵션 가져 오기
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
        url: '{{ route('shop.item.ajax_modi_itemsupply') }}',
        type: 'post',
        dataType: 'html',
        data: {
            item_code   : '{{ $item_info->item_code }}',
        },
        success: function(data) {
            $("#sit_option_addfrm").empty().html(data);
        },error: function(data) {
            console.log(data);
        }
    });
</script>
@endif

<script>
    $(function() {
        // 추가옵션의 항목 설정
        var arr_subj = new Array();
        var subj, spl;

        $("input[name='spl_subject[]']").each(function() {
            subj = $.trim($(this).val());
            if(subj && $.inArray(subj, arr_subj) == -1)
                arr_subj.push(subj);
        });

        for(i=0; i<arr_subj.length; i++) {
            var arr_spl = new Array();
            $(".spl-subject-cell").each(function(index) {
                subj = $(this).text();
                if(subj == arr_subj[i]) {
                    spl = $(".spl-cell:eq("+index+")").text();
                    arr_spl.push(spl);
                }
            });

            $("input[name='spl[]']:eq("+i+")").val(arr_spl.join());
        }

        // 입력필드추가
        $("#add_supply_row").click(function() {
            var $el = $("#sit_supply_frm tr:last");
            var fld = "<tr>\n";
            fld += "<th scope=\"row\">\n";
            fld += "<label for=\"\">추가</label>\n";
            fld += "<input type=\"text\" name=\"spl_subject[]\" value=\"\" size=\"15\">\n";
            fld += "</th>\n";
            fld += "<td>\n";
            fld += "<label for=\"\"><b>추가 항목</b></label>\n";
            fld += "<input type=\"text\" name=\"spl[]\" value=\"\" size=\"40\">\n";
            fld += "<button type=\"button\" id=\"del_supply_row\" >삭제</button>\n";
            fld += "</td>\n";
            fld += "</tr>";

            $el.after(fld);

            supply_sequence();
        });

        // 입력필드삭제
        $(document).on("click", "#del_supply_row", function() {
            $(this).closest("tr").remove();

            supply_sequence();
        });

        // 옵션목록생성
        $("#supply_table_create").click(function() {
            var it_id = $.trim($("input[name=it_id]").val());
            var subject = new Array();
            var supply = new Array();
            var subj, spl;
            var count = 0;
            var $el_subj = $("input[name='spl_subject[]']");
            var $el_spl = $("input[name='spl[]']");
            var $supply_table = $("#sit_option_addfrm");

            $el_subj.each(function(index) {
                subj = $.trim($(this).val());
                spl = $.trim($el_spl.eq(index).val());

                if(subj && spl) {
                    subject.push(subj);
                    supply.push(spl);
                    count++;
                }
            });

            if(!count) {
                alert("추가옵션명과 추가옵션항목을 입력해 주십시오.");
                return false;
            }

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                url: '{{ route('shop.item.ajax_itemsupply') }}',
                type: 'post',
                dataType: 'html',
                data: {
                    'it_id'         : it_id,
                    'subject[]'     : subject,
                    'supply[]'      : supply,
                },

                success: function(data) {
                    if($.trim(data) == 'No'){
                        alert('추가옵션명과 추가옵션항목을 입력해 주십시오.');
                        return false;
                    }else{
                        $supply_table.empty().html(data);
                    }
                },error: function(data) {
                        console.log(data);
                }
            });
        });

        // 모두선택
        $(document).on("click", "input[name=spl_chk_all]", function() {
            if($(this).is(":checked")) {
                $("input[name='spl_chk[]']").attr("checked", true);
            } else {
                $("input[name='spl_chk[]']").attr("checked", false);
            }
        });

        // 선택삭제
        $(document).on("click", "#sel_supply_delete", function() {
            var $el = $("input[name='spl_chk[]']:checked");
            if($el.length < 1) {
                alert("삭제하려는 옵션을 하나 이상 선택해 주십시오.");
                return false;
            }

            $el.closest("tr").remove();
        });

        // 일괄적용
        $(document).on("click", "#spl_value_apply", function() {
            if($(".spl_com_chk:checked").length < 1) {
                alert("일괄 수정할 항목을 하나이상 체크해 주십시오.");
                return false;
            }

            var spl_price = $.trim($("#spl_com_price").val());
            var spl_stock = $.trim($("#spl_com_stock").val());
            var spl_noti = $.trim($("#spl_com_noti").val());
            var spl_use = $("#spl_com_use").val();
            var $el = $("input[name='spl_chk[]']:checked");

            // 체크된 옵션이 있으면 체크된 것만 적용
            if($el.length > 0) {
                var $tr;
                $el.each(function() {
                    $tr = $(this).closest("tr");

                    if($("#spl_com_price_chk").is(":checked"))
                        $tr.find("input[name='spl_price[]']").val(spl_price);

                    if($("#spl_com_stock_chk").is(":checked"))
                        $tr.find("input[name='spl_stock_qty[]']").val(spl_stock);

                    if($("#spl_com_noti_chk").is(":checked"))
                        $tr.find("input[name='spl_noti_qty[]']").val(spl_noti);

                    if($("#spl_com_use_chk").is(":checked"))
                        $tr.find("select[name='spl_use[]']").val(spl_use);
                });
            } else {
                if($("#spl_com_price_chk").is(":checked"))
                    $("input[name='spl_price[]']").val(spl_price);

                if($("#spl_com_stock_chk").is(":checked"))
                    $("input[name='spl_stock_qty[]']").val(spl_stock);

                if($("#spl_com_noti_chk").is(":checked"))
                    $("input[name='spl_noti_qty[]']").val(spl_noti);

                if($("#spl_com_use_chk").is(":checked"))
                    $("select[name='spl_use[]']").val(spl_use);
            }
        });
    });

    function supply_sequence()
    {
        var $tr = $("#sit_supply_frm tr");
        var seq;
        var th_label, td_label;

        $tr.each(function(index) {
            seq = index + 1;
            $(this).find("th label").attr("for", "spl_subject_"+seq).text("추가"+seq);
            $(this).find("th input").attr("id", "spl_subject_"+seq);
            $(this).find("td label").attr("for", "spl_item_"+seq);
            $(this).find("td label b").text("추가"+seq+" 항목");
            $(this).find("td input").attr("id", "spl_item_"+seq);
        });
    }
</script>



            </table>
        </td>
    </tr>
-->
    <tr>
        <td>상품 추가 배송비</td>
        <td>
            <input type="text" name="item_sc_price" value="{{ $item_info->item_sc_price }}" id="item_sc_price" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 원
        </td>
    </tr>

    <tr>
        <td colspan=2><b>상품 이미지 사이즈 : 600 X 520</b></td>
    </tr>
    @for($i = 1; $i <=10; $i++)
    <tr>
        <td>상품 이미지{{ $i }}</td>
        <td>
            <input type="file" name="item_img{{ $i }}" id="item_img{{ $i }}">
            @error('item_img'.$i)
                <strong>{{ $message }}</strong>
            @enderror

        @php
            $item_ori_img = "item_ori_img$i";
        @endphp
                <br><a href="javascript:file_down('{{ $item_info->id }}','{{ $item_info->sca_id }}','{{ $i }}');">{{ $item_info->$item_ori_img }}</a><br>
            <input type='checkbox' name="file_chk{{ $i }}" id="file_chk{{ $i }}" value='1'>수정,삭제,새로 등록시 체크 하세요.
        </td>
    </tr>
    @endfor

    <tr colspan="2">
        <td><button type="button" onclick="submitContents();">수정</button></td>
    </tr>

</table>
</form>


<script>
    function redio_release(){
        $("input:radio[name='item_type1']").prop("checked", false);
    }
</script>

<script>
	$(document).ready(function() {
        $(document).on("click", "#caa_id", function() {
			var cate_is = $('#caa_id').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    type: 'post',
                    url: '{{ route('shop.cate.ajax_select') }}',
                    dataType: 'text',
                    data: {
                        'ca_id'   : $('#caa_id').val(),
                        'length'  : $('#caa_id').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
    //alert(data.ca_name_kr);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate2').css('display', 'block');
                            $('#cate2').html(data.data);
                            $('#cate3').html('');
                            $('#cate4').html('');
                            $('#cate5').html('');
                        }

                    },error: function(result) {
                        console.log(result);
                    }
                });
            }
		});

		$(document).on("click", "#caa_id2", function() {
			var cate_is = $('#caa_id2').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('shop.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id2').val(),
                        length  : $('#caa_id2').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate3').css('display', 'block');
                            $('#cate3').html(data.data);
                            $('#cate4').html('');
                            $('#cate5').html('');
                        }
                    },error: function(result) {
                        console.log(result);
                    }
                });
            }
		});

		$(document).on("click", "#caa_id3", function() {
			var cate_is = $('#caa_id3').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('shop.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id3').val(),
                        length  : $('#caa_id3').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate4').css('display', 'block');
                            $('#cate4').html(data.data);
                            $('#cate5').html('');
                        }
                    }
                });
            }
		});

		$(document).on("click", "#caa_id4", function() {
			var cate_is = $('#caa_id4').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('shop.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id4').val(),
                        length  : $('#caa_id4').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate5').css('display', 'block');
                            $('#cate5').html(data.data);
                        }
                    }
                });
            }
		});

		$(document).on("click", "#caa_id5", function() {
            var num = 0;
		    var cate_is = $('#caa_id5').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('shop.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id5').val(),
                        length  : $('#caa_id5').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
    //alert(data.ca_id);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            //$('#cate5').css('display', 'block');
                            //$('#cate5').html(data.data);
                        }
                    }
                });
            }
		});

    });
</script>


<script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "item_content",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {
            bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
        }, //boolean
    });

    var oEditors2 = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors2,
        elPlaceHolder: "item_content2",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {
            bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
        }, //boolean
    });

    var oEditors3 = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors3,
        elPlaceHolder: "item_content3",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {
            bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
        }, //boolean
    });

    var oEditors4 = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors4,
        elPlaceHolder: "item_content4",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {
            bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
        }, //boolean
    });

    var oEditors5 = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors5,
        elPlaceHolder: "item_content5",
        sSkinURI: "/smarteditor2/SmartEditor2Skin.html",
        fCreator: "createSEditor2",
        htParams : {
            bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
        }, //boolean
    });
</script>

<script>
    function file_down(id, ca_id, file_num)
    {
        $("#num").val(id);
        $("#ca_id").val(ca_id);
        $("#file_num").val(file_num);
        $("#item_form").attr("action", "{{ route('shop.item.downloadfile') }}");
        $("#item_form").submit();
    }
</script>

<script>
    function submitContents(elClickedObj) {
        oEditors.getById["item_content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        oEditors2.getById["item_content2"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        oEditors3.getById["item_content3"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        oEditors4.getById["item_content4"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        oEditors5.getById["item_content5"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("item_content").value를 이용해서 처리하면 됩니다.
        var item_content = $("#item_content").val();

        if($("#last_choice_ca_id").val() == ""){
            alert("단계를 선택 하세요.");
            $("#caa_id").focus();
            return;
        }

        if($.trim($("#item_name").val()) == ""){
            alert("상품명을 입력하세요.");
            $("#item_name").focus();
            return;
        }

        if( item_content == ""  || item_content == null || item_content == '&nbsp;' || item_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["item_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}
        $("#item_form").attr("action", "{{ route('shop.item.modifysave') }}");
        $("#item_form").submit();
    }
</script>





@endsection
