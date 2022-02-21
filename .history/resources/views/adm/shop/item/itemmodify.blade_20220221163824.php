@extends('layouts.admhead')

@section('content')


<!-- smarteditor2 사용 -->
<script type="text/javascript" src="{{ asset('/smarteditor2/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
<!-- smarteditor2 사용 -->

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>상품 수정</h2>
                <div class="button_box">
                    <button type="button" onclick="submitContents();">수정</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cate">
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

                <h3 class="line">카테고리 선택</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col100">
                            <ul>
                                <li id="cate1">
                                    <ul>
                                        <li>대분류</li>
                                        <li>
                                            <select size="10" name="ca_id" id="caa_id" class="cid" style="height:140px;">
                                            @foreach($one_step_infos as $one_step_info)
                                                @php
                                                    if($one_str_cut == $one_step_info->sca_id) $one_selected = "selected";
                                                    else $one_selected = "";
                                                @endphp

                                                <option value="{{ $one_step_info->sca_id }}" {{ $one_selected }}>{{ $one_step_info->sca_name_kr }}</option>
                                            @endforeach
                                            </select>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                                <li id="cate2" style="display: none;">
                                    <ul>
                                        <li>소분류</li>
                                        <li>

                                        @if($ca_id && strlen($ca_id) >= 4)
                                            <select size="10" name="ca_id" id="caa_id2" class="cid" >
                                            @foreach($two_step_infos as $two_step_info)
                                                @php
                                                    if($two_str_cut == $two_step_info->sca_id) $two_selected = "selected";
                                                    else $two_selected = "";
                                                @endphp

                                                <option value="{{ $two_step_info->sca_id }}" {{ $two_selected  }}>{{ $two_step_info->sca_name_kr }}</option>
                                            @endforeach
                                            </select>
                                        @endif
                                        
                                        </li>
                                    </ul>
                                </li>
                            
                        </div>
                    </div>
                </div>

                <h3 class="line">상품 기본 정보</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">상품코드</div>
                        <div class="col">{{ $item_info->item_code }}</div>
                    </div>
                    <div class="row">
                        <div class="col">제조사</div>
                        <div class="col">
                            <input type="text" name="item_manufacture" id="item_manufacture" value="{{ $item_info->item_manufacture }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품명</div>
                        <div class="col">
                            <p>30자 내외로 입력하세요</p>
                            <input class="wd500" type="text" name="item_name" id="item_name" value="{{ stripslashes($item_info->item_name) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품 소개 문구</div>
                        <div class="col">
                            <p>100자 내외로 입력하세요</p>
                            <input class="wd500" type="text" name="item_basic" id="item_basic" value="{{ $item_info->item_basic }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">출력여부</div>
                        <div class="col">
                            <div class="prt">
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
                                <label>
                                    <input type="radio" name="item_display" id="item_display_yes" value="Y" {{ $disp_yes }}> 출력
                                </label>
                                <label>
                                    <input type="radio" name="item_display" id="item_display_no" value="N" {{ $disp_no }}> 미출력
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">출력순서</div>
                        <div class="col">
                            <p>*숫자만 입력하세요. 숫자가 낮을수록 먼저 출력 됩니다.</p>
                            <input type="text" name="item_rank" id="item_rank" maxlength="3" size="3" value="{{ $item_info->item_rank }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품유형</div>
                        <div class="col">
                            <div class="prt">
                            @php
                                $item_type0_checked = '';
                                $item_type1_checked = '';
                                $item_type2_checked = '';
                                $item_type3_checked = '';
                                $item_type4_checked = '';

                                switch($item_info->item_type1) {
                                    case 0:
                                        $item_type0_checked = "checked";
                                        break;
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
                                <label>
                                    <input type="radio" name="item_type1" value="0"  id="item_type0" {{ $item_type0_checked }}> 없음
                                </label>
                                <label>
                                    <input type="radio" name="item_type1" value="1"  id="item_type1" {{ $item_type1_checked }}> NEW
                                </label>
                                <label>
                                    <input type="radio" name="item_type1" value="2"  id="item_type2" {{ $item_type2_checked }}> SALE
                                </label>
                                <label>
                                    <input type="radio" name="item_type1" value="3"  id="item_type3" {{ $item_type3_checked }}> BIG SALE
                                </label>
                                <label>
                                    <input type="radio" name="item_type1" value="4"  id="item_type4" {{ $item_type4_checked }}> HOT
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">기획전1 </div>
                        <div class="col">
                            <div class="dp">
                            @php
                                $item_special_checked = "";
                                $item_special2_checked = '';
                                $item_new_arrival_checked = '';

                                if($item_info->item_special == 1) $item_special_checked = "checked";
                                if($item_info->item_special2 == 1) $item_special2_checked = "checked";
                                if($item_info->item_new_arrival == 1) $item_new_arrival_checked = "checked";
                            @endphp
                                <label>
                                    <input type="checkbox" name="item_special" value="1" id="item_special" {{ $item_special_checked }}>체크시 메인 기획전1 영역에 노출합니다.
                                </label>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">기획전2 </div>
                        <div class="col">
                            <div class="dp">
                                <label>
                                    <input type="checkbox" name="item_special2" value="1" id="item_special2" {{ $item_special2_checked }}>체크시 메인 기획전2 영역에 노출합니다.
                                </label>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">New Arrivals </div>
                        <div class="col">
                            <div class="dp">
                                <label>
                                    <input type="checkbox" name="item_new_arrival" value="1" id="item_new_arrival" {{ $item_new_arrival_checked }}>체크시 메인 New Arrivals 영역에 노출합니다.
                                </label>
                           </div>
                        </div>
                    </div>
                </div>

                <h3 class="line">상품 상세 정보</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">상품상세 정보</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content" id="item_content" style="width:100%">{{ $item_info->item_content }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">성분</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content2" id="item_content2" style="width:100%">{{ $item_info->item_content2 }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">포장</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content3" id="item_content3" style="width:100%">{{ $item_info->item_content3 }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">분리 배출</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content4" id="item_content4" style="width:100%">{{ $item_info->item_content4 }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">사회적 가치</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content5" id="item_content5" style="width:100%">{{ $item_info->item_content5 }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="line">가격/옵션 설정</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">판매가</div>
                        <div class="col">
                            <div class="price">
                                <input type="text" name="item_price" id="item_price" value="{{ $item_info->item_price }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 원
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">원가</div>
                        <div class="col">
                            <div class="price">
                                <p>미입력시 상세페이지에서 미표기 됩니다</p>
                                <input type="text" name="item_cust_price" id="item_cust_price" value="{{ $item_info->item_cust_price }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 원
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">적립금 제공 여부</div>
                        <div class="col">
                            <div class="price">
                            @php
                                $select_chk1 = "";
                                $select_chk2 = "";
                                if($item_info->item_give_point == 'Y') $select_chk1 = "checked";
                                else $select_chk2 = "checked";
                            @endphp
                                <label>
                                    <input type="radio" name="item_give_point" value="Y" {{ $select_chk1 }}>적립금 제공
                                </label>

                                <label>
                                    <input type="radio" name="item_give_point" value="N" {{ $select_chk2 }}>적립금 제공 안함
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품품절</div>
                        <div class="col">
                            <p class="t_mint">판매를 중단하거나 재고가 없을 경우 체크하여 품절 표기 하세요</p>
                            @php
                                if($item_info->item_soldout == 1) $item_soldout_checked = "checked";
                                else $item_soldout_checked = "";
                            @endphp
                            <label>
                                <input type="checkbox" name="item_soldout" value="1" id="item_soldout" {{ $item_soldout_checked }}>품절처리
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">재고 수량</div>
                        <div class="col">
                            <div class="price">
                                <input type="text" name="item_stock_qty" value="{{ $item_info->item_stock_qty }}" id="item_stock_qty" size="8" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 개
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품 선택 옵션</div>
                        <div class="col">
                            <p>
                                콤마( , )로 구분하여 여러개의 옵션 등록 하세요<br>
                                예)<br>
                                옵션1: 사이즈 / 옵션1항목 : 90, 95, 100, 105<br>
                                옵션2 : 색상 / 옵션2항목 : 빨강, 파랑, 검정<br>
                                *옵션명칭과 옵션항목에 따옴표, 쌍따옴표, 쉼표 입력은 불가합니다.
                            </p>
                            <ul class="opt">
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
                                <li>
                                    <div class="title">
                                        옵션1 명칭 입력
                                    </div>
                                    <input class="wd500" type="text" name="opt1_subject" value="{{ $opt_subject[0] }}" id="opt1_subject">
                                </li>
                                <li>
                                    <div class="title">
                                        옵션1 항목
                                    </div>
                                    <input class="wd500" type="text" name="opt1" value="" id="opt1">
                                </li>
                            </ul>


                            <ul class="opt">
                                <li>
                                    <div class="title">
                                        옵션2 명칭 입력
                                    </div>
                                    <input class="wd500" type="text" name="opt2_subject" value="{{ $opt_subject[1] }}" id="opt2_subject">
                                </li>
                                <li>
                                    <div class="title">
                                        옵션2 항목
                                    </div>
                                    <input class="wd500" type="text" name="opt2" value="" id="opt2">
                                </li>
                            </ul>


                            <button type="button" class="btn blk mt20 mb20" id="option_table_create">옵션 목록 생성</button>
                            <!-- 옵션 목록 시작 -->
                            <div class="opt_list" id="sit_option_frm">
                            </div>
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
                            <!-- 옵션목록 끝 -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">추가배송비</div>
                        <div class="col">
                            <div class="price">
                                <input type="text" name="item_sc_price" value="{{ $item_info->item_sc_price }}" id="item_sc_price" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 원
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="line">상품 이미지 등록</h3>
                <div class="box_cont prd_img">
                    <div class="box_guide">
                        <p>상품 상세페이지에 들어가는 이미지 입니다. </p>
                        <p>상세페이지의 상품 이미지를 10개 까지 등록 가능합니다.</p>
                        <p class="t_blk">첫번째 이미지가 상품의 목록이미지로 등록됩니다.</p>
                        <p class="t_red mt20">이미지 사이즈 : 600*517(1200*1034)</p>
                    </div>
                    <div class="row">
                        <div class="col">이미지 선택</div>
                        <div class="col">
                            @for($i = 1; $i <=10; $i++)
                            <div class="file_att">
                                @if($i == 1)
                                <p class="t_mint">본 이미지가 목록 이미지로 등록됩니다</p>
                                @endif
                                <div class="btn_file">
                                    <label>
                                        파일첨부
                                        <input type="file" name="item_img{{ $i }}" id="item_img{{ $i }}" accept="image/*" onchange="file_name('item_img{{ $i }}')">
                                    </label>
                                    <span id="item_img{{ $i }}_name"></span>
                                    @php
                                        $item_ori_img = "item_ori_img$i";
                                    @endphp
                                    <p><a href="javascript:file_down('{{ $item_info->id }}','{{ $item_info->sca_id }}','{{ $i }}');">{{ $item_info->$item_ori_img }}</a></p>
                                </div>
                                <div class="file">
                                    <label>
                                        <input type="checkbox" name="file_chk{{ $i }}" id="file_chk{{ $i }}" value='1'>수정, 삭제, 새로등록시 체크
                                    </label>
                                </div>
                            </div>
                            @endfor

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- 컨텐츠 영역 끝 -->

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
                            $('#cate2').css('display', 'inline-block');
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
            alert("카테고리를 선택 하세요.");
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


<script>
    function file_name(id_val){
        flies = document.getElementById(id_val);

        fileList = "";
        for(i = 0; i < flies.files.length; i++){
            fileList += flies.files[i].name;
        }
        flies_name = document.getElementById(id_val+'_name');
        flies_name.innerHTML = fileList;
    }
</script>



@endsection
