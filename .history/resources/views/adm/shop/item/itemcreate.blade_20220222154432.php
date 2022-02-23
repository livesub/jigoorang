@extends('layouts.admhead')

@section('content')


<!-- smarteditor2 사용 -->
<script type="text/javascript" src="{{ asset('/smarteditor2/js/HuskyEZCreator.js') }}" charset="utf-8"></script>
<!-- smarteditor2 사용 -->

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>상품 등록</h2>
                <div class="button_box">
                    <button type="button" onclick="submitContents();">등록<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cate">
            <form name="item_form" id="item_form" method="post" action="{{ route('shop.item.createsave') }}" enctype='multipart/form-data'>
            {!! csrf_field() !!}
            <input type="hidden" name="sca_id" id="sca_id">
            <input type="hidden" name="sca_name_kr" id="sca_name_kr">
            <input type="hidden" name="length" id="length">
            <input type="hidden" name="last_choice_ca_id" id="last_choice_ca_id">
            <input type="hidden" name="item_code" id="item_code" value="{{ $item_code }}">
            <input type="hidden" name="item_use" id="item_use" value="1">
            <input type="hidden" name="item_point" id="item_point" value="{{ $item_point }}">

                <h3 class="line">카테고리 선택</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col100">
                            <ul>
                                <li>대분류</li>
                                <li id="cate1">
                                    
                                    <li>
                                        <select name="ca_id" id="caa_id" class="cid">
                                        @foreach($one_step_infos as $one_step_info)
                                            <option value="{{ $one_step_info->sca_id }}">{{ $one_step_info->sca_name_kr }}</option>
                                        @endforeach
                                        </select>
                                    </li>
                                </li>

                                             
                                        <li id="cate2">
                                            <>소분류</ㄴ>
                                            <!--    @if($ca_id && strlen($ca_id) >= 4)
                                                <li>
                                                    <select name="ca_id" id="caa_id2" class="cid">
                                                    @foreach($two_step_infos as $two_step_info)
                                                        <option value="{{ $two_step_info->sca_id }}">└ {{ $two_step_info->sca_name_kr }}</option>
                                                    @endforeach
                                                    </select>
                                                </li>
                                                @endif-->
                                        </li>
                            
                            </ul>
                        </div>
                    </div>
                </div>

                <h3 class="line">상품 기본 정보</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">상품코드</div>
                        <div class="col">{{ $item_code }}</div>
                    </div>
                    <div class="row">
                        <div class="col">제조사</div>
                        <div class="col">
                            <input type="text" name="item_manufacture" id="item_manufacture" value="{{ old('item_manufacture') }}" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품명</div>
                        <div class="col">
                            <p>30자 내외로 입력하세요</p>
                            <input class="wd500" type="text" name="item_name" id="item_name" value="{{ old('item_name') }}" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품 소개 문구</div>
                        <div class="col">
                            <p>100자 내외로 입력하세요</p>
                            <input class="wd500" type="text" name="item_basic" id="item_basic" value="{{ old('item_basic') }}" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">출력여부</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" name="item_display" id="item_display_yes" value="Y" checked="checked" > 출력
                                </label>
                                <label>
                                    <input type="radio" name="item_display" id="item_display_no" value="N"> 미출력
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">출력순서</div>
                        <div class="col">
                            <p>*숫자만 입력하세요. 숫자가 낮을수록 먼저 출력 됩니다.</p>
                            <input type="text" name="item_rank" id="item_rank" maxlength="4" size="4" value="9999" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="" style="text-align:right;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품유형</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" name="item_type1" value="0" id="item_type0"> 없음
                                </label>
                                <label>
                                    <input type="radio" name="item_type1" value="1" id="item_type1"> NEW
                                </label>
                                <label>
                                    <input type="radio" name="item_type1" value="2" id="item_type2"> SALE
                                </label>
                                <label>
                                    <input type="radio" name="item_type1" value="3" id="item_type3"> BIG SALE
                                </label>
                                <label>
                                    <input type="radio" name="item_type1" value="4"  id="item_type4"> HOT
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">기획전1 </div>
                        <div class="col">
                            <div class="dp">
                                <label>
                                    <input type="checkbox" name="item_special" value="1" id="item_special">체크시 메인 기획전1 영역에 노출합니다.
                                </label>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">기획전2 </div>
                        <div class="col">
                            <div class="dp">
                                <label>
                                    <input type="checkbox" name="item_special2" value="1" id="item_special2">체크시 메인 기획전2 영역에 노출합니다.
                                </label>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">New Arrivals </div>
                        <div class="col">
                            <div class="dp">
                                <label>
                                    <input type="checkbox" name="item_new_arrival" value="1" id="item_new_arrival">체크시 메인 New Arrivals 영역에 노출합니다.
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
                                <textarea type="text" name="item_content" id="item_content" style="width:100%">{{ old('item_content') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">성분</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content2" id="item_content2" style="width:100%">{{ old('item_content2') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">포장</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content3" id="item_content3" style="width:100%">{{ old('item_content3') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">분리 배출</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content4" id="item_content4" style="width:100%">{{ old('item_content4') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">사회적 가치</div>
                        <div class="col">
                            <p class="t_mint">권장 이미지 사이즈  : 가로 1200px / 세로 : 자유</p>
                            <div class="sm_editor">
                                <textarea type="text" name="item_content5" id="item_content5" style="width:100%">{{ old('item_content5') }}</textarea>
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
                                <input type="text" name="item_price" id="item_price" value="{{ old('item_price') }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 원
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">원가</div>
                        <div class="col">
                            <div class="price">
                                <p>미입력시 상세페이지에서 미표기 됩니다</p>
                                <input type="text" name="item_cust_price" id="item_cust_price" value="{{ old('item_cust_price') }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 원
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">적립금 제공 여부</div>
                        <div class="col">
                            <div class="price">
                                <label>
                                    <input type="radio" name="item_give_point" value="Y" checked>적립금 제공
                                </label>

                                <label>
                                    <input type="radio" name="item_give_point" value="N">적립금 제공 안함
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품품절</div>
                        <div class="col">
                            <p class="t_mint">판매를 중단하거나 재고가 없을 경우 체크하여 품절 표기 하세요</p>
                            <label>
                                <input type="checkbox" name="item_soldout" value="1" id="item_soldout">품절처리
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">재고 수량</div>
                        <div class="col">
                            <div class="price">
                                <input type="text" name="item_stock_qty" value="99999" id="item_stock_qty" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 개
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
                                <li>
                                    <div class="title">
                                        옵션1 명칭 입력
                                    </div>
                                    <input class="wd500" type="text" name="opt1_subject" value="" id="opt1_subject">
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
                                    <input class="wd500" type="text" name="opt2_subject" value="" id="opt2_subject">
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
                            <!-- 옵션목록 끝 -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">추가배송비</div>
                        <div class="col">
                            <div class="price">
                                <input type="text" name="item_sc_price" value="0" id="item_sc_price" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 원
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
                            $('#cate2_tt').css('display', 'inline-block');
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
                            //$('#cate3').css('display', 'block');
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
    $(function() {  //상품 옵션 관련
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

            // 모두선택('현재 DIV 속성 때문에 작동이 잘 안됨 차후 퍼블 작업시 상태 봄')
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
    });
</script>

<script>
    $(function() {  //추가 옵션 관련
        //추가 옵션 입력필드추가
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
            return false;
        }

        if($.trim($("#item_name").val()) == ""){
            alert("상품명을 입력하세요.");
            $("#item_name").focus();
            return false;
        }

        var point = parseInt($("#item_point").val());

        if(point > 99) {
            alert("포인트 비율을 0과 99 사이의 값으로 입력해 주십시오.");
            $("#item_point").focus();
            return false;
        }

        if( item_content == ""  || item_content == null || item_content == '&nbsp;' || item_content == '<p>&nbsp;</p>')  {
             alert("내용을 입력하세요.");
             oEditors.getById["item_content"].exec("FOCUS"); //포커싱
             return;
        }try {
            elClickedObj.form.submit();
        } catch(e) {}

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


<script>

</script>


@endsection
